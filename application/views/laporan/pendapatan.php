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
            <div id="content" data-url="<?= base_url('kasir') ?>">
                <!-- load Topbar -->
                <?php $this->load->view('partials/topbar.php') ?>

                <div class="container-fluid">
                    <div class="clearfix">
                        <div class="float-left">
                            <h1 class="h3 m-0 text-gray-800"><?= $title ?></h1>
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
                    <?php if ($this->session->userdata('role_id') == 1 || $this->session->userdata('role_id') == 2) : ?>
                        <div class="row">
                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Barang</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><? //= $jumlah_barang 
                                                                                                    ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-box fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Seluruh Pendapatan</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    Rp <?= number_format($pendapatan->pendapatan, 0, ',', '.') ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-cash-register fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Transaksi</div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><? //= $jumlah_penjualan 
                                                                                                                    ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Requests Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Pengguna</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><? //= $jumlah_pengguna 
                                                                                                    ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="card shadow">
                        <div class="card-header"><strong>Daftar Transaksi</strong></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">No Faktur</th>
                                            <th scope="col">Tanggal / Jam</th>
                                            <th scope="col">Kode Menu</th>
                                            <th scope="col">Nama Menu</th>
                                            <th scope="col">Harga Jual</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Subtotal</th>
                                            <th scope="col">No Meja</th>
                                            <th scope="col" width="20px" style="overflow: hidden;">Nama Kasir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        $ttl_pemb_all = 0;
                                        foreach ($all_laporan_transaksi as $laporan_transaksi) : ?>
                                            <?php
                                            $subtotal = $laporan_transaksi->harga_jual * $laporan_transaksi->jumlah_item;
                                            $ttl_pemb_all += $subtotal;
                                            ?>
                                            <tr>
                                                <th scope="row"><?= $i++ ?>.</th>
                                                <td><?= $laporan_transaksi->nofak_jual ?></td>
                                                <td><?= Tgl_indo::indo($laporan_transaksi->tgl_jual) . "<br>" . $laporan_transaksi->jam; ?></td>
                                                <td><?= $laporan_transaksi->kode_menu ?></td>
                                                <td><?= $laporan_transaksi->nama_menu ?></td>
                                                <td><?= number_format($laporan_transaksi->harga_jual, 0, ',', '.') ?></td>
                                                <td><?= $laporan_transaksi->jumlah_item ?></td>
                                                <td><?= number_format($laporan_transaksi->harga_jual * $laporan_transaksi->jumlah_item, 0, ',', '.') ?></td>
                                                <td><?= $laporan_transaksi->no_meja ?></td>
                                                <td><?= $laporan_transaksi->nama ?></td>
                                                <!-- <td>
                                                    <a href="<?= base_url('laporan/ubah/' . $laporan_transaksi->nofak_jual) ?>" class="btn btn-success btn-sm"><i class="fa fa-pen"></i></a>
                                                    <a onclick="return confirm('apakah anda yakin menghapus data laporan ini?')" href="<?= base_url('laporan/hapus/' . $laporan_transaksi->nofak_jual) ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                </td> -->
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <h5><strong>Total Pendapatan: </strong>Rp <?= number_format($pendapatan->pendapatan, 0, ',', '.') ?></h5>
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