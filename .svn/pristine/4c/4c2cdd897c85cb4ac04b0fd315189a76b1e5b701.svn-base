<?php 
$account = $_SESSION['accountshopping'];
?>
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
		// Thực hiện thay đổi password
		$('#changepw').on('submit', function(){
			var pass = $(this).find('input[name="password"]').val();
			var cpass = $(this).find('input[name="confirmpassword"]').val();
			var aID = $(this).find('input[name="aid"]').val();
			if(pass && cpass && aID){
				if ($.validatePW(pass)){
					if(pass == cpass){
    					$.fn_ajax('changepwlogin', {'password':pass, 'aID':aID}, function(result){					
    						if(result.flag == true){
        						<?php if($account['temp']==1){ ?>
        							$.fn_alert(true, true, "비밀번호가 변경되었습니다.<br>재로그인 해주세요.");
        							$("#tempUser").val(1);
        						<?php }else{ ?>
        							$.fn_alert(true, true, "<?=$this->language('l_warnpw5')?>");
        						<?php } ?>
    					    }else{
    					    	$.fn_alert(true, false, "<?=$this->language('l_warnpw4')?>");	
    					    }	
    					});
					}else{
						$.fn_alert(true, true, "<?=$this->language('l_warnpw3')?>");
					}	
				}else{
					$.fn_alert(true, true, "<?=$this->language('l_warnpassword')?>");
				}
				
			}else{
				$.fn_alert(true, true, "<?=$this->language('l_inputpw')?>");
			}			
			return false;
		});
		// Thực hiện thêm mới form thêm người phụ trách
		$('#addperson').on('click', function(){
			var elmt = '#tab2a .tab_bottom .forminput';
			var row = $(elmt).find('div.frrow:first-child').clone();
			$(row).find('div.rmclass').removeClass('hiden');
			$(row).find('div.row.rmclass').attr({'data-action':'addperson', 'data-perid':'0'});
			$(row).find('input[type="text"]').val('').removeAttr('disabled');
			$(row).find('input.hiden').removeClass('hiden');
			$(row).find('input.sendCode').removeAttr('hidden');
			$(row).find('input.codeConfirm').removeAttr('hidden');			
			$(row).find('input.changeEmail').attr('hidden', 'hidden');
			$(row).find('.control').removeClass('hiden');

			$(row).find('input.btnsave').attr({'data-perid':'0'});
			$(row).find('input.btnsave').removeAttr('hidden');

			$(row).find('input.btncancel').removeAttr('hidden');			
			$(row).find('input.btncancel').attr({'data-perid':'0'})

			$(row).find('input.btnedit').attr('hidden', 'hidden');
			$(row).find('input.btndelete').attr('hidden', 'hidden');			

			$(row).find('.icons .btnedit').addClass('hiden');
			$(row).find('.row i').remove();
			$(elmt).append(row);
			return false;
		});	
		// Thực hiện hiển thị form chỉnh sửa người phụ trách đã tồn tại
		$('#changeperson').on('click', '.btnedit', function(){
			var parent = $(this).closest('div.form_group.frrow');
			$(parent).find('div.row.rmclass').attr('data-excute','true');
			$(parent).find('div.row').attr('data-action', 'editperson');
			$(parent).find('input[name="aperson"]').removeAttr('disabled');
			$(parent).find('input[name="aphone"]').removeAttr('disabled');
			$(parent).find('input.hiden').removeClass('hiden');
			$(parent).find('.control').removeClass('hiden');
			$(parent).find('input.changeEmail').removeAttr('hidden');
			$(parent).find('input.sendCode').attr('hidden', 'hidden');
			$(parent).find('input.codeConfirm').removeAttr('hidden');
			$(parent).find('.icons .btnedit').addClass('hiden');
			$(parent).find('input.btnedit').attr('hidden', 'hidden');
			$(parent).find('input.btndelete').attr('hidden', 'hidden');
			$(parent).find('input.btnsave').removeAttr('hidden');
			$(parent).find('input.btncancel').removeAttr('hidden');
			$(parent).find('.row i').remove();
			return false;
		});
		
		// Thực hiện đóng hoặc xóa form người phụ trách
		$('#changeperson').on('click', '.btnclose, .btncancel', function(){
			$(this).closest('div[data-perid="0"]').remove();
			var parent = $(this).closest('div.form_group.frrow');
			var action = $(parent).find('div.row').attr('data-action');

			$(parent).find('input[type="text"]').attr('disabled','disabled');
			$(parent).find('input.btnedit').removeAttr('hidden');
			$(parent).find('input.btndelete').removeAttr('hidden');
			$(parent).find('input.btnsave').attr('hidden', 'hidden');
			$(parent).find('input.btncancel').attr('hidden', 'hidden');
			$(parent).find('input.sendCode').attr('hidden', 'hidden');
			$(parent).find('input.changeEmail').attr('hidden', 'hidden');
			$(parent).find('input.codeConfirm').attr('hidden', 'hidden');
			if(!action){
				$(parent).remove();
			}else{
				if(action == 'editperson' || action == 'changeEmail'){
					$(parent).find('div.row').attr({'data-action':'viewperson'});					
					$(parent).find('.icons .btnedit').removeClass('hiden');
					$(parent).find('.row i').remove();
					document.getElementById("changeperson").reset();
					return false;
				}
				if(action == 'viewperson'){
					var pid = $(parent).find('div.row').attr('data-perid');
					var pemail = $(parent).find('input[name="aemail"]').val();
					$.fn_confirm(true, {'class':'deleteperson','data-perid':pid, 'data-peremail':pemail}, "<?=$this->language('l_areyousure')?>");
					return false;
				}				
			}
			return false;
		});
		// Thực hiện đóng hoặc xóa form người phụ trách
		$($.elt_popup).on('click', '.confirm .deleteperson input.continue', function(){
			var pid = $(this).attr('data-perid');
			var pemail = $(this).attr('data-pemail');	
			if($.isEmail(pemail) == false){
				return false;
			}			
			if(pid && pemail){
				$.fn_confirm(false);
				$.fn_ajax('deletePerson', {'pid':pid, 'pemail':pemail},function(result){
				    if(result.flag == true){
				    	var element = '#changeperson .forminput';
				    	if($(element + ' > div.form_group').length == 1){
				    		$(element + ' div.rmclass').addClass('hiden');
				    	}else{
				    		$(element +' .row[data-perid="'+result.pid+'"]').closest('div.form_group.frrow').remove();
				    	}

				    	// load lại page, chưa làm
				    }else{	
				    	$.fn_alert(true, true, "<?=$this->language('l_warnrpersonerror')?>");
				    }			 
				});
			}
			return false;
		});	
		// Gửi mã code tới email
		$('#changeperson').on('click', '.btn.sendCode', function(){
			var elmt = $(this).closest('div.row');
			var aperson = $(elmt).find('input[name="aperson"]').val();			
			var aemail = $(elmt).find('input[name="aemail"]').val();
			// Kiểm tra email
			if($.isEmail(aemail)==false){				
				return false;
			}
			if(aperson && aemail){				
				$.fn_ajax('sendCode', {'aemail':aemail, 'aperson':aperson},function(result){
				    if(result.flag == true){	
				    	$(elmt).find('input[name="aemail"]').attr('disabled', 'disabled');			    
				    	$.fn_alert(true, true, "<?=$this->language('l_confirmemail')?>");
				    	$(elmt).find('input.sendCode').attr('hidden','hidden');
				    	$(elmt).find('input.changeEmail').removeAttr('hidden');
				    }else{	
				    	$.fn_alert(true, true, "<?=$this->language('l_exitemail')?>");
				    }			 
				});
			}else{
				$.fn_alert(true, true, "<?=$this->language('l_inputperson_responsible')?>");
			}
			return false;
		});
		// Thay đổi địa chỉ email
		$('#changeperson').on('click', 'input.changeEmail', function(){
			var elmt = $(this).closest('div.row'); 
			$(this).attr('hidden', 'hidden');
			$(elmt).find('input.sendCode').removeAttr('hidden');
			$(elmt).attr('data-action', 'changeEmail');
		   //$(elmt).find('input[name="aemail"]').closest('div.inputconfirm').find('i').remove();
			$(elmt).find('input[name="aemail"]').removeAttr('disabled').focus();
			$(elmt).find('input[name="accode"]').val('').removeAttr('disabled');			
			return false;
		});
		// Kiểm tra mã code được gửi qua email trùng khớp
		$('#changeperson').on('click', '.btn.codeConfirm',function(){
			var elmt = $(this).closest('div.row');					
			var aemail = $(elmt).find('input[name="aemail"]').val();
			var accode = $(elmt).find('input[name="accode"]').val();				
			if($.isEmail(aemail) == false){
				return false;
			}
			if(accode == ''){
				$.fn_alert(true, true, "<?=$this->language( 'l_inputcodeconfirm')?>");			
				return;
			}
			if(aemail && accode){
				var elmtaccode = $(elmt).find('input[name="accode"]');				
				$.fn_ajax('checkCode', {'accode':accode, 'aemail':aemail}, function(result){	
					if(result.flag == true){
						$.fn_check($(elmt).find('input[name="aemail"]'), result.flag);
						$.fn_check(elmtaccode, result.flag);
						$(elmt).attr('data-action', 'editperson');
						//$(elmt).find('input[name="acemail"]').attr('disabled', 'disabled');
						$(elmt).find('input[name="accode"]').attr('disabled', 'disabled');
					}else{
						$.fn_check(elmtaccode, false);
					}					
				}, true);
			}
		});
		// Thực hiện thay đổi hoặc thêm mới người phụ trách
		$('#changeperson').on('click', '.btnsave', function(){
			var perid=$(this).attr('data-perid');
			var parent = this;
			var data = [];
			var flag = false;
			$('#changeperson').find('div.row.rmclass[data-perid="'+perid+'"]').each(function(index, value){
				inputemail = $(value).find('input[name="aemail"]');
				inputaccode = $(value).find('input[name="accode"]');
				inputVal = {
					'aperson': $(value).find('input[name="aperson"]').val(), 
					'aphone': $(value).find('input[name="aphone"]').val(), 
					'aemail': $(inputemail).val(), 
					'accode': $(inputaccode).val(),
					'action': $(value).attr('data-action'),
					'perid': $(value).attr('data-perid')
				};
				data[index] = inputVal;
				if(inputVal.action == "addperson" && (inputVal.aperson == '' || inputVal.aphone == '' || inputVal.aphone == '' || inputVal.aemail == '' || inputVal.accode == ''))
				{	
					$.fn_alert(true, true, "<?=$this->language('l_require_input_all')?>");					
					return false;
				}				
				// if(inputVal.aperson == ''){
				// 	$.fn_alert(true, true, "<?=$this->language('l_inputperson_responsible')?>");					
				// 	return false;
				// }
				// if(inputVal.aphone == ''){
				// 	$.fn_alert(true, true, "<?=$this->language('l_inputphone')?>");
				// 	return false;
				// }
				if(inputVal.action!="editperson"){
    				if(inputVal.aemail == ''){
    					$.fn_alert(true, true, "<?=$this->language('l_inputemail')?>");
    					return false;
    				}				
    				if(inputVal.accode == ''){
    					$.fn_alert(true, true, "<?=$this->language('l_inputcodeconfirm')?>");
    					return false;
    				}				
    				if($(inputaccode).attr('data-check') != 'true'){
    					$.fn_alert(true, true, "<?=$this->language('l_warnemail1')?>");
    					return false;
    				}
				}
				
				flag = true;
			});	
			console.log(data);
			if(flag == true && data.length > 0){
				$.fn_ajax('changePerson', {'persons':data}, function(result){					
					if(result.flag == true){
						$.fn_alert(true, true, "<?=$this->language('l_warnrperson')?>");
						$($.elt_popup).find('.alert').addClass('autoreload');
					}else{
						$.fn_alert(true, true, "<?=$this->language('l_warnrpersonfailed')?>");
					}
				});
			}
			return false;
		});

		$('#changeperson').on('click', '.btndelete', function(){			
			var dataId = $(this).attr('data-perid');
			var pemail = $(this).attr('data-peremail');
			if(dataId > 0){
				$.fn_confirm(true, {'class':'deleteperson','data-perid':dataId, 'data-pemail':pemail}, "<?=$this->language('l_conform_delete_responsible')?>");
				$($.elt_popup).find('.back').val("취소");
				$($.elt_popup).find('.continue').val("확인");			
			}			
		});

		// Thực hiện thêm mới người dùng
		$('#updateuser').on('click', function(){	
			// kiểm tra id
			
// 			var acompany=$('#acompany').val();
// 			if ( acompany == "" ) {
//				$.fn_alert(true, true, "<?=$this->language( 'l_inputcompany')?>");
// 				return false;
// 			}
// 			var asperson=$('#asperson').val();	
// 			if ( asperson == "" ) {
//				$.fn_alert(true, true, "<?=$this->language( 'l_inputperson_surrogate')?>");
// 				return false;
// 			}
// 			var acareer1=$('#acareer1').val();	
// 			var acareer2=$('#acareer2').val();	
// 			if ( acareer1 == "" ) {
//				$.fn_alert(true, true, "<?=$this->language( 'l_inputcareer')?>");
// 				return false;
// 			}
// 			if ( acareer2 == "" ) {
//				$.fn_alert(true, true, "<?=$this->language( 'l_inputcareer')?>");
// 				return false;
// 			}
// 			var abank = $('#abank').val();
// 			if(abank == 0){
//				$.fn_alert(true, true, "<?=$this->language( 'l_abankname')?>");
// 				return false;
// 			}
// 			var abankname = $('#abankname').val();
// 			if(abankname == ""){
//				$.fn_alert(true, true, "<?=$this->language( 'l_inputabank')?>");
// 				return false;
// 			}
// 			var abanknumber = $('#abanknumber').val();
// 			if(abanknumber == ""){
//				$.fn_alert(true, true, "<?=$this->language( 'l_inputabanknumber')?>");
// 				return false;
// 			}
// 			$('#frmupdateuser').submit();
			// kiểm tra id			
			var acompany=$('#acompany').val();			
			var asperson=$('#asperson').val();			
			var acareer1=$('#acareer1').val();	
			var acareer2=$('#acareer2').val();				
			var abank = $('#abank').val();			
			var abankname = $('#abankname').val();			
			var abanknumber = $('#abanknumber').val();
			var noteAddr = $('#noteAddr p').length;
			var aphonetable = $('#aphonetable').val();
			if(acompany && asperson && acareer1 && acareer2 && abank && abankname && abanknumber && noteAddr>0 && aphonetable){
				$('#frmupdateuser').submit();
			}else{
				$.fn_alert(true, true, '필수입력항목을 모두 입력해주세요.');
			}	
            		
		});

		// Check vào ô giống sđt bàn
		$('body').on('click','.landlinebumber', function(){
			var aphone = '';
			if($(this).get(0).checked == true){
				aphone = $('#aphonetable').val();
			}
			$(this).closest('div.form_group').find('input[type="text"]').attr('readonly', true);
			$(this).closest('div.form_group').find('input[type="text"]').val(aphone).focus();
		});
		$("#changeabank").click(function(){
			$("#changeabank").css("display", "none");
			$("#confirmabank").css("display", "");
		});
		
		$("#confirmabank").click(function(){
			$("#changeabank").css("display", "");
			$("#confirmabank").css("display", "none");
		}); 
		
		$("#aphonetable").keyup(function(){
			if ($("#checkhotline").is(':checked'))
				$("#checkhotline").closest('div.form_group').find('input[type="text"]').val($(this).val());
	    	if ($("#checkphoneadvisory").is(':checked'))	
	    		$("#checkphoneadvisory").closest('div.form_group').find('input[type="text"]').val($(this).val());
        	if ($("#checkphonecancel").is(':checked'))	
        		$("#checkphonecancel").closest('div.form_group').find('input[type="text"]').val($(this).val());
		});
		// Thay đổi số dòng hiển thị trên một trang
		$('div.listsuplier').on('change', 'select.select', function(){
			var length = $(this).val();
			if(length){
				$.fn_ajax('paginationlistsuplier', {'page':1, 'length': length}, function(result){
					if(result.flag == true){
						document.getElementById('listsuplierbody').innerHTML=result.divsupllier;	
						document.getElementById('divpaging').innerHTML=result.pagination;
					}
				}, true);
			}
			return false;
		});
		
	});

