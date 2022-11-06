

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

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Edit Rate</h3>
            </div>
            <form role="form" action="<?php base_url('rates/edit') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>
                <div class="form-group">
                  <label for="group_name">Rate name</label>
                  <input type="text" class="form-control" id="rate_name" name="rate_name" placeholder="Rate name" value="<?php echo ($this->input->post('rate_name'))?:$rate_data['rate_name']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">Category</label>
                  <select class="form-control" id="category_name" name="category_name">
                    <option value="">Select Category</option>
                    <?php foreach ($category_data as $k => $v) { ?>
                      <option value="<?php echo $v['id']; ?>" <?php echo ($rate_data['vechile_cat_id'] == $v['id']) ? 'selected' : ''; ?>><?php echo $v['name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="group_name">Type</label>
                  <select class="form-control" id="type" name="type">
                    <option value="">Select Rate</option>
                    <option value="1" <?php echo ($rate_data['type'] == 1) ? 'selected':''; ?>>Fixed</option>
                    <option value="2" <?php echo ($rate_data['type'] == 2) ? 'selected':''; ?>>Hourly</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="group_name">Rate</label>
                  <input type="text" class="form-control" id="rate" name="rate" placeholder="Rate" value="<?php echo ($this->input->post('rate'))?:$rate_data['rate']; ?>">
                </div>
                <div class="form-group">
                  <label for="group_name">Active</label>
                  <select class="form-control" id="rate_status" name="rate_status">
                    <option value="1" <?php echo ($rate_data['active'] == 1) ? 'selected' : ''; ?>>Active</option>
                    <option value="2" <?php echo ($rate_data['active'] == 2) ? 'selected' : ''; ?>>Inactive</option>
                  </select>
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('rates/') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
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
    $("#ratesSideTree").addClass('active');
    $("#manageRatesSideTree").addClass('active');
  });
</script>
