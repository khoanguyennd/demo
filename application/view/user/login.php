
<script type="text/javascript">
	$(document).ready(function(){
		$('#login_area form').submit(function(){
			var aid = $('#aid').val();
			var caid = $('#aid').attr('data-check');
			var apw = $('#apw').val();
			var capw = $('#apw').attr('data-check');
			
			if(aid == ''){
				$.fn_alert(true, true, "<?=$this->language( 'l_inputid')?>");
				return false;
			}					
			if ( apw == "" ) {
				$.fn_alert(true, true, "<?=$this->language( 'l_inputpw')?>");				
				return false;
			}
			
			if(caid == 'false' || capw == 'false'){ 
				return false;
			}
			return true;
		});
	    // login_banner();
	    console.log(uhs);
	});	

	
</script>
<?php 
$ID="";
if(isset($_COOKIE['accountshopping']['ID']))
    $ID=$_COOKIE['accountshopping']['ID'];
?>
<div id="login_area">
	<div class="login_content">
		<div class="login_head">
			<a href="http://localhost/tbridge/" style="color: #fff"><h1><?=$this->language('l_tbridge')?></h1></a>
			<p><?=$this->language( 'l_titlelogin')?></p>
		</div>
		<div class="login_form">
			<form action="" method="POST">
				<div class="form_group">
					<div class="form_item">
						<div class="inputconfirm">
							<input type="text" name="aid" id="aid" class="input full checkIDLogin" data-true="true" placeholder="<?=$this->language( 'l_id')?>" value="<?=$ID?>">
						</div>
					</div>
				</div>
				<div class="form_group">
					<div class="form_item">
						<div class="inputconfirm">
							<input type="password" name="apw" id="apw" class="input full" autocomplete="off" placeholder="<?=$this->language( 'l_password')?>">
						</div>
					</div>
					<p class="form_item_error"><?=$this->getData('error');?></p>
				</div>
				<div class="form_group">
					<div class="form_item">
						<input id="achecked" type="checkbox" name="achecked" >
						<label for="achecked"><?=$this->language( 'l_saveid')?></label>
					</div>
				</div>			
				<div class="form_group">
					<div class="form_item" style="text-align: center;">
						<input type="submit" class="btn full hover login" name="" value="<?=$this->language( 'l_login')?>" <?php if(!isset($_COOKIE['accountshopping']['ID'])) echo 'disabled="disabled"'; ?> >
					</div>	
				</div>
				<div class="form_group clearfix">
					<div class="form_item col-xs-4" style="text-align: center;">
						<input type="button" class="btn full hover active" value="<?=$this->language( 'l_findid')?>" 
								onclick="window.location.assign('<?=$this->route('findid')?>');" >
						
					</div>	
					<div class="form_item col-xs-4" style="text-align: center;">
						<input type="button" class="btn full hover active" value="<?=$this->language( 'l_findpw')?>" 
								onclick="window.location.assign('<?=$this->route('findpw')?>');">
					</div>
					<div class="form_item col-xs-4" style="text-align: center;">
						<input type="button" class="btn full hover active" value="<?=$this->language( 'l_signup')?>" 
								onclick="window.location.assign('<?=$this->route('signupStep1')?>');">
					</div>
				</div>
			</form>
			
		</div>
	</div>
</div>