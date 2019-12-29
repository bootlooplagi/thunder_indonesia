<div class="row">
    <div class="col-lg-12">
        <center>
          <h2><?php echo $page_title; ?></h2>
          <hr style="border-top: 3px double #8c8b8b;">
          <?php //$this->load->view('tpl_form_message'); ?>
        </center>
    </div>
</div>

<div class="row">
    <div class="form-group col-lg-2">
        <div onclick="add_brg_hilang($(this))" class="form-control btn btn-success"><span class="fa fa-plus"></span>&nbsp;Barang Hilang</div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered table-striped table-hover dt-responsive" id="tb_barang_hilang">
          <thead>
            <tr style="color: white">
              <th>No.</th>
              <th>Nama Produk</th>
              <th>Serial Number</th>
              <th>Keterangan</th>
              <th>Status</th>
              <th style="width: 150px;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($produk)){ ?>
                <?php foreach ($produk as $key => $value) { ?>
                    <tr>
                      <td><?php echo $key+1; ?></td>
                      <td><?php echo $value->item_name; ?></td>
                      <td class="sn"><?php echo $value->serial_number; ?></td>
                      <td><?php echo $value->keterangan; ?></td>
                      <td><?php echo $value->found==1?'<div class="btn btn-xs bg-green">Found</div/b>':'<div class="btn bg-red btn-xs">Lost</div>' ?></td>
                      <td>
                          <!-- <button class="btn bg-yellow" onclick="edit(<?php echo $value->id_b; ?>)">
                              <span class="fa fa-edit"></span>
                          </button> -->
                          <?php if($value->found==0){ ?>
                              <button class="btn bg-green" onclick="del(<?php echo $value->id_b; ?>,<?php echo $value->serial_number; ?>,<?php echo $value->id_item; ?>)">
                                  <span class="fa fa-search"></span>
                              </button>
                          <?php } ?>
                      </td>
                    </tr>
                <? } ?>
            <?php } ?>
          </tbody>
        </table>
    </div>
</div>