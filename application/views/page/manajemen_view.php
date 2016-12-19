<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<!--li class="active">Icons</li-->
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Pembobotan Kriteria Manajemen</h1>
	</div>
</div><!--/.row-->

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Matriks Perbandingan Kriteria Manajemen</div>
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

				<table class="display" id="table-style" cellspacing="0" width="100%" border="1">
				    <thead>
					    <tr>
					    	<th>Kriteria</th>
					        <?php foreach($komp->result() as $kolom){ ?> 
					        <th><?php echo $kolom->kriteriaKode ?></th>
					        <?php } ?>
					    </tr>
				    </thead>
				    <form action="<?php echo site_url('kriteria/cekKonsistensi') ?>" method="post">
				    <tbody>
				    	<?php $i = 0; foreach ($komp->result() as $baris) { $j = 0; ?>
				    		<tr>
				    			<td><?php echo $baris->kriteriaKode ?></td>
				    				<?php foreach ($komp->result() as $kolom) {
				    						if($j > $i){
				    							if ($isi->num_rows() > 0) {
				    								$nilai = $this->db->query('SELECT * FROM matriks_perbandingan_kriteria WHERE mpkUserId = '.$userId.' AND mpkKriteriaIdBaris = '.$i.$j)->row()->mpkNilai;
				    								//$values = ($isi->row()->mpkKriteriaIdBaris == $i.$j) ? $isi->row()->mpkNilai : '';
				    								echo "<td><input type='text' name='".$i."_".$j."' value='".$nilai."' disabled/></td>";
				    							}else{
				    								echo "<td><input type='text' name='".$i."_".$j."'/></td>";	
				    							}
				    							
				    						}elseif($j == $i){
				    							echo "<td>1</td>";
				    						}else{
				    							echo "<td></td>";
				    						}
				    				 $j++; } ?>
				    		</tr>
				    	<?php $i++; } ?>
				    </tbody>
				</table>
			</div>
			<?php if ($isi->num_rows() > 0) { ?>
				<a class="btn btn-danger" href="<?php echo site_url('kriteria/kompetensiUbahNilai') ?>">Rubah Nilai Pembobotan</a>
			<?php }else{ ?>
				<input type="submit" value="Cek Konsistensi" class="btn btn-primary" name="submit"></input>
			<?php } ?>
			
			</form>
		</div>
	</div>
</div>

<?php if($bobot->num_rows() > 0){ ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">Hasil Bobot Kriteria Manajemen Dari Matriks Perbandingan Di Atas</div>
			<div class="panel-body">
				<table class="display" id="table-style" cellspacing="0" width="100%" border="1">
				    <thead>
					    <tr>
					    	<th>Kriteria Kode</th>
					    	<th>Krieria Nama</th>
					        <th>Bobot</th>
					    </tr>
				    </thead>
				    
				    <tbody>
				    	<?php foreach ($bobot->result() as $row) {  ?>
				    		<tr>
				    			<td><?php echo $row->kriteriaKode ?></td>
				    			<td><?php echo $row->kriteriaNama ?></td>
				    			<td><?php echo $row->bkNilai ?></td>
				    		</tr>
				    	<?php } ?>
				    </tbody>
				</table>
			</div>			
		</div>
	</div>
</div>
<?php } ?>

<script type="text/javascript">

	$(document).ready(function() {
	    $('#example').DataTable();
	} );
</script>