function goPopup(){
	// 주소검색을 수행할 팝업 페이지를 호출합니다.
	// 호출된 페이지(jusoPopup_utf8.php)에서 실제 주소검색URL(http://www.juso.go.kr/addrlink/addrLinkUrl.do)를 호출하게 됩니다.
	var pop = window.open("<?=URL_BASE?>/php_sample/jusoPopup_utf8.php","pop","width=570,height=420, scrollbars=yes, resizable=yes"); 
	// 모바일 웹인 경우, 호출된 페이지(jusoPopup_utf8.php)에서 실제 주소검색URL(http://www.juso.go.kr/addrlink/addrMobileLinkUrl.do)를 호출하게 됩니다.
    //var pop = window.open("/jusoPopup_utf8.php","pop","scrollbars=yes, resizable=yes"); 
}

function onloadSuplliers(){
	location.reload();
}
function onloadSuplliers1(checked){
	 runAjax('setSession', {'checknotuse': checked}, function (result) { 
		 location.reload();
	  });
	
}

function showPopupaddSupplier(){
	var pop = window.open("<?=$this->route('supplier')?>","pop","width=800,height=780, scrollbars=no, resizable=no"); 
}
function showPopupeditSupplier(id){
	var pop = window.open("<?=$this->route('supplier')?>/"+id,"pop1","width=800,height=780, scrollbars=no, resizable=no"); 
}
function showPopupallSupplier(){
	var pop = window.open("<?=$this->route('allsupplier')?>","pop","width=500,height=400, scrollbars=no, resizable=no"); 
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

//Chuyển hướng khi lưu thành công
setTimeout(function () {
    var urlstep = $('#locationurlstep').attr('data-urlstep');
    if (urlstep) {
        $.fn_alert(true, true, "정보가 변경되었습니다.");
    }
}, 500);
</script>
<script type="text/javascript">
	$('#uploadfile').on('click', function(){
			$('#change_files_excel').trigger('click'); 
		});
</script>



<?php $account = $_SESSION['accountshopping']; ?>
<div class="ct_head" id="locationurlstep" data-urlstep="<?=$this->getData('urlstep')?>">
	<h3><?=$this->language('l_manageinfo')?></h3>
	<p><?=$this->language('l_manageinfodescription')?></p>
</div>

<div class="ct_content">
	<div class="form_tab">
		<div class="tab_head">
			<ul class="clearfix">
				<li><a href="#tab1" class="active" data-tab="tab1" title=""><?=$this->language('l_titleusetbridge')?></a></li>				
				<li style="<?php if($account['temp']==1) echo 'pointer-events:none;opacity:0.6;';?>" ><a href="#tab2" data-tab="tab2" title="" ><?=$this->language('l_titlepersonresponsible')?></a></li>				
				<li style="<?php if($account['temp']==1) echo 'pointer-events:none;opacity:0.6;';?>" ><a href="#tab3" data-tab="tab3" <?php if($account['role']==0) echo 'style="display:none;"';?> title=""><?=$this->language('l_businessinfo')?></a></li>				
				<li style="<?php if($account['temp']==1) echo 'pointer-events:none;opacity:0.6;';?>" ><a href="#tab4" data-tab="tab4" <?php if($account['role']!=1) echo 'style="display:none;"';?> title=""><?=$this->language('l_supplierinfo')?></a></li>
			</ul>
			<script type="text/javascript">
				$(document).ready(function(){					
					if(location.hash){
						$('.tab_head a').removeClass('active');
						$('.tab_head a[href='+location.hash+']').addClass('active');
						$('.tab_content > div').hide();
						$(location.hash+'a').show();
					}
					$(".form_tab .tab_head").on('click', 'a', function(){
						var id = $(this).attr('data-tab');
						if(id){
							$(this).closest('ul').find('a').removeClass('active');
							$(this).addClass('active');
							$('.tab_content > div').hide();
							$('#'+id+'a').show();
						}
					});
				});
			</script>
		</div>
		<div class="tab_content scrollbar">
		<?php 
		require 'account/accountTab1.php';
		require 'account/accountTab2.php';
		if($account['role']>0){
		    require 'account/accountTab3.php';
		}	
		if($account['role']==1){
		    require 'account/accountTab4.php';
		}
		?>
		</div>
	</div>
</div>