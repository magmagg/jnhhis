<?php
  if (!defined('BASEPATH'))exit('No direct script access allowed');
  class Model_nurse extends CI_Model{


    /*TESTINGS*/
    function get_tasks($type_id)
    {
      $this->db->select('*');
      $this->db->from('task_usertype tu');
      $this->db->join('task t','tu.task_id=t.task_id','left');
      $this->db->where('user_type_id',$type_id);
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_permissions($type_id)
    {
      $where = "user_type_id ='$type_id' and access='1'";
      $this->db->select('*');
      $this->db->from('permission_usertype pu');
      $this->db->join('permission p','pu.permission_id=p.permission_id','left');
      $this->db->where($where);
      $query = $this->db->get();
      return $query->result_array();
    }




      public function fetchAllPatientByCategory(){

        //not complete yet need i join to
          $this -> db ->select('*');
          $this -> db ->from('patient');

          $query = $this->db->get();
          return $query->result_array();

      }

      public function searchPatientByLastName($keyword){
          //not complete yet need i join to
          $this -> db ->select('*');
          $this -> db ->from('patient');
          $this -> db ->like('first_name', $keyword);
          $query = $this->db->get();
          return $query->result_array();

      }

      public function fetchAllCSRItems(){

        $this -> db -> select('*');
        $this -> db -> from('csr_inventory');
        $query = $this->db->get();
        return $query->result_array();

      }


      public function CSRReqAddSingle($data){
        $sql =$this -> db -> insert('csr_request', $data);
          if($sql){
              return true;
          }else{
              return false;
          }
      }

      public function get_vital_sign($id){
        $this->db->select('*');
        $this->db->from('vitals v');
        $this->db->join('users u', 'v.user_id = u.user_id', 'left');
        $this->db->where('v.patient_id', $id);
        $this->db->order_by('date_recorded', 'desc');
        $query = $this->db->get();
        return $query->result_array();
      }

      public function recordvitalsign($data){
        $sql = $this->db->insert('vitals', $data);
        if($sql){
          return true;
        }else{
          return false;
        }
      }

      public  function get_admitting_data($id){
        $this->db->select('*');
        $this->db->from('admission_schedule as');
        $this->db->join('discharge_schedule ds','as.admission_id=ds.admission_id','left');
        $this->db->where('as.patient_id', $id);
        $query = $this->db->get();
        return $query->result_array();
      }

      public  function get_laboratory_data($id){
        $this->db->select('*');
        $this->db->from('laboratory_request lr');
        $this->db->join('laboratory_examination_type let','lr.exam_type_fk = let.lab_exam_type_id','left');
        //$this->db->join('laboratory_examination_type let','lr.exam_type_fk = let.lab_exam_type_id','left');
        $this->db->where('lr.lab_patient', $id);
        $query = $this->db->get();
        return $query->result_array();
      }

      public function get_radiology_data($id){
        $this->db->select('*');
        $this->db->from('radiology_request rr');
        $this->db->join('radiology_exam re', 'rr.exam_id = re.exam_id', 'left');
        $this->db->join('radiology_pat rp', 'rr.request_id = rp.rad_reqid', 'left');
        $this->db->where('rr.patient_id', $id);
        $query = $this->db->get();
        return $query->result_array();
      }

      public function get_pharmacy_data($id){
        $this->db->select('*');
        $this->db->from('pharmacy_request pr');
        $this->db->join('pharmacy_inventory pi', 'pr.phar_item_id = pi.item_id', 'left');
        $this->db->where('pr.phar_patient', $id);
        $query = $this->db->get();
        return $query->result_array();
      }














}

?>
