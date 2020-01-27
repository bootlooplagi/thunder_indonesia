

<table width="100%">
  <thead>
    <tr>
      <td><img width="150px" src="<?= base_url().'assets/img/logo/logo.jpg'; ?>"></td>
      <td></td>
      <td style="text-align: right;"><h4>PT. ARCOMEGA DIGITAL PERKASA</h4></td>
    </tr>
  </thead>
</table>

<p width="100%" align="right" style="padding: 0px;">Quotation Produksi</p>
<div style="border: 2px solid black;">
  <div style="float: left;
    width: 50%;">
    <table width="45%">
      <tbody>
        <tr>
          <td style="font-size: 12px;"><b>Kepada</b></td>
          <td style="font-size: 12px;">:</td>
          <td style="font-size: 12px;"><?= $r[0]->nama_pemesan; ?></td>
        </tr>
        <tr>
          <td style="font-size: 12px;"><b>Perusahaan</b></td>
          <td style="font-size: 12px;">:</td>
          <td style="font-size: 12px;"><?= strtoupper($r[0]->nama_perusahaan); ?></td>
        </tr>
        <tr>
          <td style="font-size: 12px;"><b>Nomor</b></td>
          <td style="font-size: 12px;">:</td>
          <td style="font-size: 12px;"><?= strtoupper($r[0]->no_pemesanan); ?></td>
        </tr>
        <tr>
          <td style="font-size: 12px;"><b>No. Fax</b></td>
          <td style="font-size: 12px;">:</td>
          <td style="font-size: 12px;"><?= strtoupper($r[0]->fax); ?></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div style="">
    <table width="45%">
      <tbody>
        <tr>
          <td style="font-size: 12px;"><b>Acara</b></td>
          <td style="font-size: 12px;">:</td>
          <td style="font-size: 12px;"><?= strtoupper($r[0]->nama_event); ?></td>
        </tr>
        <tr>
          <td style="font-size: 12px;"><b>Tanggal</b></td>
          <td style="font-size: 12px;">:</td>
          <td style="font-size: 12px;"><?= date('d',strtotime($r[0]->loading_in)).'-'.date('d&\n\b\s\p;F&\n\b\s\p;Y',strtotime($r[0]->loading_out)); ?></td>
        </tr>
        <tr>
          <td style="font-size: 12px;"><b>Tempat</b></td>
          <td style="font-size: 12px;">:</td>
          <td style="font-size: 12px;"><?= $r[0]->address; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<br>
<?php 
  $total_biaya_prod = 0;   
