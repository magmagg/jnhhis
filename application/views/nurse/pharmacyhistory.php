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
                                   <th>Item Name</th>
                                   <th>Quantity</th>
                                   <th>Status</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                  <?php
                                    foreach($pharmacy_data as $data){
                                      echo "<tr>";
                                        echo "<td>".$data['phar_req_id']."</td>";
                                        echo "<td>".date('F d, Y', strtotime($data['phar_req_date']))."</td>";
                                        echo "<td>".$data['item_name']."</td>";
                                        echo "<td>".$data['phar_req_quan']."</td>";
                                        echo "<td>PENDING (DUMMY)</td>";
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
