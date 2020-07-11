<?php
$sellerProductId = $this->getData ( 'sellerProductId' );
$inventoryType="PERIOD";
$pricebasic = 0;
$pricerepresentative = 0;
$list_sellerProduct  = $this->getData('list_sellerProduct');
foreach ($list_sellerProduct as $value => $giatri) {
    $inventoryType       = $giatri['inventoryType'];
    $pricebasic          = $giatri['pricebasic'];
    $pricerepresentative = $giatri['pricerepresentative'];
    $saleStartedAt = $giatri ['saleStartedAt1'];
    $saleEndedAt = $giatri ['saleEndedAt1'];
    $useStartedAt = $giatri ['useStartedAt1'];
    $useEndedAt = $giatri ['useEndedAt1'];
}


$list_periodrates = array();
$list_periodrates = $this->getData('list_periodrates');

$list_travelitems     = array();
$list_travelitemstemp = $this->getData('list_travelitems');
foreach ($list_travelitemstemp as $value => $giatri) {
    $list_travelitems[] = array(
        $giatri['sellerTravelItemId'],
        $giatri['name'],
        $giatri['onSale'],
        $giatri['description'],
        $giatri['taxType'],
        $giatri['seq'],
        $giatri['representative']
    );
}


?>
<link rel="stylesheet" type="text/css"
	href="<?=URL_PUBLIC?>css/jsDatePick_ltr.min.css" />
