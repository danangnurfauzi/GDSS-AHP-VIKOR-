<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<!--li class="active">Icons</li-->
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Perhitungan Borda</h1>
	</div>
</div><!--/.row-->

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Point Borda</div>
			<div class="panel-body">				
				
				<table class="display" id="table-style" cellspacing="0" width="100%" border="1">
				    <thead>
					    <tr>
					    	<td>Ranking</td>
					    	<?php for($i=1; $i<= $daftarAlternatif->num_rows(); $i++){ ?>
					    	<td><?php echo $i; ?></td>
					    	<?php } ?>					    						    
					    </tr>
				    </thead>
				    
				    <tbody>
				    	<tr>
				    		<td>Point</td>
				    		<?php for ($j=1; $j <= $daftarAlternatif->num_rows() ; $j++) { 
				    			echo "<td>".$point[$j]."</td>";
				    		} ?>
				    	</tr>		    		
				    </tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Hasil Perhitungan Borda</div>
			<div class="panel-body">				
				
				<table class="display" id="table-style" cellspacing="0" width="100%" border="1">
				    <thead>
					    <tr>
					    	<td>Alternatif</td>
					    	<?php foreach($decisionMaker->result() as $kolom){ ?>
					    	<td><?php echo $kolom->username; ?></td>
					    	<?php } ?>		
					    	<!--td>Jumlah</td-->
					    </tr>
				    </thead>
				    
				    <tbody>
				    	<?php 
				    		$a=0; 
				    		foreach ($daftarAlternatif->result() as $baris) { 
				    			$b=0; echo "<tr><td>".$baris->altKaryawanKode."</td>";
				    			foreach($decisionMaker->result() as $kolom1){
				    			?>				    						    			
					    			<td><?php echo $matriks[$a][$b] ?></td>						    					    					    				
				    			
				    	<?php $b++;} //echo "<td>".$jumlahPoint[$a]."</td></tr>"; 

				    	$a++;} ?>			    		
				    </tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {
	    $('#example').DataTable();
	} );
</script>