<section id="main-content">
    <section class="wrapper">
      <section class="panel">
          <header class="panel-heading">
              <b>Emergency Room</b>
              <span class="pull-right">
                  <a href="<?php echo base_url();?>nurse/EmergencyRoom"><button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button></a>
              </span>
          </header>
          <table class="table table-hover p-table">
              <thead>
              <tr>
                  <th>Bed #</th>
                  <th>Patient ID</th>
                  <th>Patient Name</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
              </thead>
              <tbody>
                <?php
                  foreach($emergency_room_data as $data){
                    echo "<tr>";
                      echo "<td class='p-name'>".$data['bed_id']."</td>";
                      echo "<td>".$data['patient_id']."</td>";
                    if($data['patient_id'] == ""){
                      echo "<td><span class='label label-success'>EMPTY</span></td>";
                      echo "<td><span class='label label-success'>AVAILABLE</span></td>";
                      echo "<td>";
                        echo "<a href='".base_url()."Nurse/ChoosePatient/".$data['bed_id']."' role='button' class='btn btn-info btn-xs'>ADMIT PATIENT</a>";
                      echo "</td>";
                    }else{
                      echo "<td>".$data['first_name']." ".$data['middle_name']." ".$data['last_name']."</td>";
                      echo "<td><span class='label label-danger'>EMPTY</span></td>";
                      echo "<td>";
                        echo "<a href='".base_url()."Admin/DischargePatient/".$data['patient_id']."/".$data['bed_id']."' role='button' class='btn btn-default btn-xs'>DISCHARGE</a>'";
                        echo "<a href='".base_url()."Admin/PatientList/".$data['patient_id']."' role='button' class='btn btn-default btn-xs'>PATIENT INFO</a>'";
                        echo "<a href='#' role='button' class='btn btn-default btn-xs'>GO TO PHARMACY</a>'";
                        echo "<a href='#' role='button' class='btn btn-default btn-xs'>TRANSFER ROOM</a>'";
                      echo "</td>";
                    }
                    echo "</tr>";
                  }
                ?>
              </tbody>
          </table>
      </section>
    </section>
</section>
