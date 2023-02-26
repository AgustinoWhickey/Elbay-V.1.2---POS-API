<div class="container">
	<div class="row mt-3">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					Form Edit Data Mahasiswa
				</div>
				<div class="card-body">
					<form action="" method="post">
						<div class="form-group">
							<label for="nama">Nama</label>
							<input type="text" class="form-control" name="nama" value="<?= $mahasiswa['nama']; ?>">
							<small class="form-text text-danger"><?= form_error('nama'); ?></small>
						</div>
						<div class="form-group">
							<label for="nrp">NRP</label>
							<input type="text" class="form-control" name="nrp" value="<?= $mahasiswa['nim']; ?>">
							<small class="form-text text-danger"><?= form_error('nrp'); ?></small>
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="text" class="form-control" name="email" value="<?= $mahasiswa['email']; ?>">
							<small class="form-text text-danger"><?= form_error('email'); ?></small>
						</div>
						<div class="form-group">
							<label for="jurusan">Jurusan</label>
							<select name="jurusan" id="jurusan" class="form-control">
								<?php foreach($jurusan as $jrs){ ?>
									<?php if($jrs['id'] == $mahasiswa['jurusan']){ ?>
										<option value="<?= $jrs['id'] ?>" selected><?= $jrs['nama'] ?></option>
									<?php } else { ?>
										<option value="<?= $jrs['id'] ?>"><?= $jrs['nama'] ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
						<button type="submit" class="btn btn-primary">Edit Data</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>