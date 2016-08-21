<section id="main-content">
    <section class="wrapper">
      <section class="panel">
          <header class="panel-heading">
              <b>Room List</b>
              <span class="pull-right">
                  <a href="<?php echo base_url();?>Nurse/AdmittedPatients"><button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button></a>
              </span>
          </header>
          <table class="table table-hover p-table">
              <thead>
              <tr>
                <td>ID</td>
                <td>ROOM TYPE</td>
                <td>ACTION</td>
              </tr>
              </thead>
              <tbody>
                <?php
                foreach($rooms as $room){
                  echo "<tr>";
                    echo "<td>".$room['room_type_id']."</td>";
                    echo "<td>".$room['room_name']."</td>";
                    echo "<td>";
                      echo "<a href='".base_url()."Nurse/AdmittedPatients/".$room['room_id']."' role='button' class='btn btn-info btn-xs'>View Admitted Patients</a>";
                    echo "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
          </table>
      </section>
    </section>
</section>
