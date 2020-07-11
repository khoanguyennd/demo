<script type="text/javascript">
	$( document ).ready(function() {
		// Hàm kiểm tra email và thông báo lỗi
		$.isEmail = function(aemail){
			if(aemail == ''){
				$.fn_alert(true, true, "<?=$this->language( 'l_inputemail')?>");
				return false;
			}
			if ( $.validateEmail(aemail) == false) {
				$.fn_alert(true, true, "<?=$this->language( 'l_erremail')?>");
				return false;
			}
			return true;
		}
		// Hàm kiểm tra Codetax và thông báo lỗi
		$.isCodetax = function(acodetax){
			if(acodetax){
				if($.validateCodetax(acodetax) == false){
					$.fn_alert(true, true, "<?=$this->language( 'l_errorcodetax')?>");
					return false;
				}
			}else{
				$.fn_alert(true, true, "<?=$this->language( 'l_inputcodetax')?>");
				return false;
			}
			return true;
		}
		// Gửi mã code tới email
		$('.btn.sendCode').click(function(){
			var acodetax = $('#acodetax').val();
			var aemail = $('#aemail').val();
			if($.isCodetax(acodetax)==false){
				return false;
			}
			if($.isEmail(aemail)==false){				
				return false;
			}
			if(acodetax && aemail){				
				$.fn_ajax('sendCode', {'acodetax':acodetax, 'aemail':aemail},function(result){
					//console.log(result);
				    if(result.flag == true){				    
				    	$.fn_alert(true, true, "<?=$this->language( 'l_confirmemail')?>");
				    }else{	
				    	$.fn_alert(true, true, "<?=$this->language( 'l_errcodetaxemail')?>");
				    	
				    }			 
				});
			}
			return false;
		});
		// Kiểm tra mã code được gửi qua email trùng khớp
		$('.btn.codeConfirm').on('click',function(){
			var aemail = $('#aemail').val();
			var accode = $('#accode').val();			
			if($.isEmail(aemail) == false){
				return false;
			}
			if(accode == ''){
				$.fn_alert(true, true, "<?=$this->language( 'l_inputcodeconfirm')?>");			
				return;
			}
			if(aemail && accode){
				$.fn_ajax('checkCode', {'accode':accode, 'aemail':aemail}, function(result){					
					$.fn_check($('#accode'), result.flag);
				}, true);
			}else{
				$.fn_check($('#accode'), false);
			}
		});
		// Thực hiện tìm id
		$('#login_area form').submit(function(){
			var acodetax = $('#acodetax').val();
			var aemail = $('#aemail').val();
			if($.isCodetax(acodetax)==false){
				return false;
			}
			if($.isEmail(aemail)==false){
				return false;
			}

			if(acodetax && aemail){
				$.fn_ajax('findid', {'aemail': aemail, 'acodetax':acodetax}, function(result){					
					if(result.flag == true){
						$.fn_alert(true, true, "<?=$this->language( 'l_yourid')?><strong>"+result.id+"</strong>");
						$($.elt_popup).find('.popupClose').val("로그인하기 ");
						$($.elt_popup).find('.alert').addClass('autologin');
				    }else{
				    	$.fn_alert(true, true, "<?=$this->language( 'l_errcodetaxemail')?>");	
				    }	
				});
			}		

			return false;			
		});			
	});
</script>
<div id="login_area">
	<div class="login_content">
		<div class="login_head">
			<h1><?=$this->language('l_tbridge')?></h1>
			<p><?=$this->language( 'l_titlelogin')?></p>
		</div>
		<div class="login_form">
			<form action="" method="POST">
				<div class="form_group clearfix">
					<div class="form_item col-xs-6" style="text-align: center;">
						<input type="button" class="btn full hover active" value="<?=$this->language('l_findid')?>" onclick="window.location.assign('<?=$this->route('findid')?>');">
					</div>					
					<div class="form_item col-xs-6" style="text-align: center;">
						<input type="button" class="btn full hover" value="<?=$this->language('l_findpw')?>" onclick="window.location.assign('<?=$this->route('findpw')?>');">
					</div>
				</div>
				<div class="form_group" style="padding-top: 20px;">
					<div class="form_item">
						<div class="inputconfirm">
							<input type="text" name="acodetax" id="acodetax" class="input full checkCodetax" autofocus="" placeholder="<?=$this->language('l_codetax')?> : 111-11-11111" autocomplete="off">
						</div>						
					</div>
				</div>
				<div class="form_group clearfix">
					<div class="form_item">
						<div class="inputconfirm">
							<input type="text" name="aemail" id="aemail" class="input full checkEmail" autofocus="" placeholder="회원가입시 입력한 이메일주소를 입력하세요." autocomplete="off">
						</div>						
						<!--  <div class="inputconfirm">
							<input type="text" class="input full codeConfirm" name="accode" id="accode" autocomplete="off" placeholder="이메일로 보낸 인증번호를 입력하세요.">
						</div>	-->							
					</div>
					<!-- <div class="form_item col-xs-4">
						<input type="button" class="btn hover full sendCode" value="<?=$this->language('l_sendcodeconfirm')?>">	
						<input type="button" class="btn hover full codeConfirm" value="<?=$this->language('l_confirmcodeconfirm')?>">
					</div> -->
				</div>
				<div class="form_group">
					<div class="form_item">					
						<p class="form_item_error"><?=$this->getData('error');?></p>
					</div>
				</div>						
				<div class="form_group">
					<div class="form_item" style="text-align: center;">
						<input type="submit" class="btn full hover findid" name="" value="<?=$this->language('l_findid')?>" disabled="disabled">
					</div>	
				</div>
				<div class="form_group clearfix">
					<div class="form_item col-xs-6" style="text-align: center;">
						<input type="button" class="btn full hover active login" value="<?=$this->language('l_login')?>" onclick="window.location.assign('<?=$this->route('login')?>');">
					</div>					
					<div class="form_item col-xs-6" style="text-align: center;">
						<input type="button" class="btn full hover active signup" value="<?=$this->language('l_signup')?>" onclick="window.location.assign('<?=$this->route('signupStep1')?>');">
					</div>
				</div>
			</form>
			
		</div>
	</div>
</div>