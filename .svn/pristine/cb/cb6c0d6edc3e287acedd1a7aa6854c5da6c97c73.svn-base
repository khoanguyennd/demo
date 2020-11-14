<?php 
$settlementuserdetail = $this->getData('settlementuserdetail');
$settlementuseradjusted = $this->getData('settlementuseradjusted');
?>
<link rel="stylesheet" type="text/css" href="<?=URL_PUBLIC?>css/jquery-ui.css" />
<script type="text/javascript" src="<?=URL_PUBLIC?>js/jquery-ui.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('button.viewhistory').click(function(){
			var sid = $(this).attr('data-id');
			if(sid && $.isNumeric(sid)){
				$.fn_ajax('viewStatusHistory', {'sid': sid}, function(result){
					if(result.flag == true){
						$.fn_popup(true, 'revenuedetaillog', true);
						$($.elt_popup).find('.revenuedetaillog tbody').html(result.rows);
					}
				});
			}
		});

		$('#downloadDetailExcel').on('click', function(result){
			var sid = $(this).attr('data-id');
		    window.open(jsData.urlAjax + 'downloadStatusDetailExcel'+'/'+sid);
		});
		$('#downloadDetailExcelSettlment').on('click', function(result){
			var sid = $(this).attr('data-id');
		    window.open(jsData.urlAjax + 'downloadStatusDetailExcel'+'/'+sid);
		});	

		// phê duyet
		$("#settlementsellerdone").on('click', function(){
			$.fn_popup(true, 'alert_approve');
			$($.elt_popup).find('p').html("<?= $this->language('l_revenue29') ?>");
    		$('#btnApprove').on('click', function(){
    			var sid=$("#settlementsellerdone").attr('data-id');
    			$.fn_ajax('Settlementsellerdone', {'sid': sid}, function (result) {
                    if(result.flag=true){
                   		location.reload();
                    }
                }, true);
    		});
		});
		// từ chối
		$("#settlementsellercancel").on('click', function(){
			$.fn_popup(true, 'alert_approve');
			$($.elt_popup).find('p').html("<?= $this->language('l_revenue27')?>");
    		$('#btnApprove').on('click', function(){
    			var sid=$("#settlementsellercancel").attr('data-id');
    			$.fn_ajax('Deny_Settlement', {'sid': sid}, function (result) {
                    if(result.flag=true){
                    	location.reload();
                    }
                }, true);
    		});
		});

		// gởi GĐ duyệt lại
		$("#settlementreturn").on('click', function(){
			$.fn_popup(true, 'alert_approve');
			$($.elt_popup).find('p').html("<?= $this->language('l_revenue30')?>");
    		$('#btnApprove').on('click', function(){
    			var sid=$("#settlementreturn").attr('data-id');
    			$.fn_ajax('Return_Settlement', {'sid': sid}, function (result) {
        			console.log(result);
                    if(result.flag=true){
						window.location.href ="<?=$this->route('revenuestatus')?>";
                    	//manage-revenue-settlement-status.html
                    }
                }, true);
    		});
		});

		//Uload Excel điều chỉnh quyết toán
		$(".btnUpld_settlement").on('click', function(){
			$.fn_popup(true, 'adjusted_settle');
		});
		$('#Upld_Settle_Excel').on('click', function(){
			$('#Upld_Settlement_excel').trigger('click');
		});
		$('#btnUpload_excel').on('click', function(){
			var data = new FormData();
			var fileupload = $("#Upld_Settlement_excel")[0].files[0];
			var sid=$(".btnUpld_settlement").attr('data-id');
			data.append("fileupload", fileupload);
			data.append("sid", sid);
			$.fn_ajax_upload_file('Upld_Settlement_excel',data,function(result){
				if(result.flag = true){
					$('#feedback3').html('');
					$('#feedback3').html(result.tabl);
					location.reload();
				}
			},true);
		});
	});
</script>

