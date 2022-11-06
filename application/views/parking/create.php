

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>Parking</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Parking</li>
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
              <h3 class="box-title">Add Parking</h3>
            </div>
            <form role="form" action="<?php base_url('parking/create') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="group_name">Slot</label>
                  <select class="form-control" id="parking_slot" name="parking_slot">
                    <option value="">~~Select~~</option>
                    <?php foreach ($slot_data as $k => $v): ?>
                        <option value="<?php echo $v['id'] ?>"><?php echo $v['slot_name']; ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="group_name">Category</label>
                  <select class="form-control" id="vehicle_cat" name="vehicle_cat">
                    <option value="">~~Select~~</option>
                    <?php foreach ($vehicle_cat as $k => $v): ?>
                      <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="group_name">Rate</label>
                  <select class="form-control" id="vehicle_rate" name="vehicle_rate">
                    <option value="">~~Select Category~~</option>
                  </select>
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('parking/') ?>" class="btn btn-warning">Back</a>
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
      $("#parkingSideTree").addClass('active');
      $("#createParkingSideTree").addClass('active');

      $('#parking_slot').select2();

      $("#vehicle_cat").on('change', function() {
        var value = $(this).val();

        $.ajax({
          url: <?php echo "'". base_url('parking/getCategoryRate/') . "'"; ?>  + value,
          type: 'post',
          dataType: 'json',
          success:function(response) {
            $("#vehicle_rate").html(response);
          }
        });
      });
    });
  </script>
