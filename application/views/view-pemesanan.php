  <script >
    var URL = '<?php echo base_url(); ?>';
    var arr_cs = [];
    var m = '<?php echo $mode; ?>';
    var jenis = '<?php echo $s_active; ?>';
    var redirect = '';
    if(jenis=='pemesanan'){
        redirect = 'transaksi/pemesanan/view';
    }
    if(jenis=='penawaran'){
        redirect = 'transaksi/pemesanan/view_penawaran';
    }
    // alert('');
  </script>


  <div class="row">
    <div class="col-md-12 ">
      <div id="table-wrapper">
          <center>
            <h2><?php echo $page_title; ?></h2>
            <hr style="border-top: 3px double #8c8b8b;">
          </center>     

          <?php if($mode=='view'){ ?>
            <?php if($user=='Super Admin'||$user=='Kepala Divisi'||$user=='Admin'||$user=='Karyawan'){ ?>
              <?php if($act_button=='pemesanan'){ ?>
                  <a href="<?php echo base_url('transaksi/pemesanan/add?type=pemesanan'); ?>">
                    <button type="button" class="btn btn-success">
                      <span class="glyphicon glyphicon-plus"></span> Tambah Pemesanan
                    </button>
                  </a>

                  <button class="btn btn-primary pull-right">aa</button>
                  <br><br> 
              <?php } ?>

              <?php if($act_button=='penawaran'){ ?>
                  <a href="<?php echo base_url('transaksi/pemesanan/add?type=penawaran'); ?>">
                    <button type="button" class="btn btn-success">
                      <span class="glyphicon glyphicon-plus"></span> Tambah Penawaran
                    </button>
                  </a>
                  <br><br> 
              <?php } ?>
            <?php } ?> 
            
              <table id="tb_pemesanan" class="table table-bordered table-striped table-hover dt-responsive" cellspacing="0" width="100%" style="font-size: small;">
                <thead>
                <tr>
                  <th class="" style="background-color: #4F81BD; color: white; ">NO.</th>
                  <th class="" style="background-color: #4F81BD; color: white; ">JENIS</th>
                  <th class="" style="background-color: #4F81BD; color: white; ">NO. PEMESANAN</th>
                  <th class="" style="background-color: #4F81BD; color: white; ">NAMA PEMESAN</th>
                  <!-- <th class="" style="background-color: #4F81BD; color: white; ">DURASI</th> -->
                  <th class="" style="background-color: #4F81BD; color: white; ">JML ITEM</th>
                  <th class="" style="background-color: #4F81BD; color: white; ">TGL PEMESANAN</th>
                  <?php if($act_button=='pemesanan'){ ?>
                      <th class="" style="background-color: #4F81BD; color: white; width:13%;">CREW</th>
                  <?php } ?>

                  <th class="" style="background-color: #4F81BD; color: white; "><?php echo $act_button=='pemesanan'? 'STATUS':'RESUME DEALING'; ?></th>

                  <?php if($act_button=='pemesanan'){ ?>
                      <th class="" style="background-color: #4F81BD; color: white; ">RATING</th>
                      <th class="" style="background-color: #4F81BD; color: white; ">LOADING STATUS</th>
                  <?php } ?>
                  
                  <th class="" style="background-color: #4F81BD; color: white; width: 17%">ACTION</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                    
                    if(!empty($tb_pemesanan)||$tb_pemesanan!=null){ ?>
                      
                      <?php $no=1; foreach ($tb_pemesanan as $key => $value) { ?>

                        <script>arr_cs.push({"id":"<?php echo $value->id_pemesanan; ?>","status":"<?php echo $value->status; ?>"})</script>
                        <?php if($act_button=='pemesanan'){ ?>
                            <?php 
                              $s = $value->status; 
                              $c = $stat_pemesanan[$s]['color'];
                              $st = $stat_pemesanan[$s]['status'];
                              $id_pem = $value->id_pemesanan;
                            ?>

                            <tr class="id-<?php echo $value->id_pemesanan; ?>">
                              <td><?php echo $no; ?></td>
                              <td><?php echo ucfirst($value->jenis); ?></td>
                              <td><?php echo $value->no_pemesanan; ?></td>
                              <td><?php echo $value->pemesan; ?></td>
                              <!-- <td><?php echo $value->duration; ?> Hari</td> -->
                              <td><?php echo $value->jml_item; ?></td>
                              <td><?php echo $value->tgl_pemesanan; ?></td>
                              <td >
                                  <button title="List Crew" class="btn btn-xs bg-default" value="<?php echo $value->crew_txt; ?>" onclick="$.alert($(this).val())">
                                      <span class="glyphicon glyphicon-search"></span>
                                  </button>

                                  <?php if($s>=1){ ?>
                                    <button title="Change Crew" class="btn btn-xs bg-purple" value="<?php echo $value->crew_txt; ?>" onclick="add_crew(null,<?php echo $id_pem; ?>)">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </button>

                                    <button title="Change Driver" class="btn btn-xs bg-yellow" value="<?php echo $value->crew_txt; ?>" onclick="add_driver(null,<?php echo $id_pem; ?>)">
                                        <span class="fa fa-car"></span>
                                    </button>

                                    <button title="Armada" class="btn btn-xs bg-green" onclick="armada(<?php echo $id_pem; ?>)">
                                        <span class="fa fa-car"></span>
                                    </button>
                                  <?php } ?>
                              </td>
                              <td>
                                <button onclick="ck_status(<?php echo $id_pem; ?>)" data-toggle="tooltip" data-html="true" title="<b>Status : <?php echo $st; ?></b> <br> Klik untuk melihat Detail Status" class="btn btn-xs <?php echo $c; ?>" style="width: 100%; white-space: pre-line;"><?php echo $st; ?></button>
                              </td>
                              <td><?php echo $value->rating; ?></td>
                              <td>
                                  <?php 
                                      if($value->loading_status==1){ ?>
                                        <b class="blink">IS OUT</b>
                                      <?php }
                                  ?>
                              </td>
                              <td>
                                <?php include('view-pemesanan_btn_act.php'); ?>
                              </td>
                            </tr>
                        <?php } ?>

                        <?php if($act_button=='penawaran'){ ?>
                        
                            <?php if($value->jenis=='penawaran'){ ?>
                                <?php 
                                  $s = $value->status; 
                                  $c = $stat_pemesanan[$s]['color'];
                                  $st = $stat_pemesanan[$s]['status'];
                                  $id_pem = $value->id_pemesanan;
                                ?>
                            <?php } ?>

                            <tr class="id-<?php echo $value->id_pemesanan; ?>">
                              <td><?php echo $no; ?></td>
                              <td><?php echo ucfirst($value->jenis); ?></td>
                              <td><?php echo $value->no_pemesanan; ?></td>
                              <td><?php echo $value->pemesan; ?></td>
                              <!-- <td><?php echo $value->duration; ?> Hari</td> -->
                              <td><?php echo $value->jml_item; ?></td>
                              <td><?php echo $value->tgl_pemesanan; ?></td>
                              <?php if($value->jenis=='penawaran'){ ?>
                                <td>
                                  <button onclick="ck_status(<?php echo $id_pem; ?>)" data-toggle="tooltip" data-html="true" title="<b>Status : <?php echo $st; ?></b> <br> Klik untuk melihat Detail Status" class="btn btn-xs <?php echo $c; ?>" style="width: 100%; white-space: pre-line;"><?php echo $st; ?></button>
                                </td>
                                <td>
                                  <?php include('view-pemesanan_btn_act.php'); ?>
                                </td>
                              <?php } ?>
                              <?php if($value->jenis=='pemesanan'){ ?>
                                <td>
                                  <button class="btn btn-xs btn-success" style="width: 100%; white-space: pre-line;">Done - In Production</button>
                                </td>
                                <td>
                                  
                                </td>
                              <?php } ?>
                              
                              
                            </tr>
                        <?php } ?>

                      <?php $no++; } ?>
                  <?php  } 
                  ?>
                  
                </tbody>
              </table>
          <?php } ?>
          

          <?php if($mode=='add' || $mode == 'edit'){ ?> 
            <script type="text/javascript">

              var arr_it = <?php echo json_encode($it_bc); ?>;
              var m = '<?php echo $mode; ?>';
              var is_nego = <?php echo !empty($_GET['nego']) ? ($_GET['nego']=='nego'? 1:0):0; ?>;
              //alert(arr_it[0].barcode);
            </script>

            <?php 
                function nego(){
                    if(!empty($_GET['nego'])){
                        if($_GET['nego'] == "nego"){
                            return "disabled='disabled'";
                        }else{
                            return null;
                        }
                    }
                }

                function btn_edit_nego(){
                    if(!empty($_GET['nego'])){
                        if($_GET['nego'] == "nego"){
                            return ' style="display:inline-block" onclick="edit_harga_nego($(this))" ';
                        }else{
                            return ' style="display:none" ';
                        }
                    }else{
                        return ' style="display:none" ';
                    }
                }

            ?>
            <div class="row">
              <div class="col-lg-12 col-xs-12">
                <form class="col-xs-12">
                  <div class="row">
                    <div class="panel-group col-md-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">Rincian</div>

                            <div class="panel-body">
                                <div class="form-group col-lg-12">
                                    <label>Tanggal Acara</label>
                                    <input type="text" name="tanggal_acara" class="dt_picker form-control" placeholder="Masukkan tanggal acara" value="<?php echo !empty($tb_pemesanan) ? $tb_pemesanan[0]->tanggal_acara:''; ?>">
                                </div>
                                <div class="form-group col-xs-12">
                                      <label for="judul_pemesanan">Select Customer</label><br>
                                      <select <?php echo nego(); ?> id="list_customer" class="sel2 act w-10" onchange="select_customer($(this))">
                                        <option selected="selected" disabled="disabled">-- Select Customer --</option>
                                        <?php foreach ($list_customer as $key => $value){ ?>
                                            <option value="<?php echo $value->id; ?>"
                                              <?php echo ($mode=='edit'&&$tb_pemesanan[0]->id_pemesan==$value->id) ? 'selected=selected':''; ?>>
                                              <?php echo $value->name; ?>
                                            
                                            </option>
                                        <?php } ?>
                                      </select>
                                </div>

                                <div class="form-group col-xs-12">
                                    <div id="user_info">
                                      
                                    </div>
                                    <center class="loading-user" style="display: none;">
                                        <div style='width:100px; height: 100px; background-size: cover; background-image: url("http://localhost/thunder_indonesia/assets/dist/img/loading_mini.gif");'></div>
                                    </center>
                                </div>
                                
                            </div>
                            <div class="panel-footer">
                                
                            </div>
                        </div>
                    </div>
                    <div class="panel-group col-md-7">
                        <div class="panel panel-success">
                            <div class="panel-heading">Rincian Acara</div>

                            <div class="panel-body frm-rincian_acara">
                                <div class="row col-md-12" id="ls_tanggal_acara">
                                    <div class="row col-md-12">
                                        <div class="form-group col-lg-5">
                                            <label>Tanggal Acara :</label>
                                            <div class="input-group">
                                                <input name="tanggal_acara_awal" type="text" class="form-control dtpicker_acara form-control" value="">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-5">
                                            <label>Sampai dengan :</label>
                                            <div class="input-group">
                                                <input name="tanggal_acara_akhir" type="text" class="form-control dtpicker_acara form-control" value="">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-2">
                                            <label>Action</label>
                                            <div class="btn btn-primary" onclick="add_date($(this))"><span class="fa fa-check"></span> Add to List</div>
                                        </div>
                                    </div>
                                    <div class="row col-md-12" >
                                        <table class="table table-bordered" id="tb_ls_tanggal">
                                          <thead>
                                            <tr>
                                              <td>Tanggal Awal</td>
                                              <td>Tanggal Akhir</td>
                                              <td>Action</td>
                                            </tr>
                                          </thead>
                                          <tbody>
                                              <?php if(!empty($ls_tgl_acara)){ ?>
                                                  <?php foreach ($ls_tgl_acara as $key => $value) { ?>
                                                    <tr class="server">
                                                      <td><?php echo date('Y-m-d', strtotime($value->tanggal_awal)); ?></td>
                                                      <td><?php echo date('Y-m-d', strtotime($value->tanggal_akhir)); ?></td>
                                                      <td><button class="btn btn-danger" onclick="del_date($(this),'server',<?php echo $value->id; ?>)"><span class="fa fa-trash"></span></button></td>
                                                    </tr>
                                                  <?php } ?>
                                              <?php } ?>
                                          </tbody>
                                        </table>
                                    </div>
                                </div>
                                

                                <div class="form-group col-lg-12">
                                    <label>Nama Event</label>
                                    <input name="nama_event" type="text" class="form-control form-control" value="<?php echo !empty($tb_pemesanan) ? $tb_pemesanan[0]->nama_event:''; ?>">
                                </div>

                                <div class="form-group col-lg-12">
                                    <label>Alamat Venue</label>
                                    <textarea class="form-control" name="alamat_venue" placeholder="Masukkan Alamat Venue"><?php echo !empty($tb_pemesanan) ? $tb_pemesanan[0]->alamat_venue:''; ?></textarea>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Loading IN</label>
                                    <div class="input-group">
                                        <input name="loading_in" type="text" class="loading_in_out form-control" value="<?php echo !empty($tb_pemesanan) ? $tb_pemesanan[0]->loading_in:'09:00'; ?>">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>Loading OUT</label>
                                    <div class="input-group">
                                        <input name="loading_out" type="text" class="loading_in_out form-control" value="<?php echo !empty($tb_pemesanan) ? $tb_pemesanan[0]->loading_out:'09:00'; ?>">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>PIC</label>
                                    <input type="text" name="pic" class="form-control" placeholder="Masukkan Nama PIC" value="<?php echo !empty($tb_pemesanan) ? $tb_pemesanan[0]->pic:''; ?>">
                                </div>

                                <div class="form-group col-lg-6">
                                    <label>No HP PIC</label>
                                    <input type="number" name="no_hp_pic" class="form-control" placeholder="Masukkan No HP PIC" value="<?php echo !empty($tb_pemesanan) ? $tb_pemesanan[0]->no_hp_pic:''; ?>">
                                </div>
                                
                            </div>
                            <div class="panel-footer clearfix">
                                <!-- <div class="col-sm-12 simpan">
                                    <div class="btn btn-primary pull-right" onclick="save_detail_acara()">SUBMIT</div>
                                </div>
                                <div class="col-sm-12 edit" style="display: none;">
                                    <button class="btn btn-warning pull-right">EDIT</button>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    

                    <!-- <div class="panel-group col-md-7">
                        <div class="panel panel-default">
                            <div class="panel-heading">Customer Info</div>

                            <div class="panel-body">
                                <div class="form-group col-xs-12 col-md-2">

                                        <div class="form-group">
                                          <label for="extra">Duration (Day)</label>
                                          <input <?php echo nego(); ?> type="number" min="1" max="100" class="form-control" id="duration" placeholder="Masukkan Durasi" value="<?php echo !empty($tb_pemesanan[0])?$tb_pemesanan[0]->duration:''; ?>" req-s-pem> 
                                        </div>

                                </div>
                            </div>
                            <div class="panel-footer">
                                
                            </div>
                        </div>
                    </div> -->
                  </div>
                  <br>
                  <div class="row">
                      <div class="panel-group">
                        <div class="panel panel-default">
                          <div class="panel-heading">List Item  <i class="pull-right">Nomor Order : <b id="no_pemesanan"><?php echo !empty($tb_pemesanan) ? $tb_pemesanan[0]->no_pemesanan:'P-'.time().'-'.date('Y'); ?></b></i></div>
                          <div class="panel-body">
                            <?php if(1+1==1){ ?>
                              <div class="row">
                                <div class="pad-s col-xs-12 col-md-5">
                                  <div class="form-group">
                                    <label for="item_select">Select Item *</label>
                                    <div class="input-group" style="width:100%;">
                                      
                                      <!-- <select <?php echo nego(); ?> class="select2 act" id="item_select" onchange="ch_select($(this).val())">
                                        <?php if(!array_key_exists('status', $items)){?>
                                            <?php foreach ($items as $key => $value) { ?>
                                              <?php 
                                                $val =  $value->ID_ITEM . '|' .
                                                        $value->barcode . '|' .
                                                        $value->nama_item . '|' .
                                                        $value->qty.'|'.
                                                        $value->jenis_item.'|'.
                                                        $value->harga_jual.'|'.$value->is_external;
                                              ?>
                                              <option value="<?php echo $val; ?>"><?php echo $value->nama_item . ' - ' . $value->barcode; ?></option>
                                          <?php } ?>
                                        <?php } ?>
                                      </select> -->
                                    </div>
                                  </div>
                                </div>
                                <div class="col-xs-12 col-md-2">
                                  <div class="form-group">
                                    <!-- <label for="bc">Item tidak ada?</label>
                                    <button class="btn btn-success form-control" onclick="make_new_item(event)"><span class="fa fa-plus"></span>&nbsp;(Group)</button> -->

                                  </div>
                                </div>
                                <div class="col-xs-12 col-md-3">
                                  <div class="form-group">
                                    <label for="bc">Barcode <input <?php echo nego(); ?> type="checkbox" onclick="autoenter()" id="auto_enter" name="" style="margin-top: 0px;"><i>Auto Enter</i></label>

                                    <!-- <input <?php echo nego(); ?> type="number" min="1" class="form-control" id="bc" placeholder="Input Barcode"> -->
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-xs-12 col-md-2">
                                  <div class="form-group">
                                    <label for="disc">Disc (%)</label>
                                    <!-- <input <?php echo nego(); ?> type="number" min="1" max="100" class="form-control" id="disc" placeholder="Disc" value="0"> -->
                                  </div>
                                </div>
                                <div class="col-xs-12 col-md-2">
                                  <div class="form-group">
                                    <label for="item_select">Extra Charge</label>
                                    <div class="input-group" style="width:100%;">
                                      
                                      <!-- <select <?php echo nego(); ?> id="extra" class="form-control">
                                        <option value="0" selected="selected">0 % - Default</option>
                                        <?php if(!empty($extra)){?>
                                          <?php foreach ($extra as $key => $value) { ?>
                                              <option value="<?php echo $value->charge; ?>"><?php echo $value->charge . '% - ' . $value->code; ?></option>
                                          <?php } ?>
                                        <?php } ?>
                                      </select> -->
                                    </div>
                                  </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                  <div class="form-group">
                                    <label for="item_select">Durasi</label>
                                    <div class="input-group" style="width:100%;">
                                      
                                      <!-- <select <?php echo nego(); ?> class="form-control" id="sel_durasi" >
                                          
                                      </select> -->
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="col-xs-12 col-md-2">
                                  <div class="form-group">
                                    <label for="qty">Jumlah *</label>
                                    <!-- <input <?php echo nego(); ?> onkeydown="enter(event)" type="number" min="1" class="form-control" id="qty" req-add-item placeholder="Qty"> -->
                                  </div>
                                </div>
                                <div class="col-xs-12 col-md-2">
                                  <div class="form-group">
                                    <label for="">ACT</label><br>
                                    <!-- <button <?php echo nego(); ?> id="btn_add" onclick="add_item(); " type="button" class="btn btn-success btn-sm col-xs-12" data-toggle="tooltip" title="Add Item"><span class="glyphicon glyphicon-plus"></span></button> -->
                                  </div>
                                </div>
                              </div>
                            <?php } ?>
                              <br>
                              <div class="row">
                                <div class="col-xs-12" style="overflow-x: auto;">
                                  <div clas="table-responsive">
                                    <?php if($mode=='edit'){ ?>
                                        <input type="hidden" class="id_pemesanan" value="<?php echo $id; ?>">
                                    <?php }?>
                                    <table id="tb_item_pemesanan" class="table table-bordered table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                                        <thead>
                                          <tr style="background-color: #4F81BD; color: white;">
                                            <th>No</th>
                                            <th>Barcode</th>
                                            <th>Nama Barang</th>
                                            <th>Jenis</th>
                                            <th>Stock</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Disc(%)</th>
                                            <th>Extra Charge(%)</th>
                                            <th>Durasi</th>
                                            <th>Nett</th>
                                            <th class="all">Action</th>
                                            <th style="display: none"></th>
                                            <th style="display: none"></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php if($mode=='edit'){ ?>
                                            
                                            
                                            <?php if(!empty($list)){ ?>
                                              
                                              
                                              <?php $no=1; foreach($list as $key => $value) { ?>
                                                
                                                <tr>
                                                  <input type="hidden" class="id_item" value="<?php echo $value->ID_ITEM; ?>">
                                                  <input type="hidden" class="id_it_pemesanan" value="<?php echo $value->ID_IT_PEMESANAN; ?>">
                                                  <td><p class="no_item"><?php echo $no; ?></p></td>
                                                  <td><?php echo $value->barcode; ?></td>
                                                  <td><?php echo $value->item_name; ?></td>
                                                  <td><?php echo $value->jenis_item; ?></td>
                                                  <td width="100px"><?php echo $value->i_qty; ?></td>
                                                  <td><?php echo $value->qty; ?></td>
                                                  <td><?php echo number_format($value->harga,0,",","."); ?></td>
                                                  <td><?php echo number_format($value->total,0,",","."); ?></td>
                                                  <td width="75px;"><?php echo $value->disc; ?></td>
                                                  <td><?php echo $value->extra_charge; ?></td>
                                                  <td><?php echo $value->name_durasi; ?></td>
                                                  <td title="<?php echo 'Harga Asli : '.number_format($value->total_all,0,",","."); ?>" style="width: 150px;" class="net" data-net="<?php echo $value->total_harga; ?>"><?php echo number_format($value->total_harga,0,",","."); ?></td>

                                                  <td style="width: 100px;" class="btn-nego">
                                                    <button <?php echo btn_edit_nego(); ?> type="button" class="btn-edit-nego btn btn-warning btn-sm" data-toggle="tooltip" title="Edit Harga (Harga Asli : <?php echo number_format($value->total_all,0,",","."); ?>)">
                                                      <span class="glyphicon glyphicon-edit"></span>
                                                    </button>
                                                    <button <?php echo nego(); ?> onclick="del_ip(<?php echo $value->ID_IT_PEMESANAN; ?>,$(this))" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete Item">
                                                      <span class="glyphicon glyphicon-trash"></span>
                                                    </button>
                                                  </td>
                                                  <td style="display: none"></td>
                                                  <td style="display: none"></td>
                                                </tr>
                                              <?php $no++; } ?>
                                            <?php }?>
                                          <?php }?>
                                          
                                        </tbody>
                                        <tfoot style="font-size:11px;">
                                          <tr style="background-color: grey; color: white;">
                                            <td>
                                            	<input type="checkbox" value="false">&nbsp;
                                            </td>

                                            <td colspan="2">
                                              
                                              <select <?php echo nego(); ?> style="width:100%;" class="select2 act" id="item_select" onchange="ch_select($(this).val())">
                                                <?php if(!array_key_exists('status', $items)){?>
                                                    <?php foreach ($items as $key => $value) { ?>
                                                      <?php 
                                                        $val =  $value->ID_ITEM . '|' .
                                                                $value->barcode . '|' .
                                                                $value->nama_item . '|' .
                                                                $value->qty.'|'.
                                                                $value->jenis_item.'|'.
                                                                $value->harga_jual.'|'.$value->is_external;
                                                      ?>
                                                      <option value="<?php echo $val; ?>"><?php echo $value->nama_item . ' - ' . $value->barcode; ?></option>
                                                  <?php } ?>
                                                <?php } ?>
                                              </select>
                                            </td>
                                            <td>
                                                <button class="btn btn-success form-control btn-xs" onclick="make_new_item(event)">Item tidak ada?</button></td>
                                            <td></td>
                                            <td width="100px">
                                                <input style="width: 70px;" <?php echo nego(); ?> onkeydown="enter(event)" type="number" min="1" class="form-control" id="qty" req-add-item placeholder="Qty">
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td >
                                                <input <?php echo nego(); ?> type="number" min="1" max="100" class="form-control" id="disc" placeholder="Disc" value="0" style="width: 75px;">
                                            </td>
                                            <td>
                                                <select <?php echo nego(); ?> id="extra" class="form-control">
                                                  <option value="0" selected="selected">0 % - Default</option>
                                                  <?php if(!empty($extra)){?>
                                                    <?php foreach ($extra as $key => $value) { ?>
                                                        <option value="<?php echo $value->charge; ?>"><?php echo $value->charge . '% - ' . $value->code; ?></option>
                                                    <?php } ?>
                                                  <?php } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select style="width:100%;" <?php echo nego(); ?> class="form-control" id="sel_durasi" ></select>
                                            </td>
                                            <td>
                                                
                                            </td>
                                            <td class="all">
                                                <button <?php echo nego(); ?> id="btn_add" onclick="add_item(); " type="button" class="btn btn-success btn-sm col-xs-12" data-toggle="tooltip" title="Add Item"><span class="glyphicon glyphicon-plus"></span></button>
                                            </td>
                                            <td style="display: none"></td>
                                            <td style="display: none"></td>
                                          </tr>

                                          
                                        </tfoot>
                                    </table>
                                  </div>
                                </div>
                              </div>
                          </div>
                          <div class="panel panel-footer">                        
                            <div class="row">
                              <div class="col-xs-12">
                                <div onclick="submit('<?php echo $mode; ?>','<?php echo !empty($_GET['type']) ? $_GET['type']:''; ?>')" class="btn btn-success btn-sm pull-right">
                                    <span class="glyphicon glyphicon-plus"></span> SUBMIT
                                </div>
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
<div id="modal_view_pemesanan" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title judul_pemesanan">PEMESANAN</h4>
      </div>
      <div class="modal-body">
          
          <label>Nomor Pemesanan : <i class="no_pemesanan"></i></label>
          <br>
          <label>Tanggal Pemesanan : <i class="tgl_pemesanan"></i></label>
          <br><br>

          <div class="col-md-4">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Informasi Pemesan
                </div>
                <div class="panel-body">
                  <label>Pemesan </i></label><br>
                  <label style="font-weight: normal;">Nama Pemesan : <i style="font-weight: bold; color: blue;" class="nm_pemesan"></i></label>
                  <br>

                  <label style="font-weight: normal;">Group : <i style="font-weight: bold; color: blue;" class="v_group"></i></label>
                  <br>
                  <label style="font-weight: normal;">Lantai : <i style="font-weight: bold; color: blue;" class="v_lantai"></i></label>
                </div>
              </div>
          </div>

          <div class="col-md-8">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Informasi Acara
                </div>
                <div class="panel-body">
                    <label style="font-weight: normal;">PIC : <i style="font-weight: bold; color: blue;" class="pic"></i></label>
                    <br>
                    <label style="font-weight: normal;">Nama Event : <i style="font-weight: bold; color: blue;" class="nama_event"></i></label>
                    <br>
                    <label style="font-weight: normal;">Alamat Venue : <i style="font-weight: bold; color: blue;" class="alamat_venue"></i></label>
                    <br>
                    <label style="font-weight: normal;">Loading IN : <i style="font-weight: bold; color: blue;" class="loading_in"></i></label>
                    <br>
                    <label style="font-weight: normal;">Loading OUT : <i style="font-weight: bold; color: blue;" class="loading_out"></i></label>
                    <br>
                    <br>
                    <table class="table ls_tanggal_acara table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Tanggal Acara</th>
                          <th>Sampai Tanggal</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                </div>
              </div>
          </div>
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
                        <th>Out</th>
                        <th>In</th>
                        <!-- <th>Harga Satuan</th>
                        <th>Harga Total</th>
                        <th>Harga Akhir</th> -->

                      </tr>
                    </thead>
                    <tbody>
                      
                    </tbody>
                    <!-- <tfoot>
                      <tr class="bg-gray">
                        <td colspan="10" style="text-align: right"><b>Total Harga Akhir :</b></td>
                        <td style="color:blue" class="t_right"><b id="total_akhir"></b></td>
                      </tr>
                    </tfoot> -->
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

<div id="modal_view_kurir" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="" id="md_kurir_id_pemesanan">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- <ul id="popover-content" class="list-group" style="display: none;">
  <input type="hidden" name="id_pem" class="id_pem">
  <?php if(!empty($list_kurir)){ ?>
    <?php foreach ($list_kurir as $key => $list) { ?>
        <button class="bg-blue list-group-item">
          <b class="kurir_name"></b>
            <div class="checkbox">
              <label><input name="kurir_id" type="checkbox" value="<?php echo $list->id; ?>" style="vertical-align: top;"> <?php echo $list->name; ?></label>
            </div>
        </button>
    <?php } ?>
  <?php }else{ ?>
        <label>Kurir Kosong</label>
  <?php } ?>
  
     <button onclick="insert_kurir($(this).parent())" data-toggle="popover" type="button" class="btn btn-default" style="width: 100%; margin-top: 10px;">Submit</button>
  
</ul> -->

<ul id="popover-content" class="list-group" style="display: none;">
  <input type="hidden" name="id_pem" class="id_pem">
  <button onclick="add_driver($(this))" class="btn btn-primary">Driver</button>
  <button onclick="add_crew($(this))" class="btn btn-warning">Crew</button>
</ul>



<ul id="status_pop_content" class="list-group" style="display: none;">
  <input type="hidden" name="id_pem" class="id_pem">
  <?php foreach ($list_kurir as $key => $list) { ?>
      <a href="#" onclick="kurir_act($(this))" class="list-group-item"><input name="kurir_id" type="hidden" value="<?php echo $list->id; ?>"><b class="kurir_name"><?php echo $list->name; ?></b></a>
  <?php } ?>
</ul>

<?php if($mode=='view' && $act_button=='pemesanan'){ ?>
  <ul id="stat_pem_popover" class="dropdown-menu" style="display: none;">
    <input type="hidden" name="id_pem" class="id_pem">
    <button class="btn bg-aqua btn-block" type="button" onclick="adm_ch_stat(String($(this).parent().find('.id_pem').val()),String(3))">Prepare Item</button>
    <button class="btn btn-primary btn-block" type="button" onclick="adm_ch_stat(String($(this).parent().find('.id_pem').val()),String(4))">Courier On The Way</button>
    <button class="btn btn-success btn-block" type="button" onclick="adm_ch_stat(String($(this).parent().find('.id_pem').val()),String(5))">Done</button>
  </ul>
<?php } ?>

<?php if($mode=='view' && $act_button=='penawaran'){ ?>
  <ul id="stat_pem_popover" class="dropdown-menu" style="display: none;">
    <input type="hidden" name="id_pem" class="id_pem">
    <button id="act_1" class="btn bg-aqua btn-block" type="button" onclick="adm_ch_stat(String($(this).parent().find('.id_pem').val()),String(1))">Approve</button>
    <button id="act_2" class="btn bg-blue btn-block" type="button" onclick="adm_ch_stat(String($(this).parent().find('.id_pem').val()),String(2))">Negotiation</button>
    <button id="act_3" class="btn btn-success btn-block" type="button" onclick="adm_ch_stat(String($(this).parent().find('.id_pem').val()),String(3))">Done</button>
    <button id="act_4" class="btn btn-danger btn-block" type="button" onclick="adm_ch_stat(String($(this).parent().find('.id_pem').val()),String(4))">Decline</button>
  </ul>
<?php } ?>

<style type="text/css">
  .popover-content{
    max-height: 500px;
    overflow-x:overlay;
  }
</style>

  <style type="text/css">
    .select2-container--default .select2-selection--single{
      border-radius: 0px;
    }

  </style>

  <style type="text/css">
    * { box-sizing: border-box; }
body {
  font: 16px Arial; 
}
.autocomplete {
  /*the container must be positioned relative:*/
  position: relative;
  display: inline-block;
}
input[type=text][name=tanggal_acara] {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}
input[type=text][name=tanggal_acara] {
  background-color: #f1f1f1;
  width: 100%;
}
input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
}
.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9; 
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}


  </style>

<style>
    .blink {
      color: red;
      animation: blink-animation 1s steps(5, start) infinite;
      -webkit-animation: blink-animation 1s steps(5, start) infinite;
    }
    @keyframes blink-animation {
      to {
        visibility: hidden;
      }
    }
    @-webkit-keyframes blink-animation {
      to {
        visibility: hidden;
      }
    }
</style>











