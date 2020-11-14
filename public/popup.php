<!doctype html>
<html>
<head>	
<?php require PATH_INCLUDES . 'head.php'; ?>
</head>
<body id="body" class="lang<?=Session::get('lang')?>">
	<div id="wrapper">

	   <div id="container" class="clearfix">
	   	<div class="content" id="contents" style="width: 100%;height: auto;" >
	   		<?php require  $this->_fileView;?>	
	   	</div>
		</div>
	</div> 
	<?php require PATH_INCLUDES . 'popup.php'; ?>
</body>
</html>