<section id="main-content">
    <section class="wrapper">
      <section class="panel">
          <header class="panel-heading">
              <b>SELECT ROOM</b>
              <span class="pull-right">
                  <a href="<?php echo base_url();?>Nurse/DirectRoomAdmission"><button type="button" id="loading-btn" class="btn btn-warning btn-xs"><i class="fa fa-refresh"></i> Refresh</button></a>
              </span>
          </header>
          <table class="table table-hover p-table">
              <thead>
              <tr>
                <td>#</td>
                <td>Name</td>
                <td>Beds Available</td>
                <td>Price</td>
                <td>Action</td>
              </tr>
              </thead>
              <tbody>
                <?php
                  foreach($rooms as $room){
                    echo "<tr>";
                      echo "<td>".$room['room_id']."</td>";
                      echo "<td>".$room['room_name']."</td>";
                      echo "<td></td>";
                      echo "<td>".$room['room_price']."</td>";
                      echo "<td><a href='".base_url()."Nurse/ChooseBed/".$room['room_id']."' role='button' class='btn btn-info btn-xs'>SELECT ROOM</a></td>";
                    echo "</tr>";
                  }
                ?>
              </tbody>
          </table>
      </section>
    </section>
</section>
