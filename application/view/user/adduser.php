<?php
$inputYn = "N";
if (isset($_POST['frmsubmit'])) {
    $inputYn = "Y";
}

$account = $_SESSION['accountshopping'];
$usersell = $this->getData('usersell');
$user = $this->getData('user');
$listbank = $this->getData('listbank');
$aID = "";
$arperson = "";
$aemail = "";
$aphone = "";
$acompany = "";
$asperson = "";
$atax = array();
$atax[0] = "";
$atax[1] = "";
$atax[2] = "";
$acareer1 = "";
$acareer2 = "";
$abank = 0;
$abankname = "";
$abanknumber = "";
$nrole = "";
$role = 0;
$idx_parent = 0;
if ($user) {
    $aID = $user["ID"];
    $arperson = $user["rperson"];
    $aemail = $user["email"];
    $aphone = $user["phone"];
    $acompany = $user["company"];
    $asperson = $user["sperson"];
    $atax = explode("-", $user["tax"]);
    $acareer1 = $user["career1"];
    $acareer2 = $user["career2"];
    $abank = $user["bank"];
    $abankname = $user["bankname"];
    $abanknumber = $user["banknumber"];
    $role = $user['role'];
    if ($user['role'] == 0)
        $nrole = $this->language('l_master');
    if ($user['role'] == 1)
        $nrole = $this->language('l_seller');
    if ($user['role'] == 2)
        $nrole = $this->language('l_supplier');
    $idx_parent = $user['idx_parent'];
}

$idx = $this->getData('idx');
?>
<style>
<!--
div.form_group {
	padding: 1px;
}

div.form_group .row {
	text-align: center;
	border: 1px solid #CCC;
	padding: 0px 0;
	font-size: 12px;
}

div.form_group .form_item input {
	margin: 5px 0;
}

.input, .btn {
	margin: auto;
	padding: 5px 10px;
	border: 1px solid #CCC;
	font-size: 12px;
	font-weight: normal;
	resize: none;
	vertical-align: middle;
	outline: 0;
	overflow: hidden;
}

.select.small {
	padding: 7px 40px 5px 10px;
	margin: 5px 0px 5px 0px;
}

