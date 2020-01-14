<table style="width: 710px; border-collapse: collapse; height: 150px;" border="0">
<tbody>
<tr style="height: 53px;">
<td style="width: 237px; height: 53px; vertical-align: top;">
<h3><strong>TANDA TERIMA BARANG</strong></h3>
</td>
<td style="width: 469px; height: 53px;text-align: right;"><img  src="<?= base_url().'assets/img/logo/logo.jpg'; ?>" alt="" width="159" height="120" /></td>
</tr>
<tr style="height: 42px;">
<td style="width: 237px; height: 42px; vertical-align: middle;">&nbsp;</td>
<td style="width: 469px; height: 42px;">
<table style="width: 100.292%; height: 100px;" border="0">
<tbody>
<tr style="height: 70px;">
<td style="width: 43%; height: 158px; vertical-align: top;">&nbsp;</td>
<td style="width: 53%; vertical-align: top; height: 100px;">
<h4>&nbsp;</h4>
<h4><span style="font-size: 14px;">THUNDER INDONESIA - JAKARTA<br /> Jl. Asem No.54 RT.003/RW.004<br /> Kelapa Dua Wetan - Ciracas<br /> Jakarta Timur -13730</span></h4>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr style="height: 42px;">
<td style="width: 237px; height: 42px; vertical-align: middle;" colspan="2">
<table style="width: 530px; height: 165px; float: left;">
<tbody>
<tr>
<td style="width: 114px;">Status Barang :</td>
<td style="width: 16px; vertical-align: bottom;"><img src="<?= base_url().'assets/img/logo/kotak.jpg'; ?>" alt="" /></td>
<td style="width: 96px;">Sewa Luar</td>
<td style="width: 18px; vertical-align: bottom;"><img src="<?= base_url().'assets/img/logo/kotak.jpg'; ?>" alt="" /></td>
<td style="width: 85px;">&nbsp;Service</td>
<td style="width: 18px; vertical-align: bottom;"><img src="<?= base_url().'assets/img/logo/kotak.jpg'; ?>" alt="" /></td>
<td style="width: 137px;">&nbsp;Pindah Tangan</td>
</tr>
<tr>
<td style="width: 114px;">&nbsp;</td>
<td style="width: 16px; vertical-align: bottom;"><img src="<?= base_url().'assets/img/logo/kotak.jpg'; ?>" alt="" /></td>
<td style="width: 96px;">Pembelian</td>
<td style="width: 18px; vertical-align: bottom;"><img src="<?= base_url().'assets/img/logo/kotak.jpg'; ?>" alt="" /></td>
<td style="width: 85px;">&nbsp;Pinjaman</td>
<td style="width: 18px; vertical-align: bottom;"><img src="<?= base_url().'assets/img/logo/kotak.jpg'; ?>" alt="" /></td>
<td style="width: 137px;">&nbsp;Lain-lain</td>
</tr>
<tr>
<td style="width: 114px;">&nbsp;</td>
<td style="width: 16px; vertical-align: bottom;">&nbsp;</td>
<td style="width: 96px;">&nbsp;</td>
<td style="width: 18px;">&nbsp;</td>
<td style="width: 85px;">&nbsp;</td>
<td style="width: 18px;">&nbsp;</td>
<td style="width: 137px;">&nbsp;</td>
</tr>
<tr>
<td style="width: 114px;">&nbsp;Terima dari :</td>
<td style="width: 142px;" colspan="3">&nbsp;&nbsp;</td>
<td style="width: 85px; text-align: left;">Tanggal</td>
<td style="width: 18px;">&nbsp;:</td>
<td style="width: 137px;">&nbsp;</td>
</tr>
<tr>
<td style="width: 114px;">&nbsp;</td>
<td style="width: 16px;">&nbsp;</td>
<td style="width: 96px;">&nbsp;</td>
<td style="width: 18px;">&nbsp;</td>
<td style="width: 85px; text-align: left;">PO</td>
<td style="width: 18px;">&nbsp;:</td>
<td style="width: 137px;">&nbsp;</td>
</tr>
<tr>
<td style="width: 114px;">&nbsp;</td>
<td style="width: 16px;">&nbsp;</td>
<td style="width: 96px;">&nbsp;</td>
<td style="width: 18px;">&nbsp;</td>
<td style="width: 85px; text-align: left;">No.PB</td>
<td style="width: 18px;">&nbsp;:</td>
<td style="width: 137px;">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
<table style="border-collapse: collapse; width: 100%;" border="1">
<tbody>
<tr style="height: 18px;">
<td style="width: 5%; text-align: center; height: 18px;">
<h5>NO</h5>
</td>
<td style="width: 35%; text-align: center; height: 18px;">
<h5>NAMA BARANG</h5>
</td>
<td style="width: 5%; text-align: center; height: 18px;">
<h5>JUMLAH</h5>
</td>
<td style="width: 5%; text-align: center; height: 18px;">
<h5>IN</h5>
</td>
<td style="width: 5%; text-align: center; height: 18px;">
<h5>OUT</h5>
</td>
<td style="width: 15%; text-align: center; height: 18px;">
<h5>KETERANGAN</h5>
</td>
</tr>

<?php $no=1; ?>
<?php foreach ($r as $key => $value) { ?>
<tr>
    <td><?= $no; ?></td>
    <td><?= $value->item_name; ?></td>
    <td><?= $value->qty; ?></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
<?php $no++; } ?>

</tbody>
</table>

<table style="height: 200px; width: 560px; margin-left: auto; margin-right: auto;" border="0">
<tbody>
<tr style="height: 30px;">
<td style="width: 292px; height: 30px; text-align: center;" colspan="3">
<h4>&nbsp;&nbsp;&nbsp;BARANG MASUK</h4>
</td>
<td style="width: 301px; height: 14px; text-align: center;" colspan="3">
<h4>BARANG KELUAR&nbsp;&nbsp;&nbsp;</h4>
</td>
</tr>
<tr style="height: 100px;">
<td style="width: 89px; height: 100px; vertical-align: top;">
<h5>Mengetahui&nbsp;&nbsp;&nbsp;</h5>
</td>
<td style="width: 97px; height: 100px; vertical-align: top;">
<h5>&nbsp;Yang Menyerahkan&nbsp;&nbsp;</h5>
</td>
<td style="width: 94px; height: 100px; vertical-align: top;">
<h5>&nbsp;Yang Menerima&nbsp;&nbsp;</h5>
</td>
<td style="width: 94px; height: 100px; vertical-align: top;">
<h5>Mengetahui&nbsp;&nbsp;&nbsp;</h5>
</td>
<td style="width: 101px; height: 100px; vertical-align: top;">
<h5>Yang Menyerahkan&nbsp;&nbsp;&nbsp;</h5>
</td>
<td style="width: 94px; height: 100px; vertical-align: top;">
<h5>Yang Menerima&nbsp;&nbsp;&nbsp;</h5>
</td>
</tr>
<tr style="height: 18px;">
<td style="width: 89px; height: 18px;">&nbsp;(________)</td>
<td style="width: 97px; height: 18px;">&nbsp;&nbsp;(________)</td>
<td style="width: 94px; height: 18px;">&nbsp;&nbsp;(________)</td>
<td style="width: 94px; height: 18px;">&nbsp;&nbsp;(________)</td>
<td style="width: 101px; height: 18px;">&nbsp;&nbsp;(________)</td>
<td style="width: 94px; height: 18px;">&nbsp;&nbsp;(________)</td>
</tr>
</tbody>
</table>