<div class="ct_head">
	<div class="col-xs-4">
		<h3 data-id="<?=$this->getItem('itemstatus', 'id')?>">정산현황 > 정산서</h3>
	</div>
	<div class="col-xs-8 align-right">
	
		<button type="button" name="" class="btn small hover " id="downloadDetailExcel" data-id="<?=$this->getItem('itemstatus', 'id')?>">정산서 다운로드</button>
		<?php if($this->_params['act']=='edit'){?>
		<button type="button" name="" class="btn small hover btnUpld_settlement" data-id="<?=$this->getItem('itemstatus', 'id')?>">정산서 업로드</button>
		<button type="button" name="" class="btn small hover"  id="settlementreturn" data-id="<?=$this->getItem('itemstatus', 'id')?>">사업장승인요청</button>
		<?php }?>
		<?php $account = $_SESSION['accountshopping'];
		if($account['role']==0 && $this->getItem('itemstatus', 'status')==3){?>
			<button type="button" class="btn hover settlementdone" data-id="<?=$this->getItem('itemstatus', 'id')?>"><?=$this->language('l_revenue19')?></button>
		<?php }?>
		<button type="button" name="" class="btn small hover viewhistory" data-id="<?=$this->_params['sid']?>">정산서 히스토리</button>
	</div>	
	<p>정산상세내역이 보여집니다. </p>
