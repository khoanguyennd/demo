<?php
$rowpage = 50;
$page = 1;
$user = $this->getData('user');

$m_status = $this->getData('m_status');
$m_role = $this->getData('m_role');
$m_career1 = $this->getData('m_career1');
$m_career2 = $this->getData('m_career2');
$m_key = $this->getData('m_key');
$m_name = $this->getData('m_name');

?>
<script type="text/javascript">

function goPopup(){
	// 주소검색을 수행할 팝업 페이지를 호출합니다.
	// 호출된 페이지(jusoPopup_utf8.php)에서 실제 주소검색URL(http://www.juso.go.kr/addrlink/addrLinkUrl.do)를 호출하게 됩니다.
	var pop = window.open("<?=URL_BASE?>/php_sample/jusoPopup_utf8.php","pop","width=570,height=420, scrollbars=yes, resizable=yes"); 
	// 모바일 웹인 경우, 호출된 페이지(jusoPopup_utf8.php)에서 실제 주소검색URL(http://www.juso.go.kr/addrlink/addrMobileLinkUrl.do)를 호출하게 됩니다.
    //var pop = window.open("/jusoPopup_utf8.php","pop","scrollbars=yes, resizable=yes"); 
}

function onloadUsers(){
	window.location.reload();
}

function showPopupaddUser(){
	var pop = window.open("<?=$this->route('adduser')?>","pop","width=800,height=650, scrollbars=no, resizable=no"); 
}
function showPopueditUser(id){
	var pop = window.open("<?=$this->route('edituser')?>/"+id,"pop1","width=800,height=650, scrollbars=no, resizable=no"); 
}

$(document).ready(function(){
	// Hàm lấy danh sách id đã checked
	$.getCheckedId = function(){
		var arid = [];
		$('#tablemember td input:checked').each(function(index, value){
			arid[index] = parseInt($(value).val(),10);
		});
		return arid;
	}
	// Lựa chọn tất cả dòng
	$('#tablemember').on('click','.selectAll',function(){
		$('#tablemember td input.checked0').click()
	});	
	// Hàm thay đổi trạng thái xét duyệt
	$('div.form_group.member').on('click','.statusconfirm',function(){
		var arid = $.getCheckedId();	
		if(arid.length > 0){
			$.fn_ajax('changeStatus', {'arid':arid}, function(result){				
				if(result.flag == true){					
					$.each(arid, function(index, value){
						//$('#listusers .checkbox[data-checkbox="'+value+'"]').prop("checked", false);
						$('#listusers .checkbox[data-checkbox="'+value+'"]').html("-");
						$('#listusers .status[data-status="'+value+'"]').html(result.status);
					});
				}
			}, true);
		}
	});
	// Thực hiện download file excel
	$('.btn.dowloadexcel').on('click', function(){			
		var tbody = $('.table').find('td.empty');
        if(tbody.length > 0) {
            //
        }else{	
    		var titleName = $('#contents .ct_head h3').text();  
    		var description = $('#contents .ct_head p').text();  			
    		if(titleName && description){
    			window.open(encodeURI(jsData.urlAjax + 'downloadMember?titleName='+titleName+'&description='+description));
    		}
        }
		
	});
	// Thực hiện refresh form tìm kiếm
	$('#contents .btn.reset').click(function(){
		$('#contents .search_member')[0].reset();
	});
	// Thực hiện tìm kiếm member account
// 	$('#contents .search_member').submit(function(){
// 		var data = $.fn_dataForm();		
// 		if(data.status && data.role && data.col){
// 			$.fn_ajax('searchAndPagination', data, function(result){
// 				$.fn_result(result);				
// 			}, true);
// 		}else{
//			$.fn_alert(true, true, '<?=$this->language('l_notification5')?>')
// 		}	
// 		return false;
// 	});
	// Thực hiện đổi trang
	$('div.ct_content').on('click', '.pagination a', function(){
		var length = $(this).attr('data-length');
		var page = $(this).attr('data-page');
		if(length && page){
			$.fn_ajax('memberPagination', {'page':page, 'length': length}, function(result){
				$.fn_result(result);
				return false;
			}, true);
		}
		return false;
	});
	// Thay đổi số dòng hiển thị trên một trang
	$('div.member').on('change', 'select.select', function(){		
		var length = $(this).val();
		var page = 1;
		if(length && page){
			$.fn_ajax('memberPagination', {'page':page, 'length': length}, function(result){
				$.fn_result(result);
				return false;
			}, true);
		}
		return false;
	});
	// Hàm trả về dữ liệu form
	$.fn_dataForm = function(){
		var element = $('#contents .search_member');
		return {
			'length':'<?=$this->getData('length')?>',
			'page':'1',
			'status': $(element).find('input[name="status"]:checked').val(),
		 	'role': $(element).find('input[name="role"]:checked').val(),
		 	//'col': $('#selectKey option:selected').val(),
		 	'keyword':$(element).find('input[name="keyword"]').val(),
		};
	}
	// Hàm xử lý kết quả trả về		
	$.fn_result = function(data){		
		if(data.flag == true){
			$('#tablemember tbody').html(data.rows);				
			$('div.ct_content .pagination').closest('div.form_group').remove();
			$('div.ct_content').append(data.pagination);
		}
	}
});

