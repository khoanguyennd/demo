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
		$.isID = function(aid){
			if(aid){
				if($.validateID(aid) == false){
					$.fn_alert(true, true, "<?=$this->language( 'l_inputiderr')?>");
					return false;
				}
			}else{
				$.fn_alert(true, true, "<?=$this->language( 'l_inputid')?>");
				return false;
			}
			return true;
		}
		// Gửi mã code tới email
		$('.btn.sendCode').click(function(){
			var aid = $('#aid').val();
			var aemail = $('#aemail').val();
			if($.isID(aid)==false){
				return false;
			}
			if($.isEmail(aemail)==false){				
				return false;
			}
			if(aid && aemail){				
				$.fn_ajax('sendCode', {'aid':aid, 'aemail':aemail},function(result){
				    if(result.flag == true){				    
				    	$('.login_form').find('.codeConfirm').removeAttr("disabled");
				    	$.fn_alert(true, true, "<?=$this->language( 'l_confirmemail')?>");
				    }else{	
				    	$.fn_alert(true, true, "<?=$this->language( 'l_errIDemail')?>");
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
					if(result.flag == true){
						$('.login_form').find('.findpw').removeAttr("disabled");
						$.fn_alert(true, true, "인증이 성공되었습니다.");
					}else{
						$('.login_form').find('.findpw').attr("disabled", "disabled");
						
						$.fn_alert(true, true, "인증번호를 정확히 입력하세요.");
					}
					$.fn_check($('#accode'), result.flag);
				});
			}else{
				$.fn_check($('#accode'), false);
			}
		});
		// Thực hiện tìm id
		$('#login_area form').submit(function(){
			var acode = $('#accode').val();
			var aid = $('#aid').val();
			var aemail = $('#aemail').val();
			if($.isID(aid)==false){
				return false;
			}
			if($.isEmail(aemail)==false){
				return false;
			}
			if(acode == ''){
				$.fn_alert(true, true, "<?=$this->language('l_inputcodeconfirm')?>");			
				return false;
			}
			if($('#accode').attr('data-check')=='true'){
				if(acode && aid && aemail){
					$.fn_ajax('findpw', {'aconfirm':acode, 'aemail': aemail, 'aid':aid}, function(result){								
						if(result.flag == true){
							$.fn_popup(true, 'password',true);
							$($.elt_popup).find('.password input[name="password"]').focus();
					    }else{
					    	$.fn_alert(true, true, "<?=$this->language( 'l_errcodeconfirm')?>");	
					    }	
					});
				}		
			}else{
				$.fn_alert(true, true, "<?=$this->language( 'l_warnemail1')?>");
			}
			return false;			
		});		
		// Thực hiện thay đổi password
		$($.elt_popup).on('submit', '.password form', function(){
			var pass = $(this).find('input[name="password"]').val();
			var cpass = $(this).find('input[name="confirmpassword"]').val();

			if ($.validatePW(pass)){
				if(pass == cpass){
					$.fn_ajax('changepw', {'password':pass}, function(result){					
						if(result.flag == true){
							$.fn_popup(false, 'password', true);
							$.fn_alert(true, true, "<?=$this->language( 'l_warnpw5')?>");
							$($.elt_popup).find('.alert').addClass('autologin');
					    }else{
					    	$.fn_alert(true, false, "<?=$this->language( 'l_warnpw4')?>");	
					    }	
					});
				}else{
					$.fn_alert(true, true, "<?=$this->language('l_warnpw3')?>");
				}	
			}else{
				$.fn_alert(true, true, "<?=$this->language('l_warnpassword')?>");
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
						<input type="button" class="btn full hover" value="<?=$this->language('l_findid')?>" onclick="window.location.assign('<?=$this->route('findid')?>');">
					</div>					
					<div class="form_item col-xs-6" style="text-align: center;">
						<input type="button" class="btn full hover active" value="<?=$this->language('l_findpw')?>" onclick="window.location.assign('<?=$this->route('findpw')?>');">
					</div>
				</div>
				<div class="form_group" style="padding-top: 20px;">
					<div class="form_item">
						<div class="inputconfirm">
							<input type="text" name="aid" id="aid" class="input full checkID" data-true="true" placeholder="<?=$this->language('l_id')?>" autocomplete="off">
						</div>						
					</div>
				</div>
				<div class="form_group clearfix">
					<div class="form_item col-xs-8">
						<div class="inputconfirm">
							<input type="text" name="aemail" id="aemail" class="input full checkEmail" placeholder="회원가입시 입력한 이메일주소를 입력하세요." autocomplete="off">
						</div>						
						<div class="inputconfirm">
							<input type="text" class="input full" name="accode" id="accode" autocomplete="off" placeholder="이메일로 보낸 인증번호를 입력하세요.">
						</div>								
					</div>
					<div class="form_item col-xs-4">
						<input type="button" class="btn hover full sendCode" value="<?=$this->language('l_sendcodeconfirm')?>">	
						<input type="button" class="btn hover full codeConfirm" value="<?=$this->language('l_confirmcodeconfirm')?>" disabled="disabled">
					</div>
				</div>
				<div class="form_group">
					<div class="form_item">					
						<p class="form_item_error" id="showError"><?=$this->getData('error');?></p>
					</div>
				</div>						
				<div class="form_group">
					<div class="form_item" style="text-align: center;">
						<input type="submit" class="btn full hover findpw" name="" value="이용자 확인" disabled="disabled">
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