<script type="text/javascript"
	src="<?=URL_PUBLIC?>js/jsDatePick.min.1.3.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){		
	
	$('#saveTemp').on('click', function(){	
		var ff = document.nf;
		var step = $(this).attr('data-step');
		document.getElementById("step").value=step;
		
		if( !$.trim( $('#feedback').html() ).length ) {
            $.fn_alert(true, true, "<?= $this->language('l_warnproduct1') ?>");
            return false;
        }
        
        var radioValue = $("input[name='representative']:checked").val();
        if(radioValue==undefined){
            $.fn_alert(true, true, "<?= $this->language('l_warnproduct2') ?>");
            return false;
        }

        ff.submit();
	});
	// Tiếp tục | Trở lại
	$('#continuelink, #backlink').on('click', function(){
		var step = $(this).attr('data-step');
		if(step){
			$('#step').val(step);	
			$.fn_ticketcontinue(step);	
		}
	});
	// Tiếp tục | Trở lại
	$($.elt_popup).on('click', '.ticketconfirm .continue', function(){		
		$.fn_ticketconfirm(false);
		
		if( !$.trim( $('#feedback').html() ).length ) {
            $.fn_alert(true, true, "<?= $this->language('l_warnproduct1') ?>");
            return false;
        }
        
        var radioValue = $("input[name='representative']:checked").val();
        if(radioValue==undefined){
            $.fn_alert(true, true, "<?= $this->language('l_warnproduct2') ?>");
            return false;
        }	
        $('#nf').submit();	        
	});

	 $('.inventoryType').on('click', function(){
	        var radioValue = $("input[name='inventoryType']:checked").val();
	        if(radioValue=="PERIOD"){
	            $(".form_tab .tab_head #tab1").css({display: 'block'});
	            $(".form_tab .tab_head #tab1").addClass( "active" );
	            $(".form_tab .tab_head #tab2").css({display: 'none'});
	            $(".form_tab .tab_head #tab2").removeClass("active");
	            $(".form_tab .tab_head #tab3").removeClass("active");
	            
	            $('#tab1a').css({display: 'block'});
	            $('#tab2a').css({display: 'none'});
	            $('#tab3a').css({display: 'none'});
	        }
	        if(radioValue=="DAILY"){
	            $(".form_tab .tab_head #tab1").css({display: 'none'});
	            $(".form_tab .tab_head #tab2").css({display: 'block'});
	            $(".form_tab .tab_head #tab2").addClass( "active" );
	            $(".form_tab .tab_head #tab1").removeClass("active");
	            $(".form_tab .tab_head #tab3").removeClass("active");
	            
	            $('#tab1a').css({display: 'none'});
	            $('#tab2a').css({display: 'block'});
	            $('#tab3a').css({display: 'none'});
	        }
	    });

	    $('#addTravelItem1').on('click', function(){
	        var formdata = [];        
	        var i = dem= 0;
	        var co=1;
	        var element1 = $('#feedback1 tr input[name="nameOption1"]');
	        $(element1).each(function(index1, value1){
	            dem++;
	            var element2 = $(value1).closest('tr');
	            var name1 = $(element2).find('input[name="nameOption1"]').val();
	            if(!name1){
	                 alert("<?= $this->language('l_addticket2') ?> " + index1);    
	                 co=0;
	            }
	            
	            if($(element2).find('input[name="nameOption2"]').length>0){
	                var name2 = $(element2).find('input[name="nameOption2"]').val();
	                if(!name2){
	                     alert("<?= $this->language('l_addticket2') ?> " + index1);    
	                     co=0;
	                }    
	            }        
	        });
	        if(co==1 && dem >0){
	            $(element1).each(function(index1, value1){
	                var element2 = $(value1).closest('tr');
	                var name1 = $(element2).find('input[name="nameOption1"]').val();                
	                var name2 = $(element2).find('input[name="nameOption2"]').val();                    
	                var name = $.fn_split(name1, (name2?name2:''));            
	                $.each(name, function(index2, value2){                
	                    formdata[i] = $.fn_addTravelItem1(value2, element2);
	                    i++;
	                });
	            });
	            console.log(formdata);
	            $.fn_ajax('addTravelItem1', {'formdata': formdata}, function(result){
	                if(result.flag = true){
	                    $('#feedback').append(result.data);
	                    $('#feedback1 tr input[name="idOption"]').each(function(){    
	                        document.multiselect('#rateType'+$(this).val()).destroy();
	                    });
	                    $('#feedback1 tr').remove();
	                    
	                    document.getElementById('numberDepth').disabled = false;    
	                    onloadJsDatePickTravelItem();
	                }
	            },true);
	        }
	        
	        return false;
	    });
	    $.fn_split = function(name1, name2){
	        var i=0;
	        var name = [];        
	        name1 = name1.split(",");
	        name2 = name2.split(",");        
	        $.each(name1, function(index1, value1){                        
	            var flag = true;
	            $.each(name2, function(index2, value2){                
	                if(value2){
	                    flag = false;
	                    name[i] = value1+'-'+value2;
	                    i++;
	                }                    
	            });
	            if(flag == true){
	                name[i] = value1;
	                i++;
	            }
	        });
	        return name;    
	    }    
	    $.fn_addTravelItem1 = function(name, element){    
	        var rateType=["BASIC"];
	        if($(element).find('select[name="rateType"] option[selected="selected"]').length>0){
	            rateType=[];
	            $(element).find('select[name="rateType"] option[selected="selected"]').each(function(){            
	                rateType.push($(this).val());
	            });    
	        }
	        return {
	                'nameOption':name,
	                'idOption': $(element).find('input[name="idOption"]').val(),                
	                'price': $(element).find('input[name="price"]').val(),
	                'pricesale': $(element).find('input[name="pricesale"]').val(),
	                'rateType': rateType,
	                'useStartedAt': "<?=$useStartedAt?>",
	                'useEndedAt': "<?=$useEndedAt?>",
	                'saleStartedAt': "<?=$saleStartedAt?>",
	                'saleEndedAt': "<?=$saleEndedAt?>",
	            }
	    }
	    //
	    $('#addTravelItem2').on('click', function(){
	        var formdata = [];        
	        var i = dem= 0;
	        var co=1;
	        var element1 = $('#feedback2 tr input[name="nameOption"]');
	        $(element1).each(function(index1, value1){
	            dem++;
	            var element2 = $(value1).closest('tr');
	            var name1 = $(element2).find('input[name="nameOption"]').val();
	            if(!name1){
	                 alert("<?= $this->language('l_addticket2') ?> " + index1);    
	                 co=0;
	            }
	        });
	        if(co==1 && dem >0){
	            $(element1).each(function(index1, value1){
	                var element2 = $(value1).closest('tr');
	                var name = $(element2).find('input[name="nameOption"]').val();        
	                name = name.split(",");                    
	                $.each(name, function(index2, value2){                
	                    formdata[i] = $.fn_addTravelItem2(value2, element2);
	                    i++;
	                });
	            });
	            console.log(formdata);
	            $.fn_ajax('addTravelItem2', {'formdata': formdata}, function(result){
	                if(result.flag = true){
	                    $('#feedback').append(result.data);
	                    $('#feedback2 tr').remove();
	                    onloadJsDatePickTravelItem();
	                }
	            },true);
	        }
	        
	        return false;
	    });

	    $.fn_addTravelItem2 = function(name, element){    
	        var weekendType  = $(element).find('select[name="weekendType"] option:selected').val();
	        var priceweekend = pricesaleweekend= 0;
	        if(weekendType==0){
	            priceweekend=$(element).find('input[name="price"]').val();
	            pricesaleweekend=$(element).find('input[name="pricesale"]').val();
	        }
	        if(weekendType==1){
	            priceweekend=$(element).find('input[name="priceweekend"]').val();
	            pricesaleweekend=$(element).find('input[name="pricesaleweekend"]').val();
	        }    
	        return {
	                'nameOption':name,
	                'idOption': $(element).find('input[name="idOption"]').val(),
	                'saleStartedAt': $(element).find('input[name="saleStartedAt"]').val(),
	                'saleEndedAt': $(element).find('input[name="saleEndedAt"]').val(),
	                'weekendType': weekendType,                
	                'price': $(element).find('input[name="price"]').val(),
	                'pricesale': $(element).find('input[name="pricesale"]').val(),
	                'priceweekend': priceweekend,
	                'pricesaleweekend':pricesaleweekend,
	                'amount': $(element).find('input[name="amount"]').val(),
	                'rateType': "BASIC"
	            }
	    }

	    $('#editTime').on('click', function(){
	    	if( !$.trim( $('#feedback').html() ).length ) {
	            $.fn_alert(true, true, "<?= $this->language('l_warnproduct1') ?>");
	            return false;
	        }
			$.fn_popup(true, 'editTimeTicket');
			    new JsDatePick({
			        useMode:2,
			        target: "m_useStartedAt",
			        dateFormat:"%Y-%m-%d"
			    });
			    new JsDatePick({
			        useMode:2,
			        target: "m_useEndedAt",
			        dateFormat:"%Y-%m-%d"
			    });
			    new JsDatePick({
			        useMode:2,
			        target: "m_saleStartedAt",
			        dateFormat:"%Y-%m-%d"
			    });
			    new JsDatePick({
			        useMode:2,
			        target: "m_saleEndedAt",
			        dateFormat:"%Y-%m-%d"
			    });
		});
	    $('#editPrice').on('click', function(){
	    	if( !$.trim( $('#feedback').html() ).length ) {
	            $.fn_alert(true, true, "<?= $this->language('l_warnproduct1') ?>");
	            return false;
	        }
			$.fn_popup(true, 'editPriceTicket');
		});
	    $('#editAmount').on('click', function(){
	    	if( !$.trim( $('#feedback').html() ).length ) {
	            $.fn_alert(true, true, "<?= $this->language('l_warnproduct1') ?>");
	            return false;
	        }
			$.fn_popup(true, 'editAmountTicket');
		});
	    $('#deleteOption').on('click', function(){
	    	var ids1=document.getElementsByName("checkbox[]");
			var dem=0;
			var co=1;
			
			var checkbox = [];
			for (var j = 0; j< ids1.length; j++) {
				if(ids1[j].checked){
					checkbox.push(ids1[j].value);
					dem++;
				}
			}
			if(dem==0){
				$.fn_alert(true, true, "<?=$this->language('l_listproduct7')?>");
				return;
			}
			for (var j = 0; j< checkbox.length; j++) {

				document.getElementById("tbTravelItem"+checkbox[j]).remove();
			}
	        
			//$.fn_popup(true, 'editAmountTicket');
		});
	    $('#btneditTime').on('click', function(){
			var useStartedAt=document.getElementById("m_useStartedAt").value;
			var useEndedAt=document.getElementById("m_useEndedAt").value;
			var saleStartedAt=document.getElementById("m_saleStartedAt").value;
			var saleEndedAt=document.getElementById("m_saleEndedAt").value;
			$('#feedback .useStartedAt').val(useStartedAt);
			$('#feedback .useEndedAt').val(useEndedAt);
			$('#feedback .saleStartedAt').val(saleStartedAt);
			$('#feedback .saleEndedAt').val(saleEndedAt);
			$($.elt_popup).hide().find('.absolute').hide();
		});
	    $('#btneditPrice').on('click', function(){
			var price=document.getElementById("m_price").value;
			var pricesale=document.getElementById("m_pricesale").value;
			$('#feedback .price').val(price);
			$('#feedback .pricesale').val(pricesale);
			$($.elt_popup).hide().find('.absolute').hide();
		});
	    $('#btneditAmount').on('click', function(){
			var amount=document.getElementById("m_amount").value;
			$('#feedback .amount').val(amount);
			$($.elt_popup).hide().find('.absolute').hide();
		});
			
});


