<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales extends MY_Controller {

	function __construct()
	{
		parent::__construct();

		if (!$this->loggedIn) {
			redirect('login');
		}
		$this->load->library('form_validation');
		$this->load->model('sales_model');

		$this->digital_file_types = 'zip|pdf|doc|docx|xls|xlsx|jpg|png|gif';
        $this->load->helper("database_helper");
	}

	function index()
	{
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
		$this->data['page_title'] = lang('sales');
		$bc = array(array('link' => '#', 'page' => lang('sales')));
		$meta = array('page_title' => lang('sales'), 'bc' => $bc);
		$this->page_construct('sales/index', $this->data, $meta);
	}

    function invoice_lists()
    {
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['page_title'] = lang('invoice_lists');
        $bc = array(array('link' => '#', 'page' => lang('invoice_lists')));
        $meta = array('page_title' => lang('invoice_lists'), 'bc' => $bc);
        $this->page_construct('sales/invoice_lists', $this->data, $meta);
    }

    function pro_forma()
    {
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['page_title'] = lang('invoice_lists');
        $bc = array(array('link' => '#', 'page' => lang('invoice_lists')));
        $meta = array('page_title' => lang('invoice_lists'), 'bc' => $bc);
        $this->page_construct('sales/pro_forma', $this->data, $meta);
    }

    function convert_invoice($id){
        $sale_info = get_row("tec_sales",array("id"=>$id));

        $invoice_number_info = get_row("tec_numbering",array("InvoiceYear"=>date("Y"), "InvoiceType"=>"FT"), "number DESC");
        if(empty($invoice_number_info['number']))
            $invoice_number = 1;
        else 
            $invoice_number = $invoice_number_info['number'] + 1;
        $date = $sale_info['date'];
        $hash_str = date("Y-m-d",strtotime($date)).";".date("Y-m-d",strtotime($date))."T".date("H:i:s",strtotime($date)).";".$this->input->post("invoice_type")." SIF".date("Y")."/".$invoice_number.";".str_replace(",","",number_format($sale_info['grand_total'],2)).";";
        // $hash_str =  base64_encode(hash("SHA1", $hash_str));

        $sign_key = get_row("tec_signkey",array("id"=>1));
        $privateKey=$sign_key['private'];
        $publickey=$sign_key['public'];
        
        openssl_public_encrypt($hash_str, $crypttext, $publickey);
        $hash_str = base64_encode($crypttext);
        $data = array(
            'Hash' => $hash_str,
            'InvoiceType' => "FT",
            'InvoiceNo' => "FT SIF".date("Y")."/".$invoice_number,
        );
        update_row("tec_sales",$data,array("id"=>$id));
        create_row("tec_numbering",array("number"=>$invoice_number,"InvoiceType"=>"FT", "InvoiceYear"=>date("Y")));

        redirect("sales/invoice_lists");

    }

    function edit_invoice($eid = NULL){
        $this->load->library('form_validation');
        $this->load->model('pos_model');
        $this->load->helper('database_helper');

        if (isset($eid) && !empty($eid)) {
            $sale = $this->pos_model->getSaleByID($eid);
            $inv_items = $this->pos_model->getAllSaleItems($eid);
            krsort($inv_items);
            $c = rand(100000, 9999999);
            foreach ($inv_items as $item) {
                $row = $this->site->getProductByID($item->product_id);
                if (!$row) {
                    $row = json_decode('{}');
                }
                $row->price = $item->net_unit_price;
                $row->unit_price = $item->unit_price;
                $row->real_unit_price = $item->real_unit_price;
                $row->discount = $item->discount;
                $row->qty = $item->quantity;
                $combo_items = FALSE;
                $row->quantity += $item->quantity;
                if ($row->type == 'combo') {
                    $combo_items = $this->pos_model->getComboItemsByPID($row->id);
                    foreach ($combo_items as $combo_item) {
                        $combo_item->quantity += ($combo_item->qty * $item->quantity);
                    }
                }
                $ri = $this->Settings->item_addition ? $row->id : $c;
                $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items);
                $c++;
            }
            $this->data['items'] = json_encode($pr);
            $this->data['eid'] = $eid;
            $this->data['sale'] = $sale;
            $this->data['message'] = lang('sale_loaded');
        }

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['eid'] = isset($eid) ? $eid : 0;
        $this->data['customers'] = $this->site->getAllCustomers();

        $this->data["tcp"] = $this->pos_model->products_count($this->Settings->default_category);

        // $this->data['products'] = $this->ajaxproducts($this->Settings->default_category, 1);
        $this->data['categories'] = $this->site->getAllCategories();
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['suspended_sales'] = $this->site->getUserSuspenedSales();
        $this->data['page_title'] = lang('pos');
        $bc = array(array('link' => '#', 'page' => lang('pos')));
        $meta = array('page_title' => lang('pos'), 'bc' => $bc);
        $this->page_construct('sales/edit_invoice', $this->data, $meta);

    }

    function update_invoice(){
        $this->load->model("pos_model");
        $eid = $this->input->post("eid");
        $quantity = "quantity";
        $product = "product";
        $unit_cost = "unit_cost";
        $tax_rate = "tax_rate";

        $date = date('Y-m-d H:i:s');
        $customer_id = $this->input->post('customer_id');
        $customer_details = $this->pos_model->getCustomerByID($customer_id);
        $customer = $customer_details->name;
        $note = $this->tec->clear_tags($this->input->post('spos_note'));

        $total = 0;
        $product_tax = 0;
        $order_tax = 0;
        $product_discount = 0;
        $order_discount = 0;
        $percentage = '%';
        $i = isset($_POST['product_id']) ? sizeof($_POST['product_id']) : 0;
        for ($r = 0; $r < $i; $r++) {
            $item_id = $_POST['product_id'][$r];
            $real_unit_price = $this->tec->formatDecimal($_POST['real_unit_price'][$r]);
            $item_quantity = $_POST['quantity'][$r];
            $item_discount = isset($_POST['product_discount'][$r]) ? $_POST['product_discount'][$r] : '0';

            if (isset($item_id) && isset($real_unit_price) && isset($item_quantity)) {
                $product_details = $this->site->getProductByID($item_id);
                $unit_price = $real_unit_price;

                $pr_discount = 0;
                if (isset($item_discount)) {
                    $discount = $item_discount;
                    $dpos = strpos($discount, $percentage);
                    if ($dpos !== false) {
                        $pds = explode("%", $discount);
                        $pr_discount = (($this->tec->formatDecimal($unit_price)) * (Float) ($pds[0])) / 100;
                    } else {
                        $pr_discount = $this->tec->formatDecimal($discount);
                    }
                }
                $unit_price = $this->tec->formatDecimal($unit_price - $pr_discount);
                $item_net_price = $unit_price;
                $pr_item_discount = $this->tec->formatDecimal($pr_discount * $item_quantity);
                $product_discount += $pr_item_discount;

                $pr_item_tax = 0;
                $item_tax = 0;
                $tax = 0;
                if (isset($product_details->tax) && $product_details->tax != 0) {

                    if ($product_details && $product_details->tax_method == 1) {
                        $item_tax = $this->tec->formatDecimal((($unit_price) * $product_details->tax) / 100);
                        $tax = $product_details->tax . "%";
                    } else {
                        $item_tax = $this->tec->formatDecimal((($unit_price) * $product_details->tax) / (100 + $product_details->tax));
                        $tax = $product_details->tax . "%";
                        $item_net_price -= $item_tax;
                    }

                    $pr_item_tax = $this->tec->formatDecimal($item_tax * $item_quantity);
                }

                $product_tax += $pr_item_tax;
                $subtotal = (($item_net_price * $item_quantity) + $pr_item_tax);

                $products[] = array(
                    'product_id' => $item_id,
                    'quantity' => $item_quantity,
                    'unit_price' => $unit_price,
                    'net_unit_price' => $item_net_price,
                    'discount' => $item_discount,
                    'item_discount' => $pr_item_discount,
                    'tax' => str_replace("%", "", $tax),
                    'item_tax' => $pr_item_tax,
                    'subtotal' => $subtotal,
                    'real_unit_price' => $real_unit_price,
                    'cost' => $product_details->cost,
                    'tax_id'=>$product_details->tax_id
                );

                $total += $item_net_price * $item_quantity;
            }
        }

       

        if ($this->input->post('order_discount')) {
            $order_discount_id = $this->input->post('order_discount');
            $opos = strpos($order_discount_id, $percentage);
            if ($opos !== false) {
                $ods = explode("%", $order_discount_id);
                $order_discount = $this->tec->formatDecimal((($total + $product_tax) * (Float) ($ods[0])) / 100);
            } else {
                $order_discount = $this->tec->formatDecimal($order_discount_id);
            }
        } else {
            $order_discount_id = NULL;
        }
        $total_discount = $this->tec->formatDecimal($order_discount + $product_discount);

        if ($this->input->post('order_tax')) {
            $order_tax_id = $this->input->post('order_tax');
            $opos = strpos($order_tax_id, $percentage);
            if ($opos !== false) {
                $ots = explode("%", $order_tax_id);
                $order_tax = $this->tec->formatDecimal((($total + $product_tax - $order_discount) * (Float) ($ots[0])) / 100);
            } else {
                $order_tax = $this->tec->formatDecimal($order_tax_id);
            }
        } else {
            $order_tax_id = NULL;
            $order_tax = 0;
        }

        $total_tax = $this->tec->formatDecimal($product_tax + $order_tax);
        $grand_total = $this->tec->formatDecimal($this->tec->formatDecimal($total) + $total_tax - $order_discount);
        /*   $paid = $this->input->post('amount') ? $this->input->post('amount') : 0;
          if (!$eid) {
          $status = 'due';
          if ($grand_total > $paid && $paid > 0) {
          $status = 'partial';
          } elseif ($grand_total <= $paid) {
          $status = 'paid';
          }
          } */
        $_POST['amount'] = $grand_total;
        $paid = $this->input->post('amount') ? $this->input->post('amount') : 0;
        $status = 'paid';
        if($this->input->post("invoice_type") == "FT") {
            $paid = 0;
            $status = 'no paid';

        }
        $round_total = $this->tec->roundNumber($grand_total, $this->Settings->rounding);
        $rounding = $this->tec->formatMoney($round_total - $grand_total);
        $balance = empty($this->input->post('balance_amount')) ? 0 : $this->tec->formatDecimal($this->input->post('balance_amount'));
         
        $data = array('date' => $date,
            'total' => $this->tec->formatDecimal($total),
            'product_discount' => $this->tec->formatDecimal($product_discount),
            'order_discount_id' => $order_discount_id,
            'order_discount' => $order_discount,
            'total_discount' => $total_discount,
            'total_balance' => $balance,
            'product_tax' => $this->tec->formatDecimal($product_tax),
            'order_tax_id' => $order_tax_id,
            'order_tax' => $order_tax,
            'total_tax' => $total_tax,
            'grand_total' => $grand_total,
            'total_items' => $this->input->post('total_items'),
            'total_quantity' => $this->input->post('total_quantity'),
            'rounding' => $rounding,
            'paid' => $paid,
            'status' => $status,
            'created_by' => $this->session->userdata('user_id'),
            'note' => $note,
            'InvoiceYear' => date("Y"),
            'InvoiceStatusDate'=>date("Y-m-d")."T".date("H:i:s"),
            'SourceBilling' => "P",
            'CashVATSchemeIndicator' => 1,
            'ThirdPartiesBillingIndicator' => 0,
            'SelfBillingIndicator' => 0,
            'Reason' => $this->input->post("Reason")

        );
       
        $sale_info = get_row("tec_sales",array("id"=>$eid));
        unset($data['date'], $data['InvoiceNo']);
        if($sale_info['InvoiceType'] != "FR") unset($data['paid']);
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $this->session->userdata('user_id');

        $amount =  $paid;
        $payment = array(
            'date' => $date,
            'amount' => $amount,
            'pos_paid' => $this->tec->formatDecimal($this->input->post('amount')),
            'pos_balance' => $this->tec->formatDecimal($this->input->post('balance_amount')),
        );
        if($sale_info['InvoiceType'] == "FR"){
            $row = get_row("tec_payments",array("sale_id"=>$eid));
            update_row("tec_payments", $payment, array("sale_id"=>$eid));

        }
        if ($this->pos_model->updateSale($eid, $data, $products)) {
            $this->session->set_userdata('rmspos', 1);
            $this->session->set_flashdata('message', lang("sale_updated"));
            $this->session->set_userdata('reprint', $eid);

            redirect("sales/invoice_lists");
        } else {
            $this->session->set_flashdata('error', lang("action_failed"));
            redirect("pos/?edit=" . $eid);
        }

    }
    function get_pro_forma()
    {

        $this->load->library('datatables');
        $this->datatables->select("id, date, customer_name, InvoiceNo, grand_total, InvoiceStatus");
        $this->datatables->from('sales');
        $this->datatables->where('InvoiceType', "FP");

        if(!$this->Admin) {
            $user_id = $this->session->userdata('user_id');
            $this->datatables->where('created_by', $user_id);
        }
         // $this->datatables->add_column("InvoiceStatus","");
        $this->datatables->add_column("Actions", "<div class='text-center'><div class='btn-group'><a href='#' onClick=\"MyWindow=window.open('" . site_url('pos/printInvoice/$1') . "',target='_blank'); return false;\" title='".lang("print_invoice")."' class='tip btn btn-success btn-xs print$1'><i class='fa fa-print'></i></a> <a href='#' onClick=\"MyWindow=window.open('" . site_url('pos/view/$1/1') . "', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=yes,scrollbars=yes,resizable=yes,width=350,height=600'); return false;\" title='".lang("view_invoice")."' class='tip btn btn-primary btn-xs'><i class='fa fa-list'></i></a> <a href='".site_url('sales/convert_invoice/$1')."' title='" . lang("convert invoice") . "' class='tip btn btn-primary btn-xs' ><i class='fa fa-exchange'></i></a> <a href='" . site_url('sales/edit_invoice/$1') . "' title='".lang("edit_invoice")."' class='tip btn btn-warning btn-xs'><i class='fa fa-edit'></i></a> <a href='" . site_url('sales/delete/$1') . "' onClick=\"return confirm('". lang('alert_x_sale') ."')\" title='".lang("delete_sale")."' class='tip btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></div></div>","id");

        $this->datatables->unset_column('id');
        echo $this->datatables->generate();

    }

    function get_invoices()
    {

        $this->load->library('datatables');
        $this->datatables->select("id, date, customer_name, InvoiceNo,  status,  tec_sales.grand_total, tec_sales.paid, (tec_sales.grand_total-tec_sales.paid) as balance,  InvoiceStatus ");
        $this->datatables->from('sales');
        $this->datatables->where('InvoiceType', "FT");

        if(!$this->Admin) {
            $user_id = $this->session->userdata('user_id');
            $this->datatables->where('created_by', $user_id);
        }
         // $this->datatables->add_column("paid","paid");
        $this->datatables->add_column("Actions", "<div class='text-center'><div class='btn-group'><a href='#' onClick=\"MyWindow=window.open('" . site_url('pos/printInvoice/$1') . "',target='_blank'); return false;\" title='".lang("print_invoice")."' class='tip btn btn-success btn-xs print$1'><i class='fa fa-print'></i></a> <a href='#' onClick=\"MyWindow=window.open('" . site_url('pos/view/$1/1') . "', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=yes,scrollbars=yes,resizable=yes,width=350,height=600'); return false;\" title='".lang("view_invoice")."' class='tip btn btn-primary btn-xs'><i class='fa fa-list'></i></a> <a  onClick=\"MyWindow=window.open('" . site_url('pos/guia_transporte/$1') . "',target='_blank'); \"' title='" . lang("Guia de Transporte") . "' class='tip btn btn-primary btn-xs' data-toggle='ajax'><i class='fa fa-car'></i></a> <a href='".site_url('sales/payments/$1')."' title='" . lang("view_payments") . "' class='tip btn btn-primary btn-xs' data-toggle='ajax'><i class='fa fa-money'></i></a> <a href='".site_url('sales/add_payment/$1')."' title='" . lang("add_payment") . "' class='add_payment_btn tip btn btn-primary btn-xs' data-toggle='ajax'><i class='fa fa-briefcase'></i></a> <a href='" . site_url('sales/edit_invoice/$1') . "' title='".lang("edit_invoice")."' class='edit_invoice_btn tip btn btn-warning btn-xs'><i class='fa fa-edit'></i></a> <a href='" . site_url('sales/delete/$1') . "' data-title='". lang('alert_x_sale') ."'  title='".lang("delete_sale")."' class='delete_invoice tip btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></div></div>","id");

        $this->datatables->unset_column('id');
        echo $this->datatables->generate();

    }


	function get_sales()
	{

		$this->load->library('datatables');
        $this->datatables->select("id, date, customer_name,  InvoiceNo, total_discount, grand_total, paid,  InvoiceStatus ");
        $this->datatables->from('sales');
        $this->datatables->where('InvoiceType',  "FR", "VD");
		
        if(!$this->Admin) {
            $user_id = $this->session->userdata('user_id');
            $this->datatables->where('created_by', $user_id);
        }
         // $this->datatables->add_column("InvoiceStatus","");

        $this->datatables->add_column("Actions", "<div class='text-center'><div class='btn-group'><a href='#' onClick=\"MyWindow=window.open('" . site_url('pos/printInvoice/$1') . "',target='_blank'); return false;\" title='".lang("print_invoice")."' class='tip btn btn-success btn-xs'><i class='fa fa-print'></i></a> <a href='#' onClick=\"MyWindow=window.open('" . site_url('pos/view/$1/1') . "', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=yes,scrollbars=yes,resizable=yes,width=350,height=600'); return false;\" title='".lang("view_invoice")."' class='tip btn btn-primary btn-xs'><i class='fa fa-list'></i></a> <a  onClick=\"MyWindow=window.open('" . site_url('pos/guia_transporte/$1') . "',target='_blank'); \"' title='" . lang("Guia de Transporte") . "' class='tip btn btn-primary btn-xs' data-toggle='ajax'><i class='fa fa-car'></i></a> <a href='".site_url('sales/add_payment/$1')."' title='" . lang("add_payment") . "' class='tip btn btn-primary btn-xs' data-toggle='ajax'><i class='fa fa-briefcase'></i></a> <a href='" . site_url('sales/edit_invoice/$1') . "' title='".lang("edit_invoice")."' class='tip btn btn-warning btn-xs'><i class='fa fa-edit'></i></a><a href='" . site_url('sales/delete/$1') . "' onClick=\"return confirm('". lang('alert_x_sale') ."')\" title='".lang("delete_sale")."' class='tip btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></div></div>","id");
        // $this->datatables->add_column("Actions", "<div class='text-center'><div class='btn-group'><a href='#' onClick=\"MyWindow=window.open('" . site_url('pos/guia/$1') . "',target='_blank'); return false;\" title='".lang("print_invoice")."' class='tip btn btn-success btn-xs'><i class='fa fa-print'></i></a> <a href='#' onClick=\"MyWindow=window.open('" . site_url('pos/view/$1/1') . "', 'MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=yes,scrollbars=yes,resizable=yes,width=350,height=600'); return false;\" title='".lang("view_invoice")."' class='tip btn btn-primary btn-xs'><i class='fa fa-list'></i></a> <a href='".site_url('sales/payments/$1')."' title='" . lang("view_payments") . "' class='tip btn btn-primary btn-xs' data-toggle='ajax'><i class='fa fa-money'></i></a> <a href='".site_url('sales/add_payment/$1')."' title='" . lang("add_payment") . "' class='tip btn btn-primary btn-xs' data-toggle='ajax'><i class='fa fa-briefcase'></i></a> <a href='" . site_url('pos/?edit=$1') . "' title='".lang("edit_invoice")."' class='tip btn btn-warning btn-xs'><i class='fa fa-edit'></i></a> <a href='" . site_url('sales/delete/$1') . "' onClick=\"return confirm('". lang('alert_x_sale') ."')\" title='".lang("delete_sale")."' class='tip btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></div></div>","id");

        $this->datatables->unset_column('id');
        echo $this->datatables->generate();

	}

	function opened()
	{
		$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
		$this->data['page_title'] = lang('opened_bills');
		$bc = array(array('link' => '#', 'page' => lang('opened_bills')));
		$meta = array('page_title' => lang('opened_bills'), 'bc' => $bc);
		$this->page_construct('sales/opened', $this->data, $meta);
	}

	
	function get_opened_list()
	{

		$this->load->library('datatables');
		$this->datatables
		->select("id, date, created_by, hold_ref,  CONCAT(total_items, ' (', total_quantity, ')') as items, grand_total", FALSE)
		->from('suspended_sales');
		
		
		
        if(!$this->Staff & Admin)  {
            $user_id = $this->session->userdata('user_id');
            $this->datatables->where('created_by', $user_id);
        }

		$this->datatables->add_column("Actions",
			"<div class='text-center'><div class='btn-group'><a href='" . site_url('pos/?hold=$1') . "' title='".lang("click_to_add")."' class='tip btn btn-info btn-xs'><i class='fa fa-th-large'></i></a>
			<a href='" . site_url('sales/delete_holded/$1') . "' onClick=\"return confirm('". lang('alert_x_holded') ."')\" title='".lang("delete_sale")."' class='tip btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a></div></div>", "id")
		->unset_column('id');

		echo $this->datatables->generate();
		
		
		

	}



	function delete($id = NULL)
	{
		if(DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
        }

		if($this->input->get('id')){ $id = $this->input->get('id'); }

		if (!$this->Admin) {
			$this->session->set_flashdata('error', lang("access_denied"));
			redirect('sales');
		}



		if ( $this->sales_model->deleteInvoice($id) ) {
             $this->session->set_userdata("cancel_payment","yes");
            $this->session->set_userdata("sale_id",$id);
            
			$this->session->set_flashdata('message', lang("invoice_deleted"));
			redirect('sales/invoice_lists');
		}

	}

	function delete_holded($id = NULL)
	{

		if($this->input->get('id')){ $id = $this->input->get('id'); }

		if (!$this->Admin) {
			$this->session->set_flashdata('error', lang("access_denied"));
			redirect('sales/opened');
		}

		if ( $this->sales_model->deleteOpenedSale($id) ) {
			$this->session->set_flashdata('message', lang("opened_bill_deleted"));
			redirect('sales/opened');
		}

	}

	/* -------------------------------------------------------------------------------- */

    function payments($id = NULL)
    {
        $this->data['payments'] = $this->sales_model->getSalePayments($id);
        $this->load->view($this->theme . 'sales/payments', $this->data);
    }

    function payment_note($id = NULL)
    {
        $payment = $this->sales_model->getPaymentByID($id);
        $inv = $this->sales_model->getSaleByID($payment->sale_id);
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['inv'] = $inv;
        $this->data['payment'] = $payment;
        $this->data['page_title'] = $this->lang->line("payment_note");

        $this->load->view($this->theme . 'sales/payment_note', $this->data);
    }

    function add_payment($id = NULL, $cid = NULL)
    {
        $this->load->helper('security');
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        $this->form_validation->set_rules('amount-paid', lang("amount"), 'required');
        $this->form_validation->set_rules('paid_by', lang("paid_by"), 'required');
        $this->form_validation->set_rules('userfile', lang("attachment"), 'xss_clean');
        if ($this->form_validation->run() == true) {
            if ($this->Admin) {
                $date = $this->input->post('date');
            } else {
                $date = date('Y-m-d H:i:s');
            }
            $invoice_number_info = get_row("tec_numbering",array("InvoiceYear"=>date("Y"), "InvoiceType"=>"RC"), "number DESC");
            if(empty($invoice_number_info['number']))
                $invoice_number = 1;
            else 
                $invoice_number = $invoice_number_info['number'] + 1;



            $row = get_row("tec_sales",array("id"=>$id));
            $payment = array(
                'date' => $date,
                'sale_id' => $id,
                'customer_id' => $cid,
                'reference' => $this->input->post('reference'),
                'amount' => $this->input->post('amount-paid'),
                'paid_by' => $this->input->post('paid_by'),
                'cheque_no' => $this->input->post('cheque_no'),
                'gc_no' => $this->input->post('gift_card_no'),
                'cc_no' => $this->input->post('pcc_no'),
                'cc_holder' => $this->input->post('pcc_holder'),
                'cc_month' => $this->input->post('pcc_month'),
                'cc_year' => $this->input->post('pcc_year'),
                'cc_type' => $this->input->post('pcc_type'),
                'note' => $this->input->post('note'),
                'created_by' => $this->session->userdata('user_id'),
                'PaymentStatus' => "N",
                'SourcePayment' => "P",
                'PaymentType' => "RC", 
                'OrderReferences' => $row["InvoiceNo"],

            );
            $payment['InvoiceNo'] =  "RC "." SIF".date("Y")."/".$invoice_number;


            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = 'files/';
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = 2048;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $payment['attachment'] = $photo;
            }

            //$this->sma->print_arrays($payment);

        } elseif ($this->input->post('add_payment')) {
            $this->session->set_flashdata('error', validation_errors());
            $this->tec->dd();
        }


        if ($this->form_validation->run() == true && $this->sales_model->addPayment($payment)) {
            create_row("tec_numbering",array("number"=>$invoice_number,"InvoiceType"=>"RC", "InvoiceYear"=>date("Y")));
            $this->session->set_userdata("add_payment","yes");
            $this->session->set_userdata("sale_id",$id);
            $this->session->set_flashdata('message', lang("payment_added"));
            redirect($_SERVER["HTTP_REFERER"]);
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $sale = $this->sales_model->getSaleByID($id);
            $this->data['inv'] = $sale;

            $this->load->view($this->theme . 'sales/add_payment', $this->data);
        }
    }

    function edit_payment($id = NULL, $sid = NULL)
    {

    	if (!$this->Admin) {
			$this->session->set_flashdata('error', lang("access_denied"));
			redirect($_SERVER["HTTP_REFERER"]);
		}
        $this->load->helper('security');
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        $this->form_validation->set_rules('amount-paid', lang("amount"), 'required');
        $this->form_validation->set_rules('paid_by', lang("paid_by"), 'required');
        $this->form_validation->set_rules('userfile', lang("attachment"), 'xss_clean');
        if ($this->form_validation->run() == true) {
            $payment = array(
                'sale_id' => $sid,
                'reference' => $this->input->post('reference'),
                'amount' => $this->input->post('amount-paid'),
                'paid_by' => $this->input->post('paid_by'),
                'cheque_no' => $this->input->post('cheque_no'),
                'gc_no' => $this->input->post('gift_card_no'),
                'cc_no' => $this->input->post('pcc_no'),
                'cc_holder' => $this->input->post('pcc_holder'),
                'cc_month' => $this->input->post('pcc_month'),
                'cc_year' => $this->input->post('pcc_year'),
                'cc_type' => $this->input->post('pcc_type'),
                'note' => $this->input->post('note'),
                'updated_by' => $this->session->userdata('user_id'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            if ($this->Admin) {
                $payment['date'] = $this->input->post('date');
            }

            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = 'files/';
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = 2048;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $payment['attachment'] = $photo;
            }

            //$this->sma->print_arrays($payment);

        } elseif ($this->input->post('edit_payment')) {
            $this->session->set_flashdata('error', validation_errors());
            $this->tec->dd();
        }


        if ($this->form_validation->run() == true && $this->sales_model->updatePayment($id, $payment)) {
            $this->session->set_flashdata('message', lang("payment_updated"));
            redirect("sales");
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $payment = $this->sales_model->getPaymentByID($id);
            if($payment->paid_by != 'cash') {
            	$this->session->set_flashdata('error', lang('only_cash_can_be_edited'));
            	$this->tec->dd();
            }
            $this->data['payment'] = $payment;
            $this->load->view($this->theme . 'sales/edit_payment', $this->data);
        }
    }

    function delete_payment($id = NULL)
    {   

		if($this->input->get('id')){ $id = $this->input->get('id'); }

		if (!$this->Admin) {
			$this->session->set_flashdata('error', lang("access_denied"));
			redirect($_SERVER["HTTP_REFERER"]);
		}

		if ( $this->sales_model->deletePayment($id) ) {
			$this->session->set_flashdata('message', lang("payment_deleted"));
			redirect('sales');
		}
    }

    function printPaymentInvoice($sale_id = NULL){
        $this->load->model("pos_model");
        // if ($this->input->get('id')) {
        //     $sale_id = $this->input->get('id');
        // }
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['message'] = $this->session->flashdata('message');
        $inv = $this->pos_model->getSaleByID($sale_id);
        $this->tec->view_rights($inv->created_by);
        $this->load->helper('text');
        $this->data['rows'] = $this->pos_model->getAllSaleItems($sale_id);
        $this->data['customer'] = $this->pos_model->getCustomerByID($inv->customer_id);
        $this->data['inv'] = $inv;
        $this->data['sid'] = $sale_id;
        $this->data['noprint'] = $noprint;
        $this->data['modal'] = false;
        $this->data['payments'] = $this->pos_model->getAllSalePayments($sale_id);
        $this->data['created_by'] = $this->site->getUser($inv->created_by);
        $this->data['page_title'] = lang("invoice");
        $redirect_page = (empty($this->session->userdata("redirect_page"))||$this->session->userdata("redirect_page")=="")?"":$this->session->userdata("redirect_page");
        $this->session->set_userdata("invoice_status","");

        $this->load->view($this->theme . 'sales/payment_invoice', $this->data);
    }
    /* --------------------------------------------------------------------------------------------- */


}
