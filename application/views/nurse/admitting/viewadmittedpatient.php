<section id="main-content">
    <section class="wrapper">
      <section class="panel">
          <header class="panel-heading">
              <b>ADMITTED PATIENTS</b>
              <span class="pull-right">
                  <a href="<?php echo base_url();?>Nurse/AdmittedPatients"><button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button></a>
              </span>
          </header>
          <table class="table table-hover p-table">
              <thead>
              <tr>
                <td>Bed #</td>
                <td>Patient ID</td>
                <td>Patient Checked-In</td>
                <td>Status</td>
                <td>Action</td>
              </tr>
              </thead>
              <tbody>
                <?php
                foreach($beds as $bed){
                  echo "<tr>";
                    echo "<td>".$bed['bed_id']."</td>";
                    echo "<td>".$bed['patient_id']."</td>";
                    if($bed['patient_id'] == ""){
                      echo "<td>EMPTY</td>";
                      echo "<td>AVAILABLE</td>";
                      echo "<td>";
                        echo "<a href='".base_url()."Nurse/ChoosePatientToDR/".$bed['bed_id']."/".$bed['bed_roomid']."' role='button' class='btn btn-default btn-xs'>ADD</a>'";
                      echo "</td>";
                    }else{
                      echo "<td>".$bed['first_name']." ".$bed['middle_name']." ".$bed['last_name']."</td>";
                      echo "<td>OCCUPIED</td>";
                      echo "<td>";
                        echo "<a href='".base_url()."Nurse/DischargePatient/".$bed['patient_id']."/".$bed['bed_id']."' role='button' class='btn btn-success btn-xs'>DISCHARGE</a>'";
                        echo "<a href='".base_url()."Nurse/PatientList/".$bed['patient_id']."' role='button' class='btn btn-info btn-xs'>PATIENT INFO</a>'";
                        echo "<a href='#' role='button' class='btn btn-warning btn-xs'>GO TO PHARMACY</a>'";
                        echo "<a href='".base_url()."Nurse/TransferRoom/".$bed['patient_id']."/' role='button' class='btn btn-danger btn-xs'>TRANSFER ROOM</a>'";
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
