<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends CI_Controller {   
    protected $perPage = 2;
    public function __construct() {
        parent::__construct();
        // load libraries , view , helper
        $this->load->helper('url');
        $this->data['base_url'] = base_url();
        $this->load->model('logicalexpert_model');
        $this->load->library('session');  
        $this->load->helper(array('form'));
    }
    /*
     * init function for pages
     * @param : {string} $pageName (page handle)
     */
    public function index($pageName = ''){
        /**
         * load->template('template_name',$data)
         * $params string
         */
        $whereCondition = array('status' => 1 , 'handle' => $pageName);
        $data = $this->logicalexpert_model->getSingleData('pages' , $whereCondition);
        $this->data['pageData'] = (!empty($data)) ? $data[0] : "Page Does Not Exit or Not Enable";
        $segment = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        switch ($pageName){
            case 'courses':
                $this->courses(); // call courses function to list courses
                break;
            case 'classes':
                $this->classes($segment); // call courses function to list courses
                break;
            case '':
                $this->load->template('index', $this->data); // home page template
                break;
            default :
                $this->load->template('v_pages', $this->data); // other pages template
        }
    }
    /*
     * dispaly courses
     */
    public function courses(){
        $this->session->unset_userdata('courseId');
        $this->session->unset_userdata('filter');
        $joinData = array('users' => 'users.userId = courses.createdBy');
        // count rows
        $noOfRows = $this->logicalexpert_model->countRows('courses' );
        $this->paginationInitialize($noOfRows , 'courses');        
        $offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data = $this->logicalexpert_model->getAllData('courses','','','',  $this->perPage,$offset ,'' , $joinData);
        /** get categories **/
        $categories = $this->logicalexpert_model->getAllData('categories');
        $this->session->set_userdata('pages' , 'courses');
        $this->data['categories'] = $categories;
        $this->data['listData'] = $data;
        $this->data['links'] = $this->pagination->create_links();
        $this->data['pageLink'] = 'courses';
        $this->load->template('v_listing', $this->data);
    }
    /*
     * Call on any ajax call
     * param :- { integer }  $cid (course id)
     */
    public function classes($cid = 0){
        if($cid == 0)
            redirect(URL.'courses');
        $noOfRows = $this->logicalexpert_model->countRows('classes' , 'courseId' , $cid);
        $this->paginationInitialize($noOfRows , 'classes');
        $offset = 0;
        $joinData = array('users as us' => 'us.userId = cl.createdBy ' , 'courses as co' => 'co.courseId = cl.courseId');
        $colName = "cl.className , cl.classId , cl.endDate , cl.startDate ,  cl.price , cl.time , cl.classType , cl.status , us.userName";
        $data = $this->logicalexpert_model->getAllData('classes as cl','cl.courseId',$cid,'',  $this->perPage,$offset ,'' , $joinData ,'left', $colName);
        $where = array('courseId' => $cid);
        $courseId = $this->logicalexpert_model->getSingleData('courses' , $where);
        if(!empty($courseId)){
            // set session for course id if course present
            $this->session->set_userdata('courseId' , $cid);
        }else{
            redirect(ADMIN_URL.'courses');
        }
        // create pagination links
        $this->session->set_userdata('pages' , 'classes');
        $this->data['listData'] = $data;
        $this->data['links'] = $this->pagination->create_links();
        $this->data['pageLink'] = 'classes';
        $this->load->template('v_listing', $this->data);
    }


    /*
     * Call on any ajax call
     * param :- { string }  $init (from which page been called)
     * Return : view of the page along with pagination
     */
    public function ajaxCall($init = ''){
        $pageName = $init;
        // set session for pagination within selected category
        if($this->input->post('dataId') && $this->input->post('dataId') != '-1')
            $this->session->set_userdata('filter' , $this->input->post('dataId') );
        elseif($this->input->post('dataId') == '-1')
            $this->session->unset_userdata('filter');
        // prepare data for sorting
        $sortData['sortCol'] = ($this->input->post('sortcolumn')) ? $this->input->post('sortcolumn') : '';
        $sortData['orderBy'] = ($this->input->post('orderby')) ? $this->input->post('orderby') : '';
        $sortData = ($sortData['sortCol'] != '') ? $sortData : '';
        // prepare data for category
        if($this->session->userdata('filter') && !empty($this->session->userdata('filter'))){
            $like = array('categoryId' => $this->session->userdata('filter'));
            $orLike1 = $this->session->userdata('filter')."," ;
            $orLike = array('categoryId' =>  $orLike1);
        }
        else{
           $orLike = $like = '';
        }
        // data for course id in class
        if(!empty($init) && $init == 'classes'):
            $cid = $this->session->userdata('courseId');
            $courseCol = "courseId";
        else:
           $courseCol = $cid = '';
        endif;
             
        // count rows
        $noOfRows = $this->logicalexpert_model->countRows($pageName , $courseCol , $cid , $like , $orLike );
        $this->paginationInitialize($noOfRows , $init);
        
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $joinData = array('users' => 'users.userId = '.$pageName.'.createdBy');
        $data = $this->logicalexpert_model->getAllData($pageName,$courseCol,$cid,'',  $this->perPage,$offset ,$sortData , $joinData , '' , '' , $like , $orLike );
        $this->data['listData'] = $data;
        $this->data['pageLink'] = $pageName;
        $this->data['links'] = $this->pagination->create_links();
        echo $this->load->view('front/v_'.$pageName.'Table' , $this->data , TRUE);
    }
    /*
     * function used to initilize the pagination
     * * param :- { string }  $init (from which page been called)
     * @param :- $noOfRows : Total no of records
     */
    public function paginationInitialize($noOfRows , $init = ''){
        $init = ($init != '') ? '/'.$init : '';
        $segment = ($this->uri->segment(1) == 'pages') ? 2 : 3;
        // pagination start
        $this->load->library('pagination');
        $config = array();
        $config['base_url'] = base_url().'ajaxCall' . $init;
        $config['total_rows'] = $noOfRows;
        $config['per_page'] = $this->perPage;
        $config['uri_segment'] = $segment ;
        $config['last_link'] = '<span class="lastLink">Last ›</span>';
        $config['first_link'] = '<span class="firstLink">‹ First</span>';
        $config['next_link'] = '<span class="nextLink">&gt;</span>';
        $config['prev_link'] = '<span class="prevLink">&lt;</span>';
        $this->pagination->initialize($config);
        // pagination End
    }
    public function view($viewName , $viewId){
        $columns = '';
        $joinData = '';
        switch ($viewName){
            case 'courses' :
                $whereCondition = array('courseId' => $viewId);
                break;
            case 'classes' : 
                $whereCondition = array('classId' => $viewId );
                $joinData = array('users as us' => 'us.userId = tb.createdBy ' , 'courses as co' => 'co.courseId = tb.courseId');
                $columns = array('tb.className' , 'tb.startDate' , 'tb.endDate' , 'tb.duration' , 'tb.time' , 'tb.price' , 'tb.paymentType' , 'co.courseName' , 'us.userName' );
                break;
        }
            $return = $this->logicalexpert_model->getSingleData($viewName .' as tb', $whereCondition , '' , $joinData , $columns );
            if($return == '' || empty($return)){
                echo "No Data Found";
                exit();
            }
            $this->data['singleData'] = $return[0];
            echo $this->load->view('front/v_'.$viewName.'Detail', $this->data , TRUE);
            exit();
    }
    
}