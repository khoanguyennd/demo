<!doctype html>
<html>
<head>	
<?php require PATH_INCLUDES . 'head.php'; ?>
</head>
<body id="body" class="lang<?=Session::get('lang')?>">
    <?php 
    require PATH_INCLUDES. 'header.php';
    require $this->_fileView;
    require PATH_INCLUDES . 'popup.php'
	?>    
</body>
</html>