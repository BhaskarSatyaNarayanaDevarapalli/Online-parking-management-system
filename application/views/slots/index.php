

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>Slots</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Slots</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">

          <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php elseif($this->session->flashdata('error')): ?>
            <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>

          <?php if(in_array('createSlots', $user_permission)): ?>
            <a href="<?php echo base_url('slots/create') ?>" class="btn btn-primary"> <i class="fa fa-plus"></i> Add Slot</a>
            <br /> <br />
          <?php endif; ?>

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Manage Slots</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="datatables" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Slot Name</th>
                  <th>Active</th>
                  <th>Availability</th>
                  <?php if(in_array('updateSlots', $user_permission) || in_array('deleteSlots', $user_permission)): ?>
                    <th>Action</th>
                  <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                  <?php foreach ($slot_data as $k => $v) {
                    ?>
                    <tr>
                      <td><?php echo $v['slot_name'] ?></td>
                      <td>
                        <?php if($v['active'] == 1) { ?>
                          <span class="label label-success">Active</span>
                        <?php } 
                        else { ?>
                          <span class="label label-warning">Inactive</span>
                        <?php } ?>
                      </td>
                      <td>
                        <?php if($v['availability_status'] == 1) { ?>
                          <span class="label label-success">Yes</span>
                        <?php } 
                        else { ?>
                          <span class="label label-warning">No</span>
                        <?php } ?>
                      </td>
                      <?php if(in_array('updateSlots', $user_permission) || in_array('deleteSlots', $user_permission)): ?>
                      <td>
                        <?php if(in_array('updateSlots', $user_permission)): ?>
                          <a href="<?php echo base_url('slots/edit/'.$v['id']) ?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                        <?php endif; ?>
                        <?php if(in_array('deleteSlots', $user_permission)): ?>
                          <a href="<?php echo base_url('slots/delete/'.$v['id']) ?>" class="btn btn-default"><i class="fa fa-trash"></i></a>
                        <?php endif; ?>
                      </td>
                      <?php endif; ?>
                    </tr>
                    <?php
                  } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function() {
      $('#datatables').DataTable();

      $("#slotsSideTree").addClass('active');
      $("#manageSlotsSideTree").addClass('active');
    });
  </script>
