<!-- <div class="col-lg-12">
  <div class="row">
      <div class="col-lg-6 form-group">
          <label>Pilih Barang</label>
          <select class="form-control select2" id="sel_barang">
            <?php foreach ($items as $key => $value) { ?>
                <option value='<?php echo $value->ID_ITEM; ?>'><?php echo $value->nama_item?></option>
            <? } ?>
          </select>
      </div>
  </div>
  <div class="row">
      <div class="col-lg-12">
          <div class="panel panel-default">
              <div class="panel-heading">List Barang (Serial Number)</div>
              <div class="panel-body">
                  <table class="table table-wrapper table-bordered table-hover table-striped">
                    <thead>
                      <tr style="color: white;">
                        <th>No.</th>
                        <th>Nama Vendor</th>
                        <th>Serial Number</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Masuk</th>
                      </tr>
                    </thead>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div> -->


<?php if($mode=='view'){ ?>
    <!-- Content Header (Page header) -->
    <input type="hidden" id="BASE_URL" value="<?php echo base_url(); ?>">
    <script type="text/javascript">
      var URL = '<?php echo base_url(); ?>';
    </script>
    <!-- <input type="hidden" id="type_pos" value="<?php //echo $type; ?>"> -->

      <div class="row">
        <div class="col-md-12">
          <div id="table-wrapper">

              <center>
                <h2>LIST <?php echo $page_title; ?></h2>
                <hr style="border-top: 3px double #8c8b8b;">
                <?php //$this->load->view('tpl_form_message'); ?>
              </center>

              <br>
              <!-- <a href="<?php //echo base_url('kategori/add'); ?>" class="btn btn-info pull-right"><i class="fa fa-plus"></i> ADD KATEGORI</a> -->
              <button type="button" id="add_service" onclick="location.href = '<?php echo base_url(); ?>'+'service/view_add'" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>
                Service Barang
              </button>&nbsp;
              <button type="button" id="add_service" onclick="add_vendor()" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>
                Vendor
              </button>

              <br><br>
              <table id="tb_service" class="table table-bordered table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th class="" style="background-color: #4F81BD; color: white;">NO.</th>
                  <th class="" style="background-color: #4F81BD; color: white;">JUDUL</th>
                  <th class="" style="background-color: #4F81BD; color: white;">NAMA VENDOR SERVICE</th>
                  <th class="" style="background-color: #4F81BD; color: white;">TANGGAL SERVICE</th>
                  <th class="" style="background-color: #4F81BD; color: white;">ESTIMASI SELESAI</th>
                  <th class="" style="background-color: #4F81BD; color: white;">DETAIL SERVICE</th>
                  <th class="" style="background-color: #4F81BD; color: white;">UPDATE DATE</th>
                  <th class="" style="background-color: #4F81BD; color: white;">UPDATE BY</th>
                  <th class="" style="background-color: #4F81BD; color: white; width: 10%;">ACTION</th>
                </tr>
                </thead>
                <tbody>
                  
                    <?php $no = 1; ?>
                    <?php if(!empty($tb_service) && $tb_service !== NULL){ ?>
                      <?php foreach ($tb_service as $key => $tb) { ?>
                          <tr>
                            <input type="hidden" name="id" value="<?php echo $tb->S_ID; ?>" />
                            <td><?php echo $no; ?></td>
                            <td><?php echo $tb->judul; ?></td>
                            <td><?php echo $tb->nama_vendor; ?></td>
                            <td><?php echo $tb->tanggal_service; ?></td>
                            <td><?php echo $tb->estimasi_selesai; ?></td>
                            <td><?php echo $tb->detail_service; ?></td>
                            <td><?php echo $tb->service_update_date; ?></td>
                            <td><?php echo $tb->service_update_by; ?></td>
                            <td>
                              <?php if($tb->status_service==0){ ?>
                                  <!-- <button onclick="status_done(<?php
                                       echo $tb->S_ID; ?>,<?php echo $tb->jml_barang; ?>,<?php echo $tb->id_item; ?>)" class="btn bg-green btn-xs" title="Ubah Status Service">
                                    <span class="glyphicon glyphicon-check"></span>
                                  </button> -->
                              
                                  <!-- <button value="<?php
                                       echo $tb->S_ID.'|'.
                                       $tb->ID_ITEM .'|'.
                                       $tb->nama_vendor .'|'.
                                       $tb->tanggal_service .'|'.
                                       $tb->estimasi_selesai .'|'.
                                       $tb->detail_service .'|'.
                                       $tb->jml_barang .'|'.
                                       $tb->service_update_date .'|'.
                                       $tb->service_update_by;
                                  ?>" class="btn btn-warning btn-xs" title="Edit" 
                                    onclick="ae_service('edit',$(this))">
                                    <span class="glyphicon glyphicon-edit"></span>
                                  </button> -->
                                  <button class="btn btn-warning" onclick="location.href='<?php echo base_url('service/view_edit').'?id='.$tb->id; ?>'"><span class="glyphicon glyphicon-edit"></span></button>
                              <?php } ?>
                              <button onclick="del(<?php
                                   echo $tb->S_ID; ?>)" class="btn btn-danger btn-xs" title="Delete">
                                <span class="glyphicon glyphicon-trash"></span>
                              </button>
                            </td>
                          </tr>
                          <?php $no++; ?>
                      <?php } ?>
                    <?php } ?>
                  
                </tbody>
              </table>
              <?php echo '<input type="hidden" class="cKat" value="'. $no .'">'; ?>
          </div>
        </div>
      </div>

      <!-- <div class="modal modal-success fade" id="add-kategori" style="display: none;">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add Kategori</h4>
              </div>
              <div class="modal-body">
                <input type="hidden" id="id_kat" name="id" value=""/>
                <div class="row">
                  <label for="code" class="col-sm-4 control-label">Code <span class="asterisk">*</span></label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="code" name="code" placeholder="" value="">
                  </div>
                </div>  
                <br>
                <div class="row">
                  <label for="name_txt" class="col-sm-4 control-label">Name <span class="asterisk">*</span></label>

                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="name_txt" name="name_txt" placeholder="" value="">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" id="save" class="btn btn-outline">Save</button>
              </div>
            </div>

          </div>

        </div> -->

    <!-- /.content -->

    <div id="items" style="display: none;">
        <?php foreach ($items as $key => $value) { ?>
            <option value='<?php echo $value->ID_ITEM; ?>'><?php echo $value->nama_item?></option>
        <? } ?>
    </div>
