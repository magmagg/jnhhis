<section id="main-content">
    <section class="wrapper">
      <section class="panel">
          <header class="panel-heading">
              <b>Transfer Bed</b>
              <span class="pull-right">
                  <a href="<?php echo base_url();?>Nurse/ChooseBed"><button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button></a>
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
                      echo "<td>EMPTY</td>";
                      echo "<td>AVAILABLE</td>";
                      echo "<td>";
                        echo "<a href='".base_url()."Nurse/TransferPatient/".$patientid."/".$bed['bed_id']."/".$roomid."' role='button' class='btn btn-info btn-xs'>TRANSFER</a>'";
                      echo "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
          </table>
      </section>
    </section>
</section>
