<?php 
$list_supplier = $this->getData('list_supplier');
$list_channel = $this->getData('list_channel');
$m_start = $this->getData('m_start');
$m_end = $this->getData('m_end');
$m_supplier = $this->getData('m_supplier');
$m_channel = $this->getData('m_channel');
?>
<link rel="stylesheet" type="text/css" href="<?=URL_PUBLIC?>css/jquery-ui.css" />
<script type="text/javascript" src="<?=URL_PUBLIC?>js/jquery-ui.js"></script>
<script type="text/javascript">
	$(document).ready(function(){		
		$.onchangetime = function(name){
			var d= new Date();
			$('input.datepick[name="dateend"]').val($.getFormattedDate(d.getFullYear(),(d.getMonth()+1).toString(),d.getDate().toString()));			
			$.datepickMilisecond('input.datepick[name="dateend"]');
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
		$('div.settlement').on('change', 'select.select', function(){
			var length = $(this).val();
			var page = 1;
			if(length && page){
				$.fn_ajax('searchSettlementAndPagination', {'page':page, 'length': length}, function(result){
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
				$.fn_ajax('searchSettlementAndPagination', {'page':page, 'length': length}, function(result){
					$.fn_result(result);
					return false;
				}, true);
			}
			return false;
		});
		// Hàm xử lý kết quả trả về		
		$.fn_result = function(data){
			if(data.flag == true){
				$('#settlement tbody').html(data.rows);
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
    				window.open(encodeURI(jsData.urlAjax + 'downloadSettlement?titleName='+titleName+'&description='+description));
    			}			
	        }
		});
    });
	window.onload = function(){
		document.multiselect('#channelSelect');
	};
</script>
<div class="ct_head">
	<h3><?=$this->language('l_managerevenue2')?></h3>
	<p>채널사의 정산내역을 확인할 수 있습니다. (업데이트 주기 : 매일 오전 9시 1회)</p>
</div>
<div class="ct_content">
	<div class="form_group">
		<form class="search_member" action="" method="POST">
			<table class="table">
				<tr>
					<th><?=$this->language('l_timefind')?></th>
					<td colspan="3">		
						<select class="select small">
							<option value="<?=$this->language('l_revenue01')?>"><?=$this->language('l_revenue01')?></option>							
						</select>			
						<input type="text" class="input datepick" name="datestart" value="<?=$m_start?>" readonly="readonly" style="width: 120px;">
						<span>~</span>
						<input type="text" class="input datepick" name="dateend" value="<?=$m_end?>" readonly="readonly" style="width: 120px;">
						<input type="button" class="btn changepick small" name="today" value="<?=$this->language('l_today')?>">
						<input type="button" class="btn changepick small" name="week" value="<?=$this->language('l_1week')?>">
						<input type="button" class="btn changepick small" name="month" value="<?=$this->language('l_1month')?>">
					</td>
					<td rowspan="4" style="line-height: 40px;">
						<input type="submit" class="btn small full hover" name="m_search" value="<?=$this->language('l_search')?>">
						<input type="submit" class="btn small full hover reset" name="m_reset" value="<?=$this->language('l_reset')?>">
					</td>
				</tr>
				<tr>
					<th><?=$this->language('l_supplier')?></th>				
					<td colspan="2">
						<select name="m_supplier" id="supplier" class="select small">
							<option <?php if ($m_supplier==0) echo 'selected="selected"';?> value="0"><?=$this->language('l_question4')?></option>
							<?php foreach ($list_supplier as $value =>$giatri){?>
							<option <?php if ($m_supplier==$giatri['idx']) echo 'selected="selected"';?> value="<?=$giatri['idx']?>"><?=$giatri['ID']?></option>
							<?php }?>
    					</select>	
					</td>							
				</tr>
				<tr>
					<th><?=$this->language('l_Channel7')?></th>				
					<td colspan="2">
						<select name="m_channel[]" class="select small" id='channelSelect' multiple>
    						<?php foreach ($list_channel as $value =>$giatri){?>
							<option <?php if (in_array($giatri['channel_id'], $m_channel)) echo 'selected="selected"';?> value='<?=$giatri['channel_id']?>'><?=$giatri['channel_name']?></option>
							<?php }?>
    					</select>	
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div class="form_group clearfix settlement">		
		<div class="form_table">	
			<div class="table_head bgwhite">
				<div class="ctrl_head clearfix">
					<div class="title col-xs-1">
						<h3><?=$this->language('l_mbtotal').$this->getData('total')?> <?=$this->language('l_notification16')?></h3>
					</div>
					<div class="icons col-xs-2">
						<select name="" class="select">							
							<option value="50" <?=(($this->getData('length')==20)?'selected':'')?>>20 <?=$this->language('l_notification8')?></option>	
							<option value="50" <?=(($this->getData('length')==50)?'selected':'')?>>50 <?=$this->language('l_notification8')?></option>							
							<option value="100" <?=(($this->getData('length')==100)?'selected':'')?>>100 <?=$this->language('l_notification8')?></option>
						</select>						
					</div>
					<div class="icons col-xs-2">
						<button type="button" name="" class="btn full hover downloadExcel"><?=$this->language('l_Channel26')?></button>
					</div>
				</div>
			</div>		
			<div class="table_content clearfix">
				<table class="table" id="settlement">
					<thead>
						<tr>
							<th><?=$this->language('l_Channel7')?></th>						
							<th><?=$this->language('l_supplier')?></th>	
							<th><?=$this->language('l_revenue02')?></th>
							<th><?=$this->language('l_revenue03')?></th>
							<th><?=$this->language('l_revenue04')?></th>
							<th><?=$this->language('l_revenue05')?></th>
							<th><?=$this->language('l_revenue06')?></th>
							<th><?=$this->language('l_addticket20')?></th>
							<th><?=$this->language('l_revenue07')?></th>
							<th><?=$this->language('l_revenue08')?></th>												
						</tr>
					</thead>
					<tbody><?=$this->getData('settlement')?></tbody>
				</table>							
			</div>
		</div>
	</div>
	<?=$this->getData('pagination')?>
</div>