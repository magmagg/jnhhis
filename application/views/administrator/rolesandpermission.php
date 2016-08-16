	<style>
	table tbody td{
		min-width: 100px;
	}
	</style>
  <!--sidebar end-->
  <!--main content start-->
  <section id="main-content">
      <section class="wrapper">
		<div class="row">
        <div class="col-lg-12">
               <section class="panel">
                   <header class="panel-heading">
                      Roles and Permission

                       <a  class="btn btn-primary btn-sm pull-right" data-toggle="modal" href="#myModal3"><i class="fa fa-plus"></i></a>
                   </header>

					<div class="panel-body">
						<div class="adv-table" >
							<table class="table table-striped display nowrap" cellspacing="0" width="100%" style="text-align: center;" id="dynamic-table">

                               <thead>
                               <tr>
                                  <th>Action</th>
                                   <th>id</th>
                                   <th>Role name</th>
                                   <?php foreach ($task_names as $task_name) { ?>


                                   <th><?php echo $task_name['task_name']; ?></th>
                                  <?php } ?>
                               </tr>
                               </thead>
                               <tbody>

                                 <?php foreach ($user_types as $user_type) {
                                ?>
                               <tr>

                                    <td><i class='fa fa-trash-o'> | <a href="#"
                                      data-rolename="<?php echo $user_type['name'];?>"
                                      data-userTypeId="<?php echo $user_type['type_id']?>"
                                      onclick="editrole(this)"> <i class='fa fa-edit pull-right' data-toggle="modal"></i></a>

                                      </td>

                                   <td data-title="Code"><?= $user_type['type_id']; ?></td>
                                   <td data-title="Company"><?= $user_type['name']; ?></td>

                                   <?php
                                       foreach ($task_names as $task_name) { ?>
                                          <td>
                                              <?php

                                                  foreach ($permissions as $permission) {
                                                      echo "<table><tr>";
                                                      if($permission['task_id'] == $task_name['task_id']){ ?>



                                                          <td><?php  echo $permission['permission_name'].":<br>"; ?></td>

                                                          <?php

                                                            $flag = "";
                                                              foreach ($permittedViews as $permittedView) {

                                                                  if($permittedView['permission_id'] == $permission['permission_id']
                                                                  && $permittedView['user_type_id'] == $user_type['type_id']){

                                                                      if($permittedView['access'] == 1){
                                                                          $flag = "true";
                                                                          $var = "<i class='fa fa-check-circle'></i>";
                                                                      }


                                                                  }

                                                              }
                                                           ?>
                                                          <td><?php if(empty($flag)){echo "<i class='fa fa-circle-o'></i>";}else{echo $var;}?></td>

                                                <?php      }
                                                      echo "</tr></table>";

                                                  }

                                               ?>
                                          </td>
                                      <?php } ?>
                               </tr>
                                <?php } ?>

                             </tbody>
						</table>
              
						</div>
					</div>
				</section>

		</div>
		</div>
	</section>
</section>

  <!-- Modal -->
                              <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-sm">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                              <h4 class="modal-title">New Role</h4>
                                          </div>
                                          <div class="modal-body">
                                          <?php echo form_open('Admin/addrole'); ?>
                                            <div class="form-group">

                                              <input type="text" name="rolename" class="form-control"  placeholder="role name"><br>
                                              <textarea name="desc" class="form-control" rows="8" cols="40" placeholder="description"></textarea>
                                            </div>


                                          </div>
                                          <div class="modal-footer">
                                              <button class="btn btn-danger" type="submit"> Add</button>
                                          </div>
                                          <?php echo form_close(); ?>
                                      </div>
                                  </div>
                              </div>
                              <!-- modal -->
							  
  <!-- Modal -->
<div class="modal fade " id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">
       <div class="modal-content">
                <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title">Edit</h4>
             </div>

             <?php echo form_open('Admin/updatePermission'); ?>
   <div class="modal-body">
        Name:
        <input type="text" id="updatedrolename" name="name" class="form-control" value="<?php echo $user_type['name'];?>"><br>
        <input type="hidden" id="updatedoldname" name="oldName">
        <input type="hidden" id="hiddenusertypeid" name="hiddenUserTypeId">
                <strong>Permission</strong>
              <table>

                    <?php foreach ($task_names as $task_name) { ?>

                        <tr>

                          <td><?php echo $task_name['task_name'].":"; ?></td>
                           <td>
                              <?php foreach ($permissions as $permission) {
                                      if($task_name['task_id'] == $permission['task_id']){
                                ?>

                                    <?php echo form_checkbox('permissions[]', $permission['permission_id'])	." ".$permission['permission_name'];

                                    ?>

                                <?php } } ?>



                          </td>

                        </tr>


                    <?php
                      }
					  

                    ?>




              </table>

      </div>
    <div class="modal-footer">
    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
       <button class="btn btn-success" type="submit">Save changes</button>
         </div>
     </div>

     </form>
 </div>
</div>
                             <!-- modal -->
      

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
<script type="text/javascript">
function editrole(d){
    document.getElementById("updatedrolename").value = d.getAttribute("data-rolename")
    document.getElementById("updatedoldname").value = d.getAttribute("data-rolename")
    document.getElementById("hiddenusertypeid").value = d.getAttribute("data-userTypeId")
    $("#edit").modal()

}

$( document ).ready(function() {
   
});


</script>
