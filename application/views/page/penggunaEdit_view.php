<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<!--li class="active">Icons</li-->
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Manajemen Pengguna</h1>
	</div>
</div><!--/.row-->
		

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Form Edit Pengguna</div>
			<div class="panel-body">
				<div class="col-md-6">
					<form role="form" action="<?php echo current_url() ?>" method="post">
					
						<div class="form-group">
							<label>Nama</label>
							<input class="form-control" name="nama" value="<?php echo $isi->nama ?>" required="">
						</div>

						<div class="form-group">
							<label>Username</label>
							<input class="form-control" name="username" value="<?php echo $isi->username ?>" required="">
						</div>						
						
						<div class="form-group">
							<label>Role</label>
							<div class="radio">
								<label>
									<input type="radio" name="role" id="optionsRadios1" value="0" <?php echo ($isi->role == '0') ? 'checked' : '' ?>>Admin
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="role" id="optionsRadios2" value="1" <?php echo ($isi->role == '1') ? 'checked' : '' ?>>Direktur
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="role" id="optionsRadios2" value="1" <?php echo ($isi->role == '2') ? 'checked' : '' ?>>Asisten Direktur
								</label>
							</div>
							<div class="radio">
								<label>
									<input type="radio" name="role" id="optionsRadios2" value="1" <?php echo ($isi->role == '3') ? 'checked' : '' ?>>Kepala Biro
								</label>
							</div>							
						</div>

						<input type="submit" class="btn btn-primary" name="Submit" value="Submit">																
						<a class="btn btn-default" href="<?php echo site_url('home/pengguna') ?>">Kembali</a>
					</div>
				</form>
			</div>
		</div>
	</div><!-- /.col-->
</div><!-- /.row -->