<div id="tab1a">
	<form action="<?=$this->route('account')?>#tab1" method="POST" id="changepw">
		<div class="form_group clearfix">
			<div class="form_group clearfix">
				<div class="form_item col-xs-3">
					<h3><?=$this->language('l_id')?></h3>
				</div>
				<div class="form_item col-xs-5" style="text-align: left;padding-top: 5px;">
					<?=Session::get('accountshopping')['ID']?>
					<input type="hidden" name="aid"
						value="<?=Session::get('accountshopping')['ID']?>"
						class="input full" autocomplete="off" disabled="disabled">
				</div>
				<div class="form_item col-xs-4"></div>
			</div>
			<div class="form_group clearfix">
				<div class="form_item col-xs-3">
					<h3><?=$this->language('l_accrole')?></h3>
				</div>
				<div class="form_item col-xs-5" style="text-align: left;padding-top: 5px;">				
					<?=Helper::rolesMember(Session::get('accountshopping')['role'])?>				
					<input type="hidden" name="role" class="input full"
						value="<?=Helper::rolesMember(Session::get('accountshopping')['role'])?>" autocomplete="off" disabled="disabled">
				</div>
				<div class="form_item col-xs-4"></div>
			</div>
			<div class="form_group clearfix">
				<div class="form_item col-xs-3">
					<h3><?=$this->language( 'l_newpassword')?></h3>
				</div>
				<div class="form_item col-xs-5">
					<div class="inputconfirm">
						<input name="password" type="password" value="" class="input full checkPW" autocomplete="off" >
					</div>
					<p class="note"><?=$this->language( 'l_warnpassword')?></p>
				</div>
				<div class="form_item col-xs-4" style="padding-top: 10px;text-align: left;"> 
					<p class="note" id="warnpassword" style="color: #f9933b"></p>
				</div>
			</div>
			<div class="form_group clearfix">
				<div class="form_item col-xs-3">
					<h3><?=$this->language( 'l_confirmnewpassword')?></h3>
				</div>
				<div class="form_item col-xs-5">
					<div class="inputconfirm">
						<input name="confirmpassword" type="password" value="" class="input full confirmPW" autocomplete="off">
					</div>
				</div>
				<div class="form_item col-xs-4" style="padding-top: 10px;text-align: left;"> 
					<p class="note" id="warncpassword" style="color: #f9933b"></p>
				</div>
			</div>
			<div class="form_group clearfix" style="border: 0; margin-bottom: 0;padding-top: 20px">
				<input name="submit" type="submit" value="이용정보 변경" class="btn hover">
			</div>
		</div>
	</form>
</div>