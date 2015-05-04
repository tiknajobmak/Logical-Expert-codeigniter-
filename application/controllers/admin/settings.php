<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // load libraries , view , helper
        $this->load->helper('url');
        $this->load->library('session');        
        // if session not set , redirect to admin login page
        if(!$this->session->userdata('logged_in') || $this->session->userdata('logged_in')[0]['userType'] != 'superadmin'){
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Permission Denied!</div>');
            redirect(URL.'adminLogin');   
        }
        $this->load->helper(array('form'));
        $this->load->model('logicalexpert_model');
    }
    /*
     * users listing page
     */   
    public function index(){
        // load sidebar and header
        $this->load->view('admin/templates/sidebar.php');
        $this->load->view('admin/templates/header.php');
        $whereCondition = array('settingsId' => 1);
        // fetch data for settings form
        $return = $this->logicalexpert_model->getSingleData('settings', $whereCondition );
        $data['result'] = $return[0];
        $data['pageLink'] = 'adminUsers';
        $data['heading'] = 'Admin Users';
        $data['formUrl'] = 'settings';
        $data['heading'] = "Change Settings";
        $data['submitButton'] = 'Update';
        if($this->input->post()){
            $validationError = $this->formValidations();
            $tableData = $this->input->post();
            $tableData['updatedBy'] = $this->session->userdata('logged_in')[0]['userId'];
            $ret = $this->logicalexpert_model->updateData('settings' ,$tableData, 'settingsId' ,1);
            if(!empty($ret))
                    $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Settings has been Updated Successfully!</div>');
                else
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Some Error Occur!</div>');
                redirect(ADMIN_URL.'settings');
        }
        $this->load->view('admin/addSettings' , $data);
    }
    /*
     * function used to set validations
     */
    public function formValidations(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('contactEmail', 'Contact Email', 'trim|required|valid_email|max_length[50]');
        $this->form_validation->set_rules('gatewayApi', 'Gatway API', 'trim||required' );
        if($this->form_validation->run() == FALSE){
            return FALSE;
        }
        return TRUE;
    }
}