  <script >
    var URL = '<?php echo base_url(); ?>';
  </script>

  <div class="row">
    <div class="col-md-12 ">
      <div id="table-wrapper">
          <center>
            <h2><?php echo $page_title; ?></h2>
            <hr style="border-top: 3px double #8c8b8b;">
          </center>     

          <?php if($mode=='view'){ ?>
            <?php if($user=='Super Admin'||$user=='Admin'||$user=='Admin Penerimaan'||$user=='Admin Gudang'){ ?>
                  <a href="<?php echo base_url('produk/paket_item/add'); ?>">
                    <button type="button" class="btn btn-success btn-sm">
                      <span class="glyphicon glyphicon-plus"></span> BUAT PAKET
                    </button>
                  </a>
                  <br><br> 
            <?php } ?> 
            
              <table id="tb_paket" class="table table-bordered table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th class="" style=" color: white;">NO.</th>
                  <th class="" style=" color: white;">NAMA PAKET</th>
                  <th class="" style=" color: white;">DESKRIPSI PAKET</th>
                  <th class="" style=" color: white;">JUMLAH ITEM</th>
                  <th class="" style=" color: white;">HARGA PAKET</th>
                  <th class="" style=" color: white;">TANGGAL PEMBUATAN</th>
                  <th class="" style=" color: white;">UPDATE BY</th>
                  <th class="" style=" color: white;">UPDATE DATE</th>
                  <th class="" style=" color: white;">ACTION</th>
                </tr>
                </thead>
                  <?php if(!empty($tb_paket)){ ?>
                      <?php foreach($tb_paket as $key => $value){ ?>
                          <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $value->item_name; ?></td>
                            <td><?php echo $value->item_description; ?></td>
                            <td><?php echo $value->jml_item; ?></td>
                            <td><?php echo number_format($value->harga_jual,"0",",","."); ?></td>
                            <td><?php echo $value->insert_date; ?></td>
                            <td><?php echo $value->name; ?></td>
                            <td><?php echo $value->update_date; ?></td>
                            <td>
                                <a href="<?php echo base_url('produk/paket_item/edit/'.$value->id_paket); ?>">
                                  <button 
                                      data-toggle="tooltip" 
                                      title="Edit Kategori" 
                                      class="btn btn-warning">
                                      <span class="glyphicon glyphicon-edit"></span>
                                  </button>
                                </a>
                                
                                <button 
                                    data-toggle="tooltip" 
                                    title="Hapus Paket" 
                                    class="btn btn-danger" 
                                    onclick="del_paket(<?php echo $value->id_paket; ?>,$(this))">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            </td>
                          </tr>
                      <?php } ?>
                  <?php } ?>
                <tbody>

                </tbody>
              </table>
          <?php } ?>
          

          <?php if($mode=='add' || $mode == 'edit'){ ?> 
            <div class="row">
              <div class="col-lg-10 col-xs-12 col-lg-offset-1">
                <form>
                  <div class="row">
                      <div class="form-group col-xs-5">
                        <label for="nama_paket">Nama Paket</label>
                        <input type="text" class="form-control" id="nama_paket" value="<?php echo !empty($tb_paket) ? $tb_paket[0]->package_name:''; ?>" req-submit placeholder="Isikan Judul paket">
                      </div>
                      <div class="form-group col-xs-3">
                        <label for="harga_paket">Harga Paket</label>
                        <input onkeydown="toIDR(this)" type="text" class="form-control" id="harga_paket" value="<?php echo !empty($tb_paket) ? number_format($tb_paket[0]->package_price,0,",","."):''; ?>" req-submit placeholder="Isikan Harga Paket">
                      </div>
                  </div>
                  <div class="row">
                      <div class="form-group col-xs-8">
                        <label for="deskripsi_paket">Deskripsi Paket</label>
                        <textarea name="deskripsi_paket" id="deskripsi_paket" class="form-control" req-submit placeholder="Isikan Judul paket" req-submit><?php echo !empty($tb_paket) ? trim($tb_paket[0]->package_description):''; ?></textarea>
                      </div>
                  </div>
                  <div class="panel-group">
                    <div class="panel panel-default">
                      <div class="panel-heading">List Item  <i class="pull-right">Nomor paket : <b id="no_paket"><?php echo !empty($tb_paket) ? $tb_paket[0]->no_paket:time(); ?></b></i></div>
                      <div class="panel-body">
                          <div class="row">
                            <div class="col-xs-5">
                              <div class="form-group">
                                <label for="item_select">Select Item</label>
                                <div class="input-group">
                                  
                                  <select class="select2 act" id="item_select" onchange="ch_select($(this).val())">
                                        <option disabled="disabled" selected="selected">--Select Item--</option>
                                    <?php foreach ($items as $key => $value) { ?>
                                        <?php 
                                          $val =  $value->ID_ITEM . '|' .
                                                  $value->barcode . '|' .
                                                  $value->nama_item . '|' .
                                                  $value->qty . '|' .
                                                  $value->harga_jual;
                                        ?>
                                        <option value="<?php echo $val; ?>"><?php echo $value->nama_item . ' - ' . $value->barcode; ?></option>
                                    <?php } ?>
                                  </select>
                                  
                                  <span  onclick="u_barcode()" class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Use Barcode" style="cursor: pointer;"><i class="glyphicon glyphicon-barcode"></i></span>
                                </div>
                              </div>
                            </div>
                            <div class="col-xs-3">
                              <div class="form-group">
                                <label for="bc">Barcode <input type="checkbox" onclick="autoenter($(this))" id="auto_enter" name=""><i>Auto Enter</i></label>

                                <input  name="bc" type="number" min="1" class="form-control" id="bc" placeholder="Input Barcode">
                              </div>
                            </div>
                            <div class="col-xs-3">
                              <div class="form-group">
                                <label for="qty">Jumlah</label>
                                <input onkeydown="enter(event)" type="number" min="1" class="form-control" id="qty" req-add-item placeholder="Qty">
                              </div>
                            </div>
                            <div class="col-xs-1">
                              <div class="form-group">
                                <label for="">ACT</label>
                                <button id="btn_add" onclick="add_item(); " type="button" class="btn btn-success btn-sm" data-toggle="tooltip" title="Add Item"><span class="glyphicon glyphicon-plus"></span></button>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-xs-12">
                              <div clas="table-responsive">
                                <table id="tb_item_paket" class="table table-bordered table-hover dt-responsive" cellspacing="0" width="100%">
                                    <thead>
                                      <tr style="background-color: #4F81BD; color: white;">
                                        <th>No</th>
                                        <th>Barcode</th>
                                        <th>Nama Barang</th>
                                        <th>Stock</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php if($mode=='edit'){ ?>
                                        <input type="hidden" class="id_paket" value="<?php echo $id; ?>">
                                        <?php if(!empty($list)){ ?>
                                          
                                          
                                          <?php $no=1; foreach($list as $key => $value) { ?>
                                            
                                            <tr>
                                              <input type="hidden" class="id_item" value="<?php echo $value->ID_ITEM; ?>">
                                              <input type="hidden" class="id_it_paket" value="<?php echo $value->id_it_paket; ?>">
                                              <td><?php echo $no; ?></td>
                                              <td><?php echo $value->barcode; ?></td>
                                              <td><?php echo $value->item_name; ?></td>
                                              <td><?php echo $value->stock; ?></td>
                                              <td><?php echo number_format($value->item_price,0,",","."); ?></td>
                                              <td><?php echo $value->item_qty; ?></td>
                                              <td><?php echo number_format($value->total,0,",","."); ?></td>
                                              <td>
                                                <button onclick="del_ip(<?php echo $value->id_it_paket; ?>,$(this))" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete Item">
                                                  <span class="glyphicon glyphicon-trash"></span>
                                                </button>
                                              </td>
                                            </tr>
                                          <?php $no++; } ?>
                                        <?php }?>
                                      <?php }?>
                                    </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                      </div>
                      <div class="panel panel-footer">
                        <div class="row">
                          <div class="col-xs-12">
                            <div onclick="submit('<?php echo $mode; ?>')" class="btn btn-success btn-sm pull-right">
                                <span class="glyphicon glyphicon-plus"></span> SUBMIT
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>

          <?php } ?>
      </div>
    </div>
  </div>







  <!-- Modal -->
<div id="modal_view_paket" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title judul_paket"></h4>
      </div>
      <div class="modal-body">
          
          <label>Nomor paket : <i class="no_paket"></i></label>
          <br>
          <label>Tanggal paket : <i class="tgl_paket"></i></label>
          <br><br>

          <div class="row verifikasi" style="display: none;">  
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div clas="table-responsive">
                <input type="hidden" id="id_paket_penerimaan" name="">
                <table id="tb_item_paket" class="table table-bordered table-hover dt-responsive" cellspacing="0" width="100%">
                    <thead>
                      <tr style="background-color: #4F81BD; color: white;">
                        <th>No</th>
                        <th>Barcode</th>
                        <th>Nama Barang</th>
                        <th>Stock</th>
                        <th>Jumlah</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
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


<style type="text/css">
    input#bc::-webkit-inner-spin-button,input#bc_item::-webkit-inner-spin-button, 
    input#bc::-webkit-outer-spin-button,input#bc_item::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>