<style type="text/css">
	table,
	thead,
	tr,
	tbody,
	th,
	td {
	    text-align: center;
	}

	.table td {
	   text-align: center;   
}
</style>
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<!--li class="active">Icons</li-->
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Pembobotan Sub Kriteria Kompetensi</h1>
	</div>
</div><!--/.row-->

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-warning">
			<div class="panel-heading">Keterangan Nilai Kepentingan</div>
			<div class="panel-body">				

				<table class="display" id="table-style" cellspacing="0" width="100%" border="1">
				    <thead>
					    <tr>
					    	<th>Nilai Kepentingan</th>
					        <th>Definisi</th>
					        <th>Keterangan</th>
					    </tr>					    
				    </thead>
				   
				    <tbody>
				    	<?php foreach ($nilaiKepentingan->result() as $row) {
				    		echo "<tr>";
				    		echo "<td>".$row->tkNilai."</td>";
				    		echo "<td>".$row->tkDefinisi."</td>";
				    		echo "<td>".$row->tkKeterangan."</td>";
				    		echo "</tr>";
				    	}
				    	?>
				    </tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Matriks Perbandingan Sub Kriteria Kompetensi</div>
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
					    <tr align="center">
					    	<th rowspan="2">Sub Kriteria</th>
					        <th colspan="17">Nilai Kepentingan</th>
					        <th rowspan="2">Sub Kriteria</th>
					    </tr>
					    <tr>
					    	<th>9</th>
					    	<th>8</th>
					    	<th>7</th>
					    	<th>6</th>
					    	<th>5</th>
					    	<th>4</th>
					    	<th>3</th>
					    	<th>2</th>	
					    	<th>1</th>						    	
					    	<th>2</th>
					    	<th>3</th>
					    	<th>4</th>
					    	<th>5</th>
					    	<th>6</th>
					    	<th>7</th>
					    	<th>8</th>
					    	<th>9</th>
					    </tr>
				    </thead>
				    <form action="<?php echo site_url('parameter/cekKonsistensi/'.$this->uri->segment(3)) ?>" method="post">
				    <tbody>

				    	<?php 
				    		$cek = $this->db->query('SELECT * FROM matriks_perbandingan_parameter WHERE mppUserId = '.$userId.' AND mppKriteriaId = '.$this->uri->segment(3));
				    			if ($cek->num_rows() > 0) {
				    	?>

				    	<?php
				    		for ($i=0; $i < count($matriks); $i++) { 
				    			$panjang = strlen($matriks[$i]);
				    			$tengah = $panjang/2;
				    			$sisip = substr_replace($matriks[$i],'_',$tengah,0);
				    			$explode = explode('_', $sisip);	
				    			$nilai = $this->db->query('SELECT * FROM matriks_perbandingan_parameter WHERE mppKriteriaId = '.$this->uri->segment(3).' AND mppUserId = '.$userId.' AND mppParameterBaris = '.$matriksPosisi[$i])->row()->mppNilai;			    			
				    	?>
				    	<tr>
				    		<td><?php echo getSubKriteria($explode[0],$this->uri->segment(3),'parameterNama'); ?></td>
				    		<td><input type="radio" value="9" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '9') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="8" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '8') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="7" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '7') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="6" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '6') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="5" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '5') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="4" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '4') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="3" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '3') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="2" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '2') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="1" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '1') ? "checked" : "" ?> required></td>				    	
				    		<td><input type="radio" value="1/2" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '0.5') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="1/3" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '0.33') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="1/4" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '0.25') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="1/5" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '0.2') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="1/6" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '0.17') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="1/7" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '0.14') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="1/8" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '0.12') ? "checked" : "" ?> required></td>
				    		<td><input type="radio" value="1/9" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" <?php echo ($nilai == '0.11') ? "checked" : "" ?> required></td>				    		
				    		<td><?php echo getSubKriteria($explode[1],$this->uri->segment(3),'parameterNama'); ?></td>
				    	</tr>
				    	<?php
				    		}
				    	?>

				    	<?php
				    			}else{
				    	?>

				    	<?php
				    		for ($i=0; $i < count($matriks); $i++) { 
				    			$panjang = strlen($matriks[$i]);
				    			$tengah = $panjang/2;
				    			$sisip = substr_replace($matriks[$i],'_',$tengah,0);
				    			$explode = explode('_', $sisip);				    			
				    	?>
				    	<tr>
				    		<td><?php echo getSubKriteria($explode[0],$this->uri->segment(3),'parameterNama'); ?></td>
				    		<td><input type="radio" value="9" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="8" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="7" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="6" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="5" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="4" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="3" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="2" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="1" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>				    	
				    		<td><input type="radio" value="1/2" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="1/3" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="1/4" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="1/5" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="1/6" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="1/7" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="1/8" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>
				    		<td><input type="radio" value="1/9" id="optionsRadios1" name="<?php echo $matriksPosisi[$i] ?>" required></td>				    		
				    		<td><?php echo getSubKriteria($explode[1],$this->uri->segment(3),'parameterNama'); ?></td>
				    	</tr>
				    	<?php
				    		}
				    	?>

				    	<?php
				    			}
				    	?>				    	
				    </tbody>
				</table>
			</div>
			<?php //if ($isi->num_rows() > 0) { ?>
				<!--a class="btn btn-danger" href="<?php echo site_url('kriteria/kompetensiUbahNilai') ?>">Rubah Nilai Perbandingan</a-->
			<?php //}else{ ?>
				<input type="submit" value="Cek Konsistensi" class="btn btn-primary" name="submit"></input>
			<?php //} ?>
			
			</form>
		</div>
	</div>
</div>

<?php if($bobot->num_rows() > 0){ ?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">Hasil Bobot Kriteria Kompetensi Dari Matriks Perbandingan Di Atas</div>
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
				    			<td><?php echo $row->parameterKode ?></td>
				    			<td><?php echo $row->parameterNama ?></td>
				    			<td><?php echo $row->bpNilai ?></td>
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