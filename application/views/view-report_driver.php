<?php if($mode=='view'){ ?>
	<div class="panel panel-default">
	  <div class="panel-heading">Filter By</div>
	  <div class="panel-body">
	  	<div class="row">
	  		<div class="col-lg-6 form-group">
	  			<label>Pilih Driver</label>
	  			<select class="form-control select2 act" name="sel_driver">
	  				<option disabled="disabled" selected="selected" >Pilih Driver</option>
	  				<?php foreach ($driver as $key => $value) { ?>
	  					<option value=<?php echo $value->id; ?>><?php echo $value->name; ?></option>
	  				<?php } ?>
	  			</select>
	  		</div>
	  	</div>
	  	<div class="row">
	  		<div class="col-lg-6 form-group">
	  			<label>Pilih Bulan</label>
	  			<select class="form-control" name="sel_bulan">
	  				<option value=0 selected="selected" disabled="disabled">Pilih Bulan</option>
	  				<option value=1 >Januari</option>
	  				<option value=2 >Februari</option>
	  				<option value=3 >Maret</option>
	  				<option value=4 >April</option>
	  				<option value=5 >Mei</option>
	  				<option value=6 >Juni</option>
	  				<option value=7 >Juli</option>
	  				<option value=8 >Agustus</option>
	  				<option value=9 >September</option>
	  				<option value=10 >Oktober</option>
	  				<option value=11 >November</option>
	  				<option value=12 >Desember</option>
	  			</select>
	  		</div>
	  	</div>
	  	<div class="row">
	  		<div class="col-lg-6 form-group">
	  			<label>Pilih Tahun</label>
	  			<input class="form-control" type="text" name="sel_date" id='date_year' value="<?php echo date('Y'); ?>">
	  		</div>
	  	</div>

	  	<div class="row">
	  		<div class="col-lg-6 form-group">
	  			<button class="form-control btn btn-success" onclick="getReportDriver($(this))">Submit</button>
	  		</div>
	  	</div>
	  </div>
	</div>

	<div class="panel panel-default">
	  <div class="panel-heading">Report Bulanan</div>
	  <div class="panel-body" id="list_report_driver">
	  		
	  </div>
	</div>
<?php } ?>


<?php if($mode=='post_tb'){ ?>
	<table class="table table-report table-bordered table-striped table-hover">
		<thead>
			<tr class="bg-blue">
				<th>No.</th>
				<th>Driver</th>
				<th>No. Produksi</th>
				<th>Tanggal Pemesanan</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php if(!empty($tb_report_driver)){ ?>
				<?php foreach ($tb_report_driver as $k => $tb) { ?>
					<tr>
						<td><?php echo $k+1; ?></td>
						<td><?php echo $tb->name; ?></td>
						<td><?php echo $tb->no_pemesanan; ?></td>
						<td><?php echo $tb->tgl_pemesanan; ?></td>
						<td><?php echo $status[$tb->status]; ?></td>
					</tr>
				<?php } ?>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr >
				<td colspan="4" style="text-align: right;">Total Jobs :</td>
				<td><b><?php echo $jumlah_jobs; ?></b></td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: right;">Success :</td>
				<td><b><?php echo $success; ?></b></td>
			</tr>
			<tr>
				<td colspan="4" style="text-align: right;">Progress :</td>
				<td><b><?php echo $progress; ?></b></td>
			</tr>
		</tfoot>
	</table>
<?php } ?>