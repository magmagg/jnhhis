<?php
  if (!defined('BASEPATH'))exit('No direct script access allowed');
  class Accounting extends CI_Controller{

    function __construct(){
      parent::__construct();
        $this->load->model('Model_admin');
        $this->load->model('Model_accounting');

    }

    function index(){
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $this->load->view('administrator/includes/header.php',$header);
    }

    function summary(){
      $data['title'] = "Accounting";
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('accounting/summary', $data);
    }
    function billing(){
      $data['title'] = "Accounting";
      $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
      $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
      $this->load->view('administrator/includes/header.php',$header);
      $this->load->view('accounting/billing', $data);
    }



  }



  ?>
