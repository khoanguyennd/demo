<!-- -----------------------------tro giup----------------------------------------------------->
<div class="modal fade" id="trogiupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top: 10%">
        <div class="modal-content bgt-blue">
            <div class="modal-body p-0 b-line">
                <div class="title text-center pb-3 b-line"><h3><?=$this->language("l_help")?></h3></div>
                <div class="list-luot-co t-line pt-4 pb-4">
                    <div class="row">
                        <div class="w-85 m-auto m-0 pl-5 pr-5 <?php if($_SESSION['lang']=="KR"){echo "divlangkr";}?>">
                            <p>1. <?=$this->language("l_modal_help_row1")?></p>
                            <p>2. <?=$this->language("l_modal_help_row2")?></p>
                            <p>3. <?=$this->language("l_modal_help_row3")?></p>
                        </div>
                    </div>
                </div>	
            </div>
            <div class="modal-footer t-line pb-4 pt-4">
                <div class="m-0 m-auto">
                    <button type="button" class="btn btn-primary btn-blue" data-dismiss="modal"><?=$this->language("l_close")?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<!----------------------------------end tro giup-------------------------------------->
<!-- -----------------------------dang ky thanh vien----------------------------------------------------->
<div class="modal fade" id="dangkytvModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top: 10%">
        <div class="modal-content bgt-blue">
            <form class="cmxform" id="registerForm" method="get" action="">
                <div class="modal-body p-0 b-line">
                    <div class="title text-center pb-3 b-line"><h3><?= $this->language("l_registermember") ?></h3></div>
                    <div class="list-luot-co t-line pt-4 pb-4">
                        <div class="row">
                            <div class="w-85 m-auto m-0 pl-5 pr-5">
                                <div class="form-row">
                                    <div id="msg_err_home" class="error_insert"></div>
                                    <div class="form-group col-md-12">
                                        <label for="recipient-name" class="col-form-label"><?=$this->language("l_hoten")?> <span class="required"></span></label>
                                        <input type="text" class="form-control from-c use-keyboard-input-register" id="userName" name="name" autocomplete="off" placeholder="<?=$this->language("l_hoten_placeholder")?>">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="col-form-label" for="#"><?=$this->language("l_phone") ?> <span class="required"></span></label>
                                        <input type="text" class="form-control from-c use-keyboard-number" id="phone" name="phone" autocomplete="off" onkeyup="this.value=this.value.replace(/[^\d]/,'')" placeholder="<?=$this->language("l_phone_placeholder")?>">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="recipient-name" class="col-form-label"><?=$this->language("l_point")?></label>
                                        <input type="text" class="form-control from-c use-keyboard-input-diemchap" id="point" name="point" autocomplete="off" maxlength="3" onkeyup="this.value=this.value.replace(/[^\d]/,'')" placeholder="<?=$this->language("l_point_placeholder")?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>	
                </div>
            </form>
            <div class="modal-footer t-line pb-4 pt-4">
                <div class="m-0 m-auto">
                    <button type="button" id="btnRegister_close" class="btn btn-primary btn-blue"><?=$this->language("l_close")?></button>
                    <button type="button" id="btnRegister" class="btn btn-primary btn-blue"><?=$this->language("l_register")?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<!----------------------------------end dang ky thanh vien-------------------------------------->
<!----------------------------------dang ky thanh cong-------------------------------------->
<div class="modal fade" id="thongbaoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top: 10%">
    <div class="modal-content bgt-blue">
        <div class="modal-body p-0 b-line">
        <div class="title text-center pb-3 b-line"><h3><?= $this->language("l_title_thongbaodudiem") ?></h3></div>
        <div class="list-luot-co t-line pt-4 pb-4">
            <div class="row">
                <div class="w-85 m-auto m-0 pl-5 pr-5 " style="text-align: center;">
                    <p id="successContent"></p>
                </div>
            </div>
        </div>	
        </div>
        <div class="modal-footer t-line pb-4 pt-4">
        <div class="m-0 m-auto">
            <button type="button" class="btn btn-primary btn-blue" data-dismiss="modal"><?= $this->language("l_close") ?></button>
        </div>
        </div>
    </div>
    </div>
</div>
<!----------------------------------dang ky thanh cong-------------------------------------->
<!-- Modal mess -->

<div class="modal fade" id="messModal" tabindex="-1" role="dialog" aria-labelledby="messModal" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-top: 10%">
    <div class="modal-content bgt-blue">
        <div class="modal-body p-0 b-line">
        <div class="title text-center pb-3 b-line"><h3><?= $this->language("l_title_thongbaodudiem") ?></h3></div>
        <div class="list-luot-co t-line pt-4 pb-4">
            <div class="row">
                <div class="w-85 m-auto m-0 pl-5 pr-5">
                    <p id="mess" style="text-align: center;color: red;padding-top: 20px;padding-bottom: 20px;font-size: 16px;"></p>
                </div>
            </div>
        </div>	
        </div>
        <div class="modal-footer t-line pb-4 pt-4">
        <div class="m-0 m-auto">
            <button type="button" class="btn btn-primary btn-blue" data-dismiss="modal"><?= $this->language("l_close") ?></button>
        </div>
        </div>
    </div>
    </div>
</div>
<!-- end modal mess -->

<!-- end modal register user in setting -->
<script src="<?= URL_PUBLIC ?>js/keyboard_diemchap.js"></script>
<script src="<?= URL_PUBLIC ?>js/keyboard_register.js"></script>
<script src="<?= URL_PUBLIC ?>js/keyboard_register_listmember.js"></script>
<script src="<?= URL_PUBLIC ?>js/keyboard_register_setting.js"></script>
<script src="<?= URL_PUBLIC ?>js/keyboard_number.js"></script>
<style>
    .keyboard__key_empty{cursor:auto;background:none;font-size:20px;font-weight: bold;height: 70px;margin: 10px;}
    .keyboard__key1,.keyboard__key2,.keyboard__key3,.keyboard__key4,.keyboard__key5,
    .keyboard__key6,.keyboard__key7,.keyboard__key8,.keyboard__key9,.keyboard__key0,
    .keyboard__keybackspace,.keyboard__keydone,.keyboard__keyenter {font-size: 20px;font-weight: bold;height: 70px;margin: 10px;}
</style>