<?php 
$inputYn= "N";
if(isset($_POST['frmsubmit'])){
    $inputYn="Y";
}
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
	// Thực hiện thêm mới người dùng
	$('#userAdmin').on('click', function(){
		// kiểm tra id
		var aid = $('#aid').val();		
		if($.isID(aid) == false){			
			return false;
		}
		// Kiểm tra password
		var act = $('#act').val();
		if(act=='add'){
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
		if(act=='add'){
    	    var taxfileupload = $("#change_taxfiles").get(0).files.length ;
    	    if(taxfileupload==0){
            	$.fn_alert(true, true, "<?=$this->language('l_errrfiledkkd')?>");
            	return false;
            }
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

		var abanknumber = $('#abanknumber').val();
		if(abanknumber == ""){
			$.fn_alert(true, true, "<?=$this->language('l_inputabanknumber')?>");
			return false;
		}
		
		if(act=='add'){
    		var bankfileupload = $("#change_bankfiles").get(0).files.length ;
    		if(bankfileupload == 0){
            	$.fn_alert(true, true, "<?=$this->language('l_erraccountbankupload')?>");
    			return false;
            }
		}
        
		
		$('#frmuser').submit();		
	});
	init();
});
function init(){
	var inputYn= "<?=$inputYn?>";
	if(inputYn != "Y"){

	}else{
		opener.onloadSuplliers();
		window.close();
	}
}
function goPopup(){
	// 주소검색을 수행할 팝업 페이지를 호출합니다.
	// 호출된 페이지(jusoPopup_utf8.php)에서 실제 주소검색URL(http://www.juso.go.kr/addrlink/addrLinkUrl.do)를 호출하게 됩니다.
	var pop1 = window.open("<?=URL_BASE?>/php_sample/jusoPopup_utf8.php","_blank","width=570,height=420, scrollbars=yes, resizable=yes"); 
	// 모바일 웹인 경우, 호출된 페이지(jusoPopup_utf8.php)에서 실제 주소검색URL(http://www.juso.go.kr/addrlink/addrMobileLinkUrl.do)를 호출하게 됩니다.
    //var pop = window.open("/jusoPopup_utf8.php","pop","scrollbars=yes, resizable=yes"); 
}
function jusoCallBack(roadFullAddr,jibunAddr,zipNo,siNm,sggNm,emdNm){

	document.getElementById('roadFullAddr').value = roadFullAddr;
	document.getElementById('jibunAddr').value = jibunAddr;
	document.getElementById('zipNo').value = zipNo;
	document.getElementById('siNm').value = siNm;
	document.getElementById('sggNm').value = sggNm;
	document.getElementById('emdNm').value = emdNm;
	//한국
	document.getElementById('noteAddr').innerHTML  = "<p> <?=$this->language('l_accaddress')?> : "+roadFullAddr+"</p>"+"<p> <?=$this->language('l_acccode')?> : "+jibunAddr+"</p>"+"<p> <?=$this->language('l_acczipcode')?> : "+zipNo+"</p>";
}
</script>
<?php
$account = $_SESSION['accountshopping'];

$user= $this->getData('user');
$userinfo= $this->getData('userinfo');

$aID="";
$arperson="";
$aemail="";
$aphone="";
$acompany="";
$asperson="";
$atax=array();
$atax[0]="";
$atax[1]="";
$atax[2]="";
$acareer1="";
$acareer2="";
$abank=1;
$abankname="";
$abanknumber="";

if($user){
    $aID=$user["ID"];
    $arperson=$user["rperson"];
    $aemail=$user["email"];
    $aphone=$user["phone"];
    $acompany=$user["company"];
    $asperson=$user["sperson"];
    $atax=explode("-", $user["tax"]);
    $acareer1=$user["career1"];
    $acareer2=$user["career2"];
    $abank=$user["bank"];
    $abankname=$user["bankname"];
    $abanknumber=$user["banknumber"];
}

