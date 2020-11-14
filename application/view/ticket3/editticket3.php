<?php
$sellerProductId = $this->getData('sellerProductId');
$maxPurchaseTime = 0;
$maxPurchaseQuantity = 0;
$list_sellerProduct = $this->getData ( 'list_sellerProduct' );
foreach ( $list_sellerProduct as $value => $giatri ) {
	$maxPurchaseTime = $giatri ['maxPurchaseTime'];
	$maxPurchaseQuantity = $giatri ['maxPurchaseQuantity'];
	$adultOnly = $giatri ['adultOnly'];
	$notice = $giatri ['additionalInfoPrompt'];
	$usageNotice = trim ( $giatri ['usageNotice'] );
}
$cancelPolicyId = microtime(true) * 10000;
$cancelType = "APPROVAL";
$cancelPeriodType = "";
$cancelPeriodType1="DATEUSE";
$cancelPeriodType2=1;
$cancelMarkType = "";
$refundOnBusinessDay = 0;
$refundUnusedTicket = 0;
$cancelNotice = "";
$UNUSE_REFUND_ALL = 1;
$range = 1;
$list_cancelpolicy = $this->getData('list_cancelpolicy');
foreach ($list_cancelpolicy as $value => $giatri) {
	$cancelPolicyId = $giatri['cancelPolicyId'];
	$cancelType = $giatri['cancelType'];
	$cancelPeriodType = $giatri['cancelPeriodType'];
	$cancelPeriodType1 = $giatri['cancelPeriodType1'];
	$cancelPeriodType2 = $giatri['cancelPeriodType2'];
	$cancelMarkType = $giatri['cancelMarkType'];
	$refundOnBusinessDay = $giatri['refundOnBusinessDay'];
	$refundUnusedTicket = $giatri['refundUnusedTicket'];
	$cancelNotice = $giatri['notice'];
}
if ($cancelMarkType == "UNUSE_REFUND_ALL") {
	$UNUSE_REFUND_ALL = 1;
}
if ($cancelMarkType == "UNUSE_REFUND_ALL_BEFORE_ONE_DAY") {
	$range = 1;
	$UNUSE_REFUND_ALL = 0;
}
if ($cancelMarkType == "DEPENDING_ON_VENDOR") {
	$UNUSE_REFUND_ALL = 0;
	$range = 2;
}
if ($cancelMarkType == "NONE"  || $cancelMarkType == "NOT_CANCELED" || $cancelMarkType == "NOT_REFUND_AFTER_RECEIPT" || $cancelMarkType == "NOT_REFUND_AFTER_RESERVATION_CONFIRM") {
	$UNUSE_REFUND_ALL = 0;
	$range = 3;
}
$list_refundrates = $this->getData('list_refundrates');
?>
<link rel="stylesheet" type="text/css"
href="<?=URL_PUBLIC?>css/jsDatePick_ltr.min.css" />
<script type="text/javascript"
src="<?=URL_PUBLIC?>js/jsDatePick.min.1.3.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
	function flagChanges(){
		localStorage.setItem("flagChange", "1");
	}
	function continuelink(step){
		window.location.assign("<?php echo $this->route('editticket4')."/".$sellerProductId;?>");
	}
	$(document).ready(function(){
		localStorage.setItem("flagChange", "1");
		$('#saveTemp').on('click', function(){
			var ff = document.nf;
			var step = $(this).attr('data-step');

			var co=0;
			$.each( $('.conditionTime'), function( index, value ) {
				if($.validateHhMm($(this).val())==false){
					$(this).focus();
					$.fn_alert(true, true, "conditionTime 00:00:00");
					co=1;
				}
			});
			$.each( $('.refundRate'), function( index, value ) {
				if($(this).val()>100){
					$(this).focus();
					$.fn_alert(true, true, "refundRate <=100");
					co=1;
				}
			});
			if(co==1) return false;
			
			document.getElementById("step").value=step;
			ff.submit();
		});
	// Tiếp tục | Trở lại
	$('#continuelink, #backlink').on('click', function(){
		var step = $(this).attr('data-step');
		if(step){
			$('#step').val(step);
			$.fn_ticketcontinue(step);
		}
	});
	// Tiếp tục | Trở lại
	$($.elt_popup).on('click', '.ticketconfirm .continue', function(){
		$('#nf').submit();
	});

});
	function saveTemp(step){
		var ff = document.nf;
		document.getElementById("step").value=step;
		ff.submit();
	}
	function backlink(step){
		window.location.assign("<?php echo $this->route('editticket2')."/".$sellerProductId;?>");
	}
	function addrefundRates(id){
		runAjax('addrefundRates', {'cancelPolicyId':id}, function(result){
			document.getElementById('divrefundRates').insertAdjacentHTML("beforeend",result);
		});
	}
	function delrefundRates(id){
		document.getElementById("tbrefundRates"+id).remove();
	}
	$(document).ready(function(){
		checkUNUSE_REFUND_ALL(<?=$UNUSE_REFUND_ALL?>);
		checkrange(<?=$range?>);
	});
	function checkUNUSE_REFUND_ALL(value){
		localStorage.setItem("flagChange", "1");
		if(value==1){
			document.getElementById("divrange").style.display = "none";
			document.getElementById("divmethod1").style.display = "none";
			document.getElementById("divmethod2").style.display = "none";
			document.getElementById("divmethod3").style.display = "none";
			document.getElementById("divcancelType").style.display = "none";
			document.getElementById("checkrefundUnusedTicket1").checked = true;
		}else{
			document.getElementById("divrange").style.display = "block";
			document.getElementById("divmethod1").style.display = "block";
			document.getElementById("divmethod2").style.display = "none";
			document.getElementById("divmethod3").style.display = "none";
			document.getElementById("divcancelType").style.display = "block";
			document.getElementById("checkrefundUnusedTicket0").checked = true;
		}
	}
	function checkrange(value){
		var ids1=document.getElementsByName("UNUSE_REFUND_ALL");

		if(!ids1[0].checked){

			if(value==1){
				document.getElementById("divmethod1").style.display = "block";
				document.getElementById("divmethod2").style.display = "none";
				document.getElementById("divmethod3").style.display = "none";
			}else if(value==2){
				document.getElementById("divmethod1").style.display = "none";
				document.getElementById("divmethod2").style.display = "block";
				document.getElementById("divmethod3").style.display = "none";
			}else if(value==3){
				document.getElementById("divmethod1").style.display = "none";
				document.getElementById("divmethod2").style.display = "none";
				document.getElementById("divmethod3").style.display = "block";
			}
		}
	}
	function changecancelPeriodType(value){
		if(value=="DIRECT"){
			document.getElementById("divcancelPeriodType1").style.display = "block";
			document.getElementById("divcancelPeriodType2").style.display = "block";
		}else{
			document.getElementById("divcancelPeriodType1").style.display = "none";
			document.getElementById("divcancelPeriodType2").style.display = "none";
		}
	}
	// Chuyển hướng khi lưu thành công
	setTimeout(function(){
		var urlstep = $('#locationurlstep').attr('data-urlstep');
		if((urlstep)){
			$.fn_alert(true, true, "임시저장 되었습니다.");
		}
	},500);
	function changemaxPurchaseTime(value){
		localStorage.setItem("flagChange", "1");
		document.getElementById("maxPurchaseTime").value = value;
		if(value=="11"){
			document.getElementById("maxPurchaseTime").style.display = "block";
		}else{
			document.getElementById("maxPurchaseTime").style.display = "none";
		}
}
function changemaxPurchaseQuantity(value){
	localStorage.setItem("flagChange", "1");
	document.getElementById("maxPurchaseQuantity").value = value;
	if(value=="11"){
		document.getElementById("maxPurchaseQuantity").style.display = "block";
	}else{
		document.getElementById("maxPurchaseQuantity").style.display = "none";
	}
}
</script>
<div class="ct_head" id="locationurlstep" data-urlstep="<?=$this->getData('urlstep')?>" data-step="3"> <?php require PATH_INCLUDES . 'top.php';?></div>
<div class="ct_content">
	<div class="forminput">
		<form name="nf" method="POST"
		action="<?=$this->route('editticket3')?>/<?=$sellerProductId?>" id="nf">
		<div class="form_group clearfix frrow">
			<h3><?=$this->language( 'l_conditionbuy')?></h3>
			<div class="row rmclass" data-action="viewperson" data-perid="14">
				<div class="form_group clearfix">
					<div class="form_item col-xs-2">
						<h3><?=$this->language( 'l_ammounttime')?></h3>
					</div>
					<div class="form_item col-xs-1">
						<select class="select small" onchange="changemaxPurchaseTime(this.value)" style="min-width: 50px;">
							<option <?php if($maxPurchaseTime==0) echo 'selected="selected"';?> value="0">제한없음</option>
							<option <?php if($maxPurchaseTime==1) echo 'selected="selected"';?> value="1">1</option>
							<option <?php if($maxPurchaseTime==2) echo 'selected="selected"';?> value="2">2</option>
							<option <?php if($maxPurchaseTime==3) echo 'selected="selected"';?> value="3">3</option>
							<option <?php if($maxPurchaseTime==4) echo 'selected="selected"';?> value="4">4</option>
							<option <?php if($maxPurchaseTime==5) echo 'selected="selected"';?> value="5">5</option>
							<option <?php if($maxPurchaseTime==6) echo 'selected="selected"';?> value="6">6</option>
							<option <?php if($maxPurchaseTime==7) echo 'selected="selected"';?> value="7">7</option>
							<option <?php if($maxPurchaseTime==8) echo 'selected="selected"';?> value="8">8</option>
							<option <?php if($maxPurchaseTime==9) echo 'selected="selected"';?> value="9">9</option>
							<option <?php if($maxPurchaseTime==10) echo 'selected="selected"';?> value="10">10</option>
							<option <?php if($maxPurchaseTime>=11) echo 'selected="selected"';?> value="11">제한없음</option>
						</select>

					</div>
					<div class="form_item col-xs-1" style="text-align: left;">
						<input name="maxPurchaseTime" id="maxPurchaseTime" type="text" style="<?php if($maxPurchaseTime<11) echo 'display: none;';?>margin-left: 5px;margin-top: 4px;" 
									value="<?=$maxPurchaseTime?>" class="input full" onkeypress='validate(event)' />
					</div>
					<div class="form_item col-xs-8 align-left">
						<p id="check_maxPurchaseTime"></p>
					</div>
				</div>
				<div class="form_group clearfix">
					<div class="form_item col-xs-2">
						<h3><?=$this->language('l_ammountperson')?></h3>
					</div>
					<div class="form_item col-xs-1">
						<select class="select small" onchange="changemaxPurchaseQuantity(this.value)" style="min-width: 50px;">
							<option <?php if($maxPurchaseQuantity==0) echo 'selected="selected"';?> value="0">제한없음</option>
							<option <?php if($maxPurchaseQuantity==1) echo 'selected="selected"';?> value="1">1</option>
							<option <?php if($maxPurchaseQuantity==2) echo 'selected="selected"';?> value="2">2</option>
							<option <?php if($maxPurchaseQuantity==3) echo 'selected="selected"';?> value="3">3</option>
							<option <?php if($maxPurchaseQuantity==4) echo 'selected="selected"';?> value="4">4</option>
							<option <?php if($maxPurchaseQuantity==5) echo 'selected="selected"';?> value="5">5</option>
							<option <?php if($maxPurchaseQuantity==6) echo 'selected="selected"';?> value="6">6</option>
							<option <?php if($maxPurchaseQuantity==7) echo 'selected="selected"';?> value="7">7</option>
							<option <?php if($maxPurchaseQuantity==8) echo 'selected="selected"';?> value="8">8</option>
							<option <?php if($maxPurchaseQuantity==9) echo 'selected="selected"';?> value="9">9</option>
							<option <?php if($maxPurchaseQuantity==10) echo 'selected="selected"';?> value="10">10</option>
							<option <?php if($maxPurchaseQuantity>=11) echo 'selected="selected"';?> value="11">제한없음</option>
						</select>

					</div>
					<div class="form_item col-xs-1" style="text-align: left;">
						<input name="maxPurchaseQuantity" id="maxPurchaseQuantity" type="text" style="<?php if($maxPurchaseQuantity<11) echo 'display: none;';?>margin-left: 5px;margin-top: 4px;"
								value="<?=$maxPurchaseQuantity?>" class="input full" onkeypress='validate(event)' />
					</div>
					<div class="form_item col-xs-8 align-left"><p id="check_maxPurchaseQuantity"></p></div>
				</div>
				<div class="form_group clearfix">
					<div class="form_item col-xs-2">
						<h3><?=$this->language( 'l_adultOnly')?></h3>
					</div>
					<div class="form_item col-xs-1" style="margin-top: 8px;text-align: left;">
						<input type="radio" onchange="flagChanges();" name="adultOnly" value="1" <?php if($adultOnly==1) echo 'checked="checked"';?> id="checkadultOnly1"/>
						<label for="checkadultOnly1"><?=$this->language( 'l_yes')?></label>
						<p id="check_checkadultOnly1"></p>
					</div>
					<div class="form_item col-xs-1" style="margin-top: 8px;text-align: left;">
						<input type="radio" onchange="flagChanges();" name="adultOnly" value="0" <?php if($adultOnly==0) echo 'checked="checked"';?> id="checkadultOnly0" />
						<label for="checkadultOnly0"><?=$this->language( 'l_no')?></label>
						<p id="check_checkadultOnly0"></p>
					</div>
					<div class="form_item col-xs-8 align-left"></div>
				</div>
				<div class="form_group clearfix">
					<div class="form_item col-xs-2">
						<h3><?=$this->language( 'l_addconditionbuy')?></h3>
					</div>
					<div class="form_item col-xs-8">
						<input name="notice" onchange="flagChanges();" id="notice" type="text" maxlength="30" placeholder="예) 실제 사용자가 다를 경우 사용자 이름을 적어주세요."
						data-text="<?=$this->language('l_warnname')?>"
						value="<?=$notice?>" class="input full checkMaxLength" />
					</div>
					<div class="form_item col-xs-2 align-left">
						<p class="height1 checkMaxLengthView"><?=strlen($notice)?>/30 <?=$this->language('l_warnname')?></p>
					</div>
				</div>
				<div class="form_group clearfix">
					<div class="form_item col-xs-2">
						<h3><?=$this->language( 'l_contentbuy')?></h3>
					</div>
					<div class="form_item col-xs-8">
						<textarea name="usageNotice" onchange="flagChanges();" id="usageNotice" placeholder="예) 쿠폰구매 구매 후 20~30분 뒤 LMS 문자 수신 확인
