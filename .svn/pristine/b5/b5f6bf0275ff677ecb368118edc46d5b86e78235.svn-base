<div class="title_history">
    <div class="row">
        <div class="col-md-4 pt-2">            
            <p><?=$this->language("l_history_inning")?></p>
        </div>
        <div class="col-md-4 pt-2">
            <p><?=$this->language("l_history_score")?></p>
        </div>
        <div class="col-md-4 pt-2">
            <p><?=$this->language("l_history_shot")?></p>
        </div>
    </div>
</div>
<div class="main_history containerHistory<?=$thanhvien2['id']?>">

    <?php if($currentUser || (!$currentUser && $thanhvien2['id'] != $trandau['khaicuoc_user']) || !count($historyPointUser1)): ?>
    <div class="row b-line-d m-0 pb-14 rows_history rowshow<?=$thanhvien2['id']?>">        
        <div class="col-md-4 pt-2"><p class="mb-1"><?=$innering?></p></div>
        <div class="col-md-4 pt-2"><p class="mb-1 rowshowPoint<?=$thanhvien2['id']?>">0</p></div>
        <div class="col-md-4 pt-2"><p class="mb-1 rowshowTime<?=$thanhvien2['id']?>">0</p></div>        
    </div>
    <?php endif; ?>
    <?php
    $stt = 1; 
    if($historyPointUser2)
    foreach ($historyPointUser2 as $key => $val) {
    ?>
        <div class="row b-line-d t-line-d m-0 pb-14 rows_history <?php if(!$val['status']):?> rows_history_cancel ?> <?php endif; ?> <?php if($stt==1):?>rowUser<?=$thanhvien2['id']?> <?php endif; ?>">
            <div class="col-md-4 pt-2"><p class="mb-1"><?=$val['luot']?></p></div>
            <div class="col-md-4 pt-2"><p class="mb-1"><?=$val['diem']?></p></div>
            <div class="col-md-4 pt-2"><p class="mb-1"><?=$val['time']?></p></div>
        </div>    
    <?php $stt++;  } ?>
</div>

<script type="text/javascript">
    $('.listHistory').on('click', function(){
        var userId = $(this).attr('data-id');
        var trandauId = $('#trandau_id').val();
        var url = $baseUrl + '/gethistoryUser.html'; 
       
        $('.div_load_alert').css("display","block");
        $('#detail').html('');
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                trandau:trandauId,
                user:userId               
            },
            dataType:'text',
            success:function(data){             
                jsonData =  $.parseJSON(data);console.log(jsonData);
                if(jsonData.status == false){                    
                    return false;
                } else {
                    var listdetail = jsonData.chitiet;
                    $.each(listdetail,function(i,item){
                        var classRow = 'rows_history_popup';
                        if(item.status ==0){
                            classRow = 'rows_history_popup rows_history_cancel';
                        }
                        items = '<div class="'  + classRow + '">';
                            items += '<div class="col-xs-4">' + item.luot + '</div>';                            
                            items += '<div class="col-xs-4">' + item.diem + '</div>'; 
                            items += '<div class="col-xs-4">' + item.time + '</div>'; 
                        items +='</div>';   
                        $('#detail').append(items);
                    })
                    $('.div_load_alert').css("display","none");                    
                    $("#chitietp1Modal").modal();
                }
            }
        });
        
    })
</script>