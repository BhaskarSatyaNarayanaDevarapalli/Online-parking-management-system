<?php include('include/header.php'); ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">SPARK</h1>
                    </div>
                    <!-- /.col-lg-12 -->
			<form role="form" name="form1" action="unpark.php" method="post">
<input type="hidden" name="lotno" value="<?php echo $_GET['lot'] ?>"/>
				<div class="col-lg-3"></div>
				<div class="col-lg-6">
					<img class="img-responsive" width="100%" src="<?php echo "images/car".$_GET['lot'].".jpg" ?>"></img>
					<div class="col-lg-12">

						<div class="col-lg-4"></div>
	
						<button type="submit" class="col-lg-4 btn btn-primary btn-lg btn-block">UnPark</button>
					</div>
				</div>
				<div class="col-lg-3"></div>
				
				<div class="col-lg-12">
					
				</div>
			</form>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    
<?php include('include/footer.php'); ?>
