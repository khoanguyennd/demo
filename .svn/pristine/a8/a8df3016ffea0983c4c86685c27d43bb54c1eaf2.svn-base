<div id="tab3a">
	<div class="tab_bottom">
		<div class="tab_row">
			<form action="<?=$this->route('account')?>#tab3" id="frmupdateuser"
				method="POST"  enctype="multipart/form-data">
				<input name="tab3submit" type="hidden"  />
				<div class="forminput">
					<div class="form_group clearfix frrow">
						<div class="row rmclass" data-action="viewperson"
							data-perid="14">
							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_company')?></h3>
								</div>
								<div class="form_item col-xs-5">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty checkMaxLength" value="<?=$this->getItem('user', 'company')?>"
											name="acompany" id="acompany" maxlength="50">
									</div>
								</div>
								<div class="form_item col-xs-4">
									<p class="height1 align-left checkMaxLengthView"><?=strlen($this->getItem('user', 'company'))?>/50</p>
								</div>
							</div>
							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language( 'l_person_surrogate')?></h3>
								</div>
								<div class="form_item col-xs-5">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty checkMaxLength" value="<?=$this->getItem('user', 'sperson')?>"
											maxlength="10" name="asperson" id="asperson">
									</div>
								</div>
								<div class="form_item col-xs-4">
									<p class="height1 align-left checkMaxLengthView"><?=strlen($this->getItem('user', 'sperson'))?>/10</p>
								</div>
							</div>
							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language( 'l_codetax')?></h3>
								</div>
								<div class="form_item col-xs-5">
									<input type="text" class="input full" value="<?=$this->getItem('user', 'tax')?>"
										value="<?=Session::get('atax')?>" disabled="disabled">
								</div>
								<div class="form_item col-xs-4"></div>
							</div>
							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3 class="height2"><?=$this->language( 'l_typebusinees1')?></h3>
								</div>
								<div class="form_item col-xs-5">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty checkMaxLength1" value="<?=$this->getItem('user', 'career1')?>"
											name="acareer1" id="acareer1" maxlength="10" placeholder="<?=$this->language('l_inputstatus')?>">
									</div>
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty checkMaxLength2" value="<?=$this->getItem('user', 'career2')?>" 
											name="acareer2" id="acareer2" maxlength="10" placeholder="<?=$this->language('l_inputcareer')?>">
									</div>
								</div>
								<div class="form_item col-xs-4">
									<p class="height1 align-left checkMaxLengthView1"><?=strlen($this->getItem('user', 'career1'))?>/10</p>
									<p class="height1 align-left checkMaxLengthView2"><?=strlen($this->getItem('user', 'career2'))?>/10</p>
								</div>
							</div>
							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3 class="height3"><?=$this->language('l_accountbank')?></h3>
								</div>
								<div class="form_item col-xs-5">
									<select class="select small full" name="abank" id="abank">
										<option value="0">은행명을 선택하세요.</option>
										<?php 
										$listbank = $this->getData('listbank');
										foreach ($listbank as $key => $value) {?>
										<option value="<?=$value['id']?>" <?php if($this->getItem('user', 'bank')==$value['id']) echo 'selected="selected"';?>>
										<?=$value['name']?>
										</option>
										<?php }?>
									</select>
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty" name="abankname" id="abankname" value="<?=$this->getItem('user', 'bankname')?>" 
											placeholder="<?=$this->language( 'l_inputabank')?>">
									</div>
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty" name="abanknumber" id="abanknumber" value="<?=$this->getItem('user', 'banknumber')?>" 
											placeholder="<?=$this->language('l_inputabanknumber')?>">
									</div>
								</div>
								<div class="form_item col-xs-4" style="text-align: left;padding-left: 30px;">
									<p class="height3">
										<input type="button" class="btn hover small" id="changeabank"  value="<?=$this->language('l_changeabank')?>">
										<input type="button" class="btn hover small" id="confirmabank" style="display: none;" value="<?=$this->language('l_inputabankconfirm')?>">
									</p>
								</div>
							</div>

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_accountimagebank')?></h3>
								</div>
								<div class="form_item col-xs-2">
									<label for="change_bankfiles" class="btn full height1"><?=$this->language('l_accountbankupload')?></label>
									<input id="change_bankfiles" style="display: none;" name="bankfile"
										style="visibility:hidden;" type="file"
										accept="application/pdf,image/*">
									<script type="text/javascript">
    		  							$("#change_bankfiles").change(function() {
    		  								$('#load_file_name').html('<p class="height1 align-left">'+this.files[0].name+'</p>');
    									});
    		  						</script>
								</div>
								<div class="form_item col-xs-7" id="load_file_name" style="text-align: left;">
									<a href="<?=Func::getPathImage("accounts/".$this->getItem('user', 'imgbank_name'),460)?>" target="_blank"><span class="height1 align-left"><?=$this->getItem('user', 'imgbank_name')?></span></a>
								</div>
							</div>
						</div>

					</div>
				</div>

				<div class="forminput">
					<div class="form_group clearfix frrow">
						<div class="row rmclass" data-action="viewperson"
							data-perid="14">
							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_businessinfoaddress')?></h3>
								</div>
								<div class="form_item col-xs-8" style="text-align: left;">
									<input type="button" class="btn hover small" value="<?=$this->language('l_accaddressfind')?>" onclick="goPopup();">
									<div class="note" id="noteAddr">
										<?php if($this->getItem('userinfo','roadFullAddr')){?>
										<p> <?=$this->language('l_accaddress')?> : <?=$this->getItem('userinfo','roadFullAddr')?></p>
										<p> <?=$this->language('l_acccode')?> : <?=$this->getItem('userinfo','jibunAddr')?></p>
										<p> <?=$this->language('l_acczipcode')?> : <?=$this->getItem('userinfo','zipNo')?></p>
										<?php }?>
									</div>
								</div>
								<div class="form_item col-xs-1">
										<input type="hidden"  value="<?=$this->getItem('userinfo','roadFullAddr')?>"
											name="aroadFullAddr" id="roadFullAddr" >
										<input type="hidden"  value="<?=$this->getItem('userinfo','jibunAddr')?>"
											name="ajibunAddr" id="jibunAddr" >
										<input type="hidden"  value="<?=$this->getItem('userinfo','zipNo')?>"
											name="azipNo" id="zipNo" >
										<input type="hidden"  value="<?=$this->getItem('userinfo','city')?>"
											name="asiNm" id="siNm" >
										<input type="hidden"  value="<?=$this->getItem('userinfo','district')?>"
											name="asggNm" id="sggNm" >
										<input type="hidden"  value=""
											name="aemdNm" id="emdNm" >
								</div>
							</div>

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_worktimeout')?></h3>
								</div>
								<div class="form_item col-xs-6">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty checkMaxLength1" placeholder="<?=$this->language('l_example').$this->language('l_workinweek')?> 10:00~21:00, <?=$this->language('l_worksaturday')?> 10:00~24:00"
											name="atimework" value="<?=$this->getItem('userinfo','timework')?>" maxlength="100" >
									</div>
								</div>
								<div class="form_item col-xs-3">
									<p class="height1 align-left checkMaxLengthView1"><?=strlen($this->getItem('userinfo', 'timework'))?>/100</p>
								</div>
							</div>

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_workdayoff')?></h3>
								</div>
								<div class="form_item col-xs-6">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty checkMaxLength2" placeholder="<?=$this->language('l_example').$this->language('l_worktimeoff')?>"
											value="<?=$this->getItem('userinfo','dayoff')?>" name="adayoff"  maxlength="100">
									</div>
								</div>
								<div class="form_item col-xs-3">
									<p class="height1 align-left checkMaxLengthView2"><?=strlen($this->getItem('userinfo', 'dayoff'))?>/100</p>
								</div>
							</div>

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_landlinenumber')?></h3>
								</div>
								<div class="form_item col-xs-5">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty v-numericphone" placeholder="<?=$this->language('l_example')?>02-000-0000"	onkeypress="validate(event)"
											value="<?=$this->getItem('userinfo','phonetable')?>" name="aphonetable" id="aphonetable" maxlength="11">
									</div>
								</div>
								<div class="form_item col-xs-2"></div>
							</div>

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_landlinenumberservice')?></h3>
								</div>
								<div class="form_item col-xs-5">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty v-numericphone" placeholder="<?=$this->language('l_example')?>02-000-0000" onkeypress="validate(event)"
											value="<?=$this->getItem('userinfo','phoneadvisory')?>"	name="aphoneadvisory"  maxlength="11">
									</div>
								</div>
								<div class="form_item col-xs-2" style="padding-top: 10px;width: 110px;">
									<input type="checkbox" value="" id="checkphoneadvisory" class="landlinebumber" <?php if($this->getItem('userinfo','phonetable')==$this->getItem('userinfo','phoneadvisory')) echo 'checked="checked"';?> > 
    								<label for="checkphoneadvisory"> <?=$this->language('l_landlinenumber1')?></label>
								</div>
							</div>

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_landlinenumber2')?></h3>
								</div>
								<div class="form_item col-xs-5">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty v-numericphone" placeholder="<?=$this->language('l_example')?>02-000-0000" onkeypress="validate(event)"
											value="<?=$this->getItem('userinfo','phonecancel')?>" name="aphonecancel"  maxlength="11">
									</div>
								</div>
								<div class="form_item col-xs-2" style="padding-top: 10px;width: 110px;">
									<input type="checkbox" value="" id="checkphonecancel" class="landlinebumber" <?php if($this->getItem('userinfo','phonetable')==$this->getItem('userinfo','phonecancel')) echo 'checked="checked"';?> > 
    								<label for="checkphonecancel"> <?=$this->language('l_landlinenumber1')?></label>
								</div>
							</div>

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_landlinenumber3')?></h3>
								</div>
								<div class="form_item col-xs-5">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty v-numericphone" placeholder="<?=$this->language('l_example')?>02-000-0000" onkeypress="validate(event)"
											value="<?=$this->getItem('userinfo','hotline')?>" name="ahotline"  maxlength="11">
									</div>
								</div>
								<div class="form_item col-xs-2" style="padding-top: 10px;width: 110px;">
									<input type="checkbox" value="" id="checkhotline" class="landlinebumber" <?php if($this->getItem('userinfo','phonetable')==$this->getItem('userinfo','hotline')) echo 'checked="checked"';?> > 
    								<label for="checkhotline"> <?=$this->language('l_landlinenumber1')?></label>
								</div>
							</div>

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_parking')?></h3>
								</div>
								<?php $parking = $this->getItem('userinfo','parking');?>
								<div class="form_item col-xs-2" style="text-align: left;padding-top: 5px;">
									<input type="radio" name="checkparking"  id="checkparking0" 
										onclick='document.getElementById("aparking_fee").value=0;document.getElementById("aparking_fee").setAttribute("disabled", "disabled");'  
										<?php if($parking ==0) echo 'checked="checked"'; ?>  value="0">
									<label for="checkparking0"><?=$this->language('l_parking1')?></label>
								</div>
								<div class="form_item col-xs-2" style="text-align: left;padding-top: 5px;">
									<input type="radio" name="checkparking" id="checkparking1" 
										onclick='document.getElementById("aparking_fee").removeAttribute("disabled");' 
										<?php if($parking ==1) echo 'checked="checked"'; ?> value="1">
									<label for="checkparking1"><?=$this->language('l_parking2')?></label>
								</div>
								<div class="form_item col-xs-2" style="text-align: left;">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty v-numericprice" id="aparking_fee" <?php if($parking ==0) echo 'disabled="disabled"'; ?>
											value="<?=$this->getItem('userinfo','parking_fee')?>" name="aparking_fee"  maxlength="20" />
									</div>
								</div>
							</div>
							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_website')?></h3>
								</div>
								<div class="form_item col-xs-6">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty" placeholder="http://  주소를 입력하세요. "
											value="<?=$this->getItem('userinfo','website')?>"
											name="awebsite"  maxlength="200">
									</div>
								</div>
								<div class="form_item col-xs-3"></div>
							</div>

							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_emailandfax')?></h3>
								</div>
								<div class="form_item col-xs-3">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty"  placeholder="<?=$this->language('l_example')?>tibrage@mmm.mm"
											value="<?=$this->getItem('userinfo','email')?>"
											name="aemail"  maxlength="100">
									</div>
								</div>
								<div class="form_item col-xs-3">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty v-numericphone"  placeholder="<?=$this->language('l_example')?>010-0000-0000"
											value="<?=$this->getItem('userinfo','fax')?>"
											name="afax"  maxlength="11">
									</div>
								</div>
								<div class="form_item col-xs-3"></div>
							</div>
						</div>
					</div>
				</div>

				<div class="form_group">
					<div class="form_item">
						<input id="updateuser" type="button" value="<?=$this->language('l_businessinfoedit')?>" class="btn hover full">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>