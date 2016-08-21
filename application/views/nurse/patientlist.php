<title><?php echo $title; ?></title>
<section id="main-content">
    <section class="wrapper">
      <!-- page start-->
      <section class="panel">

          <header class="panel-heading">
              Patient Vital Signs
              <span class="pull-right">
                  <a href="<?php echo base_url();?>plan/vitalsigns"><button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button></a>
              </span>
          </header>
          <div class="panel-body">
              <div class="row">
                <?php echo form_open("Nurse/PatientList"); ?>
                  <div class="col-md-12">
                      <div class="input-group"><input type="text" name="keyword" placeholder="Search Here" class="input-sm form-control"> <span class="input-group-btn">
                      <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Search</button> </span></div>
                  </div>
                </form>
              </div>
          </div>
          <table class="table table-hover p-table">
              <thead>
              <tr>
                  <th>Patient Name</th>
                  <th>Date registered</th>
                  <th>Patient Status</th>
                  <th>Custom</th>
              </tr>
              </thead>
              <tbody>


                <?php foreach ($patients as $patient) {
                      $fullname = $patient['first_name']." ".$patient['middle_name'].". ".$patient['last_name'];
                  ?>
              <tr>
                  <td class="p-name">
                      <?php echo $fullname; ?>
                      <br>
                      <small>Checked in <?php echo $patient['date_checkin']; ?></small>
                  </td>
                  <td class="p-name">
                      <p><?php echo $patient['date_registered'];?></p>
                  </td>

                  <td>
                      <span class="label label-primary">Active</span>
                  </td>
                  <td>
                      <!-- <a href="project_details.html" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a> -->
                      <a href="<?php echo base_url()?>Nurse/vitalshistory/<?php echo $patient['patient_id'];?>" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> Vital Signs</a>
                      <a href="<?php echo base_url()?>Nurse/admittinghistory/<?php echo $patient['patient_id'];?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Admitting History </a>
                      <a href="<?php echo base_url()?>Nurse/vitalshistory/<?php echo $patient['patient_id'];?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i> Overall Billing </a>
                      <a href="<?php echo base_url()?>Nurse/laboratoryhistory/<?php echo $patient['patient_id'];?>" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i> Laboratory </a>
                      <a href="<?php echo base_url()?>Nurse/radiologyhistory/<?php echo $patient['patient_id'];?>" class="btn btn-danger btn-xs"><i class="fa fa-eye"></i> Radiology </a>
                      <a href="<?php echo base_url()?>Nurse/pharmacyhistory/<?php echo $patient['patient_id'];?>" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Pharmacy</a>
                      <!-- <a href="<?php echo base_url()?>plan/deleteplan/<?php echo $patient['patient_id'];?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a> -->
                      <!-- <a href="#<?php echo $patient['patient_id']; ?>" class="btn btn-danger btn-xs" data-toggle="modal" ><i class="fa fa-trash-o"></i> Delete </a> -->
                  </td>
              </tr>


              <div class="modal fade modal-dialog-center" id="<?php echo $patient['patient_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content-wrap">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Confirmation</h4>
                                            </div>
                                            <div class="modal-body">

                                                Are you sure you want to delete <?php echo $patient['first_name'];?>?

                                            </div>
                                            <div class="modal-footer">
                                                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                                <a href="<?php echo base_url()?>plan/deleteplan/<?php echo $patient['planKey'];?>"><button class="btn btn-danger" type="button"> Confirm</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



              <?php } ?>




              </tbody>
          </table>
      </section>
      <!-- page end-->






    </section>
  </section>
      <!--main content end-->
