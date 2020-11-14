<script type="text/javascript" src="attach/js/webtoolkit.aim.js"></script>
<script type="text/javascript" src="attach/js/myattach.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		// Hàm kiểm tra email và thông báo lỗi
		$.isEmail = function(aemail){
			if(aemail == ''){
				$.fn_alert(true, true, "<?=$this->language('l_inputemail')?>");
				return false;
			}
			if ( $.validateEmail(aemail) == false) {
				$.fn_alert(true, true, "<?=$this->language('l_erremail')?>");
				return false;
			}
			return true;
		}
		// Hàm kiểm tra Codetax và thông báo lỗi
		$.isID = function(aid){
			if(aid){
				if($.validateID(aid) == false){
					$.fn_alert(true, true, "<?=$this->language('l_inputiderr')?>");
					return false;
				}
			}else{
				$.fn_alert(true, true, "<?=$this->language('l_inputid')?>");
				return false;
			}
			return true;
		}
		// Gửi mã code tới email
		$('.btn.sendCode').click(function(){
			// kiểm tra id
			var aid = $('#aid').val();			
			if($.isID(aid) == false){
				return false;
			}
			// Kiểm tra email
			var aemail = $('#aemail').val();
			if($.isEmail(aemail)==false){				
				return false;
			}
			if(aid && aemail){				
				$.fn_ajax('sendCode', {'aemail':aemail, 'newid': aid},function(result){
				    if(result.flag == true){	
				    	$('#aemail').attr('disabled', 'disabled');			    
				    	$.fn_alert(true, true, "<?=$this->language('l_confirmemail')?>");
				    }else{	
				    	$.fn_alert(true, true, "<?=$this->language('l_exitemail')?>");
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
				$.fn_alert(true, true, "<?=$this->language('l_inputcodeconfirm')?>");			
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
		// Thực hiện thêm mới người dùng
		$('#checkID').on('click', function(){
			// kiểm tra id
			var aid = $('#aid').val();		
			if($.isID(aid) == false){			
				return false;
			}else if ( $('#aid').attr('data-check') != 'true' ) {
				$.fn_alert(true, true, "<?=$this->language('l_warnid2')?>");
				return false;
			}else{
				$.fn_alert(true, true, "사용가능");
			}
		});
		// Thực hiện thêm mới người dùng
		$('input#signup').click(function(){
			// kiểm tra id
			var aid = $('#aid').val();			
			if($.isID(aid) == false){
				return false;
			}			
			if ( $('#aid').attr('data-check') != 'true' ) {
				$.fn_alert(true, true, "<?=$this->language('l_warnid2')?>");
				return false;
			}
			
			// Kiểm tra password
			var apw = $('#apw').val();
			var capw = $('#capw').val();
			if(apw != capw){
				$.fn_alert(true, true, "<?=$this->language('l_warnpw3')?>");
				return false;
			}
			if($.validatePW(apw) == false){
				$.fn_alert(true, true, "<?=$this->language('l_warnpw2')?>");
				return false;
			}
			var arperson=$('#arperson').val();
			if ( arperson == "" ) {
				$.fn_alert(true, true, "<?=$this->language('l_inputperson_responsible')?>");
				return false;
			}
			var aphone=$('#aphone').val();
			if (aphone == "" ) {
				$.fn_alert(true, true, "<?=$this->language('l_inputphone')?>");
				return false;					
			}
			var aemail=$('#aemail').val();
			if($.isEmail(aemail) == false){
				return false;
			}
			if($('#accode').val() == ''){
				$.fn_alert(true, true, "<?=$this->language('l_inputcodeconfirm')?>");
				return false;
			}			
			if ( $('#accode').attr('data-check') != 'true' ) {
				$.fn_alert(true, true, "<?=$this->language('l_warnemail1')?>");
				return false;
			}
			var acompany=$('#acompany').val();
			if ( acompany == "" ) {
				$.fn_alert(true, true, "<?=$this->language('l_inputcompany')?>");
				return false;
			}
			var asperson=$('#asperson').val();	
			if ( asperson == "" ) {
				$.fn_alert(true, true, "<?=$this->language('l_inputperson_surrogate')?>");
				return false;
			}
			var acareer1=$('#acareer1').val();	
			var acareer2=$('#acareer2').val();	
			if ( acareer1 == "" ) {
				$.fn_alert(true, true, "<?=$this->language('l_inputcareer')?>");
				return false;
			}
			if ( acareer2 == "" ) {
				$.fn_alert(true, true, "<?=$this->language('l_inputcareer')?>");
				return false;
			}
			var abank = $('#abank').val();
			if(abank == 0){
				$.fn_alert(true, true, "<?=$this->language('l_abankname')?>");
				return false;
			}
			var abankname = $('#abankname').val();
			if(abankname == ""){
				$.fn_alert(true, true, "<?=$this->language('l_inputabank')?>");
				return false;
			}
			var abanknumber = $('#abanknumber').val();
			if(abanknumber == ""){
				$.fn_alert(true, true, "<?=$this->language('l_inputabanknumber')?>");
				return false;
			}
			var formdata = new FormData(); 
			var fileupload = $("#change_files")[0].files[0];
			formdata.append("fileupload", fileupload);
			if(formdata.get('fileupload')=='undefined'){
            	$.fn_alert(true, true, "<?=$this->language('l_erraccountbankupload')?>");
				return false;
            }
            formdata.append("aid", aid);
            formdata.append("apw", apw);
            formdata.append("aphone", aphone);
            formdata.append("aemail", aemail);
            formdata.append("acompany", acompany);
            formdata.append("arperson", arperson);
            formdata.append("asperson", asperson);
            formdata.append("acareer1", acareer1);
            formdata.append("acareer2", acareer2);
            formdata.append("abank", abank);
            formdata.append("abankname", abankname);
            formdata.append("abanknumber", abanknumber);
            $.fn_ajax_upload_file('signupStep2', formdata, function(result){
            	if(result.flag == true) {               		
               		$.fn_alert(true, true, "<?=$this->language('l_warnsignup2')?>");	
               		$($.elt_popup).find('.alert').addClass('autologin');				
               	}else{
                   	if(result.error){
                   		$.fn_alert(true, true, result.error);                   		
                   	}else{
                   		$.fn_alert(true, true, "<?=$this->language('l_warnsignup1')?>");
                   	}
               	}  
            });				
			return false;			
		});
	});
	
</script>
<div class="signup_area">
	<div class="signup_area_content" id="DivloginSoho" >
		<div class="signup_head">
			<div class="signup_title">
				<h1><?=$this->language('l_titlesignup')?></h1>
			</div>			
			<div class="signup_step clearfix">
				<div class="step_item clearfix">
					<div class="item_number">
						<span>1</span>
					</div>
					<div class="item_text">
						<h3><?=$this->language('l_top01')?></h3>
						<p><?=$this->language('l_top03')?></p>
					</div>
				</div>
				<div class="step_item active clearfix">
					<div class="item_number">
						<span>2</span>
					</div>
					<div class="item_text">
						<h3><?=$this->language('l_top02')?></h3>
						<p><?=$this->language('l_top04')?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="signup_form">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="form_group clearfix" style="margin-bottom: 25px;">
					<fieldset>
						<legend><?=$this->language('l_titleusetbridge')?></legend>
						<div class="form_group clearfix">
							<div class="form_item col-xs-3">
								<h3><?=$this->language('l_id')?></h3>
							</div>
							<div class="form_item col-xs-5">
								<div class="inputconfirm">
									<input type="text" name="aid" id="aid" class="input full checkID" autocomplete="off">
								</div>								
								<p class="note"><?=$this->language('l_warnid')?></p>
							</div>
							<div class="form_item col-xs-4 align-left">
								<input id="checkID" type="button" value="중복확인" class="btn hover" />
							</div>	
						</div>
						<div class="form_group clearfix">
							<div class="form_item col-xs-3">
								<h3><?=$this->language('l_password')?></h3>
							</div>
							<div class="form_item col-xs-5">
								<div class="inputconfirm">
									<input name="apw" id="apw" type="password" value="" class="input full checkPW" autocomplete="off">
								</div>								
								<p class="note"><?=$this->language('l_warnpassword')?></p>
							</div>
							<div class="form_item col-xs-4" style="padding-top: 10px;text-align: left;"> 
            					<p class="note" id="warnpassword" style="color: #f9933b"></p>
            				</div>
						</div>
						<div class="form_group clearfix">
							<div class="form_item col-xs-3">
								<h3><?=$this->language('l_confirmpassword')?></h3>
							</div>
							<div class="form_item col-xs-5">
								<div class="inputconfirm">
									<input name="capw" id="capw" type="password" class="input full confirmPW" autocomplete="off" value="">
								</div>								
							</div>
							<div class="form_item col-xs-4" style="padding-top: 10px;text-align: left;"> 
            					<p class="note" id="warncpassword" style="color: #f9933b"></p>
            				</div>	
						</div>
					</fieldset>	
				</div>
				<div class="form_group clearfix" style="margin-bottom: 25px;">
					<fieldset>
						<legend><?=$this->language('l_titlepersonresponsible')?></legend>
						<div class="form_group clearfix">
							<div class="form_item col-xs-3">
								<h3><?=$this->language('l_person_responsible')?></h3>
							</div>
							<div class="form_item col-xs-5">
								<div class="inputconfirm">
									<input type="text" class="input full checkEmpty checkMaxLength" maxlength="10" value="" name="arperson" id="arperson" autocomplete="off" data-text="<?=$this->language('l_warnname')?>">
								</div>								
							</div>
							<div class="form_item col-xs-4">
								<p class="height1 align-left checkMaxLengthView">0/10 <?=$this->language('l_warnname')?></p>
							</div>
						</div>
						<div class="form_group clearfix">
							<div class="form_item col-xs-3">
								<h3><?=$this->language('l_phone')?></h3>
							</div>
							<div class="form_item col-xs-5">
								<div class="inputconfirm">
									<input type="text" class="input full checkEmpty v-numeric" name="aphone" id="aphone" autocomplete="off">
								</div>
							</div>
							<div class="form_item col-xs-4"></div>	
						</div>
						<div class="form_group clearfix">
							<div class="form_item col-xs-3">
								<h3 class="height2"><?=$this->language('l_email')?></h3>
							</div>
							<div class="form_item col-xs-5">
								<div class="inputconfirm">
									<input type="text" name="aemail" id="aemail" class="input full checkEmail" autocomplete="off" placeholder="">									
								</div>
								<p class="note"><?=$this->language('l_warnemail2')?></p>
								<div class="inputconfirm">
									<input type="text" class="input full" name="accode" id="accode" autocomplete="off" placeholder="이메일로 보낸 인증번호를 입력하세요">
								</div>								
							</div>							
							<div class="form_item col-xs-4 align-left">								
								<input type="button" class="btn hover sendCode" style="width: 150px;" value="<?=$this->language('l_sendcodeconfirm')?>">
								<p style="color: transparent;">hidden</p>
								<input type="button" class="btn hover codeConfirm" style="width: 150px;" value="<?=$this->language('l_confirmcodeconfirm')?>">
							</div>	
						</div>
					</fieldset>	
				</div>
				<div class="form_group clearfix" style="margin-bottom: 25px;">
					<fieldset>
						<legend><?=$this->language('l_titlecompany')?></legend>
						<div class="form_group clearfix">
							<div class="form_item col-xs-3">
								<h3><?=$this->language('l_company')?></h3>
							</div>
							<div class="form_item col-xs-5">
								<div class="inputconfirm">
									<input type="text" class="input full checkEmpty checkMaxLength" name="acompany" id="acompany" maxlength="50" data-text="<?=$this->language('l_warnname')?>">
								</div>
							</div>
							<div class="form_item col-xs-4">
								<p class="height1 align-left checkMaxLengthView">0/50 <?=$this->language('l_warnname')?></p>	
							</div>	
						</div>
						<div class="form_group clearfix">
							<div class="form_item col-xs-3">
								<h3><?=$this->language('l_person_surrogate')?></h3>
							</div>
							<div class="form_item col-xs-5">
								<div class="inputconfirm">
									<input type="text" class="input full checkEmpty checkMaxLength" maxlength="10" name="asperson" id="asperson" data-text="<?=$this->language('l_warnname')?>">
								</div>
							</div>
							<div class="form_item col-xs-4">
								<p class="height1 align-left checkMaxLengthView">0/10 <?=$this->language('l_warnname')?></p>
							</div>	
						</div>
						<div class="form_group clearfix">
							<div class="form_item col-xs-3">
								<h3><?=$this->language('l_codetax')?></h3>
							</div>
							<div class="form_item col-xs-5">
								<input type="text" class="input full" value="<?=Session::get('atax')?>" disabled="disabled">
							</div>
							<div class="form_item col-xs-4"></div>	
						</div>
						<div class="form_group clearfix">
							<div class="form_item col-xs-3">
								<h3 class="height2">업태/업종</h3>
							</div>
							<div class="form_group">
								<div class="form_item col-xs-5" style="margin-top: 5px;">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty checkMaxLength" name="acareer1" id="acareer1" placeholder="업태를 입력하세요." maxlength="50" data-text="<?=$this->language('l_warnname')?>">
									</div>
								</div>
								<div class="form_item col-xs-4">
									<p class="height1 align-left checkMaxLengthView">0/50 <?=$this->language('l_warnname')?></p>
								</div>
							</div>
							<div class="form_group">
								<div class="form_item col-xs-5">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty checkMaxLength" name="acareer2" id="acareer2" placeholder="업종을 입력하세요." maxlength="50" data-text="<?=$this->language('l_warnname')?>">
									</div>
								</div>
								<div class="form_item col-xs-4">
									<p class="height1 align-left checkMaxLengthView">0/50 <?=$this->language('l_warnname')?></p>
								</div>
							</div>
						</div>
						<div class="form_group clearfix">
							<div class="form_item col-xs-3">
								<h3 class="height3">계좌정보</h3>
							</div>
							<div class="form_item col-xs-5">
								<select class="select small full" id="abank">
									<option value="0">은행명을 선택하세요</option>
								
									<?php 
									   $listbank = $this->getData('listbank');
										foreach ($listbank as $key => $value) {?>
										<option value="<?=$value['id']?>" ><?=$value['name']?></option>
										<?php }?>
								</select>
								<div class="inputconfirm">
									<input type="text" class="input full checkEmpty" name="abankname" id="abankname" placeholder="<?=$this->language('l_inputabank')?>">
								</div>
								<div class="inputconfirm">
									<input type="text" class="input full checkEmpty" name="abanknumber" id="abanknumber" placeholder="<?=$this->language('l_inputabanknumber')?>">
								</div>
							</div>
							<div class="form_item col-xs-4" style="display: none">
								<p class="height3">
									<input type="button" class="btn hover" style="width: 150px" value="<?=$this->language('l_inputabankconfirm')?>">
								</p>
							</div>	
						</div>
						<div class="form_group clearfix">
							<div class="form_item col-xs-3">
								<h3><?=$this->language('l_accountimagebank')?></h3>
							</div>
							<div class="form_item col-xs-2">
								<label for="change_files" class="btn full height1"><?=$this->language('l_accountbankupload')?></label>
		  						<input id="change_files" style="display: none;" name="file" style="visibility:hidden;" type="file" accept="application/pdf,image/*">
		  						<script type="text/javascript">
		  							$("#change_files").change(function() {
		  								$('#load_file_name p').html(this.files[0].name);
									});
		  						</script>
							</div>
							<div class="form_item col-xs-7" id="load_file_name">
								<p class="height1 align-left"><!-- <?=$this->language('l_rulefile01')?> --></p>
							</div>	
						</div>
					</fieldset>	
				</div>								
				<div class="form_group clearfix">
					<div class="form_item col-xs-12" style="text-align: center;">
						<input type="hidden" class="btn login small" onclick="window.location.assign('<?=$this->route('login')?>');">
						<input type="button" class="btn hover small" value="<?=$this->language('l_back')?>" onclick="window.location.assign('<?=$this->route('signupStep1')?>');">
						<input type="button" class="btn hover small" id="signup" value="<?=$this->language('l_signup')?>">
					</div>	
				</div>
			</form>
		</div>
	</div>
</div>