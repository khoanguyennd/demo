<script type="text/javascript">
	$(document).ready(function(){
		
		$.fn_channeledit = function(even){			
			var chid = $(even).attr('data-typeid');
			var chstaus = $(even).attr('data-typestatus');
			var parentid = $(even).attr('data-parentid');
			var chlevel = $(even).attr('data-typelevel');
			
			var strname = $(even).text();
			var strparent = chid;
			$('input[name="channelstatus"][value="'+chstaus+'"]').click();
			$('#channel_chname').attr({'data-parentid':parentid, 'data-typeid':chid, 'data-typelevel':chlevel}).val(strname);		
			if(chid == 0){
				$('#channel_chname').val('');
				$('.btn.channeledit').hide();
	    		$('.btn.channeladd').removeClass('hiden');
			}else{
				var chlevel1=chlevel;
				while (parentid > 0){	
					var elemt = $('.treemenu label[data-typeid="'+parentid+'"]');
					
			        strname = $(elemt).text() + ((chlevel1<=4)?' > '+ strname:'');
			        parentid = $(elemt).attr('data-parentid');
			        strparent += ','+$(elemt).attr('data-typeid');
			        
			        chlevel1--;		      
			    }
			    $('.btn.channeledit').show();
	    		$('.btn.channeladd').addClass('hiden');
			}
			$('#channel_levelname').attr('data-strparent', strparent).val(strname);
			if(chlevel==4){
				$.fn_ajax('loadMatchType',{'chid': chid}, function(result){
		    		if(result.flag == true){	    				
	    				$('.channelresult').html(result.divresult);
		    		}
	    		},false,false);
			}else{
				$('.channelresult').html("");
			}
		}
		// Hiển thị menu channel T-Gridge
	    $('#container').on('click', 'ul.ch_parrent li a', function(){
	    	if($(this).attr('class')!='active'){
	    		$('#container ul.ch_parrent li a').removeClass('active');
		    	$(this).addClass('active');
		    	$.fn_channeledit(this);
		    	$(this).closest('ul').find('>li ul').slideUp();
		    	$(this).next().slideToggle();		    	
	    	}    	
	    	return false;
	    });
	    $('#container').on('click', 'div.treemenu li label', function(){
	    	if($(this).attr('class')!='active'){
	    		$('#container div.treemenu li label').removeClass('active');
		    	$(this).addClass('active');
		    	$.fn_channeledit(this);
	    	}    	
	    	return false;
	    });
	    // Hiển thị form thêm phân loại
	    $('.btn.channeladdform').on('click', function(){
	    	if($('#container div.treemenu label.active').is(':visible')){
	    		var parentid = $('#channel_chname').attr('data-parentid');
	    		var chlevel = $('#channel_chname').attr('data-typelevel');
	    		if(parentid && chlevel < 4){
	    			$('#channel_chname').val('').focus();
	    			$('.btn.channeledit').hide();
	    			$('.btn.channeladd').removeClass('hiden');
	    		}else{
	    			$.fn_alert(true, true, "<?=$this->language('l_Channel10')?>");
	    		}
	    	}else{
	    		$.fn_alert(true, true, '<?=$this->language('l_Channel11')?>');
	    	}	    	
	    });
	    // Thực hiện thêm phân loại mới
	    $('.btn.channeladd').on('click', function(){	    	
	    	var chlevel= $('#channel_chname').attr('data-typelevel');	    	
	    	if(chlevel == 4){
	    		$.fn_alert(true, true, '<?=$this->language('l_Channel12')?>');
	    		return false;
	    	}
	    	var chname = $('#channel_chname').val();
	    	if(chname == ''){
	    		$.fn_alert(true, true, '<?=$this->language('l_Channel13')?>');
	    		return false;
	    	}
	    	var chstatus = $('input[name="channelstatus"]:checked').val();	    	
	    	if(!chstatus){
	    		$.fn_alert(true, true, '<?=$this->language('l_Channel14')?>');
	    		return false;
	    	}
	    	var chid = $('#channel_chname').attr('data-typeid');
	    	if(chname && chlevel && chid && chstatus){
	    		$.fn_ajax('addProductType',{'chparentid': chid, 'chname':chname, 'chlevel': chlevel, 'chstatus':chstatus}, function(result){
		    		console.log(result);
	    			if(result.flag == true){
	    				$.fn_alert(false);
	    				var elms = $('div.treemenu label.active[data-typeid="'+chid+'"]');
	    				if(chid==0){
	    					$(elms).closest('ol').next().append(result.row);
	    				}else{
	    					var elms = $(elms).closest('li');	 
		    				if($(elms).find('>ol').length>0){		    					
		    					$(elms).find('>ol').append(result.row);
		    				}else{
		    					$(elms).append('<ol class="tree">'+result.row+'</ol>');
		    				}
		    				$('#channel_chname').val('').focus();
	    				}	    				
	    			}else{
	    				$.fn_alert(true, false, '<?=$this->language('l_Channel15')?>');
	    			}
	    		});
	    	}
	    });
	    
	    // Thực hiển hiển thị chế độ hiển thị menu product type
	    $('#ch_check1').on('click', function(){
	    	$.fn_ajax('viewProductType', {'pdmode': $(this).is(':checked')}, function(result){
	    		if(result.flag == true){
	    			$('#container div.treemenu').html(result.produttype);
	    		}else{
	    			window.location.reload();
	    		}
	    	},true);		    	  	
	    });
	    // Thực hiển cập nhật tên phân loại
	    $('.btn.channeledit').on('click', function(){	    	
	    	var chname = $('#channel_chname').val();
	    	var chid = $('#channel_chname').attr('data-typeid');
	    	if(chid == ''){
	    		$.fn_alert(true, true, '<?=$this->language('l_Channel16')?>');
	    		return false;
	    	}
	    	if(chname == ''){
	    		$.fn_alert(true, true, '<?=$this->language('l_Channel17')?>');
	    		return false;
	    	}
	    	var chstatus = $('input[name="channelstatus"]:checked').val();    	
	    	if(!chstatus){
	    		$.fn_alert(true, true, '<?=$this->language('l_Channel18')?>');
	    		return false;
	    	}
	    	if(chname && chid && chstatus){
	    		$.fn_ajax('editProductType', {'chid': chid, 'chname':chname, 'chstatus':chstatus}, function(result){
	    			$.fn_alert(false);
	    			if(result.flag == true){	    				
	    				var elemt = $('div.treemenu label.active[data-typeid="'+chid+'"]');
	    				if($('#ch_check1').is(':checked') && chstatus == 0){
	    					$(elemt).closest('li').remove();
	    				}else{
	    					$(elemt).attr('data-typestatus', chstatus).html(chname);
	    					$('#container div.treemenu li label.active').removeClass('active').click();
	    				}	    				
	    			}else{
	    				$.fn_alert(true, false, '<?=$this->language('l_Channel15')?>');
	    			}
	    		});
	    	}		    	  	
	    });
	    // Thực hiển xóa phân loại
	    $('.btn.channeldelete').on('click', function(){
	    	var elemt = $('#container div.treemenu li label.active');	    
	    	var strchild = $(elemt).attr('data-typeid');
	    	$(elemt).next().find('label').each(function(){
	    		strchild += ','+$(this).attr('data-typeid');
	    	});	    	
	    	if(strchild == ''){
	    		$.fn_alert(true, true, '<?=$this->language('l_Channel19')?>');
	    		return false;
	    	}	 
	    	$.fn_confirm(true, {'data-strchild': strchild, 'class':'channeldelete'}, "<?=$this->language('l_Channel20')?>");
	    });
	    
	    // Tiếp tục xóa phân loại
	    $($.elt_popup).on('click', '.confirm .channeldelete .continue', function(){
	    	var strchild = $(this).attr('data-strchild');
	    	if(strchild){
	    		$.fn_confirm(false);
	    		$.fn_ajax('deleteProductType', {'strchild': strchild}, function(result){
	    			$.fn_alert(false);
	    			if(result.flag == true){
	    				$('#container div.treemenu li label.active').closest('li').remove();
	    				$('#channel_levelname').val("");
	    				$('#channel_levelname').removeAttr("data-strparent");
	    				$('#channel_chname').val("")
	    				$('#channel_chname').removeAttr("data-parentid");
	    				$('#channel_chname').removeAttr("data-typeid");
	    				$('#channel_chname').removeAttr("data-typelevel");
	    				$('#channel_chname').removeAttr("data-check");
	    				$('.channelresult').html("");
	    			}else{
	    				$.fn_alert(true, false, '<?=$this->language('l_Channel21')?>');
	    			}
	    		});
	    	}
	    });	   
		// Thực hiện download file excel
		$('.btn.dowloadexcel').on('click', function(){			
			var titleName = $('#contents .ct_head h3').text();  
			var description = $('#contents .ct_head p').text();  			
			if(titleName && description){
				window.open(encodeURI(jsData.urlAjax + 'downloadProductType?titleName='+titleName+'&description='+description));
			}
		});


		// Show bang so khop
	    $('.btn.channelmatchtype').on('click', function(){	
	    	var chid = $('#channel_chname').attr('data-typeid');
	    	var chlevel = $('#channel_chname').attr('data-typelevel');
			if(chlevel==4){
    	    	$.fn_ajax('loadMatchType1', {'chid': chid}, function(result){
    		    	console.log(result);
    	    		$.fn_popup(true, 'channelmatchtype', true, true);
    	    		$('#spantypebridge').html($('#channel_levelname').val());
    	    		$('#divChannel').html(result.divChannel);
    	    		var html ='<li data-typeId="0" data-channeltypeId="0" style="font-weight: bold;">선택채널/카테고리 ( N 개)</li> <li data-typeId="0" data-channeltypeId="0"></li>';
    	    		$('#divmathtype').html(html);
    	    		$('#divtypedepth1').html("");
    	    		$('#divtypedepth2').html("");
    	    		$('#divtypedepth3').html("");
    	    		$('#divtypedepth4').html("");
    	    		$('#divmathtype').append(result.divmathtype);
    	    		
                    $('.btn.btndelmatchtype').on('click', function(){	
                    	$(this).parents('li').remove();
                    });
                    
                    $('#divChannel li').on('click', function(){	   	
                    	$('#divChannel li').removeClass('active');
                    	$(this).addClass('active');
                    	var channelId= $(this).attr('data-channelId');
                    	$.fn_ajax('loadtypedepth1', {'channelId':channelId}, function(result1){
            	    		$('#divtypedepth1').html(result1.divtypedepth1);
            	    		$('#divtypedepth2').html("");
            	    		$('#divtypedepth3').html("");
            	    		$('#divtypedepth4').html("");
                            $('#divtypedepth1 li').on('click', function(){	   	
                            	$('#divtypedepth1 li').removeClass('active');
                            	$(this).addClass('active');
                            	var typedepth1= $(this).attr('data-typedepth1');
                            	$.fn_ajax('loadtypedepth2', {'channelId':channelId,'typedepth1':typedepth1}, function(result2){
                    	    		$('#divtypedepth2').html(result2.divtypedepth2);
                    	    		$('#divtypedepth3').html("");
                    	    		$('#divtypedepth4').html("");
                                    $('#divtypedepth2 li').on('click', function(){	   	
                                    	$('#divtypedepth2 li').removeClass('active');
                                    	$(this).addClass('active');
                                    	var typedepth2= $(this).attr('data-typedepth2');
                                    	$.fn_ajax('loadtypedepth3', {'channelId':channelId,'typedepth1':typedepth1,'typedepth2':typedepth2}, function(result3){
                            	    		$('#divtypedepth3').html(result3.divtypedepth3);
                            	    		$('#divtypedepth4').html("");
                                            $('#divtypedepth3 li').on('click', function(){	   	
                                            	$('#divtypedepth3 li').removeClass('active');
                                            	$(this).addClass('active');
                                            	var typedepth3= $(this).attr('data-typedepth3');
                                            	$.fn_ajax('loadtypedepth4', {'channelId':channelId,'typedepth1':typedepth1,'typedepth2':typedepth2,'typedepth3':typedepth3}, function(result4){
                                    	    		$('#divtypedepth4').html(result4.divtypedepth4);
                                                    $('#divtypedepth4 li').on('click', function(){	   	
                                                    	$('#divtypedepth4 li').removeClass('active');
                                                    	$(this).addClass('active');
                                                    });
                                        		});	
                                            });
                                		});	
                                    });
                        		});	
                            });
            	    		 
                		});	
                    }); 

                    return false;
        		});	
			}else{
				$.fn_alert(true, true, "티브리지 카테고리의 세분류를 선택하세요.");
			}
			return false;
	    });
	    $('.btn.btnmatchtype').on('click', function(){	
		    var typeId=[];
		    var channeltypeId=[];
	    	$('#divmathtype').find('li').each(function(){
	    		if($(this).attr('data-typeId')!=0){
	    			typeId.push($(this).attr('data-typeId'));
	    			channeltypeId.push($(this).attr('data-channeltypeId'));
	    			$(this).remove();
	    		}
	    	});	  
			var chid = $('#channel_chname').attr('data-typeid');
	    	$.fn_ajax('savematchtype',{'chid': chid,'typeId':typeId,'channeltypeId':channeltypeId}, function(result1){
				console.log(result1);
	    		if(result1.flag == true){	    				
    				$('.channelresult').html(result1.divresult);
	    		}
    		});
    		$($.elt_popup).hide().find('.absolute').hide();
	    	
        });
	    $('.btn.btnaddmatchtype').on('click', function(){	
	    	var chid = $('#channel_chname').attr('data-typeid');
	    	var flag=0;
		    if($('#divtypedepth4').html()==""){
			    $('#divtypedepth3').find('li.active').each(function(){
			    	flag=1;
			    	var channelid = $(this).attr('data-channelid');
			    	var typedepth1 = $(this).attr('data-typedepth1');
			    	var typedepth2 = $(this).attr('data-typedepth2');
			    	var typedepth3 = $(this).attr('data-typedepth3');
			    	var typedepth4 = "";
			    	$.fn_ajax('getchanneltypeId',{'channelid': channelid,'typedepth1': typedepth1,'typedepth2':typedepth2,'typedepth3':typedepth3,'typedepth4':typedepth4}, function(result){
				    	var co=0;
			    		$('#divmathtype').find('li').each(function(){
				    		if($(this).attr('data-channeltypeid')==result.channeltypeId){
				    			co=1;
				    		}
				    	});	
				    	if(co==0){
    			    		var html =' <li data-typeid="'+chid+'" data-channeltypeid="'+result.channeltypeId+'"> ';
    		    			html += ' 		'+result.channelname+' &gt; '+typedepth1+' &gt; '+typedepth2+' &gt; '+typedepth3+' &gt; '+typedepth4+'  : '+result.typerate+'% ';
    		    			html += ' 		<input type="button" name="" class="btn hover small btndelmatchtype" value="삭제">	';
    		    			html += '   </li>';
    		    			$('#divmathtype').append(html);
		    			}else{
		    				$.fn_alert(true, true, "채널사 카테고리를 매칭했습니다.");
		    			}
		    		});
			    	
			    });
		    }else {
		    	$('#divtypedepth4').find('li.active').each(function(){
		    		flag=1;
		    		var channelid = $(this).attr('data-channelid');
			    	var typedepth1 = $(this).attr('data-typedepth1');
			    	var typedepth2 = $(this).attr('data-typedepth2');
			    	var typedepth3 = $(this).attr('data-typedepth3');
			    	var typedepth4 = $(this).attr('data-typedepth4');
			    	$.fn_ajax('getchanneltypeId',{'channelid': channelid,'typedepth1': typedepth1,'typedepth2':typedepth2,'typedepth3':typedepth3,'typedepth4':typedepth4}, function(result){
			    		var co=0;
			    		$('#divmathtype').find('li').each(function(){
				    		if($(this).attr('data-channeltypeid')==result.channeltypeId){
				    			co=1;
				    		}
				    	});	
				    	if(co==0){
    			    		var html =' <li data-typeid="'+chid+'" data-channeltypeid="'+result.channeltypeId+'"> ';
    		    			html += ' 		'+result.channelname+' &gt; '+typedepth1+' &gt; '+typedepth2+' &gt; '+typedepth3+' &gt; '+typedepth4+'  : '+result.typerate+'% ';
    		    			html += ' 		<input type="button" name="" class="btn hover small btndelmatchtype" value="삭제">	';
    		    			html += '   </li>';
    		    			$('#divmathtype').append(html);
		    			}else{
		    				$.fn_alert(true, true, "채널사 카테고리를 매칭했습니다.");
		    			}
		    		});
			    });
		    }
		    if(flag==0)
		    $.fn_alert(true, true, "채널사 카테고리의 마지막 분류를 선택하세요.");
			    
		    

		   
	    	//$('#divmathtype').append(result.divmathtype);
        });
	    
	});
