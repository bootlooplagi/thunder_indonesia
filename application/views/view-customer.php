
    <!-- Content Header (Page header) -->
    <input type="hidden" id="BASE_URL" value="<?php echo base_url(); ?>">
    <!-- <input type="hidden" id="type_pos" value="<?php //echo $type; ?>"> -->
      <div class="row">
        <div class="col-md-12">
          <div id="table-wrapper">
              <center>
                <h2><?php echo $page_title; ?></h2>
                <hr style="border-top: 3px double #8c8b8b;">
                <?php //$this->load->view('tpl_form_message'); ?>
              </center>

              <br>

              <?php if($s_active=='user'){ ?>
                <button type="button" id="addRow" class="btn btn-success pull-right" data-toggle="modal" data-target="#add-customer"><span class="glyphicon glyphicon-plus"></span>
                  Tambah User
                </button>
              <?php } ?>

              <?php if($s_active=='customer'){ ?>
                <button onclick="add_customer()" class="btn bg-green pull-right"><span class="glyphicon glyphicon-plus"></span>
                  Tambah Customer
                </button>
              <?php } ?>

              
<!--               <button type="button" class="btn btn-success pull-right" data-toggle="popover"  data-title="Select Rule" data-placement="left" data-trigger="focus" onclick="select_rule($(this))"><span class="glyphicon glyphicon-plus"></span>
                Tambah User
              </button> -->
              <br><br>
              <table id="tblCustomer" class="table table-bordered table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                <thead>
                <?php if($s_active=='user'){ ?>
                  <tr>
                    <th class="" style="background-color: #4F81BD; color: white;">NO.</th>
                    <th class="" style="background-color: #4F81BD; color: white;">USERNAME</th>
                    <th class="" style="background-color: #4F81BD; color: white;">NAMA</th>
                    <th class="" style="background-color: #4F81BD; color: white;">EMAIL</th>
                    <th class="" style="background-color: #4F81BD; color: white;">RULES</th>
                    <th class="" style="background-color: #4F81BD; color: white;">GROUP</th>
                    <th class="" style="background-color: #4F81BD; color: white;">LANTAI</th>
                    <th class="" style="background-color: #4F81BD; color: white;">STATUS</th>
                    <th class="" style="background-color: #4F81BD; color: white;">ACTION</th>
                  </tr>
                <?php } ?>

                <?php if($s_active=='customer'){ ?>
                  <tr>
                    <th class="" style="background-color: #4F81BD; color: white;">NO.</th>
                    <th class="" style="background-color: #4F81BD; color: white; width: 20%;">NAMA</th>
                    <th class="" style="background-color: #4F81BD; color: white;">ALAMAT</th>
                    <!-- <th class="" style="background-color: #4F81BD; color: white;">NAMA PERUSAHAAN</th> -->
                    <th class="" style="background-color: #4F81BD; color: white;">KATEGORI PERUSAHAAN</th>
                    <!-- <th class="" style="background-color: #4F81BD; color: white;">PIC PERUSAHAAN</th> -->
                    <th class="" style="background-color: #4F81BD; color: white;">NO TELP KANTOR</th>
                    <th class="" style="background-color: #4F81BD; color: white;">FAX</th>
                    <th class="" style="background-color: #4F81BD; color: white;">NAMA PIC</th>
                    <th class="" style="background-color: #4F81BD; color: white;">NO TELP PIC</th>
                    <th class="" style="background-color: #4F81BD; color: white;">REMARK</th>
                    <th class="" style="background-color: #4F81BD; color: white; width: 10%;">ACTION</th>
                  </tr>
                <?php } ?>

                </thead>
                <tbody>
                  <?php 
                    $no = 1;
                    if(!empty($tb_customer) && $tb_customer !== NULL){
                      
                      if($s_active=='user'){
                        foreach ($tb_customer as $tb) {
                          echo '<tr>
                                <td>'.$no.'</td>
                               
                                <td>'.$tb->username.'</td>
                                <td>'.$tb->name.'</td>
                                <td>'.$tb->email.'</td>
                                <td>'.$tb->user_type.'</td>
                                
                               
                                <td>'.$tb->group.'</td>
                                <td>'.$tb->lantai.'</td>';

                                if($tb->is_active==1){
                                    echo '<td><p class="btn bt-sm btn-success btn-sm" data-toggle="tooltip" title="Status User : Active">Active</p></td>';
                                }
                                if($tb->is_active==0){
                                    echo '<td><p class="btn bt-sm btn-warning btn-sm" data-toggle="tooltip" title="Status User : Non Active">Non Active</p></td>';
                                }

                          echo 
                                '<!--<td>'.$tb->update_by_username.'</td>
                                <td>'.$tb->update_date.'</td>-->
                                
                                <td>';

                                if($tb->is_active==0){
                                  echo '<button data-toggle="tooltip" title="Activate User" class="btn btn-primary" onclick="activate('.$tb->id.')"><span class="glyphicon glyphicon-check"></span></button>';
                                }

                                if($s_active=='user'){
                                  echo '<button data-toggle="tooltip" title="Edit User" class="btn btn-warning" onclick="edit($(this),'. $tb->id .')" value="'
                                        .$tb->id.'|'
                                        .$tb->username.'|'
                                        .$tb->name.'|'
                                        .$tb->password.'|'
                                        .$tb->user_type.'|'
                                        .$tb->no_pegawai .'|'
                                        .$tb->department .'|'
                                        .$tb->jabatan . '|'
                                        .$tb->email . '|'
                                        .$tb->group . '|'
                                        .$tb->lantai.
                                        '"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button data-toggle="tooltip" title="Delete User" class="btn btn-danger" onclick="del('.$tb->id.',`user`)"><span class="glyphicon glyphicon-trash"></span></button>';
                                }



                          echo  '</td>
                              </tr>';
                          $no++;
                        }
                      }

                      if($s_active=='customer'){ 
                        foreach ($tb_customer as $key => $tb) { ?>
                          <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $tb->name; ?></td>
                            <td><?php echo $tb->address; ?></td>
                            <td><?php echo $tb->kategori_perusahaan; ?></td>
                            <td><?php echo $tb->no_telp_kantor; ?></td>
                            <td><?php echo $tb->fax; ?></td>
                            <td><?php echo $tb->nama_pic; ?></td>
                            <td><?php echo $tb->no_telp_pic; ?></td>
                            <td><?php echo $tb->remark; ?></td>
                            <td>
                              <!-- <button class="btn bg-aqua btn-xs">
                                  <span class="glyphicon glyphicon-fullscreen"></span>
                              </button> -->
                              <button onclick="edit_customer(
                                                                    '<?php echo $tb->name; ?>',
                                                                    '<?php echo $tb->address; ?>',
                                                                    '<?php echo $tb->email; ?>',
                                                                    '<?php echo $tb->id_user; ?>',
                                                                    '<?php echo $tb->nama_perusahaan; ?>',
                                                                    '<?php echo $tb->kategori_perusahaan; ?>',
                                                                    '<?php echo $tb->pic_perusahaan; ?>',
                                                                    '<?php echo $tb->no_telp_kantor; ?>',
                                                                    '<?php echo $tb->fax; ?>',
                                                                    '<?php echo $tb->attachment; ?>',
                                                                    '<?php echo $tb->nama_pic; ?>',
                                                                    '<?php echo $tb->no_telp_pic; ?>',
                                                                    '<?php echo $tb->remark; ?>',
                                                                    )" data-toggle="tooltip" title="Edit Customer" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit"></span></button>
                              <button data-toggle="tooltip" title="Delete Customer" class="btn btn-xs btn-danger" onclick="del(<?php echo $tb->id?>,'customer')"><span class="glyphicon glyphicon-trash"></span></button>
                            </td>
                          </tr>
                        <?php }
                       }                      
                    }

                  ?>
                </tbody>
              </table>
              <?php echo '<input type="hidden" class="cUser" value="'. $no .'">'; ?>
          </div>
        </div>
      </div>

      <div class="modal modal-success fade" id="add-customer" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add User</h4>
              </div>
              <div class="modal-body">
                <form id="frm-customer" autocomplete="off">
                  <input type="hidden" id="id_customer" name="id" value=""/>

                  <div class="pr v_username row" style="display: none">
                    <label for="u_username" class="col-sm-4 control-label">Username <span class="asterisk">*</span></label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="u_username" name="username" placeholder="Isikan Username" value="" required>
                    </div>
                  </div>  
                  

                  <div class="pr v_password row" style="display: none">
                    <label for="u_password" class="col-sm-4 control-label">Password <span class="asterisk">*</span></label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="u_password" name="password" placeholder="Isikan Password" value="" required>
                    </div>
                  </div>  
                  

                  <div class="pr v_nama row" style="display: none">
                    <label for="u_nama" class="col-sm-4 control-label">Nama <span class="asterisk">*</span></label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="u_nama" name="name" placeholder="Isikan Nama" value="" required>
                    </div>
                  </div>  

                  <div class="pr v_email row" style="display: none">
                    <label for="u_email" class="col-sm-4 control-label">Email <span class="asterisk">*</span></label>

                    <div class="col-sm-8">
                      <input type="email" class="form-control" id="u_email" name="email" placeholder="Isikan Email" value="">
                    </div>
                  </div>  
                  

                  <div class="pr v_no_peg row" style="display: none">
                    <label for="u_no_peg" class="col-sm-4 control-label">Nomor Pegawai <span class="asterisk">*</span></label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="u_no_peg" name="no_pegawai" placeholder="Isikan Nomor Pegawai" value="">
                    </div>
                  </div>  
                  

                  <div class="pr v_jabatan row" style="display: none">
                    <label for="u_jabatan" class="col-sm-4 control-label">Jabatan <span class="asterisk">*</span></label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="u_jabatan" name="jabatan" placeholder="Isikan Jabatan" value="">
                    </div>
                  </div>  
                  

                  <div class="pr v_department row" style="display: none">
                    <label for="u_department" class="col-sm-4 control-label">Department <span class="asterisk">*</span></label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="u_department" name="department" placeholder="Isikan Department" value="">
                    </div>
                  </div>  

                  <div class="pr v_group row" style="display: none">
                    <label for="u_group" class="col-sm-4 control-label">Group <span class="asterisk">*</span></label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="u_group" name="group" placeholder="Isikan Group" value="" required>
                    </div>
                  </div> 

                  <div class="pr v_lantai row" style="display: none">
                    <label for="u_lantai" class="col-sm-4 control-label">Lantai <span class="asterisk">*</span></label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="u_lantai" name="lantai" placeholder="Isikan Lantai" value="" required>
                    </div>
                  </div> 
                  

                  <div class="v_privilage row" style="display: inline">
                    <label for="u_privilege" class="col-sm-4 control-label">Rules<span class="asterisk">*</span></label>

                    <div class="col-sm-7">
                        <select  id="u_privilege" class="form-control col-sm-12" name="user_type" required onchange="v_form($(this).val())">
                          <option disabled selected>-- SELECT RULE --</option>
                          <option value="Super Admin" >Super Admin</option>
                          <option value="Kepala Divisi" >Kepala Divisi</option>
                          <option value="Admin"  >Admin</option>
                          <option value="Admin Penerimaan"  >Admin Penerimaan</option>
                          <option value="Admin Gudang"  >Admin Gudang</option>
                          <option value="Approval"  >Approval</option>
                          <option value="Karyawan"  >Karyawan</option>
                          <option value="Kurir"  >Kurir</option>
                        </select>
                      
                    </div>
                  </div>  
                  <br>



              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" id="u_save" class="btn btn-outline">Save</button>
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>



        <ul id="pop_select_rule" class="dropdown-menu" style="display: none;">
          <input type="hidden" name="id_pem" class="id_pem">
          <button class="btn bg-aqua btn-block" type="button" onclick="adm_ch_stat(String($(this).parent().find('.id_pem').val()),String(3))">Prepare Item</button>
          <button class="btn btn-primary btn-block" type="button" onclick="adm_ch_stat(String($(this).parent().find('.id_pem').val()),String(4))">Courier On The Way</button>
          <button class="btn btn-success btn-block" type="button" onclick="adm_ch_stat(String($(this).parent().find('.id_pem').val()),String(5))">Done</button>

        </div> 
        </ul>
    <!-- /.content -->

    <style>
      #u_password{
        -webkit-text-security:square;
      }
    </style>
  
