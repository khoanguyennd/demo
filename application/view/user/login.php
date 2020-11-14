<script type="text/javascript">
    $(document).ready(function () {
        $('#login_area form').submit(function () {
            var aid = $('#aid').val();
            var caid = $('#aid').attr('data-check');
            var apw = $('#apw').val();
            var capw = $('#apw').attr('data-check');
            if (aid == '') {
                $.fn_alert(true, true, "<?= $this->language('l_inputid') ?>");
                return false;
            }
            if (apw == "") {
                $.fn_alert(true, true, "<?= $this->language('l_inputpw') ?>");
                return false;
            }
            if (caid == 'false' || capw == 'false') {
                return false;
            }
            return true;
        });
    });
</script>
<?php
$ID = "";
$PW ="";

if (isset($_COOKIE['accountremember']['ID'])){
    $ID = $_COOKIE['accountremember']['ID'];
    $PW = $_COOKIE['accountremember']['PW'];
}
?>
<script src="<?= URL_PUBLIC ?>js/vietuni.js"></script>
<div class="row ">
    <div class="col-md-4"></div>
    <div id="login_area" class="col-md-4">
        <form action="" method="POST" style="width: 70%; margin: 0 auto">
            <p class="form_item_error"><?= $this->getData('error'); ?></p>
            <div class="form-group">
                <input type="text" class="form-control from-c use-keyboard-input" autocomplete="off" name="aid" id="aid" placeholder="<?= $this->language('l_id') ?>" value="<?=$ID?>">
            </div>
            <div class="form-group">
                <input type="password" class="form-control from-c use-keyboard-input" name="apw" id="apw" placeholder="<?= $this->language('l_password') ?>" value="<?=$PW?>">
            </div>            
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" checked="checked">
                <label class="form-check-label" for="exampleCheck1"><?= $this->language('l_remember_id') ?></label>
            </div> 
            <input type="submit" class="btn btn-primary w100 submitlogin" name="" value="<?= $this->language('l_login') ?>">
            
        </form>
    </div>
    <div class="col-md-4"></div>
</div>
<script src="<?= URL_PUBLIC ?>js/keyboard_login.js"></script>

<style>
.submitlogin {
    background: #cb7309;
    border: #f69929 1px solid;
    box-shadow: #222 0px 6px 8px;
    font-size: 28px;
    font-weight: bold;
    text-transform: uppercase;
    border-radius: 10px;
    text-shadow:none;
    font-family: utm avo;
    font-weight: 500;
    color: #fff
}
.submitlogin:hover {background-color: #d39e00;border-color: #c69500;}
.form_item_error{text-align: center; color: red;}
</style>