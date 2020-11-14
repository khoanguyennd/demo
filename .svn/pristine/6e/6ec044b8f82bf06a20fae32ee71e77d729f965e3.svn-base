<script type="text/javascript">
	$(document).ready(function(){
		$('#login_area form').submit(function(){
			var aid = $('#aid').val();
			var caid = $('#aid').attr('data-check');
			var apw = $('#apw').val();
			var capw = $('#apw').attr('data-check');;
			//alert("login");
			if(aid == ''){
				$.fn_alert(true, true, "<?=$this->language( 'l_inputid')?>");
				return false;
			}					
			if ( apw == "" ) {
				$.fn_alert(true, true, "<?=$this->language( 'l_inputpw')?>");				
				return false;
			}
			
			if(caid == 'false' || capw == 'false'){
				return false;
			}
			return true;
		});
	});	
</script>
<?php 
$ID="";
if(isset($_COOKIE['accountshopping']['ID']))
    $ID=$_COOKIE['accountshopping']['ID'];
?>

<div class="t_page_login" id="login_area">
    <div class="t_logo">
        <!--<img src="<?=URL_PUBLIC?>temple_mobile/img/tbridge.jpg" alt=""/>-->
        <h2><?=$this->language('l_tbridge')?><!--티브리지--></h2>
        <p>여행 / 티켓 판매자를 위한 통합솔루션</p>
    </div>
    <form action="" method="POST">
    <div class="t_form_login">
        <div class="div_input_name">
            <input type="text" name="aid" id="aid" data-true="true" onchange="submitChanges()" placeholder="아이디" value="<?=$ID?>"  />
        </div>
        <div class="div_input_pass">
            <input type="password" name="apw" id="apw" onchange="submitChanges()" autocomplete="off" placeholder="비밀번호" />
        </div>
        <p style="color: red;margin-top: 5px;padding-bottom: 10px;text-align: center;"><?=$this->getData('error');?></p>
        <div class="div_input_checkbox" style="">
           	<input id="achecked" type="checkbox" name="achecked" >
			<label for="achecked">자동로그인</label>
        </div>
        <div class="div_input_submit">
            <input id="t_btn_submit_login" class="t_btn_submit_login t_btn_submit_login_dis" type="submit" name="" value="로그인" disabled="disabled" />
        </div>

        <div class="cl"></div>
    </div>
    </form>
    <div style="text-align: center;">  
        <!--<input class="t_p_button" type="button" value="<?=$this->language( 'l_findid')?>" onclick="window.location.assign('<?=$this->route('findid')?>');" />
        <input class="t_p_button" type="button" value="<?=$this->language( 'l_findpw')?>" onclick="window.location.assign('<?=$this->route('findpw')?>');" />
        <input class="t_p_pcversion" type="button" value="PC version" />-->
        <p class="t_p_findid">
            아이디/비밀번호 찾기는 PC버전을 이용해주세요
            <input style="color: red;" type="button" value="PC버전" />
        </p>
    </div>
    <div class="cl"></div>
</div>

<style>
    .t_btn_submit_login_dis{
        background: #d9d9d9;
    }
</style>
<script>
    function submitChanges() {
        var aid=document.getElementById("aid").value;
        var apw=document.getElementById("apw").value;
        if(aid!=""&&apw!=""){
            document.getElementById('t_btn_submit_login').disabled = false;
            var element = document.getElementById("t_btn_submit_login");
                element.classList.remove("t_btn_submit_login_dis");
        }else{
            document.getElementById('t_btn_submit_login').disabled = false;
            var element = document.getElementById("t_btn_submit_login");
                element.classList.add("t_btn_submit_login_dis");
        }
    }
</script>