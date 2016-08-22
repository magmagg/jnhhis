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

    function get_total_patient_count(){
      $this->db->select('*');
      $this->db->from('patient');
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_count_admitted_patient(){
      $this->db->select('*');
      $this->db->from('patient');
      $this->db->where('patient_status !=', 0);
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_count_patient_admitted_in_er(){
      $this->db->select('*');
      $this->db->from('patient');
      $this->db->where('patient_status ', 1);
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_single_patient($id){
      $this->db->select('*');
      $this->db->from('patient');
      $this->db->where('patient_id', $id);
      $query = $this->db->get();
      return $query->row();
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

      /*Admitting*/
      public function get_available_beds_from_emergency_room(){
        $this->db->select('*');
        $this->db->from('beds b');
        $this->db->join('rooms r', 'r.room_id=b.bed_roomid', 'left');
        $this->db->join('room_type rt', 'r.room_id=rt.room_type_id', 'left');
        $this->db->join('patient p', 'p.patient_id=b.bed_patient', 'left');
        $this->db->where('r.room_type', 1);
        $this->db->where('b.bed_patient', NULL);
        $query = $this->db->get();
        return $query->result_array();
      }

      public function get_non_admitted_patient_list(){
        $this->db->select('*');
        $this->db->from('patient');
        $this->db->where('patient_status', 0);
        $query = $this->db->get();
        return $query->result_array();
      }

      public function admit_patient($data_bedstable, $data_admission_schedule, $data_admitting_resident, $data_update_patient_status, $bed_id, $patient){
        $this->db->where('bed_id', $bed_id);
        $this->db->update('beds', $data_bedstable);

        $this->db->insert('admission_schedule', $data_admission_schedule);

        $this->db->insert('admitting_resident', $data_admitting_resident);

        $this->db->where('patient_id', $patient);
        $this->db->update('patient', $data_update_patient_status);
      }

      public function get_room_list()
      {
        $this->db->select('*');
        $this->db->from('rooms a');
        $this->db->join('room_type b', 'a.room_type=b.room_type_id', 'left');
        $this->db->join('occupancy c', 'a.occupancy_status=c.occupancy_status_id', 'left');
        $this->db->join('maintenance d', 'a.maintenance_status=d.maintenance_status_id', 'left');
        $this->db->order_by('a.room_id','asc');
        $query = $this->db->get();
        return $query->result_array();
      }

      function get_admitted_patient($id){
        $this->db->select('*');
        $this->db->from('beds a');
        $this->db->join('rooms b', 'a.bed_roomid=b.room_id', 'left');
        $this->db->join('patient c', 'a.bed_patient=c.patient_id', 'left');
        $this->db->where('a.bed_patient !=', NULL);
        $this->db->where('a.bed_roomid', $id);
        $query = $this->db->get();
        return $query->result_array();
      }

      function dischargepatient($data_discharge, $data_update_bed, $data_update_patient, $patient_id, $bed_id){
        $this->db->where('patient_id', $patient_id);
        $this->db->update('patient', $data_update_patient);

        $this->db->where('patient_id', $patient_id);
        $this->db->update('admission_schedule', $data_discharge);

        $this->db->where('bed_id', $bed_id);
        $this->db->update('beds', $data_update_bed);
      }

      function get_room_list_for_directadmission(){
        $this->db->select('*');
        $this->db->from('rooms a');
        $this->db->join('room_type b', 'a.room_type=b.room_type_id', 'left');
        $this->db->where('a.room_type !=', 1);
        $query = $this->db->get();
        return $query->result_array();
      }

      function get_available_beds_for_directadmission($id){
        $this->db->select('*');
        $this->db->from('beds a');
        $this->db->join('rooms b', 'b.room_id=a.bed_roomid', 'left');
        $this->db->join('room_type c', 'b.room_id=c.room_type_id', 'left');
        $this->db->join('patient d', 'd.patient_id=a.bed_patient', 'left');
        $this->db->where('b.room_type', $id);
        $this->db->where('a.bed_patient', NULL);
        $query = $this->db->get();
        return $query->result_array();
      }

      function transfer_patient($data_remove_patient_from_prev_bed, $data_transfer_patient_to_new_bed, $update_patient_status, $bedid, $patientid){
        $this->db->where('bed_patient', $patientid);
        $this->db->update('beds', $data_remove_patient_from_prev_bed);

        $this->db->where('bed_id', $bedid);
        $this->db->update('beds', $data_transfer_patient_to_new_bed);

        $this->db->where('patient_id', $patientid);
        $this->db->update('patient', $update_patient_status);
      }
      /*Admitting*/

}

?>
