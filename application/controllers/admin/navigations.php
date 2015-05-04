<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Navigations extends CI_Controller {
    public $counter = 1;
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
        $this->load->helper('text');
    }
    /*
     * categories listing page
     */   
    public function index(){
        // load sidebar and header
        $this->load->view('admin/templates/sidebar.php');
        $this->load->view('admin/templates/header.php');
        $data['js'] = "<script src=".URL."assets/admin/js/jquery.nestable.js></script>";
        $sort = array('sortCol' => 'position','orderBy' => 'asc');
        $whereCondition = array('status' => 1);
        $data['userData'] = $this->logicalexpert_model->getAllData('pages','status','1','','','',$sort,'','',array('pageId','handle' , 'title' , 'parentId', 'position'));
        $data['heading'] = 'Navigations';
        $this->load->view('admin/navigation' , $data);
    }
    /*
     * ajax handler for navigation
     */
    public function changeMenu(){
        $array = JSON_decode($this->input->post('menu'));
        $this->recursionLoop($array);
        exit;
    }
    /*
     * recursive loop function to update menu
     * @param {array} menus
     * @param {integer} ids
     * @returns {recursive}
    */
    public function recursionLoop($menus , $ids=0)
    {
        $col = 'pageId';
        foreach ($menus as $menu ){
            $val = $menu->id;
            //echo "parent = $ids and child = $menu->id<br>";
            $data = array('parentId' => $ids , 'position' => $this->counter++);
            if(isset($menu->children) || !empty($menu->children)  ){
                $ret = $this->logicalexpert_model->updateData('pages' ,$data ,$col , $val);
                $this->recursionLoop($menu->children , $menu->id );
            }
            
        }    
    }
}