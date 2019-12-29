<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap/dist/css/bootstrap.min.css"> -->
<table width="100%" style="font-family: arial; font-size: 11px; font-weight: bold;">
    <tr>
      <td style="width: 30%; text-align: center;">
        
          <b>PT. TUGU PRATAMA INDONESIA<br>
          ASURANSI KERUGIAN</b>
        
      </td>
      <td style="text-align: center; width: 45%">
           
      </td>
      <td style="text-align: center; width: 30%">
            
      </td>
    <tr>
  </table>

  <table width="100%" style="font-family: arial; font-size: 11px; font-weight: bold;">
    <tr>
      <td style="text-align: center; width: 20%"></td>
      
      <td style="text-align: center; width: 60%">
          <b style="font-size: 12px;">PERMINTAAN BARANG ATK</b><br>
          BERDASARKAN SISA STOCK PER TANGGAL PERMINTAAN
      </td>
      <td style="text-align: center; width: 20%"></td>  
    </tr>
  </table>
  <br>
  <table width="100%" style="font-family: arial; font-size: 11px;">
    <tr>
      <td width="25%"><b>TANGGAL PERMINTAAN :</b></td>
      <td width="20%"><?php echo $date; ?></td>
      <td width="15%"></td>
      <td width="15%"></td>
      <td width="25%"><b>GUDANG. QRP / request.ap</b></td>
    </tr>
  </table>

  <table width="100%" cellpadding="5" class="tbBarang" style="font-family: arial; font-size: 11px;">
    <thead >
      <tr>
        <th class="bhead"></th>
        <th class="bhead"></th>
        <th class="bhead"></th>
        <th class="bhead"></th>
        <th class="bhead"></th>
        <th class="bhead"></th>
        <th class="bhead"></th>
        <th class="bhead"></th>
      </tr>

      <tr >
        <th class="thead bhead" style="width: 15%; text-align: left;">KD. BARANG</td>
        <th class="thead bhead" style="padding-left: 15px; text-align: left; " width="25%">NAMA BARANG</td>
        <th class="thead bhead" style="text-align: left; " width="10%">NO. REQ</td>
        <th class="thead bhead" style="text-align: left; " width="80px">MAX STOCK</td>
        <th class="thead bhead" style="text-align: left; " >SALDO</td>
        <th class="thead bhead" style="text-align: left; " width="80px">MIN. ORDER</td>
        <th class="thead bhead" style="text-align: left; " >REQ</td>
        <th class="thead bhead" style="text-align: left; " >KET</td>
      </tr>

      <tr>
        <th class="thead"></th>
        <th class="thead"></th>
        <th class="thead"></th>
        <th class="thead"></th>
        <th class="thead"></th>
        <th class="thead"></th>
        <th class="thead"></th>
        <th class="thead"></th>
      </tr>
    </thead>
    <tbody >

      <?php foreach ($items as $key => $value) { ?>
        <?php
            if(!empty($items)){
                $date_it = date_create($value->update_it_date);
                $it_date=date_format($date_it,"M Y");
            }
        ?>
        <tr>
          <td style="padding-left: 5px"><?php echo $value->barcode; ?></td>
          <td style="padding-left: 15px"><?php echo $value->item_name; ?></td>
          <td style="padding-left: 5px">0</td>
          <td style="padding-left: 5px">0</td>
          <td style="padding-left: 5px">0</td>
          <td style="padding-left: 5px">0</td>
          <td style="padding-left: 5px"><?php echo $value->qty; ?></td>
          <td style="padding-left: 5px"><?php echo $it_date; ?></td>
        </tr>
      <?php } ?>
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
        <td></td>
      </tr>
    </tfoot>
  </table>

  <table width="100%" style="font-family: arial; font-size: 11px;">
    <tbody>
      <tr>
        <td width="20%"></td>
        <td width="20%"></td>
        <td width="20%"></td>
        <td width="20%"></td>
        <td width="25%"><br><br>Mengetahui,<br>Kasie Persediaan<br><br><br><br><br><b style="text-align: center;">(. . . . . . . . . . . .)</b></td>
      </tr>
    </tbody>
  </table>


  <style type="text/css">
    .tbBarang {
      /*border:0; */
      border-collapse:separate; 
      border-spacing:0 2px;
    }

    .tbBarang thead tr th{
      
      border-collapse:separate; 
      border-spacing:0 2px;
      
    } 

    .tbBarang tfoot tr td{
      /*border-top: 1px solid black; */
      border-top: 2px solid black; 
      border-collapse:separate; 
      border-spacing:0 5px;
    }
    .tbBarang thead tr th.thead{
        border-top: 1px solid black;
    }
    .tbBarang thead tr th.bhead{
        border-bottom: 1px solid black;
    }
/*    .tbBarang tbody tr th{
      border-top: 3px solid black; 
      border-bottom: 3px solid black; 
      border-collapse:collapse; 
      border-spacing:0 0px;
    } */


  </style>