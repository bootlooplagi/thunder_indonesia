<button data-toggle="tooltip" title="Tampilkan Item Pemesanan" class="btn btn-default btn-xs ps_view" onclick="sh_pemesanan(<?php echo $id_pem; ?>)">
          
          <span class="glyphicon glyphicon-fullscreen"></span>
  </button>

  <?php if($user=='Super Admin'||$user=='Kepala Divisi'||$user=='Karyawan'){ ?>
    <?php if(($s==0) && $act_button=='penawaran'){ ?>
      <a href="<?php echo base_url('transaksi/pemesanan/edit/') . $id_pem . '?type='.$s_active; ?>">
        <button data-toggle="tooltip" title="Edit Pemesanan" class="btn btn-xs btn-warning ps_edit" >
                <span class="glyphicon glyphicon-edit"></span>
        </button>
      </a>
    <?php } ?>
    <?php if(($s==2) && $act_button=='penawaran'){ ?>
      <a href="<?php echo base_url('transaksi/pemesanan/edit/') . $id_pem . '?type='.$s_active; ?>&nego=nego">
        <button data-toggle="tooltip" title="Edit Pemesanan" class="btn btn-xs btn-warning ps_edit" >
                <span class="glyphicon glyphicon-edit"></span>
        </button>
      </a>
    <?php } ?>
  <?php } ?>


  <?php if($act_button=='pemesanan'){ ?>
      <?php if($user=='Super Admin'||$user=='Kepala Divisi'||$user=='Approval'){ ?>
        <?php if($s==0){ ?>
          <button data-toggle="tooltip" title="Menyetujui Pemesanan" class="btn btn-xs btn-success ps_ch_stat" onclick="acc_order(<?php echo $id_pem; ?>)">
                <span class="glyphicon glyphicon-check"></span>
          </button>
        <?php } ?>
      <?php } ?>
      
        <?php if($user=='Super Admin'||$user=='Kepala Divisi'){ ?>
          <?php if($s==1){ ?>
            <button data-toggle="tooltip" title="Verifikasi Crew" class="btn btn-xs btn-primary" onclick="ver_crew(<?php echo $id_pem; ?>)">
                <span class="fa fa-truck"></span>
            </button>
<!--                 <button  class="csstooltip btn btn-xs btn-primary ps_kurir" value="<?php echo $id_pem; ?>" data-toggle="popover" data-title="List Kurir<a onclick='hide_pop($(this))' style='color:red;' href='#' class='pull-right'><b>X</b></a>" data-placement="left" onclick="pil_kurir($(this))">
                  <span class="tooltiptext">Pilih Kurir</span>
                        <span class="fa fa-truck"></span>
                </button> -->
          <?php } ?>
        <?php } ?>

        <?php if($user=='Super Admin'||$user=='Kepala Divisi'){ ?>
          <?php if($s>1 && $s<5){ ?>
              <button class="csstooltip btn btn-xs bg-aqua" onclick="ch_stat_pem($(this))" data-toggle="popover"  data-placement="left" data-trigger="focus" value="<?php echo $id_pem; ?>">
                <span class="tooltiptext" style="width: 300%;">Change Status</span>
                <span class="glyphicon glyphicon-send"></span>
              </button>
          <?php } ?>
        <?php } ?>

        <?php if($user=='Super Admin'||$user=='Kepala Divisi'||$user=='Approval'){ ?>
          <?php if($s<5){ ?>
              <button class="csstooltip btn btn-xs btn-danger" onclick="cancel_order(<?php echo $id_pem; ?>)" data-toggle="popover"  data-placement="left" data-trigger="focus">
                <span class="tooltiptext" style="width: 300%;">Cancel Order</span>
                <span class="glyphicon glyphicon-remove-circle"></span>
              </button>
          <?php } ?>
        <?php } ?>

        <button class="csstooltip btn btn-xs btn-success" onclick="location.href = '<?php echo base_url('transaksi/cetak_produksi'); ?>'" data-toggle="popover"  data-placement="left" data-trigger="focus">
          <span class="tooltiptext" style="width: 300%;">Print</span>
          <span class="glyphicon glyphicon-print"></span>
        </button>

        

  <?php } ?>

  <?php if($act_button=='penawaran'){ ?>

    <?php if($user=='Super Admin'||$user=='Kepala Divisi'||$user=='Kurir'||$user=='Admin'||$user=='Kurir'){ ?>
      <?php if($s!=3){ ?>
          <button class="csstooltip btn btn-xs bg-aqua" onclick="ch_stat_pem($(this),<?php echo $s; ?>)" data-toggle="popover"  data-placement="left" data-trigger="focus" data-title="<center><b>Action</b></center>" value="<?php echo $id_pem; ?>">
                  <span class="tooltiptext" style="width: 300%;">Change Status</span>
                  <span class="glyphicon glyphicon-send"></span>
          </button>
      <?php } ?>
    <?php } ?>

    <?php if($user=='Super Admin'||$user=='Kepala Divisi'){ ?>    
      <?php if($s==3){ ?>
          <button data-toggle="tooltip" title="Confirm to Production" class="btn btn-xs bg-white" onclick="conf_to_prod(<?php echo $id_pem; ?>)" data-html="true"> 
                  <span class="glyphicon glyphicon glyphicon-open"></span>
          </button>
      <?php } ?>
    <?php } ?>

      <?php if($s>0){ ?>
          <button class="csstooltip btn btn-xs bg-blue" onclick="alert('Print PDF')" data-toggle="popover"  data-placement="left" data-trigger="focus" data-title="<center><b>Action</b></center>" value="<?php echo $id_pem; ?>">
                  <span class="tooltiptext" style="width: 300%;">Cetak PDF</span>
                  <span class="glyphicon glyphicon-print"></span>
          </button>
      <?php } ?>

  <?php } ?>