</script>

<div class="ct_head">
	<h3><?=$this->language('l_managemember')?></h3>
	<p><?=$this->language('l_managemember1')?></p>
</div>
<div class="ct_content">
	<div class="form_group">
		<form class="search_member" action="" method="POST" name="mform">
			<table class="table">
				<tr>
					<th><?=$this->language('l_status')?></th>
					<td>					
						<ul class="clearfix">
							<li>
								<input type="radio" id="statusall" name="m_status" checked="checked" <?php if($m_status==-1) echo 'checked="checked" ';?> value="-1">
								<label for="statusall"><?=$this->language('l_all')?></label>
							</li>
							<li>
								<input type="radio" id="statusunactive" name="m_status" <?php if($m_status==0) echo 'checked="checked" ';?> value="0">
								<label for="statusunactive"><?=$this->language('l_status1')?></label>
							</li>
							<li>
								<input type="radio" id="statusactive" name="m_status" <?php if($m_status==1) echo 'checked="checked" ';?> value="1">
								<label for="statusactive"><?=$this->language('l_status_6')?></label>
							</li>
						</ul>
					</td>
					<th><?=$this->language('l_accrole')?></th>
					<td>
						<ul class="clearfix">
							<li>
								<input type="radio" id="roleall" name="m_role" <?php if($m_role==-1) echo 'checked="checked" ';?> value="-1">
								<label for="roleall"><?=$this->language('l_all')?></label>
							</li>
							<li>
								<input type="radio" id="roleseller" name="m_role" <?php if($m_role==1) echo 'checked="checked" ';?> value="1">
								<label for="roleseller"><?=$this->language('l_seller')?></label>
							</li>
							<li>
								<input type="radio" id="rolesupplier" name="m_role" <?php if($m_role==2) echo 'checked="checked" ';?> value="2">
								<label for="rolesupplier"><?=$this->language('l_supplier')?></label>
							</li>
							<li>
								<input type="radio" id="rolemaster" name="m_role" <?php if($m_role==0) echo 'checked="checked" ';?> value="0">
								<label for="rolemaster"><?=$this->language('l_master')?></label>
							</li>
						</ul>
					</td>
					<td rowspan="3" style="line-height: 40px;width: 100px;">
						<input type="submit" name="m_search" class="btn full hover" name="" value="<?=$this->language('l_search')?>">
						<input type="submit" name="m_reset" class="btn full hover reset" name="" value="<?=$this->language('l_reset')?>">
					</td>
				</tr>
				<tr>
					<th><?=$this->language('l_typebusinees1')?></th>				
					<td colspan="3">	
						<input type="text" class="input" name="m_career1" placeholder="<?=$this->language('l_typebusinees2')?>" value="<?=$m_career1?>">	
						<input type="text" class="input" name="m_career2" placeholder="<?=$this->language('l_career')?>" value="<?=$m_career2?>">			
					</td>				
				</tr>
				<tr>
					<th><?=$this->language('l_keyword')?></th>
					<td>
						<select name="m_key" class="select small full">
							<option <?php if($m_key==-1) echo 'selected="selected"';?> value="-1"><?=$this->language('l_question4')?></option>
							<option <?php if($m_key==1) echo 'selected="selected"';?> value="1"><?=$this->language('l_companyname')?></option>
							<option <?php if($m_key==2) echo 'selected="selected"';?> value="2"><?=$this->language('l_id')?></option>
							<option <?php if($m_key==3) echo 'selected="selected"';?> value="3"><?=$this->language('l_acctable5')?></option>
							<option <?php if($m_key==4) echo 'selected="selected"';?> value="4"><?=$this->language('l_titlepersonresname')?></option>
						</select>
					</td>
					<td colspan="2">	
						<input type="text" class="input full" name="m_name" placeholder="<?=$this->language('l_keyword')?>" value="<?=$m_name?>">				
					</td>				
				</tr>
			</table>
		</form>
	</div>
	<div class="form_group clearfix member">
		<div class="form_table">
			<div class="table_head bgwhite">
				<div class="ctrl_head clearfix align-left">
					<div class="title col-xs-1">
						<h3><?=$this->language('l_mbtotal').$this->getData('total')?> <?=$this->language('l_notification16')?></h3>
					</div>
					<div class="title col-xs-2">
						<select name="" class="select">	
							<option value="20" <?=(($this->getData('length')==20)?'selected':'')?>>20 <?=$this->language('l_notification8')?></option>							
							<option value="50" <?=(($this->getData('length')==50)?'selected':'')?>>50 <?=$this->language('l_notification8')?></option>							
							<option value="100" <?=(($this->getData('length')==100)?'selected':'')?>>100 <?=$this->language('l_notification8')?></option>
						</select>
					</div>
					<div class="title col-xs-2">
						<button type="button" name="" class="btn hover dowloadexcel" style="height: 29px;width: 120px;"><?=$this->language('l_Channel26')?></button>
					</div>						
					<div class="icons col-xs-7 align-right">
						<button type="button" name="" class="btn hover statusconfirm" style="height: 29px;width: 120px;"><?=$this->language('l_mbconfirm')?></button>
						<button type="button" name="" class="btn hover small" onclick="showPopupaddUser()" style="height: 29px;width: 120px;"><?=$this->language('l_postlive')?></button>
					</div>
				</div>
			</div>
			
			
			<div  class="table_content scrollbar scrlX">
				<table class="table" id="tablemember">
					<thead>
						<tr>
							<th style="width:40px;"><input type="checkbox" name="checkbox" class="selectAll" value=""></th>
							<th style="min-width: 60px;"><?=$this->language('l_accmanage')?></th>
							<th style="min-width: 70px;"><?=$this->language('l_status')?></th>
							<th style="min-width: 70px;"><?=$this->language('l_id')?></th>
							<th style="min-width: 70px;"><?=$this->language('l_accrole')?></th>
							<th style="min-width: 70px;"><?=$this->language('l_acctable10')?></th>
							<th style="min-width: 100px;"><?=$this->language('l_acctable5')?></th>
							<th style="min-width: 100px;"><?=$this->language('l_companyname')?></th>
							<th style="min-width: 100px;"><?=$this->language('l_acctable6')?></th>
							<th style="min-width: 100px;"><?=$this->language('l_acctable7')?></th>
							<th style="min-width: 100px;"><?=$this->language('l_accountinfo')?></th>
							<th style="min-width: 100px;"><?=$this->language('l_acctable3')?></th>
							<th style="min-width: 100px;"><?=$this->language('l_phonenumeric')?></th>
							<th style="min-width: 100px;"><?=$this->language('l_email')?></th>
						</tr>
					</thead>
					<tbody id="listusers">
					<?=$this->getData('memberList')?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?=$this->getData('pagination')?>
</div>