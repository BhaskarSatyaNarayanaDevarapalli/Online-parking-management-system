<?php include('include/header.php'); ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">SPARK</h1>
                    </div>
                    <!-- /.col-lg-12 -->
			<form role="form" name="form1" action="index.php" method="post">
				<div class="col-lg-3"></div>
				<div class="col-lg-6">
					<img class="img-responsive" width="100%" src="<?php echo "images/lot".$_GET['lot'].".jpg" ?>"></img>
				</div>
				<div class="col-lg-3"></div>
				
				<div class="col-lg-12">
					<button type="submit" class="btn btn-default">Done</button>
				</div>
			</form>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    
<?php include('include/footer.php'); ?>
