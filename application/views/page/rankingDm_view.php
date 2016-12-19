<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<!--li class="active">Icons</li-->
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Perankingan Pengambil Keputusan</h1>
	</div>
</div><!--/.row-->

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Perankingan Pengambil Keputusan</div>
			<div class="panel-body">				
				
				<table class="display" id="table-style" cellspacing="0" width="100%" border="1">
				    <thead>
					    <tr>
					    	<td>Alternatif</td>
					    	<?php foreach($decisionMaker->result() as $kolom){ ?>
					    	<td><?php echo $kolom->username; ?></td>
					    	<?php } ?>					    						    
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
				    			
				    	<?php $b++;} echo "</tr>"; $a++;} ?>			    		
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