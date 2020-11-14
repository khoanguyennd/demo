<!DOCTYPE html>
<html>
    <head>
    	<title><?= $this->language('l_tbbida') ?></title>
    	<meta charset="utf-8">
    	<!-- <link rel="stylesheet" type="text/css" href="<?= URL_PUBLIC ?>bootstrap/css/bootstrap.css">-->
    	<link rel="stylesheet" type="text/css" href="<?= URL_PUBLIC ?>bootstrap/css/bootstrap.min.css">
    	<link rel="stylesheet" type="text/css" href="<?= URL_PUBLIC ?>style.css">
        <link rel="stylesheet" type="text/css" href="<?= URL_PUBLIC ?>css/customer.css" />
    	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Roboto:wght@300;400&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
        <script src="<?= URL_PUBLIC ?>js/jquery-3.5.1.min.js"></script> 
        <script src="<?= URL_PUBLIC ?>js/jquery.main.min.js"></script>
        <script src="<?= URL_PUBLIC ?>js/jquery.validate.js"></script>
        <script src="<?= URL_PUBLIC ?>js/jquery.blockUI.min.js"></script>
        <script src="<?= URL_PUBLIC ?>js/jquery.countdown.min.js"></script>
        <script src="<?= URL_PUBLIC ?>js/customer.js"></script>
        <script src="<?= URL_PUBLIC ?>js/hangul.js"></script>
        <script src="<?= URL_PUBLIC ?>js/vietuni.js"></script>
        <script>
            <?php echo 'jsData=' . json_encode($this->getData('jsData')); ?>
        </script>
        <script type="text/javascript">
            <?php 
            if (isset($_SESSION['lang'])){ 
                if($_SESSION['lang']=="VN"){
                    $lang="vn";
                }
                if($_SESSION['lang']=="EN"){
                    $lang="en";
                }
                if($_SESSION['lang']=="KR"){
                    $lang="kr";
                }
            }else{
                $lang="en";
            }?>
            var lang="<?=$lang?>";
        </script>
        <script type="text/javascript">
            var $baseUrl = "<?= URL_BASE; ?>";
        </script>
    	<?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'KR') { ?>
            <!-- load font KR -->
            <style>
                body {
                    
                    font-family: 'Nanum Gothic', 'Roboto', sans-serif;
                }
            </style>
        <?php }?>  
    </head>
    <body>
        <input type="hidden" id="pos_number" value=""/>
        <input type="hidden" id="pos_char" value=""/>
    	<div class="container-fluid">
    		<div class="row">
    			<div class="col-md-12" style="margin: 50px 0 250px 0; text-align: center;">
    				<img src="<?= URL_PUBLIC ?>images/logo.png" alt="Billiard">
    			</div>
    		</div>
                    <?php require  $this->_fileView; ?>		
    	</div>
        <div class="div_load_alert">
            <div class="main_mess">
                <p><?= $this->language("l_main_mess") ?></p>
                <img style="width: 200px;" src="<?= URL_PUBLIC ?>img/load.gif" />
            </div>
        </div>
    <script type="text/javascript" src="<?= URL_PUBLIC ?>bootstrap/js/bootstrap.js"></script>
    </body>
</html>