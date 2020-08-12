<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller
{

    function __construct() {
        parent::__construct();

        if (!$this->loggedIn) {
            redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('customers_model');
    }

    function index()
    {

    	$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
    	$this->data['page_title'] = lang('customers');
    	$bc = array(array('link' => '#', 'page' => lang('customers')));
    	$meta = array('page_title' => lang('customers'), 'bc' => $bc);
    	$this->page_construct('customers/index', $this->data, $meta);
    }

    function get_customers()
    {

    	$this->load->library('datatables');
    	$this->datatables
    	->select("id, name, phone,  email, cf1, endereco")
    	->from("customers")
    	->add_column("Actions", "<div class='text-center'><div class='btn-group'><a href='" . site_url('customers/edit/$1') . "' class='edit_customer tip btn btn-warning btn-xs' title='".$this->lang->line("edit_customer")."'><i class='fa fa-edit'></i></a> <a href='" . site_url('customers/delete/$1') . "' onClick=\"return confirm('". $this->lang->line('alert_x_customer') ."')\" class='tip btn btn-danger btn-xs' title='".$this->lang->line("delete_customer")."'><i class='fa fa-trash-o'></i></a></div></div>", "id")
    	->unset_column('id');

    	echo $this->datatables->generate();

    }

	function add()
	{
		$this->load->helper("database_helper");
		$this->form_validation->set_rules('name', $this->lang->line("name"), 'required');
		$this->form_validation->set_rules('cf1', $this->lang->line("cf1"), 'required');
		$this->form_validation->set_rules('estado', $this->lang->line("estado"), 'required');
		$this->form_validation->set_rules('bairro', $this->lang->line("Morada"), 'required');
		$this->form_validation->set_rules('Country', $this->lang->line("País"), 'required');

		if ($this->form_validation->run() == true) {
			// $data = array('name' => $this->input->post('name'),
			// 	'email' => $this->input->post('email'),
			// 	'phone' => $this->input->post('phone'),
			// 	'cf1' => $this->input->post('cf1'),
			// 	'cf2' => $this->input->post('cf2'),
			// 	'endereco' => $this->input->post('endereco'),
			// 	'numero' => $this->input->post('numero'),
			// 	'bairro' => $this->input->post('bairro'),
			// 	'cidade' => $this->input->post('cidade'),
			// 	'estado' => $this->input->post('estado'),
			// 	'AccountID' => $this->input->post('AccountID'),
			// 	'endereco' => $this->input->post('endereco'),
			// 	'cep' =>  $this->input->post('endereco'),
			// ); .

			$data = array('name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'cf1' => $this->input->post('cf1'),
				
				'endereco' => $this->input->post('bairro'),
				'numero' => $this->input->post('numero'),
				'bairro' => $this->input->post('bairro'),
				'cidade' => $this->input->post('cidade'),
				'estado' => $this->input->post('estado'),
				'data' => date("Y-m-d"),
				'AccountID' => $this->input->post('AccountID'),
				'Country' => $this->input->post('Country'),
				'complemento' => $this->input->post('bairro'),
			); 

			// print_r($data);
			// exit;
		}

		if ( $this->form_validation->run() == true && $cid = $this->customers_model->addCustomer($data)) {
            if($this->input->is_ajax_request()) {
                echo json_encode(array('status' => 'success', 'msg' =>  $this->lang->line("customer_added"), 'id' => $cid, 'val' => $data['name']));
                die();
            }
            $this->session->set_flashdata('message', $this->lang->line("customer_added"));
            redirect("customers");

		} else {
            if($this->input->is_ajax_request()) {
                echo json_encode(array('status' => 'failed', 'msg' => validation_errors())); die();
            }

			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
    		$this->data['page_title'] = lang('add_customer');
    		$bc = array(array('link' => site_url('customers'), 'page' => lang('customers')), array('link' => '#', 'page' => lang('add_customer')));
    		$meta = array('page_title' => lang('add_customer'), 'bc' => $bc);
    		$this->page_construct('customers/add', $this->data, $meta);

		}
	}

	function edit($id = NULL)
	{
        if (!$this->Admin) {
            $this->session->set_flashdata('error', $this->lang->line('access_denied'));
            redirect('pos');
        }
		if($this->input->get('id')) { $id = $this->input->get('id', TRUE); }

		$this->form_validation->set_rules('name', $this->lang->line("name"), 'required');
		$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'valid_email');

		if ($this->form_validation->run() == true) {

			$data = array('name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'cf1' => $this->input->post('cf1'),
				'cf2' => $this->input->post('cf2'),
				'endereco' => $this->input->post('endereco'),
				'numero' => $this->input->post('numero'),
				'complemento' => $this->input->post('complemento'),
				'bairro' => $this->input->post('bairro'),
				'cep' => $this->input->post('cep'),				
				'cidade' => $this->input->post('cidade'),
				'estado' => $this->input->post('estado'),
				'obs1' => $this->input->post('obs1')
			);

		}

		if ( $this->form_validation->run() == true && $this->customers_model->updateCustomer($id, $data)) {

			$this->session->set_flashdata('message', $this->lang->line("customer_updated"));
			redirect("customers");

		} else {

			$this->data['customer'] = $this->customers_model->getCustomerByID($id);
			$cf1 = $this->data['customer']->cf1;
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
    		$this->data['page_title'] = lang('edit_customer');
    		$bc = array(array('link' => site_url('customers'), 'page' => lang('customers')), array('link' => '#', 'page' => lang('edit_customer')));
    		$meta = array('page_title' => lang('edit_customer'), 'bc' => $bc);
    		$this->data['edit_nif'] = "yes";
    		$this->load->helper("database_helper");
    		// $rows = get_rows("tec_sales",array("customer_id"=>$id));
    		// if(strpos($cf1, "999999999") === false && strlen($cf1) > 3 && count($rows) == 0)
    		// 	$this->data['edit_nif'] = "no";
    		if(strpos($cf1, "999999999") === false && strlen($cf1) > 3)
    			$this->data['edit_nif'] = "no";

    		$this->page_construct('customers/edit', $this->data, $meta);

		}
	}

	function delete($id = NULL)
	{
		if(DEMO) {
			$this->session->set_flashdata('error', $this->lang->line("disabled_in_demo"));
			redirect('pos');
		}

		if($this->input->get('id')) { $id = $this->input->get('id', TRUE); }

		if (!$this->Admin)
		{
			$this->session->set_flashdata('error', lang("access_denied"));
			redirect('pos');
		}

		if ( $this->customers_model->deleteCustomer($id) )
		{
			$this->session->set_flashdata('message', lang("customer_deleted"));
			redirect("customers");
		}

	}


}
