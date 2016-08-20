<?php
  if (!defined('BASEPATH'))exit('No direct script access allowed');
  class Cashier extends CI_Controller{

    function __construct(){
      parent::__construct();
        $this->load->model('Model_admin');
        $this->load->model('Model_cashier');

    }

    function index(){
      $data['title'] = "Cashier";
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $this->load->view('administrator/includes/header.php',$header);
    }

    function pendingdischarge(){
      $data['title'] = "Cashier";
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $this->load->view('administrator/includes/header.php',$header);
        $this->load->view('cashier/pendingdischarge',$data);
    }




  }


  ?>
