
    <!-- Content Header (Page header) -->
    <input type="hidden" id="BASE_URL" value="<?php echo base_url(); ?>">
    <!-- <input type="hidden" id="type_pos" value="<?php //echo $type; ?>"> -->
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div id="table-wrapper">
              <center>
                <h2>SET UP <?php echo $page_title; ?></h2>
                <hr style="border-top: 3px double #8c8b8b;">
                <?php //$this->load->view('tpl_form_message'); ?>
              </center>

              <br>
              <button onclick="ae('add','','bg-green','SAVE')" type="button" id="addRow" class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus"></span>
                Tambah Extra Charge
              </button>
              <br><br>
              <table id="tb_extra_charge" class="table table-bordered table-striped table-hover dt-responsive" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th class="" style="background-color: #4F81BD; color: white; width: 15px">NO.</th>
                  <th class="" style="background-color: #4F81BD; color: white; width: 30px">KODE</th>
                  <th class="" style="background-color: #4F81BD; color: white; width: 30px">CHARGE</th>
                  <th class="" style="background-color: #4F81BD; color: white; width: 30px">DESCRIPTION</th>
                  <th class="" style="background-color: #4F81BD; color: white; width: 100px">UPDATE BY</th>
                  <th class="" style="background-color: #4F81BD; color: white; width: 110px">UPDATE DATE</th>
                  <th class="" style="background-color: #4F81BD; color: white; width: 100px">ACTION.</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                    $no = 1;
                    if(!empty($tb_extra) && $tb_extra !== NULL){
                      
                      foreach ($tb_extra as $tb) {
                        echo '<tr>
                              <td>'.$no.'</td>
                              <td>'.$tb->code.'</td>
                              <td>'.$tb->charge.' %</td>
                              <td>'.$tb->description.'</td>
                              <td>'.$tb->update_by_username.'</td>
                              <td>'.$tb->update_date.'</td>
                              <td>
                                <button data-toggle="tooltip" title="Edit \'Extra Charge\'" class="btn btn-warning" onclick="ae(\'edit\',$(this).val(),\'bg-yellow\',\'UPDATE\')" value="'
                                                                                          .$tb->id.'|'
                                                                                          .$tb->code.'|'
                                                                                          .$tb->charge.'|'
                                                                                          .$tb->description.
                                  '"><span class="glyphicon glyphicon-edit"></span></button>
                                <button data-toggle="tooltip" title="Hapus \'Extra Charge\'" class="btn btn-danger" onclick="del('.$tb->id.')"><span class="glyphicon glyphicon-trash"></span></button>
                              </td>
                            </tr>';
                        $no++;
                      }
                    }

                  ?>
                </tbody>
              </table>
              <?php echo '<input type="hidden" class="cKat" value="'. $no .'">'; ?>
          </div>
        </div>
      </div>

    <!-- /.content -->
  
