<script type="text/javascript">
    $(document).ready(function () {
        $('#login_area form').submit(function () {
            var aid = $('#aid').val();
            var caid = $('#aid').attr('data-check');
            var apw = $('#apw').val();
            var capw = $('#apw').attr('data-check');
            if (aid == '') {
                $(".form_item_error").html("<?= $this->language('l_inputid') ?>");                
                return false;
            }
            if (apw == "") {
                $(".form_item_error").html("<?= $this->language('l_inputpw') ?>");
                //$.fn_alert(true, true, "<?= $this->language('l_inputpw') ?>");
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
$ID = "";$PW ="";
if (isset($_COOKIE['accountremember']['ID'])){
    $ID = $_COOKIE['accountremember']['ID'];
    $PW = $_COOKIE['accountremember']['PW'];
}
?>   
<div id="login_area" class="col-md-12">
    <form action="" method="POST" style="width: 90%; margin: 0 auto">
        <p class="form_item_error"><?= $this->getData('error'); ?></p>
        <div class="form-group">
            <input type="text" class="form-control from-c from-c_mobi" autocomplete="off" name="aid" id="aid" placeholder="<?= $this->language('l_id') ?>" value="<?=$ID?>">
        </div>
        <div class="form-group">
            <input type="password" class="form-control from-c from-c_mobi" name="apw" id="apw" placeholder="<?= $this->language('l_password') ?>" value="<?=$PW?>">
        </div>            
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" checked="checked">
            <label class="form-check-label" for="exampleCheck1"><?= $this->language('l_remember_id') ?></label>
        </div>
        <input type="submit" class="btn btn-primary w100 submitlogin" name="" value="<?= $this->language('l_login') ?>">            
    </form>
</div>