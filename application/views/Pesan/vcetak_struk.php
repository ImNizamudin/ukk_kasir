<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk</title>
    <link rel="shorcut icon" type="text/css" href="<?= base_url().'assets/images/favicon.png'?>">

    <style>
      body{
        font-family:calibri; 
        font-size:14px;
      }
      .judul{font-size: 20px;}
      .jalan{font-size: 12px;}
      hr.hr1{
        margin-top: 0px;
        border: 0;
        border-top: 3px double black;
      }
      hr.hr2{
        text-align: center;
        width: 500px;
        margin-top: 20px;
      }
      hr.hr3{
        margin-top: 5px;
      }

      .table1{
        width:350px; 
        border-collapse:collapse; 
        margin-bottom: -12px;
      }

      .table2{
        width:500px;
        margin-top: 0px; 
        padding: '0'; 
        border-collapse: collapse;
      }
    </style>
  </head>
  <body onload="window.print(); window.onafterprint = window.close; ">
    <center>
      <?php 
      foreach ($data->result_array() as $i){
        $nofaktur = $i['nofak_jual'];
        $tgl      = date_format(date_create($i['tgl_jual']), "d M Y");
        $noMeja   = $i['no_meja'];
        $namaKasir= $i['pengguna_nama'];
      }?>

      <table class="table1">
        <tr>
          <td align="center" colspan='4'>
            <span class="judul">Restoran Cafe Bisa Ngopi</span><br>
            <span class="jalan">Jalan Kartini No 2 Bandung</span>
          </td>
        </tr>
        <tr>
          <td colspan="4"><hr class="hr1"></td>
        </tr>

        <tr>
          <td width="110px">No Transaksi</td>
          <td width="10px" align="center">:</td>
          <td><?= $nofaktur; ?></td>
        </tr>
          
        <tr>
          <td >Tanggal</td>
          <td align="center">:</td>
          <td><?= $tgl; ?></td>
        </tr>
        
        <tr>
          <td>No Meja</td>
          <td align="center">:</td>
          <td><?= $noMeja; ?></td>
        </tr>
          
        <tr>
          <td>Nama Kasir</td>
          <td align="center">:</td>
          <td><?= $namaKasir; ?></td>
        </tr>
      </table>

      <hr class="hr2">
      
      <table class="table2">
        <tr>
          <th width="40px">No.</th>
          <th>Nama Menu</th>
          <th>Harga</th>
          <th>Qty</th>
          <th>Sub</th>
        </tr>
        <tr>
          <td colspan='5'><hr class="hr3"></td>
        </tr>

        <?php
          $no=1;
          foreach ($data->result_array() as $j):
            $namaMenu = $j['nama_menu'];
            $harga    = $j['harga_jual'];
            $qty      = $j['jumlah_item'];?>
            </tr>
              <td align="center"><?= $no++; ?>.</td>
              <td><?= $namaMenu; ?></td>
              <td align="right"><?= number_format($harga); ?></td>
              <td align="center"><?= number_format($qty); ?></td>
              <td align="right"><?= number_format($harga*$qty); ?></td>
              <td></td>
            <tr>
            <?php 
          endforeach;
        ?>

        <tr>
          <td colspan='5'><hr class="hr4"></td>
        </tr>

        <tr>
          <td align="right" colspan='4'>Total</td>
          <td style='text-align:right; font-size:13pt;'><?= number_format($j['total_harga']); ?></td>
        </tr>

        <tr>
          <td align="right" colspan='4'>Total Bayar</td>
          <td style='text-align:right; font-size:13pt;'><?= number_format($j['total_bayar']); ?></td>
        </tr>

        <tr>
          <td align="right" colspan='4'>Kembali</td>
          <td style='text-align:right; font-size:13pt;'><?= number_format($j['total_bayar']-$j['total_harga']); ?></td>
        </tr>

        <tr>
          <td colspan='5' align="center" height="40px">****** TERIMA KASIH ******</td>
        </tr>
      </table>
    </center>   
  </body>
</html>
