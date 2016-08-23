<section id="main-content">
    <section class="wrapper">
                <div class="row">
             <div class="col-lg-12">
                 <section class="panel">
                     <header class="panel-heading">
                        <center><?php echo $this->uri->segment(3);?> Laboratory History</center>
                     </header>
                     <div class="panel-body">
                         <section id="flip-scroll">
                             <table class="table table-bordered table-striped table-condensed cf">
                                 <thead class="cf">
                                 <tr>
                                   <th>ID</th>
                                   <th>Date of Request</th>
                                   <th>Laboratory Exam</th>
                                   <th>Specimen</th>
                                   <th>Status</th>
                                   <th>Results</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                  <?php
                                    foreach($laboratory_data as $data){
                                      echo "<tr>";
                                        echo "<td>".$data['lab_id']."</td>";
                                        echo "<td>".date('F d, Y', strtotime($data['lab_date_req']))."</td>";
                                        echo "<td>".$data['lab_exam_type_name']."</td>";
                                        echo "<td>DUMMY</td>";
                                        echo "<td>".$data['lab_status']."</td>";
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
