<?php 
$account = $_SESSION['accountshopping'];
$list_supplier = $this->getData('list_supplier');
$m_key = $this->getData('m_key');
$m_start = $this->getData('m_start');
$m_end = $this->getData('m_end');
$m_supplier = $this->getData('m_supplier');
$m_status = $this->getData('m_status');
?>
<link rel="stylesheet" type="text/css" href="<?=URL_PUBLIC?>css/jquery-ui.css" />
<script type="text/javascript" src="<?=URL_PUBLIC?>js/jquery-ui.js"></script>
<script type="text/javascript">
	$(document).ready(function(){		
		$.onchangetime = function(name){
			var d= new Date();
			$('input.datepick[name="dateend"]').val($.getFormattedDate(d.getFullYear(),(d.getMonth()+1).toString(),d.getDate().toString()));			
			$.datepickMilisecond('input.datepick[name="dateend"]');
			if(name=='today'){
				d.setDate(d.getDate());
			}
			if(name=='week'){
				d.setDate(d.getDate() -7);
			}
			if(name=='month'){
				d.setMonth(d.getMonth() - 1);
			}			
			$('input.datepick[name="datestart"]').val($.getFormattedDate(d.getFullYear(),(d.getMonth()+1).toString(),d.getDate().toString()));	
			$.datepickMilisecond('input.datepick[name="datestart"]');
		}		
		$('.changepick').on('click',function(){
			$(this).closest('td').find('input.btn').removeClass('active');
			$(this).addClass('active');
			$.onchangetime($(this).attr('name'));
		});
		//$('.btn.changepick[name="today"]').click();
		
		// Thay đổi số dòng hiển thị trên một trang
		$('div.revenuestatus').on('change', 'select.select', function(){
			var length = $(this).val();
			var page = 1;
			if(length && page){
				$.fn_ajax('searchSettlementStausAndPagination', {'page':page, 'length': length}, function(result){
					$.fn_result(result);
					return false;
				}, true);
			}
			return false;
		});
		// Thực hiện phân trang
		$('div.ct_content').on('click', '.pagination a', function(){
			var length = $(this).attr('data-length');
			var page = $(this).attr('data-page');
			if(length && page){
				$.fn_ajax('searchSettlementStausAndPagination', {'page':page, 'length': length}, function(result){
					$.fn_result(result);
					return false;
				}, true);
			}
			return false;
		});
		// Hàm trả về tham số
		$.fn_dataForm = function(){	
			var elemnt = $('div.ct_content form.search_member');				
			return {
				'length':'<?=$this->getData('length')?>',
				'page':'1',
				'datestart' : $(elemnt).find('input[name="datestart"]').attr('data-millisecond'),
				'dateend' : $(elemnt).find('input[name="dateend"]').attr('data-millisecond'),
				'supplier' :$(elemnt).find('select[name="supplierSelect"] option:selected').val(),				
				'status' :$(elemnt).find('input[name="status"]:checked').val(),			
			}
		}		
		// Hàm xử lý kết quả trả về		
		$.fn_result = function(data){
			if(data.flag == true){
				$('#settlementstatus tbody').html(data.rows);
				$('div.ct_content .pagination').closest('div.form_group').remove();
				$('div.ct_content').append(data.pagination);
			}
		}
		// Thực hiện tại xuất file excel
		$('button.downloadExcel').on('click', function(result){			
			var tbody = $('.table').find('td.empty');
	        if(tbody.length > 0) {
	            //
	        }else{	
    			var titleName = $('#contents .ct_head h3').text();  
    			var description = $('#contents .ct_head p').text(); 						
    			if(titleName && description){
    				window.open(encodeURI(jsData.urlAjax + 'downloadSettlementStatus?titleName='+titleName+'&description='+description));			
    			}	
	        }		
		});
		// Thực hiện lựa chọn tất cả trong bảng
		$('#tbcheckall').on('click', function(){
			var checked = $(this).get(0).checked;
			$('#settlementstatus tbody input[type="checkbox"]').each(function(){
				$(this).get(0).checked = checked
			});			
		});
		// Thực hiện quyết toán xong
		$('button.settlementdone').click(function(){
			var data = $.fn_dataChecked(3, 'done', '<?=$this->language('l_revenue26')?>');			
			if(data){
				$.fn_changestatus(data, 'settlementdone', ' 개의 정산서를 정산완료상태로 변경합니다');
			}
		});
		// Thực hiện xét duyệt
		$('button.settlementsellerdone').click(function(){
			var data = $.fn_dataChecked(1, 'done', '<?=$this->language('l_revenue25')?>');	
			if(data){				
				$.fn_changestatus(data, 'settlementsellerdone', '<?=$this->language('l_revenue29')?>');
			}			
		});
		// Thực hiện từ chối duyệt
		$('button.settlementsellercancel').click(function(){
			var data = $.fn_dataChecked(1, 'cancel', '<?=$this->language('l_revenue25')?>');
			if(data){
				$.fn_changestatus(data, 'settlementsellercancel', '<?=$this->language('l_revenue27')?>');
			}	
		});
		$.fn_dataChecked = function(status, actname, contentAlert){
			var formdata = [];
			var elemnt = '#settlementstatus tbody input[type="checkbox"]:checked';
			if($(elemnt).length > 0){
				$(elemnt).each(function(){
					var tbtr = $(this).closest('tr');
					var cid = $(tbtr).attr('data-id');
					var cstatus = $(tbtr).attr('data-status');								
					if(cid && $.isNumeric(cid) && (status == cstatus)){
						formdata.push({ 'id': cid, 'status': cstatus, 'actname': actname});
					}else{
						$.fn_alert(true, true, contentAlert);
						formdata = [];
						return false;
					}
				});
				return formdata;
			}else{
				$.fn_alert(true, true, '<?=$this->language('l_listproduct7')?>');
			}
		}
		$.fn_changestatus = function(data, clsname, alert){
			if($('#settlementstatus').attr('data-action') == 'true' && $($.elt_popup+' .confirm').is(':visible')){
				$.fn_confirm(false);
				var page = $('div.pagination a.active').attr('data-page');			
				$.fn_ajax('changeSettlementStatus', {'status': data, 'length': '<?=$this->getData('length')?>', 'page': ((page)?page:1)}, function(result){
					if(result.flag == true){
						$('#settlementstatus').removeAttr('data-action');
						$('#settlementstatus tbody').html(result.rows);
					}
				}, true);
			}else{
				$.fn_confirm(true, {'class':'changeSettlementStatus', 'data-clsname': clsname}, data.length+alert);
				$($.elt_popup).find('.back').val("취소");
				$($.elt_popup).find('.continue').val("확인");	
				$('#settlementstatus').attr('data-action', 'true');				
			}		
		}	
		// Tiếp tục thực hiện thay đổi trạng thái
		$($.elt_popup).on('click', '.confirm .changeSettlementStatus .continue', function(){			
			$('button.'+$(this).attr('data-clsname')).click();
		});	
    });
