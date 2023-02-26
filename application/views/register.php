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
						<b>Register</b>
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
						
						<div class="form-group">
							<label for="pass2">Confirm Password</label>
							<input class="form-control" type="password" id="pass2" name="pass2" placeholder="Confirm Password" />
						</div>

						<input class="btn btn-success" type="button" name="btn" id="register" value="Register" />

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
				$('#register').click(function(){
					var username = $('#username').val();
					var pass = $('#pass').val();
					var pass2 = $('#pass2').val();
					if(username != '' && pass != '' && pass2 != ''){
						if(pass == pass2){
							$.ajax({
								type: "POST",
								url: "<?php echo base_url('register/insertregister') ?>",
								data: "username="+username+"&password="+pass,
								success: function(data){
									if(data == 0){
										swal("Registrasi Gagal!","Pastikan Password Sama","error");
									}else{
										swal("Registrasi Sukses!","Silahkan login","success")
										.then((value) => {
										  document.location.href = '<?php echo base_url('login') ?>';
										});
									}
								}
							});
						}else{
							swal("Pastikan Password Sudah Sama!","Cek lagi form Anda","warning");
						}
					}else{
						swal("Pastikan semua sudah terisi!","Cek lagi form Anda","warning");
					}
				});
			});
		</script>

</body>

</html>
