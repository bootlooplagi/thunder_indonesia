<script>
  var URL = '<?php echo base_url(); ?>'
</script>

<ul class="sidebar-menu tree" data-widget="tree">
  <li class="header">MAIN NAVIGATION</li>
  <li onclick="location.href = '<?php echo base_url('home'); ?>'"><a href="#"><i class="fa fa-shopping-cart"></i> <span>Dashboard</span></a></li>
    <?php if($user=='Super Admin'||$user=='Kepala Divisi'||$user=='Approval'||$user=='Admin'||$user=='Karyawan'||$user=='Kurir'||$user=='Admin Gudang'){ ?>
      <li class="<?php echo $s_active=='penawaran' ? 'active':''; ?>"><a href="<?php echo base_url('transaksi/pemesanan/view_penawaran'); ?>"><i class="glyphicon glyphicon-shopping-cart"></i> <span>Penawaran</span></a></li>
  <?php } ?>

  <?php if($user == 'Super Admin'||$user=='Kepala Divisi' || $user == 'Admin' || $user == 'Approval'|| $user == 'Admin Penerimaan' || $user == 'Admin Gudang'||$user=='Admin Gudang'){ ?>
      <li class="treeview <?php echo $s_active=='pengajuan' || $s_active=='penerimaan' ? 'active':''; ?>">
        <a href="#">
          <i class="fa fa-shopping-bag"></i> <span>Pengadaan Barang</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
            <li class="<?php echo $s_active=='pengajuan' ? 'active':''; ?>"><a href="<?php echo base_url('transaksi/trx/view'); ?>"><i class="glyphicon glyphicon-upload"></i> <span>Pengajuan / Persetujuan</span></a></li>
            <li class="<?php echo $s_active=='penerimaan' ? 'active':''; ?>"><a href="<?php echo base_url('transaksi/trx/view_penerimaan'); ?>"><i class="glyphicon glyphicon-download"></i> <span>Penerimaan</span></a></li>
        </ul>
      </li>
      
  <?php } ?>

  <?php if($user=='Super Admin'||$user=='Kepala Divisi'||$user=='Approval'||$user=='Admin'||$user=='Karyawan'||$user=='Kurir'||$user=='Admin Gudang'){ ?>
      <li class="<?php echo $s_active=='pemesanan' ? 'active':''; ?>"><a href="<?php echo base_url('transaksi/pemesanan/view'); ?>"><i class="glyphicon glyphicon-shopping-cart"></i> <span>Produksi</span></a></li>
  <?php } ?>
  

  <?php if($user == 'Super Admin'||$user=='Kepala Divisi' || $user == 'Admin'||$user=='Admin Gudang'){ ?>
      <li class="treeview <?php echo $s_active=='kategori' || $s_active=='sub_kategori' || $s_active=='item' || $s_active=='paket_item' || $s_active=='barang_hilang' ? 'active':''; ?>">
        <a href="#">
          <i class="fa fa-shopping-bag"></i> <span>Produk</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo $s_active=='kategori'? 'active':''; ?>"><a href="<?php echo base_url('produk/kategori/view'); ?>"><i class="fa fa-circle-o"></i> Kategori</a></li>
          <li class="<?php echo $s_active=='sub_kategori'? 'active':''; ?>"><a href="<?php echo base_url('produk/sub_kategori/view'); ?>"><i class="fa fa-circle-o"></i> Sub Kategori</a></li>
          <li class="<?php echo $s_active=='item'? 'active':''; ?>"><a href="<?php echo base_url('produk/item/view'); ?>"><i class="fa fa-circle-o"></i> Item</a></li>
          <li class="<?php echo $s_active=='paket_item'? 'active':''; ?>"><a href="<?php echo base_url('produk/paket_item/view'); ?>"><i class="fa fa-circle-o"></i>Paket Item</a></li>
          <li class="<?php echo $s_active=='barang_hilang'? 'active':''; ?>"><a href="<?php echo base_url('produk/barang_hilang/view'); ?>"><i class="fa fa-circle-o"></i>Barang Hilang</a></li>
        </ul>
      </li>
  <?php } ?>

  <?php if($user == 'Super Admin'||$user=='Kepala Divisi'){ ?>
      <li class="<?php echo $s_active=='service' ? 'active':''; ?>">
        <a href="<?php echo base_url('service'); ?>">
          <i  class="glyphicon glyphicon-wrench"></i><span>Service</span>
        </a>
      </li>
  <?php } ?>
  
  <?php if($user=='Super Admin'||$user=='Kepala Divisi'||$user=='Admin'||$user=='Karyawan'||$user=='Kurir'||$user=='Admin Gudang'){ ?>
      <li class="<?php echo $s_active=='extra' ? 'active':''; ?>">
        <a href="<?php echo base_url('transaksi/extra_charge_view'); ?>">
          <i class="glyphicon glyphicon-usd"></i> <span>Extra Charge</span>
        </a>
      </li>
  <?php } ?>


      
      


  







  <?php if($user == 'Super Admin'){ ?>
      <!-- <li class="treeview ">
        <a href="#">
          <i class="fa fa-user"></i> <span>User</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu"> -->
         <!--  <li class="<?php echo $s_active=='user' ? 'active':''; ?>"><a href="<?php echo base_url('customer/view'); ?>"><i  class="fa fa-user"></i>User Management</a></li> -->

          <li class="treeview <?php echo $s_active=='user' || $s_active=='customer' ? 'active':''; ?>">
              <a href="#">
                <i class="fa fa-user"></i> <span>User Management</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                  <li class="<?php echo $s_active=='user' ? 'active':''; ?>"><a href="<?php echo base_url('customer/view'); ?>"><i class="glyphicon glyphicon-user"></i> <span>User</span></a></li>
                  <li class="<?php echo $s_active=='customer' ? 'active':''; ?>"><a href="<?php echo base_url('customer/view_customer'); ?>"><i class="fa fa-user-circle-o"></i> <span>Customer</span></a></li>
              </ul>
          </li>
      
          <!-- <li onclick="beta()"><a href="#"><i  class="beta fa fa-circle-o"></i> User</a></li>
          <li onclick="beta()"><a href="#"><i  class="beta fa fa-circle-o"></i> Super Admin</a></li>
        </ul>
      </li> -->
  <?php } ?>

  <?php if($user == 'Super Admin'){ ?>
          <li class="treeview <?php echo $s_active=='report_driver' ? 'active':''; ?>">
              <a href="#">
                <i class="fa fa-file"></i> <span>Laporan</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                  <li class="<?php echo $s_active=='report_driver' ? 'active':''; ?>"><a href="<?php echo base_url('report/report_driver'); ?>"><i class="fa fa-file"></i> <span>Laporan Driver</span></a></li>
              </ul>
          </li>
  <?php } ?>


</ul>

<script>
  function beta(){
    alert('Maaf, halaman belum bisa dibuka');
  }
</script>