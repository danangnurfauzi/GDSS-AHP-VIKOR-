<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<!--li class="active">Icons</li-->
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Indeks VIKOR</h1>
	</div>
</div><!--/.row-->

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Indeks VIKOR</div>
			<div class="panel-body">				
				
				<table class="display" id="table-style" cellspacing="0" width="100%" border="1">
				    <thead>
					    <tr>
					    	<td>Alternatif</td>
					    	<td>Indeks Vikor</td>					    	
					    </tr>
				    </thead>
				    
				    <tbody>
				    	<?php 
				    		$a=0; 
				    		foreach ($daftarAlternatif->result() as $baris) { ?>
				    			<tr>
				    				<td><?php echo $baris->altKaryawanKode ?></td>
					    			<td><?php echo round($matriks[$a],3); ?></td>				    					    				
				    			</tr>
				    	<?php $a++;} ?>			    		
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