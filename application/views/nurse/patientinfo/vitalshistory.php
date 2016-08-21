<section id="main-content">
    <section class="wrapper">
                <div class="row">
             <div class="col-lg-12">
                 <section class="panel">
                   <h1 style="color: red;"></h1>
                     <header class="panel-heading">
                        <?php echo $this->uri->segment(3); ?> Vital signs History
                        <a class='btn btn-primary btn-sm pull-right' data-toggle="modal" href="#myModal3">Record Vital Sign</a>
                     </header>
                     <div class="panel-body">
                         <section id="flip-scroll">
                             <table class="table table-bordered table-striped table-condensed cf">
                                 <thead class="cf">
                                 <tr>
                                     <th>ID</th>
                                     <th>Date</th>
                                     <th>Time</th>
                                     <th class="numeric">Heart rate (pulse)</th>
                                     <th class="numeric">Respiratory rate</th>
                                     <th class="numeric">Blood pressure</th>
                                     <th class="numeric">Body temperature (Celsius)</th>
                                     <th>Nurse</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                   <tr>
                                     <?php
                                      foreach($vitalsign_data as $data){
                                        echo "<tr>";
                                          echo "<td>".$data['vital_id']."</td>";
                                          echo "<td>".date('F d, Y', strtotime($data['date_recorded']))."</td>";
                                          echo "<td>".date('H:i:s', strtotime($data['date_recorded']))."</td>";
                                          echo "<td>".$data['heart_rate']."</td>";
                                          echo "<td>".$data['resp_rate']."</td>";
                                          echo "<td>".$data['blood_pres']."</td>";
                                          echo "<td>".$data['body_temp']."</td>";
                                          echo "<td>".$data['first_name']." ".$data['middle_name']." ".$data['last_name']."</td>";
                                        echo "</tr>";
                                      }
                                     ?>
                                   </tr>
                                 </tbody>
                             </table>
                         </section>
                     </div>
                 </section>
             </div>
          </div>
    </section>
  </section>
      <!--main content end-->

      <!-- Modal -->
      <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Vital Sign Record</h4>
                  </div>
                  <div class="modal-body">
                  <?php echo form_open('Nurse/recordvitalsign/'.$this->uri->segment(3)); ?>
                    <div class="form-group">
                      <input type="text" name="heartrate" class="form-control"  placeholder="Heart Rate"><br>
                      <input type="text" name="respiratoryrate" class="form-control"  placeholder="Respiratory Rate"><br>
                      <input type="text" name="bloodpressure" class="form-control"  placeholder="Blood Pressure"><br>
                      <input type="text" name="temperature" class="form-control"  placeholder="Body Temperature"><br>
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button class="btn btn-danger" type="submit">Submit</button>
                  </div>
                  <?php echo form_close();?>
              </div>
          </div>
      </div>
      <!-- modal -->
