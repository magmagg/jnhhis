<?php
  if (!defined('BASEPATH'))exit('No direct script access allowed');
  class Admin extends CI_Controller{
    function __construct(){
      parent::__construct();
      $this->load->model('Model_admin');
      if($this->session->userdata("user_loggedin")==TRUE){
        if($this->session->userdata("type_id") == 5){
          redirect(base_url()."Radiology", "refresh");
        } if($this->session->userdata("type_id") == 11)
        {
          redirect(base_url()."Csr", "refresh");
        }
      }else{
        redirect(base_url());
      }
    }

    function index(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/index.php');
      $this->load->view('administrator/includes/footer.php');
    }
    /*=========================================================================================================================*/

	function User(){
	  $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['users'] = $this->Model_admin->get_users();
      $data['usertypes'] = $this->Model_admin->get_user_type();
      $this->load->view('administrator/includes/header.php', $header);
      $this->load->view('administrator/users', $data);
    }
    function PatientList($id = null){
      if(empty($id)){
        $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
        $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
        $data['patients'] = $this->Model_admin->get_patient_list();
        $data['total_patients_count'] = $this->Model_admin->get_total_patient_count();
        $data['total_admitted_patients_count'] = $this->Model_admin->get_count_admitted_patient();
        $data['total_admitted_in_er_count'] = $this->Model_admin->get_count_patient_admitted_in_er();
        $this->load->view('administrator/includes/header.php',$header);
        $this->load->view('administrator/patient/patientlist.php', $data);
        //$this->load->view('administrator/includes/footer.php');
      }else{
        $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
        $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
        $data['patient'] = $this->Model_admin->get_single_patient($id);
        $data['total_patients_count'] = $this->Model_admin->get_total_patient_count();
        $data['total_admitted_patients_count'] = $this->Model_admin->get_count_admitted_patient();
        $data['total_admitted_in_er_count'] = $this->Model_admin->get_count_patient_admitted_in_er();
        $this->load->view('administrator/includes/header.php',$header);
        $this->load->view('administrator/patient/show_patient.php', $data);
        //$this->load->view('administrator/includes/footer.php');
      }
    }

    function PatientHistory($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['patient'] = $this->Model_admin->get_single_patient($id);
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/patient/list_of_patient_history.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function AddPatient(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/patient/addpatient.php');
      $this->load->view('administrator/includes/footer.php');
    }

    function insert_patient(){
          $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('gender', 'Gender', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('age', 'Age', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('birthday', 'Birthday', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('birthplace', 'Birthplace', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('occupation', 'Occupation', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('religion', 'Religion', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('nationality', 'Nationality', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('address', 'Address', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('telephone_number', 'Telephone number', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('mobile_number', 'Mobile number', 'required|trim|xss_clean|strip_tags');
          $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');

         if($this->form_validation->run() == FALSE){
           echo "may mali";
         }else{
           $data = array(
             'first_name' => $this->input->post('firstname'),
             'last_name' => $this->input->post('lastname'),
             'middle_name' => $this->input->post('middlename'),
             'gender' => $this->input->post('gender'),
             'age' => $this->input->post('age'),
             'birthdate' => $this->input->post('birthday'),
             'birthplace' => $this->input->post('birthplace'),
             'occupation' => $this->input->post('occupation'),
             'religion' => $this->input->post('religion'),
             'nationality' => $this->input->post('nationality'),
             'present_address' => $this->input->post('address'),
             'telephone_number' => $this->input->post('telephone_number'),
             'mobile_number' => $this->input->post('mobile_number'),
             'email' => $this->input->post('email'),
             'patient_status' => "0",
             'date_registered' => date('Y-m-d'),
           );

           $insertpatient = $this->Model_admin->insertpatient($data);
           $url = $this->input->post('url');
           if($url == base_url()."Admin/AddPatient"){
             redirect(base_url().'Admin/PatientList');
           }else{
             redirect(base_url()."Admin/AdmitER");
           }
         }
    }

    function EditPatient($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['patient'] = $this->Model_admin->get_single_patient($id);
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/patient/editpatient.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function edit_patient($id){
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('age', 'Age', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('nationality', 'Nationality', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('mobile_number', 'Mobile', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'Birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthplace', 'Birthplace', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('occupation', 'Occupation', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('religion', 'Religion', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('address', 'Address', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('telephone_number', 'Telephone', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      "last_name"=>$this->input->post('lastname'),
                      "first_name"=>$this->input->post('firstname'),
                      "middle_name"=>$this->input->post('middlename'),
                      "age"=>$this->input->post('age'),
                      "nationality"=>$this->input->post('nationality'),
                      "mobile_number"=>$this->input->post('mobile_number'),
                      "birthdate"=>$this->input->post('birthday'),
                      "birthplace"=>$this->input->post('birthplace'),
                      "occupation"=>$this->input->post('occupation'),
                      "religion"=>$this->input->post('religion'),
                      "present_address"=>$this->input->post('address'),
                      "telephone_number"=>$this->input->post('telephone_number'),
                     );
        $this->Model_admin->edit_patient_information($data, $id);
        redirect(base_url().'Admin/PatientList/'.$id);
      }
    }

    function VitalSign($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['patient'] = $this->Model_admin->get_single_patient($id);
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/patient/view_vital.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function Pharmacy($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['patient'] = $this->Model_admin->get_single_patient($id);
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/patientlist/viewpharmacy.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function Billing($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['patient'] = $this->Model_admin->get_single_patient($id);
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/patient/billinghistory.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    /*=========================================================================================================================*/

    function DoctorList(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['doctors'] = $this->Model_admin->get_doctor_list();
      $data['total_doctors_count'] = $this->Model_admin->get_total_doctor_count();
      $data['total_active_doctors_count'] = $this->Model_admin->get_total_active_doctor_count();
      $data['total_inactive_doctors_count'] = $this->Model_admin->get_total_inactive_doctor_count();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/doctor/active_doctorlist.php', $data);
      //$this->load->view('administrator/includes/footer.php');
    }

    function InactiveDoctor(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['doctors'] = $this->Model_admin->get_inactive_doctor_list();
      $data['total_doctors_count'] = $this->Model_admin->get_total_doctor_count();
      $data['total_active_doctors_count'] = $this->Model_admin->get_total_active_doctor_count();
      $data['total_inactive_doctors_count'] = $this->Model_admin->get_total_inactive_doctor_count();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/doctor/inactive_doctorlist.php', $data);
      //$this->load->view('administrator/includes/footer.php');
    }

    function AddDoctor(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['specialties'] = $this->Model_admin->get_specialty();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/doctor/adddoctor.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function insert_doctor(){
      $this->form_validation->set_rules('specialty', 'Specialization', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|strip_tags|is_unique[users.username]');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags|is_unique[users.email]');
      $this->form_validation->set_rules('gender', 'Gender', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('mobile_number', 'Phone number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array("type_id"=>2,
                      "username"=>$this->input->post('username'),
                      "password"=>sha1("doctor"),
                      "email"=>$this->input->post('email'),
                      "first_name"=>$this->input->post('firstname'),
                      "last_name"=>$this->input->post('lastname'),
                      "middle_name"=>$this->input->post('middlename'),
                      "birthdate"=>$this->input->post('birthday'),
                      "contact_number"=>$this->input->post('mobile_number'),
                      "gender"=>$this->input->post('gender'),
                      "status"=>1,
                      "employment_date"=>date('Y-m-d'),
                    );
        $doctor_id = $this->Model_admin->insert_user($data);
        $this->Model_admin->insert_doctor_information($doctor_id, $this->input->post('specialty'));
        redirect(base_url().'Admin/DoctorList');
      }
    }

    function EditDoctor($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['doctor'] = $this->Model_admin->get_single_doctor($id);
      $data['specialties'] = $this->Model_admin->get_specialty();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/doctor/editdoctor.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function update_doctor($id){
      $this->form_validation->set_rules('specialty', 'Specialization', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('contact_number', 'Mobile number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'first_name'=>$this->input->post('firstname'),
                      'last_name'=>$this->input->post('lastname'),
                      'middle_name'=>$this->input->post('middlename'),
                      'email'=>$this->input->post('email'),
                      'birthdate'=>$this->input->post('birthday'),
                      'contact_number'=>$this->input->post('contact_number')
                     );
         $this->Model_admin->update_user($id, $data);
         $this->Model_admin->update_doctor_information($id, $this->input->post('specialty'));
         redirect(base_url().'Admin/DoctorList');
      }
    }

    function ActivateDoctor($id){
      $this->Model_admin->activate($id);
      redirect(base_url().'Admin/InactiveDoctor');
    }

    function DeactivateDoctor($id){
      $this->Model_admin->deactivate($id);
      redirect(base_url().'Admin/DoctorList');
    }

    /*=========================================================================================================================*/
    function NurseList(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['nurses'] = $this->Model_admin->get_active_nurses_list();
      $data['total_nurse'] = $this->Model_admin->get_total_nurse();
      $data['total_active_nurse_manager'] = $this->Model_admin->get_total_active_nurse_manager();
      $data['total_inactive_nurse_manager'] = $this->Model_admin->get_total_inactive_nurse_manager();
      $data['total_active_bedside_nurse'] = $this->Model_admin->get_total_active_bedside_nurse();
      $data['total_inactive_bedside_nurse'] = $this->Model_admin->get_total_inactive_bedside_nurse();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/nurse/active_nurselist.php', $data);
      //$this->load->view('administrator/includes/footer.php');
    }

    function InactiveNurse(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['nurses'] = $this->Model_admin->get_inactive_nurses_list();
      $data['total_nurse'] = $this->Model_admin->get_total_nurse();
      $data['total_active_nurse_manager'] = $this->Model_admin->get_total_active_nurse_manager();
      $data['total_inactive_nurse_manager'] = $this->Model_admin->get_total_inactive_nurse_manager();
      $data['total_active_bedside_nurse'] = $this->Model_admin->get_total_active_bedside_nurse();
      $data['total_inactive_bedside_nurse'] = $this->Model_admin->get_total_inactive_bedside_nurse();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/nurse/inactive_nurselist.php', $data);
      //$this->load->view('administrator/includes/footer.php');
    }

    function AddNurse(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/nurse/addnurse.php');
      $this->load->view('administrator/includes/footer.php');
    }

    function insert_nurse(){
      $this->form_validation->set_rules('nursetype', 'Specialization', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|strip_tags|is_unique[users.username]');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags|is_unique[users.email]');
      $this->form_validation->set_rules('gender', 'Gender', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('mobile_number', 'Phone number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo "may mali";
      }else{
        $data = array("type_id"=>$this->input->post('nursetype'),
                      "username"=>$this->input->post('username'),
                      "password"=>sha1("nurse"),
                      "email"=>$this->input->post('email'),
                      "first_name"=>$this->input->post('firstname'),
                      "last_name"=>$this->input->post('lastname'),
                      "middle_name"=>$this->input->post('middlename'),
                      "birthdate"=>$this->input->post('birthday'),
                      "contact_number"=>$this->input->post('mobile_number'),
                      "gender"=>$this->input->post('gender'),
                      "status"=>1,
                      "employment_date"=>date('Y-m-d'),
                    );
        $doctor_id = $this->Model_admin->insert_user($data);
        redirect(base_url().'Admin/NurseList');
      }
    }

    function EditNurse($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['nurse'] = $this->Model_admin->get_single_nurse($id);
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/nurse/editnurse.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function update_nurse($id){
      $this->form_validation->set_rules('nursetype', 'Position', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('contact_number', 'Mobile number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'first_name'=>$this->input->post('firstname'),
                      'last_name'=>$this->input->post('lastname'),
                      'middle_name'=>$this->input->post('middlename'),
                      'email'=>$this->input->post('email'),
                      'birthdate'=>$this->input->post('birthday'),
                      'contact_number'=>$this->input->post('contact_number'),
                      'type_id'=>$this->input->post('nursetype')
                     );
         $this->Model_admin->update_user($id, $data);
         redirect(base_url().'Admin/NurseList');
      }
    }

    function ActivateNurse($id){
      $this->Model_admin->activate($id);
      redirect(base_url().'Admin/InactiveNurse');
    }

    function DeactivateNurse($id){
      $this->Model_admin->deactivate($id);
      redirect(base_url().'Admin/NurseList');
    }

    /*=========================================================================================================================*/

    function RadiologistList(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['radiologists'] = $this->Model_admin->get_active_radiologists();
      $data['total_radiologist'] = $this->Model_admin->get_total_radiologists();
      $data['total_active_radiologist'] = $this->Model_admin->get_total_active_radiologists();
      $data['total_inactive_radiologist'] = $this->Model_admin->get_total_inactive_radiologists();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/radiology/active_radiologist.php', $data);
      //$this->load->view('administrator/includes/footer.php');
    }

    function InactiveRadiologist(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['radiologists'] = $this->Model_admin->get_inactive_radiologists();
      $data['total_radiologist'] = $this->Model_admin->get_total_radiologists();
      $data['total_active_radiologist'] = $this->Model_admin->get_total_active_radiologists();
      $data['total_inactive_radiologist'] = $this->Model_admin->get_total_inactive_radiologists();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/radiology/inactive_radiologist.php', $data);
      //$this->load->view('administrator/includes/footer.php');
    }

    function AddRadiologist(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['total_radiologist'] = $this->Model_admin->get_total_radiologists();
      $data['total_active_radiologist'] = $this->Model_admin->get_total_active_radiologists();
      $data['total_inactive_radiologist'] = $this->Model_admin->get_total_inactive_radiologists();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/radiology/add_radiologist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function insert_radiologist(){
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|strip_tags|is_unique[users.username]');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags|is_unique[users.email]');
      $this->form_validation->set_rules('gender', 'Gender', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('mobile_number', 'Phone number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo "may mali";
      }else{
        $data = array("type_id"=>6,
                      "username"=>$this->input->post('username'),
                      "password"=>sha1("radiologist"),
                      "email"=>$this->input->post('email'),
                      "first_name"=>$this->input->post('firstname'),
                      "last_name"=>$this->input->post('lastname'),
                      "middle_name"=>$this->input->post('middlename'),
                      "birthdate"=>$this->input->post('birthday'),
                      "contact_number"=>$this->input->post('mobile_number'),
                      "gender"=>$this->input->post('gender'),
                      "status"=>1,
                      "employment_date"=>date('Y-m-d'),
                      "dept"=>"DEPT-0005"
                    );
        $doctor_id = $this->Model_admin->insert_user($data);
        redirect(base_url().'Admin/RadiologistList');
      }
    }

    function EditRadioligst($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['radiologist'] = $this->Model_admin->get_single_radiologist($id);
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/radiology/edit_radiologist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function update_radiologist($id){
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('contact_number', 'Mobile number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'first_name'=>$this->input->post('firstname'),
                      'last_name'=>$this->input->post('lastname'),
                      'middle_name'=>$this->input->post('middlename'),
                      'email'=>$this->input->post('email'),
                      'birthdate'=>$this->input->post('birthday'),
                      'contact_number'=>$this->input->post('contact_number')
                     );
         $this->Model_admin->update_user($id, $data);
         redirect(base_url().'Admin/RadiologistList');
      }
    }

    function ActivateRadiologist($id){
      $this->Model_admin->activate($id);
      redirect(base_url().'Admin/InactiveRadiologist');
    }

    function DeactivateRadiologist($id){
      $this->Model_admin->deactivate($id);
      redirect(base_url().'Admin/RadiologistList');
    }

    /*=========================================================================================================================*/
    function PharmacistList(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['pharmacists'] = $this->Model_admin->get_active_pharmacist();
      $data['total_pharmacist'] = $this->Model_admin->get_total_pharmacist();
      $data['total_active_pharmacist'] = $this->Model_admin->get_total_active_pharmacist();
      $data['total_inactive_pharmacist'] = $this->Model_admin->get_total_inactive_pharmacist();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/pharmacy/active_pharmacist.php', $data);
      //$this->load->view('administrator/includes/footer.php');
    }

    function InactivePharmacist(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['pharmacists'] = $this->Model_admin->get_inactive_pharmacist();
      $data['total_pharmacist'] = $this->Model_admin->get_total_pharmacist();
      $data['total_active_pharmacist'] = $this->Model_admin->get_total_active_pharmacist();
      $data['total_inactive_pharmacist'] = $this->Model_admin->get_total_inactive_pharmacist();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/pharmacy/inactive_pharmacist.php', $data);
      //$this->load->view('administrator/includes/footer.php');
    }

    function AddPharmacist(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['total_pharmacist'] = $this->Model_admin->get_total_pharmacist();
      $data['total_active_pharmacist'] = $this->Model_admin->get_total_active_pharmacist();
      $data['total_inactive_pharmacist'] = $this->Model_admin->get_total_inactive_pharmacist();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/pharmacy/add_pharmacist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function insert_pharmacist(){
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('username', 'Username', 'required|trim|xss_clean|strip_tags|is_unique[users.username]');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags|is_unique[users.email]');
      $this->form_validation->set_rules('gender', 'Gender', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('mobile_number', 'Phone number', 'required|trim|xss_clean|strip_tags');



      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array("type_id"=>7,
                      "username"=>$this->input->post('username'),
                      "password"=>sha1("pharmacist"),
                      "email"=>$this->input->post('email'),
                      "first_name"=>$this->input->post('firstname'),
                      "last_name"=>$this->input->post('lastname'),
                      "middle_name"=>$this->input->post('middlename'),
                      "birthdate"=>$this->input->post('birthday'),
                      "contact_number"=>$this->input->post('mobile_number'),
                      "gender"=>$this->input->post('gender'),
                      "status"=>1,
                      "employment_date"=>date('Y-m-d'),
                    );
        $doctor_id = $this->Model_admin->insert_user($data);
        redirect(base_url().'Admin/PharmacistList');
      }
    }

    function EditPharmacist($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['pharmacist'] = $this->Model_admin->get_single_pharmacist($id);
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/pharmacy/edit_pharmacist.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function update_pharmacist($id){
      $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('birthday', 'birthday', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('contact_number', 'Mobile number', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'first_name'=>$this->input->post('firstname'),
                      'last_name'=>$this->input->post('lastname'),
                      'middle_name'=>$this->input->post('middlename'),
                      'email'=>$this->input->post('email'),
                      'birthdate'=>$this->input->post('birthday'),
                      'contact_number'=>$this->input->post('contact_number')
                     );
         $this->Model_admin->update_user($id, $data);
         redirect(base_url().'Admin/PharmacistList');
      }
    }


    function ActivatePharmacist($id){
      $this->Model_admin->activate($id);
      redirect(base_url().'Admin/InactivePharmacist');
    }

    function DeactivatePharmacist($id){
      $this->Model_admin->deactivate($id);
      redirect(base_url().'Admin/PharmacistList');
    }
    /*=========================================================================================================================*/
    function EmergencyRoom(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['emergency_rooms'] = $this->Model_admin->get_available_beds_from_emergency_room();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/admitting/choose_er_room.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function ChoosePatient($bed_id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['patients'] = $this->Model_admin->get_non_admitted_patient_list();
      $data['bed_id'] = $bed_id;
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/admitting/choosepatient_to_er.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }


    function InsertAdmitFromER($bed_id){
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
                                        "patient_id"=>$patient
                                      );
     $data_update_patient_status = array(
                                          "patient_status"=>1
                                        );
     $this->Model_admin->insert_patient_to_beds($data_bedstable, $bed_id);
     $this->Model_admin->insert_admission_schedule($data_admission_schedule);
     $this->Model_admin->insert_admitting_resident($data_admitting_resident);
     $this->Model_admin->update_patient_status($data_update_patient_status, $patient);
     redirect(base_url().'Admin/EmergencyRoom', 'refresh');
    }

    function DischargePatient($patient_id, $bed_id){
      $data_discharge = array("status"=>2);
      $data_update_bed = array("bed_patient"=>NULL);
      $data_update_patient = array("patient_status"=>0);
      $this->Model_admin->dischargepatient($data_discharge, $patient_id);
      $this->Model_admin->removepatient_from_bed($data_update_bed, $bed_id);
      $this->Model_admin->update_patient_status($data_update_patient, $patient_id);
      //redirect(base_url()."Admin/EmergencyRoom");
      redirect($this->agent->referrer(), 'refresh');
    }

    function DirectRoomAdmission(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['rooms'] = $this->Model_admin->get_room_list_for_directadmission();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/admitting/choose_direct_room.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function ChooseBed($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['beds'] = $this->Model_admin->get_available_beds_for_directadmission($id);
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/admitting/choose_bed.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function ChoosePatientToDR($bed_id, $roomid){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['patients'] = $this->Model_admin->get_non_admitted_patient_list();
      $data['bed_id'] = $bed_id;
      $data['roomid'] = $roomid;
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/admitting/choosepatient_to_dr.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function InsertAdmitFromDR($bed_id, $roomid){
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
                                        "patient_id"=>$patient
                                      );
     $data_update_patient_status = array(
                                          "patient_status"=>2
                                        );
     $this->Model_admin->insert_patient_to_beds($data_bedstable, $bed_id);
     $this->Model_admin->insert_admission_schedule($data_admission_schedule);
     $this->Model_admin->insert_admitting_resident($data_admitting_resident);
     $this->Model_admin->update_patient_status($data_update_patient_status, $patient);
     redirect(base_url().'Admin/ViewAdmittedPatients/'.$roomid, 'refresh');
    }

    function ViewAdmittedPatients($id = NULL){
      if(empty($id)){
        $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
        $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
        $data['rooms'] = $this->Model_admin->get_room_list();
        $this->load->view('administrator/includes/header.php',$header);
        $this->load->view('administrator/admitting/roomlist.php', $data);
        $this->load->view('administrator/includes/footer.php');
      }else{
        $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
        $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
        $data['beds'] = $this->Model_admin->get_admitted_patient($id);
        $this->load->view('administrator/includes/header.php',$header);
        $this->load->view('administrator/admitting/viewadmittedpatient.php', $data);
        $this->load->view('administrator/includes/footer.php');
      }
    }

    function TransferRoom($patientid){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['rooms'] = $this->Model_admin->get_room_list_for_directadmission();
      $data['patientid'] = $patientid;
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/admitting/choose_room_to_transfer.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function ChooseBedToTransfer($patientid, $roomid){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['beds'] = $this->Model_admin->get_available_beds_for_directadmission($roomid);
      $data['patientid'] = $patientid;
      $data['roomid'] = $roomid;
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/admitting/choose_bed_to_transfer.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function TransferPatient($patientid, $bedid, $roomid){
      $data_remove_patient_from_prev_bed = array("bed_patient"=>NULL);
      $data_transfer_patient_to_new_bed = array("bed_patient"=>$patientid);
      $update_patient_status = array("patient_status"=>2);
      $this->Model_admin->remove_patient_from_bed($data_remove_patient_from_prev_bed, $patientid);
      $this->Model_admin->transfer_patient_to_new_bed($data_transfer_patient_to_new_bed, $bedid);
      $this->Model_admin->update_patient_status($update_patient_status, $patientid);
      redirect(base_url().'Admin/ViewAdmittedPatients/'.$roomid);
    }

    /*=========================================================================================================================*/
    function RoomType()
    {
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['roomtypes'] = $this->Model_admin->get_roomtype_List();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/rooms/roomtypelist.php', $data);
      //$this->load->view('administrator/includes/footer.php');
    }

    function insert_roomtype(){
      $this->form_validation->set_rules('roomname', 'Room Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('roomprice', 'Room Price', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('roomdesc', 'Room Description', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'room_name' => $this->input->post('roomname'),
                      'room_description' => $this->input->post('roomdesc'),
                      'room_price' => $this->input->post('roomprice')
                     );
        $insertroomtype = $this->Model_admin->insertroomtype($data);
        redirect(base_url()."Admin/RoomType");
      }
    }

    function UpdateRoomType($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['roomtype'] = $this->Model_admin->get_room_type($id);
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/rooms/updateroomtype.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function update_roomtype($id){
      $this->form_validation->set_rules('roomname', 'Room Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('roomprice', 'Room Price', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('roomdesc', 'Room Description', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'room_name' => $this->input->post('roomname'),
                      'room_description' => $this->input->post('roomdesc'),
                      'room_price' => $this->input->post('roomprice')
                     );
        $this->Model_admin->updateroomtype($data, $id);
        redirect(base_url()."Admin/RoomType");
      }
    }

    function Rooms(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['rooms'] = $this->Model_admin->get_room_list();
      $data['roomtypes'] = $this->Model_admin->get_roomtype_List();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/rooms/roomlist.php', $data);
      //$this->load->view('administrator/includes/footer.php');
    }

    function insert_room(){
      $this->form_validation->set_rules('roomtype', 'Room Type', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('roomloc', 'Room Location', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'room_type' => $this->input->post('roomtype'),
                      'room_location' => $this->input->post('roomloc'),
                      'occupancy_status' => 1,
                      'maintenance_status' => 1
                    );

        $insertroomtype = $this->Model_admin->insertroom($data);
        $beddata = array(
                        'bed_roomid' => $insertroomtype
                        );
        $bednum = $this->input->post('bednum');
        for($i=1;$i<=$bednum;$i++)
        {
            $this->Model_admin->insertbedsinroom($beddata);
        }

        redirect(base_url()."Admin/Rooms");
      }
    }

    function ViewRoom($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['roomdata'] = $this->Model_admin->get_room_data($id);
      $data['roomid'] = $id;
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/rooms/viewroom.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function UpdateRoom($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['rooms'] = $this->Model_admin->get_single_room_type($id);
      $data['roomtypes'] = $this->Model_admin->get_roomtype_List();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/rooms/updateroom.php', $data);
      $this->load->view('administrator/includes/footer.php');
    }

    function update_room($id){
      $this->form_validation->set_rules('roomtype', 'Room Type', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('roomloc', 'Room Location', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run() == FALSE){
        echo validation_errors();
      }else{
        $data = array(
                      'room_type' => $this->input->post('roomtype'),
                      'room_location' => $this->input->post('roomloc')
                     );
        $this->Model_admin->updateroom($data, $id);
        redirect(base_url()."Admin/Rooms");
      }
    }

     function add_bed($id){
      $beddata = array(
                      'bed_roomid' => $id
                      );
      $bednum = $this->input->post('bednum');
      for($i=1;$i<=$bednum;$i++)
      {
          $this->Model_admin->insertbedsinroom($beddata);
      }
      redirect(base_url()."Admin/ViewRoom/".$id);
    }

    function remove_bed($roomid, $id){
      $this->Model_admin->removebed($id);
      redirect(base_url()."Admin/ViewRoom/".$roomid);
    }
    /*=========================================================================================================================*/
function LaboratoryRequests(){
  $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
  $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
$data['laboratoryreq'] = $this->Model_admin->get_laboratoryrequest_list();
$this->load->view('administrator/includes/header.php',$header);
$this->load->view('administrator/laboratory/laboratoryrequest.php',$data);
$this->load->view('administrator/includes/footer.php');
}

    function ShowLabReq($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['requestno'] = $id;
      $data['laboratorytopatient'] = $this->Model_admin->get_laboratorytopatient_data($id);
      $data['laboratorytouser'] =  $this->Model_admin->get_laboratorytouser_data($id);
      $data['laboratorytolabrequest'] = $this->Model_admin->get_laboratorytorequest_data($id);
      $data['laboratorytospecimen'] = $this->Model_admin->get_laboratorytospecimen_data($id);
      $data['laboratorytoremarks'] = $this->Model_admin->get_laboratorytoremarks_data($id);
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/laboratory/showlaboratoryrequest.php',$data);
      //$this->load->view('administrator/includes/footer.php');
    }


    function MakeLaboratoryRequests(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
$data['patientlist'] = $this->Model_admin->get_patient_list();
$this->load->view('administrator/includes/header.php',$header);
$this->load->view('administrator/laboratory/makelaboratoryrequest.php',$data);
$this->load->view('administrator/includes/footer.php');
}

function MakeLaboratoryRequests2(){
  $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
  $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
$patient = $this->input->post('patient');
if($patient==""){
redirect(base_url()."Admin/MakeLaboratoryRequests");
}else{
$data['labexamtype'] = $this->Model_admin->get_all_examtype();
$data['urgencycat'] = $this->Model_admin->get_all_urgencycategory();
$data['fastingcat'] = $this->Model_admin->get_all_fastingcategory();
$data['patient'] = $this->Model_admin->get_single_patient($patient);
$data['specimen'] = $this->Model_admin->get_all_labspec();
$this->load->view('administrator/includes/header.php',$header);
$this->load->view('administrator/laboratory/makelaboratoryrequest2.php',$data);
//$this->load->view('administrator/includes/footer.php');
}
}

function AppofReq(){
  $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
  $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
  $data['laboratoryreq'] = $this->Model_admin->get_laboratoryrequest_list();
  $this->load->view('administrator/includes/header.php',$header);
  $this->load->view('administrator/laboratory/approvalofrequest.php',$data);
  $this->load->view('administrator/includes/footer.php');
}

function ApproveLabReq($id)
{
      $data = array('lab_status'=>2);
      $this->Model_admin->approvelabreq($id,$data);
      redirect(base_url()."Admin/AppofReq");
}

function LabAccRequest()
{
  $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
  $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
  $data['acceptedreq'] = $this->Model_admin->get_accepted_labreq();
  $this->load->view('administrator/includes/header.php',$header);
  $this->load->view('administrator/laboratory/labaccrequest.php',$data);
  $this->load->view('administrator/includes/footer.php');
}

function CancelLabReq($id)
{
        $data = array('lab_status'=>3);
        $this->Model_admin->cancellabreq($id,$data);
        redirect(base_url()."Admin/AppofReq");
}

 function LabRejRequest()
{
  $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
  $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
  $data['rejectedreq'] = $this->Model_admin->get_rejected_labreq();
  $this->load->view('administrator/includes/header.php',$header);
  $this->load->view('administrator/laboratory/labrejrequest.php',$data);
  $this->load->view('administrator/includes/footer.php');
}

function LabExamCateg(){
  $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
  $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
  $data['examcateg'] = $this->Model_admin->get_all_examcateg();
  $this->load->view('administrator/includes/header.php',$header);
  $this->load->view('administrator/laboratory/labexamcateg.php',$data);
  $this->load->view('administrator/includes/footer.php');
}

function EditExamCateg($id){
  $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
  $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
  $data['examcateg'] = $this->Model_admin->get_examcateg($id);
  $this->load->view('administrator/includes/header.php',$header);
  $this->load->view('administrator/laboratory/editexamcateg.php',$data);
  $this->load->view('administrator/includes/footer.php');
}

function LabExamType(){
  $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
  $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
  $data['examtype'] = $this->Model_admin->get_all_examtype();
  $data['examcateg'] = $this->Model_admin->get_all_examcateg();
  $this->load->view('administrator/includes/header.php',$header);
  $this->load->view('administrator/laboratory/labexamtype.php',$data);
  $this->load->view('administrator/includes/footer.php');
}

function EditExamType($id){
  $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
  $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
  $data['examtype'] = $this->Model_admin->get_specific_examtype($id);
  $data['examcateg'] = $this->Model_admin->get_all_examcateg();
  $this->load->view('administrator/includes/header.php',$header);
  $this->load->view('administrator/laboratory/editexamtype.php',$data);
  $this->load->view('administrator/includes/footer.php');
}

function LabExamSpec(){
  $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
  $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
  $data['labspec'] = $this->Model_admin->get_all_labspec();
  $this->load->view('administrator/includes/header.php',$header);
  $this->load->view('administrator/laboratory/labexamspec.php',$data);
  $this->load->view('administrator/includes/footer.php');
}

function EditSpec($id){
  $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
  $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
  $data['spec'] = $this->Model_admin->get_specific_specimen($id);
  $this->load->view('administrator/includes/header.php',$header);
  $this->load->view('administrator/laboratory/editspec.php',$data);
  $this->load->view('administrator/includes/footer.php');
}

 function insert_patient_thrulaboratory(){
   $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('firstname', 'First Name', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('middlename', 'Middle Name', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('gender', 'Gender', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('age', 'Age', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('birthday', 'Birthday', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('birthplace', 'Birthplace', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('occupation', 'Occupation', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('religion', 'Religion', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('nationality', 'Nationality', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('address', 'Address', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('telephone_number', 'Telephone number', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('mobile_number', 'Mobile number', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('email', 'Email', 'required|trim|xss_clean|strip_tags');

  if($this->form_validation->run() == FALSE){
    echo "may mali";
  }else{
    $data = array(
      'first_name' => $this->input->post('firstname'),
      'last_name' => $this->input->post('lastname'),
      'middle_name' => $this->input->post('middlename'),
      'gender' => $this->input->post('gender'),
      'age' => $this->input->post('age'),
      'birthdate' => $this->input->post('birthday'),
      'birthplace' => $this->input->post('birthplace'),
      'occupation' => $this->input->post('occupation'),
      'religion' => $this->input->post('religion'),
      'nationality' => $this->input->post('nationality'),
      'present_address' => $this->input->post('address'),
      'telephone_number' => $this->input->post('telephone_number'),
      'mobile_number' => $this->input->post('mobile_number'),
      'email' => $this->input->post('email'),
      'patient_status' => "0",
      'date_registered' => date('Y-m-d'),
    );

    $insertpatient = $this->Model_admin->insertpatient($data);
      redirect(base_url()."Admin/MakeLaboratoryRequests");

  }
 }

 function insert_category(){
   $this->form_validation->set_rules('categname', 'Name', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('categdesc', 'Description', 'required|trim|xss_clean|strip_tags');

   if($this->form_validation->run() == FALSE){
     echo "Something's Wrong";
   } else {
     $data = array ('exam_cat_name' => $this->input->post('categname'),
                    'exam_cat_desc' => $this->input->post('categdesc'));
      $insertcategory = $this->Model_admin->insertcategory($data);
      redirect(base_url()."Admin/LabExamCateg");
   }
 }

 function update_examination_category($id)
 {
   $this->form_validation->set_rules('catname', 'Name', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('catdesc', 'Description', 'required|trim|xss_clean|strip_tags');

   if($this->form_validation->run()==FALSE){
     echo "Something's Wrong";
   } else {
     $data = array ('exam_cat_name' => $this->input->post('catname'),
                    'exam_cat_desc' => $this->input->post('catdesc'));
      $insertcategory = $this->Model_admin->updatecategory($id,$data);
      redirect(base_url()."Admin/LabExamCateg");
   }
 }

 function update_exam_type($id)
 {
   $this->form_validation->set_rules('typename', 'Name', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('typecateg', 'Category', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('typedesc', 'Description', 'required|trim|xss_clean|strip_tags');

   if($this->form_validation->run()==FALSE){
     echo "Something's Wrong";
   } else {
     $data = array ('lab_exam_type_name' => $this->input->post('typename'),
                    'lab_exam_type_category_id' => $this->input->post('typecateg'),
                    'lab_exam_type_description' => $this->input->post('typedesc'));
      $insertcategory = $this->Model_admin->updateexamtype($id,$data);
      redirect(base_url()."Admin/LabExamType");
   }
 }

 function insert_examtype(){
   $this->form_validation->set_rules('typename', 'Name', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('examcateg', 'Category', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('typedesc', 'Description', 'required|trim|xss_clean|strip_tags');

   if($this->form_validation->run()==FALSE){
     echo "Something's Wrong";
   } else {
     $data = array('lab_exam_type_name' => $this->input->post('typename'),
                   'lab_exam_type_category_id' => $this->input->post('examcateg'),
                   'lab_exam_type_description' => $this->input->post('typedesc'));
    $insertetype = $this->Model_admin->insertexamtype($data);
          redirect(base_url()."Admin/LabExamType");
   }
 }

 function insert_labspecimen()
 {
   $this->form_validation->set_rules('specname', 'Name', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('specdesc', 'Description', 'required|trim|xss_clean|strip_tags');

   if($this->form_validation->run()==FALSE)
   {
     echo "Something is Wrong";
   }
   else
   {
     $data = array('specimen_name' => $this->input->post('specname'),
                   'specimen_description' => $this->input->post('specdesc'));
     $this->Model_admin->insertspecimen($data);
     redirect(base_url()."Admin/LabExamSpec");
   }
 }

 function update_lab_specimen($id){
   $this->form_validation->set_rules('specname', 'Name', 'required|trim|xss_clean|strip_tags');
   $this->form_validation->set_rules('specdesc', 'Description', 'required|trim|xss_clean|strip_tags');

   if($this->form_validation->run()==FALSE)
   {
     echo "Something is Wrong";
   }
   else
   {
     $data = array('specimen_name' => $this->input->post('specname'),
                   'specimen_description' => $this->input->post('specdesc'));
     $this->Model_admin->updatespecimen($id,$data);
     redirect(base_url()."Admin/LabExamSpec");
   }
 }

 function insert_laboratoryrequest()
 {
   $this->form_validation->set_rules('labremark', 'Remark', 'required|trim|xss_clean|strip_tags');

   if($this->form_validation->run()==FALSE)
   {
     echo "Something is Wrong";
   }
   else {
     $specimens = $this->input->post('specimens');
     $data1 = array('user_id_fk'=>$_SESSION['user_id'],
                   'lab_patient'=>$this->input->post('patientid'),
                   'lab_date_req'=>date('Y-m-d H:i:s'),
                   'lab_patient_checkin'=>$this->input->post('patientchckin'),
                   'urgency_cat_fk'=>$this->input->post('urgency'),
                   'fasting_cat_fk'=>$this->input->post('fasting'),
                   'exam_type_fk'=>$this->input->post('laboratoryexam'));
        $id = $this->Model_admin->insertlaboratoryrequest($data1);

     foreach($specimens as $spec){
       $data2 = array('lab_req_id'=>$id,
                      'specimen_id'=>$spec);
        $this->Model_admin->insertrequestspecimen($data2);

     }

     $data3 = array('remark'=>$this->input->post('labremark'),
                    'rem_date'=>date('Y-m-d'),
                  'lab_id_fk'=>$id,
                  'user_id_fk'=>$_SESSION['user_id']);
        $this->Model_admin->insertrequestremark($data3);
      redirect(base_url()."Admin/LaboratoryRequests");
   }
  }


    /*=========================================================================================================================*/
    function CSRListofproducts(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['csrinventory'] = $this->Model_admin->get_csr_inventory();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/csr/listofproducts.php',$data);
      //$this->load->view('administrator/includes/footer.php');
    }

    function CSRPendingrequests(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['nursetocsr'] = $this->Model_admin->get_nurse_requests();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/csr/pendingrequest.php',$data);
      //$this->load->view('administrator/includes/footer.php');
    }

    function RequestRestock($id){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['restock'] = $this->Model_admin->restockdata($id);
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/csr/restock.php',$data);
      $this->load->view('administrator/includes/footer.php');
    }

    function add_newproduct(){
      $this->form_validation->set_rules('itemreq', 'Item Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('itemquant', 'Item Name', 'required|trim|xss_clean|strip_tags');

      if($this->form_validation->run()==FALSE){
        echo "Something is wrong";
      } else {
        $new = $this->Model_admin->reqtypenewproduct();
        $data = array('requester_id'=>$_SESSION['user_id'],
                      'item_id'=>NULL,
                      'quantity'=>$this->input->post('itemquant'),
                      'request_type'=>$new,
                      'item_name'=>$this->input->post('itemreq'));
       $this->Model_admin->requestproduct($data);
       redirect("Admin/CSRListofproducts");
      }
    }

      function request_restock($id)
      {
        $itemname = $this->input->post('productname');
        $itemquant = $this->input->post('productquant');

        $restock = $this->Model_admin->reqtyperestock();
        $data = array('requester_id'=>$_SESSION['user_id'],
                      'item_id'=>$id,
                      'quantity'=>$itemquant,
                      'request_type'=>$restock,
                      'item_name'=>$itemname);
        $this->Model_admin->restockproduct($data);
        redirect("Admin/CSRListofproducts");
      }

    /*=========================================================================================================================*/
    function PurchasingCSRInventory()
    {
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['csrinventory'] = $this->Model_admin->get_csr_inventory();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/purchasing/csrinventory.php',$data);
      $this->load->view('administrator/includes/footer.php');
    }

    function PurchasingCSRRequests()
    {
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['csrrequests'] = $this->Model_admin->get_csr_requests();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/purchasing/csrrequests.php',$data);
      //$this->load->view('administrator/includes/footer.php');
    }

    function PurCsrAccRequest()
    {
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['accepted'] = $this->Model_admin->get_acceptedcsr_requests();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/purchasing/csraccrequests.php',$data);
      $this->load->view('administrator/includes/footer.php');
    }

    function PurCsrRejRequest()
    {
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $data['rejected'] = $this->Model_admin->get_rejectedcsr_requests();
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/purchasing/csrrejrequests.php',$data);
      $this->load->view('administrator/includes/footer.php');
    }

    function accept_csr($id)
    {
      //Accept = 1
      $requesttype = $this->Model_admin->get_request_type($id);
      if($requesttype == "REQ-TYP00001")
      {
        //NEW PRODUCT
      $requestdata = $this->Model_admin->get_request_data($id);
      $data = array('item_name'=>$requestdata->item_name,
                    'item_desc'=>$requestdata->item_name,
                    'item_stock'=>$requestdata->quantity);
      $this->Model_admin->insertnewcsrproduct($data);
      $newstat = array('pur_stat'=>1,
                       'date_altered_status'=>date('Y-m-d H:i:s'));
      $this->Model_admin->change_pur_status($id,$newstat);
        redirect("Admin/PurchasingCSRRequests");
      } else {
        //RESTOCK
      $requestdata = $this->Model_admin->get_request_data($id);
      $existingstock = $this->Model_admin->get_csr_stock($requestdata->item_id);
      $sumstock = $existingstock + $requestdata->quantity;
      $data = array('item_name'=>$requestdata->item_name,
                    'item_desc'=>$requestdata->item_name,
                    'item_stock'=>$sumstock);

      $this->Model_admin->restockcsrproduct($requestdata->item_id,$data);
      $newstat = array('pur_stat'=>1,
                       'date_altered_status'=>date('Y-m-d H:i:s'));
      $this->Model_admin->change_pur_status($id,$newstat);
        redirect("Admin/PurchasingCSRRequests");
      }
    }

    function reject_csr($id)
    {
      //Reject = 2
      $newstat = array('pur_stat'=>2,
                       'date_altered_status'=>date('Y-m-d H:i:s'));
      $this->Model_admin->change_pur_status($id,$newstat);
        redirect("Admin/PurchasingCSRRequests");
    }

    function hold_csr($id)
    {
      //Hold = 3
      $newstat = array('pur_stat'=>3,
                       'date_altered_status'=>date('Y-m-d H:i:s'));
      $this->Model_admin->change_pur_status($id,$newstat);
        redirect("Admin/PurchasingCSRRequests");
    }

    function rolesandpermission()
    {
      $data['title'] = "HIS";
      $data['task_names'] = $this->Model_admin->fetch_tasks();
      $data['user_types'] = $this->Model_admin->get_usertypes();
      $data['permissions'] = $this->Model_admin->fetch_permissions();
      $data['permittedViews'] = $this->Model_admin->fetchPermittedViews();
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/rolesandpermission', $data);
    }

    function rolesandpermission_settings()
    {
      $data['title'] = "HIS";
      $data['permissions'] = $this->Model_admin->fetch_permissions();
      $data['task_names'] = $this->Model_admin->fetch_tasks();
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('administrator/RandPsettings', $data);
    //  $this->load->view('administrator/includes/footer.php');

    }

    function medchangebaseprice()
    {
        $data['title'] = "HIS";
        $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
        $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
        $this->load->view('administrator/includes/header.php',$header);
        $this->load->view('administrator/changeMedbaseprice', $data);
        $this->load->view('administrator/includes/footer');

    }


    function addtask()
    {
      $this->form_validation->set_rules('taskname', 'Task name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('tasklogo', 'Task logo', 'required|trim|xss_clean|strip_tags');

        if($this->form_validation->run()){

            $data = array(
              'task_logo' => $this->input->post('tasklogo'),
              'task_name' => $this->input->post('taskname')
            );
            if($this->Model_admin->addtask($data)){
                //john renz pa add ng notifs sa page na successfully add
              $this ->rolesandpermission_settings();
            }else{
              $this ->rolesandpermission_settings();
            }
        }else{
          $this ->rolesandpermission_settings();
        }

    }

    function addpermission()
    {
      $this->form_validation->set_rules('permissionname', 'Permission Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('permissionlink', 'permissions link', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('taskid', 'Task', 'required');

        if($this->form_validation->run()){

            $data = array(
              'permission_name' => $this->input->post('permissionname'),
              'permission_link' => $this->input->post('permissionlink'),
              'task_id' => $this->input->post('taskid')
            );

              if($this->Model_admin->addpermission($data)){
                //set flashdata here
                $this->rolesandpermission_settings();
              }else{
                $this->rolesandpermission_settings();
              }

        }else{
            $this->rolesandpermission_settings();
        }
    }


    function addrole()
    {
      $this->form_validation->set_rules('rolename', 'Role name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('desc', 'Description', 'required|trim|xss_clean|strip_tags');

        if($this->form_validation->run()){

          $data = array(
            'name' => $this->input->post('rolename'),
            'description' => $this->input->post('desc')

          );
          if($this->Model_admin->insertRole($data)){

            $this->rolesandpermission();
          }else{


          }

        }else{
          $this->rolesandpermission();

        }

    }




    function updatePermission()
    {
      // echo $_POST['hiddenUserTypeId']."<br>";
      // print_r($_POST['permissions']);

      $this->form_validation->set_rules('name', 'Role Name', 'required|trim|xss_clean|strip_tags');
      $this->form_validation->set_rules('permissions[]', 'Permissions', 'required');

        if($this->form_validation->run()){
          $permissionArrays = $this ->input ->post('permissions');
            if($this->input->post('name') == $this->input->post('oldName')){
                    $this->Model_admin->deleteAllTaskUserTypeById($this->input->post('hiddenUserTypeId'));
                    $this->Model_admin->deleteAllUserTypeById($this->input->post('hiddenUserTypeId'));
                    $this->Model_admin->insertPermissionUserType($permissionArrays);
                    $this->rolesandpermission();
            }else{

            }
        }else{

        }



    }








    /*=========================================================================================================================*/
    function logout(){
      $this->session->sess_destroy();
      redirect(base_url());
    }






  }

?>
