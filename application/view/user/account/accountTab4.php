<script type="text/javascript">
	$(document).ready(function(){
		$(".newposts").on('click', function(){
			$.fn_popup(true, 'newposts');
		});
	});
</script>		
<!-- Thêm nhiều nhà cung cấp -->
<script>
	$(document).ready(function(){
		$('#upload_file_NCC').on('click', function(){
			$('#Uploadexcel_NCC').trigger('click');
		});	
		$('#btnUploadNCC').on('click', function(){
			var data = new FormData();
			var fileupload = $("#Uploadexcel_NCC")[0].files[0];
			data.append("fileupload", fileupload);
				$.fn_ajax_upload_file('Uploadexcel_NCC', data, function(result){
					console.log(result);
					if(result.flag == true){						
						$('#listsuplierbody').append(result.data);
					}
				},true);	
			});
		});		
</script>
<!-- end of thêm nhiều nhà cung cấp -->
<div id="tab4a">
	<div class="form_group clearfix listsuplier">
		<div class="form_table">
			<div class="table_head">
				<div class="ctrl_head clearfix">
					<div class="title col-xs-9">
						<h3></h3>
					</div>
					<div class="icons col-xs-2">
						
					</div>
				</div>
			</div>
		<div class="table_head bgwhite">
			<div class="ctrl_head clearfix align-left">
				<div class="title col-xs-1">
					<h3><?=$this->language('l_mbtotal')?> <?=$this->getData('count')?> <?=$this->language('l_notification16')?></h3>
				</div>
				<div class="title col-xs-2">
					<select name="" class="select" id="selectLength" >
						<option value="20" <?=(($this->getData('length')==20)?'selected':'')?>>20 <?=$this->language('l_notification8')?></option>
						<option value="50" <?=(($this->getData('length')==50)?'selected':'')?>>50 <?=$this->language('l_notification8')?></option>
						<option value="100" <?=(($this->getData('length')==100)?'selected':'')?>>100 <?=$this->language('l_notification8')?></option>
					</select>
				</div>
				<div class="icons col-xs-5 align-right" style="margin-top: 10px">
					<input type="checkbox" value="1" <?php if(isset($_SESSION['checknotuse']) && $_SESSION['checknotuse']=="true") echo 'checked="checked"';?> 
							name="checknotuse" id="checknotuse" onclick="onloadSuplliers1(this.checked)"> 
				    <label for="checknotuse">사용중인 시설사만 보기</label>
				</div>
				<div class="icons col-xs-4 align-right">
					<button type="button" name="newpost" class="btn hover newpost" onclick="showPopupaddSupplier()"><?=$this->language('l_supplieradd')?></button>
					<button type="button" name="newposts" class="btn hover newposts"><?=$this->language('l_supplierall')?></button>
				</div>
			</div>
		</div>
			<div class="table_content scrollbar scrlX">
				<table class="table">
					<thead>
						<tr>
							<th><?=$this->language('l_accmanage')?></th>
							<th><?=$this->language('l_acctable1')?></th>
							<th>아이디</th>
							<th>사용여부</th>
							<th><?=$this->language('l_acctable3')?></th>
							<th><?=$this->language('l_acctable4')?></th>
							<th><?=$this->language('l_acctable5')?></th>
							<th><?=$this->language('l_acctable6')?></th>
							<th><?=$this->language('l_acctable7')?></th>
							<th><?=$this->language('l_acctable8')?></th>
							<th><?=$this->language('l_acctable9')?></th>
							<th><?=$this->language('l_accaddress')?></th>
							<th><?=$this->language('l_landlinenumber')?></th>
						</tr>
					</thead>
					<tbody id="listsuplierbody">								
						<?=$this->getData('divsupllier');?>
					</tbody>
				</table>
			</div>
			<div id="divpaging">
    		<?=$this->getData('pagination')?>
    		</div>
		</div>
	</div>	
</div>