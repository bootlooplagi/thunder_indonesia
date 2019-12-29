<?php if($mode=='add'){ ?>
    <div id="form-barang_hilang">
        <div class="form-group">
            <label>Pilih Barang</label>
            <select class="form-control" name="id_barang" id="id_barang">
                <?php foreach ($barang as $key => $value) { ?>
                    <option value=<?php echo $value->id; ?>><?php echo $value->item_name; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Serial Number</label>
            <input type="number" name="serial_number" class="form-control">
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="col-lg-12" rows="5"></textarea>
        </div>
    </div>
<?php } ?>

<?php if($mode=='edit'){ ?>

    <div id="form-barang_hilang">
        <div class="form-group">
            <label>Pilih Barang</label>
            <select disabled=disabled class="form-control" name="id_barang" id="id_barang">
                <?php foreach ($barang as $key => $value) { ?>
                    <option <?php echo ($data[0]->id_barang==$value->id)?'selected="selected"':''; ?> value=<?php echo $value->id; ?>><?php echo $value->item_name; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Serial Number</label>
            <input type="number" name="serial_number" class="form-control" value="<?php echo $data[0]->serial_number; ?>">
        </div>

        <div class="form-group">
            <label>Remark</label>
            <textarea name="keterangan" class="col-lg-12" rows="5"><?php echo $data[0]->keterangan; ?></textarea>
        </div>
    </div>
<?php } ?>



<script type="text/javascript">
  $('#id_barang').select2({dropdownCssClass: "id_barangDropdown"});
</script>
<style type="text/css">
  .id_barangDropdown{
      z-index: 99999999999999;
  }
</style>