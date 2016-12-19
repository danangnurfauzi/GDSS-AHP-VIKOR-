<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<!--li class="active">Icons</li-->
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Data Karyawan</h1>
	</div>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Data Alternatif Karyawan</div>
			<div class="panel-body">
				<?php if ($this->session->flashdata('error')) { ?>
				<div role="alert" class="alert bg-danger">
					<svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"/></svg> <?php echo $this->session->flashdata('error'); ?><span class="glyphicon glyphicon-remove"></span></a>
				</div>
				<?php } ?>

				<?php if ($this->session->flashdata('success')) { ?>
				<div role="alert" class="alert bg-success">
					<svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"/></svg> <?php echo $this->session->flashdata('success'); ?><span class="glyphicon glyphicon-remove"></span></a>
				</div>
				<?php } ?>

				<form role="form" action="<?php echo site_url('home/postAlternatif') ?>" method="post">

				<table id="example" class="display" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>No</th>
			                <th>ID Karyawan</th>
			                <th>Nama</th>
			                <th>Jabatan</th>
			                <th>Lokasi</th>	
			                <th>Jenjang</th>
			                <th>Golongan</th>	
			                <th>Set Alternatif</th>		                		               
			            </tr>
			        </thead>
			        <tbody>
			        	<?php $i=1; foreach ($list->result() as $value) { ?>
			        		<tr>
			        			<td><?php echo $i++ ?></td>
			        			<td><?php echo $value->id ?></td>
			        			<td><?php echo $value->nama ?></td>
			        			<td><?php echo $value->jabatan_nama_lengkap ?></td>
			        			<td><?php echo $value->sat_nama_lengkap ?></td>
			        			<td><?php echo $value->jenjang_nama ?></td>
			        			<td><?php echo $value->gol_short_name ?></td>	
			        			<td>
			        				
									<label>
										<input type="checkbox" value="<?php echo $value->id ?>" name="karyawan[]" <?php echo ($value->altKaryawanIdk == $value->id) ? "checked disabled='disabled'" : "" ?> >
									</label>
									
			        			</td>		        			
			        		</tr>
			        	<?php } ?>
			        </tbody>
			    </table>
			    <br />
			    <input class="btn btn-primary" type="submit" value="SUBMIT">
			    </form>
			</div>
		</div>
	</div>
</div><!--/.row-->	

<script type="text/javascript">

	$(document).ready(function() {
	    $('#example').DataTable();
	} );
</script>