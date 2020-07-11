<!DOCTYPE html>
<html>
<head>	
<?php require PATH_INCLUDES . 'head.php'; ?>
</head>
<body id="body" class="lang<?=Session::get('lang')?> scrollbar">
	<div id="wrapper">
	<?php 
	   require PATH_INCLUDES . 'header.php'; 
	   ?>
	   <div id="container" class="clearfix">
	   	<?php require PATH_INCLUDES . 'menu_left.php'; ?>
	   	<div class="content" id="contents" >
	   		<?php require  $this->_fileView;?>

	   	</div>
		</div>
	   <?php //require PATH_INCLUDES . 'footer.php';?>   
	</div> 
	<?php require PATH_INCLUDES . 'popup.php'; ?> 
</body>
</html>