function notlimit(source,id){
    document.getElementById("saleEndedAt"+id).disabled = source.checked;
}

function addOption1(){
    var depth = document.getElementById("numberDepth").value;
    document.getElementById("thnameoption").setAttribute("colspan", depth);
    runAjax('addOption1', {"depth":depth}, function(result1){
        var result = JSON.parse(result1);
        $('#feedback1').append(result.data);
        document.getElementById('numberDepth').disabled = true;    
        document.multiselect('#rateType'+result.optionId);
        document.multiselect('#rateType'+result.optionId).deselectAll();
        
    });    
}

function delOption1(id){
    document.multiselect('#rateType'+id).destroy();
    document.getElementById("tbOption1"+id).remove();
    if( !$.trim( $('#feedback1').html() ).length ) {
        document.getElementById('numberDepth').disabled = false;    
    }
}

function onloadJsDatePickOption(id){
    var  saleStartedAt=  "saleStartedAt"+id;
    var  saleEndedAt=  "saleEndedAt"+id;    
    new JsDatePick({
        useMode:2,
        target: saleStartedAt,
        dateFormat:"%Y-%m-%d"
    });
    new JsDatePick({
        useMode:2,
        target: saleEndedAt,
        dateFormat:"%Y-%m-%d"
    });
}
function addOption2(){
    runAjax('addOption2', {}, function(result1){
        var result = JSON.parse(result1);
        $('#feedback2').append(result.data);
        onloadJsDatePickOption(result.optionId);
    });    
}
function changeweekendType(sel,id){
    if(sel.value==0){
        document.getElementById("tdpriceweekend"+id).innerHTML = "주중가격표기";
        document.getElementById("tdpricesaleweekend"+id).innerHTML = "주중가격표기";
    }
    if(sel.value==1){
        //
        //
        document.getElementById("tdpriceweekend"+id).innerHTML = '<input name="priceweekend" type="text" value="0" onkeypress="validate(event)" class="v-numericprice" style="width: 70px;"/>';
        document.getElementById("tdpricesaleweekend"+id).innerHTML = '<input name="pricesaleweekend" type="text" value="0" onkeypress="validate(event)" class="v-numericprice" style="width: 70px;"/>';
    }
}
function delOption2(id){
    document.getElementById("tbOption2"+id).remove();
}

