<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>GDSS AHP-VIKOR</title>

<link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/css/datepicker3.css" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/css/styles.css" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/css/bootstrap-table.css" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/css/prelodr.css" rel="stylesheet">

<!--Icons-->
<script src="<?php echo base_url() ?>assets/js/lumino.glyphs.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery-1.12.0.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

<style type="text/css">
	#loading {
	   width: 100%;
	   height: 100%;
	   top: 0px;
	   left: 0px;
	   position: fixed;
	   display: block;
	   opacity: 0.7;
	   background-color: #fff;
	   z-index: 99;
	   text-align: center;
	}

	#loading-image {
	  position: absolute;
	  margin: auto;
	  text-align: center;
	  top: 50%;	  
	  z-index: 100;
	}
</style>
</head>

<body>
	<div id="loading">
  		<img id="loading-image" src="<?php echo base_url(); ?>assets/images/loading.gif" alt="Loading..." />
	</div>
	<?php $this->load->view('header') ?>
		
	<?php $this->load->view('sidebar') ?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		
	<?php 
    	if (!empty($page)): 
     		$this->load->view($page); 
    	else: 
     		$this->load->view('blank_view');
     	endif; 
    ?>	
		
	</div>	<!--/.main-->

	

	<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/chart.min.js"></script>
	<!--script src="<?php echo base_url() ?>assets/js/chart-data.js"></script-->
	<script src="<?php echo base_url() ?>assets/js/easypiechart.js"></script>
	<script src="<?php echo base_url() ?>assets/js/easypiechart-data.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap-table.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/prelodr.js"></script>
	<script>

		 $(window).load(function() {
		     //alert('full');
		     $('#loading').fadeOut();
		  });

		$('#calendar').datepicker({
		});

		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
		        $(this).find('em:first').toggleClass("glyphicon-minus");      
		    }); 
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})


	</script>	
</body>

</html>
