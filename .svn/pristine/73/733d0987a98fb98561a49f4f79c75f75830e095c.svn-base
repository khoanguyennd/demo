<div class="menu">
    <div class="title">
        <div class="logo">
           <a href="http://localhost/tbridge/" style="color: #fff"><h1><?=$this->language('l_tbridge')?></h1></a>
        </div>
    </div>
    <div class="nav">
        <ul>
            <li><a class="dashboard index" 
            			href="<?=$this->route('dashboard')?>" title=""><i class="fa fa-home" aria-hidden="true"></i>Dashboard</a></li>   
            			          
            <li><a class="ticket1 ticket2 ticket3 ticket4 ticket5 addticket editticket1 editticket2 editticket3 editticket4 editticket5" 
            			href="<?=$this->route('addticket')?>"><i class="fa fa-cube" aria-hidden="true"></i><?=$this->language('l_addproduct')?></a></li>     
            			         
            <li><a class="listproduct listproduct" title="" 
            			href="<?=$this->route('listproduct', ['method'=>'sale'])?>" title=""><i class="fa fa-sitemap" aria-hidden="true"></i><?=$this->language('l_manageproduct')?></a></li>            	
            <li><a class="order index" 
            			href="<?=$this->route('order', ['method'=>'sale'])?>" title=""><i class="fas fa-file-alt"></i><?=$this->language( 'l_manageorder')?></a></li>
            			
            <li>
            	<a class="revenue detail settlement status" href="#" title=""><i class="fas fa-hand-holding-usd"></i><?=$this->language( 'l_managerevenue')?><i class="fa fa-chevron-down"></i></a>
            	<ul>
                    <li><a href="<?=$this->route('revenuedetail',['method'=>'detail'])?>" title=""><?=$this->language( 'l_managerevenue1')?></a></li>
                    <li><a href="<?=$this->route('revenuesettlement')?>" title=""><?=$this->language( 'l_managerevenue2')?></a></li>
                    <li><a href="<?=$this->route('revenuestatus')?>" title=""><?=$this->language( 'l_managerevenue3')?></a></li>
                </ul>
            </li>
            <li><a class="question index" 
            	href="<?=$this->route('question', ['method'=>'anwser'])?>" title=""><i class="fa fa-envelope" aria-hidden="true"></i><?=$this->language( 'l_managequestion')?></a></li>
            	
            <?php            
            if(Session::get('accountshopping')['role'] == 0){
            ?>
            <li>
            	<a class="channel tgridge sale" href="#" title=""><i class="fa fa-cubes" aria-hidden="true"></i><?=$this->language( 'l_managetype')?><i class="fa fa-chevron-down"></i></a>
            	<ul>
                    <li><a href="<?=$this->route('channeltbridge')?>" title=""><?=$this->language('l_Channel40')?></a></li>
                    <li><a href="<?=$this->route('channelsale')?>" title=""><?=$this->language('l_Channel41')?></a></li>
                </ul>
            </li>
            <li><a class="user member" href="<?=$this->route('member')?>" title=""><i class="fa fa-users"></i><?=$this->language('l_managemember')?></a></li>
            
            <?php } ?>
            <li><a class="notification index" href="<?=$this->route('notification')?>" title=""><i class="fa fa-bell" aria-hidden="true"></i>공지사항 </a></li>
        </ul>
    </div>
</div>

	

