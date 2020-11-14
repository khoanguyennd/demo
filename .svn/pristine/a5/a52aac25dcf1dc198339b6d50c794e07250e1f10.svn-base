<style type="text/css">
	.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0, 0, 0);
  background-color: rgba(0, 0, 0, .4);
}

.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>


<script type="text/javascript">
	$(document).ready(function(){
		// Hiển thị form chi tiet thông báo
		$('.detailnotification').click(function(){
			var noid = $(this).attr('data-noid');
			if(noid){
				$.fn_ajax('editNotification', {'noid': noid}, function(result){
					if(result.flag == true){
						$.fn_popup(true, 'detailnotification');
						$($.elt_popup).find('.detailnotification h3').text('<?=$this->language('l_notification19')?>');
						$($.elt_popup).find('.detailnotification p').text(result.title);
						$($.elt_popup).find('.detailnotification textarea[name="content"]').val(result.content);
						
					}else{
						$.fn_alert(true, true, "<?=$this->language('l_notification4')?>");
					}
				});
			}
			
		});
		
		// Hiển thị form nhập thông báo
		$('.btn.newnotification').click(function(){
			$.fn_popup(true, 'notification');
			$($.elt_popup).find('.notification h3').text('<?=$this->language('l_notification15')?>');
			$($.elt_popup).find('.notification input[name="submit"]').removeAttr('data-noid').val('<?=$this->language('l_add')?>');
		});
		// Thực hiện đăng thông báo
		$($.elt_popup).on('submit', '.notification form', function(){
			var noid = $(this).find('input[name="submit"]').attr('data-noid');
			var title = $(this).find('input[name="title"]').val();
			var content = $(this).find('textarea[name="content"]').val();
			if(!title){
				$.fn_alert(true, true, "<?=$this->language('l_notification1')?>");
				return false;
			}
			if(!content){
				$.fn_alert(true, true, "<?=$this->language('l_notification2')?>");
				return false;
			}
			if(title && content){
				$.fn_ajax('notification', {'title': title, 'content': content, 'noid': noid}, function(result){
					if(result.flag == true){
						var tbody = '#notification tbody';
						$.fn_popup(false, 'notification', true);
						if(result.type == 'add'){
							if($(tbody).find('td.empty').length>0){
								$(tbody).find('td.empty').closest('tr').remove();
								$(tbody).append(result.row);
							}else{
								$(tbody).find('tr:first-child').before(result.row);
							}
						}
						if(result.type == 'edit'){
							var row = $(tbody).find('input[data-noid="'+result.id+'"]').closest('tr');
							$(row).find('td:nth-child(2)').text(result.title);
							$(row).find('td:nth-child(5)').text(result.name);
							$(row).find('td:nth-child(6)').text(result.time);
						}						
					}else{
						$.fn_alert(true, true, "<?=$this->language('l_notification3')?>");
					}
				});
			}
			return false;
		});
		// Thực hiện chỉnh sửa thông báo
		$('#notification').on('click','.editnotification', function(){
			var noid = $(this).attr('data-noid');
			if(noid){
				$.fn_ajax('editNotification', {'noid': noid}, function(result){
					if(result.flag == true){
						$.fn_popup(true, 'notification');
						$($.elt_popup).find('.notification h3').text('<?=$this->language('l_notification19')?>');
						$($.elt_popup).find('.notification input[name="title"]').val(result.title);
						$($.elt_popup).find('.notification textarea[name="content"]').val(result.content);
						$($.elt_popup).find('.notification input[name="submit"]').attr({'data-noid':result.id, 'value':'<?=$this->language('l_edit')?>'});
					}else{
						$.fn_alert(true, true, "<?=$this->language('l_notification4')?>");
					}
				});
			}
		});
		// Thực hiện tìm kiếm tiêu đề thông báo
		$('.searchNotification').submit(function(){
			var data = $.fn_dataForm();
			if(!data.keyword){
				$.fn_alert(true, true,"<?=$this->language('l_notification5')?>");
				return false;
			}			
			$.fn_ajax('searchAndPagination', data, function(result){
				$.fn_result(result);
			},true);
			return false;
		});
		// Thực hiện reset tiêu đề thông báo
		$('.searchNotification').on('click', '.btn.reset',function(){
			var data = $.fn_dataForm();		
			data.keyword='';				
			$.fn_ajax('searchAndPagination', data, function(result){
				$.fn_result(result);
			},true);
			return false;
		});
		// Thay đổi số dòng hiển thị trên một trang
		$('div.notification').on('change', 'select.select', function(){
			var length = $(this).val();
			if(length){
				var data = $.fn_dataForm();
				data.length = length;
				$.fn_ajax('searchAndPagination', data, function(result){
					$.fn_result(result);
				}, true);
			}
			return false;
		});
		// Thực hiện phân trang
		$('div.ct_content').on('click', '.pagination a', function(){
			var length = $(this).attr('data-length');
			var page = $(this).attr('data-page');
			if(length && page){
				var data = $.fn_dataForm();
				data.page = page;
				data.length = length;
				$.fn_ajax('searchAndPagination', data, function(result){
					$.fn_result(result);
				}, true);
			}
			return false;
		});
		// Hàm trả về tham số
		$.fn_dataForm = function(){			
			return {
				'length':'<?=$this->getData('length')?>',
				'page':'1',				
				'keyword' : $('.keywordNotification').val()
			}
		}
		// Hàm xử lý kết quả trả về		
		$.fn_result = function(data){
			if(data.flag == true){
				$('#notification tbody').html(data.rows);
				$('div.ct_content .pagination').closest('div.form_group').remove();
				$('div.ct_content').append(data.pagination);
			}
		}
	});	
