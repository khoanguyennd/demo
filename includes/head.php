<title>T-BRIDGE</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
<link href="<?=URL_PUBLIC?>multiselect/styles/multiselect.css" rel="stylesheet" />
<script src="<?=URL_PUBLIC?>multiselect/multiselect.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=URL_PUBLIC?>css/reset.css">
<link rel="stylesheet" type="text/css" href="<?=URL_PUBLIC?>css/site.css">
<link rel="stylesheet" type="text/css" href="<?=URL_PUBLIC?>css/default.css">
<?php if( $_SESSION['mobile']!=0){?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?=URL_PUBLIC?>temple_mobile/css/style.css">
<?php }?>
<script src="<?=URL_PUBLIC?>js/jquery-1.9.1.js"></script>
<script src="<?=URL_PUBLIC?>js/fontawesome.js"></script>
<script><?php echo 'jsData='.json_encode($this->getData('jsData'));?></script>
<script src="<?=URL_PUBLIC?>js/jquery.main.min.js"></script>
