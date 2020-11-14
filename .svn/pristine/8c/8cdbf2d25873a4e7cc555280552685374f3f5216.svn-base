<style type="text/css">
#chitietthanhvien{text-align: left;}
#chitietthanhvien2{text-align: left;}
.chitietthanhvien_icon i {background: #9599b8;padding: 13px 13px;border-radius: 50%;font-size: 22px; border: 1px solid #fff;float: left;margin-right: 10px;}
.chitietthanhvien_icon p{text-transform: uppercase; font-size: 22px;}
.chitietthanhvien p{margin-bottom: 0px;}
.chitietthanhvien span{font-size: 15px;}
.rows_tk{ margin: 0 auto;background: #011b43;width: 33%;margin-right: 1px;margin-left: 1px; margin-bottom: 1px;text-align: center; padding: 5px 5px; color: #fff;}
.rows_tk p{font-size: 14px}
.rows_tk_title{font-weight: bold; padding-bottom: 2px;height: 20px;overflow: hidden;}
.rows_tk_content{color: #f7941d; font-weight:bold;}
.colordefault{color: #f7941d; font-weight: bold}
</style>
<?php
    $totalTrandau1 = $thanhvien1['total_thang'] + $thanhvien1['total_thua'];
    if(!$totalTrandau1) $totalTrandau1 =1;
?>
<div class="modal fade" id="chitietthanhvien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 80%; margin-top: 10%">
        <div class="modal-content bgt-blue">
            <div class="modal-body p-0 b-line">
                <div class="title text-center b-line"><h3><?=$this->language("l_detail_member")?> </h3></div>
                <div class="list-luot-co t-line pt-2 pb-1 pr-3 pl-3">                    
                    <div class="row">
                        <div class="col">
                            <div class="chitietthanhvien_icon">
                                <i class="fa fa-user" aria-hidden="true"></i>                            
                                <p><?=$thanhvien1['name']?></p>
                            </div>                    
                        </div>
                        <div class="col" style="text-align: right;">
                            <p><span><?=$this->language("l_point")?>: </span><span class="colordefault"><?=$thanhvien1['diem']?></span></p>
                            <p><span><?=$this->language("l_detail_highrun")?>: </span><span class="colordefault"><?=$thanhvien1['highrun']?></span></p>
                        </div>    
                    </div>                                   
                    <div class="row" style="padding-bottom: 15px; padding-top: 15px;">
                        <div class="col-xs-4 rows_tk">
                            <p class="rows_tk_title"><?=$this->language("l_detail_trungbinh")?></p>
                            <p class="rows_tk_content"><?=$thanhvien1['avg']?></p>
                        </div>
                        <div class="col-xs-4 rows_tk">
                            <p class="rows_tk_title"><?=$this->language("l_detail_high")?></p>
                            <p class="rows_tk_content"><?=$thanhvien1['highrun']?></p>
                        </div>
                        <div class="col-xs-4 rows_tk">
                            <p class="rows_tk_title"><?=$this->language('l_detail_all')?></p>
                            <p class="rows_tk_content"><?=$thanhvien1['total_thang']?> <?=$this->language('l_detail_win')?> <?=$thanhvien1['total_thua']?> <?=$this->language('l_detail_faile')?></p>
                        </div>                
                        <div class="col-xs-4 rows_tk">
                            <p class="rows_tk_title"><?=$this->language("l_detail_doidau")?></p>
                            <p class="rows_tk_content"><?=$this->getData('total_doidau');?></p>
                        </div>
                        <div class="col-xs-4 rows_tk">
                            <p class="rows_tk_title"><?=$this->language("l_tylethang")?></p>
                            <p class="rows_tk_content">
                                <?=round($thanhvien1['total_thang']/$totalTrandau1,2)?>%
                            </p>
                        </div>
                        <div class="col-xs-4 rows_tk">
                            <p class="rows_tk_title"><?=$this->language("l_tylecham")?></p>
                            <p class="rows_tk_content"><?=$this->getData('tylechambi_thanhvien1')?>%</p>
                        </div>
                        <div class="col-xs-4 rows_tk">
                            <p class="rows_tk_title"><?=$this->language("l_trungbinhmot")?></p>
                            <p class="rows_tk_content"><?=$thanhvien1['avg_time']?>s</p>
                        </div>
                        <div class="col-xs-4 rows_tk">
                            <p class="rows_tk_title"><?=$this->language("l_tylethangdepa")?></p>
                            <p class="rows_tk_content">50%</p>
                        </div>
                        <div class="col-xs-4 rows_tk">
                            <p class="rows_tk_title"><?=$this->language("l_tylethangkhaicuoc")?></p>
                            <p class="rows_tk_content"><?=round($thanhvien1['win_start']/$totalTrandau1,2)?>%</p>
                        </div>
                    </div>                
                </div>     
            </div> 
          <div class="modal-footer t-line"></div>         
        </div>
    </div>
</div>