</script>
<?php $account = $_SESSION['accountshopping']; ?>
<div class="ct_head">
	<h3><?=$this->language('l_notification6')?></h3>
	<p><?=$this->language('l_notification7')?></p>
</div>
<div class="ct_content">
	<div class="form_group clearfix form_search">
		<form action="" method="post" class="searchNotification">
			<div class="form_item col-xs-2">
				<input type="button" name="key" value="<?=$this->language('l_keyword')?>" class="btn full active disabled" >
			</div>
			<div class="form_item col-xs-8">
				<input type="text" name="keyword" value="" class="input full keywordNotification">
			</div>
			<div class="form_item col-xs-1">
				<input type="submit" name="search" value="<?=$this->language('l_search')?>" class="btn full hover small search" style="height: 29px;width: 65px;">
			</div>
			<div class="form_item col-xs-1">
				<input type="reset" name="reset" value="<?=$this->language('l_reset')?>" class="btn full hover small reset" style="height: 29px;width: 65px;">
			</div>
		</form>
	</div>
	<div class="form_group clearfix notification">
		<div class="form_table">	
			<div class="table_head bgwhite">
				<div class="ctrl_head clearfix">
					<div class="title col-xs-1">
						<h3><?=$this->language('l_mbtotal').$this->getData('total')?> <?=$this->language('l_notification16')?></h3>
					</div>
					<div class="icons col-xs-2">
						<select name="" class="select">							
							<option value="20"
								<?=(($this->getData('length')==20)?'selected':'')?>>20 <?=$this->language('l_notification8')?></option>
							<option value="50"
								<?=(($this->getData('length')==50)?'selected':'')?>>50 <?=$this->language('l_notification8')?></option>
							<option value="100"
								<?=(($this->getData('length')==100)?'selected':'')?>>100 <?=$this->language('l_notification8')?></option>
						</select>
					</div>
					<div class="icons col-xs-7">
					</div>
					<?php if($account['role']==0){?>
					<div class="icons col-xs-2" style="float: right;text-align: right;">
						<button type="button" name="newnotification" class="btn full hover newnotification" style="height: 29px;width: 120px;"><?=$this->language('l_notification9')?> </button>
					</div>
					<?php }?>
				</div>
			</div>		
			<div class="table_content">
				<table class="table" id="notification">
					<thead>
						<tr>
							<th><?=$this->language('l_no')?></th>
							<th><?=$this->language('l_notification10')?></th>
							<?php if($account['role']==0){?>
							<th><?=$this->language('l_notification11')?></th>
							<?php }?>
							<th><?=$this->language('l_notification12')?></th>
							<?php if($account['role']==0){?>
							<th><?=$this->language('l_notification17')?></th>
							<th><?=$this->language('l_notification18')?></th>
							<th><?=$this->language('l_accmanage')?></th>
							<?php }?>
							
						</tr>
					</thead>
					<tbody><?=$this->getData('notification')?></tbody>
				</table>
			</div>
		</div>
	</div>
	<?=$this->getData('pagination')?>
</div>

<script type="text/javascript">
	$(document).ready(function () {
  var modal = $('.modal');
  var btn = $('.btn');
  var span = $('.close');

  btn.click(function () {
    modal.show();
  });

  span.click(function () {
    modal.hide();
  });

  $(window).on('click', function (e) {
    if ($(e.target).is('.modal')) {
      modal.hide();
    }
  });
});
</script>