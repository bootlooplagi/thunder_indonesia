
<style>
.card {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    cursor: pointer;
    /*width: 100%;*/
}

.card:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.containerz {
    padding: 2px 16px;
    margin-bottom: 20px;
}

.select2-dropdown.increasedzindexclass {
  z-index: 999999999999;
}
</style>
</head>

<?php if($mode=="driver"){ ?>
    <div class="col-lg-12">
        <?php foreach ($driver as $key => $value) { ?>
            <div class="col-md-4">
                <div class="card" onclick="add_driver_to_produksi(<?php echo $value->id; ?>,'<?php echo $value->name; ?>',<?php echo $id_pemesanan; ?>)">
                  <img src="<?php echo base_url('images/') ?>img_avatar.png?token=<?php echo time(); ?>" alt="Avatar" style="width:100%;background-color:grey;">
                  <div class="containerz">
                    <center><h4><b><?php echo $value->name; ?></b></h4> </center>
    <!--                 <p>Architect & Engineer</p>  -->
                  </div>
                </div>
            </div>
        <? } ?>
        
    </div>
<?php } ?>

<?php if($mode=="crew"){ ?>    
    <div class="col-lg-12" id="content-dialog">
        <?php foreach ($driver as $key => $value) { ?>
            <?php $av = array_search($value->id, $crews); ?>
            <div class="col-md-3">
                <div class="<?php echo !empty($av) ? 'selected':''; ?> driver_list card" data-id=<?php echo $value->id; ?> data-name="<?php echo $value->name; ?>" onclick="select_crew($(this),<?php echo $value->id; ?>)">
                  <img src="<?php echo base_url('images/') ?>img_avatar.png?token=<?php echo time(); ?>" alt="Avatar" style="width:100%;background-color:grey;">
                  <div class="containerz <?php echo $value->is_freelance==1 ? 'bg-yellow':''; ?>">
                    <center ><h6><b><?php echo $value->name; ?></b></h6> </center>
    <!--                 <p>Architect & Engineer</p>  -->
                  </div>
                </div>
            </div>
        <? } ?>
        
    </div>
<?php } ?>

<script type="text/javascript">
    $('#sel2-driver').select2({
        dropdownCssClass: "increasedzindexclass"
    });
</script>

<style type="text/css">
    .driver_list.card.selected{
        box-shadow:rgb(81, 51, 247) 0 0px 14px 6px;
    }
</style>


