<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

		<title><?= $judul; ?></title>

		<!-- Bootstrap core CSS-->
		<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/bootstrap/css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet">

		<!-- Custom fonts for this template-->
		<link href="<?php echo base_url('assets/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">

		<!-- Page level plugin CSS-->
		<link href="<?php echo base_url('assets/datatables/dataTables.bootstrap4.css') ?>" rel="stylesheet">

		<!-- Sweet Alert plugin CSS-->
		<link href="<?php echo base_url('assets/sweetalert2/sweetalert2.min.css') ?>" rel="stylesheet">

		<!-- Custom styles for this template-->
		<link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/font-awesome.min.css') ?>" rel="stylesheet">

		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">

		<!-- Bootstrap core JavaScript-->
		<script src="<?php echo base_url('assets/jquery/jquery.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/js/moment.min.js') ?>"></script>
		<!-- <script src="<?php //echo base_url('assets/bootstrap/js/bootstrap-datetimepicker.min.js') ?>"></script> -->

	</head>

	<body>

		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="container">
			  <a class="navbar-brand" href="#">Codeigniter 3</a>
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			  </button>
			  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			    <div class="navbar-nav">
			      <a class="nav-link" href="<?= base_url(); ?>">Home <span class="sr-only">(current)</span></a>
			      <a class="nav-link" href="<?= base_url('mahasiswa'); ?>">Mahasiswa</a>
			      <a class="nav-link" href="<?= base_url('peoples'); ?>">Peoples</a>
			      <a class="nav-link" href="<?= base_url('mahasiswa/album'); ?>">Album</a>
			      <a class="nav-link" href="<?= base_url('forum'); ?>">Forum</a>
			    </div>
			  </div>
		  </div>
		</nav>
