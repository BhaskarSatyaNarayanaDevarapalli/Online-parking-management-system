

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
              <h3 class="box-title">Edit Parking</h3>
            </div>
            <form role="form" action="<?php base_url('parking/edit') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="group_name">Slot</label>
                  <select class="form-control" id="parking_slot" name="parking_slot">
                    <option value="">~~Select~~</option>
                    <?php foreach ($slot_data as $k => $v): ?>
                        <option value="<?php echo $v['id'] ?>" <?php if($save_parking_data['slot_id'] == $v['id']) {
                          echo "selected";
                        } ?> ><?php echo $v['slot_name']; ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="group_name">Category</label>
                  <select class="form-control" id="vehicle_cat" name="vehicle_cat">
                    <option value="">~~Select~~</option>
                    <?php foreach ($vehicle_cat as $k => $v): ?>
                      <option value="<?php echo $v['id'] ?>" <?php if($save_parking_data['vechile_cat_id'] == $v['id']) {
                        echo "selected";
                      } ?> ><?php echo $v['name'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="group_name">Rate</label>
                  <select class="form-control" id="vehicle_rate" name="vehicle_rate">
                    <?php if($save_parking_data['rate_id']) { ?>
                      <?php foreach ($get_used_rate_data as $rate_v): ?>
                        <option value="<?php echo $rate_v['id']; ?>" <?php if($rate_v['id'] == $save_parking_data['rate_id']) { echo "selected"; } ?>><?php echo $rate_v['rate_name'] ?></option>
                      <?php endforeach ?>
                    <?php } else { ?>
                    <option value="">~~Select Category~~</option>
                    <?php } ?>
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

      <div class="row">
        <div class="col-md-12">
          <?php if($this->session->flashdata('payment_error')): ?>
            <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('payment_error'); ?>
            </div>
          <?php endif; ?>

          <div class="box">
            <div class="box-header">
              <h3>Update payment</h3>
            </div>

            <form action="<?php echo base_url('parking/updatepayment/') ?>" method="post">
            <div class="box-body">
              <?php $date = strtotime('now'); ?>
              <div class="form-group">
                <label for="">Check-out date : <?php echo date('Y-m-d', $date); ?></label> <br />
                <label for="">Check-out time : <?php echo date('h:i a', $date); ?></label>
              </div>
              <div class="form-group">
                <label class="payment_status">Payment status</label>
                <select class="form-control" name="payment_status" id="payment_status">
                  <option value="">~~Select~~</option>
                  <option value="1">Paid</option>
                  <option value="0">Unpaid</option>
                </select>
              </div>
            </div>
            <div class="box-footer">
              <input type="hidden" name="parking_id" id="parking_id" value="<?php echo $save_parking_data['id'];  ?>">
              <button type="submit" class="btn btn-primary">Update payment</button>
              <a href="<?php echo base_url('parking/') ?>" class="btn btn-warning">Back</a>
            </div>   

            </form>

          </div>
        </div>
      </div>
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <script type="text/javascript">
    $(document).ready(function() {
      $("#parkingSideTree").addClass('active');
      $("#manageParkingSideTree").addClass('active');
      
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
