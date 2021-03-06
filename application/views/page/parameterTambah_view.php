<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<!--li class="active">Icons</li-->
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Manajemen Sub Kriteria</h1>
	</div>
</div><!--/.row-->
		

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Form Tambah Sub Kriteria</div>
			<div class="panel-body">
				<div class="col-md-6">
					<form role="form" action="<?php echo current_url() ?>" method="post">
						
						<div class="form-group">
							<label>Kriteria</label>
							<select class="form-control" name="kriteria">
								<?php foreach ($kriteria->result() as $value) { ?>
									<option value="<?php echo $value->kriteriaId ?>"><?php echo $value->kriteriaNama ?></option>									
								<?php } ?>								
							</select>
						</div>

						<div class="form-group">
							<label>Sub Kriteria</label>
							<input class="form-control" name="parameter" required="">
						</div>

						<div class="form-group">
							<label>Kode Sub Kriteria</label>
							<input class="form-control" name="kode" required="">
						</div>						
						
						<div class="form-group">
							<label>Keterangan</label>
							<textarea class="form-control" rows="3" name="keterangan"></textarea>
						</div>						

						<input type="submit" class="btn btn-primary" name="Submit" value="Submit">																
					
					</div>
				</form>
			</div>
		</div>
	</div><!-- /.col-->
</div><!-- /.row -->