</script>

<style>
ol.tree
{
    padding: 5px 0 0 0;
    width: 270px;
}

ol.tree li 
{
    list-style: none;
    padding: 5px;
}
ol.tree li input
{
    opacity: 0;
    margin-left: 3px;
    display: flex;
    margin-top: -15px;
}
ol.tree li input + ol
{
    background: url(img/arrow-down.png) 45px -3px no-repeat;
    margin: -0.938em 0 0 -44px;
    height: 1em;
}
ol.tree li input + ol > li { display: none; margin-left: -14px !important; padding-left: 1px; }
ol.tree li label
{
    cursor: pointer;
    display: block;
    padding-left: 20px;
}

ol.tree li label.active, ol.tree li label:hover {
    color: #DB4437;
}
ol.tree li input:checked + ol
{
    background: url(img/arrow-up.png) 45px 4px no-repeat;
    margin: -1.25em 0 0 -44px;
    padding: 1.563em 0 0 80px;
    height: auto;
}
ol.tree li input:checked + ol > li { display: block; margin: 0 0 0.125em;}
ol.tree li input:checked + ol > li:last-child { margin: 0 0 0.063em; }

.contentpopup ul {
    display: inline-block;
    width: 150px;
    height : 150px;
    border: 1px solid;
    padding: 5px;
    overflow: auto;
 }
 .contentpopup ul li {
    padding: 5px;
 }
 
