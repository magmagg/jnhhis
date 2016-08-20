

<section id="main-content">
    <section class="wrapper">
        <div class="row">


              <div class="col-lg-12">

                 <section class="panel">
                   <header class="panel-heading">
                      Roles and Permission Settings
                      <a  class="btn btn-primary btn-sm pull-right" data-toggle="modal" href="#myModal1"><i class="fa fa-plus"> Add permission</i></a>

                      <a  class="btn btn-danger btn-sm pull-right" data-toggle="modal" href="#myModal3"><i class="fa fa-plus"> Add task</i></a>

                   </header>

                   <div class="panel-body">
                     <div class="adv-table">

                       <table class="table table-striped">

                            <thead>
                              <tr>
                                <th>Task logo</th>
                                <th>Task name</th>
                                <th>Action</th>
                              </tr>

                               <tbody>
                                 <?php foreach ($task_names as $task_name): ?>


                                  <tr>
                                    <td><i class="<?php echo $task_name['task_logo']; ?>"></i> <?php echo $task_name['task_logo']; ?></td>
                                    <td><?php echo $task_name['task_name']; ?></td>
                                  </tr>

                                       <?php endforeach; ?>
                               </tbody>

                            </thead>


                       </table>

                       <hr>
                       <header class="panel-heading">
                          <strong>Permissions</strong>
                        </header>


                       <table class="table table-striped display nowrap" style="text-align: center;" id="dynamic-table">

                            <thead>
                              <tr>
                                <th>Permission name</th>
                                <th>Permission link</th>
                              </tr>

                               <tbody>
                                 <?php foreach ($permissions as $permission): ?>


                                  <tr>
                                    <td><?php echo $permission['permission_name']; ?></td>
                                    <td><?php echo $permission['permission_link']; ?></td>
                                  </tr>

                                       <?php endforeach; ?>
                               </tbody>

                            </thead>


                       </table>


                     </div>
                   </div>






                 </section>





              </div>





        </div>
    </section>

</section>


<!-- modal for add task -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">New Task</h4>
            </div>
            <div class="modal-body">
            <?php echo form_open('Admin/addtask'); ?>
              <div class="form-group">

                <input type="text" name="taskname" class="form-control"  placeholder="Task name"><br>
                <input type="text" name="tasklogo" class="form-control"  placeholder="Task logo (e.g. fa fa-users)"><br>

              </div>


            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="submit"> Add</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- end of modal task -->

<!-- modal for add permission -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">New permission</h4>
            </div>
            <div class="modal-body">
            <?php echo form_open('Admin/addpermission'); ?>
              <div class="form-group">
                  <select name="taskid" class="form-control">

                    <?php foreach ($task_names as $task_name): ?>
                        <option value="<?php echo $task_name['task_id'];?>"><?php echo $task_name['task_name']; ?></option>
                    <?php endforeach; ?>

                  </select>
                  <br>
                <input type="text" name="permissionname" class="form-control"  placeholder="permission name"><br>
                <input type="text" name="permissionlink" class="form-control"  placeholder="Permission link (e.g. Admin/index)"><br>

              </div>


            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="submit"> Add</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- end of modal permission -->








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
