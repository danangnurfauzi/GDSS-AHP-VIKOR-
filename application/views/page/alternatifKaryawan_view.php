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

				<div>
					<a href="<?php echo site_url('home/dataKaryawan') ?>"><img src="<?php echo base_url() ?>assets/images/add_files.png" height="48px"><strong>Tambah Alternatif Karyawan</strong></a>
				</div>
				<br />
				<table id="example" class="display" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>No</th>
			                <th>Nama</th>
			                <th>Kode</th>			                
			                <th>Aksi</th>
			            </tr>
			        </thead>
			        <tbody>
			        	<?php $i=1; foreach ($list->result() as $value) { ?>
			        		<tr>
			        			<td><?php echo $i++ ?></td>
			        			<td><?php echo $value->nama ?></td>
			        			<td><?php echo $value->altKaryawanKode ?></td>			        			
			        			<td>
			        				<!--a href="<?php echo site_url('home/alternatifKaryawanEdit/'.$value->altKaryawanId) ?>" ><img src="<?php echo base_url() ?>assets/images/edit.png" height="24px"></a-->
			        				<a href="<?php echo site_url('home/alternatifKaryawanHapus/'.$value->altKaryawanId) ?>" onClick="return confirm('yakin data akan dihapus?')"><img src="<?php echo base_url() ?>assets/images/trash-bin-open.png" height="24px"></a>
			        			</td>
			        		</tr>
			        	<?php } ?>
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
</div><!--/.row-->	

<script type="text/javascript">

	$(document).ready(function() {
	    $('#example').DataTable();
	} );
</script>