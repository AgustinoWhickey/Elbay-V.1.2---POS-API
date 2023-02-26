<div class="container">
	<div class="row mt-3">
		<div class="col-md-6">
			<?php if($this->session->flashdata()) : ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					Data Mahasiswa <strong>berhasil</strong> <?= $this->session->flashdata('flash'); ?>.
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>
			<a href="<?= base_url('mahasiswa/tambah'); ?>" class="btn btn-primary">
				Tambah Data Mahasiswa
			</a>
			<form action="" method="post">
				<div class="input-group mt-3">
					<input type="text" class="form-control" name="keyword" placeholder="Cari Data Mahasiswa">
					<div class="input-group-append">
						<button type="submit" id="button" class="btn btn-primary">Search</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-md-6">
			<h3>Daftar Mahasiswa</h3>
			<?php if(empty($mahasiswa)){ ?>
				<div class="alert alert-danger">Data Mahasiswa Kosong</div>
			<?php } ?>
			<ul class="list-group">
				<?php foreach($mahasiswa as $mhs){ ?>
					<li class="list-group-item">
						<?= $mhs['nama']; ?>
						<a href="<?= base_url('mahasiswa/hapus/'.$mhs['nim']); ?>" class="badge badge-danger float-right" onclick="return confirm('yakin?');">Hapus</a>
						<a href="<?= base_url('mahasiswa/edit/'.$mhs['nim']); ?>" class="badge badge-success float-right" >Edit</a>	
						<a href="<?= base_url('mahasiswa/detail/'.$mhs['nim']); ?>" class="badge badge-primary float-right">Detail</a>	
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>