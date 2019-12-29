<script>
  var kat = <?php echo json_encode($kats); ?>;
  var sub = <?php echo json_encode($subs); ?>;
</script>






<input type="hidden" id="BASE_URL" value="<?php echo base_url(); ?>">
<div class="row">
  <div class="col-md-12 ">
    <div id="table-wrapper">
        <center>
          <h2><?php echo $page_title; ?></h2>
          <hr style="border-top: 3px double #8c8b8b;">
        </center>     
        <button type="button" id="addRow" class="btn btn-success pull-right" data-toggle="modal" data-target="#add-item"><span class="glyphicon glyphicon-plus"></span>
          Tambah Item
        </button>
        <br><br>            
        <table id="tblItem" class="table table-bordered table-striped table-hover dt-responsive" cellspacing="0" width="100%" style="font-size: 12px;">
          <thead>
          <tr>
            <th class="" style="background-color: #4F81BD; color: white; ">NO.</th>
            <th class="" style="background-color: #4F81BD; color: white; ">BARCODE</th>
            <th class="" style="background-color: #4F81BD; color: white; ">ITEM NAME</th>
            <th class="" style="background-color: #4F81BD; color: white; ">SUB CATEGORY.</th>
            <th class="" style="background-color: #4F81BD; color: white; ">ITEM CATEGORY</th>
            <th class="" style="background-color: #4F81BD; color: white; ">QTY</th>
            <th class="" style="background-color: #4F81BD; color: white; ">LOST REMARK</th>
            <th class="" style="background-color: #4F81BD; color: white; ">FRAGILE</th>
            <th class="" style="background-color: #4F81BD; color: white; ">STATUS</th>
            <th class="" style="background-color: #4F81BD; color: white; ">HARGA BELI</th>
            <th class="" style="background-color: #4F81BD; color: white; ">HARGA JUAL</th>
            <th class="" style="background-color: #4F81BD; color: white; ">LOKASI</th>
            <th class="" style="background-color: #4F81BD; color: white; ">UPDATE BY</th>
            <th class="" style="background-color: #4F81BD; color: white; ">UPDATE DATE</th>
            <th class="" style="background-color: #4F81BD; color: white; ">ACTION.</th>
          </tr>
          </thead>
          <tbody>

            <?php 
              $no = 1;
              if(!empty($tb_item) && $tb_item !== NULL){
                
                foreach ($tb_item as $tb) {
                  $nama_gudang = !empty($tb->nama_gudang) ? $tb->nama_gudang:"<b class=\'c_red\'>Belum ditentukan</b>";
                  $kode_gudang = !empty($tb->kode_gudang) ? $tb->kode_gudang:"<b class=\'c_red\'>Belum ditentukan</b>";
                  $kode_lokasi = !empty($tb->kode_lokasi) ? $tb->kode_lokasi:"<b class=\'c_red\'>Belum ditentukan</b>";
                  $kode_rak = !empty($tb->kode_rak) ? $tb->kode_rak:"<b class=\'c_red\'>Belum ditentukan</b>";

                  $lokasi = "'Nama Gudang : <label>". $nama_gudang ."</label><br>".
                            "Kode Gudang : <label> ". $kode_gudang ."</label><br>".
                            "Kode Lokasi : <label> ". $kode_lokasi ."</label><br>".
                            "Kode Rak : <label> ". $kode_rak ."</label>'";
                  // echo $lokasi;

                  echo '<tr>
                        <td>'.$no.'</td>
                        <td>'.$tb->barcode.'</td>
                        <td style="font-weight:bold;">'.$tb->nama_item.'</td>
                        <td>'.$tb->jenis_item.'</td>
                        <td>'.$tb->kategori_item.'</td>
                        <td  title="'. $tb->deskripsi_satuan .'">'.$tb->qty . ' ' . $tb->satuan .'</td>
                        <td>'.$tb->lost_remark.'</td>
                        <td>'.$tb->fragile.'</td>
                        <td>'.$tb->status.'</td>
                        <td>'.number_format($tb->harga_beli,0,",",".").'</td>
                        <td>'.number_format($tb->harga_jual,0,",",".").'</td>
                        <td><button class="btn btn-xs bg-blue" title="Lokasi Penyimpanan" onclick="$.alert({title:\'LOKASI\',content:'.$lokasi.'})"><span class="glyphicon glyphicon-folder-open"></span></button></td>
                        <td>'.$tb->update_by_username.'</td>
                        <td>'.date('F d', strtotime($tb->update_date)).', '.date('Y H.i A', strtotime($tb->update_date)).'</td>
                        <td><center>
                          <button data-toggle="tooltip" title="Edit Item" class="btn btn-warning btn-xs" onclick="edit($(this),'. $tb->ID_ITEM .')" value="'
                          .$tb->barcode.'|'
                          .$tb->nama_item.'|'
                          .$tb->id_sub .'|'
                          .$tb->id_kat .'|'
                          .$tb->qty . '|'
                          .$tb->satuan . '|'
                          .$tb->deskripsi_satuan . '|'

                          .number_format($tb->harga_beli,0,",",".") . '|'
                          .number_format($tb->harga_jual,0,",",".") . '|'
                          .$tb->lost_remark . '|'
                          .$tb->fragile . '|'
                          .$tb->status . '|'
                          .$tb->nama_gudang . '|'
                          .$tb->kode_gudang . '|'
                          .$tb->kode_lokasi . '|'
                          .$tb->kode_rak . '|'
                          .$tb->tahun_pembelian .


                          '"><span class="glyphicon glyphicon-edit"></span></button>
                          <button data-toggle="tooltip" title="Hapus Item" class="btn btn-danger btn-xs" onclick="del('.$tb->ID_ITEM.')"><span class="glyphicon glyphicon-trash"></span></button>
                          <a href="'.base_url('produk/printbarcode?id=').$tb->ID_ITEM.'" target="_blank"><button data-toggle="tooltip" title="Print Barcode" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-print"></span></button></a>
                          </center>
                        </td>
                      </tr>';
                  $no++;
                }
               
              }
            ?>
          </tbody>
        </table>
        <?php echo '<input type="hidden" class="cItem" value="'. $no .'">'; ?>
    </div>
  </div>
