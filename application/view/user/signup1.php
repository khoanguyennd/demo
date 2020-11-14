<script type="text/javascript" src="attach/js/webtoolkit.aim.js"></script>
<script type="text/javascript" src="attach/js/myattach.js"></script>
<script type="text/javascript">
	$(document).ready(function(){	

		$('#signupCompany').on('click', function(){	
			var atax=$('#atax1').val() + "-" + $('#atax2').val() + "-" + $('#atax3').val();
            $.fn_ajax('signupCompany', {'atax': atax}, function (result) {
            	console.log(result);
            	if(result.flag == true) {
            		$.fn_alert(true, true, result.state);
               	}else{
               		$.fn_alert(true, true, result.error);
               	} 
            });			
			return false;
		});
			
		$('#signupAdmin').on('click', function(){	
			var formdata = new FormData(); 
			var fileupload = $("#change_files_pdf")[0].files[0]; 
			formdata.append("fileupload", fileupload);
			formdata.append("atax1", $('#atax1').val());
			formdata.append("atax2", $('#atax2').val());
			formdata.append("atax3", $('#atax3').val());
			formdata.append("acheck1", $('#acheck1:checked').val()); 
			formdata.append("acheck2", $('#acheck2:checked').val());
			formdata.append("atax", formdata.get('atax1') + "-" + formdata.get('atax2') + "-" + formdata.get('atax3'));	
            if(formdata.get('atax1') == ''){
            	$('#atax1').focus();
            	return false;
            }
            if(formdata.get('atax2') == ''){
            	$('#atax2').focus();
            	return false;
  			}
  	        if(formdata.get('atax3') == ''){
            	$('#atax3').focus();
            	return false;
            }           
            if(formdata.get('fileupload')=='undefined'){
            	$.fn_alert(true, true, "<?=$this->language('l_errrfiledkkd')?>");
            	return false;
            }
           	if (formdata.get('acheck1') != 'on') {
           		$.fn_alert(true, true, "<?=$this->language('l_agree1')?>");
                return false;
            }
            if (formdata.get('acheck2') != 'on') {
                $.fn_alert(true, true, "<?=$this->language('l_agree2')?>");                    
                return false;
            }
            $.fn_ajax_upload_file('signupStep1', formdata, function(result){
            	if(result.flag == true) {
                   	window.location.assign('<?=$this->route('signupStep2')?>');
               	}else{
               		$.fn_alert(true, true, result.error); 
               	} 
            });			
			return false;
		});
	});
</script>
<div class="signup_area">
	<div class="signup_area_content" id="DivloginSoho" >
		<div class="signup_head">
			<div class="signup_title">
				<h1><?=$this->language('l_titlesignup')?></h1>
			</div>			
			<div class="signup_step clearfix">
				<div class="step_item active clearfix">
					<div class="item_number">
						<span>1</span>
					</div>
					<div class="item_text">
						<h3><?=$this->language('l_top01')?></h3>
						<p><?=$this->language('l_top03')?></p>
					</div>
				</div>
				<div class="step_item clearfix">
					<div class="item_number">
						<span>2</span>
					</div>
					<div class="item_text">
						<h3><?=$this->language('l_top02')?></h3>
						<p><?=$this->language('l_top04')?></p>
					</div>
				</div>
			</div>
		</div>
		<div class="signup_form">
			<form action="" method="post" enctype="multipart/form-data" id="af">
				<div class="form_group clearfix">
					<div class="form_item col-xs-2">
						<h3><?=$this->language( 'l_codetax')?></h3>
					</div>
					<div class="form_item col-xs-2">
						<input type="text" class="input full v-numeric" name="atax1" id="atax1"  maxlength="3" placeholder="<?=$this->language( 'l_tax1')?>">
					</div>
					<div class="form_item col-xs-2">
						<input type="text" class="input full v-numeric" name="atax2" id="atax2"  maxlength="2" placeholder="<?=$this->language('l_tax2')?>">
					</div>
					<div class="form_item col-xs-2">
						<input type="text" class="input full v-numeric" name="atax3" id="atax3"  maxlength="5" placeholder="<?=$this->language('l_tax3')?>">
					</div>
					<div class="form_item col-xs-2">
						<input type="button" class="btn hover full"  id="signupCompany" name="" value="<?=$this->language('l_companyconfirm')?>">
					</div>
					<div class="form_item_error col-xs-12"></div>
				</div>
				<div class="form_group clearfix">
					<div class="form_item col-xs-2">
						<h3><?=$this->language('l_dkkdname')?></h3>
					</div>
					<div class="form_item col-xs-2">
						<label for="change_files_pdf" class="btn full" style="text-align:center;"><?=$this->language( 'l_dkkdupload')?></label>
  						<input id="change_files_pdf" style="display: none;" name="file" style="visibility:hidden;" type="file" accept="application/pdf,image/*">
  						<script type="text/javascript">
  							$("#change_files_pdf").change(function() {
  								$('#load_file_name p').html(this.files[0].name);
							});
  						</script>  					
					</div>
					<div class="form_item col-xs-6" id="load_file_name"><p  class="height1"><!-- <?=$this->language('l_rulefile01')?> --></p></div>
					<div class="form_item_error col-xs-2"></div>
				</div>
				<div class="form_group clearfix">
					<div class="form_item col-xs-12">
						<h3><?=$this->language('l_rule')?></h3>
					</div>
					<div class="form_item col-xs-12" style="margin-bottom: 15px;">
						<div class="item_check clearfix">
							<div class="checkbox col-xs-6">
								<input id="acheck1" type="checkbox" name="acheck1">
								<label for="acheck1"><?=$this->language( 'l_textarea1')?></label>
							</div>
							<div class="checkbox col-xs-6">
								<input id="acheck2" type="checkbox" name="acheck2">
								<label for="acheck2"><?=$this->language('l_textarea2')?></label>
							</div>
						</div>					
					</div>	
					<div class="form_item col-xs-12">
						<div class="form_tab">
							<div class="tab_head">
								<ul class="clearfix">
									<li><a class="active" data-tab="tab1" title=""><?=$this->language( 'l_rule01')?></a></li>
									<li style="margin: 0 0 0 2px;"><a data-tab="tab2" title=""><?=$this->language('l_rule02')?></a></li>
								</ul>
								<script type="text/javascript">
		  							$(document).ready(function(){					
										if(location.hash){
											$('.tab_head a').removeClass('active');
											$('.tab_head a[href='+location.hash+']').addClass('active');
											$('.tab_content > div').hide();
											$(location.hash+'a').show();
										}
										$(".form_tab .tab_head").on('click', 'a', function(){
											var id = $(this).attr('data-tab');
											if(id){
												$(this).closest('ul').find('a').removeClass('active');
												$(this).addClass('active');
												$('.tab_content > div').hide();
												$('#'+id+'a').show();												
											}
										});
									});
		  						</script>  	
							</div>
							<div class="tab_content scrollbar">
								<div id="tab1a">
									<?php require 'rule/rule1.php'; ?>
								</div>
								<div id="tab2a" style="display:none;">
									<?php require 'rule/rule2.php'; ?>
								</div>
							</div>
						</div>				
					</div>			
				</div>
				<div class="form_group clearfix">
					<div class="form_item col-xs-12" style="text-align: center;">
						<input type="button" class="btn hover small" name="" value="흠으로" 
						onclick="window.location.assign('<?=$this->route('home')?>');">
						<input type="button" class="btn hover small" name="" value="<?=$this->language('l_continue')?>" id="signupAdmin">
					</div>	
				</div>
			</form>
		</div>
	</div>
</div>