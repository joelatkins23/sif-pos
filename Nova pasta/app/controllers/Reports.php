<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller
{

    function __construct() {
        parent::__construct();


        if ( ! $this->loggedIn) {
            redirect('login');
        }

        if ( ! $this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }

        $this->load->model('reports_model');
        $this->load->helper("database_helper");
    }

    function daily_sales($year = NULL, $month = NULL)
    {
        if (!$year) { $year = date('Y'); }
        if (!$month) { $month = date('m'); }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->lang->load('calendar');
        $config = array(
            'show_next_prev' => TRUE,
            'next_prev_url' => site_url('reports/daily_sales'),
            'month_type' => 'long',
            'day_type' => 'long'
            );
        $config['template'] = '

        {table_open}<table border="0" cellpadding="0" cellspacing="0" class="table table-bordered" style="min-width:522px;">{/table_open}

        {heading_row_start}<tr class="active">{/heading_row_start}

        {heading_previous_cell}<th><div class="text-center"><a href="{previous_url}">&lt;&lt;</div></a></th>{/heading_previous_cell}
        {heading_title_cell}<th colspan="{colspan}"><div class="text-center">{heading}</div></th>{/heading_title_cell}
        {heading_next_cell}<th><div class="text-center"><a href="{next_url}">&gt;&gt;</a></div></th>{/heading_next_cell}

        {heading_row_end}</tr>{/heading_row_end}

        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<td class="cl_equal"><div class="cl_wday">{week_day}</div></td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}

        {cal_row_start}<tr>{/cal_row_start}
        {cal_cell_start}<td>{/cal_cell_start}

        {cal_cell_content}<div class="cl_left">{day}</div><div class="cl_right">{content}</div>{/cal_cell_content}
        {cal_cell_content_today}<div class="cl_left highlight">{day}</div><div class="cl_right">{content}</div>{/cal_cell_content_today}

        {cal_cell_no_content}{day}{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

        {cal_cell_blank}&nbsp;{/cal_cell_blank}

        {cal_cell_end}</td>{/cal_cell_end}
        {cal_row_end}</tr>{/cal_row_end}

        {table_close}</table>{/table_close}
        ';

        $this->load->library('calendar', $config);

        $sales = $this->reports_model->getDailySales($year, $month);

        if(!empty($sales)) {
            foreach($sales as $sale){
                $daily_sale[$sale->date] = "<span class='text-warning'>". $sale->tax."</span><br>".$sale->discount."<br><span class='text-success'>".$sale->total."</span><br><span style='border-top:1px solid #DDD;'>".$sale->grand_total."</span>";
            }
        } else {
            $daily_sale = array();
        }

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['calender'] = $this->calendar->generate($year, $month, $daily_sale);

        $start = $year.'-'.$month.'-01 00:00:00';
        $end = $year.'-'.$month.'-'.days_in_month($month, $year).' 23:59:59';
        $this->data['total_purchases'] = $this->reports_model->getTotalPurchases($start, $end);
        $this->data['total_sales'] = $this->reports_model->getTotalSales($start, $end);
        $this->data['total_expenses'] = $this->reports_model->getTotalExpenses($start, $end);

        $this->data['page_title'] = $this->lang->line("daily_sales");
        $bc = array(array('link' => '#', 'page' => lang('reports')), array('link' => '#', 'page' => lang('daily_sales')));
        $meta = array('page_title' => lang('daily_sales'), 'bc' => $bc);
        $this->page_construct('reports/daily', $this->data, $meta);

    }


    function monthly_sales($year = NULL)
    {
        if(!$year) { $year = date('Y'); }
        $this->lang->load('calendar');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $start = $year.'-01-01 00:00:00';
        $end = $year.'-12-31 23:59:59';
        $this->data['total_purchases'] = $this->reports_model->getTotalPurchases($start, $end);
        $this->data['total_sales'] = $this->reports_model->getTotalSales($start, $end);
        $this->data['total_expenses'] = $this->reports_model->getTotalExpenses($start, $end);
        $this->data['year'] = $year;
        $this->data['sales'] = $this->reports_model->getMonthlySales($year);
        $this->data['page_title'] = $this->lang->line("monthly_sales");
        $bc = array(array('link' => '#', 'page' => lang('reports')), array('link' => '#', 'page' => lang('monthly_sales')));
        $meta = array('page_title' => lang('monthly_sales'), 'bc' => $bc);
        $this->page_construct('reports/monthly', $this->data, $meta);
    }

    function index()
    {

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

        if($this->input->post('customer')) {
            $start_date = $this->input->post('start_date') ? $this->input->post('start_date') : NULL;
            $end_date = $this->input->post('end_date') ? $this->input->post('end_date') : NULL;
            $user = $this->input->post('user') ? $this->input->post('user') : NULL;
            $this->data['total_sales'] = $this->reports_model->getTotalSalesforCustomer($this->input->post('customer'), $user, $start_date, $end_date);
            $this->data['total_sales_value'] = $this->reports_model->getTotalSalesValueforCustomer($this->input->post('customer'), $user, $start_date, $end_date);
        }
        
        $this->data['customers'] = $this->reports_model->getAllCustomers();
        $this->data['users'] = $this->reports_model->getAllStaff();
        $this->data['page_title'] = $this->lang->line("sales_report");
        $bc = array(array('link' => '#', 'page' => lang('reports')), array('link' => '#', 'page' => lang('sales_report')));
        $meta = array('page_title' => lang('sales_report'), 'bc' => $bc);
        $this->page_construct('reports/sales', $this->data, $meta);
    }

     function invoices()
    {

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

        if($this->input->post()) {

            $start_date = $this->input->post('start_date') ? $this->input->post('start_date') : NULL;
            $end_date = $this->input->post('end_date') ? $this->input->post('end_date') : NULL;
            $user = $this->input->post('user') ? $this->input->post('user') : NULL;
            $this->data['total_sales'] = $this->reports_model->getTotalSalesforCustomer($this->input->post('customer'), $user, $start_date, $end_date);
            $this->data['total_sales_value'] = $this->reports_model->getTotalSalesValueforCustomer($this->input->post('customer'), $user, $start_date, $end_date);
        }
        
        $this->data['customers'] = $this->reports_model->getAllCustomers();
        $this->data['users'] = $this->reports_model->getAllStaff();
        $this->data['products'] = $this->reports_model->getAllProducts();
        $this->data['page_title'] = $this->lang->line("invoice_report");
        $bc = array(array('link' => '#', 'page' => lang('invoice_report')), array('link' => '#', 'page' => lang('invoice_report')));
        $meta = array('page_title' => lang('invoice_report'), 'bc' => $bc);
        $this->page_construct('reports/invoice_reports', $this->data, $meta);
    }


    function print_report(){
        $where = array();
        $where_in =  array();
        $user = $this->input->post('user') ? $this->input->post('user') : NULL;
        $start_date = $this->input->post('start_date') ? $this->input->post('start_date') : NULL;
        $end_date = $this->input->post('end_date') ? $this->input->post('end_date') : NULL;
        // if($start_date!=NULL) array_push($where, array("date>="=>$start_date));
        // if($end_date!=NULL) array_push($where, array("date<="=>$end_date));
        if($start_date!=NULL) $where["date>="] = $start_date;
        if($end_date!=NULL) $where["date<="] = $end_date;
        if($user!=NULL) $where_in['created_by'] = $user;

        $sales = get_rows("sales",$where," created_by ASC, date DESC",array(), "",   $where_in);
        $this->load->view($this->theme . 'reports/print_sales', array("sale_data"=>$sales,"start_date"=>$start_date,"end_date"=>$end_date));
    }

    function print_sale(){
        $where = array();
        $where_in =  array();
        $user = $this->input->post('user') ? $this->input->post('user') : NULL;
        $start_date = $this->input->post('start_date') ? $this->input->post('start_date') : NULL;
        $end_date = $this->input->post('end_date') ? $this->input->post('end_date') : NULL;
        if($start_date!=NULL) $where["date>="] = $start_date;
        if($end_date!=NULL) $where["date<="] = $end_date;
        if($user!=NULL) $where_in['created_by'] = $user;

        $sales = get_rows("sales",$where," created_by ASC, date DESC",array(), "",   $where_in);
        $this->load->view($this->theme . 'reports/print_sale_report', array("sale_data"=>$sales,"start_date"=>$start_date,"end_date"=>$end_date,"assets"=>$this->data["assets"]));

    }


    function print_payments(){
        $user = $this->input->get('user') ? $this->input->get('user') : NULL;
        $ref = $this->input->get('payment_ref') ? $this->input->get('payment_ref') : NULL;
        $sale_id = $this->input->get('sale_no') ? $this->input->get('sale_no') : NULL;
        $customer = $this->input->get('customer') ? $this->input->get('customer') : NULL;
        $paid_by = $this->input->get('paid_by') ? $this->input->get('paid_by') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;

        // $this->datatables
        // ->select($this->db->dbprefix('payments') . ".date, " . $this->db->dbprefix('payments') . ".reference as ref, " . $this->db->dbprefix('sales') . ".id as sale_no, paid_by, amount")
        // ->from('payments')
        // ->join('sales', 'payments.sale_id=sales.id', 'left')
        // ->group_by('payments.id');
        $where_in = array();

        $where = array();
        if ($user) {
            $where['tec_payments.created_by'] = $user;
        }
        if ($ref) {
            $where['tec_payments.reference'] = $ref;

        }
        if ($paid_by) {
            $where['tec_payments.paid_by'] = $paid_by;
        }
        if ($sale_id) {
            $where['tec_sales.id'] = $sale_id;

        }
        if ($customer) {
            $where['tec_sales.customer_id'] = $customer;

        }
        // $this->db->dbprefix('payments') . ".date, " . $this->db->dbprefix('payments') . ".reference as ref, " . $this->db->dbprefix('sales') . ".id as sale_no, paid_by, amount"

        if($start_date!=NULL) $where["tec_payments.date>="] = $start_date;
        if($end_date!=NULL) $where["tec_payments.date<="] = $end_date;
        $payments = get_rows_join("tec_payments",$where," tec_payments.created_by ASC, tec_payments.date DESC",array(), "tec_payments.*, tec_sales.id as sale_id",   $where_in,array(array("table"=>"tec_sales","where"=>"tec_payments.sale_id=tec_sales.id")));
        $this->load->view($this->theme . 'reports/print_payments', array("payments"=>$payments,"start_date"=>$start_date,"end_date"=>$end_date));
    }
    function print_invoices(){
        $where = array();
        $where_in =  array();
        $user = $this->input->post('user') ? $this->input->post('user') : NULL;
        $start_date = $this->input->post('start_date') ? $this->input->post('start_date') : NULL;
        $end_date = $this->input->post('end_date') ? $this->input->post('end_date') : NULL;
        $products = $this->input->post('products') ? $this->input->post('products') : NULL;
        $invoice_type = $this->input->post('invoice_type') ? $this->input->post('invoice_type') : NULL;

        if($start_date!=NULL) $where["tec_sales.date>="] = $start_date;
        if($end_date!=NULL) $where["tec_sales.date<="] = $end_date;
        if($user!=NULL) $where_in['tec_sales.created_by'] = $user;
        if($invoice_type!=NULL) $where['tec_sales.InvoiceType'] = $invoice_type;
        $where['tec_sales.InvoiceStatus!='] = "A";
        $sales = get_rows("tec_sales",$where," created_by ASC, tec_sales.date DESC",array(), "",   $where_in);
        if($products != NULL){
            $where_in['tec_sale_items.product_id'] = $products;
            
            $sales = get_rows_join("tec_sales",$where," created_by ASC, tec_sales.date DESC",array(), "tec_sales.*",   $where_in,array(array("table"=>"tec_sale_items","where"=>"tec_sale_items.sale_id=tec_sales.id")));

        }

        $this->load->view($this->theme . 'reports/print_invoices', array("sale_data"=>$sales,"start_date"=>$start_date,"end_date"=>$end_date));
    }

   
    function print_report1(){

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        if($this->input->post('customer')) {
            $start_date = $this->input->post('start_date') ? $this->input->post('start_date') : NULL;
            $end_date = $this->input->post('end_date') ? $this->input->post('end_date') : NULL;
            $user = $this->input->post('user') ? $this->input->post('user') : NULL;
            $sales = $this->reports_model->getRowSalesforCustomer($this->input->post('customer'), $user, $start_date, $end_date);
           
        } else{
            $sales = $this->reports_model->getRowSales($this->input->post('customer'), $user, $start_date, $end_date);
        }
        $sale_data = $sales;
        $this->load->view($this->theme . 'reports/print_sales', array("sale_data"=>$sale_data));
    }

    function get_sales()
    {
        $customer = $this->input->get('customer') ? $this->input->get('customer') : NULL;
        //$paid_by = $this->input->get('paid_by') ? $this->input->get('paid_by') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;
        $user = $this->input->get('user') ? $this->input->get('user') : NULL;
		$invoice_type = 'FR';

        $this->load->library('datatables');
        $this->datatables
        ->select("id, date, customer_name, total, total_tax, total_discount, grand_total, paid, (grand_total-paid) as balance")
        ->from('sales')
        ->unset_column('id');
        $this->datatables->where("InvoiceStatus!=","A");
        if($customer) { $this->datatables->where('customer_id', $customer); }
        if($user) { $this->datatables->where_in('created_by', explode(",", $user)); }
        if($start_date) { $this->datatables->where('date >=', $start_date); }
        if($end_date) { $this->datatables->where('date <=', $end_date); }
		 if($invoice_type) { $this->datatables->where('tec_sales.InvoiceType', $invoice_type); }

        echo $this->datatables->generate();

    }

    function get_invoices()
    {
        $customer = $this->input->get('customer') ? $this->input->get('customer') : NULL;
        //$paid_by = $this->input->get('paid_by') ? $this->input->get('paid_by') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;
        $user = $this->input->get('user') ? $this->input->get('user') : NULL;
        $products = $this->input->get('products') ? $this->input->get('products') : NULL;
        $invoice_type = $this->input->get('invoice_type') ? $this->input->get('invoice_type') : NULL;

        $this->load->library('datatables');
        $this->datatables
        ->select("tec_sales.id, tec_sales.date, tec_sales.customer_name, tec_sales.InvoiceNo, tec_sales.total, tec_sales.total_tax, tec_sales.total_discount, tec_sales.grand_total, tec_sales.paid, (tec_sales.grand_total-tec_sales.paid) as balance")
        ->from('sales');
        $this->datatables->where("tec_sales.InvoiceStatus!=","A");

        if($customer) { $this->datatables->where('tec_sales.customer_id', $customer); }
        if($user) { $this->datatables->where_in('tec_sales.created_by', explode(",", $user)); }
        if($start_date) { $this->datatables->where('tec_sales.date >=', $start_date); }
        if($end_date) { $this->datatables->where('tec_sales.date <=', $end_date); }
        if($invoice_type) { $this->datatables->where('tec_sales.InvoiceType', $invoice_type); }

        if($products){
            // $this->datatables->join_where_in('tec_sale_items',"tec_sale_items.sale_id = tec_sales.id", "tec_sale_items.product_id",$products);
            $this->datatables->join("tec_sale_items","tec_sale_items.sale_id=tec_sales.id");
            $this->datatables->where_in('tec_sale_items.product_id', explode(",", $products)); 

        }
        $this->datatables->add_column("Actions", "<div class='text-center'><div class='btn-group'><a href='#' onClick=\"MyWindow=window.open('" . site_url('pos/printInvoice/$1') . "',target='_blank'); return false;\" title='".lang("print_invoice")."' class='tip btn btn-success btn-xs print$1'><i class='fa fa-print'></i></a> </div></div>","tec_sales.id");

        $this->datatables->unset_column('tec_sales.id');

        echo $this->datatables->generate();

    }

    function products()
    {

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

        $this->data['products'] = $this->reports_model->getAllProducts();
        $this->data['page_title'] = $this->lang->line("products_report");
        $this->data['page_title'] = $this->lang->line("products_report");
        $bc = array(array('link' => '#', 'page' => lang('reports')), array('link' => '#', 'page' => lang('products_report')));
        $meta = array('page_title' => lang('products_report'), 'bc' => $bc);
        $this->page_construct('reports/products', $this->data, $meta);
    }

    function get_products()
    {
        $product = $this->input->get('product') ? $this->input->get('product') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;
//COALESCE(sum(".$this->db->dbprefix('sale_items').".quantity)*".$this->db->dbprefix('products').".cost, 0) as cost,
        $this->load->library('datatables');
        $this->datatables
        ->select($this->db->dbprefix('products').".name, ".$this->db->dbprefix('products').".code, COALESCE(sum(".$this->db->dbprefix('sale_items').".quantity), 0) as sold, ROUND(COALESCE(((sum(".$this->db->dbprefix('sale_items').".subtotal)*".$this->db->dbprefix('products').".tax)/100), 0), 2) as tax, COALESCE(sum(".$this->db->dbprefix('sale_items').".quantity)*".$this->db->dbprefix('sale_items').".cost, 0) as cost, COALESCE(sum(".$this->db->dbprefix('sale_items').".subtotal), 0) as income,
            ROUND((COALESCE(sum(".$this->db->dbprefix('sale_items').".subtotal), 0)) - COALESCE(sum(".$this->db->dbprefix('sale_items').".quantity)*".$this->db->dbprefix('sale_items').".cost, 0) -COALESCE(((sum(".$this->db->dbprefix('sale_items').".subtotal)*".$this->db->dbprefix('products').".tax)/100), 0), 2)
            as profit", FALSE)
        ->from('sale_items')
        ->join('products', 'sale_items.product_id=products.id', 'left' )
        ->join('sales', 'sale_items.sale_id=sales.id', 'left' )
        ->group_by('products.id');

        if($product) { $this->datatables->where('products.id', $product); }
        if($start_date) { $this->datatables->where('date >=', $start_date); }
        if($end_date) { $this->datatables->where('date <=', $end_date); }

        echo $this->datatables->generate();

    }

    function profit( $income, $cost, $tax)
    {
        return floatval($income)." - ".floatval($cost)." - ".floatval($tax);
    }

    function top_products()
    {

        $this->data['topProducts'] = $this->reports_model->topProducts();
        $this->data['topProducts1'] = $this->reports_model->topProducts1();
        $this->data['topProducts3'] = $this->reports_model->topProducts3();
        $this->data['topProducts12'] = $this->reports_model->topProducts12();

        $this->data['page_title'] = $this->lang->line("top_products");
        $bc = array(array('link' => '#', 'page' => lang('reports')), array('link' => '#', 'page' => lang('top_products')));
        $meta = array('page_title' => lang('top_products'), 'bc' => $bc);
        $this->page_construct('reports/top', $this->data, $meta);
    }

    function registers()
    {

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['users'] = $this->reports_model->getAllStaff();
        $bc = array(array('link' => '#', 'page' => lang('reports')), array('link' => '#', 'page' => lang('registers_report')));
        $meta = array('page_title' => lang('registers_report'), 'bc' => $bc);
        $this->page_construct('reports/registers', $this->data, $meta);
    }

    function get_register_logs()
    {

        $user = $this->input->get('user') ? $this->input->get('user') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;

        $this->load->library('datatables');
        $this->datatables
        ->select("date, closed_at, CONCAT(" . $this->db->dbprefix('users') . ".first_name, ' ', " . $this->db->dbprefix('users') . ".last_name, '<br>', " . $this->db->dbprefix('users') . ".email) as user, cash_in_hand, CONCAT(total_cc_slips, ' (', total_cc_slips_submitted, ')') as cc_slips, CONCAT(total_cheques, ' (', total_cheques_submitted, ')') as total_cheques, CONCAT(total_cash, ' (', total_cash_submitted, ')') as total_cash, note", FALSE)
        ->from("registers")
        ->join('users', 'users.id=registers.user_id', 'left');

        if ($user) {
            $this->datatables->where('registers.user_id', $user);
        }
        if ($start_date) {
            $this->datatables->where('date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
        }

        echo $this->datatables->generate();


    }

    function payments()
    {
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['users'] = $this->reports_model->getAllStaff();
        $this->data['customers'] = $this->reports_model->getAllCustomers();
        $bc = array(array('link' => '#', 'page' => lang('reports')), array('link' => '#', 'page' => lang('payments_report')));
        $meta = array('page_title' => lang('payments_report'), 'bc' => $bc);
        $this->page_construct('reports/payments', $this->data, $meta);
    }

    function get_payments()
    {
        $user = $this->input->get('user') ? $this->input->get('user') : NULL;
        $ref = $this->input->get('payment_ref') ? $this->input->get('payment_ref') : NULL;
        $sale_id = $this->input->get('sale_no') ? $this->input->get('sale_no') : NULL;
        $customer = $this->input->get('customer') ? $this->input->get('customer') : NULL;
        $paid_by = $this->input->get('paid_by') ? $this->input->get('paid_by') : NULL;
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;

        $this->load->library('datatables');
        $this->datatables
        ->select($this->db->dbprefix('payments') . ".date, " . $this->db->dbprefix('sales') . ".customer_name ref, "  .$this->db->dbprefix('sales') . ".id as sale_no,"  .$this->db->dbprefix('payments') . ".InvoiceNo, paid_by, amount, grand_total")
        ->from('payments')
        ->join('sales', 'payments.sale_id=sales.id', 'left')
        ->group_by('payments.id');

        if ($user) {
            $this->datatables->where('payments.created_by', $user);
        }
        if ($ref) {
            $this->datatables->where('payments.reference', $ref);
        }
        if ($paid_by) {
            $this->datatables->where('payments.paid_by', $paid_by);
        }
        if ($sale_id) {
            $this->datatables->where('sales.id', $sale_id);
        }
        if ($customer) {
            $this->datatables->where('sales.customer_id', $customer);
        }
        if ($customer) {
            $this->datatables->where('sales.customer_id', $customer);
        }
        if ($start_date) {
            $this->datatables->where($this->db->dbprefix('payments').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
        }

        $this->datatables->add_column("Actions", "<div class='text-center'><a href='#' onClick=\"MyWindow=window.open('" . site_url('sales/printPaymentInvoice/$1') . "',target='_blank'); return false;\" title='".lang("print_payment")."' class='tip btn btn-success btn-xs print$1'><i class='fa fa-print'></i></a></div>","sale_no");

        echo $this->datatables->generate();

    }

    function alerts() {
        $data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['page_title'] = lang('stock_alert');
        $bc = array(array('link' => '#', 'page' => lang('stock_alert')));
        $meta = array('page_title' => lang('stock_alert'), 'bc' => $bc);
        $this->page_construct('reports/alerts', $this->data, $meta);

    }

    function get_alerts() {

        $this->load->library('datatables');
        $this->datatables->select($this->db->dbprefix('products').".id as pid, ".$this->db->dbprefix('products').".image as image, ".$this->db->dbprefix('products').".code as code, ".$this->db->dbprefix('products').".name as pname, type, ".$this->db->dbprefix('categories').".name as cname, quantity, alert_quantity, tax, tax_method, cost, price", FALSE)
        ->join('categories', 'categories.id=products.category_id')
        ->from('products')
        ->where('quantity < alert_quantity', NULL, FALSE)
        ->group_by('products.id');
        $this->datatables->add_column("Actions", "<div class='text-center'><a href='#' class='btn btn-xs btn-primary ap tip' data-id='$1' title='".lang('add_to_purcahse_order')."'><i class='fa fa-plus'></i></a></div>", "pid");
        $this->datatables->unset_column('pid');
        echo $this->datatables->generate();

    }

}
