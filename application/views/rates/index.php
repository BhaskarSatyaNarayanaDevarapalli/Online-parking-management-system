

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>Rates</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Rates</li>
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

          <?php if(in_array('createRates', $user_permission)): ?>
            <a href="<?php echo base_url('rates/create') ?>" class="btn btn-primary"> <i class="fa fa-plus"></i> Add Rate</a>
            <br /> <br />
          <?php endif; ?>

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Manage Rates</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="datatables" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Rate name</th>
                  <th>Type</th>
                  <th>Rate</th>
                  <th>Category</th>
                  <th>Status</th>
                  <?php if(in_array('updateRates', $user_permission) || in_array('deleteRates', $user_permission)): ?>
                    <th>Action</th>
                  <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                  <?php foreach ($rates_data as $k => $v) {
                    ?>
                    <tr>
                      <td><?php echo $v['rate_info']['rate_name']; ?></td>
                      <td><?php echo ($v['rate_info']['type'] == 1) ? 'Fixed': 'Hourly'; ?></td>
                      <td><?php echo '$ '. $v['rate_info']['rate']; ?></td>
                      <td><?php echo $v['cat_info']['name']; ?></td>
                      <td>
                        <?php if($v['rate_info']['active'] == 1) { ?>
                          <span class="label label-success">Active</span>
                        <?php } 
                        else { ?>
                          <span class="label label-warning">Inactive</span>
                        <?php } ?>
                      </td>
                      <?php if(in_array('updateRates', $user_permission) || in_array('deleteRates', $user_permission)): ?>
                      <td>
                        <?php if(in_array('updateRates', $user_permission)): ?>
                          <a href="<?php echo base_url('rates/edit/'.$v['rate_info']['id']) ?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                        <?php endif; ?>
                        <?php if(in_array('deleteRates', $user_permission)): ?>
                          <a href="<?php echo base_url('rates/delete/'.$v['rate_info']['id']) ?>" class="btn btn-default"><i class="fa fa-trash"></i></a>
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

      $("#ratesSideTree").addClass('active');
      $("#manageRatesSideTree").addClass('active');
    });
  </script>
