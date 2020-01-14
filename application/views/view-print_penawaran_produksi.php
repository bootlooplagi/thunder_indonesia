<table width="100%">
  <tbody>
    <tr>
      <td><h3>PENAWARAN</h3></td>
      <td colspan="2"></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td style="text-align: right;"><img width="150px" src="<?= base_url().'assets/img/logo/logo.jpg'; ?>"></td>
    </tr>
    <tr>
      <td colspan="3" height="50px"></td>
    </tr>
    <tr>
      <td>
        <?php echo $r[0]->nama_pic; ?><br>
        Jakarta
      </td>
      <td width="40%" style="text-align: center;">
        Tanggal Acara<br><br>
        <p style="font-size: 12px; font-weight: bold;">
          <?= date('d F Y',strtotime($r[0]->loading_in)).' - '.date('d F Y',strtotime($r[0]->loading_out)); ?>
        </p>
      </td>
      <td>
        <p style="font-weight: bold;"><?= $r[0]->nama_pemesan; ?></p><br>
        <?= $r[0]->address; ?>
      </td>
    </tr>
    <tr>
      <td height="50px" colspan="3"></td>
    </tr>
    <tr>
      <td colspan="2"><?= strtoupper($r[0]->nama_event); ?></td>
      <td></td>
    </tr>
  </tbody>
</table>

<table width="100%" border="1" cellspacing="0">
  <thead>
    <tr>
      <th>NO</th>
      <th>QTY</th>
      <th>UNIT</th>
      <th>ITEM OF EQUIPMENT</th>
      <th>PRICE</th>
      <th>TOTAL</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($r as $key => $value) { ?>
      <tr>
        <td></td>
        <td><?= $value->qty; ?></td>
        <td>ITEM</td>
        <td><?= $value->item_name; ?></td>
        <td><?= $value->harga; ?></td>
        <td><?= $value->harga * $value->qty; ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<table width="100%">
  <tbody>
    <tr>
      <td colspan="3" height="50px"></td>
    </tr>
    <tr>
      <td style="font-size: 12px; font-weight: bold;" width="50%" rowspan="3">
        Note : <br><br>

        * Pembayaran dilakukan 50% sebagai down payment<br>
        * Pelunasan dilakukan setelah selesai setting alat<br>
        * Biaya diluar pajak yang dikenakan<br>
        <br>
        <br>
        <br>
        Mohon disertakan surat loading dari venue
      </td>
      <td width="30%" style="vertical-align: top;">
        Instalasi dan pemasangan
      </td>
      <td width="20%" style="vertical-align: top;">Jam :</td>
    </tr>
    <tr>
      <td width="30%" style="vertical-align: top;">
        Gladi Resik
      </td>
      <td width="20%" style="vertical-align: top;">Jam :</td>
    </tr>
    <tr>
      <td width="30%" style="vertical-align: top;">
        Acara
      </td>
      <td width="20%" style="vertical-align: top;">Jam :</td>
    </tr>
  </tbody>
</table>

<table>
  <tbody>
    <tr>
      <td height="100px"></td>
    </tr>
    <tr>
      <td>THUNDER INDONESIA - JAKARTA</td>
    </tr>
    <tr>
      <td height="100px"></td>
    </tr>
    <tr>
      <td>FARIDA</td>
    </tr>
  </tbody>
</table>