.contentpopup ul li.active,.contentpopup ul li:hover {
    color: #DB4437;
}
</style>

<div class="ct_head">
	<h3><?=$this->language('l_Channel22')?></h3>
	<p><?=$this->language('l_Channel23')?></p>
</div>
<div class="ct_content">
	<div class="form_group clearfix channel">
		<div class="form_table">
			<div class="table_head bgwhite">
				<div class="ctrl_head clearfix">
					<div class="title col-xs-3">
						<button type="button" name="newpost" class="btn small hover"><?=$this->language('l_Channel24')?></button>
						<button type="button" name="newpost" class="btn small hover"><?=$this->language('l_Channel25')?></button>
					</div>
					<div class="title col-xs-5">
						<button type="button" name="newpost" class="btn small hover dowloadexcel"><?=$this->language('l_Channel26')?></button>						
					</div>
					<div class="icons col-xs-4 align-right">
						<button type="button" name="channeladdform" class="btn small hover channeladdform"><?=$this->language('l_Channel27')?></button>
						<button type="button" name="channeldelete" class="btn small hover channeldelete"><?=$this->language('l_Channel28')?></button>
					</div>
				</div>
			</div>
			<div class="table_content clearfix" id="channelTgridge">
				<div class="channelLeft col-xs-4">
					<div class="ch_head">
						<input type="checkbox" name="" value=""<?=(Session::get('pdmode')?' checked="checked"':'')?> id="ch_check1">
						<label for="ch_check1"><?=$this->language('l_Channel29')?></label>
					</div>
					<div class="ch_content scrollbar">
						<ul class="ch_parrent">
							<li><a href="#" class="chroot" title="<?=$this->language('l_Channel22')?>" data-typeid="0" data-parentid="0" data-typestatus="1" data-typelevel="0"><?=$this->language('l_Channel22')?></a></li>
						</ul>
						<?=$this->getData('menuTbridge')?>						
					</div>
				</div>
				<div class="channelRight col-xs-8">
					<div class="form_group">
						<form action="#" method="POST">
							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_Channel30')?></h3>
								</div>
								<div class="form_item col-xs-9">
									<input type="text" class="input full" id="channel_levelname" name="" value="" disabled="disabled">
								</div>
							</div>							
							<div class="form_group clearfix">
								<div class="form_item col-xs-3">
									<h3><?=$this->language('l_Channel31')?></h3>
								</div>
								<div class="form_item col-xs-9">
									<div class="inputconfirm">
										<input type="text" class="input full checkEmpty" name="" id="channel_chname" value="">
									</div>									
								</div>
							</div>
							<div class="form_group clearfix">
								<div class="form_item col-xs-5">
									<h3><?=$this->language('l_Channel32')?></h3>
								</div>
								<div class="form_item col-xs-3 itemradio">
									<input type="radio" name="channelstatus" value="1" checked="checked" id="chn-radio1">
									<label for="chn-radio1"><?=$this->language('l_acctable2')?></label>
								</div>
								<div class="form_item col-xs-4 itemradio">
									<input type="radio" name="channelstatus" value="0" id="chn-radio2">
									<label for="chn-radio2"><?=$this->language('l_acctable12')?></label>
								</div>
							</div>														
							<div class="form_group align-center">
								<input type="button" name="channeledit" value="<?=$this->language('l_Channel43')?>" class="btn hover small channeledit">
								<input type="button" name="channeladd" value="<?=$this->language('l_Channel44')?>" class="btn hover small channeladd hiden">
							</div>
						</form>
					</div>
					<div class="form_group channeloption">
						<div class="channelmatch">
							<div class="form_group clearfix">
								<div class="form_item col-xs-7 align-left">
									<div class="height1">
										<!-- <input type="checkbox" name="" checked="checked" value="" style="vertical-align: text-bottom;"> -->
										<label for="chn-radio1" style="vertical-align: middle;"><?=$this->language('l_Channel33')?></label>
								</div>
								</div>
								<div class="form_item col-xs-5 align-right">
									<input type="button" name="" class="btn hover small channelmatchtype" value="<?=$this->language('l_Channel42')?>">									
								</div>
							</div>
						</div>
						<div class="channelresult">
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>