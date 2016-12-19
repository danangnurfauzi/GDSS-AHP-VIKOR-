<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<!--li class="active">Icons</li-->
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Manajemen Alternatif Karyawan</h1>
	</div>
</div><!--/.row-->
		

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Form Edit Alternatif Karyawan</div>
			<div class="panel-body">
				<div class="col-md-6">
					<form role="form" action="<?php echo current_url() ?>" method="post">
						
						<div class="form-group">
							<label>Nama</label>
							<input class="form-control" name="nama" value="<?php echo $isi->altKaryawanNama ?>" required="">
						</div>

						<div class="form-group">
							<label>Kode</label>
							<input class="form-control" name="kode" value="<?php echo $isi->altKaryawanKode ?>" required="">
						</div>						
						
						<div class="form-group">
							<label>Jenjang</label>
							<select class="form-control" name="jenjang">
								<?php foreach ($jenjang->result() as $jen) { ?>
									<option value="<?php echo $jen->jenjang_nama ?>" <?php echo ($isi->altKaryawanJenjang == $jen->jenjang_nama) ? 'selected' : '' ?>><?php echo $jen->jenjang_nama ?></option>									
								<?php } ?>								
							</select>
						</div>					

						<div class="form-group">
							<label>Golongan</label>
							<select class="form-control" name="golongan">
								<?php foreach ($golongan->result() as $gol) { ?>
									<option value="<?php echo $gol->gol_short_name ?>" <?php echo ($isi->altKaryawanGolongan == $gol->gol_short_name) ? 'selected' : '' ?>><?php echo $gol->gol_short_name ?></option>									
								<?php } ?>								
							</select>
						</div>

						<input type="submit" class="btn btn-primary" name="Submit" value="Submit">																
						<a class="btn btn-default" href="<?php echo site_url('home/alternatifKaryawan') ?>">Kembali</a>
					</div>
				</form>
			</div>
		</div>
	</div><!-- /.col-->
</div><!-- /.row -->