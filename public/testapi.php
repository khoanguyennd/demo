<!DOCTYPE html>
<html>
<head>
	<title>Test API</title>
	<link rel="stylesheet" type="text/css" href="public/css/reset.css">
	<style type="text/css">
		.main{
			width: 800px;
			margin: auto;
			padding: 15px;
			text-align: center;
			border: 1px solid #ccc;
		}
		.main .header{
			margin-bottom: 25px;
			border-bottom: 2px solid #CCC;
			padding: 15px;
		}
		.main .row{
			text-align: left;
			font-size: 16px;
			margin: 15px 0;
		}
		h5{
			margin: 5px 0;
		}
		a{
			display: block;
			padding: 8px !important;
			text-align: center;
			text-decoration: none;
		}
	</style>
	<script type="text/javascript" src="public/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('a.btn.test1').on('click', function(){
				var element = $(this).closest('div.row');
				var ipval = '/';
				$(element).find('input').each(function(){
					if($(this).val()){
						ipval +=  $(this).val() + '/';
					}
				});				
				var href = $(this).attr('href');
				if(ipval.length>1 && href){					
					var url = href + '/' + ipval.substr(1);
					window.open(url);
				}else{
					alert('Bạn chưa nhập ID cần test');
					return false;
				}
			
				return false;						
			});
		});
	</script>
</head>
<body>

	<div class="main">
		<div class="header">
			<h1>Testing API Coupang</h1>
		</div>
		<div class="content">
			<div class="row clearfix">
				<h5>POST Product {$sellerProductId}</h5>
				<div class="col-xs-10">
					<input type="number" name="" value="" class="input full" placeholder="{$sellerProductId}">
				</div>
				<div class="col-xs-2">
					<a href="<?=$this->route('connectAPI', ['method'=>'addproduct'])?>" class="btn hover full test1" target="_blank"> Testing</a>
				</div>
			</div>
			<div class="row clearfix">
				<h5>GET Product {$travelProductId}</h5>
				<div class="col-xs-10">
					<input type="number" name="" value="" class="input full" placeholder="{$travelProductId}">
				</div>
				<div class="col-xs-2">
					<a href="<?=$this->route('connectAPI', ['method'=>'getproduct'])?>" class="btn hover full test1" target="_blank"> Testing</a>
				</div>
			</div>
			<div class="row clearfix">
				<h5>GET Product list</h5>
				<div class="col-xs-10">
					<input type="number" name="" value="" class="input full" disabled>
				</div>
				<div class="col-xs-2">
					<a href="<?=$this->route('connectAPI', ['method'=>'getproductlist'])?>" class="btn hover full" target="_blank"> Testing</a>
				</div>
			</div>
			<div class="row clearfix">
				<h5>Edit Product {$sellerProductId} / {$travelProductId}</h5>
				<div class="col-xs-5">
					<input type="number" name="" value="" class="input full"  placeholder="{$sellerProductId}">
				</div>
				<div class="col-xs-5">
					<input type="number" name="" value="" class="input full" placeholder="{$travelProductId}">
				</div>
				<div class="col-xs-2">
					<a href="<?=$this->route('connectAPI', ['method'=>'editProduct'])?>" class="btn hover full test1" target="_blank"> Testing</a>
				</div>
			</div>
			<div class="row clearfix">
				<h5>Delete Product {$travelProductId}</h5>
				<div class="col-xs-10">
					<input type="number" name="" value="" class="input full" placeholder="{$travelProductId}">
				</div>
				<div class="col-xs-2">
					<a href="<?=$this->route('connectAPI', ['method'=>'deleteproduct'])?>" class="btn hover full test1" target="_blank"> Testing</a>
				</div>
			</div>
			<div class="row clearfix">
				<h5>POST Option {$travelProductId}</h5>
				<div class="col-xs-10">
					<input type="number" name="" value="" class="input full" placeholder="{$travelProductId}">
				</div>				
				<div class="col-xs-2">
					<a href="<?=$this->route('connectAPI', ['method'=>'addoption'])?>" class="btn hover full test1" target="_blank"> Testing</a>
				</div>
			</div>
			<div class="row clearfix">
				<h5>Edit Option {$travelProductId} / {$travelItemId}</h5>
				<div class="col-xs-5">
					<input type="number" name="" value="" class="input full" placeholder="{$travelProductId}">
				</div>	
				<div class="col-xs-5">
					<input type="number" name="" value="" class="input full" placeholder="{$travelItemId}">
				</div>			
				<div class="col-xs-2">
					<a href="<?=$this->route('connectAPI', ['method'=>'editoption'])?>" class="btn hover full test1" target="_blank"> Testing</a>
				</div>
			</div>
			<div class="row clearfix">
				<h5>Delete Option {$travelProductId} / {$travelItemId}</h5>
				<div class="col-xs-5">
					<input type="number" name="" value="" class="input full" placeholder="{$travelProductId}">
				</div>	
				<div class="col-xs-5">
					<input type="number" name="" value="" class="input full" placeholder="{$travelItemId}">
				</div>			
				<div class="col-xs-2">
					<a href="<?=$this->route('connectAPI', ['method'=>'deleteoption'])?>" class="btn hover full test1" target="_blank"> Testing</a>
				</div>
			</div>
			<div class="row clearfix">
				<h5>Update Fee Amount {$travelProductId}</h5>
				<div class="col-xs-10">
					<input type="number" name="" value="" class="input full" placeholder="{$travelProductId}">
				</div>				
				<div class="col-xs-2">
					<a href="<?=$this->route('connectAPI', ['method'=>'feeamount'])?>" class="btn hover full test1" target="_blank"> Testing</a>
				</div>
			</div>
			<div class="row clearfix">
				<h5>Get InventoryList {$travelProductId}</h5>
				<div class="col-xs-10">
					<input type="number" name="" value="" class="input full" placeholder="{$travelProductId}">
				</div>				
				<div class="col-xs-2">
					<a href="<?=$this->route('connectAPI', ['method'=>'inventoryList'])?>" class="btn hover full test1" target="_blank"> Testing</a>
				</div>
			</div>
		</div>

	</div>
</body>
</html>