<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<!--li class="active">Icons</li-->
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Manajemen Nilai Alternatif Karyawan</h1>
	</div>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Data Nilai Alternatif Karyawan</div>
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
				<table id="example" class="display" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>No</th>
			                <th>Nama</th>
			                <th>Kode</th>
			                <th>Kriteria</th>
			                <th>Sub Kriteria</th>			                
			            </tr>
			        </thead>
			        <tbody>
			        	<?php $i=1; foreach ($list->result() as $value) { ?>
			        		<tr>
			        			<td><?php echo $i++ ?></td>
			        			<td><?php echo $value->nama ?></td>
			        			<td><?php echo $value->altKaryawanKode ?></td>
			        			<td>
			        				<?php $cek = cekNilaiKriteria($value->altKaryawanId);
			        					if ($cek === TRUE) { ?>
			        					 	<a href="<?php echo site_url('nilai/nilaikriteriaEdit/'.$value->altKaryawanId) ?>" ><img alt="Edit Data" src="<?php echo base_url() ?>assets/images/green.png" height="24px"></a>
			        				<?php	 } else { ?>
			        					 	<a href="<?php echo site_url('nilai/nilaikriteriaInput/'.$value->altKaryawanId) ?>" ><img alt="Input Data" src="<?php echo base_url() ?>assets/images/red-11.png" height="24px"></a>
			        				<?php	 }
			        				?>
			        			</td>
			        			<td>
			        				<?php $cek = cekNilaiParameter($value->altKaryawanId);
			        					if ($cek === TRUE) { ?>
			        					 	<a href="<?php echo site_url('nilai/nilaiParameterEdit/'.$value->altKaryawanId) ?>" ><img alt="Edit Data" src="<?php echo base_url() ?>assets/images/green.png" height="24px"></a>
			        				<?php	 } else { ?>
			        					 	<a href="<?php echo site_url('nilai/nilaiParameterInput/'.$value->altKaryawanId) ?>" ><img alt="Input Data" src="<?php echo base_url() ?>assets/images/red-11.png" height="24px"></a>
			        				<?php	 }
			        				?>
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