</div>
<div class="ct_content" id="revenuestatusdetail">
	<div class="form_group">
		<table class="table">
			<tr>
				<th>총판사/시설사</th>
				<td>
				<?php  echo $this->getItem('itemstatus', 'userId')."/". $this->getItem('itemstatus', 'supplier');?>
				</td>
				<th>정산서 상태</th>
				<td>
				<?php  
				    if($this->getItem('itemstatus', 'status')==1) echo $this->language('l_revenue10');
				    if($this->getItem('itemstatus', 'status')==2) echo $this->language('l_revenue12');
				    if($this->getItem('itemstatus', 'status')==3) echo $this->language('l_revenue11');
				    if($this->getItem('itemstatus', 'status')==4) echo $this->language('l_revenue24');
				?>
				</td>
			</tr>
			<tr>
				<th>정산기간</th>
				<td>
					<input type="text" class="input datepick" name="datestart" value="<?=$this->getItem('itemstatus', 'createdstart')?>" readonly="readonly" style="width: 120px;"<?=$this->getData('actstatus')?>>
					<span>~</span>
					<input type="text" class="input datepick" name="dateend" value="<?=$this->getItem('itemstatus', 'createdend')?>" readonly="readonly" style="width: 120px;"<?=$this->getData('actstatus')?>>
				</td>
				<th>지급예정일</th>
				<td>
					<input type="text" class="input datepick" name="settlementday" value="<?=$this->getItem('itemstatus', 'settlementday')?>" readonly="readonly" style="width: 120px;"<?=$this->getData('actstatus')?>>
				</td>
			</tr>
			<tr>
				<th>판매가/수수료</th>
				<td><?=Func::formatPrice($this->getItem('itemstatus', 'pricetotal'))?> (<?=Func::formatPrice($this->getItem('itemstatus', 'feetotal'))?>)</td>
				<th>정산금액</th>
				<td><?=Func::formatPrice($this->getItem('itemstatus', 'settlementtotal'))?></td>
			</tr>
		</table>		
	</div>	
	<div class="form_group">
		<div class="form_item">
			<input type="checkbox" name="" checked="checked" disabled value="" style="vertical-align: text-bottom;">
			<label for="chn-radio1" style="vertical-align: middle;">판매상세내역</label>
		</div>
	</div>
	<div class="form_group">
		<table class="table">
			<thead>
				<tr>
					<th>구분</th>
					<th>채널</th>
					<th>상품명</th>
					<th>단가</th>
					<th>수량</th>
					<th>판매가</th>
					<th>공급가</th>
					<th>수수료</th>
				</tr>
				<tr>
					<th colspan="4" class="align-right">합계</th>				
					<?=$this->getItem('customstatus', 'totalHtml')?>
				</tr>
			</thead>
			<tbody><?=$this->getItem('customstatus', 'strHtml')?></tbody>
		</table>		
	</div>
	<div class="form_group">
		<div class="form_item">
			<input type="checkbox" name="" checked="checked" disabled value="" style="vertical-align: text-bottom;">
			<label for="chn-radio1" style="vertical-align: middle;">조정금 상세내역</label>
		</div>
	</div>
	<div class="form_group">
		<table class="table">
			<thead>
				<tr>
					<th colspan="2">구분</th>
					<th>수량</th>
					<th>판매가</th>
					<th>공급가</th>
					<th>수수료</th>					
				</tr>				
			</thead>
			<tbody>
				<tr>
					<td colspan="2" class="tbclsbg">총 판매금액</td>
					<?=$this->getItem('customstatus', 'totalHtml')?>
				</tr>
				<?php 
				$amount=$pricetotal=$pricesupply=$feetotal=0;
				foreach ($settlementuserdetail as $key => $value){   
				    $amount+=$value['amount'];
				    $pricetotal+=($value['price']*$value['amount']);
				    $feetotal+=$value['feetotal'];
				}
				$pricesupply=$pricetotal-$feetotal;
				
				$co=0;
				foreach($settlementuseradjusted as $value => $giatri){
				?>
				<tr>
					<?php if($co==0){?>
					<td rowspan="5" class="tbclsbg" style="width: 100px;">조정금액</td>
					<?php }?>
					
					<td class="tbclsbg" style="width: 200px;">
					<?php 
					   if($giatri['pos']==1) echo '사용 후 취소/환불금액';
					   if($giatri['pos']==2) echo '선정산 금액';
					   if($giatri['pos']==3) echo '취소위약금';
					   if($giatri['pos']==4) echo '수수료 변경에 따른 판매가/공급가 조정항목';
					   if($giatri['pos']==5) echo '기타 조정금액';
					?>
					</td>
					<td><?=$giatri['amount']?></td>
					<td><?=$giatri['price']?></td>
					<td><?=$giatri['supplyprice']?></td>
					<td><?=$giatri['fee']?></td>
				</tr>
				<?php 
				    $co++; 
				    $amount-=$giatri['amount'];
				    $pricetotal-=$giatri['price'];
				    $pricesupply-=$giatri['supplyprice'];
				    $feetotal-=$giatri['fee'];
				
				}?>
				<tr>
					<td colspan="2">총 정산금액(총 판매금액-조정금)</td>
					<td><?=number_format($amount)?></td>
					<td><?=number_format($pricetotal)?></td>
					<td><?=number_format($pricesupply)?></td>
					<td><?=number_format($feetotal)?></td>
				</tr>
			</tbody>
		</table>		
	</div>
	<div class="form_group">
		<div class="form_item">
			<input type="checkbox" name="" checked="checked" disabled value="" style="vertical-align: text-bottom;">
			<label for="chn-radio1" style="vertical-align: middle;">지급예정</label>
		</div>
	</div>
	<div class="form_group">
		<table class="table">
			<thead>
				<tr>
					<th>지급비율(%)</th>
					<th>지급예정일</th>
					<th>수량</th>
					<th>판매가</th>
					<th>공급가</th>					
					<th style="width: 200px;">수수료(세금계산서 발행 예정 금액)</th>					
				</tr>				
			</thead>
			<tbody>
				<tr>
					<td>100%</td>
					<td><?=$this->getItem('itemstatus', 'settlementday')?></td>
					<td><?=number_format($amount)?></td>
					<td><?=number_format($pricetotal)?></td>
					<td><?=number_format($pricesupply)?></td>
					<td><?=number_format($feetotal)?></td>
				</tr>
			</tbody>
		</table>		
	</div>
	<div class="form_group">
		<div class="form_item">
			<input type="checkbox" name="" checked="checked" disabled value="" style="vertical-align: text-bottom;"> 
			<label for="chn-radio1" style="vertical-align: middle;">안내</label>
		</div>
	</div>
	<div class="form_group" style="padding:15px;">
		<div class="form_group bdsolid">
			<div class="form_item">
				<p>안내문구가 들어갑니다.</p>  
			</div>
		</div>
	</div>
	<div class="form_group fgpcontrol clearfix">
		<div class="form_item col-xs-4">
			<input type="button" class="btn small hover" onclick="window.location.href='<?=$this->route('revenuestatus')?>'" value="목록">
		</div>
		<div class="form_item col-xs-8 align-right">
    		<button type="button" name="" class="btn small hover " id="downloadDetailExcel" data-id="<?=$this->getItem('itemstatus', 'id')?>">정산서 다운로드</button>
    		<?php if($this->_params['act']=='edit'){?>
    		<button type="button" name="" class="btn small hover btnUpld_settlement" data-id="<?=$this->getItem('itemstatus', 'id')?>">정산서 업로드</button>
    		<button type="button" name="" class="btn small hover"  id="settlementreturn" data-id="<?=$this->getItem('itemstatus', 'id')?>">사업장승인요청</button>
    		<?php }?>
    		<?php $account = $_SESSION['accountshopping'];
    		if($account['role']==0 && $this->getItem('itemstatus', 'status')==3){?>
    			<button type="button" class="btn hover settlementdone" data-id="<?=$this->getItem('itemstatus', 'id')?>"><?=$this->language('l_revenue19')?></button>
    		<?php }?>
    		<button type="button" name="" class="btn small hover viewhistory" data-id="<?=$this->_params['sid']?>">정산서 히스토리</button>
		</div>
	</div>
</div>