div.form_group .form_item h3, div.form_group .form_item .height1 {
	vertical-align: middle;
	line-height: 35px;
	padding: 0;
	border: 0;
	margin: 0;
}
-->
</style>
<script type="text/javascript">
$(document).ready(function(){
	
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
	// Thực hiện thêm mới người dùng
	$('#userAdmin').on('click', function(){
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
		var role = $('#role').val();
		
		var apw = $('#apw').val();
		var capw = $('#capw').val();
		if(apw != capw){
			$.fn_alert(true, true, "<?=$this->language( 'l_warnpw3')?>");
			return false;
		}
		if($.validatePW(apw) == false){
			$.fn_alert(true, true, "<?=$this->language( 'l_warnpw2')?>");
			return false;
		}
		var aemail=$('#aemail').val();
		if($.isEmail(aemail) == false){
			return false;
		}
		
		var acompany=$('#acompany').val();
		if ( acompany == "" ) {
			$.fn_alert(true, true, "<?=$this->language( 'l_inputcompany')?>");
			return false;
		}
		if(role!=0){
    		var arperson=$('#arperson').val();
    		if ( arperson == "" ) {
    			$.fn_alert(true, true, "<?=$this->language( 'l_inputperson_responsible')?>");
    			return false;
    		}
    		var aphone=$('#aphone').val();
    		if (aphone == "" ) {
    			$.fn_alert(true, true, "<?=$this->language( 'l_inputphone')?>");
    			return false;					
    		}
    		
    		var asperson=$('#asperson').val();	
    		if ( asperson == "" ) {
    			$.fn_alert(true, true, "<?=$this->language( 'l_inputperson_surrogate')?>");
    			return false;
    		}
    		var atax1=$('#atax1').val();	
    		if(atax1 == ''){
            	$('#atax1').focus();
            	return false;
            }
    		var atax2=$('#atax2').val();	
            if(atax2 == ''){
            	$('#atax2').focus();
            	return false;
    		}
            var atax3=$('#atax3').val();	
    	    if(atax3 == ''){
            	$('#atax3').focus();
            	return false;
            }   
    	    var taxfileupload = $("#change_taxfiles").get(0).files.length ;
    	    if(taxfileupload==0){
            	$.fn_alert(true, true, "<?=$this->language('l_errrfiledkkd')?>");
            	return false;
            }
    		var acareer1=$('#acareer1').val();	
    		var acareer2=$('#acareer2').val();	
    		if ( acareer1 == "" ) {
    			$.fn_alert(true, true, "<?=$this->language( 'l_inputcareer')?>");
    			return false;
    		}
    		if ( acareer2 == "" ) {
    			$.fn_alert(true, true, "<?=$this->language( 'l_inputcareer')?>");
    			return false;
    		}
    		var abank = $('#abank').val();
    		if(abank == 0){
    			$.fn_alert(true, true, "<?=$this->language( 'l_abankname')?>");
    			return false;
    		}
    		var abankname = $('#abankname').val();
    		if(abankname == ""){
    			$.fn_alert(true, true, "<?=$this->language( 'l_inputabank')?>");
    			return false;
    		}
    		var abanknumber = $('#abanknumber').val();
    		if(abanknumber == ""){
    			$.fn_alert(true, true, "<?=$this->language( 'l_inputabanknumber')?>");
    			return false;
    		}
    
    		var abanknumber = $('#abanknumber').val();
    		if(abanknumber == ""){
    			$.fn_alert(true, true, "<?=$this->language( 'l_inputabanknumber')?>");
    			return false;
    		}
    		
    		var bankfileupload = $("#change_bankfiles").get(0).files.length ;
    		if(bankfileupload == 0){
            	$.fn_alert(true, true, "<?=$this->language( 'l_erraccountbankupload')?>");
    			return false;
            }
        
		}
		$('#frmuser').submit();		
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

	
	init();
});
function init(){
	var inputYn= "<?=$inputYn?>";
	if(inputYn != "Y"){

	}else{
		opener.onloadUsers();
		window.close();
	}
}
</script>

<div class="ct_content">
	<div class="tab_bottom">
		<div class="tab_row">
			<form action="<?=$this->route('adduser')?>" method="POST" id="frmuser" enctype="multipart/form-data">
				<input name="frmsubmit" type="hidden" /> 
				<input name="role" id="role" type="hidden" value="0" />
				<div class="forminput">
					<div class="form_group clearfix frrow">
						<div class="row rmclass" data-action="viewperson" data-perid="14">
							<div class="form_tab">
								<div class="tab_head">
									<div class="form_group clearfix">
										<div class="form_item col-xs-3">
											<h3><?=$this->language('l_accrole')?></h3>
										</div>
										<div class="form_item col-xs-6">
											<ul class="clearfix">
												<li style="width: 100px;"><a data-tab="tab1" class="active"  title=""><?=$this->language('l_master')?></a></li>
												<li style="width: 100px;"><a data-tab="tab2" title=""><?=$this->language('l_seller')?></a></li>
												<li style="width: 100px;"><a data-tab="tab3" title=""><?=$this->language('l_supplier')?></a></li>
											</ul>
											<script type="text/javascript">
                            				$(document).ready(function(){		
                            					$('#tab2a').hide();
                    							$('#tab3a').hide();			
                            					$(".tab_head").on('click', 'a', function(){
                            						var id = $(this).attr('data-tab');
                            						if(id =="tab1"){
                            							$(this).closest('ul').find('a').removeClass('active');
                            							$(this).addClass('active');
                            							$('#tab2a').hide();
                            							$('#tab3a').hide();
                            							$('#role').val("0");
                            						}
    
                            						if(id =="tab2"){
                            							$(this).closest('ul').find('a').removeClass('active');
                            							$(this).addClass('active');
                            							$('#tab2a').show();
                            							$('#tab3a').hide();
                            							$('#role').val("1");
                            						}
    
                            						if(id =="tab3"){
                            							$(this).closest('ul').find('a').removeClass('active');
                            							$(this).addClass('active');
                            							$('#tab2a').show();
                            							$('#tab3a').show();
                            							$('#role').val("2");
                            						}
                            					});
                            				});
                            			</script>
										</div>
										<div class="form_item col-xs-3 align-left"></div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row rmclass" data-action="viewperson" data-perid="14">
							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_id')?></h3>
								</div>
								<div class="form_item col-xs-3">
									<div class="inputconfirm">
										<input type="text" name="aid" id="aid" value="<?=$aID?>" class="input full checkID" autocomplete="off">
									</div>
								</div>
								<div class="form_item col-xs-6 align-left">
									<div class="form_item">
                						<input id="checkID" type="button" value="중복확인" class="btn hover" />
                					</div>
								</div>
							</div>
							<div class="form_group clearfix" >
								<div class="form_item col-xs-3">
									<h3><?=$this->language( 'l_password')?></h3>
								</div>
								<div class="form_item col-xs-3">
									<div class="inputconfirm">
										<input name="apw" id="apw" type="password" value="" class="input full checkPW" autocomplete="off">
									</div>
								</div>
								<div class="form_item col-xs-3">
									<h3><?=$this->language( 'l_confirmpassword')?></h3>
								</div>
								<div class="form_item col-xs-3">
									<div class="inputconfirm">
										<input name="capw" id="capw" type="password" class="input full confirmPW" autocomplete="off" value="">
									</div>
								</div>
							</div>
							<div id="tab3a">
								<div class="form_group clearfix">
									<div class="form_item col-xs-3">
										<h3><?=$this->language( 'l_seller')?></h3>
									</div>
									<div class="form_item col-xs-3">
										<select class="select small full" name="idx_parent" id="idx_parent">
    										<?php foreach ($usersell as $key => $value){?>
    										<option value="<?=$value['idx']?>" ><?=$value['company']?>/<?=$value['ID']?></option>
    										<?php }?>
    									</select>
									</div>
									<div class="form_item col-xs-6"></div>
								</div>
							</div>
								
							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language( 'l_company')?></h3>
								</div>
								<div class="form_item col-xs-6">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty checkMaxLength" value="<?=$acompany?>" name="acompany" id="acompany" maxlength="50">
									</div>
								</div>
								<div class="form_item col-xs-3">
									<p class="height1 align-left checkMaxLengthView">0/50</p>
								</div>
							</div>
							<div id="tab2a">
    							<div class="form_group clearfix">
    								<div class="form_item col-xs-3">
    									<h3><?=$this->language( 'l_person_surrogate')?></h3>
    								</div>
    								<div class="form_item col-xs-6">
    									<div class="inputconfirm">
    										<input type="text" class="input full checkEmpty checkMaxLength" value="<?=$asperson?>" maxlength="10" name="asperson" id="asperson">
    									</div>
    								</div>
    								<div class="form_item col-xs-3">
    									<p class="height1 align-left checkMaxLengthView">0/10</p>
    								</div>
								</div>

    							<div class="form_group clearfix">
    								<div class="form_item col-xs-3">
    									<h3 class="height2"><?=$this->language( 'l_codetax')?></h3>
    								</div>
    
    								<div class="form_item col-xs-2"  style="width: 135px">
    									<input type="text" class="input full" name="atax1" id="atax1" value="<?=$atax[0]?>" maxlength="3" placeholder="<?=$this->language( 'l_tax1')?>" onkeypress="validate(event)"> 
    									<label for="change_taxfiles" class="btn full height1"><?=$this->language('l_dkkdupload')?></label> 
    									<input	id="change_taxfiles" style="display: none;" name="taxfile" style="visibility:hidden;" type="file" accept="application/pdf,image/*">
    									<script type="text/javascript">
        		  							$("#change_taxfiles").change(function() {
        		  								$('#load_taxfile_name p').html(this.files[0].name);
        									});
        		  						</script>
    								</div>
    								<div class="form_item col-xs-2">
    									<input type="text" class="input full" name="atax2" id="atax2" value="<?=$atax[1]?>" 
    											onkeypress="validate(event)" maxlength="2" placeholder="<?=$this->language( 'l_tax2')?>">
    									<div class="form_item" id="load_taxfile_name">
    										<p class="height1 align-left" style="position: absolute;"></p>
    									</div>
    								</div>
    								<div class="form_item col-xs-2">
    									<input type="text" class="input full" name="atax3" id="atax3" value="<?=$atax[2]?>" 
    											onkeypress="validate(event)" maxlength="5" placeholder="<?=$this->language( 'l_tax3')?>">
    								</div>
    								<div class="form_item col-xs-3"></div>
								</div>

								<div class="form_group clearfix">
    								<div class="form_item col-xs-3">
    									<h3>업태/업종</h3>
    								</div>
    								<div class="form_item col-xs-3">
    									<div class="inputconfirm">
    										<input type="text" class="input full checkEmpty" value="<?=$acareer1?>" value="<?=$user['career1']?>" 
    												name="acareer1" id="acareer1" maxlength="50">
    									</div>
    
    								</div>
    								<div class="form_item col-xs-3">
    									<div class="inputconfirm">
    										<input type="text" class="input full checkEmpty" value="<?=$acareer2?>" value="<?=$user['career2']?>"
    												name="acareer2" id="acareer2" maxlength="50">
    									</div>
    								</div>
    								<div class="form_item col-xs-3"></div>
								</div>
								<div class="form_group clearfix">
    								<div class="form_item col-xs-3">
    									<h3 >계좌정보</h3>
    								</div>
    								<div class="form_item col-xs-3">
    									<select class="select small full" name="abank" id="abank">
    										<option value="0"><?=$this->language( 'l_accountbank')?></option>
    										<?php foreach ($listbank as $key => $value) {  ?>
    										<option value="<?=$value['id']?>" <?php if($abank==$value['id']) echo 'selected="selected"';?>><?=$value['name']?></option>
    										<?php }?>
    									</select>
    								</div>
    								<div class="form_item col-xs-3">
    									<div class="inputconfirm">
    										<input type="text" class="input full checkEmpty" name="abankname" id="abankname" value="<?=$abankname?>" placeholder="<?=$this->language( 'l_inputabank')?>">
    									</div>
    
    								</div>
    								<div class="form_item col-xs-3">
    									<div class="inputconfirm">
    										<input type="text" class="input full checkEmpty" name="abanknumber" id="abanknumber" value="<?=$abanknumber?>" placeholder="<?=$this->language( 'l_inputabanknumber')?>">
    									</div>
    								</div>
								</div>

								<div class="form_group clearfix">
    								<div class="form_item col-xs-3">
    									<h3 >통장사본</h3>
    								</div>
    								<div class="form_item col-xs-9">
    									
    									<div class="form_item col-xs-3" style="padding: 0px">
    										<label for="change_bankfiles" class="btn full height1">통장사본등록</label>
    										<input id="change_bankfiles" style="display: none;" name="bankfile" style="visibility:hidden;" 
    												type="file" accept="application/pdf,image/*">
    										<script type="text/javascript">
            		  							$("#change_bankfiles").change(function() {
            		  								$('#load_bankfile_name p').html(this.files[0].name);
            									});
            		  						</script>
    									</div>
    									<div class="form_item col-xs-9" id="load_bankfile_name">
    										<p class="height1 align-left" style="position: absolute;"></p>
    									</div>
    								</div>
    								
								</div>
								
								<div class="form_group clearfix">
    								<div class="form_group clearfix">
    									<div class="form_item col-xs-3">
    										<h3><?=$this->language( 'l_person_responsible')?></h3>
    									</div>
    									<div class="form_item col-xs-3">
    										<div class="inputconfirm">
    											<input type="text" class="input full checkEmpty" value="<?=$arperson?>" maxlength="10" value="" name="arperson" id="arperson" autocomplete="off">
    										</div>
    									</div>
    									<div class="form_item col-xs-3">
    										<h3><?=$this->language( 'l_phone')?></h3>
    									</div>
    									<div class="form_item col-xs-3">
    										<div class="inputconfirm">
    											<input type="text" class="input full checkEmpty" name="aphone" value="<?=$aphone?>" id="aphone" autocomplete="off" onkeypress="validate(event)">
    										</div>
    									</div>
    								</div>
								</div>
							</div>
							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language( 'l_email')?></h3>
								</div>
								<div class="form_item col-xs-6">
									<div class="inputconfirm">
										<input type="text" name="aemail" id="aemail" value="<?=$aemail?>" class="input full checkEmail" autocomplete="off" placeholder="<?=$this->language( 'l_email')?>">
									</div>

								</div>
								<div class="form_item col-xs-3 align-left"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="form_group">
					<div class="form_item">
						<input id="userAdmin" type="button" value="<?=$this->language('l_Channel34')?>" class="btn hover full" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>