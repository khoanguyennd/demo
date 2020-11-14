<?php 
$mobile=$_SESSION['mobile'];
if($mobile==0){
?>
    <div id="header">
    	<div class="head_content clearfix">
    		<div class="head_logo">
    			<a href="<?=$this->route('home')?>" title=""><img src="<?=URL_PUBLIC?>images/tbridge.jpg" alt="" title=""></a>
    		</div>
    		<?php if (Session::get('accountshopping')) { ?>
    		<div class="searchtop">
    			<form action="<?=$this->route('listproduct', ['method'=>'sale'])?>" method="POST" name="searchtop">
    				<input type="text" class="input full" name="searchtopkeyword" value="" placeholder="<?=$this->language('l_keyword')?>">
    				<button type="submit" class="input"><i class="fas fa-search"></i></button>
    			</form>
    		</div>
    		<?php }?>
    		<div class="sidebar_top">
    			<?php if (Session::get('accountshopping')) { ?>
                <ul class="clearfix">
    				<li><span onclick="return window.location.href='<?=$this->route('dashboard')?>'" style="cursor: pointer;"><?='<strong>'.Session::get('accountshopping')['ID'].'</strong>'." ".$this->language( 'l_welcome')?></span></li>
    				<li><a href="<?=$this->route('account')?>" title="<?=$this->language('l_accountinfo')?>"><?=$this->language('l_accountinfo')?></a></li>
    				<li><a href="<?=$this->route('logout')?>" title="<?=$this->language('l_areyousure')?>" onclick="return confirm('<?=$this->language( 'l_areyousure')?>');"><?=$this->language( 'l_logout')?></a></li>
    			</ul>
                <?php }else{ ?>
    			<ul class="clearfix">
    				<li>
    					<a href="<?=$this->route('login')?>" title=""><?=$this->language('l_login')?></a>
    				</li>
    			</ul>
    			<?php } ?>
    		</div>
    
    		<div class="sidebar_top change_lang"  >
    
    			<ul class="clearfix">
    				<li>
    					<input type="button" value="" name="bt-vn" class="vn" onclick="changeLangue('VN')">
    				</li>
    				<li>
    					<input type="button" value="" name="bt-kr" class="kr" onclick="changeLangue('KR')">
    				</li>
    			</ul>
    		</div>
    	</div>
    </div>
<?php } else {?>
    <!--<div id="header">
    	<div class="head_content clearfix">
    		<div class="head_logo">
    			<a href="<?=$this->route('home')?>" title=""><img src="<?=URL_PUBLIC?>images/tbridge.jpg" alt="" title=""></a>
    		</div>
    		<?php if (Session::get('accountshopping')) { ?>
    		<div class="searchtop">
    			<form action="<?=$this->route('listproduct', ['method'=>'sale'])?>" method="POST" name="searchtop">
    				<input type="text" class="input full" name="searchtopkeyword" value="" placeholder="<?=$this->language('l_keyword')?>">
    				<button type="submit" class="input"><i class="fas fa-search"></i></button>
    			</form>
    		</div>
    		<?php }?>
    		<div class="sidebar_top">
    			<?php if (Session::get('accountshopping')) { ?>
                <ul class="clearfix">
    				<li><span onclick="return window.location.href='<?=$this->route('dashboard')?>'" style="cursor: pointer;"><?='<strong>'.Session::get('accountshopping')['ID'].'</strong>'." ".$this->language( 'l_welcome')?></span></li>
    				<li><a href="<?=$this->route('account')?>" title="<?=$this->language('l_accountinfo')?>"><?=$this->language('l_accountinfo')?></a></li>
    				<li><a href="<?=$this->route('logout')?>" title="<?=$this->language('l_areyousure')?>" onclick="return confirm('<?=$this->language( 'l_areyousure')?>');"><?=$this->language( 'l_logout')?></a></li>
    			</ul>
                <?php }else{ ?>
    			<ul class="clearfix">
    				<li>
    					<a href="<?=$this->route('login')?>" title=""><?=$this->language('l_login')?></a>
    				</li>
    			</ul>
    			<?php } ?>
    		</div>
    
    		<div class="sidebar_top change_lang"  >
    
    			<ul class="clearfix">
    				<li>
    					<input type="button" value="" name="bt-vn" class="vn" onclick="changeLangue('VN')">
    				</li>
    				<li>
    					<input type="button" value="" name="bt-kr" class="kr" onclick="changeLangue('KR')">
    				</li>
    			</ul>
    		</div>
    	</div>
    </div>-->
<?php }?>