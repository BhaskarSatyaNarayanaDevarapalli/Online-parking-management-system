  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manage
        <small>Company</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Company</li>
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
              <h3 class="box-title">Company info</h3>
            </div>
            <form role="form" action="<?php base_url('company/') ?>" method="post">
              <div class="box-body">

                <?php echo validation_errors(); ?>

                <div class="form-group">
                  <label for="company_name">Company name</label>
                  <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company name" value="<?php echo ($this->input->post('company_name')) ?:$company_data['name']; ?>">
                </div>


                <div class="form-group">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php echo ($this->input->post('address')) ?:$company_data['address']; ?>">
                </div>

                <div class="form-group">
                  <label for="message">Message</label>
                  <textarea class="form-control" id="message" name="message"  rows="5" cols="80">
                    <?php echo trim(($this->input->post('message')) ?:trim($company_data['message'])); ?>
                  </textarea>
                </div>

                <div class="form-group">
                  <label for="currency">Currency</label>
                  <?php ?>
                  <select class="form-control" id="currency" name="currency">
                    <option value="">~~SELECT~~</option>

                    <?php foreach ($currency_symbols as $k => $v): ?>
                      <option value="<?php echo trim($k); ?>" <?php if($company_data['currency'] == $k) {
                        echo "selected";
                      } ?>><?php echo $k ?></option>
                    <?php endforeach ?>
                  </select>
                </div>


              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="hidden" name="currency_rate" id="currency_rate" value="<?php echo $company_data['currency']; ?>" /> 
                <button type="submit" class="btn btn-primary">Save Changes</button>
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

    
    $("#companySideTree").addClass('active');
    

    $("#currency").select2();
    $('#message').wysihtml5();

    
      var currency_rate = $("#currency_rate").val();
      
    
    $("#currency").val(currency_rate);
    

  });
</script>
