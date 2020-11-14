<?php
$tickets = [
	'tk1'=>$this->route('editticket1'),
	'tk2'=>$this->route('editticket2'),
	'tk3'=>$this->route('editticket3'),
	'tk4'=>$this->route('editticket4'),
	'tk5'=>$this->route('editticket5')
];
?>
<style type="text/css">
	.divmenutop{
		display: inline-block;		
		width: 150px;
	}	
	.divmenutop a{
		display: block;
		font-weight: bold;
		color: #000;
   		background-color: #FFF;
   		border: 1px solid;
		padding: 10px;
		font-size: 16px;
		text-decoration: none;
	}
	.divmenutop a.active{		
		color: #DB4437;
   		background-color: #f2f2f2;
	}

</style>

<script type="text/javascript">
	$(document).ready(function(){
		localStorage.setItem("flagChange", "0");
		// hàm xử lý link ticket (tiếp tục|đổi link)
		$.fn_ticketcontinue = function(step){
			var tk = 'tk'+step;			
			var sellerProductId = '<?=$sellerProductId?>';
			var tickets = <?=json_encode($tickets)?>;	
			var href="";	
			if(jsData.control == 'ticket1' && jsData.action == 'addticket'){ 
				href="";
			}else
				href=tickets[tk]+'/'+sellerProductId;

			var stepactive = $('.divmenutop .active').attr('data-step');	

			if(jsData.control == 'ticket1' && jsData.action == 'addticket'){
				var ff = document.nf;
				if( !$.trim( $('#divsalechannel').html() ).length ) {
					 $.fn_alert(true, true, "필수 입력사항을 체크 해 주세요.");
		            return false;
		        }
				if( !$.trim( $('#divsearchtags').html() ).length ) {
					 $.fn_alert(true, true, "<?= $this->language('l_warntagsproduct1') ?>");
		            return false;
		        }
				var name = document.getElementById("name").value;
	            if (name == '') {
	                $.fn_alert(true, true, "필수 입력사항을 체크 해 주세요.");
	                $('#name').focus();
	                return false;
	            }
		        ff.submit();
		        return false;
		        
			}
			
			if(jsData.control == 'ticket1' && jsData.action == 'editticket1' ){
				if( !$.trim( $('#divsalechannel').html() ).length ) {
					 $.fn_alert(true, true, "필수 입력사항을 체크 해 주세요.");
		            return false;
		        }
				if( !$.trim( $('#divsearchtags').html() ).length ) {
					 $.fn_alert(true, true, "<?= $this->language('l_warntagsproduct1') ?>");
		            return false;
		        }
				var name = document.getElementById("name").value;
	            if (name == '') {
	                $.fn_alert(true, true, "필수 입력사항을 체크 해 주세요.");
	                $('#name').focus();
	                return false;
	            }
			}

			if(step>stepactive && jsData.control == 'ticket2' && jsData.action == 'editticket2'){
				if( !$.trim( $('#feedback').html() ).length ) {
					 $.fn_alert(true, true, "필수 입력사항을 체크 해 주세요.");
		            return false;
		        }
				var co=0;
				$('#feedback').find('textarea[name^="name"]').each(function(){            
		             if( !$.trim( $(this).val() ).length ) {
		            	$.fn_alert(true, true, "옵션명을 입력하세요. " +$(this).attr('name').slice(4));
		             	co=1;
		             }
		         });  
		        if(co==1)
					return false;
		        var radioValue = $("input[name='representative']:checked").val();
		        if(radioValue==undefined){
		        	 $.fn_alert(true, true, "필수 입력사항을 체크 해 주세요.");
		            return false;
		        }
			}

			if(jsData.control == 'ticket3' && jsData.action == 'editticket3' ){
				var ff = document.nf;

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
				
		        ff.submit();
		        return false;
			}

			if(step>stepactive &&  jsData.control == 'ticket4' && jsData.action == 'editticket4' ){
				if( !$.trim( $('#uploadresult').html() ).length ) {
		        	$.fn_alert(true, true, "<?=$this->language('l_warnimage')?>");
		        	return false;
		        }
				var count = $("#uploadresult div").length;
				if(count>30){ // 1sp = 3div
					$.fn_alert(true, true, "<?=$this->language('l_warnimage3')?>");
		        	return false;
				}

				var count1 = $("#uploadresult1 div").length;
				if(count1>30){ // 1sp = 3div 
					$.fn_alert(true, true, "<?=$this->language('l_warnimage4')?>");
		        	return false;
				}
				var radioValue= $("input[name='representativeimage']:checked").val();
		        if(radioValue==undefined){
		        	$.fn_alert(true, true, "<?=$this->language('l_warnimage1')?>");
		    		return false;
		    	}
		        var radioValue2 = $("input[name='pformat']:checked").val();
				if( !$.trim( $('#feedback').html() ).length && radioValue2=="IMAGE") {
		        	$.fn_alert(true, true, "<?=$this->language('l_warncontent')?>");
		        	return false;
		        }
			}

			if(step<stepactive &&  jsData.control == 'ticket5' && jsData.action == 'editticket5' ){
				if( !$.trim( $('#noteAddr').html() ).length ) {
					$.fn_alert(true, true, "<?=$this->language('l_businessinfoaddress')?>");
					$('#noteAddr').focus();
					return false;
				}
				var externalCouponUseType= document.getElementById("externalCouponUseType").value;
				if(externalCouponUseType == ''){
		        	$.fn_alert(true, true, "<?=$this->language('l_warnexternalCouponUseType')?>");
		        	$('#externalCouponUseType').focus();
		        	return false;
		        }

				if( !$.trim( $('#noteAddr').html() ).length ) {
					 $.fn_alert(true, true, "필수 입력사항을 체크 해 주세요.");
		           return false;
		        }
// 				var atimework= document.getElementById("atimework").value;
// 				if(atimework == ''){
// 		        	$.fn_alert(true, true, "운영시간을 입력하세요");
// 		        	$('#atimework').focus();
// 		        	return false;
// 		        }
				var aphonetable= document.getElementById("aphonetable").value;
				if(aphonetable == ''){
		        	$.fn_alert(true, true, "<?=$this->language('l_warnphonetable')?>");
		        	$('#aphonetable').focus();
		        	return false;
		        }
				if (validatePhone(aphonetable)) {
				}else{
					$.fn_alert(true, true, "<?=$this->language('l_warnphonetable')?>");
		        	$('#aphonetable').focus();
					return false;
				}
				
				var aphoneadvisory= document.getElementById("aphoneadvisory").value;
				if(aphoneadvisory == ''){
		        	$.fn_alert(true, true, "<?=$this->language('l_warnphoneadvisory')?>");
		        	$('#aphoneadvisory').focus();
		        	return false;
		        }
				if (validatePhone(aphoneadvisory)) {
				}else{
					$.fn_alert(true, true, "<?=$this->language('l_warnphoneadvisory')?>");
		        	$('#aphoneadvisory').focus();
					return false;
				}
				
				var aphonecancel= document.getElementById("aphonecancel").value;
				if(aphonecancel == ''){
		        	$.fn_alert(true, true, "<?=$this->language('l_warnphonecancel')?>");
		        	$('#aphonecancel').focus();
		        	return false;
		        }
				if (validatePhone(aphonecancel)) {
				}else{
					$.fn_alert(true, true, "<?=$this->language('l_warnphonecancel')?>");
		        	$('#aphonecancel').focus();
					return false;
				}
				
				var ahotline= document.getElementById("ahotline").value;
				if(ahotline == ''){
		        	$.fn_alert(true, true, "<?=$this->language('l_warnhotline')?>");
		        	$('#ahotline').focus();
		        	return false;
		        }
				if (validatePhone(ahotline)) {
				}else{
					$.fn_alert(true, true, "<?=$this->language('l_warnhotline')?>");
		        	$('#ahotline').focus();
					return false;
				}
				var website= document.getElementById("website").value;
				if(website!="" && isValidURL(website)==false){
					$.fn_alert(true, true, "website false");
		        	$('#website').focus();
		        	return false;
				}
				
				var email= document.getElementById("email").value;
				if(email!="" && $.isEmail(email) == false){
		        	$('#email').focus();
		        	return false;
				}

				var fax= document.getElementById("fax").value;

				var introduction= document.getElementById("introduction").value;
				if(introduction == ''){
		        	$.fn_alert(true, true, "상품소개");
		        	$('#introduction').focus();
		        	return false;
		        }

				var csContactInfo= document.getElementById("csContactInfo").value;
				if(csContactInfo == ''){
		        	$.fn_alert(true, true, "예약안내");
		        	$('#csContactInfo').focus();
		        	return false;
		        }
			}
			
			if(localStorage.getItem("flagChange")==1){	
				//$.fn_ticketconfirm(true, "저장후 이동하시겠습니까?", href);
				
				var ff = document.nf;
				document.getElementById("step").value=step;
		        ff.submit();
			}else{
				window.location.href = href;
			}
		}
		// click đổi link
		$('a.btnactnproduct').on('click', function(){		
			var step = $(this).attr('data-step');
			var stepactive = $('.divmenutop .active').attr('data-step');	
			if(step && stepactive != step){
				$('#step').val(step);
				$.fn_ticketcontinue(step);
			}	
			return false;		
		});
	});
	function validatePhone(value) {
	    var filter = /\(?([0-9]{2})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
	    if (filter.test(value)) {
	        return true;
	    }
	    else {
	        return false;
	    }
	}
</script>
<div class="content_table_detail" style="margin-left: 15px;">
	<div class="divmenutop">
		<a href="<?=$tickets['tk1'].'/'.$sellerProductId?>" data-step="1" class="btnactnproduct <?php if($this->_params['action']=="addticket" || $this->_params['action']=="editticket1") echo "active";?>"><?=$this->language( 'l_top1')?></a>
	</div>
	<div class="divmenutop">
		<a href="<?=$tickets['tk2'].'/'.$sellerProductId?>" data-step="2" class="btnactnproduct <?php if($this->_params['action']=="editticket2") echo "active";?>"><?=$this->language( 'l_top2')?></a>
	</div>
	<div class="divmenutop">
		<a href="<?=$tickets['tk3'].'/'.$sellerProductId?>" data-step="3" class="btnactnproduct <?php if($this->_params['action']=="editticket3") echo "active";?>"><?=$this->language( 'l_top3')?></a>
	</div>
	<div class="divmenutop">
		<a href="<?=$tickets['tk4'].'/'.$sellerProductId?>" data-step="4" class="btnactnproduct <?php if($this->_params['action']=="editticket4") echo "active";?>"><?=$this->language( 'l_top4')?></a>
	</div>
	<div class="divmenutop">
		<a href="<?=$tickets['tk5'].'/'.$sellerProductId?>" data-step="5" class="btnactnproduct <?php if($this->_params['action']=="editticket5") echo "active";?>"><?=$this->language( 'l_top5')?></a>
	</div>
</div>