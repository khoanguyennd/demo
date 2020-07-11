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
			//alert(acodetax+"a"+aemail);
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
<?php 
$ID="";
if(isset($_COOKIE['accountshopping']['ID']))
    $ID=$_COOKIE['accountshopping']['ID'];
?>

<div class="t_page_login" id="login_area">
    <div class="t_logo">     
		<img src="<?=URL_PUBLIC?>temple_mobile/img/tbridge.jpg" alt=""/>
        <h2><?=$this->language('l_tbridge')?><!--티브리지--></h2>
        <p><?=$this->language( 'l_titlelogin')?><!--여행 / 티켓 판매자를 위한 통합솔루션--></p>
    </div>
    <form action="" method="POST">
    <div class="t_form_login">
        <div class="div_input_name">
            <input type="text" name="acodetax" id="acodetax" autofocus="" placeholder="<?=$this->language('l_codetax')?> : 111-11-11111" autocomplete="off"  />
        </div>
        <div class="div_input_name">
            <input type="text"  name="aemail" id="aemail" data-true="true" placeholder="회원가입시 입력한 이메일주소를 입력하세요." autocomplete="off"  />
        </div>
        <p style="color: red;margin-top: -5px;padding-bottom: 10px;text-align: center;"><?=$this->getData('error');?></p>
        <!-- <div class="form_item col-xs-4">
						<input type="button" class="btn hover full sendCode" value="<?=$this->language('l_sendcodeconfirm')?>">	
						<input type="button" class="btn hover full codeConfirm" value="<?=$this->language('l_confirmcodeconfirm')?>">
					</div> -->
        <div class="div_input_submit">
            <input class="t_btn_submit_login" type="submit" name="" value="<?=$this->language('l_findid')?>" />
        </div>

        <div class="cl"></div>
    </div>
    </form>
    <div style="text-align: center;">  
        <input class="t_p_button" type="button" value="<?=$this->language( 'l_login')?>" onclick="window.location.assign('<?=$this->route('login')?>');" />
        <input class="t_p_button" type="button" value="<?=$this->language( 'l_findpw')?>" onclick="window.location.assign('<?=$this->route('findpw')?>');" />
        <input class="t_p_pcversion" type="button" value="PC version" />
    </div>
    <div class="cl"></div>
</div>