window.onload = function(e){ 
    onloadJsDatePickTravelItem();
}

function onloadJsDatePickTravelItem(){
    var ids=document.getElementsByName("sellerTravelItemId[]");
    for (var i = 0; i < ids.length; i++) {
        var  id= ids[i].value;
        
        var  useStartedAt=  "useStartedAt"+id;
        var  useEndedAt=  "useEndedAt"+id;
        var  saleStartedAt=  "saleStartedAt"+id;
        var  saleEndedAt=  "saleEndedAt"+id;
          new JsDatePick({
                useMode:2,
                target: useStartedAt,
                dateFormat:"%Y-%m-%d"
           });
          
          new JsDatePick({
                useMode:2,
                target: useEndedAt,
                dateFormat:"%Y-%m-%d"
           });
    
          new JsDatePick({
                useMode:2,
                target: saleStartedAt,
                dateFormat:"%Y-%m-%d"
           });
          
          new JsDatePick({
                useMode:2,
                target: saleEndedAt,
                dateFormat:"%Y-%m-%d"
           });
    }
}



function addTravelItem2(){
    var x = document.getElementById("feedback2").rows.length;
    if(x>0){
        
        var idOption = document.getElementsByName('idOption2[]');
        var saleStartedAt = document.getElementsByName('saleStartedAt[]');
        var saleEndedAt = document.getElementsByName('saleEndedAt[]');
        var pricenormal = document.getElementsByName('pricenormal[]');
        var priceweekend = document.getElementsByName('priceweekend[]');
        runAjax('addTravelItem2',{"saleStartedAt":saleStartedAt[0].value , "saleEndedAt":saleEndedAt[0].value , 
                                  "pricenormal":pricenormal[0].value , "priceweekend":priceweekend[0].value  }, 
            function(result){
            $('#feedback').append(result);    
            delOption2(idOption[0].value);
            onloadJsDatePickTravelItem();
            addTravelItem2();
        });    
    }
}

function delTravelItem(id){
    document.getElementById("tbTravelItem"+id).remove();
}
function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
  }
function handleClick(myRadio) {
    var price= parseFloat((document.getElementById("price"+myRadio.value).value).replace(",", ""));
    var pricesale= parseFloat((document.getElementById("pricesale"+myRadio.value).value).replace(",", ""));
    //document.getElementById("divpricebasic").innerHTML=formatNumber(price);
    //document.getElementById("divpricerepresentative").innerHTML=formatNumber(pricesale);
    document.getElementById("pricebasic").value=price;
    document.getElementById("pricerepresentative").value=pricesale;
}

