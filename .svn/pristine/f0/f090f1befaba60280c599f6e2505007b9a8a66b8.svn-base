<style type="text/css">
    .detail {
        color: #ebebeb;        
        margin-left: 15px;        
        margin-right: 15px;
    }
    .rows_title_popup{
        margin-top: 15px;
        height: 38px;
        background: #233f76;
        padding: 7px !important;
        text-align: left;
        font-size: 18px;
    }
    .rows_history_popup{
        padding: 7px !important;
        border-bottom: 1px solid #233f76;
        height: 8%;
    }
    .hide-scroll {
        height: 60%;
        position: relative;
    } 
    .viewport{
        height: 400px !important;
    }   
    .rows_history_cancel{color: red;} 
    .title_history_mobi p{margin-bottom: 0px; margin-top: 0px;}
</style>
<div class="title_history_mobi">
    <div class="row">
        <div class="col-4 text-center">            
            <p><?=$this->language("l_history_inning")?></p>
        </div>
        <div class="col-4 text-center">
            <p><?=$this->language("l_history_score")?></p>
        </div>
        <div class="col-4 text-center">
            <p><?=$this->language("l_history_shot")?></p>
        </div>
    </div>
</div>
<div class="main_history_mobi containerHistory<?=$thanhvien1['id']?>">

    <?php if($currentUser || (!$currentUser && $thanhvien1['id'] != $trandau['khaicuoc_user']) || !count($historyPointUser1)): ?>    
    <div class="row b-line-d m-0 pb-14 rows_history rowshow<?=$thanhvien1['id']?>">        
        <div class="col-4 pt-2"><p class="mb-1"><?=$innering?></p></div>
        <div class="col-4 pt-2"><p class="mb-1 rowshowPoint<?=$thanhvien1['id']?>">0</p></div>
        <div class="col-4 pt-2"><p class="mb-1 rowshowTime<?=$thanhvien1['id']?>">0</p></div>        
    </div>
    <?php endif; ?>
    
    <?php 
    $stt = 1;
    if($historyPointUser1)
    foreach ($historyPointUser1 as $key => $val) {
    ?>
        <div class="row b-line-d t-line-d m-0 pb-14 rows_history  <?php if(!$val['status']):?> rows_history_cancel ?> <?php endif; ?>  <?php if($stt==1):?>rowUser<?=$thanhvien1['id']?> <?php endif; ?>">
            <div class="col-4 pt-2"><p class="mb-1"><?=$val['luot']?></p></div>
            <div class="col-4 pt-2"><p class="mb-1"><?=$val['diem']?></p></div>
            <div class="col-4 pt-2"><p class="mb-1"><?=$val['time']?></p></div>
        </div>    
    <?php $stt++;  } 
    ?>
</div>
<!-- Modal luot co -->
<div class="modal fade" id="chitietp1Modal" tabindex="-1" role="dialog" aria-labelledby="chitietp1Modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="padding: 20px;margin-top: 100px;">
            <h3 style="margin: 0px;padding-bottom: 20px;border-bottom: 1px solid #ebebeb;">
                <?=$this->language("l_history_title")?> 
                <span style="text-align: right;border: 1px solid #ccc;border-radius: 50%;float: right;padding: 3px 7px;font-size: 20px;" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>
            </h3>
            <div class="detail">                
                <div class="hide-scroll">
                    <div class="row rows_title_popup">
                        <div class="col-xs-4"><?=$this->language("l_history_inning")?></div>
                        <div class="col-xs-4"><?=$this->language("l_history_score")?></div>
                        <div class="col-xs-4"><?=$this->language("l_history_shot")?></div>
                    </div>
                    <div class="viewport" id="detail">
                                               
                    </div>
                </div>                    
            </div>
            <div class="cl"></div>
        </div>
    </div>
</div>
<!-- end modal luot co -->
