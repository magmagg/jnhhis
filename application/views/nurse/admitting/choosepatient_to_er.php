<section id="main-content">
  <section class="wrapper">
    <div class="row">
      <div class="col-sm-6">
        <section class="panel">
            <header class="panel-heading" align="center">LIST OF PATIENTS</header>
            <table class="table">
              <center>
              <?php
                $attributes = array('class'=>'form-horizontal', 'role'=>'form');
                echo form_open(base_url().'Nurse/admit_patient_to_ER/'.$bed_id, $attributes);
              ?>
              <div class="form-group">
                  <div class="col-lg-12">
                    <select name="patient" size="20" style="height: 100%;">
                      <?php
                        foreach($patients as $patient){
                          echo "<option value='".$patient['patient_id']."'>";
                            echo $patient['patient_id'].": ".$patient['first_name']." ".$patient['middle_name']." ".$patient['last_name'];
                          echo "</option>";
                        }
                      ?>
                    </select>
                  </div>
              </div>
              <br>
              <div class="form-group">
                  <div class="col-lg-12">
                    <input type="submit" name="submit" id="submit" value="Select" class="btn btn-info">
                  </div>
              </div>
              <?=form_close()?>
            </center>
            </table>
        </section>
      </div>
      <div class="col-sm-6">
        <center>
        <section class="panel">
            <header class="panel-heading" align="center">NEW PATIENT</header>
            <div class="panel-body">
              <?php
                $attributes = array('class'=>'form-horizontal', 'role'=>'form');
                echo form_open('admin/insert_patient', $attributes);
              ?>
              <div class="form-group">
                  <label  class="col-lg-3 col-sm-3 control-label">Last Name: </label>
                  <div class="col-lg-9">
                      <input type="text" name="lastname" class="form-control" placeholder="Last Name">
                  </div>
              </div>

              <div class="form-group">
                  <label  class="col-lg-3 col-sm-3 control-label">First Name: </label>
                  <div class="col-lg-9">
                      <input type="text" name="firstname" class="form-control" placeholder="First Name">
                  </div>
              </div>

              <div class="form-group">
                  <label  class="col-lg-3 col-sm-3 control-label">Middle Name: </label>
                  <div class="col-lg-9">
                      <input type="text" name="middlename" class="form-control" placeholder="Middle Name">
                  </div>
              </div>

              <div class="form-group">
                  <label  class="col-lg-3 col-sm-3 control-label">Gender: </label>
                  <div class="col-lg-9">
                    <div class="radios">
                        <label class="label_radio" for="radio-01">
                            <input name="gender" id="radio-01" value="M" type="radio" checked /> MALE &nbsp;
                            <input name="gender" id="radio-02" value="F" type="radio" /> FEMALE
                        </label>
                    </div>
                  </div>
              </div>

              <div class="form-group">
                  <label  class="col-lg-3 col-sm-3 control-label">Age: </label>
                  <div class="col-lg-9">
                      <input type="number" name="age" class="form-control" placeholder="Age">
                  </div>
              </div>

              <div class="form-group">
                  <label  class="col-lg-3 col-sm-3 control-label">Birth Date: </label>
                  <div class="col-lg-9">
                      <input type="date" name="birthday" class="form-control">
                  </div>
              </div>

              <div class="form-group">
                  <label  class="col-lg-3 col-sm-3 control-label">Birth Place: </label>
                  <div class="col-lg-9">
                      <input type="text" name="birthplace" class="form-control" placeholder="Birhplace">
                  </div>
              </div>

              <div class="form-group">
                  <label  class="col-lg-3 col-sm-3 control-label">Occupation: </label>
                  <div class="col-lg-9">
                      <input type="text" name="occupation" class="form-control" placeholder="Occupation">
                  </div>
              </div>

              <div class="form-group">
                  <label  class="col-lg-3 col-sm-3 control-label">Religion: </label>
                  <div class="col-lg-9">
                      <input type="text" name="religion" class="form-control" placeholder="Religion">
                  </div>
              </div>

              <div class="form-group">
                  <label  class="col-lg-3 col-sm-3 control-label">Nationality: </label>
                  <div class="col-lg-9">
                      <input type="text" name="nationality" class="form-control" placeholder="Nationality">
                  </div>
              </div>

              <div class="form-group">
                  <label  class="col-lg-3 col-sm-3 control-label">Address: </label>
                  <div class="col-lg-9">
                      <input type="text" name="address" class="form-control" placeholder="Address">
                  </div>
              </div>

              <div class="form-group">
                  <label  class="col-lg-3 col-sm-3 control-label">Telephone Number: </label>
                  <div class="col-lg-9">
                      <input type="text" name="telephone_number" class="form-control" placeholder="Telephone Number">
                  </div>
              </div>

              <div class="form-group">
                  <label  class="col-lg-3 col-sm-3 control-label">Mobile Number: </label>
                  <div class="col-lg-9">
                      <input type="text" name="mobile_number" class="form-control" placeholder="Mobile Number">
                  </div>
              </div>

              <div class="form-group">
                  <label  class="col-lg-3 col-sm-3 control-label">Email: </label>
                  <div class="col-lg-9">
                      <input type="email" name="email" class="form-control" placeholder="Email">
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-lg-12">
                    <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-info">
                    <input type="hidden" name="url" value="<?=current_url()?>">
                  </div>
              </div>
              <?=form_close()?>
            </div>
        </section>
      </center>
      </div>
    </div>
  </section>
</section>
