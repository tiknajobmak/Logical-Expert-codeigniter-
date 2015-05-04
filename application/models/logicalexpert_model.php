<?php
class LogicalExpert_model extends CI_Model {
    
    function __construct() {
        $this->load->database(); // load databse library in constructor
    }
    /*
     * check for login
     * @param {string} $tableName
     * @param {string} $data
     * @param {array} $userTypeArr
     * @returns {array}
     */
    public function getUser( $tableName = '' , $data = '' , $userTypeArr ) {
        $this->db->select('*');
        $this->db->from($tableName);
        $this -> db -> where("(userName = '".$data['username']."'OR userEmail = '".$data['username']."')");
        $this -> db -> where('userPass', $data['password']);
        $this -> db -> where('userStatus', 1);
        // check user type
        $this -> db ->where_in('userType',$userTypeArr );
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result_array();
    }
    /*
     * fetch all records
     * @param {string} $tableName
     * @param {string} $whereCol
     * @param {string} $whereVal
     * @param {string} $type (array/object)
     * @param {string} $limit (number of records in one time)
     * @param {string} $offset (start record)
     * @param {array} $sortData
     * @param {array} $join ( Data to join tables )
     * @param {array} $joinType
     * @param {array} $colName ( column to fetch )
     * @returns {array/object}
     */
    public function getAllData($tableName , $whereCol='' , $whereVal='' , $type = 'array' , $limit='' , $offset='' , $sortData = '' , $join = '' , $joinType = 'left' , $colName='' , $like = 0 , $orLike = 0){
        if($colName != '')
            $this->db->select($colName);
        $this->db->from($tableName);
        if($join != ''){
            foreach ($join as $tbName => $condition){
                $this->db->join($tbName, $condition , 'left');
            }
        }
        if($limit!='')
            $this->db->limit($limit,$offset);
        if($whereCol != '')
            $this -> db ->where($whereCol,$whereVal);
        if($sortData != '')
            $this->db->order_by($sortData['sortCol'], $sortData['orderBy']);
        if($like != 0)
            $this->db->like($like);
        if($orLike != 0){
            foreach ($orLike as $col => $cond){
                $this->db->or_like($col , $cond);
            }
        }
        
        $query = $this->db->get();
        //echo $this->print_query();
        //exit;
        return ($type == 'object') ? $query->result() : $query->result_array();
    }
    
