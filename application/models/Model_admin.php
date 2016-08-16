<?php
  if (!defined('BASEPATH'))exit('No direct script access allowed');
  class Model_admin extends CI_Model{

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

	function get_users(){
      $query = $this->db->query("select * from users a
                                 join user_type b on a.type_id = b.type_id");
      return $query->result_array();
    }
	
	function get_user_type(){
      $query = $this->db->query("select * from user_type");
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

    /*Patients*/
    function get_patient_list(){
      $this->db->select('*');
      $this->db->from('patient');
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

    function insertpatient($data){
      $this->db->insert('patient', $data);
    }

    function edit_patient_information($data, $id)
    {
      $this->db->where('patient_id', $id);
      $this->db->update('patient', $data);
      return $id;
    }
    /*Patients*/

    /*Doctors*/
    function get_doctor_list(){
      $this->db->select('*');
      $this->db->from('doctor_information a');
      $this->db->join('users b', 'b.user_id=a.user_id', 'left');
      $this->db->join('doctor_specializations c', 'c.spec_id=a.spec_id', 'left');
      $this->db->where('b.status', 1);
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_single_doctor($id){
      $this->db->select('*');
      $this->db->from('doctor_information a');
      $this->db->join('users b', 'b.user_id=a.user_id', 'left');
      $this->db->join('doctor_specializations c', 'c.spec_id=a.spec_id', 'left');
      $this->db->where('a.user_id', $id);
      $query = $this->db->get();
      return $query->row();
    }

    function get_inactive_doctor_list(){
      $this->db->select('*');
      $this->db->from('doctor_information a');
      $this->db->join('users b', 'b.user_id=a.user_id', 'left');
      $this->db->join('doctor_specializations c', 'c.spec_id=a.spec_id', 'left');
      $this->db->where('b.status', 0);
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_total_doctor_count(){
      $this->db->select('*');
      $this->db->from('doctor_information');
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_active_doctor_count(){
      $this->db->select('*');
      $this->db->from('doctor_information a');
      $this->db->join('users b', 'b.user_id=a.user_id', 'left');
      $this->db->where('b.status', 1);
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_inactive_doctor_count(){
      $this->db->select('*');
      $this->db->from('doctor_information a');
      $this->db->join('users b', 'b.user_id=a.user_id', 'left');
      $this->db->where('b.status', 0);
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_specialty(){
      $this->db->select('*');
      $this->db->from('doctor_specializations');
      $query = $this->db->get();
      return $query->result_array();
    }

    function insert_user($data){
      $this->db->insert('users', $data);
      $this->db->select('*');
      $this->db->from('users');
      $this->db->order_by("user_id", "desc");
      $this->db->limit(1);
      $query = $this->db->get();
      return $query->row();
    }

    function insert_nurse($data){
      $this->db->insert('nurses', $data);
    }

    function update_user($id, $data){
      $this->db->where('user_id', $id);
      $this->db->update('users', $data);
    }

    function insert_doctor_information($doctor_id, $specialty){
      $data = array('user_id'=>$doctor_id, 'spec_id'=>$specialty);
      $this->db->insert('doctor_information', $data);
    }

    function update_doctor_information($id, $specialty){
      $data = array('spec_id'=>$specialty);
      $this->db->where('user_id', $id);
      $this->db->update('doctor_information', $data);
    }
    /*Doctors*/

    /*Nurses*/
    function get_active_nurses_list(){
      $this->db->select('*');
      $this->db->from('users a');
      $this->db->join('user_type b', 'b.type_id=a.type_id', 'left');
      $this->db->group_start();
      $this->db->where('a.type_id', 3);
      $this->db->or_where('a.type_id', 4);
      $this->db->group_end();
      $this->db->where('status', 1);
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_single_nurse($id){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('user_id', $id);
      $query = $this->db->get();
      return $query->row();
    }

    function get_inactive_nurses_list(){
      $this->db->select('*');
      $this->db->from('users a');
      $this->db->join('user_type b', 'b.type_id=a.type_id', 'left');
      $this->db->group_start();
      $this->db->where('a.type_id', 3);
      $this->db->or_where('a.type_id', 4);
      $this->db->group_end();
      $this->db->where('status', 0);
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_total_nurse(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('type_id', 3);
      $this->db->or_where('type_id', 4);
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_active_nurse_manager(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>3, 'status'=>1));
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_inactive_nurse_manager(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>3, 'status'=>0));
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_active_bedside_nurse(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>4, 'status'=>1));
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_inactive_bedside_nurse(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>4, 'status'=>0));
      $query = $this->db->get();
      return $query->num_rows();
    }
    /*Nurses*/

    /*Radiologist*/
    function get_active_radiologists(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>5, 'status'=>1));
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_inactive_radiologists(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>5, 'status'=>0));
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_single_radiologist($id){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('user_id', $id);
      $query = $this->db->get();
      return $query->row();
    }

    function get_total_radiologists(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('type_id', 5);
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_active_radiologists(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>5, 'status'=>1));
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_inactive_radiologists(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>5, 'status'=>0));
      $query = $this->db->get();
      return $query->num_rows();
    }
    /*Radiologist*/

    /*Pharmacist*/
    function get_active_pharmacist(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>6, 'status'=>1));
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_inactive_pharmacist(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>6, 'status'=>0));
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_single_pharmacist($id){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('user_id', $id);
      $query = $this->db->get();
      return $query->row();
    }

    function get_total_pharmacist(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('type_id', 6);
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_active_pharmacist(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>6, 'status'=>1));
      $query = $this->db->get();
      return $query->num_rows();
    }

    function get_total_inactive_pharmacist(){
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where(array('type_id'=>6, 'status'=>0));
      $query = $this->db->get();
      return $query->num_rows();
    }
    /*Pharmacist*/

    /*Room and Bed*/
    function get_roomtype_List()
    {
      $this->db->select('*');
      $this->db->from('room_type');
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_room_type($id)
    {
      $this->db->select('*');
      $this->db->from('room_type');
      $this->db->where('room_type_id',$id);
      $query = $this->db->get();
      return $query->row();
    }

    function get_single_room_type($id){
      $this->db->select('*');
      $this->db->from('rooms');
      $this->db->where('room_id',$id);
      $query = $this->db->get();
      return $query->row();
    }

    function get_room_list()
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

    function get_room_data($id)
    {
      $this->db->select('*');
      $this->db->from('beds a');
      $this->db->join('rooms b', 'b.room_id=a.bed_roomid','left');
      $this->db->join('patient c', 'a.bed_patient=c.patient_id','left');
      $this->db->where('a.bed_roomid',$id);
      $query = $this->db->get();
      return $query->result_array();
    }

    function insertroomtype($data){
      $this->db->insert('room_type', $data);
    }

    function insertroom($data)
    {
      $this->db->insert('rooms',$data);
      $room_id = $this->db->insert_id();
      return $room_id;
    }

    function insertbedsinroom($data){
      $this->db->insert('beds',$data);
    }

    function removebed($id){
      $this->db->where('bed_id',$id);
      $this->db->delete('beds');
    }

    function updateroom($data, $id){
      $this->db->where('room_id',$id);
      $this->db->update('rooms',$data);
    }

    function updateroomtype($data,$id){
      $this->db->where('room_type_id', $id);
      $this->db->update('room_type', $data);
    }




    /*Admitting*/
    function get_available_beds_from_emergency_room(){
      $this->db->select('*');
      $this->db->from('beds a');
      $this->db->join('rooms b', 'b.room_id=a.bed_roomid', 'left');
      $this->db->join('room_type c', 'b.room_id=c.room_type_id', 'left');
      $this->db->join('patient d', 'd.patient_id=a.bed_patient', 'left');
      $this->db->where('b.room_type', 1);
      $this->db->where('a.bed_patient', NULL);
      $query = $this->db->get();
      return $query->result_array();
    }

    function insert_patient_to_beds($data, $bedid){
      $this->db->where('bed_id', $bedid);
      $this->db->update('beds', $data);
    }

    function insert_admission_schedule($data){
      $this->db->insert('admission_schedule', $data);
    }

    function insert_admitting_resident($data){
      $this->db->insert('admitting_resident', $data);
    }

    function get_non_admitted_patient_list(){
      $this->db->select('*');
      $this->db->from('patient');
      $this->db->where('patient_status', 0);
      $query = $this->db->get();
      return $query->result_array();
    }

    function update_patient_status($data, $patientid){
      $this->db->where('patient_id', $patientid);
      $this->db->update('patient', $data);
    }

    function dischargepatient($data, $patientid){
      $this->db->where('patient_id', $patientid);
      $this->db->update('admission_schedule', $data);
    }

    function removepatient_from_bed($data, $bed_id){
      $this->db->where('bed_id', $bed_id);
      $this->db->update('beds', $data);
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

    function remove_patient_from_bed($data, $patientid){
      $this->db->where('bed_patient', $patientid);
      $this->db->update('beds', $data);
    }

    function transfer_patient_to_new_bed($data, $bedid){
      $this->db->where('bed_id', $bedid);
      $this->db->update('beds', $data);
    }
    /*Admitting*/

    function activate($id){
      $data = array('status'=>1);
      $this->db->where('user_id', $id);
      $this->db->update('users', $data);
    }

    function deactivate($id){
      $data = array('status'=>0);
      $this->db->where('user_id', $id);
      $this->db->update('users', $data);
    }

    /* Laboratory Request*/
    function get_laboratoryrequest_list()
    {
      $this->db->select('*');
      $this->db->from('laboratory_request');
      $this->db->join('patient','laboratory_request.lab_patient=patient.patient_id','left');
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_laboratorytopatient_data($id)
    {
      $this->db->select('*');
      $this->db->from('laboratory_request');
      $this->db->join('patient','laboratory_request.lab_patient=patient.patient_id','left');
      $query = $this->db->get();
      return $query->row();
    }

    function get_laboratorytouser_data($id)
    {
      $this->db->select('*');
      $this->db->from('laboratory_request');
      $this->db->join('users', 'laboratory_request.user_id_fk=users.user_id', 'left');
      $query = $this->db->get();
      return $query->row();
    }

    function get_laboratorytorequest_data($id)
    {
      $this->db->select('*');
      $this->db->from('laboratory_request a');
      $this->db->join('urgency_cat u', 'a.urgency_cat_fk=u.urg_id','left');
      $this->db->join('fasting_cat f', 'a.fasting_cat_fk=f.fast_id', 'left');
      $this->db->join('laboratory_examination_type l', 'a.exam_type_fk=l.lab_exam_type_id', 'left');
      $this->db->join('examination_category e', 'l.lab_exam_type_category_id=e.exam_cat_id', 'left');
      $query = $this->db->get();
      return $query->row();
    }

    function get_laboratorytospecimen_data($id)
    {
      $this->db->select('*');
      $this->db->from('lab_specimen_request a');
      $this->db->join('laboratory_specimens l', 'a.specimen_id=l.specimen_id', 'left');
      $this->db->where('lab_req_id',$id);
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_laboratorytoremarks_data($id)
    {
      $this->db->select('*');
      $this->db->from('lab_request_remarks');
      $this->db->where('lab_id_fk',$id);
      $query = $this->db->get();
      return $query->row();
    }

    function approvelabreq($id,$data)
    {
      $this->db->where('lab_id',$id);
      $this->db->update('laboratory_request',$data);
    }

    function get_accepted_labreq()
    {
      $this->db->select('*');
      $this->db->from('laboratory_request a');
      $this->db->join('patient b', 'a.lab_patient=b.patient_id','left');
      $this->db->where('lab_status',2);
      $query = $this->db->get();
      return $query->result_array();
    }

    function cancellabreq($id,$data)
    {
      $this->db->where('lab_id',$id);
      $this->db->update('laboratory_request',$data);
    }

    function get_rejected_labreq()
    {
      $this->db->select('*');
      $this->db->from('laboratory_request a');
      $this->db->join('patient b', 'a.lab_patient=b.patient_id','left');
      $this->db->where('lab_status',3);
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_all_examcateg()
    {
      $this->db->select('*');
      $this->db->from('examination_category');
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_examcateg($id)
    {
        $this->db->select('*');
        $this->db->from('examination_category');
        $this->db->where('exam_cat_id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    function insertcategory($data)
    {
      $this->db->insert('examination_category',$data);
    }

    function updatecategory($id,$data)
    {
      $this->db->where('exam_cat_id',$id);
      $this->db->update('examination_category',$data);
    }

    function get_all_examtype(){
      $this->db->select('*');
      $this->db->from('laboratory_examination_type');
      $this->db->join('examination_category','laboratory_examination_type.lab_exam_type_category_id=examination_category.exam_cat_id','left');
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_specific_examtype($id){
      $this->db->select('*');
      $this->db->from('laboratory_examination_type');
      $this->db->where('lab_exam_type_id',$id);
      $query = $this->db->get();
      return $query->row();
    }

    function insertexamtype($data)
    {
      $this->db->insert('laboratory_examination_type',$data);
    }

    function updateexamtype($id,$data)
    {
      $this->db->where('lab_exam_type_id',$id);
      $this->db->update('laboratory_examination_type',$data);
    }

    function get_all_labspec()
    {
      $this->db->select('*');
      $this->db->from('laboratory_specimens');
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_specific_specimen($id)
    {
      $this->db->select('*');
      $this->db->from('laboratory_specimens');
      $this->db->where('specimen_id',$id);
      $query = $this->db->get();
      return $query->row();
    }

    function insertspecimen($data)
    {
      $this->db->insert('laboratory_specimens',$data);
    }

    function updatespecimen($id,$data)
    {
      $this->db->where('specimen_id',$id);
      $this->db->update('laboratory_specimens',$data);
    }

    function get_all_urgencycategory()
    {
      $this->db->select('*');
      $this->db->from('urgency_cat');
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_all_fastingcategory()
    {
      $this->db->select('*');
      $this->db->from('fasting_cat');
      $query = $this->db->get();
      return $query->result_array();
    }

    function insertlaboratoryrequest($data1){
      $this->db->insert('laboratory_request',$data1);
      $labid = $this->db->insert_id();
      return $labid;
    }

    function insertrequestspecimen($data2){
      $this->db->insert('lab_specimen_request',$data2);
    }

    function insertrequestremark($data3){
      $this->db->insert('lab_request_remarks',$data3);
    }
    /* CSR */
    function get_csr_inventory()
    {
      $this->db->select('*');
      $this->db->from('csr_inventory');
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_stockname($id)
    {
      $this->db->select('*');
      $this->db->from('csr_inventory');
      $this->db->where('csr_id',$id);
      $query = $this->db->get();
      return $query->row('item_name');
    }

    function reqtypenewproduct()
    {
    $this->db->select('*');
    $this->db->from('purchase_req_type');
    $this->db->where('pur_name','New Product');
    $query = $this->db->get();
    return $query->row('pur_req_id');
    }

    function reqtyperestock()
    {
    $this->db->select('*');
    $this->db->from('purchase_req_type');
    $this->db->where('pur_name','Restock');
    $query = $this->db->get();
    return $query->row('pur_req_id');
    }

    function requestproduct($data)
    {
      $this->db->insert('purchasing_csr',$data);
    }

    function restockproduct($data)
    {
      $this->db->insert('purchasing_csr',$data);
    }

    function restockdata($id)
    {
      $this->db->select('*');
      $this->db->from('csr_inventory');
      $this->db->where('csr_id',$id);
      $query = $this->db->get();
      return $query->row();
    }

    function get_nurse_requests()
    {
      $this->db->select('*');
      $this->db->from('csr_request');
      $this->db->where('csr_status',0);
      $this->db->where('csr_status',2);
      $query = $this->db->get();
      return $query->result_array();
    }

    /* Purchasing */
    function get_csr_requests()
    {
      $this->db->select('*');
      $this->db->from('purchasing_csr a');
      $this->db->join('users u','a.requester_id=u.user_id','left');
      $this->db->join('purchase_req_type p', 'a.request_type=p.pur_req_id', 'left');
      $query = $this->db->get();
      return $query->result_array();
    }

    function get_request_data($id)
    {
      $this->db->select('*');
      $this->db->from('purchasing_csr');
      $this->db->where('purchase_id',$id);
      $query = $this->db->get();
      return $query->row();
    }

    function get_request_type($id)
    {
      $this->db->select('*');
      $this->db->from('purchasing_csr');
      $this->db->where('purchase_id',$id);
      $query = $this->db->get();
      return $query->row('request_type');
    }

    function change_pur_status($id,$newstat)
    {
      $this->db->where('purchase_id',$id);
      $this->db->update('purchasing_csr',$newstat);
    }

    function insertnewcsrproduct($data)
    {
      $this->db->insert('csr_inventory',$data);
    }

    function get_csr_stock($id)
    {
      $this->db->select('*');
      $this->db->from('csr_inventory');
      $this->db->where('csr_id',$id);
      $query = $this->db->get();
      return $query->row('item_stock');
    }

    function restockcsrproduct($id,$data)
    {
      $this->db->where('csr_id',$id);
      $this->db->update('csr_inventory',$data);
    }

    function get_acceptedcsr_requests()
    {
      $this->db->select('*');
      $this->db->from('purchasing_csr a');
      $this->db->join('users u','a.requester_id=u.user_id','left');
      $this->db->join('purchase_req_type p', 'a.request_type=p.pur_req_id', 'left');
      $this->db->where('pur_stat',1);
      $query = $this->db->get();
      return $query->result_array();
    }
    function get_rejectedcsr_requests()
    {
      $this->db->select('*');
      $this->db->from('purchasing_csr a');
      $this->db->join('users u','a.requester_id=u.user_id','left');
      $this->db->join('purchase_req_type p', 'a.request_type=p.pur_req_id', 'left');
      $this->db->where('pur_stat',2);
      $query = $this->db->get();
      return $query->result_array();
    }

    function fetch_tasks()
    {
      $this->db->select('*');
      $this->db->from('task');
      $query = $this->db->get();
      return $query->result_array();

    }

    function get_usertypes()
    {
      $this->db->select('*');
      $this->db->from('user_type');
      $query = $this->db->get();
      return $query->result_array();
    }

    function fetch_permissions()
    {
      $this->db->select('*');
      $this->db->from('permission');
      $query = $this->db->get();
      return $query->result_array();
    }

    function insertRole($data)
    {
      $sql = $this->db->insert('user_type', $data);
        if($sql){
          return true;
        }else{
          return false;
        }
    }

    function fetchPermittedViews()
    {
      $this->db->select('*');
      $this->db->from('permission_usertype');
      $query = $this->db->get();
      return $query->result_array();
    }

    function getTaskIdforPermission($id)
    {
        $this->db->select('task_id');
        $this->db->from('permission');
        $this->db->where('permission_id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function checkExistingTaskUserType($taskId,$userTypeId)
    {
      $this->db->select('task_usertype_id');
      $this->db->from('task_usertype');
      $this->db->where('task_id', $taskId);
      $this->db->where('user_type_id', $userTypeId);
      $query = $this->db->get();

          if($query->num_rows() > 0){
              return false;
          }else{
              return true;
          }



    }

    function deleteAllUserTypeById($id)
    {
      $this->db->where('user_type_id',$id);
      $this->db->delete('permission_usertype');
    }
    function deleteAllTaskUserTypeById($id)
    {
      $this->db->where('user_type_id',$id);
      $this->db->delete('task_usertype');
    }

    function insertPermissionUserType($permissionArrays)
    {

        foreach ($permissionArrays as $permissionArray => $value) {
            $data = array(
              'user_type_id' => $this->input->post('hiddenUserTypeId'),
              'permission_id' => $value,
              'access' => 1

            );
          $sql =  $this->db->insert('permission_usertype', $data);

            $taskId = $this->Model_admin->getTaskIdforPermission($value);
            $newTaskId = "";
            foreach ($taskId as $taskID) {
                $newTaskId = $taskID['task_id'];
            }

            $var = array(
              'task_id' => $newTaskId,
              'user_type_id' => $this->input->post('hiddenUserTypeId')
            );
                if($this->Model_admin->checkExistingTaskUserType($newTaskId, $this->input->post('hiddenUserTypeId'))){
                    $sqlquery = $this->db->insert('task_usertype', $var);
                }


        }
    }


  }
?>
