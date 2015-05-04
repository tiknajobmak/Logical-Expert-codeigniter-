<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Classes extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // load libraries , view , helper
        $this->load->helper('url');
        $this->load->library('session');        
        // if session not set , redirect to admin login page
        if(!$this->session->userdata('logged_in')){
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Permission Denied!</div>');
            redirect(URL.'adminLogin');   
        }
        $this->load->helper(array('form'));
        $this->load->model('logicalexpert_model');
        $this->asset['js'] = "<script src=".URL."assets/admin/js/classes.js></script>";
    }
    /*
     * categories listing page
     */   
    public function index($cid = ''){
        if($cid == '')
            redirect(ADMIN_URL.'courses');
        // load sidebar and header
        $this->load->view('admin/templates/sidebar.php' , $this->asset);
        $this->load->view('admin/templates/header.php');
        // returns number of pages per page
        $perPage = $this->paginationInitialize();
        $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $joinData = array('users as us' => 'us.userId = cl.createdBy ' , 'courses as co' => 'co.courseId = cl.courseId');
        $colName = "cl.className , cl.classId , cl.endDate , cl.startDate ,  cl.price , cl.time , cl.classType , cl.status , us.userName";
        $data['userData'] = $this->logicalexpert_model->getAllData('classes as cl','cl.courseId',$cid,'',$perPage,$offset ,'' , $joinData ,'left', $colName);
        $where = array('courseId' => $cid);
        $courseId = $this->logicalexpert_model->getSingleData('courses' , $where);
        if(!empty($courseId)){
            // set session for course id if course present
            $this->session->set_userdata('courseId' , $cid);
        }else{
            redirect(ADMIN_URL.'courses');
        }
        // create pagination links
        $data['links']= $this->pagination->create_links();
        $data['pageLink'] = 'classes';
        $data['heading'] = 'Classes';
        $this->load->view('admin/contentListing' , $data);
    }
    /*
     * add categories
     */
    public function add(){
        $this->load->view('admin/templates/sidebar.php');
        $this->load->view('admin/templates/header.php');
        $viewData['cid']= $this->session->userdata('courseId');
        $viewData['submitButton'] = 'Save';
        $viewData['formUrl'] = 'classes/add';
        $viewData['heading'] = "Add Class";
        $cid = $this->session->userdata('courseId');
        if($this->input->post()){
            $validationError = $this->formValidations();
            if($validationError == FALSE){
                $this->load->view('admin/addClass' , $viewData);
            }
            else{
                $data = $this->input->post();
                $data['createdBy'] = $this->session->userdata('logged_in')[0]['userId'];
                $data['courseId']  = $cid;
                $ret = $this->logicalexpert_model->insertData('classes' ,$data);
                if($ret)
                    $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Class has been Saved Successfully!</div>');
                else
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Some Error Occur!</div>');
                redirect(ADMIN_URL.'classes/'.$cid);
            }
        }
        else{
            $this->load->view('admin/addClass', $viewData);
        }
    }
    /*
     * Edit categories
     */
    public function edit($cid = ''){
        $this->load->view('admin/templates/sidebar.php');
        $this->load->view('admin/templates/header.php');
        // check for the id in the url
        if($cid == '')redirect (ADMIN_URL.'classes');
        // get posted data in form
        $data = $this->input->post();
        $whereCondition = array('classId' => $cid);
        $return = $this->logicalexpert_model->getSingleData('classes', $whereCondition );
        // if no data found , redirect to listing
        if($return == '' || empty($return))redirect(ADMIN_URL.'classes');
        // setting variables for view
         /** get categories **/
        $viewData['result'] = $return[0];
        $viewData['formUrl'] = 'classes/edit/'.$viewData['result']['classId'];
        $viewData['submitButton'] = 'Update';
        $viewData['heading'] = "Edit Class";
        $viewData['cid'] = $this->session->userdata('courseId') ;
        $validationError = $this->formValidations();
            if($validationError == FALSE){
                $this->load->view('admin/addClass' , $viewData);
            }
            else{
                $ret = $this->logicalexpert_model->updateData('classes' ,$data ,$whereCondition , $cid);
                if(!empty($ret))
                    $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Class has been Updated Successfully!</div>');
                else
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Some Error Occur!</div>');
                redirect(ADMIN_URL.'classes/'.$viewData['cid']);
        }        
    }
    /*
     * Single category view
     */
    public function view($cid = ''){
        $whereCondition = array('cl.classId' => $cid);
        $joinData = array('users as us' => 'us.userId = cl.createdBy ' , 'courses as co' => 'co.courseId = cl.courseId');
        $return = $this->logicalexpert_model->getSingleData('classes as cl', $whereCondition ,'' , $joinData );
        if($return == '' || empty($return)){
            echo "No Data Found";
            exit();
        }
        $viewData['data'] = $return[0] ;
        echo $this->load->view('admin/classDetail', $viewData , TRUE);
        exit();
    }
    
    /*
     * Delete single category
     */
    public function delete($uid = '') {
        if($uid != ''){
            $deleteCheck = $this->logicalexpert_model->deleteData('classes' , 'classId' , $uid);
            if($deleteCheck)
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Class has been Deleted Successfully!</div>');
            else
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Class not found</div>');            
       }
       redirect(ADMIN_URL.'classes/'. $this->session->userdata('courseId'));
    }
    /*
     * Delete multiple categories
     */
    public function multipleDelete(){
        $postData = $this->input->post('deleteId');
        $this->logicalexpert_model->deleteMultiple('classes' , 'classId' , json_decode($postData));
        $this->ajaxCall();
        exit;
    }
    /*
     * Call on any ajax call
     * Return : view of the page along with pagination
     */
    public function ajaxCall()  {
        $perPage = ($this->input->post('perPage')) ? $this->input->post('perPage') : $this->session->userdata('perPage' );
        $sortData['sortCol'] = ($this->input->post('sortcolumn')) ? $this->input->post('sortcolumn') : '';
        $sortData['orderBy'] = ($this->input->post('orderby')) ? $this->input->post('orderby') : '';
        $this->session->set_userdata('perPage' , $perPage );
        $perPage = $this->paginationInitialize();
        $cid = $this->session->userdata('courseId');
        if($this->uri->segment(4))
            $offset = $this->uri->segment(4);
        else
            $offset = 0;
        $this->session->set_userdata('pageNumber' , $offset );
        $sortData = ($sortData['sortCol'] != '') ? $sortData : '';
        $joinData = array('users as us' => 'us.userId = cl.createdBy ' , 'courses as co' => 'co.courseId = cl.courseId');
        $colName = "cl.className , cl.classId , cl.endDate , cl.startDate ,  cl.price , cl.time , cl.classType , cl.status , us.userName";
        $data['userData'] = $this->logicalexpert_model->getAllData('classes as cl','cl.courseId',$cid,'',$perPage,$offset ,$sortData , $joinData ,'left', $colName);
        $data['links']= $this->pagination->create_links();
        $data['pageLink'] = 'classes';
        // get the view of the page
        echo $this->load->view('admin/classesTable' , $data , TRUE);
        exit;
    }
    /*
     * function used to initilize the pagination
     * @param :- $perpage : no of records per page
     */
    public function paginationInitialize($perPage = 2){
        // pagination start
        $this->load->library('pagination');
        $perPage = ($this->session->userdata('perPage')) ? $this->session->userdata('perPage') : $perPage ;
        $config = array();
        $config['base_url'] = base_url().'admin/classes/ajaxCall';
        $cid = $this->session->userdata('courseId');
        $config['total_rows'] = $this->logicalexpert_model->countRows('classes' , 'courseId' , $cid);
        $config['per_page'] = $perPage;
        $config['uri_segment'] = 4;
        $config['last_link'] = '<span class="lastLink">Last ›</span>';
        $config['first_link'] = '<span class="firstLink">‹ First</span>';
        $config['next_link'] = '<span class="nextLink">&gt;</span>';
        $config['prev_link'] = '<span class="prevLink">&lt;</span>';
        $this->pagination->initialize($config);
        return $perPage;
        // pagination End
    }
    
    /*
     * function used to set validations
     * @param :- $updateCheck : check update or save
     * $validateUserName : whether to validate user name
     * $validateEmail : whether to validate email
     */
    public function formValidations(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('className', 'Class Name', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('duration', 'Class Duration', 'trim|required|numeric|max_length[10]');
        $this->form_validation->set_rules('classType', 'Class Type', 'required|alpha_numeric');
        if($this->input->post('classType') != 'videoondemand' ){
            $this->form_validation->set_rules('startDate', 'Start Date', 'required');
            $this->form_validation->set_rules('endDate', 'End Date', 'required');
        }
        $this->form_validation->set_rules('time', 'Class Time', 'required|min_length[3]');
        $this->form_validation->set_rules('paymentType', 'Class Payment Type', 'required|alpha_numeric');
        $this->form_validation->set_rules('price', 'Class Price', 'trim|required|numeric|max_length[10]');
        $this->form_validation->set_rules('private', 'Private', 'trim');
        $this->form_validation->set_rules('attendee', 'Attendee', 'trim|required|numeric');
        $this->form_validation->set_message('alpha_numeric','You need to select something other than the default in %s');
        $this->form_validation->set_message('min_length','You need to select something other than the default in %s');
        if($this->input->post('private') == '1'){
            $this->form_validation->set_rules('privatePassCode', 'Pass Code', 'trim|required');
        }
        if($this->form_validation->run() == FALSE){
            return FALSE;
        }
        return TRUE;
    }
    /*
     * function to enable/disable
     */
    public function changeStatus(){
        $id = $this->input->post('columnId');
        $status = $this->input->post('status');
        $newStatus = ($status == 'enable') ? 0 : 1; 
        $data = array('status' => $newStatus);
        echo $ret = $this->logicalexpert_model->updateData('classes' ,$data , 'classId' ,$id);
        exit();
    }
}