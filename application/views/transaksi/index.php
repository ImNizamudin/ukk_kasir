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
            <div id="content" data-url="<?= base_url('penjualan') ?>">
                <!-- load Topbar -->
                <?php $this->load->view('partials/topbar.php') ?>

                <div class="container-fluid">
                    <div class="clearfix">
                        <div class="float-left">
                            <h1 class="h3 m-0 text-gray-800"><?= $title ?></h1>
                        </div>
                        <div class="float-right">
                            <a href="<?= base_url('transaksi/export') ?>" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf"></i>&nbsp;&nbsp;Export</a>
                            <!-- <a href="<?= base_url('transaksi/tambah') ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp;&nbsp;Order</a> -->
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
                        <div class="card-header"><strong>Daftar Pesanan</strong></div>
                        <div class="card-body">
                            <?php if ($this->session->userdata('role_id') == 2) : ?>
                                <div class="row mb-3 d-flex">
                                    <div class="col-6">
                                        <form action="" method="post">
                                            <div class="form-row">
                                                <div class="col-md-5">
                                                    <input type="date" class="form-control" placeholder="Dari Tanggal" name="tgl1">
                                                </div>
                                                <div class="col-md-5">
                                                    <input type="date" class="form-control" placeholder="Sampai Tanggal" name="tgl2">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-primary">Saring</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-6">
                                        <form action="" method="post">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <select name="pegawai" id="pegawai" class="form-control">
                                                        <option value="" selected>~ Pilih Nama Kasir ~</option>
                                                        <?php foreach ($result_pegawai as $pegawai) : ?>
                                                            <option value="<?= $pegawai->id ?>"><?= $pegawai->nama ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="table-responsive">
                                <table id="example" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">No Faktur</th>
                                            <th scope="col">No Meja</th>
                                            <th scope="col">Nama Kasir</th>
                                            <th scope="col">Tangal / Jam</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Aksi</th>
                                            <th scope="col">Cetak</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($result_transaksi as $transaksi) : ?>
                                            <tr>
                                                <th scope="row"><?= $i++ ?>.</th>
                                                <td><?= $transaksi->nofak_jual ?></td>
                                                <td><?= $transaksi->no_meja ?></td>
                                                <td><?= $transaksi->nama ?></td>
                                                <td>
                                                    <?= Tgl_indo::indo($transaksi->tgl_jual) . "<br>" . $transaksi->jam; ?></td>
                                                </td>
                                                <td><?= number_format($transaksi->total_harga, 0, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <a href="<?= base_url('transaksi/detail/' . $transaksi->nofak_jual) ?>" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                                    <?php if ($this->session->userdata('role_id') == 2) : ?>
                                                        <a onclick="return confirm('apakah anda yakin?')" href="<?= base_url('penjualan/hapus/' . $transaksi->nofak_jual) ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                    <?php endif;  ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= base_url('penjualan/detail/' . $transaksi->nofak_jual) ?>" class="btn btn-success btn-sm"><i class="fas fa-print"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
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