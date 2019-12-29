<table width="100%" style="text-align: center; font-family: Impact, Charcoal, sans-serif;">
  <tr>
    <td style="font-size: 12; font-weight: bold;">SURAT PESANAN BARANG</td>
  </tr>
  <tr>
    <td style="font-size: 9; font-weight: bold;">Nomor : <?php echo $no_pengajuan;?></td>
  </tr>
</table>


<p class="fontTB">Kepada Yth.</p><br>

<pre class="fontTB">
Telp  :
Up    :

Mohon dapat dilaksanakan pesanan kami sebagai berikut:
</pre>

<table width="100%" cellspacing="0" class="tbBarang fontTB" style="border-collapse: separate; border-spacing: 0 1px;">
    <thead >
      <tr style="background-color: #d0d0d0;">
        <th class="thead bhead tlr l" rowspan="2" width="10px">No.</th>
        <th class="thead bhead tlr l" rowspan="2">Deskripsi Barang</th>
        <th class="thead bhead tlr l" rowspan="2">Volume</th>
        <th class="thead bhead tlr l" rowspan="2">Satuan</th>
        <th class="thead bhead tlr" colspan="2">Harga (Rp)</th>
        <th class="thead bhead tlr l" rowspan="2">Keterangan</th>
      </tr>
      <tr style="background-color: #d0d0d0;">
        <th class="thead bhead tlr">Satuan</th>
        <th class="thead bhead tlr">Jumlah</th>
      </tr>
    </thead>

    <tbody>
      <?php $no = 0; ?>
      <?php $s=10; foreach ($items as $key => $val) { ?>
        <?php $s--; ?>

          <tr>
            <td class="tlr"><?php echo $key+1;?></td>
            <td class="tlr"><?php echo $val->item_name ?></td>
            <td class="tlr"><?php echo $val->qty ?></td>
            <td class="tlr"><?php echo $val->satuan ?></td>
            <td class="tlr"><?php echo $val->satuan ?></td>
            <td class="tlr"></td>
            <td class="tlr"></td>
          </tr>
      <?php } ?>

      <?php if($s>0){ ?>
        <tr>
          <td class="tlr">
            <?php for($i=0; $i<=$s; $i++){ ?>
            <br>
            <?php } ?>
          </td>
          <td class="tlr"></td>
          <td class="tlr"></td>
          <td class="tlr"></td>
          <td class="tlr"></td>
          <td class="tlr"></td>
          <td class="tlr"></td>
        </tr>
      <?php } ?>
      
      
    </tbody>
    <tfoot>
      <tr>
        <td class="thead bhead tleft"></td>
        <td class="thead bhead"></td>
        <td class="thead bhead"></td>
        <td class="thead bhead"></td>
        <td class="thead bhead"style="text-align: right;">Total :</td>
        <td class="thead bhead">-</td>
        <td class="thead bhead tright"></td>
      </tr>
    </tfoot>
</table>

<pre class="fontTB" style="margin-bottom: -20px;">
Demikian disampaikan, atas perhatian dan kerjasamanya diucapkan terima kasih.
    <ol>
      <li class="U"><b>Waktu Pekerjaan</b>
        <ul style="list-style-type: none; margin-left:-30px;">
          <li style="margin-top: -10px;">Pengadaan Souvenir dilaksanakan selama 25 (dua puluh lima) hari, terhitung mulai tanggal 28 Desember 2017 sampai dengan tanggal 22 Januari 2018.</li>
        </ul>
      </li>
      <li class="U" style="margin-top: -30px;"><b>Cara Pembayaran</b>
        <ul style="list-style-type: none; margin-left:-30px;">
          <li style="margin-top: -10px;">Pembayaran sebesar 100% (seratus persen), yaitu sebesar Rp XXXXXXXXXXXX,-setelah barang diterima dengan melampirkan Berita Acara Serah Terima (BAST) dan Invoice.</li>
        </ul>
      </li>
    </ol>
</pre>

<table width="100%" style="font-family: arial; font-size: 11px;">
  <tbody>
    <tr>
      <td width="25%">Jakarta, <?php echo date('d-M-Y'); ?></td>
      <td width="20%"></td>
      <td width="25%"></td>
    </tr>
    <tr>
      <td width="25%">Pemberi Pekerjaan,<br><br><br><br><br><b style="text-align: center; text-decoration: underline;">XXXXXXXXXXXXX</b><br>HRD & GA Group Head</td>
      <td width="20%"></td>
      <td width="25%">Penerima Pekerjaan<br><br><br><br><br><b style="text-align: center; text-decoration: underline;">XXXXXXXXXXXXX</b><br>Director</td>
    </tr>
  </tbody>
</table>



<style type="text/css">
  .fontTB{
      font-size: 9; text-align: left; font-family: Impact, Charcoal, sans-serif;
  }

  .U{
    list-style-type: upper-alpha;
  }
</style>


  <style type="text/css">
    .tbBarang {
      /*border:0; */
      border-collapse:separate; 
      border-spacing:0 0px;
    }

    .tbBarang thead tr th{
      
      border-collapse:separate; 
      border-spacing:0 0px;
      
    } 

    .tbBarang tfoot tr td{
      /*border-top: 1px solid black; */
      border-top: 2px solid black; 
      border-collapse:separate; 
      border-spacing:0 0px;
    }
    .tbBarang thead tr th.thead{
        border-top: 1px solid black;
    }
    .tbBarang thead tr th.bhead{
        border-bottom: 1px solid black;
    }

    .tbBarang tfoot tr td.thead{
        border-top: 1px solid black;
    }
    .tbBarang tfoot tr td.bhead{
        border-bottom: 1px solid black;
    }

    .tlr{
      
      padding-left: 10px;
      border-left: 1px solid black;
      border-right: 1px solid black;
    }

    .l{
      text-align: left;
    }
    .tleft{
      border-left: 1px solid black;
    }
    .tright{
      border-right: 1px solid black;
    }
/*    .tbBarang tbody tr th{
      border-top: 3px solid black; 
      border-bottom: 3px solid black; 
      border-collapse:collapse; 
      border-spacing:0 0px;
    } */


  </style>