</script>
<div class="ct_head">
	<h3><?=$this->language('l_managerevenue3')?></h3>
	<p>정산서를 확인하고 관리 할 수 있습니다. </p>
</div>
<div class="ct_content ">
	<div class="form_group">
		<form class="search_member" action="" method="POST">
			<table class="table">
				<tr>
					<th><?=$this->language('l_revenue14')?></th>
					<td colspan="3">
						<select class="select small" name="m_key">
							<option <?php if ($m_key==1) echo 'selected="selected"';?> value="1"><?=$this->language('l_revenue15')?></option>	
							<option <?php if ($m_key==2) echo 'selected="selected"';?> value="2"><?=$this->language('l_revenue05')?></option>	
							<option <?php if ($m_key==3) echo 'selected="selected"';?> value="3"><?=$this->language('l_revenue16')?></option>							
						</select>			
						<input type="text" class="input datepick" name="datestart" value="<?=$m_start?>" readonly="readonly" style="width: 120px;">
						<span>~</span>
						<input type="text" class="input datepick" name="dateend" value="<?=$m_end?>" readonly="readonly" style="width: 120px;">
						<input type="button" class="btn small changepick" name="today" value="<?=$this->language('l_today')?>">
						<input type="button" class="btn small changepick" name="week" value="<?=$this->language('l_1week')?>">
						<input type="button" class="btn small changepick" name="month" value="<?=$this->language('l_1month')?>">
					</td>
					<td rowspan="4" style="line-height: 40px;">
						<input type="submit" class="btn full hover" name="m_search" value="<?=$this->language('l_search')?>">
						<input type="submit" class="btn full hover reset" name="m_reset" value="<?=$this->language('l_reset')?>">
					</td>
				</tr>
				<tr>
					<th><?=$this->language('l_supplier')?></th>				
					<td colspan="3">
						<select name="m_supplier" id="supplier" class="select small">
							<option <?php if ($m_supplier==0) echo 'selected="selected"';?> value="0"><?=$this->language('l_question4')?></option>
							<?php foreach ($list_supplier as $value =>$giatri){?>
							<option <?php if ($m_supplier==$giatri['idx']) echo 'selected="selected"';?> value="<?=$giatri['idx']?>"><?=$giatri['ID']?></option>
							<?php }?>
    					</select>	
					</td>					
				</tr>
				<tr>
					<th><?=$this->language('l_revenue17')?></th>				
					<td colspan="3">	
						<ul class="clearfix">
							<li>
								<input type="radio" id="revenuestatus1" name="m_status" value="0" <?php if ($m_status==0) echo 'checked="checked"';?>>
								<label for="revenuestatus1"><?=$this->language('l_all')?></label>
							</li>
							<li>
								<input type="radio" id="revenuestatus2" name="m_status" value="1" <?php if ($m_status==1) echo 'checked="checked"';?> >
								<label for="revenuestatus2"><?=$this->language('l_revenue10')?></label>
							</li>
							<li>
								<input type="radio" id="revenuestatus3" name="m_status" value="2" <?php if ($m_status==2) echo 'checked="checked"';?>>
								<label for="revenuestatus3"><?=$this->language('l_revenue12')?></label>
							</li>
							<li>
								<input type="radio" id="revenuestatus4" name="m_status" value="3" <?php if ($m_status==3) echo 'checked="checked"';?>>
								<label for="revenuestatus4"><?=$this->language('l_revenue11')?></label>
							</li>	
							<li>
								<input type="radio" id="revenuestatus5" name="m_status" value="4" <?php if ($m_status==4) echo 'checked="checked"';?>>
								<label for="revenuestatus5"><?=$this->language('l_revenue24')?></label>
							</li>						
						</ul>
					</td>					
				</tr>
			</table>
		</form>
	</div>
	<div class="form_group clearfix revenuestatus">		
		<div class="form_table">	
			<div class="table_head bgwhite">
				<div class="ctrl_head clearfix">
					<div class="title col-xs-1">
						<h3><?=$this->language('l_mbtotal').$this->getData('total')?> <?=$this->getData('count')?> <?=$this->language('l_notification16')?></h3>
					</div>
					<div class="icons col-xs-2">
						<select name="" class="select">			
							<option value="20" <?=(($this->getData('length')==20)?'selected':'')?>>20 <?=$this->language('l_notification8')?></option>				
							<option value="50" <?=(($this->getData('length')==50)?'selected':'')?>>50 <?=$this->language('l_notification8')?></option>							
							<option value="100" <?=(($this->getData('length')==100)?'selected':'')?>>100 <?=$this->language('l_notification8')?></option>
						</select>
					</div>
					<div class="icons col-xs-2">
					<?php if($account['role'] == 0){ ?>
						<button type="button" name="" class="btn hover downloadExcel"><?=$this->language('l_Channel26')?></button>	
					<?php }?>	
				 	</div>
				  	<div class="icons col-xs-7 align-right" style="float: right;">
			  		<?php if($account['role'] != 0){ ?>
		  		        <button type="button" class="btn hover settlementsellerdone"><?=$this->language('l_mbconfirm')?></button>
						<button type="button" class="btn hover settlementsellercancel"><?=$this->language('l_revenue18')?></button>
							<style type="text/css">
								#settlementstatus tr th:last-child,#settlementstatus tr td:last-child{display: none !important;}
							</style>
						<?php }else{ ?>
							<button type="button" class="btn hover settlementdone"><?=$this->language('l_revenue19')?></button>
						<?php } ?>
				  	</div>
				</div>
			</div>		
			<div class="table_content scrollbar scrlX clearfix">				
				<table class="table" id="settlementstatus">
					<thead>
						<tr>
							<th><input type="checkbox" id="tbcheckall"></th>						
							<th><?=$this->language('l_accmanage')?></th>													
							<th><?=$this->language('l_revenue17')?></th>													
							<th><?=$this->language('l_seller')?></th>													
							<th><?=$this->language('l_supplier')?></th>													
							<th><?=$this->language('l_revenue05')?></th>
							<th><?=$this->language('l_revenue16')?></th>
							<th><?=$this->language('l_addticket20')?></th>
							<th><?=$this->language('l_revenue20')?></th>
							<th><?=$this->language('l_revenue21')?></th>
							<th><?=$this->language('l_revenue22')?></th>
							<th><?=$this->language('l_revenue23')?></th>
						</tr>
					</thead>
					<tbody><?=$this->getData('settlementstatus')?></tbody>
				</table>
			</div>
		</div>
	</div>
	<?=$this->getData('pagination')?>
</div>