$roadFullAddr="";
$jibunAddr="";
$zipNo="";
$siNm="";
$sggNm="";
$emdNm="";
$timework="";
$dayoff="";
$phonetable="";
$phoneadvisory="";
$phonecancel="";
$hotline="";
$parking=0;
$parking_fee=0;
$website="";
$email="";
$fax="";

if($userinfo){
    $roadFullAddr=$userinfo['roadFullAddr'];
    $jibunAddr=$userinfo['jibunAddr'];
    $zipNo=$userinfo['zipNo'];
    $siNm=$userinfo['city'];
    $sggNm=$userinfo['district'];
    //$emdNm=$userinfo['emdNm'];
    $timework=$userinfo['timework'];
    $dayoff=$userinfo['dayoff'];
    $phonetable=$userinfo['phonetable'];
    $phoneadvisory=$userinfo['phoneadvisory'];
    $phonecancel=$userinfo['phonecancel'];
    $hotline=$userinfo['hotline'];
    $parking=$userinfo['parking'];
    $parking_fee=$userinfo['parking_fee'];
    $website=$userinfo['website'];
    $email=$userinfo['email'];
    $fax=$userinfo['fax'];
}
$act= $this->getData('act');
$idx= $this->getData('idx');
?>
<div class="ct_content" >
	<div class="tab_bottom">
		<div class="tab_row">
			<form action="<?=$this->route('supplier')?>" method="POST" id="frmuser"
				 enctype="multipart/form-data">
				<input name="frmsubmit" type="hidden"  />
				<input name="idx_parent" type="hidden"  value="<?=$account['idx']?>"/>
				<input name="act" id="act" type="hidden"  value="<?=$act?>"/>
				<input name="idx" type="hidden"  value="<?=$idx?>"/>
				<div class="forminput">
					<div class="form_group clearfix frrow">
						<div class="row rmclass" data-action="viewperson" data-perid="14">

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_id')?></h3>
								</div>
								<div class="form_item col-xs-3">
									<div class="inputconfirm">
										<input type="text" name="aid" id="aid" value="<?=$aID?>"  <?php if($act=="edit") echo 'readonly="readonly"';?>
											class="input full checkID" autocomplete="off">
									</div>
								</div>
								<div class="form_item col-xs-6 align-left"></div>
							</div>
							<div class="form_group clearfix" <?php if($act=="edit") echo 'style="display:none;"';?> >
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_password')?></h3>
								</div>
								<div class="form_item col-xs-3">
									<div class="inputconfirm">
										<input name="apw" id="apw" type="password" value=""
											class="input full checkPW" autocomplete="off">
									</div>
								</div>
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_confirmpassword')?></h3>
								</div>
								<div class="form_item col-xs-3">
									<div class="inputconfirm">
										<input name="capw" id="capw" type="password" class="input full confirmPW" autocomplete="off" value="">
									</div>
								</div>
							</div>

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_person_responsible')?></h3>
								</div>
								<div class="form_item col-xs-3">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty" value="<?=$arperson?>"
											maxlength="10" value="" name="arperson" id="arperson"
											autocomplete="off">
									</div>
								</div>
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_phone')?></h3>
								</div>
								<div class="form_item col-xs-3">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty" name="aphone" value="<?=$aphone?>"
											id="aphone" autocomplete="off" onkeypress="validate(event)" maxlength="11" >
									</div>
								</div>
							</div>

							

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_email')?></h3>
								</div>
								<div class="form_item col-xs-6">
									<div class="inputconfirm">
										<input type="text" name="aemail" id="aemail" value="<?=$aemail?>"
											class="input full checkEmail" autocomplete="off"
											placeholder="<?=$this->language('l_email')?>">
									</div>

								</div>
								<div class="form_item col-xs-3 align-left"></div>
							</div>


						</div>

					</div>
				</div>

				<div class="forminput">
					<div class="form_group clearfix frrow">
						<div class="row rmclass" data-action="viewperson" data-perid="14">
							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_company')?></h3>
								</div>
								<div class="form_item col-xs-6">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty checkMaxLength" 
											value="<?=$user['company']?>" name="acompany" id="acompany"
											maxlength="50">
									</div>
								</div>
								<div class="form_item col-xs-3">
									<p class="height1 align-left checkMaxLengthView"><?=strlen($user['company'])?>/50</p>
								</div>
							</div>

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_person_surrogate')?></h3>
								</div>
								<div class="form_item col-xs-6">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty checkMaxLength" 
											value="<?=$user['sperson']?>" maxlength="10" name="asperson"
											id="asperson">
									</div>
								</div>
								<div class="form_item col-xs-3">
									<p class="height1 align-left checkMaxLengthView"><?=strlen($user['sperson'])?>/10</p>
								</div>
							</div>

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3 class="height2"><?=$this->language('l_codetax')?></h3>
								</div>
								
								<div class="form_item col-xs-2" style="min-width: 140px;">
									<input type="text" class="input full" name="atax1" id="atax1" value="<?=$atax[0]?>" maxlength="3" placeholder="<?=$this->language('l_tax1')?>" onkeypress="validate(event)" >
									
									<label for="change_taxfiles" class="btn full height1"><?=$this->language('l_dkkdupload')?></label>
									<input id="change_taxfiles" style="display: none;" name="taxfile" style="visibility : hidden;" type="file" accept="application/pdf,image/*">
									<script type="text/javascript">
                		  							$("#change_taxfiles").change(function() {
                		  								$('#load_taxfile_name p').html(this.files[0].name);
                									});
                		  						</script>
								</div>
								<div class="form_item col-xs-2">
									<input type="text" class="input full" name="atax2" id="atax2"  value="<?=$atax[1]?>" onkeypress="validate(event)" maxlength="2" placeholder="<?=$this->language('l_tax2')?>">
									
									<div class="form_item"  id="load_taxfile_name">
										<p class="height1 align-left" style="position: absolute;"></p>
									</div>
								</div>
								<div class="form_item col-xs-2">
									<input type="text" class="input full" name="atax3" id="atax3"  value="<?=$atax[2]?>" onkeypress="validate(event)" maxlength="5" placeholder="<?=$this->language('l_tax3')?>">
								</div>
							
								<div class="form_item col-xs-3">
									
								</div>
							</div>

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_career')?></h3>
								</div>
								<div class="form_item col-xs-3">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty" 
											value="<?=$user['career1']?>" name="acareer1" id="acareer1"
											maxlength="10">
									</div>

								</div>
								<div class="form_item col-xs-3">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty" 
											value="<?=$user['career2']?>" name="acareer2" id="acareer2"
											maxlength="10">
									</div>
								</div>
								<div class="form_item col-xs-3"></div>
							</div>
							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3 class="height2">계좌정보</h3>
								</div>
								<div class="form_item col-xs-3">
									<select class="select small full" name="abank" id="abank">
										<option value="0"><?=$this->language('l_accountbank')?></option>
										<?php 
										$listbank = $this->getData('listbank');
										foreach ($listbank as $key => $value) {?>
										<option value="<?=$value['id']?>"
										<?php if($abank==$value['id']) echo 'selected="selected"';?>><?=$value['name']?></option>
										<?php }?>
											
									</select>
									
									<div class="form_item col-xs-8" style="padding: 0px">
        								<label for="change_bankfiles" class="btn full height1">계좌변경</label>
        								<input id="change_bankfiles" style="display: none;" name="bankfile"
        									style="visibility:hidden;" type="file" accept="application/pdf,image/*">
        								<script type="text/javascript">
                        		  							$("#change_bankfiles").change(function() {
                        		  								$('#load_bankfile_name p').html(this.files[0].name);
                        									});
                        		  						</script>
                        		  		
        							</div>
        							
        							<div class="form_item col-xs-4" id="load_bankfile_name">
										<p class="height1 align-left" style="position: absolute;"></p>
									</div>
        							
								</div>
								<div class="form_item col-xs-3">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty"
											name="abankname" id="abankname"
											value="<?=$abankname?>"
											placeholder="<?=$this->language('l_inputabank')?>">
									</div>
									
								</div>
								<div class="form_item col-xs-3">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty"
											name="abanknumber" id="abanknumber"
											value="<?=$abanknumber?>"
											placeholder="<?=$this->language('l_inputabanknumber')?>">
									</div>
								</div>
						</div>

						<div class="form_group clearfix">
							
							
							
						</div>
					</div>

				</div>
		
		</div>

		<div class="forminput">
			<div class="form_group clearfix frrow">
				<div class="row rmclass" data-action="viewperson" data-perid="14">
					<div class="form_group clearfix">
						<div class="form_item col-xs-3">
							<h3><?=$this->language('l_businessinfoaddress')?></h3>
						</div>
						<div class="form_item col-xs-8" style="text-align: left;">
							<input type="button" class="btn hover" value="<?=$this->language('l_accaddressfind')?>"
								onclick="goPopup();">
							<div class="note" id="noteAddr">
							<?php if($roadFullAddr!=""){?>
							
							<p> <?=$this->language('l_accaddress')?> : <?=$roadFullAddr?></p>
							<p> <?=$this->language('l_acccode')?> : <?=$jibunAddr?></p>
							<p> <?=$this->language('l_acczipcode')?> : <?=$zipNo?></p>
    												<?php }?>
												</div >
						</div>
						<div class="form_item col-xs-1">
							<input type="hidden" value="<?=$roadFullAddr?>"
								name="aroadFullAddr" id="roadFullAddr"> <input type="hidden"
								value="<?=$jibunAddr?>" name="ajibunAddr" id="jibunAddr"> <input
								type="hidden" value="<?=$zipNo?>" name="azipNo" id="zipNo"> <input
								type="hidden" value="<?=$siNm?>" name="asiNm" id="siNm"> <input
								type="hidden" value="<?=$sggNm?>" name="asggNm" id="sggNm"> <input
								type="hidden" value="<?=$emdNm?>" name="aemdNm" id="emdNm">
						</div>
					</div>

					<div class="form_group clearfix">
						<div class="form_item col-xs-3">
							<h3><?=$this->language('l_worktimeout')?></h3>
						</div>
						<div class="form_item col-xs-6">
							<div class="inputconfirm">
								<input type="text" class="input full checkEmpty checkMaxLength"
									placeholder="<?=$this->language('l_example').$this->language('l_workinweek')?> 10:00~21:00, <?=$this->language('l_worksaturday')?> 10:00~24:00"
									value="<?=$timework?>" name="atimework" maxlength="100">
							</div>
						</div>
						<div class="form_item col-xs-3">
							<p class="height1 align-left checkMaxLengthView"><?=strlen($timework)?>/100</p>
						</div>
					</div>

					<div class="form_group clearfix">
						<div class="form_item col-xs-3">
							<h3><?=$this->language('l_workdayoff')?></h3>
						</div>
						<div class="form_item col-xs-6">
							<div class="inputconfirm">
								<input type="text" class="input full checkEmpty checkMaxLength"
									placeholder="<?=$this->language('l_example').$this->language('l_worktimeoff')?>" value="<?=$dayoff?>"
									name="adayoff" maxlength="100">
							</div>
						</div>
						<div class="form_item col-xs-3">
							<p class="height1 align-left checkMaxLengthView"><?=strlen($dayoff)?>/100</p>
						</div>
					</div>

					<div class="form_group clearfix">
						<div class="form_item col-xs-3">
							<h3><?=$this->language('l_landlinenumber')?></h3>
						</div>
						<div class="form_item col-xs-3">
							<div class="inputconfirm">
								<input type="text" class="input full checkEmpty"
									placeholder="<?=$this->language('l_example')?>02-000-0000" value="<?=$phonetable?>" onkeypress="validate(event)"
									name="aphonetable" maxlength="11">
							</div>
						</div>
						<div class="form_item col-xs-3">
							<h3><?=$this->language('l_landlinenumber3')?></h3>
						</div>
						<div class="form_item col-xs-3">
							<div class="inputconfirm">
								<input type="text" class="input full checkEmpty"
									placeholder="<?=$this->language('l_example')?>02-000-0000" value="<?=$hotline?>" onkeypress="validate(event)"
									name="ahotline" maxlength="11">
							</div>
						</div>
					</div>

					<div class="form_group clearfix">
						<div class="form_item col-xs-3">
							<h3><?=$this->language('l_landlinenumberservice')?></h3>
						</div>
						<div class="form_item col-xs-3">
							<div class="inputconfirm">
								<input type="text" class="input full checkEmpty"
									placeholder="<?=$this->language('l_example')?>02-000-0000" value="<?=$phoneadvisory?>" onkeypress="validate(event)"
									name="aphoneadvisory" maxlength="11">
							</div>
						</div>
						<div class="form_item col-xs-3">
							<h3><?=$this->language('l_landlinenumber2')?></h3>
						</div>
						<div class="form_item col-xs-3">
							<div class="inputconfirm">
								<input type="text" class="input full checkEmpty"
									placeholder="<?=$this->language('l_example')?>02-000-0000" value="<?=$phonecancel?>" onkeypress="validate(event)"
									name="aphonecancel" maxlength="11">
							</div>
						</div>
					</div>

					

					<div class="form_group clearfix">
						<div class="form_item col-xs-3">
							<h3><?=$this->language('l_parking')?></h3>
						</div>
						<div class="form_item col-xs-3">
							<input type="radio" name="checkparking" <?php if($parking==0) echo 'checked="checked"'; ?> id="checkparking0"  value="0"
									onclick='document.getElementById("aparking_fee").value=0;document.getElementById("aparking_fee").setAttribute("disabled", "disabled");' >
							<label for="checkparking0"><?=$this->language('l_parking1')?></label>
							<input type="radio" name="checkparking" <?php if($parking==1) echo 'checked="checked"'; ?> id="checkparking1" value="1"
									onclick='document.getElementById("aparking_fee").removeAttribute("disabled");' >
							<label for="checkparking1"><?=$this->language('l_parking2')?></label>
						</div>
						<div class="form_item col-xs-3">
							<h3><?=$this->language('l_parking3')?></h3>
						</div>
						<div class="form_item col-xs-3">
							<div class="inputconfirm">
								<input type="text" class="input full checkEmpty v-numericprice" <?php if($parking ==0) echo 'disabled="disabled"'; ?>
									value="<?=$parking_fee?>" id="aparking_fee" name="aparking_fee" maxlength="20" />
							</div>
						</div>
					</div>
					<div class="form_group clearfix">
						<div class="form_item col-xs-3">
							<h3><?=$this->language('l_website')?></h3>
						</div>
						<div class="form_item col-xs-6">
							<div class="inputconfirm">
								<input type="text" class="input full checkEmpty"
									placeholder="http://  주소를 입력하세요. " value="<?=$website?>"
									name="website" maxlength="100">
							</div>
						</div>
						<div class="form_item col-xs-3"></div>
					</div>

					<div class="form_group clearfix">
						<div class="form_item col-xs-3">
							<h3><?=$this->language('l_emailandfax')?></h3>
						</div>
						<div class="form_item col-xs-3">
							<div class="inputconfirm">
								<input type="text" class="input full checkEmpty"
									placeholder="<?=$this->language('l_example')?>tibrage@mmm.mm" value="<?=$email?>"
									name="email" maxlength="100">
							</div>
						</div>
						<div class="form_item col-xs-3">
							<div class="inputconfirm">
								<input type="text" class="input full checkEmpty"
									placeholder="<?=$this->language('l_example')?>010-0000-0000" value="<?=$fax?>" name="fax"
									maxlength="100">
							</div>
						</div>
						<div class="form_item col-xs-3"></div>
					</div>

				</div>
			</div>
		</div>

		<div class="form_group">
			<div class="form_item">
				
				<input  id="userAdmin" type="button"   <?php if($act=="edit") echo 'value="등록"'; else echo 'value="'.$this->language('l_acctable11').'"';?> class="btn hover full" />
			</div>
		</div>
		</form>
	</div>




</div>
</div>