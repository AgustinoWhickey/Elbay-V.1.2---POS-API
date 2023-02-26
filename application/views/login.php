<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view("admin/_partials/head.php") ?>
</head>

<body id="page-top">

	<div id="wrapper">

		<div id="content-wrapper">

			<div class="container-fluid" style="width: 36%;margin-top:5%;">

				<?php if ($this->session->flashdata('success')): ?>
				<div class="alert alert-success" role="alert">
					<?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php endif; ?>

				<div class="card mb-3">
					<div class="card-header">
						<b>Login</b>
					</div>
					<div class="card-body">

						<div class="form-group">
							<label for="name">Username</label>
							<input class="form-control" type="text" id="username" name="name" placeholder="Username" />
						</div>
						
						<div class="form-group">
							<label for="pass">Password</label>
							<input class="form-control" type="password" id="pass" name="pass" placeholder="Password" />
						</div>

						<input class="btn btn-success" type="button" id="signin" name="btn" value="Login" />
						<a href="<?php echo site_url('register') ?>">Register</a>

					</div>

					<div class="card-footer small text-muted">
						
					</div>
				</div>
				
				<?php $this->load->view("admin/_partials/footer.php") ?>

			</div>

		</div>


		<?php $this->load->view("admin/_partials/scrolltop.php") ?>

		<?php $this->load->view("admin/_partials/js.php") ?>
		
		<script>
			$(document).ready(function(){
				$('#signin').click(function(){
					var username = $('#username').val();
					var pass = $('#pass').val();
					if(username != '' && pass != '' ){
						$.ajax({
							type: "POST",
							url: "<?php echo base_url('login/ceklogin') ?>",
							data: "username="+username+"&password="+pass,
							success: function(data){
								if(data == 0){
									swal("Login Gagal!","Pastikan Semua Benar","error");
								}else{
									swal("Login Sukses!","Selamat Datang","success")
									.then((value) => {
									  document.location.href = '<?php echo base_url('login') ?>';
									});
								}
							}
						});
					}else{
						swal("Pastikan semua sudah terisi!","Cek lagi form Anda","warning");
					}
				});
			});
		</script>

</body>

</html>
