<?php
  if (!defined('BASEPATH'))exit('No direct script access allowed');
  class Nurse extends CI_Controller{


    function __construct(){
        parent::__construct();
        $this->load->model('Model_nurse');
        // if($this->session->userdata("user_loggedin")==TRUE){
        //   if($this->session->userdata("type_id") == 3){
        //     redirect(base_url()."Nurse", "refresh");
        //   }
        // }else{
        //   redirect(base_url());
        // }
    }

    public function index(){
      $header['title'] = "HIS: Nurse dashboard";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $this->load->view('nurse/includes/header.php',$header);
      $this->load->view('nurse/index.php');
      $this->load->view('nurse/includes/footer.php');
    }
    /*============================================================================================================*/
    public function EmergencyRoom(){
      $header['title'] = "HIS: Emergency Room Admission";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['emergency_room_data'] = $this->Model_nurse->get_available_beds_from_emergency_room();
      $this->load->view('nurse/includes/header.php',$header);
      $this->load->view('nurse/admitting/choose_er_room.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    public function DirectRoomAdmission(){
      $header['title'] = "HIS: Direct Room Admission";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['rooms'] = $this->Model_nurse->get_room_list_for_directadmission();
      $this->load->view('nurse/includes/header.php',$header);
      $this->load->view('nurse/admitting/choose_direct_room.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    function ChooseBed(){
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['beds'] = $this->Model_nurse->get_available_beds_for_directadmission($this->uri->segment(3));
      $this->load->view('nurse/includes/header.php',$header);
      $this->load->view('nurse/admitting/choose_bed.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    function ChoosePatientToDR(){
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['patients'] = $this->Model_nurse->get_non_admitted_patient_list();
      $data['bed_id'] = $this->uri->segment(3);
      $data['roomid'] = $this->uri->segment(4);
      $this->load->view('nurse/includes/header.php',$header);
      $this->load->view('nurse/admitting/choosepatient_to_dr.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }


    public function AdmittedPatients($id = null){
      $header['title'] = "HIS: Admitted Patients";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $this->load->view('nurse/includes/header.php',$header);
      if(empty($id)){
        $data['rooms'] = $this->Model_nurse->get_room_list();
        $this->load->view('nurse/admitting/roomlist.php', $data);
      }else{
        $data['beds'] = $this->Model_nurse->get_admitted_patient($id);
        $this->load->view('nurse/admitting/viewadmittedpatient.php', $data);
      }
      $this->load->view('nurse/includes/footer.php');
    }

    public function ChoosePatient(){
      $header['title'] = "HIS: Choose Patient";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['patients'] = $this->Model_nurse->get_non_admitted_patient_list();
      $data['bed_id'] = $this->uri->segment(3);
      $this->load->view('nurse/includes/header.php',$header);
      $this->load->view('nurse/admitting/choosepatient_to_er.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    function admit_patient_to_ER(){
      $bed_id = $this->uri->segment(3);
      $patient = $this->input->post('patient');
      $data_bedstable = array(
                    "bed_patient"=>$patient
                  );
      $data_admission_schedule = array(
                                        "admission_date"=>date('Y-m-d H:i:s'),
                                        "patient_id"=>$patient,
                                        "status"=>1
                                       );
      $data_admitting_resident = array(
                                        "user_id"=>$this->session->userdata("user_id"),
                                        "patient_id"=>$patient,
                                        "user_id_fk"=>$this->session->userdata("user_id")
                                      );
     $data_update_patient_status = array(
                                          "patient_status"=>1
                                        );

     $sql = $this->Model_nurse->admit_patient($data_bedstable, $data_admission_schedule, $data_admitting_resident, $data_update_patient_status, $bed_id, $patient);
     redirect(base_url().'Nurse/EmergencyRoom', 'refresh');
    }

    function admit_patient_to_dr(){
      $bed_id = $this->uri->segment(3);
      $roomid = $this->uri->segment(4);
      $patient = $this->input->post('patient');
      $data_bedstable = array(
                    "bed_patient"=>$patient
                  );
      $data_admission_schedule = array(
                                        "admission_date"=>date('Y-m-d H:i:s'),
                                        "patient_id"=>$patient,
                                        "status"=>1
                                       );
      $data_admitting_resident = array(
                                        "user_id"=>$this->session->userdata("user_id"),
                                        "patient_id"=>$patient,
                                        "user_id_fk"=>$this->session->userdata("user_id")
                                      );
     $data_update_patient_status = array(
                                          "patient_status"=>2
                                        );
     $sql = $this->Model_nurse->admit_patient($data_bedstable, $data_admission_schedule, $data_admitting_resident, $data_update_patient_status, $bed_id, $patient);
     redirect(base_url().'Nurse/AdmittedPatients/'.$roomid, 'refresh');
    }

    function DischargePatient(){
      $data_discharge = array("status"=>2);
      $data_update_bed = array("bed_patient"=>NULL);
      $data_update_patient = array("patient_status"=>0);
      $this->Model_nurse->dischargepatient($data_discharge, $data_update_bed, $data_update_patient, $this->uri->segment(3), $this->uri->segment(4));
      redirect($this->agent->referrer(), 'refresh');
    }

    function TransferRoom(){
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['rooms'] = $this->Model_nurse->get_room_list_for_directadmission();
      $data['patientid'] = $this->uri->segment(3);
      $this->load->view('nurse/includes/header.php',$header);
      $this->load->view('nurse/admitting/choose_room_to_transfer.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    function ChooseBedToTransfer(){
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['beds'] = $this->Model_nurse->get_available_beds_for_directadmission($this->uri->segment(4));
      $data['patientid'] = $this->uri->segment(3);
      $data['roomid'] = $this->uri->segment(4);
      $this->load->view('nurse/includes/header.php',$header);
      $this->load->view('nurse/admitting/choose_bed_to_transfer.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    function TransferPatient($patientid, $bedid, $roomid){
      $data_remove_patient_from_prev_bed = array("bed_patient"=>NULL);
      $data_transfer_patient_to_new_bed = array("bed_patient"=>$patientid);
      $update_patient_status = array("patient_status"=>2);
      $this->Model_nurse->transfer_patient($data_remove_patient_from_prev_bed, $data_transfer_patient_to_new_bed, $update_patient_status, $bedid, $patientid);
      redirect(base_url().'Nurse/AdmittedPatients/'.$roomid);
    }
    /*============================================================================================================*/

    public function PatientList($id = null){
      $header['title'] = "HIS: Patient Vital signs";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['total_patients_count'] = $this->Model_nurse->get_total_patient_count();
      $data['total_admitted_patients_count'] = $this->Model_nurse->get_count_admitted_patient();
      $data['total_admitted_in_er_count'] = $this->Model_nurse->get_count_patient_admitted_in_er();
      $this->load->view('nurse/includes/header.php', $header);
      if(empty($id)){
        $data['patients'] = $this -> Model_nurse -> fetchAllPatientByCategory();
        $this->load->view('nurse/patientinfo/patientlist.php', $data);
      }else{
        $data['patient'] = $this->Model_nurse->get_single_patient($id);
        $this->load->view('nurse/patientinfo/patientinfo.php', $data);
      }
      //$this->load->view('nurse/includes/footer.php');
    }

    public function vitalshistory(){
      $header['title'] = "HIS: Patient Vital signs";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['vitalsign_data'] = $this->Model_nurse->get_vital_sign($this->uri->segment(3));
      $this->load->view('nurse/includes/header.php', $header);
      $this->load->view('nurse/patientinfo/vitalshistory.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    public function recordvitalsign(){
      $data = array(
                    'heart_rate'=>$this->input->post('heartrate'),
                    'resp_rate'=>$this->input->post('respiratoryrate'),
                    'blood_pres'=>$this->input->post('bloodpressure'),
                    'body_temp'=>$this->input->post('temperature'),
                    'patient_id'=>$this->uri->segment(3),
                    'user_id'=>$this->session->userdata('user_id')
                   );
      $sql = $this->Model_nurse->recordvitalsign($data);
      redirect(base_url().'Nurse/vitalshistory/'.$this->uri->segment(3));
    }

    public function admittinghistory(){
      $header['title'] = "HIS: Patient Admitting History";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['admitting_data'] = $this->Model_nurse->get_admitting_data($this->uri->segment(3));
      $this->load->view('nurse/includes/header.php', $header);
      $this->load->view('nurse/patientinfo/admittinghistory.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    public function laboratoryhistory(){
      $header['title'] = "HIS: Patient Laboratory History";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['laboratory_data'] = $this->Model_nurse->get_laboratory_data($this->uri->segment(3));
      $this->load->view('nurse/includes/header.php', $header);
      $this->load->view('nurse/patientinfo/laboratoryhistory.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    public function radiologyhistory(){
      $header['title'] = "HIS: Patient Radiology History";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['radiology_data'] = $this->Model_nurse->get_radiology_data($this->uri->segment(3));
      $this->load->view('nurse/includes/header.php', $header);
      $this->load->view('nurse/patientinfo/radiologyhistory.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    public function pharmacyhistory(){
      $header['title'] = "HIS: Patient Pharmacy History";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['pharmacy_data'] = $this->Model_nurse->get_pharmacy_data($this->uri->segment(3));
      $this->load->view('nurse/includes/header.php', $header);
      $this->load->view('nurse/patientinfo/pharmacyhistory.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    /*============================================================================================================*/
    public function csr(){
      $data['title'] = "HIS: CSR";
      $data['CSRItems'] = $this -> Model_nurse ->fetchAllCSRItems();
      $this->load->view('nurse/includes/header.php');
      $this->load->view('nurse/csrrequest.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }


    public function csr_singlerequest(){

        $this->form_validation->set_rules('stock','Stock','trim|required|is_natural_no_zero');

          if($this->form_validation->run()){

              $data = array(
                'nurse_id' => $this->session->userdata('user_id'),
                'csr_item_id' => $this->input->post('hiddenItemId'),
                'item_quant' => $this->input->post('stock'),
                'date_created' => date('Y-m-d H:i:s')
              );

              if($this->Model_nurse->CSRReqAddSingle($data)){
                $this->session->set_flashdata("succ", "<div class='alert alert-success' role='alert'> <p align='center'>Request has been sent.</p></div>");

                $this->csr();
              }else{
                $this->csr();
              }

          }else{
              $this->csr();
          }
    }
    /*============================================================================================================*/
}
?>
