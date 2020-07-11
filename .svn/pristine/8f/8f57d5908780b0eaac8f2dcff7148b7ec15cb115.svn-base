<?php
if (isset($_REQUEST['filepath']) && isset($_REQUEST['filename']) && isset($_REQUEST['filetype'])) {
	header("Content-disposition: attachment; filename=".rawurlencode($_REQUEST['filename'])."");
	header('Content-type: '.$_REQUEST['filetype']);
	readfile('upload/'.$_REQUEST['filepath']);
}
?>