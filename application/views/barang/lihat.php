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
							<?php if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 2) : ?>
								<a href="<?= base_url('barang/export') ?>" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf"></i>&nbsp;&nbsp;Export</a>
								<a href="<?= base_url('barang/tambah') ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp;&nbsp;Tambah</a>
							<?php endif ?>
						</div>
					</div>
					<hr>
					<?php if ($this->session->flashdata('success')) : ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('success') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php elseif ($this->session->flashdata('error')) : ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?= $this->session->flashdata('error') ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endif ?>
					<div class="card shadow">
						<div class="card-header"><strong>Daftar Menu</strong></div>
						<div class="card-body">
							<div class="table-responsive">
								<table id="example" class="display" style="width:100%">
									<thead>
										<tr>
											<td>No</td>
											<td>Kode Menu</td>
											<td>Nama Menu</td>
											<td>Satuan Menu</td>
											<td>Harga Menu</td>
											<?php if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 2) : ?>
												<td>Aksi</td>
											<?php endif ?>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($all_menu as $menu) : ?>
											<tr>
												<td><?= $no++ ?></td>
												<td><?= $menu->kode_menu ?></td>
												<td><?= $menu->nama_menu ?></td>
												<td><?= $menu->satuan ?></td>
												<td>Rp <?= number_format($menu->harga_menu, 0, ',', '.') ?></td>
												<?php if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 2) : ?>
													<td>
														<a href="<?= base_url('barang/ubah/' . $menu->kode_menu) ?>" class="btn btn-success btn-sm"><i class="fa fa-pen"></i></a>
														<a onclick="return confirm('apakah anda yakin menghapus menu ini?')" href="<?= base_url('barang/hapus/' . $menu->kode_menu) ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
													</td>
												<?php endif ?>
											</tr>
										<?php endforeach ?>
									</tbody>
								</table>
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
	<script src="<?= base_url('sb-admin/js/demo/datatables-demo.js') ?>"></script>
	<script src="<?= base_url('sb-admin') ?>/vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url('sb-admin') ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>

	<script>
		$(document).ready(function() {
			$('#example').DataTable({
				responsive: false,
				language: {
					sEmptyTable: "Tidak ada data yang tersedia pada tabel ini",
					sProcessing: "Sedang memproses...",
					sLengthMenu: "Tampilkan _MENU_ data",
					sZeroRecords: "Tidak ditemukan data yang sesuai",
					sInfo: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
					sInfoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
					sInfoFiltered: "(disaring dari _MAX_ data keseluruhan)",
					sInfoPostFix: "",
					sSearch: "Cari:",
					sUrl: "",
					oPaginate: {
						sFirst: "Pertama",
						sPrevious: "Sebelumnya",
						sNext: "Selanjutnya",
						sLast: "Terakhir",
					},
					aria: {
						sortAscending: ": aktivasi untuk menyaring kolom secara menaik",
						sortDescending: ": aktivasi untuk menyaring kolom secara menurun",
					},
				},
			});
		});
	</script>

</body>

</html>