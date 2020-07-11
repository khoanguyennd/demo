<script type="text/javascript">
	$(document).ready(function(){
		// Thay đổi số dòng hiển thị trên một trang
		$('div.notification').on('change', 'select.select', function(){
			var length = $(this).val();
			if(length){
				var url = '<?=$this->route('logApi')?>/1/';
				window.location.href = url+length;
			}
		});		
	});	
</script>
<div class="ct_head">
	<h3>Logs API</h3>
	<p>Hiển thị thông báo kết nối API</p>
</div>
<div class="ct_content">	
	<div class="form_group clearfix notification">
		<div class="form_table">	
			<div class="table_head bgwhite">
				<div class="ctrl_head clearfix">
					<div class="title col-xs-2">
						<h3><?=$this->language('l_mbtotal').$this->getData('total')?> <?=$this->language('l_notification16')?></h3>
					</div>
					<div class="icons col-xs-10">
						<select name="" class="select">							
							<option value="20"
								<?=(($this->getData('length')==20)?'selected':'')?>>20 <?=$this->language('l_notification8')?></option>
							<option value="50"
								<?=(($this->getData('length')==50)?'selected':'')?>>50 <?=$this->language('l_notification8')?></option>
							<option value="100"
								<?=(($this->getData('length')==100)?'selected':'')?>>100 <?=$this->language('l_notification8')?></option>
						</select>
					</div>					
				</div>
			</div>		
			<div class="table_content">
				<table class="table" id="notification">
					<thead>
						<tr>
							<th><?=$this->language('l_no')?></th>
							<th>Channel</th>
							<th>SellerProductId</th>
							<th>TravelProductId</th>
							<th>Action</th>
							<th>Result</th>
							<th>Day</th>							
						</tr>
					</thead>
					<tbody><?=$this->getData('apilogs')?></tbody>
				</table>
			</div>
		</div>
	</div>
	<?=$this->getData('pagination')?>
</div>