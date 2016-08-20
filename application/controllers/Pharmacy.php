<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pharmacy extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Model_pharmacy');
    $this->load->model('Model_admin');
  }
  /*=========================================================================================================================*/

  function index()
  {
    $this->landing();
  }



  function landing()
  {
    $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
    $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
    $this->load->view('administrator/includes/header', $header);
      $this->load->view('administrator/includes/footer.php');
    //$this->load->view('pharmacy/landing');
  }


  function pharmacy_inventory()
  {
    $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
    $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
    $data['items'] = $this->Model_pharmacy->get_pharmacy_inventory();
    $data['inventorycount'] = $this->Model_pharmacy->count_pharmacy_inventory();
    $this->load->view('administrator/includes/header', $header);
    $this->load->view('pharmacy/add_item_modal');
    $this->load->view('pharmacy/delete_item_modal');
    $this->load->view('pharmacy/update_item_modal');
    $this->load->view('pharmacy/inventory',$data);
  }

  function update_item_inventory()
  {
    $id = $this->input->post('itemid');

    $data = array('item_name'=>$this->input->post('name'),
                  'item_description'=>$this->input->post('description'),
                  'item_quantity'=>$this->input->post('quantity'),
                  'item_price'=>$this->input->post('price'));

    $this->Model_pharmacy->update_item_inventory($id,$data);
    redirect(base_url()."Pharmacy/pharmacy_inventory");
  }

  function delete_item_inventory()
  {
    $id = $this->uri->segment(3);
    $this->Model_pharmacy->delete_item_inventory($id);
    redirect(base_url()."Pharmacy/pharmacy_inventory");
  }

  function add_item_inventory()
  {
    $data = array('item_name'=>$this->input->post('name'),
                  'item_description'=>$this->input->post('description'),
                  'item_quantity'=>$this->input->post('quantity'),
                  'item_price'=>$this->input->post('price'));

    $this->Model_pharmacy->add_item_inventory($data);
    redirect(base_url()."Pharmacy/pharmacy_inventory");
  }

  function add_item_inventory_import()
  {
    $data['error'] = '';    //initialize image upload error array to empty
        $config['upload_path'] = './csv/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // If upload failed, display error
        if (!$this->upload->do_upload())
        {
            redirect('Pharmacy/pharmacy_inventory');
        }
        else
        {
            $file_data = $this->upload->data();
            $file_path =  './csv/'.$file_data['file_name'];
            if ($this->csvimport->get_array($file_path))
            {
                $csv_array = $this->csvimport->get_array($file_path);
                foreach ($csv_array as $row)
                {
                    $insert_data = array(
                        'item_name'=>$row['Name'],
                        'item_description'=>$row['Description'],
                        'item_quantity'=>$row['Quantity'],
                        'item_price'=>$row['Price']
                    );
                    $this->Model_pharmacy->add_item_inventory_import($insert_data);
                }
                //$this->session->set_flashdata('csv', '<div class="alert alert-success text-center">Users imported successfully!</div>');
                redirect(base_url().'Pharmacy/pharmacy_inventory');
            } else
            $this->session->set_flashdata('error', "Error occured");
        redirect('Pharmacy/pharmacy_inventory');
            }
  }

  function pharmacy_request()
  {
    $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
    $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
    $data['items'] = $this->Model_pharmacy->get_pharmacy_inventory();
    $data['patient'] = $this->Model_pharmacy->get_all_patients();
    $this->load->view('administrator/includes/header', $header);
    $this->load->view('pharmacy/pharmacy_request',$data);
    $this->load->view('pharmacy/pharmacy_request_modal');
  }

  function pharmacy_request_submit()
  {
    $quantity = $this->input->post('quantity');
    $itemid = $this->input->post('itemid');
    $price = $this->input->post('price');
    $patientid = $this->input->post('patientid');
    $userid = $this->session->userdata('user_id');
    $unique_id = bin2hex(mcrypt_create_iv(5, MCRYPT_DEV_URANDOM));

    foreach($quantity as $key => $q)
    {
      if($q == 0)
      {
        unset($quantity[$key]);
        unset($itemid[$key]);
        unset($price[$key]);
      }
    }
    $quantity = array_values($quantity);
    $itemid = array_values($itemid);
    $price = array_values($price);

    foreach($price as $key => $p)
    {
      $price[$key] = $p * $quantity[$key];
    }

    foreach($itemid as $key => $i)
    {
      $data = array('phar_item'=>$i,
                    'phar_user_id'=>$userid,
                    'phar_patient'=>$patientid,
                    'quant_requested'=>$quantity[$key],
                    'total_price'=>$price[$key],
                    'phar_stat'=>0,
                    'unique_id'=>$unique_id);
      $this->Model_pharmacy->insert_pharmacy_request($data);
    }

    $data['items'] = $this->Model_pharmacy->get_pharmacy_inventory();

    foreach($data['items'] as $d)
    {
      foreach($itemid as $key => $i)
      {
        if($d->item_id == $i)
        {
          $newquantity = $d->item_quantity - $quantity[$key];
          $data = array('item_quantity'=>$newquantity);
          $this->Model_pharmacy->update_pharmacy_quantity($d->item_id,$data);
        }
      }
    }

    redirect('Pharmacy/pharmacy_request');
  }

  function process_pharmacy_request()
  {
    $data['requests'] = $this->Model_pharmacy->get_pharmacy_requests();
    //$data['items'] = $this->Model_pharmacy->get_pharmacy_inventory();
    //$data['patient'] = $this->Model_pharmacy->get_all_patients();

    $data['unique_ids'] = $this->Model_pharmacy->get_unique_ids();
    $data['table_details'] = array();
    foreach($data['unique_ids'] as $d)
    {
      $data['new_details'] = $this->Model_pharmacy->get_specific_request($d->unique_id);
      $totalprice = 0;
      $quantity = 0;
      $patient;
      $requestedby;
      $date;
      $status;
      foreach($data['new_details'] as $nd)
      {
        $totalprice += $nd->total_price;
        $quantity   += $nd->quant_requested;
        $patient     = $nd->phar_patient;
        $requestedby = $nd->phar_user_id;
        $date        = $nd->date_req;
        $status    = $nd->phar_stat;

      }
      $data['table_details'][$d->unique_id] = array('price'=>$totalprice,
                                                    'date'=>$date,
                                                    'quantity'=>$quantity,
                                                    'requestedby'=>$requestedby,
                                                    'patient'=>$patient,
                                                    'status'=>$status,
                                                    'unique_id'=>$d->unique_id);
    }

    $this->load->view('administrator/includes/header', $header);
    $this->load->view('pharmacy/process_pharmacy_request',$data);
  }

  function accept_pharmacy_request()
  {
    $postid = $this->uri->segment(3);
    $data = array('phar_stat'=>1);
    $this->Model_pharmacy->process_pharmacy_request_model($postid,$data);
    redirect('Pharmacy/process_pharmacy_request');
  }

  function reject_pharmacy_request()
  {
    $postid = $this->uri->segment(3);
    $var['details'] = $this->Model_pharmacy->get_specific_request($postid);
    foreach($var['details'] as $d)
    {
      $this->Model_pharmacy->restore_quantity($d->phar_item,$d->quant_requested);
    }
    $data = array('phar_stat'=>2);
    $this->Model_pharmacy->process_pharmacy_request_model($postid,$data);
    redirect('Pharmacy/process_pharmacy_request');
  }

  function view_one_request()
  {
    $id = $this->uri->segment('3');

    $header['tasks'] = $this->Model_admin->get_tasks($this->session->userdata('type_id'));
    $header['permissions'] = $this->Model_admin->get_permissions($this->session->userdata('type_id'));
    $data['details'] = $this->Model_pharmacy->get_specific_request($id);
    $data['items'] = $this->Model_pharmacy->get_pharmacy_inventory();
    $data['id'] = $id;
    $this->load->view('administrator/includes/header', $header);
    $this->load->view('pharmacy/accept_pharmacy_request_modal');
    $this->load->view('pharmacy/reject_pharmacy_request_modal');
    $this->load->view('pharmacy/view_one_request',$data);
  }


}
