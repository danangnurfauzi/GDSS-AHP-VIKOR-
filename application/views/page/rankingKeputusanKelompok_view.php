<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<!--li class="active">Icons</li-->
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Ranking Keputusan Kelompok</h1>
	</div>
</div><!--/.row-->

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Ranking Keputusan Kelompok</div>
			<div class="panel-body">				
				
				<table class="display" id="table-style" cellspacing="0" width="100%" border="1">
				    <thead>
					    <tr>
					    	<td>Ranking</td>					    		
					    	<td>Jumlah Point</td>
					    	<td>Alternatif</td>			    						    
					    </tr>
				    </thead>
				    
				    <tbody>
				    	<?php 
				    		$i=1;
				    		foreach ($jumlahPoint as $key => $value) { ?>
				    			<tr>
				    				<td><?php echo $i; ?></td>
				    				<td><?php echo $value; ?></td>
				    				<td><?php echo "K".$alternatifArray[$key] ?></td>
				    			</tr>
				    	<?php $i++;	}
				    	 ?>		    		
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