// Chuyển hướng khi lưu thành công
setTimeout(function(){
	var urlstep = $('#locationurlstep').attr('data-urlstep');
	if(urlstep){
		$.fn_alert(true, true, "임시저장 되었습니다.");
	}  
},500);
</script>
<style>
<!--
.multiselect-wrapper .multiselect-input {
    width: 180px;
}

.multiselect-wrapper .multiselect-list.active {
    text-align: left;
}

.multiselect-wrapper ul {
    width: 170px;
}

.multiselect-input-div input {
    margin: 3px 0 6px 0;
}
-->
</style>
<div class="ct_head" id="locationurlstep" data-urlstep="<?=$this->getData('urlstep')?>" data-step="2">
	<?php require PATH_INCLUDES . 'top.php';?>
</div>
<div class="ct_content">
	<div class="forminput">
		<form name="nf" method="POST" action="<?=$this->route('editticket2')?>/<?=$sellerProductId?>" id="nf">
			<input type="hidden" name="sellerProductId" id="sellerProductId" value="<?= $sellerProductId ?>"> 
			<input name="btnSumit" id="btnSumit" type="hidden" value="editticket2" />
			<input name="pricebasic" id="pricebasic" type="hidden" value="<?=$pricebasic?>" />
			<input name="pricerepresentative" id="pricerepresentative" type="hidden" value="<?=$pricerepresentative?>" />
			
			<div class="form_group clearfix frrow">
				 <div class="row rmclass" data-action="viewperson" data-perid="14">
    				<div class="form_group clearfix">
                        <div class="form_item col-xs-2">
                            <h3>*<?= $this->language('l_typesale') ?></h3>
                        </div>
                         <div class="form_item col-xs-2" style="margin-top: 8px;text-align: left;">
                            <input name="inventoryType" type="radio" id="inventoryType2" 
                            		class="inventoryType" <?php if ($inventoryType == 'PERIOD') echo 'checked="checked"'; ?> value="PERIOD" /> 
                            <label for="inventoryType2"><?= $this->language('l_typesale1') ?></label>
                        </div>
                        
                        <div class="form_item col-xs-2" style="margin-top: 8px;text-align: left;">
                            <input name="inventoryType" type="radio" id="inventoryType1" 
                            		class="inventoryType" <?php if ($inventoryType == 'DAILY') echo 'checked="checked"'; ?> value="DAILY" /> 
                            <label for="inventoryType1"><?= $this->language('l_typesale2') ?></label>
                        </div>
                        
                       
                        <div class="form_item col-xs-4 align-left"></div>
                    </div>
                </div>
			</div>
			
			<div class="form_group clearfix frrow">
				 <h3><?= $this->language('l_addticket3') ?></h3>

                <div class="form_tab" style="margin: 5px 0px 20px 0px;">
                    <div class="tab_head">
                        <ul class="clearfix">
                            <li>
                            	<a id="tab1" data-tab="tab1" class="<?php if ($inventoryType == "DAILY") echo "active";?>" 
                            			style="<?php if ($inventoryType == "PERIOD") echo "display: none;"; ?>" title=""><?= $this->language('l_addticket4') ?></a>
                            </li>
                            <li>
                            	<a id="tab2" data-tab="tab2" class="<?php if ($inventoryType == "PERIOD") echo "active"; ?>"  
                            			style="<?php if ($inventoryType == "DAILY") echo "display: none;"; ?>" title=""><?= $this->language('l_addticket5') ?></a>
                            </li>
                            <li><a id="tab3" data-tab="tab3" title=""><?= $this->language('l_Channel36') ?></a></li>
                        </ul>
                        <script type="text/javascript">
                $(document).ready(function(){                    
            
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
                    
                    
                    
                    <div class="tab_content">
                        <div id="tab1a" style="<?php if ($inventoryType == "DAILY") echo "display: none;"; else echo "display: block;"; ?>">
                            <p><?= $this->language('l_addticket6') ?></p>
                            <p><?= $this->language('l_addticket7') ?></p>
                            <p><?= $this->language('l_addticket8') ?></p>
                            
                            <div class="form_group clearfix" style="padding-top: 10px;">
                                <div class="form_item col-xs-1">
                                    <h3>옵션단수</h3>
                                </div>
                                <div class="form_item col-xs-1">
                                    <select class="select small full" name="numberDepth" id="numberDepth">
                                        <option value="1">1 단</option>
                                        <option value="2">2 단</option>
                                    </select>
                                </div>
                            </div>
                            
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="1" id="thnameoption"><?= $this->language('l_nameoption') ?> (”,”로 구분해서 여러개 입력) </th>
                                        <th style="width: 125px;"><?= $this->language('l_addticket19') ?></th>
                                        <th style="width: 125px;"><?= $this->language('l_addticket20') ?></th>
                                        <th style="width: 220px;"><?= $this->language('l_addticket10') ?></th>
                                        <th style="width: 80px;text-align: center;">
                                            <div class="btnupload">                                        
                                                <button type="button" class="btn hover small " onclick="addOption1();"><?= $this->language('l_add') ?></button>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="feedback1">
                                </tbody>

                            </table>
                            <div class="divBtn align-center" style="padding: 15px;">                                
                                <button type="button" class="btn hover" id="addTravelItem1"><?= $this->language('l_addticket11') ?></button>
                            </div>
                        </div>
                        <div id="tab2a" style="<?php if ($inventoryType == "PERIOD") echo "display: none;"; else echo "display: block;"; ?>">

                            <p>옵션값을 작성한 후 [옵션목록에 추가] 를 클릭하면 자동으로 옵션이 조합되어 옵션목록에 등록됩니다.</p>
                            <p> 사용일자 기간내 주중/주말 가격은 입력된 가격으로 자동 등록됩니다. </p>
                            <br>                    
                           <p>예시1) 워터파크 이용권 x 4/22~4/23(총2일)  = 총 2개의 조합</p>
                           <p> 예시2) 4/22~4/30, 주중/주말가격 동일 = 일자별 가격 동일 가격으로 등록</p>
                            <br>                    
                                                
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?= $this->language('l_nameoption') ?> <br> (”,”로 구분해서 여러개 입력) </th>
                                        <th style="width: 180px">사용일자 <br>(다중선택시 기간으로 설정)</th>
                                        <th style="width: 80px;">주중/주말</th>
                                        <th style="width: 80px;">주중 정상가</th>
                                        <th style="width: 80px;">주중 판매가</th>
                                        <th style="width: 80px;">주말 정상가</th>
                                        <th style="width: 80px;">주말 판매가</th>
                                        <th style="width: 50px;">수량</th>
                                        <th style="width: 80px;">
                                            <div class="btnupload">                                        
                                                <button type="button" class="btn hover small "  onclick="addOption2();"><?= $this->language('l_add') ?></button>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="feedback2">


                                </tbody>
                            </table>                            
                            <div class="divBtn align-center" style="padding: 15px;">                                
                                <button type="button" class="btn hover" id="addTravelItem2"><?= $this->language('l_addticket11') ?></button>
                            </div>
                        </div>

                        <div id="tab3a">
                            <div class="form-upload-ticket">
                                <ul class="clearfix">
                                    <li><a href="<?= URL_TEMPLATE ?>add-ticket.xlsx" class="btn hover dowloadfile">엑셀 업로드</a></li>
                                    <li>
                                        <label for="change_files_excel" class="btn hover full" style="text-align:center;">사업자 등록증 업로드</label>
                                        <input type="file" id="change_files_excel" name="fileupload" value="" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                    </li>
                                    <li><p class="height1">엑셀양식에 맞추어 옵션을 입력한 후 엑셀로 업로드 할 수 있습니다</p></li>
                                </ul>
                                <div class="btnupload">                                        
                                    <button type="button" class="btn hover uploadfile"><?= $this->language('l_addticket11') ?></button>
                                </div>
                            </div>
                            <script type="text/javascript">
                                var str = '엑셀양식에 맞추어 옵션을 입력한 후 엑셀로 업로드 할 수 있습니다';
                                $('body').on('change','.form-upload-ticket input[type="file"]',function(){                                    
                                    if(this.files[0]){                                        
                                        $(this).closest('.form-upload-ticket').find('p').text(this.files[0].name);
                                    }else{
                                        $(this).closest('.form-upload-ticket').find('p').text(str);
                                    }
                                });
                                $('body').on('click','.form-upload-ticket .uploadfile',function(){
                                    var element = $(this).closest('.form-upload-ticket');
                                    if($(element).find('input[type="file"]').val()){
                                        var formdata = new FormData(); 
                                        var fileupload = $(element).find('input[type="file"]')[0].files[0];
                                        formdata.append("fileupload", fileupload);
                                        $.fn_ajax_upload_file('uploadFileExcel', formdata, function(result){
                                            if(result.flag == true){
                                                $(element).find('p').text(str);
                                                $(element).find('input[type="file"]').val('');
                                                $('#feedback').append(result.datafile);
                                                onloadJsDatePickTravelItem();
                                            }
                                        }, true);
                                    }else{
                                        $.fn_alert(true, true, '<?= $this->language('l_Channel1') ?>');
                                    }                                    
                                });
                            </script>
                        </div>

                    </div>
                </div>


                <h3><?= $this->language('l_listoption') ?></h3>
                <p><?= $this->language('l_addticket16') ?></p>
                <p><?= $this->language('l_addticket17') ?></p>
                <div class="table_head bgwhite">
    				<div class="ctrl_head clearfix">
    						<button type="button" name="editTime" id="editTime" class="btn hover">판매기간 일괄수정</button>
    						<button type="button" name="editPrice" id="editPrice" class="btn hover">가격 일괄수정</button>
    						<button type="button" name="editAmount" id="editAmount" class="btn hover">수량 일괄수정</button>
    						<button type="button" name="deleteOption" id="deleteOption" class="btn hover"><?= $this->language('l_delete') ?></button>
    				</div>
				</div>
                <div class="table_content">
                    <table class="table">
                        <thead>

                            <tr>
                                <th style="min-width: 50px"><?= $this->language('l_no') ?></th>
                                <th style="min-width: 80px"><?= $this->language('l_addticket18') ?></th>
                                <th><?= $this->language('l_travelItemId') ?></th>
                                <th><?= $this->language('l_nameoption') ?></th>
                                <th><?= $this->language('l_addticket10') ?></th>
                                <th><?= $this->language('l_addticket19') ?></th>
                                <th><?= $this->language('l_addticket20') ?></th>
                                <th><?= $this->language('l_addticket21') ?></th>
                                <th><?= $this->language('l_listproduct3') ?></th>
                                <th><?= $this->language('l_listproduct4') ?></th>
                                <th><?= $this->language('l_addticket22') ?></th>
                                <th><?= $this->language('l_addticket23') ?></th>
                                <th style="min-width: 100px"><?= $this->language('l_addticket24') ?></th>
                                <!-- <th></th> -->

                            </tr>
                        </thead>
                        <tbody id="feedback">
                        <?php
        
                        foreach ($list_travelitems as $value => $giatri) {
                            $list_useperiod = $list_periodrates[$giatri[0]][0];
                            $list_rates     = $list_periodrates[$giatri[0]][1];
                        ?>
                           <tr id="tbTravelItem<?= $giatri[0] ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?= $giatri[0] ?>"/>
                                </td>
                                <td>
                                    <input type="radio" name="representative" value="<?= $giatri[0] ?>" onclick="handleClick(this)" <?php if ($giatri[6] == 1) echo 'checked="checked"'; ?> />
                                </td>
                                <td>
                                    <?= $giatri[0] ?>
                                    <input type="hidden" name="sellerTravelItemId[]" value="<?= $giatri[0] ?>" />
                                    <input type="hidden" name="taxType<?= $giatri[0] ?>" value="FREE" />
                                </td>
                                <td>
                                    <textarea name="name<?= $giatri[0] ?>" rows="3" style="resize: none"><?= $giatri[1] ?></textarea>
                                    <input type="hidden" name="priceType<?= $giatri[0] ?>" value="OWN_COMPANY_PRICE" />
                                </td>
                                <td>
                                    <select name="rateType<?= $giatri[0] ?>" style="min-width: 75px;width: 75px;padding: 3px 0px 5px 0px;" class="select">
                                        <option <?php if ($list_rates[0][1] == "BASIC")  echo 'selected="selected"';?> value="BASIC">해당없음</option>
                                        <option <?php if ($list_rates[0][1] == "ADULT_DAEIN_AND_CHILD_SOIN") echo 'selected="selected"';?> value="ADULT_DAEIN_AND_CHILD_SOIN">대인/소인동일</option>
                                        <option <?php if ($list_rates[0][1] == "ADULT") echo 'selected="selected"';?> value="ADULT">성인</option>
                                        <option <?php if ($list_rates[0][1] == "ADULT_DAEIN") echo 'selected="selected"';?> value="ADULT_DAEIN">대인</option>
                                        <option <?php if ($list_rates[0][1] == "UNIVERSITY_STUDENT") echo 'selected="selected"'; ?> value="UNIVERSITY_STUDENT">대학생</option>
                                        <option <?php if ($list_rates[0][1] == "HIGH_SCHOOL_STUDENT") echo 'selected="selected"'; ?> value="HIGH_SCHOOL_STUDENT">고등학생</option>
                                        <option <?php if ($list_rates[0][1] == "MIDDLE_SCHOOL_STUDENT") echo 'selected="selected"'; ?> value="MIDDLE_SCHOOL_STUDENT">중학생</option>
                                        <option <?php if ($list_rates[0][1] == "SCHOOL_CHILD") echo 'selected="selected"'; ?> value="SCHOOL_CHILD">초등학생</option>
                                        <option <?php if ($list_rates[0][1] == "HIGH_AND_MIDDLE_SCHOOL_STUDENT")  echo 'selected="selected"'; ?> value="HIGH_AND_MIDDLE_SCHOOL_STUDENT">중고생</option>
                                        <option <?php if ($list_rates[0][1] == "ELEMENTARY_MIDDLE_AND_HIGH_SCHOOL_STUDENT") echo 'selected="selected"'; ?> value="ELEMENTARY_MIDDLE_AND_HIGH_SCHOOL_STUDENT">초중고생</option>
                                        <option <?php if ($list_rates[0][1] == "TEENS") echo 'selected="selected"'; ?> value="TEENS">청소년</option>
                                        <option <?php if ($list_rates[0][1] == "STUDENT") echo 'selected="selected"'; ?> value="STUDENT">학생</option>
                                        <option <?php if ($list_rates[0][1] == "PRESCHOOL_CHILD") echo 'selected="selected"'; ?> value="PRESCHOOL_CHILD">미취학아동</option>
                                        <option <?php if ($list_rates[0][1] == "CHILD") echo 'selected="selected"'; ?> value="CHILD">아동</option>
                                        <option <?php if ($list_rates[0][1] == "CHILD_SOIN") echo 'selected="selected"'; ?> value="CHILD_SOIN">소인</option>
                                        <option <?php if ($list_rates[0][1] == "TODDLER") echo 'selected="selected"'; ?> value="TODDLER">유아</option>
                                        <option <?php if ($list_rates[0][1] == "INFANT") echo 'selected="selected"'; ?> value="INFANT">영아</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="price<?= $giatri[0] ?>" id="price<?= $giatri[0] ?>" value="<?= number_format($list_rates[0][3]) ?>" onkeypress='validate(event)' class="price v-numericprice" style="width: 60px;" />
                                </td>
                                <td>
                                    <input type="text" name="pricesale<?= $giatri[0] ?>" id="pricesale<?= $giatri[0] ?>" value="<?= number_format($list_rates[0][4]) ?>" onkeypress='validate(event)' class="pricesale v-numericprice" style="width: 60px;" />
                                </td>
                                <td>
                                    <input type="text" name="amount<?= $giatri[0] ?>" value="<?= $list_rates[0][5] ?>" onkeypress='validate(event)' class="amount v-numericprice" style="width: 40px;" />
                                </td>
                                <td>
                                    <input type="text" name="useStartedAt<?= $giatri[0] ?>" id="useStartedAt<?= $giatri[0] ?>" value="<?= $list_useperiod[0][2] ?>" class="useStartedAt" readonly="readonly" style="width: 80px;" />
                                </td>
                                <td>
                                    <input type="text" name="useEndedAt<?= $giatri[0] ?>" id="useEndedAt<?= $giatri[0] ?>" value="<?= $list_useperiod[0][3] ?>" class="useEndedAt" readonly="readonly" style="width: 80px;" />
                                </td>
                                <td>
                                    <input type="text" name="saleStartedAt<?= $giatri[0] ?>" id="saleStartedAt<?= $giatri[0] ?>" value="<?= $list_rates[0][7] ?>" class="saleStartedAt" readonly="readonly" style="width: 80px;" />
                                </td>
                                <td>
                                    <input type="text" name="saleEndedAt<?= $giatri[0] ?>" id="saleEndedAt<?= $giatri[0] ?>" value="<?= $list_rates[0][8] ?>"  class="saleEndedAt" readonly="readonly" style="width: 80px;" />
                                </td>
                                <td> <?= $this->language('l_addticket25') ?> </td>
                                <!-- <td><a onclick="delTravelItem('<?= $giatri[0] ?>');" class="btn hover small"> X </a></td> -->
                            </tr>
                        <?php
                        }
                        ?>
                   		</tbody>
                    </table>
                </div>
				<div class="table_content">
					<table class="table" style="float: right;">
						<tr>
							<td colspan="8">
								<input type="hidden" name="step" id="step" value="1">
								<div class="btnupload">										
                            			<button type="button" style="width: 100px; float: right;" class="btn hover "  id="continuelink" data-step="3" ><?=$this->language( 'l_continue')?></button>
                            			<button type="button" style="width: 100px; float: right;margin-right: 5px" class="btn hover "  id="saveTemp" data-step="2"><?=$this->language( 'l_savedraft')?></button>
                            			<button type="button" style="width: 100px; float: right;margin-right: 5px" class="btn hover "  id="backlink" data-step="1"><?=$this->language( 'l_back')?></button>
                            	</div>
                            </td>
						</tr>
					</table>
				</div>
			</div>
		</form>
	</div>

</div>