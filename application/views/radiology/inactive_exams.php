<section id="main-content">
  <section class="wrapper">
    <div class="row">
      <div class="col-sm-3">
          <section class="panel">
              <header class="panel-heading" style="background-color: #000;"></header>
              <table class="table">
                <tr>
                  <td colspan="2" align="center"><h5><a class="btn btn-info" data-toggle="modal" href="#myModal5">+ADD NEW EXAM</a></h5></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><h5><a class="btn btn-info" data-toggle="modal" href="<?=base_url()?>Radiology/Maintenance">SHOW ACTIVE EXAM</a></h5></td>
                </tr>
              </table>
          </section>
      </div>
      <div class="col-sm-9">
        <section class="panel">
          <header class="panel-heading">
              <center><h4>RADIOLOGY EXAMS<h4></center>
          </header>
          <table class="table table-hovered" style="text-align: center;">
            <tr id="tblheader">
              <td>ID</td>
              <td>Name</td>
              <td>Description</td>
              <td>Action</td>
            </tr>
            <?php
              foreach($radiology_exams as $radiology_exam){
                echo "<tr>";
                  echo "<td>".$radiology_exam['exam_id']."</td>";
                  echo "<td>".$radiology_exam['exam_name']."</td>";
                  echo "<td>".$radiology_exam['exam_description']."</td>";
                  echo "<td>";
                    echo "<a href='".base_url()."Radiology/ActivateExam/".$radiology_exam['exam_id']."' role='button' class='btn btn-default btn-sm'>Activate</a>";
                  echo "</td>";
                echo "</tr>";
              }
            ?>
          </table>
        </section>
      </div>
    </div>

    <div class="modal fade modal-dialog-center" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content-wrap">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" align="center">Add Radiology Exam</h4>
                    </div>
                    <div class="modal-body">
                      <?php
                        $attributes = array('class'=>'form-horizontal', 'role'=>'form');
                        echo form_open('radiology/insert_radiology_exam', $attributes);
                      ?>

                      <div class="form-group">
                          <label  class="col-lg-3 col-sm-3 control-label">Exam Name: </label>
                          <div class="col-lg-9">
                              <input type="text" name="name" class="form-control" placeholder="Exam Name">
                          </div>
                      </div>

                      <div class="form-group">
                          <label  class="col-lg-3 col-sm-3 control-label">Exam Description: </label>
                          <div class="col-lg-9">
                              <input type="text" name="description" class="form-control" placeholder="Exam Description">
                          </div>
                      </div>

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                        <input type="submit" value="Submit" class="btn btn-warning">
                    </div>
                    <?=form_close()?>
                </div>
            </div>
        </div>
    </div>
  </section>
</section>