<?php } ?>




<?php if($mode=='add'||$mode=='edit'){ ?>

    <script type="text/javascript">
        var produk = [];

            <?php if(!empty($items)){ ?>
              <?php foreach ($items as $key => $value) { ?>
                  produk.push({
                    id:<?php echo $value->ID_ITEM; ?>,
                    name:"<?php echo $value->nama_item; ?>"
                  });
              <? } ?>
            <?php } ?>
    </script>

    <?php 
        // $stat = $p_value->status;
        function status_item($s){
            if($s==0){
                return "<center><strong class='status_it' style='color:black'>Service</strong></center>";
            }
            if($s==1){
                return "<center><strong class='status_it' style='color:blue'>Done</strong></center>";
            }
            if($s==2){
                return "<center><strong class='status_it' style='color:red'>Fail</strong></center>";
            }
        }

        function status_btn($s){
            if($s==1){
                return "disabled='disabled'";
            }
        }
    ?>

    <div class="col-lg-12">
        <center><h2>Tambah Barang Service</h2></center>
        <hr style="border: 1pt black solid">
        
        <div class="panel panel-default">
            <div class="panel-heading bg-blue clearfix">Detail</div>
            <div class="panel-body clearfix">
                <form id="detail_service">
                    <div class="row">
                      <div class="col-lg-6 form-group">
                          <label>Judul</label>
                          <input type="text" name="judul" class="form-control" placeholder="Isikan Judul Service" value="<?php echo $mode=='edit'?$tb_service[0]->judul:''; ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6 form-group">
                          <label>Pilih Vendor</label>
                          <select class="form-control select2" id="sel_barang" name="id_vendor">
                            <?php if(!empty($vendor)){ ?>
                              <?php foreach ($vendor as $key => $value) { ?>
                                  <option <?php echo (!empty($tb_service[0]->id_vendor)&&$mode=='edit'&&$tb_service[0]->id_vendor==$value->id)?'selected="selected"':''; ?> value='<?php echo $value->id; ?>'><?php echo $value->nama_vendor?></option>
                              <? } ?>
                            <?php } ?>
                          </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6 form-group">
                          <label>Tanggal Service</label>
                          <input type="date" name="tanggal_service" class="form-control" value="<?php echo $mode=='edit'?$tb_service[0]->tanggal_service:''; ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6 form-group">
                          <label>Estimasi Selesai</label>
                          <input type="date" name="estimasi_selesai" class="form-control" value="<?php echo $mode=='edit'?$tb_service[0]->estimasi_selesai:''; ?>">
                      </div>
                    </div>
                </form>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12 form-group">
                <div class="panel panel-default">
                  <div class="panel-heading bg-blue clearfix"><strong>List Item</strong><button onclick="add_prod($(this),'<?php echo $mode; ?>')" class="btn btn-success pull-right"><span class="fa fa-plus"></span>&nbsp; Tambah Produk</button></div>
                  <div class="list-group" id="list-barang">
                  <!-- ////////////////////////  LIST BARANG //////////////////////////////////// -->
                    <?php if($mode=='edit'){ ?>
                      <?php foreach ($produk as $p_key => $p_value) { ?>
                          <a class="list-group-item clearfix item_list from_server ada">
                            <input type="hidden" name="id" value="<?php echo $p_value->id; ?>">
                            <div class="col-lg-4 clearfix">
                              <div class="row">
                                  <div class="col-lg-12 form-group">
                                      <select disabled="disabled" class="form-control produk_barang" name="id_item">
                                          <?php foreach ($items as $i_key => $i_value) { ?>
                                              <option <?php echo (!empty($p_value->id_item)&&$mode=='edit'&&$p_value->id_item==$i_value->ID_ITEM)?'selected="selected"':''; ?> value=<?php echo $i_value->ID_ITEM; ?>><?php echo $i_value->nama_item; ?></option>
                                          <?php } ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-lg-12 form-group">
                                      <input type="text" name="serial_number" class="form-control" placeholder="Input Serial Number" value="<?php echo $p_value->serial_number?>">
                                  </div>
                              </div>
                            </div>

                            <div class="col-lg-7 clearfix">
                              <div class="row">
                                <div class="col-lg-12 form-group">
                                    <textarea name="remark" rows="3" class="form-control" placeholder="Input Keterangan"><?php echo $p_value->remark?></textarea>
                                </div>
                              </div>
                            </div>

                            
                            <div class="col-lg-1 clearfix">
                              <div class="row">
                                <div class="col-lg-12 form-group">
                                    <button <?php echo status_btn($p_value->status); ?> title="Change Status" class="btn btn-info btn-lg btn-block" onclick="del_item($(this),'<?php echo $mode; ?>','acc')"><span class="fa fa-gear"></span></button>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12 form-group">
                                    <?php echo status_item($p_value->status); ?>
                                </div>
                              </div>
                            </div>
                          </a>
                      <?php } ?>
                    <?php } ?>
                      <!-- //////////////////////////    END LIST BARANG   //////////////////////////////////-->
                  </div>
                  <div class="panel-footer panel-default clearfix">
                    <?php if($mode=='add'){ ?>
                      <button onclick="submit_services()" class="btn btn-success btn-md pull-right"><span class="fa fa-check"></span>&nbsp;SUBMIT</button>
                    <?php } ?>
                    <?php if($mode=='edit'){ ?>
                      <button onclick="submit_edit_services(<?php echo $_GET['id']; ?>)" class="btn btn-success btn-md pull-right"><span class="fa fa-check"></span>&nbsp;SUBMIT</button>
                    <?php } ?>
                  </div>
                </div>
            </div>
        </div>
        
    </div>
<?php } ?>


<style type="text/css">
  .hapus{
    display: none;
  }
</style>


<!-- //////////////// Modal Alert /////////////////// -->
<div style="display: none">
    <div id="add_vendor">
        <div class="col-lg-12 form-group">
          <label>Nama Vendor</label>
          <input type="text" name="nama_vendor" class="form-control" placeholder="Masukkan Nama Vendor">
        </div>
        <div class="col-lg-12 form-group">
          <label>Alamat Vendor</label>
          <textarea name="alamat_vendor" class="form-control" placeholder="Masukkan Alamat Vendor"></textarea>
        </div>
        <div class="col-lg-12 form-group">
          <label>PIC</label>
          <input type="text" name="pic" class="form-control" placeholder="Masukkan PIC">
        </div>
        <div class="col-lg-12 form-group">
          <label>No. Telp</label>
          <input type="number" name="no_telp" class="form-control" placeholder="Masukkan Nomor Telp Vendor">
        </div>
        <div class="col-lg-12 form-group">
          <label>No. HP</label>
          <input type="number" name="no_hp" class="form-control" placeholder="Masukkan Nomor HP Vendor">
        </div>
    </div>


</div>