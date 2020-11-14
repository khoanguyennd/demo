<?php
    $totalTrandau2 = ($thanhvien2['total_thang'] + $thanhvien1['total_thua']) > 0 ? ($thanhvien2['total_thang'] + $thanhvien2['total_thua']) : 1;    
?>
<div class="modal fade" id="chitietthanhvien2" tabindex="-1" role="dialog" aria-labelledby="chitietthanhvien2" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 40%; height: 200px; top: 10%">
        <div class="modal-content bgt-blue" style="padding: 20px;;margin-top: 100px;">
            <h3 style="margin: 0px;padding-bottom: 20px;border-bottom: 1px solid #ebebeb;">
                <?=$this->language("l_detail_member")?> 
                <span style="text-align: right;border: 1px solid #ccc;border-radius: 50%;float: right;padding: 3px 7px;font-size: 20px;" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>
            </h3>
            <div class="chitietthanhvien">
                <div class="row paddingleftright">
                    <div class="col">
                        <div class="chitietthanhvien_icon">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <!-- <p style="padding-top: 5px;"><?=$this->language("l_detail_title1")?></p> -->
                            <p><?=$thanhvien2['name']?></p>
                        </div>                    
                    </div>
                    <div class="col" style="text-align: right;">
                        <p style="padding-top: 5px;"><span><?=$this->language("l_point")?>: </span><span class="colordefault"><?=$thanhvien2['diem']?></span></p>
                        <p><span><?=$this->language("l_detail_highrun")?>: </span><span class="colordefault"><?=$thanhvien2['highrun']?></span></p>
                    </div>
                </div>                                
                <div class="row paddingleftright" style="padding-bottom: 15px; padding-top: 15px;">
                    <div class="col-xs-4 paddingleftright rows_tk">
                        <p class="rows_tk_title"><?=$this->language("l_detail_trungbinh")?></p>
                        <p class="rows_tk_content"><?=$thanhvien2['avg']?></p>
                    </div>
                    <div class="col-xs-4 paddingleftright rows_tk">
                        <p class="rows_tk_title"><?=$this->language("l_detail_high")?></p>
                        <p class="rows_tk_content"><?=$thanhvien2['highrun']?></p>
                    </div>
                    <div class="col-xs-4 paddingleftright rows_tk">
                        <p class="rows_tk_title"><?=$this->language('l_detail_all')?></p>
                        <p class="rows_tk_content"><?=$thanhvien2['total_thang']?> <?=$this->language('l_detail_win')?> <?=$thanhvien2['total_thua']?> <?=$this->language('l_detail_faile')?></p>
                    </div>
                    <div class="col-xs-4 paddingleftright rows_tk">
                        <p class="rows_tk_title"><?=$this->language("l_detail_doidau")?></p>
                        <p class="rows_tk_content"><?=$this->getData('total_doidau');?></p>
                    </div>
                    <div class="col-xs-4 paddingleftright rows_tk">
                        <p class="rows_tk_title"><?=$this->language("l_tylethang")?></p>
                        <p class="rows_tk_content"><?=round($thanhvien2['total_thang']/$totalTrandau2,2)?>%</p>
                    </div>
                    <div class="col-xs-4 paddingleftright rows_tk">
                        <p class="rows_tk_title"><?=$this->language("l_tylecham")?></p>
                        <p class="rows_tk_content"><?=$this->getData('tylechambi_thanhvien2')?>%</p>
                    </div>
                    <div class="col-xs-4 paddingleftright rows_tk">
                        <p class="rows_tk_title"><?=$this->language("l_trungbinhmot")?></p>
                        <p class="rows_tk_content"><?=$thanhvien2['avg_time']?>s</p>
                    </div>
                    <div class="col-xs-4 paddingleftright rows_tk">
                        <p class="rows_tk_title"><?=$this->language("l_tylethangdepa")?></p>
                        <p class="rows_tk_content">50%</p>
                    </div>
                    <div class="col-xs-4 paddingleftright rows_tk">
                        <p class="rows_tk_title"><?=$this->language("l_tylethangkhaicuoc")?></p>
                        <p class="rows_tk_content"><?=round($thanhvien2['win_start']/$totalTrandau2,2)?>%</p>
                    </div><div class="cl"></div>
                </div>
                <div class="cl"></div>
            </div>
            <div class="cl"></div>
        </div>
    </div>
</div>