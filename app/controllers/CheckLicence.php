<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CheckLicence extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('auth_model');
        $this->Settings = $this->site->getSettings();
        $this->lang->load('app', $this->Settings->language);
        $this->load->helper("database_helper");
    }

    function index() {
      
    }

    public function check(){
            
        $user_id = $this->input->post("user_id");
        $licence = $this->input->post("licence");
        $user_info = $this->auth_model->checkId($user_id);
        if($user_info === FALSE){
            echo json_encode(array("status"=>"no","error"=>lang("no_user")));
            exit;
        }
        // if($user_info['group_id'] == 4){
        if(base64_decode($user_info['group_id']) == 4){
            echo json_encode(array("status"=>"ok","error"=>""));
            exit;
        }
        if($user_info['licence'] == ""){
            if($licence == "no"){
                echo json_encode(array("status"=>"need_licence","error"=>""));
                exit;
            } else {
                $user_id = $user_info['id'];
                $licence_info = get_row("tec_licences",array("user_id"=>$user_info['id']));

                $licence_info['expired_month'] = base64_decode($licence_info['expired_month']);

                if($licence_info['licence'] == $licence && isset($licence_info['licence'])){
                    $expired_date = date("Y-m-d", strtotime("+".$licence_info['expired_month']." month", strtotime(date("Y-m-d"))));

                    update_row("tec_users",array("licence"=>$licence, "expired_date"=>base64_encode($expired_date)),array("id"=>$user_id));
                    update_row("tec_licences",array("status"=>"used","insert_date"=>date("Y-m-d")), array("id"=>$licence_info['id']));
                    echo json_encode(array("status"=>"ok"));
                    exit;
                } else {
                    echo json_encode(array("status"=>"no","error"=>lang("no_licence")));
                    exit;
                }
            }
        } else {
            echo json_encode(array("status"=>"ok","error"=>""));
            exit;
        }

    }

}
