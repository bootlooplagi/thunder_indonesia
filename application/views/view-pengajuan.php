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
            <?php if($stat_user=='Super Admin'||$stat_user=='Admin'||$stat_user=='Admin Penerimaan'||$stat_user=='Admin Gudang'){ ?>
              <?php if($act_button=='pengajuan'){ ?>
                  <a href="<?php echo base_url('transaksi/trx/add'); ?>">
                    <button type="button" class="btn btn-success btn-sm">
                      <span class="glyphicon glyphicon-plus"></span> PENGAJUAN BARANG
                    </button>
                  </a>
                  <br><br> 
              <?php } ?>
            <?php } ?> 
            
              <table id="tb_pengajuan" class="table table-bordered table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th class="" style="background-color: #4F81BD; color: white;">NO.</th>
                  <?php if($s_active=='penerimaan'){ ?>
                      <th class="" style="background-color: #4F81BD; color: white;">ID PROJECT</th>
                  <?php } ?>
                  <th class="" style="background-color: #4F81BD; color: white;">NO. PENGAJUAN</th>
                  <th class="" style="background-color: #4F81BD; color: white;">JUDUL PENGAJUAN</th>
                  <th class="" style="background-color: #4F81BD; color: white;">TGL PENGAJUAN</th>
                  <th class="" style="background-color: #4F81BD; color: white;">DIAJUKAN OLEH</th>
                  <?php if($s_active=='pengajuan'){ ?>
                      <th class="" style="background-color: #4F81BD; color: white;">TGL PERSETUJUAN</th>
                      <th class="" style="background-color: #4F81BD; color: white;">DISETUJUI OLEH</th>
                  <?php } ?>
                  <?php if($s_active=='penerimaan'){ ?>
                      <th class="" style="background-color: #4F81BD; color: white;">TGL PENERIMAAN</th>
                      <th class="" style="background-color: #4F81BD; color: white;">DITERIMA OLEH</th>
                  <?php } ?>
                  <th class="" style="background-color: #4F81BD; color: white;">STATUS</th>
                  <th class="" style="background-color: #4F81BD; color: white;">UPDATE BY</th>
                  <th class="" style="background-color: #4F81BD; color: white;">ACTION</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                    if(!empty($tb_pengajuan)||$tb_pengajuan!=null){ ?>
                      <?php $no=1; foreach ($tb_pengajuan as $key => $value) { ?>
                        <?php if(($act_button=='penerimaan' && $value->status==1)||$act_button=='pengajuan'){ ?>
                            <tr>
                              <td><?php echo $no; ?></td>
                              <?php if($s_active=='penerimaan'){ ?>
                                  <td><?php echo $value->id_project; ?></td>
                              <?php } ?>
                              <td><?php echo $value->no_pengajuan; ?></td>
                              <td title="<?php echo $value->judul; ?>"><?php echo substr($value->judul,0, 30).'...'; ?></td>
                              <td><?php echo $value->tgl_pengajuan; ?></td>
                              <td><?php echo $value->submiter; ?></td>
                              <?php if($s_active=='pengajuan'){ ?>
                                  <td><?php echo $value->approve_date; ?></td>
                                  <td><?php echo $value->approval; ?></td>
                              <?php } ?>
                              <?php if($s_active=='penerimaan'){ ?>
                                  <td><?php echo $value->receive_date; ?></td>
                                  <td><?php echo $value->receiver; ?></td>
                              <?php } ?>
                              <td>
                                <?php if($value->status==0){ ?>
                                    <p class="btn bt-sm btn-warning btn-sm" data-toggle="tooltip" title="Status Pengajuan : Menunggu">Pending</p>

                                <?php }else if($value->status==1){ ?>
                                    <?php if($act_button=='pengajuan'){ ?>
                                        <p class="btn bt-sm btn-primary btn-sm" data-toggle="tooltip" title="Status Pengajuan : Diterima">Accept</p>
                                    <?php }else if($act_button=='penerimaan'){ ?>
                                        <?php if($value->stat_penerimaan==0){ ?>
                                            <p class="btn bt-sm btn-warning btn-sm" data-toggle="tooltip" title="Item Belum Diterima / Belum lengkap">Pending</p>
                                        <?php }else if($value->stat_penerimaan==1){ ?>
                                            <p class="btn bt-sm btn-success btn-sm" data-toggle="tooltip" title="Item Sudah Diterima">Verified</p>
                                        <?php } ?>
                                    <?php }?>
                                    
                                <?php }else if($value->status==2){ ?>
                                    <p class="btn bt-sm btn-danger btn-sm" data-toggle="tooltip" title="Status Pengajuan : Ditolak">Reject</p>
                                <?php } ?>


                              </td>
                              <td><?php echo $value->username; ?></td>
                              <td>
                                  <button  type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Tampilkan Pengajuan" onclick="sh_pengajuan(<?php echo $value->id; ?>)">
                                    <span class="glyphicon glyphicon-search"></span>
                                  </button>
                                <?php if($act_button=='pengajuan'){ ?>
                                  <?php if($value->status==0 && $stat_user!='Approval'){ ?>
                                    <a href="<?php echo base_url('transaksi/trx/edit/') . $value->id; ?>">
                                      <button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit Pengajuan">
                                        <span class="glyphicon glyphicon-edit"></span>
                                      </button>
                                    </a>
                                  <?php } ?>
                                  <?php if($value->status==0){ ?>
                                    <?php if($stat_user=='Approval'||$stat_user=='Super Admin'){ ?>
                                        <button onclick="accept_pengajuan(<?php echo $value->id; ?>)" type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Setuju/Terima">
                                          <span class="glyphicon glyphicon-check"></span>
                                        </button>
                                    <?php } ?>
                                  <?php } ?>
                                  <a href="<?php echo base_url('transaksi/cetak_pengajuan/'.$value->id); ?>" target="_blank"><button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" title="Cetak">
                                      <span class="glyphicon glyphicon-print"></span>
                                  </button>
                                  <?php if($value->status==0){ ?>
                                    <?php if($stat_user=='Approval'||$stat_user=='Super Admin'){ ?>
                                        <button onclick="reject_pengajuan(<?php echo $value->id; ?>)" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Reject">
                                            <span class="glyphicon glyphicon-floppy-remove"></span>
                                        </button>
                                    <?php }else{ ?>
                                        <button onclick="del_pengajuan(<?php echo $value->id; ?>,$(this))" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus Pengajuan">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    <?php }
                                  } ?>
                                <?php }else if($act_button=='penerimaan'){ ?>
                                    <?php if($stat_user!='Approval'){ ?>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Upload File Project">
                                            <span class="glyphicon glyphicon-cloud-upload"></span>
                                        </button>
                                    <?php } ?>
                                    <a href="<?php echo base_url('transaksi/cetak_penerimaan/'.$value->id); ?>" target="_blank"><button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" title="Cetak SPB">
                                        <span class="glyphicon glyphicon-print"></span>
                                    </button></a>
                                    <?php if($value->stat_penerimaan==0){ ?>
                                        <?php if($stat_user=='Super Admin' || $stat_user=='Admin' || $stat_user=='Admin Penerimaan'){ ?>
                                            <button type="button" class="btn-sh_peng btn btn-primary btn-sm" data-toggle="tooltip" title="Verifikasi" onclick="sh_pengajuan(<?php echo $value->id; ?>,'verifikasi',$(this))">
                                              <span class="glyphicon glyphicon-check"></span>
                                            </button>
                                        <?php } ?>
                                    <?php }else if($value->stat_penerimaan==1){ ?>

                                    <?php } ?>
                                <?php } ?>
                              </td>
                            </tr>
                        <?php } ?>

                      <?php $no++; } ?>
                  <?php  } 
                  ?>
                  
                </tbody>
              </table>
          <?php } ?>
          

          <?php if($mode=='add' || $mode == 'edit'){ ?> 
            <div class="row">
              <div class="col-lg-10 col-xs-12 col-lg-offset-1">
                <form>
                  <div class="form-group">
                    <label for="judul_pengajuan">Judul Pengajuan</label>
                    <input type="text" class="form-control" id="judul_pengajuan" value="<?php echo !empty($tb_pengajuan) ? $tb_pengajuan[0]->judul:''; ?>" req-submit placeholder="Isikan Judul Pengajuan">
                  </div>
                  <div class="panel-group">
                    <div class="panel panel-default">
                      <div class="panel-heading">List Item  <i class="pull-right">Nomor Pengajuan : <b id="no_pengajuan"><?php echo !empty($tb_pengajuan) ? $tb_pengajuan[0]->no_pengajuan:time(); ?></b></i></div>
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
                                                  $value->qty;
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
                                <table id="tb_item_pengajuan" class="table table-bordered table-hover dt-responsive" cellspacing="0" width="100%">
                                    <thead>
                                      <tr style="background-color: #4F81BD; color: white;">
                                        <th>No</th>
                                        <th>Barcode</th>
                                        <th>Nama Barang</th>
                                        <th>Stock</th>
                                        <th>Jumlah</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php if($mode=='edit'){ ?>
                                        <input type="hidden" class="id_pengajuan" value="<?php echo $id; ?>">
                                        <?php if(!empty($list)){ ?>
                                          
                                          
                                          <?php $no=1; foreach($list as $key => $value) { ?>
                                            
                                            <tr>
                                              <input type="hidden" class="id_item" value="<?php echo $value->ID_ITEM; ?>">
                                              <input type="hidden" class="id_it_pengajuan" value="<?php echo $value->ID_IT_PENGAJUAN; ?>">
                                              <td><?php echo $no; ?></td>
                                              <td><?php echo $value->barcode; ?></td>
                                              <td><?php echo $value->item_name; ?></td>
                                              <td><?php echo $value->i_qty; ?></td>
                                              <td><?php echo $value->qty; ?></td>
                                              <td>
                                                <button onclick="del_ip(<?php echo $value->ID_IT_PENGAJUAN; ?>,$(this))" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete Item">
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
<div id="modal_view_pengajuan" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title judul_pengajuan"></h4>
      </div>
      <div class="modal-body">
          
          <label>Nomor Pengajuan : <i class="no_pengajuan"></i></label>
          <br>
          <label>Tanggal Pengajuan : <i class="tgl_pengajuan"></i></label>
          <br><br>

          <div class="row verifikasi" style="display: none;">  
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div clas="table-responsive">
                <input type="hidden" id="id_pengajuan_penerimaan" name="">
                <table id="tb_item_pengajuan" class="table table-bordered table-hover dt-responsive" cellspacing="0" width="100%">
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