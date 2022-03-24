<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('partials/head.php') ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- load sidebar -->
        <?php $this->load->view('partials/sidebar.php')
        ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content" data-url="<?= base_url('kasir') ?>">
                <!-- load Topbar -->
                <?php $this->load->view('partials/topbar.php') ?>

                <div class="container-fluid">
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
                    <div class="row">
                        <div class="col-lg-7">
                            <form class="form-horizontal" method="post" id="transaksiMenu">
                                <!-- Tanggal -->
                                <div class="form-group form-group-sm">
                                    <label class="col-sm-4 control-label">Tanggal</label>
                                    <div class="col-sm-8">
                                        <input type="date" name="tgl_jual" class="form-control form-control-sm" value="<?= $tglHariIni; ?>" readonly>
                                    </div>
                                </div>
                                <!-- Nama Menu -->
                                <div class="form-group form-group-sm batas_bawah">
                                    <label class="col-sm-4 control-label">Nama Menu</label>
                                    <div class="col-sm-8">
                                        <select name="kode_menu" id="kode_menu" class="form-control chosen-select">
                                            <option value="">~ Pilih Menu ~</option>
                                            <?php foreach ($all_menu as $menu) : ?>
                                                <option value="<?= $menu->kode_menu; ?>"><?= $menu->nama_menu; ?>- Rp. &nbsp;<?= number_format($menu->harga_menu, 0, ',', '.'); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- Qty dan No. Meja-->
                                <div class="form-group form-group-sm batas_bawah">
                                    <label class="col-sm-4 control-label">Qty</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="qty" class="form-control form-control-sm text-right angkaSemua" placeholder="Qty" required autocomplete="off">
                                    </div>
                                    <label class="col-sm-2 control-label" style="margin-left: -20px; width:73px; display: inline-block; padding-right:0;">No Meja</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="no_meja" class="form-control form-control-sm text-right angkaSemua" placeholder="Meja" required" autocomplete="off">
                                    </div>
                                </div>
                                <div class="modal-footer col-sm-12">
                                    <button type="button" class="btn btn-default btn-flat btn-sm" data-dismiss="modal" id="transaksiClose">Close</button>

                                    <a class="btn btn-success btn-flat btn-sm" id="transaksiSimpan"> Simpan</a>

                                    <a class="btn btn-success btn-flat btn-sm" id="transaksiBaru"> Baru&nbsp;&nbsp;</a>
                                </div>
                            </form>
                        </div>

                        <!-- Detail Penjualan -->
                        <div class="col-sm-6 bg-dark" style="width: 45%; padding:0">
                            <div class="panel panel-success" style="margin-left:10px; margin-right:10px;">

                                <!-- Panel Header -->
                                <div class="panel-heading panel-heading-success">
                                    <div class="form-group form-group-sm" style="padding-bottom: 10px;">
                                        <label class="col-sm-3 group-control-label" style=" margin-top: 2px; padding-left:0;">No Faktur Jual: </label>
                                        <div class="col-sm-9">
                                            <input class="group-control" type="text" name="no_faktur" readonly style="border: none; background:transparent; font-weight:bold;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Body -->
                                <div class="panel-body" style="margin-bottom: -25px;">
                                    <div class="tampilkanDetails">
                                        <table class="table table-bordered" id="example">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Menu</th>
                                                    <th>Harga Jual</th>
                                                    <th>Qty</th>
                                                    <th>Sub Total</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>

                                <div class="panel-footer">
                                    <table style="width:100%; margin-top:-5px;">
                                        <form action="<?= base_url() . 'pesan/simpan_transaksi_bayar' ?>" method="POST" target="_blank">
                                            <input type="hidden" name="no_faktur">

                                            <!-- Total Penjualan -->
                                            <tr>
                                                <td style="text-align:right; width:350px; border:0px; padding-right:10px;">Total Penjualan</td>
                                                <td style="border:0px; width:100px;">Rp. </td>

                                                <td style="padding-right:5px; font-weight:bold; width:150px;"><input class="input-control text-right" type="text" name="total_penjualan" id="total_penjualan" readonly></td>

                                                <td rowspan="3" style="border:0px; ">
                                                    <button type="submit" class="btn btn-lg btn-success cekBayar"><i class="fa fa-dollar fa-2x"></i></button>
                                                </td>
                                            </tr>

                                            <!-- Total Pembayaran -->
                                            <tr>
                                                <td style="text-align:right; border:0px; padding-right:10px;">Total Bayar</td>
                                                <td style="border:0px;">Rp. </td>

                                                <td style="padding-right:5px; font-weight:bold; width:150px;"><input type="text" class="input-control input-control-sm text-right money angkaSemua" name="total_bayar" id="total_bayar" autocomplete="off"></td>
                                            </tr>

                                            <!-- Total Pengembalian -->
                                            <tr>
                                                <td style="text-align:right; border:0px; padding-right:10px;">Total Kembali</td>
                                                <td style="border:0px;">Rp. </td>

                                                <td style="padding-right:5px; font-weight:bold; width:150px;"><input class="input-control text-right" type="text" name="total_kembali" id="total_kembali" readonly></td>
                                            </tr>
                                        </form>
                                    </table>
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

    <script language="JavaScript" type="text/javascript" src="<?= base_url('sb-admin/vendor/jquery/jquery.min.js') ?>"></script>
    <script language="JavaScript" type="text/javascript" src="<?= base_url('sb-admin/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <script>
        $(function() {
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

        $(document).on('click', '#transaksiSimpan', function() {
            var idQty = $('[name="qty"]').val();
            var idMeja = $('[name="no_meja"]').val();
            if (idQty == "") {
                alert('Qty belum diisi!');
                $('[name="qty"]').focus();
            } else if (idMeja == "") {
                alert('No Meja belum diisi!');
                $('[name="idMeja"]').focus();
            } else {
                if (confirm('Data akan disimpaan?')) {
                    var no_faktur = $('[name="no_faktur"]').val();
                    var data = $('#transaksiMenu').serialize();
                    data = data + "&no_faktur=" + no_faktur;
                    $.ajax({
                        method: 'POST',
                        data: data,
                        url: "<?= base_url(); ?>pesan/simpan_transaksi",
                        cache: false,
                        success: function(nofak_jual) {
                            $('[name="no_faktur"]').val(nofak_jual);
                            $("#kode_menu").val('');
                            $('#kode_menu').trigger("chosen:updated");
                            $('[name="qty"]').val('');
                            $('[name="no_meja"]').prop('disabled', true);
                            $('.tampilkanDetails').load('<?= base_url(); ?>/admin/transaksi/transaksi_details', {
                                nofak_jual: nofak_jual
                            });
                            $.ajax({
                                method: 'POST',
                                data: {
                                    nofak_jual: nofak_jual
                                },
                                url: "<?= base_url(); ?>/admin/transaksi/transaksi_hitung",
                                cache: false,
                                success: function(a) {
                                    $('[name="total_penjualan"]').val(a);
                                }
                            });
                        }
                    });
                } else {
                    preventDefault();
                }
            }
        });
    </script>

</body>

</html>