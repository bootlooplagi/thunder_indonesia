<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">Pengingat Penawaran Acara</div>
              <div class="panel-body">
                    <div class="form-group col-md-5" >
                        <div class="row">
                            <div class="col-md-12">
                                <div id="datetimepicker12"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-5" >
                        <label>LIST PENAWARAN :</label>
                    </div>
                    <div class="form-group col-md-5" >
                        <ul id="event_list" class="list-group">
                            
                        </ul>
                    </div>
              </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default ">
              <div class="panel-heading bg-yellow">TOTAL ITEM YANG DISEWA</div>
              <div class="panel-body">
                    <div class="form-group col-md-12" >
                        <table class="table table-bordered table-responsive table-hover table-report" id="tb_item_disewa">
                            <thead>
                                <tr class="bg-purple">
                                    <th>No.</th>
                                    <th>Nama Produk</th>
                                    <th>Total Disewa (QTY)</th>
                                    <th>Total Anggaran (Non Nego)</th>
                                    <th>Total Anggaran (After Nego)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($tb_item_disewa)){ ?>
                                    <?php foreach ($tb_item_disewa as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo $key+1; ?></td>
                                            <td><?php echo $value->item_name; ?></td>
                                            <td><?php echo $value->total_disewa; ?></td>
                                            <td><?php echo $value->total_anggaran_from_durasi; ?></td>
                                            <td><?php echo $value->anggaran_akhir; ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
              </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default ">
              <div class="panel-heading bg-purple">ITEM TERLARIS</div>
              <div class="panel-body">
                    <div class="form-group col-md-12" >
                        <table class="table table-bordered table-responsive table-hover table-report" id="tb_item_disewa">
                            <thead>
                                <tr class="bg-purple">
                                    <th>No.</th>
                                    <th>Nama Produk</th>
                                    <th>Total Disewa (QTY)</th>
                                    <!-- <th>Total Anggaran (Non Nego)</th>
                                    <th>Total Anggaran (After Nego)</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($tb_item_disewa)){ ?>
                                    <?php foreach ($tb_item_disewa as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo $key+1; ?></td>
                                            <td><?php echo $value->item_name; ?></td>
                                            <td><?php echo $value->total_disewa; ?></td>
                                           <!--  <td><?php echo $value->total_anggaran_from_durasi; ?></td>
                                            <td><?php echo $value->anggaran_akhir; ?></td> -->
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
              </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default ">
              <div class="panel-heading bg-green">REPORT DRIVER</div>
              <div class="panel-body">
                    <div class="form-group col-md-12" >
                        <table class="table table-bordered table-responsive table-hover table-report" id="tb_item_disewa">
                            <thead>
                                <tr class="bg-green">
                                    <th>No.</th>
                                    <th>Nama Driver</th>
                                    <th>Total Jobs</th>
                                    <th>Progress</th>
                                    <th>Done</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($tb_jumlah_driver)){ ?>
                                    <?php foreach ($tb_jumlah_driver as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo $key+1; ?></td>
                                            <td><?php echo $value->name; ?></td>
                                            <td><?php echo $value->total_jobs; ?></td>
                                            <td><?php echo $value->progress; ?></td>
                                            <td><?php echo $value->done; ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align: right;">Total Driver :</td>
                                    <td><?php echo $total_driver; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: right;">Total Driver Assigned :</td>
                                    <td><?php echo $driver_assigned; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: right;">Total Driver Belum Assigned :</td>
                                    <td><?php echo $driver_no_assigned; ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
              </div>
            </div>
        </div>
    </div>
</div>


<div id="modal_view_pemesanan" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title judul_pemesanan"></h4>
      </div>
      <div class="modal-body">
          
          <label>Nomor Pemesanan : <i class="no_pemesanan"></i></label>
          <br>
          <label>Tanggal Pemesanan : <i class="tgl_pemesanan"></i></label>
          <br><br>

          <label>Pemesan </i></label><br>
          <label style="font-weight: normal;">Nama Pemesan : <i style="font-weight: bold; color: blue;" class="nm_pemesan"></i></label>
          <br>

          <label style="font-weight: normal;">Group : <i style="font-weight: bold; color: blue;" class="v_group"></i></label>
          <br>
          <label style="font-weight: normal;">Lantai : <i style="font-weight: bold; color: blue;" class="v_lantai"></i></label>
          <br><br>

          <div class="row verifikasi" style="display: none;">  
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div clas="table-responsive">
                <input type="hidden" id="id_pemesanan_lg" name="">
                <table id="modal_tb_item_pemesanan" class="table table-bordered table-hover dt-responsive" cellspacing="0" width="100%">
                    <thead>
                      <tr style="background-color: #4F81BD; color: white;">
                        <th>No</th>
                        <th>Barcode</th>
                        <th>Nama Barang</th>
                        <th>Stock</th>
                        <th>Jumlah</th>
                        <th>Disc</th>
                        <th>Extra Charge</th>
                        <th>Durasi</th>
                        <th>Harga Satuan</th>
                        <th>Harga Total</th>
                        <th>Harga Akhir</th>

                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                    <tfoot>
                      <tr class="bg-gray">
                        <td colspan="10" style="text-align: right"><b>Total Harga Akhir :</b></td>
                        <td style="color:blue" class="t_right"><b id="total_akhir"></b></td>
                      </tr>
                    </tfoot>
                </table>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
    var reminder;
</script>