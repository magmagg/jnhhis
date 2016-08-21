<section id="main-content">
  <section class="wrapper">
    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
      				<div class="panel-body">
      				<div class="adv-table">
                <table class="table">
                    <tr>
                    </tr>
                    <tr>
                      <td>Overall Patients: </td>
                      <td><?=$total_patients_count?></td>
                    </tr>
                    <tr>
                      <td>Patients Admitted: </td>
                      <td><?=$total_admitted_patients_count?></td>
                    </tr>
                    <tr>
                      <td>Patients in ER: </td>
                      <td><?=$total_admitted_in_er_count?></td>
                    </tr>
                </table>
				</div>
				</div>
            </section>
        </div>
        <div class="col-sm-9">
            <section class="panel">
                  <header style="font-weight:300" class="panel-heading">
						 Patient List
					 <span class="tools pull-right">
					 </span>
				  </header>
				<div class="panel-body">
				<div class="adv-table">
                <table class="table table-striped" id="dynamic-table">
                    <thead>
                    <tr>
                        <th>Patient No.</th>
                        <th>Name</th>
                        <th>Date Registered</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody align="center">
                      <?php
                        foreach($patients as $patient){
                          echo "<tr>";
                            echo "<td>".$patient['patient_id']."</td>";
                            echo "<td>";
                              if($patient['gender'] == 'M'){
                                echo "Mr. ";
                              }else{
                                echo "Ms. ";
                              }
                              echo $patient['first_name']." ".$patient['middle_name']." ".$patient['last_name'];
                            echo "</td>";
                            echo "<td>".date('F d, Y', strtotime($patient['date_registered']))."</td>";
                            echo "<td>";
                              echo "<div class='btn-group' role='group' aria-label='...'>";
                                echo "<a href='".base_url()."Nurse/PatientList/".$patient['patient_id']."' role='button' class='btn btn-sm btn-info'>View</a>";
                              echo "</div>";
                            echo "</td>";
                          echo "</tr>";
                        }
                      ?>
                    </tbody>
                </table>
				</div>
				</div>
            </section>
        </div>
    </div>
  </section>
</section>

<script src="<?=base_url()?>js/jquery.js"></script>
<script src="<?=base_url()?>js/bootstrap.min.js"></script>

<script class="include" type="text/javascript" src="<?=base_url()?>js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?=base_url()?>js/jquery.scrollTo.min.js"></script>
<script src="<?=base_url()?>js/jquery.nicescroll.js" type="text/javascript"></script>

<!--right slidebar-->
<script src="<?=base_url()?>js/slidebars.min.js"></script>
<!--common script for all pages-->
<script src="<?=base_url()?>js/common-scripts.js"></script>

<!--dynamic table initialization -->
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>assets/data-tables/DT_bootstrap.js"></script>
<script src="<?php echo base_url()?>js/dynamic_table_init.js"></script>
