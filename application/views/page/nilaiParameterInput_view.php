<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<!--li class="active">Icons</li-->
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Edit Nilai Parameter Alternatif Karyawan</h1>
	</div>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Edit Data Nilai Parameter Alternatif Karyawan</div>
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

				<!--div>
					<a href="<?php echo site_url('home/alternatifKaryawanTambah') ?>"><img src="<?php echo base_url() ?>assets/images/add_files.png" height="48px"><strong>Tambah Alternatif Karyawan</strong></a>
				</div-->
				<br />
				<form role="form" action="<?php echo site_url('nilai/setDataNilaiParameter/'.$this->uri->segment(3)) ?>" method="post">
				<table id="example" class="display" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>No</th>
			                <th>Parameter</th>
			                <th>Kode</th>
			                <th>Nilai</th>
			                		                
			            </tr>
			        </thead>
			        <tbody>
			        	<?php $i=1; foreach ($parameter->result() as $value) { ?>
			        		<tr>
			        			<td><?php echo $i++ ?></td>
			        			<td><?php echo $value->parameterNama ?></td>
			        			<td><?php echo $value->parameterKode ?></td>
			        			<td>
			        				<input class="form-control" name="kriteria_<?php echo $value->parameterId ?>" required="">
			        			</td>			        			
			        		</tr>
			        	<?php } ?>
			        </tbody>
			    </table>
			    <input type="submit" class="btn btn-primary" name="Submit" value="Submit">																
			    </form>
			</div>
		</div>
	</div>
</div><!--/.row-->	

<script type="text/javascript">

	$(document).ready(function() {
	    $('#example').DataTable({
						"aLengthMenu": [
						[-1] ]
		});
	} );
</script>