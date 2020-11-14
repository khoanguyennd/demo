<!-- Modal home_register -->
<div class="modal fade" id="winModal" tabindex="-1" data-backdrop="static" style="padding-top: 150px" role="dialog" width="100%" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">                                        
                <h1 class="h1register"><?=$this->language("l_title_thongbaodudiem")?></h1>
            </div>
            <div class="modal-body" style="color:#ffffff">
               <?=$this->language("l_content_thongbaodudiem")?>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="button_closehelp" data-dismiss="modal"><?=$this->language("l_no")?></button>
                <button type="button" id="btnWin" class="button_closehelp"><?=$this->language("l_yes")?></button>
            </div>
        </div>
    </div>
</div>
