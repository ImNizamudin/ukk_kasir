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
                            <div class="row justify-content-center">
                                <?php foreach ($all_menu as $menu) : ?>
                                    <div class="card mr-2 mb-2 menu-card">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <div class="position-relative d-inline-block"><img class="avatar avatar-lg mb-3" src="<?= base_url() ?>assets/images/food.jpg" alt="food.jpg" width="100px"></div>
                                                <h5><?= $menu->nama_menu ?></h5>
                                                <div class="d-inline-block py-1 px-4 fw-light text-sm mb-1">Rp <?= number_format($menu->harga_menu, 0, ',', '.') ?></div>
                                                <div class="card-action">
                                                    <button type="submit" onclick="pesan(<?= $menu->kode_menu ?>)" name="pesan" id="pesan<?= $menu->kode_menu ?>" data-productname="<?= $menu->nama_menu ?>" data-productkode="<?= $menu->kode_menu ?>" data-productprice="<?= $menu->harga_menu ?>" class="btn btn-success">Pesan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card">
                                <div class="card-body">
                                    <p>Tanggal : <?= $tgl ?></p>
                                    <p>Kasir : <?= $tgl ?></p>
                                    <div class="form-group row">
                                        <label for="meja" class="col-sm-4 col-form-label">No meja</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="meja" name="meja">
                                            <?= form_error('meja', '<small class="text-danger pl-3">', '</small>') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body" id="pesanan">
                                    <table id="tbpesanan" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Menu</th>
                                                <th>Harga Jual</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pesananan">

                                        </tbody>
                                    </table>
                                    <!-- <table>
                                        <td>
                                            <p class="mr-2">Burger</p>
                                        </td>
                                        <td>
                                            <ul class="pagination">
                                                <li class="page-item"><button class="page-link" onclick="handleQtyMin('itemval')"><i class="fas fa-minus"></i></li>
                                                <li class="page-item"><input type="text" class="qty" id="qtyy" name="qty" value="1"></li>
                                                <li class="page-item"><button class="page-link" onclick="handleQtyPlus('itemval')"><i class="fas fa-plus"></i></li>
                                            </ul>
                                            <ul class="justify-content-center">
                                                <li>
                                                    <button onclick="editQty($('#qty_111111').val(), 'min', 'Ord-8339f6', '111111')" class="btn btn-warning btn-xs btn-flat" type="button">
                                                        <i class="fa fa-minus"></i></button>
                                                </li>
                                                <li>
                                                    <input type="text" value="1" id="qty">
                                                </li>
                                                <li>
                                                    <button onclick="editQty($('#qty_111111').val(), 'plus', 'Ord-8339f6', '111111')" type="button" class="btn btn-success btn-xs btn-flat">
                                                        <i class="fa fa-plus"></i></button>
                                                </li>
                                            </ul>
                                        </td>
                                        <td>
                                            <p class="ml-2">Rp<span id="itemval">10000</span></p>
                                        </td>
                                        <td>
                                            <ul class="pagination">
                                                <li class="page-item"><a onclick="" href="<?= base_url() ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></li>
                                            </ul>
                                        </td>
                                    </table> -->
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="ket d-flex justify-content-between">
                                        <p>Subtotal</p>
                                        <p id="subtotal">Rp<span>100000</span></p>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="card">
                                <div class="card-body bg-primary">
                                    <div class="d-flex justify-content-between">
                                        <h4 class="text-white">Total</h4>
                                        <p class="text-white">Rp<span id="subtotal"></p>
                                    </div>
                                </div>
                            </div> -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <form action="" method="POST">
                                                <div class="form-group row">
                                                    <label for="bayar" class="col-sm-4 col-form-label">Total Bayar</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="bayar" name="bayar">
                                                        <?= form_error('bayar', '<small class="text-danger pl-3">', '</small>') ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="kembalian" class="col-sm-4 col-form-label">Kembalian</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="kembalian" name="kembalian">
                                                        <?= form_error('kembalian', '<small class="text-danger pl-3">', '</small>') ?>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-lg-3">
                                            <button type="submit" class="btn btn-success justify-content-center"><i class="fas fa-dollar-sign"></i> Bayar</button>
                                        </div>
                                    </div>
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
        function pesan(id) {
            var kode_menu = $('#pesan' + id).data('productkode');
            var nama_menu = $('#pesan' + id).data('productname');
            var harga_menu = $('#pesan' + id).data('productprice');

            $.ajax({
                url: "<?= base_url() ?>pesan/pesanan",
                method: "post",
                data: {
                    kode_menu: kode_menu,
                    nama_menu: nama_menu,
                    harga_menu: harga_menu
                },
                success: function(data) {
                    var pesan = JSON.parse(data);

                    var html = '<tr>';
                    $.each(pesan, function(i, value) {

                        html += "<td>" + pesan[i] + "</td>";
                        html += "<td><input type='number' name='qtypo' id='qtypo' class='form-control' value='1'></td>";
                        // html += '<td><input type="text" name="qtypo' + pesan[i] + '" id="qtypo' + pesan[i] + '" class="form-control" value=' + 1 + '></td>';
                        // console.log(html);
                    });
                    html += "</tr>";
                    $('#tbpesanan').append(html);

                }
            });

        }

        function total() {
            var sum = 0;
            $('#tbpesanan > tbody  > tr').each(function() {
                var qty = $(this).find('option:selected').val();
                var price = $(this).find('.price').val();
                var amount = (qty * price)
                sum += amount;
                $(this).find('.amount').text('' + amount);
            });
            $('.total').text(sum);
        }




        $(document).ready(function() {
            total();

            $('#subtotal').change(function() {
                total();
            });
        });


        // $('#pesan').on('click', function() {
        //     var kode_menu = $(this).data('productkode');
        //     var nama_menu = $(this).data('productname');
        //     var harga_menu = $(this).data('productprice');

        //     $.ajax({
        //         url: "<?= base_url() ?>pesan/pesanan",
        //         method: "post",
        //         data: {
        //             kode_menu: kode_menu,
        //             nama_menu: nama_menu,
        //             harga_menu: harga_menu
        //         },
        //         success: function(data) {
        //             $('#pesanan').html(data);
        //             $("<tr><td>" + data + "</td></tr>").appendTo("#tbpesanan > tbody");
        //             pesan = $.parseJSON(data);
        //             console.log(pesan);
        //             $.each(pesan, function(key, value) {
        //                 $('#tbpesanan').append('<tr> <td>' + value + '</td>  <td>' + key[1] + ' < /td> <td>' + key[2] + '</td > < /tr>');
        //             });

        //             $('#tbpesanan tr').each(function(index, tr) {
        //                 $(tr).find('td').each(function(index, td) {
        //                     ("#tbpesanan").append("<tr><td>" + td.kode_menu + "</td> <td>" + td.nama_menu + " </td> <td>" + td.harga_menu + "</td></tr>");
        //                 });
        //             });
        //             console.log(data);
        //             $('#tbpesanan').append('<tr><td>' + data.kode_menu + '</td><td>' + data.nama_menu + '</td><td>' + data.harga_menu + '</td></tr>');

        //             var pesan = JSON.parse(data);

        //             var html = '<tr>';
        //             $.each(pesan, function(i, value) {

        //                 html += "<td>" + pesan[i] + "</td>";
        //                 // console.log(html);
        //             });
        //             html += "</tr>";
        //             $('#tbpesanan').append(html);

        //         }
        //     });

        //     console.log(kode_menu);
        // });

        // $('#pesan').on('click', function() {
        //     const kode_menu = $(this).data('productkode');
        //     const nama_menu = $(this).data('productname');
        //     const harga_menu = $(this).data('productprice');

        //     console.log(kode_menu);

        //     $.ajax({
        //         url: "<?= base_url() ?>pesan/pesanan",
        //         method: 'post',
        //         data: {
        //             kode_menu: kode_menu,
        //             nama_menu: nama_menu,
        //             harga_menu: harga_menu,
        //             qty: 1
        //         },
        //         success: function(data) {
        //             $('#pesanan').html(data);
        //             $('#' + kode_menu).val('');
        //         }
        //     })


        // });



        function handleQtyPlus(itemval) {
            const qty = document.getElementById("qtyy");
            const itemprice = document.getElementById("itemval");
            let qtyValue = qty.value;
            qty.value = ++qtyValue;
            //itemprice.innerHTML = parseInt(itemprice.innerHTML) + parseInt(itemprice.innerHTML);
        }

        function handleQtyMin() {
            const qty = document.getElementById("qtyy");
            let qtyValue = qty.value;
            if (qtyValue <= 1) {
                qty.value = 1;
            } else {
                qty.value = --qtyValue;
            }
        }
    </script>
</body>

</html>