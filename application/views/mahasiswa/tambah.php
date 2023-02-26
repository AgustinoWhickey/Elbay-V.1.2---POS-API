<div class="container">
	<div class="row mt-3">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					Form Tambah Data Mahasiswa
				</div>
				<div class="card-body">
					<form action="" method="post">
						<div class="form-group">
							<label for="nama">Nama</label>
							<input type="text" class="form-control" name="nama">
							<small class="form-text text-danger"><?= form_error('nama'); ?></small>
						</div>
						<div class="form-group">
							<label for="nrp">NRP</label>
							<input type="text" class="form-control" name="nrp">
							<small class="form-text text-danger"><?= form_error('nrp'); ?></small>
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="text" class="form-control" name="email">
							<small class="form-text text-danger"><?= form_error('email'); ?></small>
						</div>
						<div class="form-group">
							<label for="tgllahir">Tanggal Lahir</label>
							<input type="text" class="form-control" id="tgllahir" name="tgllahir">
							<span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
							<small class="form-text text-danger"><?= form_error('tgllahir'); ?></small>
						</div>
						<div class="form-group">
							<label for="jurusan">Jurusan</label>
							<select name="jurusan" id="jurusan" class="form-control">
								<?php foreach($jurusan as $jrs){ ?>
									<option value="<?= $jrs['id'] ?>"><?= $jrs['nama'] ?></option>
								<?php } ?>
							</select>
						</div>
						<button type="submit" class="btn btn-primary">Tambah Data</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	 $('#tgllahir').datetimepicker({
        format: 'YYYY-MM-DD'
    });
</script>