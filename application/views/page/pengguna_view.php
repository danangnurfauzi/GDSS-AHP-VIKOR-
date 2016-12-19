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
			<div class="panel-heading">Data Pengguna</div>
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
					<a href="<?php echo site_url('home/penggunaTambah') ?>"><img src="<?php echo base_url() ?>assets/images/add_users.png" height="48px"><strong>Tambah Pengguna</strong></a>
				</div>
				<br />
				<table id="tabel" class="display" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                <th>No</th>
			                <th>Nama</th>
			                <th>Username</th>
			                <th>Role</th>
			                <th>Aksi</th>
			            </tr>
			        </thead>
			        <tbody>
			        	<?php $i=1; foreach ($list->result() as $value) { ?>
			        		<tr>
			        			<td><?php echo $i++ ?></td>
			        			<td><?php echo $value->nama ?></td>
			        			<td><?php echo $value->username ?></td>
			        			<td><?php echo getRolePengguna($value->role) ?></td>
			        			<td>
			        				<a href="<?php echo site_url('home/penggunaEdit/'.$value->userId) ?>" ><img src="<?php echo base_url() ?>assets/images/edit.png" height="24px"></a>
			        				<a href="<?php echo site_url('home/penggunaHapus/'.$value->userId) ?>" onClick="return confirm('yakin data akan dihapus?')"><img src="<?php echo base_url() ?>assets/images/trash-bin-open.png" height="24px"></a>
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
	    $('#tabel').DataTable();
	} );
</script>