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


    public function PatientList(){
      $header['title'] = "HIS: Patient Vital signs";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      if(empty($this->input->post('keyword'))){
          $data['patients'] = $this -> Model_nurse -> fetchAllPatientByCategory();
      }else{
        $data['patients'] = $this -> Model_nurse -> searchPatientByLastName($this->input->post('keyword'));
      }
      $this->load->view('nurse/includes/header.php', $header);
      $this->load->view('nurse/patientlist.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    public function vitalshistory(){
      $header['title'] = "HIS: Patient Vital signs";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['vitalsign_data'] = $this->Model_nurse->get_vital_sign($this->uri->segment(3));
      $this->load->view('nurse/includes/header.php', $header);
      $this->load->view('nurse/vitalshistory.php', $data);
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
      $this->load->view('nurse/admittinghistory.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    public function laboratoryhistory(){
      $header['title'] = "HIS: Patient Laboratory History";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['laboratory_data'] = $this->Model_nurse->get_laboratory_data($this->uri->segment(3));
      $this->load->view('nurse/includes/header.php', $header);
      $this->load->view('nurse/laboratoryhistory.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    public function radiologyhistory(){
      $header['title'] = "HIS: Patient Radiology History";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['radiology_data'] = $this->Model_nurse->get_radiology_data($this->uri->segment(3));
      $this->load->view('nurse/includes/header.php', $header);
      $this->load->view('nurse/radiologyhistory.php', $data);
      $this->load->view('nurse/includes/footer.php');
    }

    public function pharmacyhistory(){
      $header['title'] = "HIS: Patient Pharmacy History";
      $header['tasks'] = $this->Model_nurse->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_nurse->get_permissions($this->session->userdata('type_id'));
      $data['pharmacy_data'] = $this->Model_nurse->get_pharmacy_data($this->uri->segment(3));
      $this->load->view('nurse/includes/header.php', $header);
      $this->load->view('nurse/pharmacyhistory.php', $data);
      //$this->load->view('nurse/includes/footer.php');
    }


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






}


?>
