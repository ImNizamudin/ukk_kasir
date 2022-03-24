<!DOCTYPE html>
<html lang="en">

<head>
	<?php $this->load->view('partials/head.php') ?>
</head>

<body id="page-top">
	<div id="wrapper">
		<!-- load sidebar -->
		<?php $this->load->view('partials/sidebar.php') ?>

		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content" data-url="<?= base_url('barang') ?>">
				<!-- load Topbar -->
				<?php $this->load->view('partials/topbar.php') ?>

				<div class="container-fluid">
					<div class="clearfix">
						<div class="float-left">
							<h1 class="h3 m-0 text-gray-800"><?= $title ?></h1>
						</div>
						<div class="float-right">
							<a href="<?= base_url('barang') ?>" class="btn btn-secondary btn-sm"><i class="fa fa-reply"></i>&nbsp;&nbsp;Kembali</a>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-lg">
							<div class="card shadow">
								<div class="card-header"><strong>Detail menu</strong></div>
								<div class="card-body">
									<form action="<?= base_url('barang/proses_ubah/' . $menu->kode_menu) ?>" id="form-tambah" method="POST">
										<div class="form-group row">
											<label for="kode_menu" class="col-sm-2 col-form-label">Kode Menu</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="kode_menu" name="kode_menu" autofocus placeholder="kode harus 6 digit angka" value="<?= $menu->kode_menu ?>" readonly>
												<?= form_error('kode_menu', '<small class="text-danger pl-3">', '</small>') ?>
											</div>
										</div>
										<div class="form-group row">
											<label for="nama_menu" class="col-sm-2 col-form-label">Nama Menu</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="nama_menu" name="nama_menu" autofocus placeholder="nama menu" value="<?= $menu->nama_menu ?>">
												<?= form_error('nama_menu', '<small class="text-danger pl-3">', '</small>') ?>
											</div>
										</div>
										<div class="form-group row">
											<label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="satuan" name="satuan" autofocus placeholder="contoh: porsi, gelas" value="<?= $menu->satuan ?>">
												<?= form_error('satuan', '<small class="text-danger pl-3">', '</small>') ?>
											</div>
										</div>
										<div class="form-group row">
											<label for="harga" class="col-sm-2 col-form-label">Harga Menu</label>
											<div class="col-sm-10">
												<input type="number" class="form-control" id="harga" name="harga" autofocus placeholder="contoh: 200000" value="<?= $menu->harga_menu ?>">
												<?= form_error('harga', '<small class="text-danger pl-3">', '</small>') ?>
											</div>
										</div>
										<div class="form-group row justify-content-end">
											<button type="submit" class="btn btn-primary mr-1"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan</button>
											<button type="reset" class="btn btn-danger mr-3"><i class="fa fa-times"></i>&nbsp;&nbsp;Batal</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- load footer -->
			<?php $this->load->view('partials/footer.php') ?>
		</div>
	</div>
	<?php $this->load->view('partials/js.php') ?>
</body>

</html>