</div>

<div class="modal modal-success fade" id="add-item" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Add Item</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id_item" name="id" value=""/><br>
        <form id="form_item">
            <div class="row">
              <label for="code" class="col-sm-3 control-label">Barcode <span class="asterisk">*</span></label>

              <div class="col-sm-7">
                <input type="text" class="req form-control" id="it_barcode" name="it_barcode" placeholder="Masukkan Barcode" value="">
              </div>
              <div class="col-sm-1 btn btn-success" onclick="c_barcode()"><span class="glyphicon glyphicon-barcode"></span></div>
            </div> <br>
            <div class="row">
              <label for="code" class="col-sm-3 control-label">Nama Item <span class="asterisk">*</span></label>

              <div class="col-sm-9">
                <input type="text" class="req form-control" id="it_nama" name="it_nama" placeholder="Nama Item/Produk" value="" required>
              </div>
            </div> <br>
            <div class="row">
              <label for="katName" class="col-sm-3 control-label">Kategori <span class="asterisk">*</span></label>  
              <div class="col-sm-9">
                <select  onchange="setSub($(this))" id="kat_id" class="katName select2 req form-control col-sm-12" name="it_id_kat" required>
                  
                  <?php
                    foreach ($tb_kategori as $op_kat) {
                        echo '<option value="'. $op_kat->id .'" ';                         

                        echo '>'.$op_kat->description.'</option>';
                    }
                  ?>
                </select>
              </div>
            </div>
            <br>
            <div class="row">
              <label for="subKatName" class="col-sm-3 control-label">Sub Kategori <span class="asterisk">*</span></label>  
              <div class="col-sm-9">
                <select  id="sub_kat_id" class="subKatName select2 req form-control col-sm-12" name="it_id_sub" required>
                  <?php
                    foreach ($tb_sub_kategori as $op_sub_kat) {
                        echo '<option value="'. $op_sub_kat->id .'" ';                         

                        echo '>'.$op_sub_kat->sub_description.'</option>';
                    }
                  ?>
                </select>
              </div>
            </div>
            <br>
            <div class="row">
              <label for="qty" class="col-sm-3 control-label">Qty <span class="asterisk"></span></label>

              <div class="col-sm-9">
                <input type="number" class="req form-control" id="it_qty" name="it_qty" placeholder="Jumlah Item" value="" required>
              </div>
            </div> <br>

            <div class="row">
              <label for="sat" class="col-sm-3 control-label">Satuan <span class="asterisk"></span></label>

              <div class="col-sm-9">
                <input type="text" class="req form-control" id="it_sat" name="it_sat" placeholder="Satuan Item. Ex: Pcs" value="" required>
              </div>
            </div> <br>

            <div class="row">
              <label for="it_sat_des" class="col-sm-3 control-label">Deskripsi Satuan <span class="asterisk"></span></label>

              <div class="col-sm-9">
                <textarea type="text" class="req form-control" id="it_sat_des" name="it_sat_des" placeholder="Ex : 1 Box Isi 10 Pcs" value="" required></textarea>
              </div>
            </div> <br>


            <div class="row">
              <label for="it_harga_beli" class="col-sm-3 control-label">Harga Beli <span class="asterisk">*</span></label>

              <div class="col-sm-9">
                <input onkeydown="toIDR(this)" type="text" class="form-control" id="it_harga_beli" name="it_harga_beli" placeholder="" value="" required>
              </div>
            </div> <br>

            <div class="row">
              <label for="it_harga_jual" class="col-sm-3 control-label">Harga Jual <span class="asterisk">*</span></label>
              <div class="col-sm-9">
                <div class="btn btn-default btn-block" onclick="add_durasi()">List Durasi (Click to Manage)</div>
              </div>
                <input onkeydown="toIDR(this)" type="hidden" class="req form-control" id="it_harga_jual" name="it_harga_jual" placeholder="" value="0" required>

            </div><br>

            <div class="row">
              <label for="it_lost_remark" class="col-sm-3 control-label">Lost Remark <span class="asterisk">*</span></label>

              <div class="col-sm-9">
                <input type="text" class="req form-control" id="it_lost_remark" name="it_lost_remark" placeholder="" value="" required>
              </div>
            </div><br>

            <div class="row">
              <label for="it_fragile" class="col-sm-3 control-label">Fragile <span class="asterisk">*</span></label>

              <div class="col-sm-9">
                <select class="form-control" id="it_fragile" name="ii_fragile">
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </div>
            </div><br>

            <div class="row">
              <label for="it_status" class="col-sm-3 control-label">Remark Status <span class="asterisk">*</span></label>

              <div class="col-sm-9">
                <input type="text" class="req form-control" id="it_status" name="it_status" placeholder="" value="" required>
              </div>
            </div><br>

            <div class="row">
              <label for="it_status" class="col-sm-3 control-label">Location <span class="asterisk">*</span></label>
              <style type="text/css">
                .lbl-location{
                  font-size: 11px;
                }
                .inp-location{
                  padding-right: 0px;

                }
              </style>
              <div class="col-sm-9" style="padding-left: 0px;">
                  <div class="col-sm-3 inp-location">
                        <label for="it_status" class="lbl-location control-label">Nm. Gudang <span class="asterisk">*</span></label>
                        <input type="text" class=" req form-control col-sm-3" id="it_loc_nm_gudang" name="it_loc_nm_gudang" placeholder="" value="" required>
                  </div>
                  <div class="col-sm-3 inp-location">
                        <label for="it_status" class="lbl-location control-label">Kd. Gudang <span class="asterisk">*</span></label>
                        <input type="text" class=" req form-control col-sm-3" id="it_loc_kd_gudang" name="it_loc_kd_gudang" placeholder="" value="" required>
                  </div>
                  <div class="col-sm-3 inp-location">
                        <label for="it_status" class="lbl-location control-label">Kd. Lokasi <span class="asterisk">*</span></label>
                        <input type="text" class=" req form-control col-sm-3" id="it_loc_kd_lokasi" name="it_loc_kd_lokasi" placeholder="" value="" required>
                  </div>
                  <div class="col-sm-3 inp-location">
                        <label for="it_status" class="lbl-location control-label">Kd. Rak <span class="asterisk">*</span></label>
                        <input type="text" class=" req form-control col-sm-3" id="it_loc_kd_rak" name="it_loc_kd_rak" placeholder="" value="" required>
                  </div>
              </div>

            </div><br>

            <div class="row">
              <label for="it_th_beli" class="col-sm-3 control-label">Th. Pembelian <span class="asterisk">*</span></label>

              <div class="col-sm-9">
                <input type="text" class="req date_pembelian form-control" id="it_th_beli" name="it_th_beli" placeholder="" value="" required>
              </div>
              <style type="text/css">
                  .bootstrap-datetimepicker-widget table thead tr th,.bootstrap-datetimepicker-widget table tbody tr td{color:black;}
              </style>
            </div><br>
        </form>


        <div class="row">
          <label for="code" class="col-sm-3 control-label">Photos <span class="asterisk">*</span></label>

          <div class="col-sm-9">
            <form id="up" method="post" enctype="multipart/form-data">
              <div class="img_upload col-sm-4">
                <label for="photo1">
                  <img src="<?php echo base_url('assets/img/add.png'); ?>" class="photo img-thumbnail " alt="Cinque Terre">
                </label>
                <input id="photo1" type="file" accept=".jpg,.jpeg,.png" name="image[]" onchange="previewFile($(this))">
              </div>

              <div class="img_upload col-sm-4">
                <label for="photo2">
                  <img src="<?php echo base_url('assets/img/add.png'); ?>" class="photo img-thumbnail " alt="Cinque Terre">
                </label>
                <input id="photo2" type="file" accept=".jpg,.jpeg,.png" name="image[]" onchange="previewFile($(this))">
              </div>

              <div class="img_upload col-sm-4">
                <label for="photo3">
                  <img src="<?php echo base_url('assets/img/add.png'); ?>" class="photo img-thumbnail " alt="Cinque Terre">
                </label>
                <input id="photo3" type="file" accept=".jpg,.jpeg,.png" name="image[]" onchange="previewFile($(this))">
              </div>
            </form>
          </div>
          
        </div><br>




      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
        <button type="button" id="save" class="btn btn-outline">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
    <!-- /.modal-dialog -->
</div>

<style type="text/css">
  .nophoto{
    filter: opacity(0.2);
  }
  .img_upload > input{
    display: none;
  }

  .bx{
    background:rgba(255,0,0,0.1);
/*    width:100px; height:100px;
    position:relative;*/
    
    -webkit-transition: background .5s ease-out;
       -moz-transition: background .5s ease-out;
         -o-transition: background .5s ease-out;
            transition: background .5s ease-out;
  }
</style>

<style type="text/css">
  .c_red{
    color: red;
  }
</style>

<div style="display: none">
    <div id="add_durasi">
      <input type="hidden" name="id_item" class="form-control">
      <div class="form-group col-sm-12">
        <label>Nama</label>
        <input type="text" name="name" class="form-control">
      </div>
      <div class="form-group col-sm-12">
        <label>Harga</label>
        <input type="text" name="harga" class="form-control">
      </div>
      <div class="form-group col-sm-12">
        <ul class="list-group" id="list_durasi">
          <!-- Diisi -->
        </ul>
      </div>
    </div>
</div>