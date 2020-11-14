<!DOCTYPE html>
<html>
    <head>
        <title><?= $this->language('l_tbbida') ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/8aee9abc8a.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="<?= URL_PUBLIC ?>css/customer.css" />
        <!--<link rel="stylesheet" type="text/css" href="<?= URL_PUBLIC ?>bootstrap/css/bootstrap.css">-->
        <link rel="stylesheet" type="text/css" href="<?= URL_PUBLIC ?>bootstrap/css/bootstrap.min.css"> 
        <link rel="stylesheet" type="text/css" href="<?= URL_PUBLIC ?>style.css">
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&family=Roboto:wght@300;400&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">   
		 
        <script type="text/javascript" src="<?= URL_PUBLIC ?>js/jquery-3.5.1.min.js"></script> 
        <script type="text/javascript" src="<?= URL_PUBLIC ?>bootstrap/js/bootstrap.js"></script>   
        <script type="text/javascript" src="<?= URL_PUBLIC ?>js/jquery.main.min.js"></script>
        <script type="text/javascript" src="<?= URL_PUBLIC ?>js/jquery.validate.js"></script>
        <script type="text/javascript" src="<?= URL_PUBLIC ?>js/jquery.blockUI.min.js"></script>
        <script type="text/javascript" src="<?= URL_PUBLIC ?>js/jquery.countdown.min.js"></script>
        <script type="text/javascript" src="<?= URL_PUBLIC ?>js/customer.js"></script>
        
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
            <?php echo 'jsData=' . json_encode($this->getData('jsData')); ?>            
            var $baseUrl = "<?= URL_BASE; ?>";
        </script>
        <script src="<?= URL_PUBLIC ?>js/hangul.js"></script>
        <script src="<?= URL_PUBLIC ?>js/vietuni.js"></script>
        <script type="text/javascript">
        let play = function(){document.getElementById("audio").play()};
        let play1 = function(){document.getElementById("video").play()};
        </script>
        <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'KR') { ?>
            <!-- load font KR -->
            <style>
                body {font-family: 'Nanum Gothic', 'Roboto', sans-serif;}
                @font-face { 
                        font-family: 'NanumGothic';
                        src: url('<?= URL_BASE ?>/public/font/NanumGothic.eot');
                        src: url('<?= URL_BASE ?>/public/font/NanumGothic.eot') format('embedded-opentype'),
                        url('<?= URL_BASE ?>/public/font/NanumGothic.woff') format('woff');
                }
                .divlangkr{font-family: 'NanumGothic';}
            </style>
        <?php }?>  
    </head>
    <body>
        <input type="hidden" id="pos_number" value=""/>
        <input type="hidden" id="pos_char" value=""/>     
        <?php include_once(PATH_APPLICATION . 'view/popup/home.php') ?>
        <?php require  $this->_fileView; ?>                
    </body>
</html>