    /*
     * fetch single record
     * @param {string} $tableName
     * @param {string} $whereCondition
     * @param {string} $type (array/object)
     * @param {array} $join ( Data to join tables )
     * @returns {array/object}
     */
    public function getSingleData($tableName , $whereCondition , $type = "array" , $join = '' , $colName = ''){
        if($colName != '')
            $this->db->select($colName);
        $this->db->from($tableName);
        if($join != ''){
            foreach ($join as $tbName => $condition){
                $this->db->join($tbName, $condition);
            }
        }
        $this->db->where($whereCondition);
        $query = $this->db->get();     
        return ($type == 'object') ? $query->result() : $query->result_array();
    }
    /*
     * Insert record
     * @param {string} $tableName
     * @param {array} $data
     * @returns {array/object}
     */
    public function insertData($tableName , $data){
        return $this->db->insert($tableName , $data); 
    }
    /*
     * update record
     * @param {string} $tableName
     * @param {array} $data
     * @param {string} $updateIdCol
     * @param {string} $updateIdVal
     * @returns {int}
     */
    public function updateData($tableName , $data ,$updateIdCol, $updateIdVal){
        $this->db->where($updateIdCol , $updateIdVal );
        $this->db->update($tableName, $data); 
        return $this->db->affected_rows();
    }
    /*
     * delete record
     * @param {string} $tableName
     * @param {string} $whereCol
     * @param {string} $whereVal
     * @returns {int}
     */
    public function deleteData($tableName , $whereCol='' , $whereVal='') {
        $this->db->delete($tableName, array($whereCol => $whereVal));
        return $this->db->affected_rows();
    }
    /*
     * delete multiple records
     * @param {string} $tableName
     * @param {string} $whereCol
     * @param {string} $whereVal
     * @returns {int}
     */
    public function deleteMultiple($tableName , $whereCol='' , $whereVal=''){
        $this->db->where_in($whereCol,$whereVal);
        $this->db->delete($tableName);
        return $this->db->affected_rows();
    }
    /*
     * Count number of rows
     * @param {string} $tableName
     * @param {string} $whereCol
     * @param {string} $whereVal
     * @returns {int}
     */
    public function countRows($tableName , $whereCol='' , $whereVal='' , $like = 0 , $orLike = 0){
        $this->db->select ( 'COUNT(*) AS `numrows`' );
        if($whereCol != '')
            $this->db->where ( array ( $whereCol => $whereVal ) );
        if($like != 0)
            $this->db->like($like);
        if($orLike != 0){
            foreach ($orLike as $col => $cond){
                $this->db->or_like($col , $cond);
            }
        }
        $query = $this->db->get ($tableName);
        return $query->row ()->numrows;
    }
    public function add_record($data,$tablename) {
        $this->db->insert($tablename, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    public function update_record($upd_id,$upd_val,$data,$tablename) {
        $this->db->where($upd_id, $upd_val);
        return $this->db->update($tablename, $data);         
    }
    public function del_record($data,$tablename) {
       return $this->db->delete($tablename, $data);       
    }
    public function del_multiple_record($data,$tablename,$whr_id) {
       $arr= json_decode($data);
       $this->db->where_in($whr_id,$arr);
       return $this->db->delete($tablename);
    }
    public function list_records($tablename,$type = 'array',$limit='',$start='',$where_id='',$whr_val='',$opr='') {
        $this->db->select('*');
        $this->db->from($tablename . ' AS cf');  
        if($limit!=''){
            $this->db->limit($limit,$start);
        }         
        if($where_id!='')
        {
          if($opr=='in')
            $this->db->where_in($where_id,$whr_val);
          else
            $this->db->where($where_id,$whr_val);
        }
        $query = $this->db->get();           
        return ($type == 'object') ? $query->result() : $query->result_array();
    }
    public function list_records_multi_tables($tablename,$fetch_column,$limit_arr=array(),$where_arr=array(),$joins_arr=array(),$where_like_arr=array()) {
       
        $fetch_column=(isset($fetch_column)&&!empty($fetch_column))?$fetch_column:'*'; 
        $this->db->select($fetch_column);
        $this->db->from($tablename);                      
        if(!empty($joins_arr))
        {
         foreach($joins_arr as $join){
            if(!empty($join->join_alias)) 
                $this->db->join($join->join_table.' '.$join->join_alias,$join->join_alias.'.'.$join->join_id .'='. $join->join_whr_table.'.'.$join->join_whr_id , $join->join_type);
            else
                $this->db->join($join->join_table,$join->join_table.'.'.$join->join_id .'='. $join->join_whr_table.'.'.$join->join_whr_id , $join->join_type);
         }
        }
        if(!empty($limit_arr)){
            $this->db->limit($limit_arr['limit'],$limit_arr['start']);
        }
        if(!empty($where_arr))
        {
            $this->db->where($tablename.'.'.$where_arr['whr_id'],$where_arr['whr_val']);           
        } 
         if(!empty($where_like_arr))
         {
            $like_id=$where_like_arr['whr_id_like'];
            $like_val=$where_like_arr['whr_val_like'];
            if($where_like_arr['whr_like_section']=='segment') 
            $this->db->where('(tbSegment.segment_pick_location LIKE \'%"'.$like_id.'":"'.$like_val.'"%\' or tbSegment.segment_drop_location LIKE \'%"'.$like_id.'":"'.$like_val.'"%\')');
         }
        $query = $this->db->get();           
        // return $this->db->last_query();
        return $query->result_array();
    }
    public function cust_select_query($cust_query){
        $query = $this->db->query($cust_query);                  
        // return $this->db->last_query();
        return $query->result_array(); 
    }
    public function count_records($tablename,$where_id='',$whr_val='',$where_like_arr=array()) {
           
        if($where_id!='')
        {          
            $query = $this->db->where($where_id,$whr_val)->get($tablename);
            if(!empty($where_like_arr))
            {
                $like_id=$where_like_arr['whr_id_like'];
                $like_val=$where_like_arr['whr_val_like'];
                if($where_like_arr['whr_like_section']=='segment') 
                $this->db->where('(tbSegment.segment_pick_location LIKE \'%"'.$like_id.'":"'.$like_val.'"%\' or tbSegment.segment_drop_location LIKE \'%"'.$like_id.'":"'.$like_val.'"%\')');            
            }
            return $query->num_rows(); 
        }
        else if(!empty($where_like_arr))
        {            
           $like_id=$where_like_arr['whr_id_like'];
           $like_val=$where_like_arr['whr_val_like'];
           if($where_like_arr['whr_like_section']=='segment') 
           $query= $this->db->where('(tbSegment.segment_pick_location LIKE \'%"'.$like_id.'":"'.$like_val.'"%\' or tbSegment.segment_drop_location LIKE \'%"'.$like_id.'":"'.$like_val.'"%\')')->get($tablename);            
           return $query->num_rows(); 
        }
        return $this->db->count_all($tablename);
    }
    public function loginModal($eml,$pwd) {
        
        $this->db->trans_start();
        $this->db->query("call spLogin('$eml','$pwd',@ret)");
        $exqry= $this->db->last_query();
        $query=$this->db->query('select @ret');
        $this->db->trans_complete();
        $result = $query->result_array();
        $ret_result=$result[0]['@ret'];
        $ret=$ret_result;
        return $ret;
    }
    public function print_query()
    {         
        return $this->db->last_query();
    }
    public function last_queries()
    {
        return $this->output->enable_profiler(TRUE);
    }
    public function sendMail($to,$sub,$msg){
        $this->load->library('email');
        $this->email->set_mailtype("html");
        $this->email->from('abc@abc.com', 'Logic Expert Information Mail');
        $this->email->to($to);         
        $this->email->subject($sub);
        $this->email->message($msg);
        return $this->email->send();       
    }
    public function getMultiple($tableName , $condition){
        $this->db->select('title, content, date');
        $this->db->from($tableName);
        $this->db->like($condition);

    }
}