?>
<table width="100%" border="1" cellspacing="0" style="font-size: 11px;">
  <thead>
    <tr style="background-color: yellow;">
      <td width="30px">No.</td>
      <td>QTY</td>
      <td>UNIT</td>
      <td>ITEMS&nbsp;OF&nbsp;EQUIPMENT</td>
      <td>PRICE</td>
      <td colspan="2" style="text-align: center;">TOTAL</td>
    </tr>
  </thead>
  <tbody>
    <?php $no_kat=1; ?>
    <?php foreach ($kat as $key => $value) { ?>
        <tr>
          <td class="b t" ><?= $no_kat; ?></td>
          <td class="b" ></td>
          <td class="b" ></b></td>
          <td class="b" style="background-color: <?= empty($value->nama_kategori)?'green':'blue'; ?>; color: white;"><b><?= empty($value->nama_kategori)?'TANPA KATEGORI':$value->nama_kategori; ?></td>
          <td class="b" ></td>
          <td class="b r">Rp </td>
          <td class="b l" style="text-align: right;"><?= $total[$value->id]; ?></td>
        </tr>
        <?php $total_biaya_prod+=$total[$value->id]; ?>
        <?php foreach ($r as $k => $v) { ?>
          <?php if($v->id_kat==$value->id){ ?>
            <tr>
              <td class="b"></td>
              <td class="b t"><?= $v->qty; ?></td>
              <td class="b t"><?= $v->satuan; ?></td>
              <td class="b"><?= $v->item_name; ?></td>
              <td class="b"></td>
              <td class="b r"></td>
              <td class="b l"></td>
            </tr>
          <?php } ?>
        <?php } ?>
        <?php $no_kat++; ?>
    <?php } ?>
    <tr>
      <td colspan="5" align="right">TOTAL BIAYA PRODUKSI</td>
      <td>Rp</td>
      <td align="right"><?= $total_biaya_prod; ?></td>
    </tr>
    <tr>
      <td colspan="5" align="right">PPN</td>
      <td>Rp</td>
      <td align="right"><?= $total_biaya_prod*(10/100); ?></td>
    </tr>
    <tr>
      <td colspan="5" align="right">TOTAL</td>
      <td>Rp</td>
      <td align="right"><?= $total_biaya_prod+($total_biaya_prod*(10/100)); ?></td>
    </tr>
    <tr>
      <td height="70px">&nbsp;</td>
      <td colspan="2"></td>
      <td></td>
      <td colspan="3"></td>
    </tr>
    <tr>
      <td colspan="5" align="right">TOTAL</td>
      <td>Rp</td>
      <td align="right"><?= $total_biaya_prod+($total_biaya_prod*(10/100)); ?></td>
    </tr>
    <tr>
      <td colspan="3">Dengan Huruf</td>
      <td colspan="4" align="center"><?= Terbilang($total_biaya_prod+($total_biaya_prod*(10/100))); ?>&nbsp;Rupiah</td>
    </tr>
    <tr>
      <td colspan="3" align="center" class="bt">Thunder Production</td>
      <td colspan="4">Jadwal</td>
    </tr>
    <tr>
      <td colspan="3" rowspan="5" class="tp"></td>
      <td>Instalasi dan Pemasangan</td>
      <td>Jam</td>
      <td colspan="2"></td>
    </tr>
    <tr>
      <td>Gladi Resik</td>
      <td>Jam</td>
      <td colspan="2"></td>
    </tr>
    <tr>
      <td>Acara</td>
      <td>Jam</td>
      <td colspan="2"></td>
    </tr>
    <tr>
      <td colspan="4" align="center">mohon disertakan surat loading dari venue</td>
    </tr>
    <tr>
      <td colspan="4" class="bt">Note:</td>
    </tr>
    <tr>
      <td colspan="3" rowspan="6" align="center" valign="top" class="bt">Menyetujui,</td>
      <td colspan="4" class="b">* Pembayaran dilakukan 50% sebagai down payment</td>
    </tr>
    <tr>
      
      <td colspan="4" class="b">* Pelunasan dilakukan setelah selesai setting alat</td>
    </tr>
    <tr>
      
      <td colspan="4" class="b">* Biaya di luar pajak-pajak yang dikenakan</td>
    </tr>
    <tr>
      
      <td colspan="4" class="b">-</td>
    </tr>
    <tr>
      
      <td colspan="4" class="tp">-</td>
    </tr>
    <tr>
      
      <td colspan="4">Masa Berlaku</td>
    </tr>
    <tr>
      <td colspan="3" align="center" class="tp">(please sign here)</td>
      <td colspan="4">Penawaran ini berlaku sampai dengan tanggal :</td>
    </tr>


    
  </tbody>
  <tfoot>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tfoot>
</table>


<style type="text/css">
  .b{
    border-bottom: 0px solid white;
    border-top: 0px solid white;
  }
  .t{
    text-align: center;
  }

  .r{
    border-right: 0px solid white;
  }

  .l{
    border-left: 0px solid white;
  }

  .bt{
    border-bottom: 0px solid white;
  }

  .tp{
    border-top: 0px solid white;
  }

  table tbody tr td{
    padding-right: 10px;
    padding-left: 10px;
  }
</style>