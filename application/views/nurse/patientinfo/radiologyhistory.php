<section id="main-content">
    <section class="wrapper">
                <div class="row">
             <div class="col-lg-12">
                 <section class="panel">
                     <header class="panel-heading">
                        <center><?php echo $this->uri->segment(3);?> Radiology History</center>
                     </header>
                     <div class="panel-body">
                         <section id="flip-scroll">
                             <table class="table table-bordered table-striped table-condensed cf">
                                 <thead class="cf">
                                 <tr>
                                   <th>ID</th>
                                   <th>Date of Request</th>
                                   <th>Radiology Exam</th>
                                   <th>Request Note</th>
                                   <th>Status</th>
                                   <th>Result</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                  <?php
                                    foreach($radiology_data as $data){
                                      echo "<tr>";
                                        echo "<td>".$data['request_id']."</td>";
                                        echo "<td>".$data['request_date']."</td>";
                                        echo "<td>".$data['exam_name']."</td>";
                                        echo "<td>".$data['req_notes']."</td>";
                                        echo "<td>".$data['request_status']."</td>";
                                        echo "<td><a href='#' class='btn btn-info btn-xs'><i class='fa fa-eye'></i> VIEW</a></td>";
                                      echo "</tr>";
                                    }
                                  ?>
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
