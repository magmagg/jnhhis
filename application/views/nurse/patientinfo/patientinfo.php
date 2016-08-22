<style>
b{color:#222;font-weight:600}
table tr td {border:0}
#patient-info tr td{border:0}
</style>
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
            <section class="panel" style="height: 100%;">
              <header class="panel-heading">
                  Patient Information
              </header>
              <table class="table" style="text-align: center;">
                <tr id="tblheader">
                  <td>
                  <?php
                      echo "<h4>";
                      if($patient->gender == 'M'){
                        echo "Mr. ";
                      }else{
                        echo "Ms. ";
                      }
                      echo $patient->first_name." ".$patient->middle_name." ".$patient->last_name;
                      echo "</h4>";
                    ?>
                </td>
                </tr>
              </table>
              <center>
              <table id="patient-info" class="table" style="width: 55%; text-align: left; ">
                <tr>
                  <td style="border:0;width: 50%;"><b>Patient Number:</b></td>
                  <td><?=" ".$patient->patient_id?></td>
                </tr>

                <tr>
                  <td style="border:0;width: 50%;"><b>Age:</b></td>
                  <td><?=" ".$patient->age?></td>
                </tr>

                <tr>
                  <td style="border:0;width: 50%;"><b>Birthday:</b></td>
                  <td><?=" ".date('F d, Y', strtotime($patient->birthdate))?></td>
                </tr>
                <tr>
                  <td style="border:0;width: 50%;"><b>Gender:</b></td>
                  <td>
                    <?php
                     if($patient->gender == 'M'){
                       echo "Male";
                     }else{
                       echo "Female";
                     }
                    ?>
                  </td>
                </tr>

                <tr>
                  <td style="border:0;width: 50%;"><b>Mobile Number:</b></td>
                  <td><?=" ".$patient->mobile_number?></td>
                </tr>

                <tr>
                  <td style="border:0;width: 50%;"><b>Telephone Number:</b></td>
                  <td><?=" ".$patient->telephone_number?></td>
                </tr>

                <tr>
                  <td style="border:0;width: 50%;"><b>Address:</b></td>
                  <td><?=" ".$patient->present_address?></td>
                </tr>

                <tr>
                  <td style="border:0;width: 50%;"><b>Nationality:</b></td>
                  <td><?=" ".$patient->nationality?></td>
                </tr>

                <tr>
                  <td colspan="2" style="text-align:left">
                    <a href="<?=base_url()?>Nurse/VitalsHistory/<?=$patient->patient_id?>" role="button" class="btn btn-shadow btn-default"><i class="fa fa-money"></i> Overall Billing</a>
                    <a href="<?=base_url()?>Nurse/AdmittingHistory/<?=$patient->patient_id?>" role="button" class="btn btn-shadow btn-primary"><i class="fa fa-archive"></i> Admitting History</a>
                    <a href="<?=base_url()?>Nurse/VitalsHistory/<?=$patient->patient_id?>" role="button" class="btn btn-shadow btn-success"><i class="fa fa-h-square"></i> Vital Signs</a>
                    <br>
                    <br>
                    <a href="<?=base_url()?>Nurse/PharmacyHistory/<?=$patient->patient_id?>" role="button" class="btn btn-shadow btn-info"><i class="fa fa-medkit"></i> Pharmacy</a>
                    <a href="<?=base_url()?>Nurse/LaboratoryHistory/<?=$patient->patient_id?>" role="button" class="btn btn-shadow btn-warning"><i class="fa fa-flask"></i> Laboratory</a>
                    <a href="<?=base_url()?>Nurse/RadiologyHistory/<?=$patient->patient_id?>" role="button" class="btn btn-shadow btn-danger"><i class="fa fa-stethoscope"></i> Radiology</a>
                  </td>
                </tr>
              </table>
            </section>
          </div>
      </div>
  </section>
</section>