oooo 현장 방문
매표소에서 구매자 성함&연락처&바코드 확인
바코드 지참 필수"
						style="resize: none; height: 100px;" maxlength="2000" data-text="<?=$this->language('l_warnname')?>" class="input full checkMaxLength"><?=$usageNotice?></textarea>

					</div>
					<div class="form_item col-xs-2 align-left">
						<p class="height2 checkMaxLengthView"><?=strlen($usageNotice)?>/2000 <?=$this->language('l_warnname')?></p>
					</div>
				</div>
			</div>

			<h3><?=$this->language( 'l_conditioncancel')?></h3>
			<div class="row rmclass" data-action="viewperson" data-perid="14">
				<div class="form_group clearfix" style="display: none;">
					<div class="form_item col-xs-2">
						<h3><?=$this->language( 'l_codeproduct')?></h3>
					</div>
					<div class="form_item col-xs-3">
						<input type="text" name="sellerProductId" id="sellerProductId" value="<?=$sellerProductId?>" readonly="readonly" class="input full" autocomplete="off">
						<input name="btnSumit" id="btnSumit" type="hidden" value="editticket3" />
						<input name="cancelPolicyId" id="cancelPolicyId" type="hidden" value="<?=$cancelPolicyId?>">
					</div>
					<div class="form_item col-xs-7 align-left"></div>
				</div>
				<div class="form_group clearfix">
					<div class="form_item col-xs-2">
						<h3>미사용 100% 환불</h3>
					</div>
					<div class="form_item col-xs-1" style="margin-top: 8px;text-align: left;">
						<input type="radio" onchange="flagChanges();" id="checkUNUSE_REFUND_ALL1" onclick="checkUNUSE_REFUND_ALL(1)" <?php if($UNUSE_REFUND_ALL==1) echo 'checked="checked"';?> name="UNUSE_REFUND_ALL" value="1" />
						<label for="checkUNUSE_REFUND_ALL1"><?=$this->language( 'l_yes')?></label>
					</div>
					<div class="form_item col-xs-1" style="margin-top: 8px;text-align: left;">
						<input type="radio" onchange="flagChanges();" id="checkUNUSE_REFUND_ALL0" onclick="checkUNUSE_REFUND_ALL(0)" <?php if($UNUSE_REFUND_ALL==0) echo 'checked="checked"';?> name="UNUSE_REFUND_ALL" value="0" />
						<label for="checkUNUSE_REFUND_ALL0"><?=$this->language( 'l_no')?></label>
					</div>
					<div class="form_item col-xs-8 align-left"></div>
				</div>
				<div class="form_group clearfix" id="divrange">
					<div class="form_item col-xs-2">
						<h3>환불가능범위</h3>
					</div>
					<div class="form_item col-xs-2" style="margin-top: 8px;text-align: left;">
						<input type="radio" onchange="flagChanges();" id="checkrange1" <?php if($range==1) echo 'checked="checked"';?> onclick="checkrange(1)" name="range" value="1" />
						<label for="checkrange1">전액환불</label>
					</div>
					<div class="form_item col-xs-2" style="margin-top: 8px;text-align: left;">
						<input type="radio" onchange="flagChanges();" id="checkrange2" name="range" value="2" <?php if($range==2) echo 'checked="checked"';?> onclick="checkrange(2)" />
						<label for="checkrange2">부분환불</label>
					</div>
					<div class="form_item col-xs-2" style="margin-top: 8px;text-align: left;">
						<input type="radio" onchange="flagChanges();" id="checkrange3" name="range" value="3" <?php if($range==3) echo 'checked="checked"';?> onclick="checkrange(3)" />
						<label for="checkrange3">환불불가</label>
					</div>
					<div class="form_item col-xs-4 align-left"></div>
				</div>
				<div class="form_group clearfix" id="divmethod1">
					<div class="form_item col-xs-2">
						<h3>환불규정</h3>
					</div>
					<div class="form_item col-xs-2" style="padding-top: 5px;">
						<select name="cancelMarkType1" class="select small full" onchange="changecancelPeriodType(this.value)">
							<option value="BEFORE_USE"
							<?php if($cancelPeriodType=="BEFORE_USE") echo 'selected="selected"';?>><?=$this->language( 'l_ct_BEFORE_USE')?></option>
							<option value="AFTER_7DAYS"
							<?php if($cancelPeriodType=="AFTER_7DAYS") echo 'selected="selected"';?>><?=$this->language( 'l_ct_AFTER_7DAYS')?></option>
							<option value="UNUSE_REFUND_ALL_BEFORE_ONE_DAY"
							<?php if($cancelPeriodType=="UNUSE_REFUND_ALL_BEFORE_ONE_DAY") echo 'selected="selected"';?>><?=$this->language( 'l_ct_UNUSE_REFUND_ALL_BEFORE_ONE_DAY')?></option>
							<option value="DIRECT"
							<?php if($cancelPeriodType=="DIRECT") echo 'selected="selected"';?>>직접입력</option>
						</select>
					</div>
					<div class="form_item col-xs-2 align-left" style="padding-top: 5px;<?php if($cancelPeriodType!="DIRECT") echo 'display: none;' ?>" id="divcancelPeriodType1">
						<select name="cancelPeriodType1" class="select small full">
							<option onchange="flagChanges();" value="DATEPURCHASE"
							<?php if($cancelPeriodType1=="DATEPURCHASE") echo 'selected="selected"';?>>구매일기준</option>
							<option onchange="flagChanges();" value="DATEUSE"
							<?php if($cancelPeriodType1=="DATEUSE") echo 'selected="selected"';?>>이용일기준</option>
						</select>
					</div>
					<div class="form_item col-xs-2 align-left" style="padding-top: 5px;<?php if($cancelPeriodType!="DIRECT") echo 'display: none;' ?>" id="divcancelPeriodType2">
						<select name="cancelPeriodType2" class="select small full">
							<option value="1" <?php if($cancelPeriodType2=="1") echo 'selected="selected"';?>>1일 이내</option>
							<option value="2" <?php if($cancelPeriodType2=="2") echo 'selected="selected"';?>>2일 이내</option>
							<option value="3" <?php if($cancelPeriodType2=="3") echo 'selected="selected"';?>>3일 이내</option>
							<option value="4" <?php if($cancelPeriodType2=="4") echo 'selected="selected"';?>>4일 이내</option>
							<option value="5" <?php if($cancelPeriodType2=="5") echo 'selected="selected"';?>>5일 이내</option>
							<option value="6" <?php if($cancelPeriodType2=="6") echo 'selected="selected"';?>>6일 이내</option>
							<option value="7" <?php if($cancelPeriodType2=="7") echo 'selected="selected"';?>>7일 이내</option>
							<option value="8" <?php if($cancelPeriodType2=="8") echo 'selected="selected"';?>>8일 이내</option>
							<option value="9" <?php if($cancelPeriodType2=="9") echo 'selected="selected"';?>>9일 이내</option>
							<option value="10"<?php if($cancelPeriodType2=="10") echo 'selected="selected"';?>>10일 이내</option>
						</select>
					</div>
					<div class="form_item col-xs-3 align-left"></div>
				</div>
        				<div class="form_group clearfix" id="divmethod2">
        					<div class="form_item col-xs-2">
        						<h3>환불규정</h3>
        					</div>
        					<div class="form_item col-xs-10" id="divrefundRates" style="text-align: left;">
        						<input type="hidden" name="cancelMarkType2" value="DEPENDING_ON_VENDOR" />
        						<input type="button" class="btn hover small" value="<?=$this->language( 'l_add')?>" onclick="addrefundRates(<?=$cancelPolicyId?>)" style="width: 50px; height: 24px; float: right;">
    							<?php foreach ($list_refundrates as $value => $giatri) { ?>
    							<div id="tbrefundRates<?=$giatri[0]?>" class="contBox"style="padding: 5px">
    								<input name="cancelPolicyId<?=$cancelPolicyId?>[]" id="cancelPolicyId<?=$giatri[0]?>" type="hidden" value="<?=$giatri[0]?>" />사용일
    								<input type="text" name="conditionDays<?=$cancelPolicyId?>[]" id="conditionDays<?=$giatri[0]?>" value="<?=$giatri[1]?>" onkeypress='validate(event)' style="width: 50px; height: 24px;margin-right: 10px;margin-left: 5px;" placeholder="" />시간
    								<input type="text"name="conditionTime<?=$cancelPolicyId?>[]" id="conditionTime<?=$giatri[0]?>" value="<?=$giatri[2]?>" style="width: 120px; height: 24px;margin-right: 10px;margin-left: 5px; " placeholder="HH:mm:ss" class="conditionTime" maxlength="8" />환분율
    								<input type="text" class="v-numeric refundRate" maxlength="3" name="refundRate<?=$cancelPolicyId?>[]" id="refundRate<?=$giatri[0]?>" value="<?=$giatri[3]?>" style="width: 50px; height: 24px;margin-right: 10px;margin-left: 5px;" placeholder="70% is 70" />
    									<!-- <input name="cancellable<?=$giatri[0]?>?>" id="cancellable<?=$giatri[0]?>?>" type="checkbox" <?php if($giatri[4]==1) echo'checked="checked"';?> />
    										<label for="cancellable<?=$giatri[0]?>?>">취소가능 여부</label> -->
    								<a onclick="delrefundRates('<?=$giatri[0]?>');" class="btn hover small"> X </a>
    							</div>
    
    							<?php }?>
    						</div>
						</div>
    						<div class="form_group clearfix" id="divmethod3">
    							<div class="form_item col-xs-2">
    								<h3>환불규정</h3>
    							</div>
    							<div class="form_item col-xs-2">
    								<select name="cancelMarkType3" class="select small full">
    									<option value="NONE" <?php if($cancelMarkType=="NONE") echo 'selected="selected"';?>>해당 없음</option>
    									<option value="NOT_CANCELED" <?php if($cancelMarkType=="NOT_CANCELED") echo 'selected="selected"';?>><?=$this->language( 'l_ct_NOT_CANCELED')?></option>
    									<option value="NOT_REFUND_AFTER_RECEIPT" <?php if($cancelMarkType=="NOT_REFUND_AFTER_RECEIPT") echo 'selected="selected"';?>><?=$this->language( 'l_ct_NOT_REFUND_AFTER_RECEIPT')?></option>
    									<option value="NOT_REFUND_AFTER_RESERVATION_CONFIRM" <?php if($cancelMarkType=="NOT_REFUND_AFTER_RESERVATION_CONFIRM") echo 'selected="selected"';?>><?=$this->language( 'l_ct_NOT_REFUND_AFTER_RESERVATION_CONFIRM')?></option>
    								</select>
    							</div>
    							<div class="form_item col-xs-8 align-left"></div>
    						</div>
    						<div class="form_group clearfix" id="divcancelType">
    							<div class="form_item col-xs-2">
    								<h3>환불처리방식</h3>
    							</div>
    							<div class="form_item col-xs-4" style="margin-top: 8px;text-align: left;">
    								<input onchange="flagChanges();" type="radio" <?php if($cancelType=='APPROVAL') echo 'checked="checked"';?> id="checkcancelType2" name="cancelType" value="APPROVAL" />
    								<label for="checkcancelType2">셀러승인후 환불처리 </label>
    								<br>
    								<input onchange="flagChanges();" type="radio" <?php if($cancelType=='AUTO') echo 'checked="checked"';?> id="checkcancelType1" name="cancelType" value="AUTO" />
    								<label for="checkcancelType1">자동환불처리 </label>
    							</div>
    							<div class="form_item col-xs-6 align-left"></div>
    						</div>
    						<div class="form_group clearfix" style="display: none;">
    							<div class="form_item col-xs-2">
    								<h3><?=$this->language( 'l_refundUnusedTicket')?></h3>
    							</div>
    							<div class="form_item col-xs-1" style="margin-top: 8px;">
    								<input onchange="flagChanges();" type="radio" id="checkrefundUnusedTicket1" <?php if($refundUnusedTicket==1) echo 'checked="checked"';?>	name="refundUnusedTicket" value="1" />
    								<label for="checkrefundUnusedTicket1"><?=$this->language( 'l_yes')?></label>
    							</div>
    							<div class="form_item col-xs-1" style="margin-top: 8px;">
    								<input onchange="flagChanges();" type="radio" id="checkrefundUnusedTicket0" <?php if($refundUnusedTicket==0) echo 'checked="checked"';?>	name="refundUnusedTicket" value="0" />
    								<label for="checkrefundUnusedTicket0"><?=$this->language( 'l_no')?></label>
    							</div>
    							<div class="form_item col-xs-8 align-left"></div>
    						</div>
    						<div class="form_group clearfix" style="display: none;">
    							<div class="form_item col-xs-2">
    								<h3><?=$this->language( 'l_refundUnusedTicket')?></h3>
    							</div>
    							<div class="form_item col-xs-1">
    								<input onchange="flagChanges();" type="radio" id="checkrefundOnBusinessDay1" <?php if($refundOnBusinessDay==1) echo 'checked="checked"';?> checked="checked" name="refundOnBusinessDay" value="1" />
    								<label for="checkrefundOnBusinessDay1"><?=$this->language( 'l_yes')?></label>
    							</div>
    							<div class="form_item col-xs-1">
    								<input onchange="flagChanges();" type="radio" id="checkrefundOnBusinessDay0" <?php if($refundOnBusinessDay==0) echo 'checked="checked"';?> name="refundOnBusinessDay" value="0" />
    								<label for="checkrefundOnBusinessDay0"><?=$this->language( 'l_no')?></label>
    							</div>
    							<div class="form_item col-xs-8 align-left"></div>
    						</div>

    						<div class="form_group clearfix">
    							<div class="form_item col-xs-2">
    								<h3><?=$this->language( 'l_contentcancel')?></h3>
    							</div>
    							<div class="form_item col-xs-8">
    								<textarea onchange="flagChanges();" name="cancelNotice" id="cancelNotice" maxlength="100" data-text="<?=$this->language('l_warnname')?>" placeholder="예) *유효기간 내 미사용티켓 100% 환불가능
