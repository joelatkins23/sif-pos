<?php
// error_reporting(-1);
        // ini_set('display_errors', 1);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require realpath(__DIR__) . '/../../app/core/Request.php';
require realpath(__DIR__) . '/../../vendor/autoload.php';

class Settings extends MY_Controller {

    function __construct() {
        parent::__construct();

        if (!$this->loggedIn) {
            redirect('login');
        }

        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect('pos');
        }

        $this->load->library('form_validation');
        $this->load->model('settings_model');
        $this->load->helper("database_helper");
    }

    function index() {
        $this->form_validation->set_rules('site_name', lang('site_name'), 'required');
        $this->form_validation->set_rules('tel', lang('tel'), 'required');
        //$this->form_validation->set_rules('language', lang('language'), 'required');
        $this->form_validation->set_rules('currency_prefix', lang('currency_code'), 'required|max_length[3]|min_length[3]');
        $this->form_validation->set_rules('default_discount', lang('default_discount'), 'required');
        $this->form_validation->set_rules('tax_rate', lang('default_tax_rate'), 'required');
        $this->form_validation->set_rules('rows_per_page', lang('rows_per_page'), 'required');
        $this->form_validation->set_rules('display_product', lang('display_product'), 'required');
        $this->form_validation->set_rules('pro_limit', lang('pro_limit'), 'required');
        $this->form_validation->set_rules('display_kb', lang('display_kb'), 'required');
        $this->form_validation->set_rules('default_category', lang('default_category'), 'required');
        $this->form_validation->set_rules('default_customer', lang('default_customer'), 'required');
        $this->form_validation->set_rules('dateformat', lang('date_format'), 'required');
        $this->form_validation->set_rules('timeformat', lang('time_format'), 'required');
        $this->form_validation->set_rules('item_addition', lang('item_addition'), 'required');
        if ($this->input->post('protocol') == 'smtp') {
            $this->form_validation->set_rules('smtp_host', lang('smtp_host'), 'required');
            $this->form_validation->set_rules('smtp_user', lang('smtp_user'), 'required');
            $this->form_validation->set_rules('smtp_pass', lang('smtp_pass'), 'required');
            $this->form_validation->set_rules('smtp_port', lang('smtp_port'), 'required');
        }
        if ($this->input->post('stripe')) {
            $this->form_validation->set_rules('stripe_secret_key', lang('stripe_secret_key'), 'required');
            $this->form_validation->set_rules('stripe_publishable_key', lang('stripe_publishable_key'), 'required');
        }
        $this->form_validation->set_rules('bill_header', lang('bill_header'), 'required');
        $this->form_validation->set_rules('bill_footer', lang('bill_footer'), 'required');
        $this->load->library('encrypt');

        if ($this->form_validation->run() == true) {

            $data = array(
                'site_name' => DEMO ? 'SimplePOS' : $this->input->post('site_name'),
                'Telephone' => $this->input->post('tel'),
                'currency_prefix' => DEMO ? 'USD' : strtoupper($this->input->post('currency_prefix')),
                'default_tax_rate' => $this->input->post('tax_rate'),
                'default_discount' => $this->input->post('default_discount'),
                'rows_per_page' => $this->input->post('rows_per_page'),
                'bsty' => $this->input->post('display_product'),
                'pro_limit' => $this->input->post('pro_limit'),
                'display_kb' => $this->input->post('display_kb'),
                'default_category' => $this->input->post('default_category'),
                'default_customer' => $this->input->post('default_customer'),
                'barcode_symbology' => $this->input->post('barcode_symbology'),
                'dateformat' => DEMO ? 'jS F Y' : $this->input->post('dateformat'),
                'timeformat' => DEMO ? 'h:i A' : $this->input->post('timeformat'),
                'header' => $this->input->post('bill_header'),
                'footer' => $this->input->post('bill_footer'),
                'default_email' => DEMO ? 'noreply@spos.tecdiary.my' : $this->input->post('default_email'),
                'protocol' => $this->input->post('protocol'),
                'smtp_host' => $this->input->post('smtp_host'),
                'smtp_user' => $this->input->post('smtp_user'),
                'smtp_port' => $this->input->post('smtp_port'),
                'smtp_crypto' => $this->input->post('smtp_crypto'),
                'pin_code' => $this->input->post('pin_code') ? $this->input->post('pin_code') : NULL,
                'receipt_printer' => $this->input->post('receipt_printer'),
                'cash_drawer_codes' => $this->input->post('cash_drawer_codes'),
                'focus_add_item' => $this->input->post('focus_add_item'),
                'add_customer' => $this->input->post('add_customer'),
                'toggle_category_slider' => $this->input->post('toggle_category_slider'),
                'cancel_sale' => $this->input->post('cancel_sale'),
                'suspend_sale' => $this->input->post('suspend_sale'),
                'print_order' => $this->input->post('print_order'),
                'print_bill' => $this->input->post('print_bill'),
                'finalize_sale' => $this->input->post('finalize_sale'),
                'today_sale' => $this->input->post('today_sale'),
                'open_hold_bills' => $this->input->post('open_hold_bills'),
                'close_register' => $this->input->post('close_register'),
                'pos_printers' => $this->input->post('pos_printers'),
                'java_applet' => DEMO ? '0' : $this->input->post('enable_java_applet'),
                'rounding' => $this->input->post('rounding'),
                'item_addition' => $this->input->post('item_addition'),
                'stripe' => $this->input->post('stripe'),
                'stripe_secret_key' => $this->input->post('stripe_secret_key'),
                'stripe_publishable_key' => $this->input->post('stripe_publishable_key'),
                'CompanyID' => $this->input->post('CompanyID'),
                'TaxRegistrationNumber' => $this->input->post('TaxRegistrationNumber'),
                'TaxAccountingBasis' => $this->input->post('TaxAccountingBasis'),
                'CompanyName' => $this->input->post('CompanyName'),
                'BusinessName' => $this->input->post('BusinessName'),
                'BuildingNumber' => $this->input->post('BuildingNumber'),
                'StreetName' => $this->input->post('StreetName'),
                'AddressDetail' => $this->input->post('AddressDetail'),
                'City' => $this->input->post('City'),
                'PostalCode' => $this->input->post('PostalCode'),
                'Province' => $this->input->post('Province'),
                'FiscalYear' => $this->input->post('FiscalYear'),
                'CurrencyCode' => $this->input->post('CurrencyCode'),
                'TaxEntity' => $this->input->post('TaxEntity'),
                'ProductCompanyTaxID' => $this->input->post('ProductCompanyTaxID'),
                'SoftwareValidationNumber' => $this->input->post('SoftwareValidationNumber'),
                'ProductID' => $this->input->post('ProductID'),
                'HeaderComment' => $this->input->post('HeaderComment'),
                'Fax' => $this->input->post('Fax'),
                'Email' => $this->input->post('Email'),
                'Website' => $this->input->post('Website'),
                'phone' => $this->input->post('phone'),
            );
            if ($this->input->post('smtp_pass')) {
                $data['smtp_pass'] = $this->encrypt->encode($this->input->post('smtp_pass'));
            }

            if (DEMO) {
                $data['site_name'] = 'SimplePOS';
            } else {
                if ($_FILES['userfile']['size'] > 0) {

                    $this->load->library('upload');
                    $config['upload_path'] = 'uploads/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '300';
                    $config['max_width'] = '300';
                    $config['max_height'] = '80';
                    $config['overwrite'] = FALSE;
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload()) {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('message', $error);
                        redirect('settings');
                    }

                    $photo = $this->upload->file_name;
                }
            }
            if (isset($photo)) {
                $data['logo'] = $photo;
            }
        }


        if ($this->form_validation->run() == true && $this->settings_model->updateSetting($data)) {

            $this->session->set_flashdata('message', lang('setting_updated'));
            redirect('settings');
        } else {

            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->data['settings'] = $this->site->getSettings();
            $this->data['customers'] = $this->site->getAllCustomers();
            $this->data['categories'] = $this->site->getAllCategories();
            $this->data['smtp_pass'] = $this->encrypt->decode($this->data['settings']->smtp_pass);
            $this->data['page_title'] = lang('settings');
            $bc = array(array('link' => '#', 'page' => lang('settings')));
            $meta = array('page_title' => lang('settings'), 'bc' => $bc);
            $this->page_construct('settings/index', $this->data, $meta);
        }
    }

    function updates() {
        if (DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
        }
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->form_validation->set_rules('purchase_code', lang("purchase_code"), 'required');
        $this->form_validation->set_rules('envato_username', lang("envato_username"), 'required');
        if ($this->form_validation->run() == true) {
            $this->db->update('settings', array('purchase_code' => $this->input->post('purchase_code', TRUE), 'envato_username' => $this->input->post('envato_username', TRUE)), array('setting_id' => 1));
            redirect('settings/updates');
        } else {
            $fields = array('version' => $this->Settings->version, 'code' => $this->Settings->purchase_code, 'username' => $this->Settings->envato_username, 'site' => base_url());
            $this->load->helper('update');
            $protocol = is_https() ? 'https://' : 'http://';
            $updates = get_remote_contents($protocol . 'tecdiary.com/api/v1/update/', $fields);
            $this->data['updates'] = json_decode($updates);
            $bc = array(array('link' => site_url('settings'), 'page' => lang('settings')), array('link' => '#', 'page' => lang('updates')));
            $meta = array('page_title' => lang('updates'), 'bc' => $bc);
            $this->page_construct('settings/updates', $this->data, $meta);
        }
    }

    function install_update($file, $m_version, $version) {
        if (DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
        }
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->load->helper('update');
        save_remote_file($file . '.zip');
        $this->tec->unzip('./files/updates/' . $file . '.zip');
        if ($m_version) {
            $this->load->library('migration');
            if (!$this->migration->latest()) {
                $this->session->set_flashdata('error', $this->migration->error_string());
                redirect("settings/updates");
            }
        }
        $this->db->update('settings', array('version' => $version, 'update' => 0), array('setting_id' => 1));
        unlink('./files/updates/' . $file . '.zip');
        $this->session->set_flashdata('success', lang('update_done'));
        redirect("settings/updates");
    }

    function mesa() {
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $bc = array(array('link' => '#', 'page' => lang('settings')));
        $meta = array('page_title' => "Mesas", 'bc' => $bc);
        $this->page_construct('settings/mesa', $this->data, $meta);
    }

    function table() {
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $q = new Query();
        $q
                ->select()
                ->from("tec_mesas")
                ->where_equal(
                        array(
                            "id" => $_POST["id"]
                        )
                )
                ->limit(1)
                ->run();
        $data = $q->get_selected();
        if (!$data) {
            return print json_encode(array("error" => true));
            die();
        }

        return print json_encode(array("error" => false, "name" => $data["name"], "places" => $data["places"]));
        die();
    }

    function new_table() {
        $q = new Query();
        $q
                ->insert("tec_mesas", array("name" => $_POST["table_name"], "places" => $_POST["table_place"]))
                ->run();
        redirect("settings/mesa");
    }

    function update_mesa() {
        $q = new Query();
        $q
                ->update("tec_mesas", array("name" => $_POST["table_name"], "places" => $_POST["table_place"]))
                ->where_equal(
                        array(
                            "id" => $_POST["update"]
                        )
                )
                ->run();
        redirect("settings/mesa");
    }

    function remove_mesa() {
        if (empty($_GET["id"])) {
            redirect("settings/mesa");
        }
        $q = new Query();
        $q
                ->delete("tec_mesas")
                ->where_equal(
                        array(
                            "id" => $_GET["id"]
                        )
                )
                ->run();
        redirect("settings/mesa");
    }

    function get_mesas_logs() {
        $this->load->library('datatables');
        $this->datatables
                ->select("id, name, places, status,id AS ID", FALSE)
                ->from("tec_mesas");
        echo $this->datatables->generate();
    }

    function backups() {
        if (DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
        }
        $this->data['files'] = glob('./files/backups/*.zip', GLOB_BRACE);
        $this->data['dbs'] = glob('./files/backups/*.txt', GLOB_BRACE);
        $bc = array(array('link' => site_url('settings'), 'page' => lang('settings')), array('link' => '#', 'page' => lang('backups')));
        $meta = array('page_title' => lang('backups'), 'bc' => $bc);
        $this->page_construct('settings/backups', $this->data, $meta);
    }

    function backup_database() {
        if (DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
        }
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->load->dbutil();
        $prefs = array(
            'format' => 'txt',
            'filename' => 'spos_db_backup.sql'
        );
        $back = $this->dbutil->backup($prefs);
        $backup = & $back;
        $db_name = 'db-backup-on-' . date("Y-m-d-H-i-s") . '.txt';
        $save = './files/backups/' . $db_name;
        $this->load->helper('file');
        write_file($save, $backup);
        $this->session->set_flashdata('messgae', lang('db_saved'));
        redirect("settings/backups");
    }

    function backup_files() {
        if (DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
        }
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $name = 'file-backup-' . date("Y-m-d-H-i-s");
        $this->tec->zip("./", './files/backups/', $name);
        $this->session->set_flashdata('messgae', lang('backup_saved'));
        redirect("settings/backups");
        exit();
    }

    function restore_database($dbfile) {
        if (DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
        }
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $file = file_get_contents('./files/backups/' . $dbfile . '.txt');
        $this->db->conn_id->multi_query($file);
        $this->db->conn_id->close();
        redirect('logout/db');
    }

    function download_database($dbfile) {
        if (DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
        }
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->load->library('zip');
        $this->zip->read_file('./files/backups/' . $dbfile . '.txt');
        $name = 'db_backup_' . date('Y_m_d_H_i_s') . '.zip';
        $this->zip->download($name);
        exit();
    }

    function download_backup($zipfile) {
        if (DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
        }
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->load->helper('download');
        force_download('./files/backups/' . $zipfile . '.zip', NULL);
        exit();
    }

    function restore_backup($zipfile) {
        if (DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
        }
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $file = './files/backups/' . $zipfile . '.zip';
        $this->tec->unzip($file, './');
        $this->session->set_flashdata('success', lang('files_restored'));
        redirect("settings/backups");
        exit();
    }

    function delete_database($dbfile) {
        if (DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
        }
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        unlink('./files/backups/' . $dbfile . '.txt');
        $this->session->set_flashdata('messgae', lang('db_deleted'));
        redirect("settings/backups");
    }

    function delete_backup($zipfile) {
        if (DEMO) {
            $this->session->set_flashdata('error', lang('disabled_in_demo'));
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
        }
        if (!$this->Admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        unlink('./files/backups/' . $zipfile . '.zip');
        $this->session->set_flashdata('messgae', lang('backup_deleted'));
        redirect("settings/backups");
    }

    public function saf_xsd(){
        $saf_xsd_field_row = get_row("tec_saf_setting",array("id"=>1));
        if($saf_xsd_field_row){
            $saf_xsd_fields = explode(",", $saf_xsd_field_row['field']);
        } else {
            $saf_xsd_fields = array();
        }
        $saf_xsd_setting = array();

        foreach ($saf_xsd_fields as $key => $saf_xsd_field) {
            $saf_xsd_row = get_row("tec_saf_setting",array("field"=>$saf_xsd_field));
            $saf_xsd_setting[$saf_xsd_field] = $saf_xsd_row['value'];
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['page_title'] = lang('AF-AO XSD & XML Pattern');
        // $bc = array(array('link' => '#', 'page' => lang('settings')));

        $bc = array(array('link' => site_url('settings'), 'page' => lang('settings')), array('link' => '#', 'page' => lang('AF-AO XSD & XML Pattern')));
        $meta = array('page_title' => lang('SAF-AO XSD & XML Pattern'), "saf_xsd_setting"=>$saf_xsd_setting,"bc"=>$bc);
        $this->page_construct('settings/saf_xsd',$this->data, $meta);

    }

    public function getXmlPattern(){
        $xml_content = htmlspecialchars_decode($this->input->post("xml"));
    
        $sub_str = $this->get_string_between($xml_content,"<Header>","</Header>");
        $data['Header'] = $sub_str;
        $xml_content = str_replace($sub_str, "Header_pattern", $xml_content);

        $sub_str = $this->get_string_include($xml_content,"<Account>","</Account>");
        $data['Account'] = $sub_str;
        $xml_content = str_replace($sub_str, "Account_pattern", $xml_content);

        $sub_str = $this->get_string_include($xml_content,"<Customer>","</Customer>");
        $data['Customer'] = $sub_str;
        $xml_content = str_replace($sub_str, "<Customer>Customer_pattern</Customer>", $xml_content);

        $sub_str = $this->get_string_include($xml_content,"<Supplier>","</Supplier>");
        $data['Supplier'] = $sub_str;
        $xml_content = str_replace($sub_str, "<Supplier>Supplier_pattern</Supplier>", $xml_content);
    
        $sub_str = $this->get_string_include($xml_content,"<Product>","</Product>");
        $data['Product'] = $sub_str;
        $xml_content = str_replace($sub_str, "<Product>Product_pattern</Product>", $xml_content);

        $sub_str = $this->get_string_between($xml_content,"<TaxTable>","</TaxTable>");
        $data['TaxTable'] = $sub_str;
        $xml_content = str_replace($sub_str, "TaxTable_pattern", $xml_content);

        $sub_str = $this->get_string_between($xml_content,"<GeneralLedgerEntries>","</GeneralLedgerEntries>");
        $data['GeneralLedgerEntries'] = $sub_str;
        $xml_content = str_replace($sub_str, "generalledgerentries_pattern", $xml_content);

        $sub_str = $this->get_string_between($xml_content,"<Invoice>","</Invoice>");
        $data['SalesInvoices'] = $sub_str;
        $xml_content = str_replace($sub_str, "SalesInvoices_pattern", $xml_content);

        $sub_str = $this->get_string_between($xml_content,"<StockMovement>","</StockMovement>");
        $data['MovementOfGoods'] = $sub_str;
        $xml_content = str_replace($sub_str, "MovementOfGoods_pattern", $xml_content);

        $sub_str = $this->get_string_between($xml_content,"<WorkDocument>","</WorkDocument>");
        $data['WorkingDocuments'] = $sub_str;
        $xml_content = str_replace($sub_str, "WorkingDocuments_pattern", $xml_content);

        $sub_str = $this->get_string_between($xml_content,"<Payment>","</Payment>");
        $data['Payments'] = $sub_str;
        $xml_content = str_replace($sub_str, "Payments_pattern", $xml_content);

        $sub_str = $this->get_string_between($xml_content,"<PurchaseInvoices>","</PurchaseInvoices>");
        $data['PurchaseInvoices'] = $sub_str;
        $xml_content = str_replace($sub_str, "PurchaseInvoices_pattern", $xml_content);

        $data['Audit'] = $xml_content;
        echo json_encode($data);
    }

    public function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }


    public function get_string_include($string, $start, $end){
        $string = $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        // $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini + strlen($end);
        return $substr = substr($string, $ini, $len);
    }

    public function save_pattern(){
        $data = $this->input->post();
        $saf_xsd_fields = "";
        foreach ($data as $key => $value) {

            $saf_xsd_fields.=$key.",";
        }
        $saf_xsd_fields = trim($saf_xsd_fields,",");
        delete_row("tec_saf_setting");
        create_row("tec_saf_setting",array("id"=>1,"field"=>$saf_xsd_fields));

        foreach ($data as $key => $value) {
            $value = str_replace("[removed]", 'xmlns="urn:OECD:StandardAuditFile-Tax:AO_1.01_01" attributeFormDefault="unqualified" elementFormDefault="qualified" targetNamespace="urn:OECD:StandardAuditFile-Tax:AO_1.01_01" version="1.01_01" id="SAF-T_AO" xmlns', $value);
            // $value = str_replace("[1-9]+\d?/AGT/\d{4}|[0]","[1-9]+\\d?/AGT/\\d{4}|[0]", $value);
            // $value = str_replace("[1-9]+\d?/AGT/\d{4}|[0]","[0-9a-zA-Z\-/._+*]", $value);
            create_row("tec_saf_setting",array("field"=>$key,"value"=>htmlspecialchars_decode($value)));

        }
        redirect("settings/saf_xsd");
    }

    public function fill_xml_value($string,$start,$end,$value=""){
        // $sub_str = $this->get_string_between($xml_pattern,$start_string,$end_string);
        $string = $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        // $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini + strlen($end);
        $substr = substr($string, $ini, $len);
        if(trim($value) == "" || $value == NULL) {
            $xml_pattern = str_replace($substr,  "", $string);
            // $xml_pattern = str_replace("\r\n    ".$substr,  "", $string);
            // $xml_pattern = str_replace("\r\n        ".$substr,  "", $string);
        }
        else {
             if($start =="<Customer>" || $start =="<Supplier>" || $start =="<Account>" || $start =="<Product>" || $start =="<Line>" || $start == "<Invoice>" || ($start == "<Payment>" && strlen($value)>100)){
                $xml_pattern = str_replace($substr,  $value, $string);

             }
            else 
                $xml_pattern = str_replace($substr,  $start.$value.$end, $string);

        }
        file_put_contents("1.xml", $xml_pattern);
        return $xml_pattern;
    }
    public function xmlReport(){
        $saf_xsd_field_row = get_row("tec_saf_setting",array("id"=>1));
        $saf_xsd_fields = explode(",", $saf_xsd_field_row['field']);
        $saf_xsd_pattern = array();

        $start_date = $this->input->post("start_date");
        $end_date = $this->input->post("end_date");

        foreach ($saf_xsd_fields as $key => $saf_xsd_field) {
            $saf_xsd_row = get_row("tec_saf_setting",array("field"=>$saf_xsd_field));
            $saf_xsd_pattern[$saf_xsd_field] = $saf_xsd_row['value'];
        }
        $header_pattern = $saf_xsd_pattern['header_pattern'];
        $setting_info = get_row("tec_settings",array("setting_id"=>1));
        $header_pattern = $this->fill_xml_value($header_pattern,"<AuditFileVersion>","</AuditFileVersion>","1.01_01");
        $header_pattern = $this->fill_xml_value($header_pattern,"<CompanyID>","</CompanyID>",$setting_info['CompanyID']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<TaxRegistrationNumber>","</TaxRegistrationNumber>",$setting_info['TaxRegistrationNumber']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<TaxAccountingBasis>","</TaxAccountingBasis>","F");
        $header_pattern = $this->fill_xml_value($header_pattern,"<CompanyName>","</CompanyName>",$setting_info['CompanyName']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<BusinessName>","</BusinessName>",$setting_info['BusinessName']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<BuildingNumber>","</BuildingNumber>",$setting_info['BuildingNumber']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<StreetName>","</StreetName>",$setting_info['StreetName']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<AddressDetail>","</AddressDetail>",$setting_info['AddressDetail']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<City>","</City>",$setting_info['City']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<PostalCode>","</PostalCode>",$setting_info['PostalCode']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<Province>","</Province>",$setting_info['Province']);
        $header_pattern = str_replace("<Country />", "<Country>AO</Country>",$header_pattern);
        $header_pattern = $this->fill_xml_value($header_pattern,"<FiscalYear>","</FiscalYear>",$setting_info['FiscalYear']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<StartDate>","</StartDate>",$start_date);
        $header_pattern = $this->fill_xml_value($header_pattern,"<EndDate>","</EndDate>", $end_date);
        $header_pattern = $this->fill_xml_value($header_pattern,"<CurrencyCode>","</CurrencyCode>",$setting_info['CurrencyCode']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<DateCreated>","</DateCreated>",date("Y-m-d"));
        $header_pattern = $this->fill_xml_value($header_pattern,"<TaxEntity>","</TaxEntity>",$setting_info['TaxEntity']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<ProductCompanyTaxID>","</ProductCompanyTaxID>",$setting_info['ProductCompanyTaxID']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<SoftwareValidationNumber>","</SoftwareValidationNumber>",$setting_info['SoftwareValidationNumber']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<ProductID>","</ProductID>",$setting_info['ProductID']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<ProductVersion>","</ProductVersion>",$setting_info['ProductVersion']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<HeaderComment>","</HeaderComment>",$setting_info['HeaderComment']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<Telephone>","</Telephone>",$setting_info['Telephone']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<Fax>","</Fax>",$setting_info['Fax']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<Email>","</Email>",$setting_info['Email']);
        $header_pattern = $this->fill_xml_value($header_pattern,"<Website>","</Website>",$setting_info['Website']);
        
        $account_pattern = $saf_xsd_pattern['account_pattern'];
        $account_info = array();
        $account_pattern = $this->fill_xml_value($account_pattern,"<AccountID>","</AccountID>",$account_info['AccountID']);
        $account_pattern = $this->fill_xml_value($account_pattern,"<AccountDescription>","</AccountDescription>",$account_info['AccountDescription']);
        $account_pattern = $this->fill_xml_value($account_pattern,"<OpeningDebitBalance>","</OpeningDebitBalance>",$account_info['OpeningDebitBalance']);
        $account_pattern = $this->fill_xml_value($account_pattern,"<OpeningCreditBalance>","</OpeningCreditBalance>",$account_info['OpeningCreditBalance']);
        $account_pattern = $this->fill_xml_value($account_pattern,"<ClosingDebitBalance>","</ClosingDebitBalance>",$account_info['OpeningCreditBalance']);
        $account_pattern = $this->fill_xml_value($account_pattern,"<ClosingCreditBalance>","</ClosingCreditBalance>",$account_info['ClosingCreditBalance']);
        $account_pattern = $this->fill_xml_value($account_pattern,"<GroupingCategory>","</GroupingCategory>",$account_info['GroupingCategory']);
        $account_pattern = $this->fill_xml_value($account_pattern,"<GroupingCode>","</GroupingCode>",$account_info['GroupingCode']);

        $customer_pattern = "";
        $customer_infos = get_rows("tec_customers");
        foreach ($customer_infos as $key => $customer_info) {
            $customer_pattern_sub = $saf_xsd_pattern['customer_pattern']."\r\n    ";
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<CustomerID>","</CustomerID>",$customer_info['id']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<AccountID>","</AccountID>",$customer_info['id']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<CustomerTaxID>","</CustomerTaxID>",$customer_info['cf1']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<CompanyName>","</CompanyName>",$customer_info['name']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<Contact>","</Contact>",$customer_info['phone']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<BuildingNumber>","</BuildingNumber>",$customer_info['numero']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<StreetName>","</StreetName>",$customer_info['bairro']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<AddressDetail>","</AddressDetail>",$customer_info['bairro']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<City>","</City>",$customer_info['cidade']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<PostalCode>","</PostalCode>",$customer_info['postal_code']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<Province>","</Province>",$customer_info['province']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<Country>","</Country>","AO");
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<Telephone>","</Telephone>",$customer_info['phone']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<Fax>","</Fax>",$customer_info['Fax']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<Email>","</Email>",$customer_info['email']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<Website>","</Website>",$customer_info['website']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<SelfBillingIndicator>","</SelfBillingIndicator>","0");
            $customer_pattern.= $customer_pattern_sub;
        }

        $supplier_pattern = "";
        $customer_infos = get_rows("tec_suppliers");
        foreach ($customer_infos as $key => $customer_info) {
            $customer_pattern_sub = $saf_xsd_pattern['supplier_pattern']."\r\n    ";
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<SupplierID>","</SupplierID>",$customer_info['id']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<AccountID>","</AccountID>",$customer_info['id']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<SupplierTaxID>","</SupplierTaxID>",$customer_info['cf1']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<CompanyName>","</CompanyName>",$customer_info['name']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<Contact>","</Contact>",$customer_info['phone']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<BuildingNumber>","</BuildingNumber>",$customer_info['numero']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<StreetName>","</StreetName>",$customer_info['bairro']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<AddressDetail>","</AddressDetail>",$customer_info['bairro']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<City>","</City>",$customer_info['cidade']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<PostalCode>","</PostalCode>",$customer_info['postal_code']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<Province>","</Province>",$customer_info['estado']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<Country>","</Country>","AO");
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<Telephone>","</Telephone>",$customer_info['phone']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<Fax>","</Fax>",$customer_info['Fax']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<Email>","</Email>",$customer_info['email']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<Website>","</Website>",$customer_info['website']);
            $customer_pattern_sub = $this->fill_xml_value($customer_pattern_sub,"<SelfBillingIndicator>","</SelfBillingIndicator>","0");
            $supplier_pattern.= $customer_pattern_sub;
        }

        $product_pattern = "";
        $product_infos = get_rows("tec_products");
        foreach ($product_infos as $key => $product_info) {
            $product_pattern_sub = $saf_xsd_pattern['product_pattern']."\r\n    ";
            $product_type =  ($product_info['type'] == "service")?"S":"P";
            $product_pattern_sub = $this->fill_xml_value($product_pattern_sub,"<ProductType>","</ProductType>",$product_type);
            $product_pattern_sub = $this->fill_xml_value($product_pattern_sub,"<ProductCode>","</ProductCode>",$product_info['code']);
            $product_category = get_row("tec_categories", array("id"=>$product_info['category_id']));
            $product_pattern_sub = $this->fill_xml_value($product_pattern_sub,"<ProductGroup>","</ProductGroup>",$product_category['name']);
            $product_pattern_sub = $this->fill_xml_value($product_pattern_sub,"<ProductDescription>","</ProductDescription>",$product_info['name']);
            $product_pattern_sub = $this->fill_xml_value($product_pattern_sub,"<ProductNumberCode>","</ProductNumberCode>",$product_info['code']);
            $product_pattern_sub = $this->fill_xml_value($product_pattern_sub,"<CustomsDetails>","</CustomsDetails>",$product_info['customsDetails']);
            $product_pattern .= $product_pattern_sub;
        }

        $taxtable_pattern = "";
        $tax_infos = get_rows("tec_tax");
        foreach ($tax_infos as $key => $tax_info) {
            $tax_pattern_sub = $saf_xsd_pattern['taxtable_pattern'];
            $tax_pattern_sub = $this->fill_xml_value($tax_pattern_sub,"<TaxType>","</TaxType>",$tax_info['tax_type']);
            $tax_pattern_sub = $this->fill_xml_value($tax_pattern_sub,"<TaxCountryRegion>","</TaxCountryRegion>","AO");
            $tax_pattern_sub = $this->fill_xml_value($tax_pattern_sub,"<TaxCode>","</TaxCode>",$tax_info['tax_code']);
            $tax_pattern_sub = $this->fill_xml_value($tax_pattern_sub,"<Description>","</Description>",$tax_info['reason']);
            $tax_pattern_sub = $this->fill_xml_value($tax_pattern_sub,"<TaxExpirationDate>","</TaxExpirationDate>",$tax_info['TaxExpirationDate']);
            if($tax_info['tax_type'] == "IS" && $tax_info['tax_code']!="ISE"){
                $tax_pattern_sub = str_replace("TaxPercentage", "TaxAmount", $tax_pattern_sub);
                $tax_pattern_sub = $this->fill_xml_value($tax_pattern_sub,"<TaxAmount>","</TaxAmount>",$tax_info['tax']);

            }  else {
                $tax_pattern_sub = $this->fill_xml_value($tax_pattern_sub,"<TaxPercentage>","</TaxPercentage>",$tax_info['tax']);
            }
            $taxtable_pattern .= $tax_pattern_sub;

        }
        $invoice_pattern = "";
        $sale_infos = get_rows("tec_sales",array("date>="=>$start_date, "date<="=>$end_date));
        // $sale_infos = get_rows("tec_sales");
        $sale_invoice_number = 0;
        $total = 0;
        foreach ($sale_infos as $key => $sale_info) {
            if($sale_info['InvoiceType'] == "FP") continue;
            $sale_invoice_number ++ ;
            // $total += $sale_info["grand_total"];
            $invoice_pattern_sub = "\r\n      <Invoice>".$saf_xsd_pattern['saleinvoice_pattern']."</Invoice>";
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<InvoiceNo>","</InvoiceNo>",$sale_info['InvoiceNo']);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<InvoiceStatusDate>","</InvoiceStatusDate>",$sale_info['InvoiceStatusDate']);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<Reason>","</Reason>",$sale_info['Reason']);
            $source_id = get_row("tec_users",array("id"=>$sale_info['created_by']));

            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<SourceID>","</SourceID>", $source_id['username']);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<SourceBilling>","</SourceBilling>",$sale_info['SourceBilling']);
            
            // $hash_str = date("Y-m-d",strtotime($sale_info['date'])).";".$sale_info['date'].";".$sale_info['InvoiceNo'].";".$sale_info['grand_total'];
            // $hash_str =  base64_encode(hash("SHA1", $hash_str));


            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<Hash>","</Hash>",$sale_info['Hash']);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<HashControl>","</HashControl>",$sale_info['HashControl']);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<Period>","</Period>",$sale_info['Period']);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<InvoiceDate>","</InvoiceDate>",date("Y-m-d",strtotime($sale_info['date'])));
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<InvoiceType>","</InvoiceType>",$sale_info['InvoiceType']);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<SelfBillingIndicator>","</SelfBillingIndicator>",$sale_info['SelfBillingIndicator']?$sale_info['SelfBillingIndicator']:"0");
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<CashVATSchemeIndicator>","</CashVATSchemeIndicator>",$sale_info['CashVATSchemeIndicator']);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<ThirdPartiesBillingIndicator>","</ThirdPartiesBillingIndicator>",$sale_info['ThirdPartiesBillingIndicator']);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<EACCode>","</EACCode>",$sale_info['EACCode']);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<SystemEntryDate>","</SystemEntryDate>",$sale_info['InvoiceStatusDate']);
            // $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<TransactionID>","</TransactionID>",$sale_info['id']);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<TransactionID>","</TransactionID>","");
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<CustomerID>","</CustomerID>",$sale_info['customer_id']);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<CustomerID>","</CustomerID>",$sale_info['customer_id']);

            $customer_info = get_row("tec_customers",array("id"=>$sale_info['customer_id']));
            
            $sub_str = $this->get_string_between($invoice_pattern_sub,"<ShipTo>","</ShipTo>");
            $invoice_pattern_sub = str_replace($sub_str, "ShipTpPattern", $invoice_pattern_sub);
            $ship_to = $sub_str;
            
            $ship_from = $sub_str;

            $ship_to = $this->fill_xml_value($ship_to,"<DeliveryID>","</DeliveryID>",$customer_info['DeliveryID']);
            $ship_to = $this->fill_xml_value($ship_to,"<DeliveryDate>","</DeliveryDate>",$customer_info['DeliveryDate']);

            $ship_to = $this->fill_xml_value($ship_to,"<BuildingNumber>","</BuildingNumber>",$customer_info['numero']);
            $ship_to = $this->fill_xml_value($ship_to,"<StreetName>","</StreetName>",$customer_info['bairro']);
            $ship_to = $this->fill_xml_value($ship_to,"<AddressDetail>","</AddressDetail>",$customer_info['bairro']);
            $ship_to = $this->fill_xml_value($ship_to,"<City>","</City>",$customer_info['cidade']);
            $ship_to = $this->fill_xml_value($ship_to,"<PostalCode>","</PostalCode>",$customer_info['postal_code']);
            $ship_to = $this->fill_xml_value($ship_to,"<Province>","</Province>",$customer_info['province']);
            $ship_to = $this->fill_xml_value($ship_to,"<Country>","</Country>","AO");
            
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<ShipTo>","</ShipTo>",$ship_to);

            $customer_info = get_row("tec_settings",array("setting_id"=>1));

            $ship_from = $this->fill_xml_value($ship_from,"<DeliveryID>","</DeliveryID>",$customer_info['DeliveryID']);
            $ship_from = $this->fill_xml_value($ship_from,"<DeliveryDate>","</DeliveryDate>",$customer_info['DeliveryDate']);
            
            $ship_from = $this->fill_xml_value($ship_from,"<BuildingNumber>","</BuildingNumber>",$customer_info['BuildingNumber']);
            $ship_from = $this->fill_xml_value($ship_from,"<StreetName>","</StreetName>",$customer_info['StreetName']);
            $ship_from = $this->fill_xml_value($ship_from,"<AddressDetail>","</AddressDetail>",$customer_info['AddressDetail']);
            $ship_from = $this->fill_xml_value($ship_from,"<City>","</City>",$customer_info['City']);
            $ship_from = $this->fill_xml_value($ship_from,"<PostalCode>","</PostalCode>",$customer_info['PostalCode']);
            $ship_from = $this->fill_xml_value($ship_from,"<Province>","</Province>",$customer_info['Province']);
            $ship_from = $this->fill_xml_value($ship_from,"<Country>","</Country>","AO");
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<ShipFrom>","</ShipFrom>",$ship_from);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<MovementEndTime>","</MovementEndTime>",$sale_info['MovementEndTime']);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<MovementStartTime>","</MovementStartTime>",$sale_info['MovementStartTime']);
            
            $sub_str = $this->get_string_include($invoice_pattern_sub,"<Line>","</Line>");
            $sale_item_infos = get_rows("tec_sale_items",array("sale_id"=>$sale_info['id']));
            $line_pattern = "";
            foreach ($sale_item_infos as  $sale_item_info) {
                $line_pattern_sub = $sub_str."\r\n        ";
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<LineNumber>","</LineNumber>",$sale_item_info['id']);
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<OriginatingON>","</OriginatingON>",$sale_info['id']);
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<OrderDate>","</OrderDate>",date("Y-m-d",strtotime($sale_info['date'])));

                $product_info = get_row("tec_products",array("id"=>$sale_item_info['product_id']));
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<ProductCode>","</ProductCode>",$product_info['code']);
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<ProductDescription>","</ProductDescription>",$product_info['name']);
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<Quantity>","</Quantity>",$sale_item_info['quantity']);
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<UnitOfMeasure>","</UnitOfMeasure>",$product_info['UnitOfMeasure']);
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<UnitPrice>","</UnitPrice>",$sale_item_info['net_unit_price']);
                // $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<UnitPrice>","</UnitPrice>",$sale_item_info['unit_price'] + $sale_item_info['unit_price']*14/100 );
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<TaxBase>","</TaxBase>","");
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<TaxPointDate>","</TaxPointDate>",date("Y-m-d",strtotime($sale_info['date'])));
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<References>","</References>",$sale_item_info['References']);
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<Description>","</Description>",$product_info['name']);
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<ProductSerialNumber>","</ProductSerialNumber>",$sale_item_info['ProductSerialNumber']);
                
                $line_pattern_sub = str_replace("DebitAmount", "CreditAmount", $line_pattern_sub);

                $sub_total = $sale_item_info['subtotal']*1 - $sale_item_info['item_discount'];
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<CreditAmount>","</CreditAmount>",number_format($sub_total,2));
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<CreditAmount>","</CreditAmount>",$sale_item_info['net_unit_price']);

                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<SettlementAmount>","</SettlementAmount>",$sale_item_info['item_discount']);
                $total += $sale_item_info['net_unit_price'];
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<CustomsInformation>","</CustomsInformation>",$sale_item_info['CustomsInformation']);
                $tax_info = get_row("tec_tax",array("id"=>$sale_item_info['tax_id']));
               
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<TaxType>","</TaxType>",$tax_info['tax_type']);
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<TaxCountryRegion>","</TaxCountryRegion>","AO");
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<TaxCode>","</TaxCode>",$tax_info['tax_code']);
                    $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<TaxPercentage>","</TaxPercentage>",$tax_info['tax']);
                if($tax_info['tax'] == 0){
                    $line_pattern_sub = str_replace("</Tax>","</Tax>\r\n          <TaxExemptionReason>".$tax_info['reason']."</TaxExemptionReason>\r\n          <TaxExemptionCode>".$tax_info['code']."</TaxExemptionCode>\r\n",$line_pattern_sub);

                }

                $line_pattern .= $line_pattern_sub;
            }
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<Line>","</Line>",$line_pattern);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<TaxPayable>","</TaxPayable>",$sale_info["total_tax"]);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<NetTotal>","</NetTotal>",$sale_info["total"]);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<GrossTotal>","</GrossTotal>",$sale_info["total"]*1 +  $sale_info["total_tax"]*1);
            // $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<GrossTotal>","</GrossTotal>",$sale_info["grand_total"]);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<Currency>","</Currency>",$sale_info["Currency"]);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<Settlement>","</Settlement>",$sale_info["Settlement"]);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<PaymentMechanism>","</PaymentMechanism>","CC");
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<PaymentAmount>","</PaymentAmount>",$sale_info["grand_total"]);
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<PaymentDate>","</PaymentDate>",date("Y-m-d",strtotime($sale_info["date"])));
            $invoice_pattern_sub = $this->fill_xml_value($invoice_pattern_sub,"<WithholdingTax>","</WithholdingTax>","");
            $invoice_pattern .= $invoice_pattern_sub;

        }

        $purchaseinvoice_pattern = $saf_xsd_pattern['purchaseinvoice_pattern'];
        $p_invoice = "";
        $purchase_infos = get_rows("tec_purchases");
        $invoice_number = 0;
        foreach ($purchase_infos as $key => $purchase_info) {
            $invoice_number ++; 
            $p_invoice_sub = "\r\n      <Invoice>".$this->get_string_between($purchaseinvoice_pattern, "<Invoice>","</Invoice>")."</Invoice>";
            $invoice_no = "FT SIF".date("Y")."/".$purchase_info['id'];
            $p_invoice_sub = $this->fill_xml_value($p_invoice_sub,"<InvoiceNo>","</InvoiceNo>",$invoice_no);
            $p_invoice_sub = $this->fill_xml_value($p_invoice_sub,"<Period>","</Period>",$purchase_info['Period']);
            $p_invoice_sub = $this->fill_xml_value($p_invoice_sub,"<InvoiceDate>","</InvoiceDate>",$purchase_info['date']);
            $p_invoice_sub = $this->fill_xml_value($p_invoice_sub,"<InvoiceType>","</InvoiceType>","FT");
            $supplier_info = get_row("tec_suppliers",array("id"=>$purchase_info['supplier_id']));
            $p_invoice_sub = $this->fill_xml_value($p_invoice_sub,"<SourceID>","</SourceID>",$supplier_info['name']);
            $p_invoice_sub = $this->fill_xml_value($p_invoice_sub,"<SupplierID>","</SupplierID>",$purchase_info['supplier_id']);
            $p_invoice_sub = $this->fill_xml_value($p_invoice_sub,"<InputTax>","</InputTax>",$purchase_info['TaxPercentage']);
            $p_invoice_sub = $this->fill_xml_value($p_invoice_sub,"<TaxPayable>","</TaxPayable>",$purchase_info['TaxPayable']);
            $p_invoice_sub = $this->fill_xml_value($p_invoice_sub,"<NetTotal>","</NetTotal>",$purchase_info['NetTotal']);
            $p_invoice_sub = $this->fill_xml_value($p_invoice_sub,"<GrossTotal>","</GrossTotal>",$purchase_info['total']);
            $p_invoice_sub = $this->fill_xml_value($p_invoice_sub,"<Currency>","</Currency>",$purchase_info['Currency']);
            $p_invoice .= $p_invoice_sub;
        }
        $purchaseinvoice_pattern = $this->fill_xml_value($purchaseinvoice_pattern,"<Invoice>","</Invoice>",$p_invoice);
        $purchaseinvoice_pattern = $this->fill_xml_value($purchaseinvoice_pattern,"<NumberOfEntries>","</NumberOfEntries>",$invoice_number);
 
        $payment_pattern = "";
        $payment_infos = get_rows("tec_payments");
        $payment_number = 0;
        $payment_total = 0;
        foreach ($payment_infos as $key => $payment_info) {
            $payment_number ++;
            
            $sale_info = get_row("tec_sales",array("id"=>$payment_info['sale_id']));
            $payment_pattern_sub = "\r\n      <Payment>".$saf_xsd_pattern['payment_pattern']."</Payment>";
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<PaymentRefNo>","</PaymentRefNo>", $payment_info['PaymentType']." RC/".$payment_info['id']);

            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<Period>","</Period>","1");
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<TransactionID>","</TransactionID>",$payment_info['transaction_id']);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<TransactionDate>","</TransactionDate>",date("Y-m-d",strtotime($payment_info['date'])));
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<Description>","</Description>",$payment_info['Description']);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<PaymentType>","</PaymentType>",$payment_info['PaymentType']);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<SystemID>","</SystemID>",$payment_info['SystemID']);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<PaymentStatus>","</PaymentStatus>",$payment_info['PaymentStatus']);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<PaymentStatusDate>","</PaymentStatusDate>",str_replace(" ","T",date("Y-m-d H:i:s",strtotime($payment_info['date']))));
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<Reason>","</Reason>",$payment_info['note']);
            
            $source_id = get_row("tec_users",array("id"=>$sale_info['created_by']));
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<SourceID>","</SourceID>", $source_id['username']);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<SourcePayment>","</SourcePayment>",$payment_info['SourcePayment']);
            $paid_by = "";
            if($payment_info['paid_by'] == "cash") $paid_by = "CC"; else $paid_by = "CD";
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<PaymentMechanism>","</PaymentMechanism>",$paid_by);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<PaymentAmount>","</PaymentAmount>",$payment_info['amount']);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<PaymentDate>","</PaymentDate>",date("Y-m-d", strtotime($payment_info['date'])));
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<PaymentAmount>","</PaymentAmount>",$payment_info['amount']);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<SystemEntryDate>","</SystemEntryDate>",$sale_info['InvoiceStatusDate']);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<CustomerID>","</CustomerID>",$payment_info['customer_id']);
            

            $sub_str = $this->get_string_include($payment_pattern_sub,"<Line>","</Line>");
            $sale_item_infos = get_rows("tec_sale_items",array("sale_id"=>$sale_info['id']));
            $line_pattern = "";
            foreach ($sale_item_infos as  $sale_item_info) {
                $line_pattern_sub = $sub_str."\r\n        ";
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<LineNumber>","</LineNumber>",$sale_item_info['id']);
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<OriginatingON>","</OriginatingON>",$sale_info['id']);
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<InvoiceDate>","</InvoiceDate>",date("Y-m-d",strtotime($sale_info['date'])));

                $product_info = get_row("tec_products",array("id"=>$sale_item_info['product_id']));
                
                $line_pattern_sub = str_replace("DebitAmount", "CreditAmount", $line_pattern_sub);

                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<CreditAmount>","</CreditAmount>",str_replace(",","",$sale_item_info['net_unit_price'])*$sale_item_info['quantity']);
                $payment_total += str_replace(",","",$sale_item_info['net_unit_price'])*$sale_item_info['quantity'];
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<SettlementAmount>","</SettlementAmount>",$sale_item_info['subtotal']);
                $tax_info = get_row("tec_tax",array("id"=>$sale_item_info['tax_id']));
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<TaxType>","</TaxType>",$tax_info['tax_type']);
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<TaxCountryRegion>","</TaxCountryRegion>","AO");
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<TaxCode>","</TaxCode>",$tax_info['tax_code']);
                $line_pattern_sub = $this->fill_xml_value($line_pattern_sub,"<TaxPercentage>","</TaxPercentage>",$tax_info['tax']);

                if($tax_info['tax'] == 0){
                    $line_pattern_sub = str_replace("</Tax>","</Tax>\r\n          <TaxExemptionReason>".$tax_info['reason']."</TaxExemptionReason>\r\n          <TaxExemptionCode>".$tax_info['code']."</TaxExemptionCode>\r\n",$line_pattern_sub);

                }

                $line_pattern .= $line_pattern_sub;
            }
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<TaxPayable>","</TaxPayable>",$sale_info['total_tax']);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<NetTotal>","</NetTotal>",$sale_info['total']);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<GrossTotal>","</GrossTotal>",$sale_info['grand_total']);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<SettlementAmount>","</SettlementAmount>",$sale_info['paid']);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<Line>","</Line>",$line_pattern);
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<Currency>","</Currency>","");
            $payment_pattern_sub = $this->fill_xml_value($payment_pattern_sub,"<WithholdingTax>","</WithholdingTax>","");
            
            $payment_pattern.= $payment_pattern_sub;
        }
          

        $audit_pattern = $saf_xsd_pattern['audit_pattern'];
        $audit_pattern = $this->fill_xml_value($audit_pattern,"<Header>","</Header>",$header_pattern);
        $audit_pattern = $this->fill_xml_value($audit_pattern,"<GeneralLedgerAccounts>","</GeneralLedgerAccounts>",$account_pattern);
        $audit_pattern = $this->fill_xml_value($audit_pattern,"<Customer>","</Customer>",$customer_pattern);
        $audit_pattern = $this->fill_xml_value($audit_pattern,"<Supplier>","</Supplier>",$supplier_pattern);
        $audit_pattern = $this->fill_xml_value($audit_pattern,"<Product>","</Product>",$product_pattern);
        $audit_pattern = $this->fill_xml_value($audit_pattern,"<TaxTable>","</TaxTable>",$taxtable_pattern);
        $audit_pattern = $this->fill_xml_value($audit_pattern,"<Payment>","</Payment>",$payment_pattern);

        $sale_invoice_pattern = $this->get_string_between($audit_pattern, "<SalesInvoices>","</SalesInvoices>");
        $sub_str = $sale_invoice_pattern;
        $sale_invoice_pattern = $this->fill_xml_value($sale_invoice_pattern,"<NumberOfEntries>","</NumberOfEntries>",$sale_invoice_number);
        $sale_invoice_pattern = $this->fill_xml_value($sale_invoice_pattern,"<TotalDebit>","</TotalDebit>","0");
        $sale_invoice_pattern = $this->fill_xml_value($sale_invoice_pattern,"<TotalCredit>","</TotalCredit>",$total);
        $audit_pattern = str_replace($sub_str, $sale_invoice_pattern, $audit_pattern);
        $audit_pattern = $this->fill_xml_value($audit_pattern,"<Invoice>","</Invoice>",$invoice_pattern);
        

        $payments_payment_pattern = $this->get_string_between($audit_pattern, "<Payments>","</Payments>");
        $sub_str = $payments_payment_pattern;
        $payments_payment_pattern = $this->fill_xml_value($payments_payment_pattern,"<NumberOfEntries>","</NumberOfEntries>",$payment_number);
        $payments_payment_pattern = $this->fill_xml_value($payments_payment_pattern,"<TotalDebit>","</TotalDebit>","0");
        $payments_payment_pattern = $this->fill_xml_value($payments_payment_pattern,"<TotalCredit>","</TotalCredit>",$payment_total);

        $audit_pattern = str_replace($sub_str, $payments_payment_pattern, $audit_pattern);

        $audit_pattern = $this->fill_xml_value($audit_pattern,"<PurchaseInvoices>","</PurchaseInvoices>","");
        // $audit_pattern = $this->fill_xml_value($audit_pattern,"<PurchaseInvoices>","</PurchaseInvoices>",$purchaseinvoice_pattern);
        $audit_pattern = $this->fill_xml_value($audit_pattern,"<GeneralLedgerAccounts>","</GeneralLedgerAccounts>","");
        $audit_pattern = $this->fill_xml_value($audit_pattern,"<GeneralLedgerEntries>","</GeneralLedgerEntries>","");
        $audit_pattern = $this->fill_xml_value($audit_pattern,"<WorkingDocuments>","</WorkingDocuments>","");
        $audit_pattern = $this->fill_xml_value($audit_pattern,"<MovementOfGoods>","</MovementOfGoods>","");


        file_put_contents("1.xml", $audit_pattern);

        $p_file = fopen("2.xml","w");
        if ($file = fopen("1.xml", "r")) {
            while(!feof($file)) {
                $line = fgets($file);
                if(strpos($line, "<") !== false) {
                    fwrite($p_file,$line);
                }
            }
            fclose($file);
        }
        fclose($p_file);

        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"SAF-T AO.xml\""); 
        readfile("2.xml");
    }

    public function generate_licence(){
        if (!$this->Super_admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['users'] = get_rows("tec_users",array("group_id!="=>4));
        $bc = array(array('link' => '#', 'page' => lang('generate_licence')));
        $meta = array('page_title' => lang("generate_licence"), 'bc' => $bc);
        $this->page_construct('settings/generate_licence', $this->data, $meta);
    }

    public function generate(){
        $expired_month = $this->input->post("expired_month");
        $user_id = $this->input->post("user_id");
        delete_row("tec_licences",array("user_id"=>$user_id));
        $licence = strtotime(date("Y-m-d H:i:s"))."_".$user_id." ".$expired_month;
        $licence = sha1($licence);
        create_row("tec_licences", array("user_id"=>$user_id, "expired_month"=> base64_encode($expired_month), "licence"=> $licence));
        redirect("settings/generate_licence");
    }

    public function sign_keys(){
        if (!$this->Super_admin) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['sign_key'] = get_row("tec_signkey",array("id"=>1));
        $bc = array(array('link' => '#', 'page' => lang('Private & Public Key')));
        $meta = array('page_title' => lang("Private & Public Key"), 'bc' => $bc);
        $this->page_construct('settings/sign_keys', $this->data, $meta);
    }

    public function general_key(){
        $config = array(
        "digest_alg" => "sha1", /* sha512*/
        "private_key_bits" => 1024,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
        'x509_extensions' => 'v3_ca',
        'config' => 'C:/xampp/apache/conf/openssl.cnf'
        );
        $privateKey=openssl_pkey_new($config);

        openssl_pkey_export($privateKey, $privKey, null, [
            'config' => 'C:/xampp/apache/conf/openssl.cnf'
        ]);
         
        var_dump($privKey); // Just to test output
         
        $publickey=openssl_pkey_get_details($privateKey);
        $publickey=$publickey["key"];

        echo "<br/>Public Key <br/>".$publickey;

        delete_row("tec_signkey",array("id"=>1));
        create_row("tec_signkey",array("id"=>1, "public"=>$publickey,"private"=>$privKey));
        redirect("settings/sign_keys");
         
    }
}
