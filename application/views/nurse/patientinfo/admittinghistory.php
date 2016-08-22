<section id="main-content">
    <section class="wrapper">
                <div class="row">
             <div class="col-lg-12">
                 <section class="panel">
                     <header class="panel-heading">
                        <center><?php echo $this->uri->segment(3);?> Admitting History</center>
                     </header>
                     <div class="panel-body">
                         <section id="flip-scroll">
                             <table class="table table-bordered table-striped table-condensed cf">
                                 <thead class="cf">
                                 <tr>
                                   <th>ID</th>
                                   <th>Admitting Date</th>
                                   <th>Discharge Data</th>
                                   <th>Admitting Resident</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                  <?php
                                    foreach($admitting_data as $data){
                                      echo "<tr>";
                                        echo "<td>".$data['admission_id']."</td>";
                                        echo "<td>".date('F d, Y', strtotime($data['admission_date']))."</td>";
                                        echo "<td>".date('F d, Y', strtotime($data['discharge_date']))."</td>";
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
