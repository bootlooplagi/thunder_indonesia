<p></p>
<table width="100%" style="font-size: 12px;">
<tbody>
<tr>
<td>
<h1><strong>INVOICE</strong></h1>
</td>
<td></td>
<td align="right">
<p><img height="80px" src="<?= base_url('assets/img/logo/logo.jpg'); ?>"></p>
</td>
</tr>
<tr>
<td ><strong>&nbsp;</strong></td>
<td ></td>
<td >
<p></p>
</td>
</tr>
<tr >
<td width="35%" rowspan="8" valign="top">
<b><?= $event[0]->nama_pic; ?></b><br>
<?= $event[0]->address; ?>
</td>
<td width="30%" align="right">
<b>Tanggal Faktur</b>
</td>
<td rowspan="8" width="35%" valign="top" style="padding-left: 10px;">
<b>THUNDER INDONESIA - JAKARTA</b><br>
Jalan Asem No. 54 RT 003/RW 004<br>
Kelapa Dua Wetan - Ciracas<br>
Jakarta Timur - 13730
</td>
</tr>
<tr >

<td align="right">
<?= date('d/m/Y',strtotime($event[0]->tanggal_acara)); ?>
</td>
</tr>
<tr >

<td></td>
</tr>
<tr >

<td align="right">
<b>Tanggal Jatuh Tempo</b>
</td>
</tr>
<tr >

<td align="right">
<?= date('d/m/Y',strtotime($event[0]->tanggal_acara)); ?>
</td>
</tr>
<tr >

<td></td>
</tr>
<tr >

<td align="right">
<b>Nomor Faktur</b>
</td>
</tr>
<tr >

<td align="right">
<?= $event[0]->no_pemesanan; ?>
</td>
</tr>
</tbody>
</table>
<p></p>
<p><strong><?= $event[0]->nama_event; ?></strong></p>
<table border="1" style="border-collapse: collapse; width: 100%;">
<tbody>
<tr style="height: 21px;">
<td style="width: 33.2166%; height: 21px; text-align: center;"><strong>Keterangan</strong></td>
<td style="width: 10.6051%; height: 21px; text-align: center;"><strong>Satuan</strong></td>
<td style="width: 16.1783%; height: 21px; text-align: center;"><strong>Kuantitas</strong></td>
<td style="width: 20%; height: 21px; text-align: center;"><strong>Harga Satuan</strong></td>
<td style="width: 20%; height: 21px; text-align: center;"><strong>Jumlah</strong></td>
</tr>
<tr style="height: 41px;">
<td style="width: 33.2166%; height: 41px;">Biaya Sewa Keseluruhan</td>
<td style="width: 10.6051%; height: 41px;">Pack</td>
<td style="width: 16.1783%; height: 41px; text-align: center;">1</td>
<td style="width: 20%; height: 41px; text-align: right;"><?= number_format($total_harga,2,",","."); ?></td>
<td style="width: 20%; height: 41px; text-align: right;"><?= number_format($total_harga,2,",","."); ?></td>
</tr>
<?php foreach ($kat as $key => $value) { ?>
	<tr style="height: 21px;">
		<td style="width: 33.2166%; height: 21px;">Biaya Sewa <?= !empty(trim($value->nama_kategori))?$value->nama_kategori:' Other '; ?> System</td>
		<td style="width: 10.6051%; height: 21px;"></td>
		<td style="width: 16.1783%; height: 21px;"></td>
		<td style="width: 20%; height: 21px;"></td>
		<td style="width: 20%; height: 21px;"></td>
	</tr>
<?php } ?>

<tr style="height: 41px;">
<td style="width: 80%; height: 41px; text-align: right;" colspan="4">Total</td>
<td style="width: 20%; height: 41px; text-align: right;">Rp. <?= number_format($total_harga,2,",","."); ?></td>
</tr>
</tbody>
</table>
<p></p>
<p></p>
<table style="border-collapse: collapse; width: 100%;">
<tbody>
<tr style="height: 21px;">
<td style="width: 99.8368%; height: 21px;" colspan="2">
<p>Pembayaran atas Invoice ini mohon ditransfer ke rekening :</p>
<p>A/N. ADY RIVANTO</p>
<p>BANK BCA JAKARTA</p>
<p>NO. ACCOUNT 8710-200425</p>
<p>untuk konfirmasi pembayaran mohon email ke financejakarta@thunder-indonesia.com</p>
</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr style="height: 21px;">
<td style="height: 21px; width: 39.9786%; text-align: left;">THUNDER INDONESIA - JAKARTA</td>
<td style="width: 59.8582%;"></td>
</tr>
<tr style="height: 21px;">
<td style="width: 39.9786%; height: 100px;"><img src="" alt="Gambar TTD"></td>
<td style="width: 59.8582%; height: 21px;"></td>
</tr>
<tr style="height: 21px;">
<td style="width: 39.9786%; height: 21px; text-align: left;">FARIDA</td>
<td style="width: 59.8582%; height: 21px;"></td>
</tr>
</tbody>
</table>