*유효기간 후 환불불가
*사용한 티켓은 환불 불가능합니다.
 ※패키지(1인 입장권+BIG5)상품은  이용당일에 모두 사용해야하며부분취소 및 부분환불불가"
    								style="height: 80px; resize: none;" class="input full checkMaxLength"><?=$cancelNotice?></textarea>
    
    							</div>
    								<div class="form_item col-xs-2 align-left">
    									<p class="height2 checkMaxLengthView"><?=strlen($cancelNotice)?>/100 <?=$this->language('l_warnname')?></p>
    								</div>
    						</div>
						</div>
						<div class="table_content">
							<table class="table" style="float: right;">
								<tr>
									<td colspan="8">
										<input type="hidden" name="step" id="step" value="3">
										<div class="btnupload">
											<button type="button" style="width: 100px; float: right;" class="btn hover" id="continuelink" data-step="4"><?=$this->language( 'l_continue')?></button>
											<button type="button" style="width: 100px; float: right;margin-right: 5px" class="btn hover "  id="saveTemp" data-step="3"><?=$this->language( 'l_savedraft')?></button>
											<button type="button" style="width: 100px; float: right;margin-right: 5px" class="btn hover "  id="backlink" data-step="2"><?=$this->language( 'l_back')?></button>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</form>
			</div>
		</div>