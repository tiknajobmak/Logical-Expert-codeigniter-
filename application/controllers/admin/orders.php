<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders extends CI_Controller {
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
        $this->asset['js'] = "<script src=".URL."assets/admin/js/orders.js></script>";
    }
    /*
     * orders listing page
     */   
    public function index($pdfChk = ''){
        // load sidebar and header
        $this->load->view('admin/templates/sidebar.php' , $this->asset);
        $this->load->view('admin/templates/header.php');
        // returns number of pages per page
        $perPage = $this->paginationInitialize();
        $offset = 0;
        $joinData = array('users' => 'users.userId = orders.orderUserId' , 'classes' => 'classes.classId = orders.orderClassId');
        $data['userData'] = $this->logicalexpert_model->getAllData('orders','','','',$perPage,$offset ,'' , $joinData  );
        // create pagination links
        $data['links']= $this->pagination->create_links();
        $data['pageLink'] = 'orders';
        $data['heading'] = 'Orders';
        $data['pdf'] = TRUE;
        if($pdfChk == 1){
            $this->load->helper(array('dompdf', 'file'));
            // page info here, db calls, etc.    
            $html = $this->load->view('admin/ordersTable' , $data , TRUE);
            pdf_create($html, 'myPdf');
        }
        $this->load->view('admin/contentListing' , $data);
    }
    /*
     * Single category view
     */
    public function view($oid = ''){
        $whereCondition = array('orderId' => $oid);
        $joinData = array('users' => 'users.userId = orders.orderUserId' , 'classes' => 'classes.classId = orders.orderClassId');
        $return = $this->logicalexpert_model->getSingleData('courses', $whereCondition ,'' , $joinData );
        if($return == '' || empty($return)){
            echo "No Data Found";
            exit();
        }
        $viewData['data'] = $return[0] ;
        echo $this->load->view('admin/orderDetail', $viewData , TRUE);
        exit();
    }
    /*
     * Delete single category
     */
    public function delete($uid = '') {
        if($uid != ''){
            $deleteCheck = $this->logicalexpert_model->deleteData('orders' , 'orderId' , $uid);
            if($deleteCheck)
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Order has been Deleted Successfully!</div>');
            else
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Order not found</div>');            
       }
       redirect(ADMIN_URL.'orders');
    }
    /*
     * Delete multiple categories
     */
    public function multipleDelete(){
        $postData = $this->input->post('deleteId');
        $this->logicalexpert_model->deleteMultiple('orders' , 'orderId' , json_decode($postData));
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
        if($this->uri->segment(4)) 
            $offset = $this->uri->segment(4);
        else
            $offset = 0;
        $this->session->set_userdata('pageNumber' , $offset );
        $sortData = ($sortData['sortCol'] != '') ? $sortData : '';
        $joinData = array('users' => 'users.userId = orders.orderUserId' , 'classes' => 'classes.classId = orders.orderClassId');
        $data['userData'] = $this->logicalexpert_model->getAllData('orders','','','',$perPage,$offset ,$sortData , $joinData);
        $data['links']= $this->pagination->create_links();
        $data['pageLink'] = 'courses';
        // get the view of the page
        echo $this->load->view('admin/ordersTable' , $data , TRUE);
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
        $config['base_url'] = base_url().'admin/orders/ajaxCall';
        $config['total_rows'] = $this->logicalexpert_model->countRows('orders');
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
}