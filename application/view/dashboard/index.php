<style>
		canvas{
			-moz-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
		}
</style>
<script src="<?=URL_PUBLIC?>js/Chart.min.js"></script>
<script src="<?=URL_PUBLIC?>js/utils.js"></script>
<?php 
$data11 = $this->getData('data11');
$data22 = $this->getData('data22');
$data33 = $this->getData('data33');
$data44 = $this->getData('data44');
?>
<script>	
	var config1 = {
		type: 'line',
		data: {
			labels: <?=json_encode($this->getItem('charjs', 'day'))?>, 
			datasets: [{
				label: '<?=$this->language('l_charjsweek1')?>',
				backgroundColor: '#5bb1d9',
				borderColor: '#5bb1d9',
				data:<?=json_encode($data22)?>,
				fill: false,
			}, 
			{
				label: '<?=$this->language('l_charjsweek2')?>',
				fill: false,
				backgroundColor: '#fdd100',
				borderColor: '#fdd100',
				data: <?=json_encode($data11)?>
			}]
		},
		options: {
			responsive: true,			
			tooltips: {
				mode: 'index',
				intersect: false,
			},
			hover: {
				mode: 'nearest',
				intersect: true
			}
		}
	};
	var config2 = {
		type: 'line',
		data: {
			labels: <?=json_encode($this->getItem('charjs', 'day'))?>,
			datasets: [{
				label: '<?=$this->language('l_charjsweek1')?>',
				backgroundColor: '#5bb1d9',
				borderColor: '#5bb1d9',
				data:<?=json_encode($data33)?>,
				fill: false,
			}, {
				label: '<?=$this->language('l_charjsweek2')?>',
				fill: false,
				backgroundColor: '#fdd100',
				borderColor: '#fdd100',
				data: <?=json_encode($data44)?>,
			}]
		},
		options: {
			responsive: true,			
			tooltips: {
				mode: 'index',
				intersect: false,
			},
			hover: {
				mode: 'nearest',
				intersect: true
			}
		}
	};

	window.onload = function() {
		var ctx1 = document.getElementById('canvas1').getContext('2d');
		var ctx2 = document.getElementById('canvas2').getContext('2d');
		window.myLine = new Chart(ctx1, config1);
		window.myLine = new Chart(ctx2, config2);
	};
	
</script>

<div class="ct_head">
	<h3><?=$this->language('l_dashboard')?></h3>
</div>
<div class="ct_content">
	<div class="form_group clearfix">
		<div class="form_table col-xs-4">
			<div class="table_head">
				<h3><?=$this->language('l_dashboard1')?></h3>
			</div>
			<div class="table_content">
				<p><a href="<?=$this->getItem('productTotal', 'url')?>" target="_blank"><?=$this->getItem('productTotal', 'amount') .' '. $this->language('l_product')?></a></p>
			</div>
		</div>
		<div class="form_table col-xs-4">
			<div class="table_head">
				<h3><?=$this->language('l_dashboard2')?></h3>
			</div>
			<div class="table_content">
				<p><a href="<?=$this->getItem('productEnd', 'url')?>" target="_blank"><?=$this->getItem('productEnd', 'amount') .' '. $this->language('l_product')?></a></p>
			</div>
		</div>
		<div class="form_table col-xs-4">
			<div class="table_head">
				<h3><?=$this->language('l_dashboard3')?></h3>
			</div>
			<div class="table_content">
				<p><a href="<?=$this->getItem('productStart', 'url')?>" target="_blank"><?=$this->getItem('productStart', 'amount') .' '. $this->language('l_product')?></a></p>
			</div>
		</div>
	</div>
	<div class="form_group clearfix">
		<div class="form_table col-xs-6">
			<div class="table_head">
				<h3><?=$this->language('l_dashboard4')?></h3>
			</div>
			<div class="table_content">
				<p><a href="<?=$this->getItem('productAmountToday', 'url')?>" target="_blank"><?=$this->getItem('productAmountToday', 'amount') .' '. $this->language('l_product')?></a></p>
			</div>
		</div>
		<div class="form_table col-xs-6">
			<div class="table_head">
				<h3><?=$this->language('l_dashboard5')?></h3>
			</div>
			<div class="table_content">
				<p><a href="<?=$this->getItem('productAmountUnuse', 'url')?>" target="_blank"><?=$this->getItem('productAmountUnuse', 'amount') .' '. $this->language('l_product')?></a></p>
			</div>
		</div>
	</div>
	<div class="form_group clearfix">
		<div class="form_table col-xs-6">
			<div class="table_head">
				<h3><?=$this->language('l_dashboard6')?></h3>
			</div>
			<div class="table_content">				
				<p><a href="<?=$this->getItem('revenueNotOrder', 'url')?>" target="_blank"><?=$this->getItem('revenueNotOrder', 'amount') .' '. $this->language('l_product')?></a></p>
			</div>
		</div>
		<div class="form_table col-xs-6">
			<div class="table_head">
				<h3><?=$this->language('l_dashboard7')?></h3>
			</div>
			<div class="table_content">
				<p><a href="<?=$this->getItem('questionNotReply', 'url')?>" target="_blank"><?=$this->getItem('questionNotReply', 'amount') .' '. $this->language('l_question')?></a></p>
			</div>
		</div>
	</div>
	<div class="form_group clearfix">
		<div class="form_table col-xs-6">
			<div class="table_head">
				<h3><?=$this->language('l_dashboard8')?></h3>
			</div>
			<div class="table_content">
				<canvas id="canvas1"></canvas>
			</div>
		</div>
		<div class="form_table col-xs-6">
			<div class="table_head">
				<h3><?=$this->language('l_dashboard9')?></h3>
			</div>
			<div class="table_content">
				<canvas id="canvas2"></canvas>
			</div>
		</div>
	</div>
</div>