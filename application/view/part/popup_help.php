<!-- Modal help -->
<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="h1help"><?=$this->language("l_help")?></h1>
            </div>
            <div class="modal-body">
                <div class="help1">
                    <p class="helpnumber">1</p>
                    <p class="helptext"><?=$this->language("l_modal_help_row1")?></p>
                </div>
                <div class="help2">
                    <p class="helpnumber">2</p>
                    <p class="helptext"><?=$this->language("l_modal_help_row2")?></p>
                </div>
                <div class="help3">
                    <p class="helpnumber">3</p>
                    <p class="helptext"><?=$this->language("l_modal_help_row3")?></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="button_closehelp" data-dismiss="modal"><?=$this->language("l_close")?></button>
            </div>
        </div>
    </div>
</div>
<!-- end modal help -->