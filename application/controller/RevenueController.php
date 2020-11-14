<?php
class RevenueController extends Controller
{

    // Phương thức khởi tạo
    public function __construct($params)
    {
        parent::__construct($params);
        $this->isLogin();
        $account = $_SESSION['accountshopping'];
        if($account['temp']==1)
            Url::header($this->route('account')."#tab1");
    }

    // Phương thức
    public function detailAction()
    {
        $account = $_SESSION['accountshopping'];
        $list_channel = array();
        $channel = $this->_model->loadRecords('channels');
        $m_channel = array();
        $m_product = array();
        foreach ($channel as $value => $giatri) {
            $list_channel[] = array(
                $giatri['channel_id'],
                $giatri['channel_name']
            );
            $m_channel[]= $giatri['channel_id'];
        }
        $this->_view->setData('list_channel', $list_channel);

        $sql = "SELECT p.sellerProductId,p.`name` FROM tb_sellerproduct p ";
        if ($account['role'] == 0) {
            $sql .= "WHERE 1!=-1 ";
        } else {
            $sql .= "WHERE (p.creator='" . $account['ID'] . "' OR p.creator IN (SELECT u2.ID FROM tb_user u1 ,tb_user u2
        								WHERE u1.ID = '" . $account['ID'] . "' AND u2.idx_parent=u1.idx) )";
        }
        $sql .= " ORDER BY p.name DESC ";
        $this->_model->setQuery($sql);
        $list_product = $this->_model->readAll();
        $this->_view->setData('list_product', $list_product);
        foreach ($list_product as $value => $giatri) {
            $m_product[]= $giatri['sellerProductId'];
        }
        $sqlheader = "SELECT 	sc.id as salechannelId,sc.channelTypeId,
                				c.channel_name as channelname,
                				sp.`supplier` as supplierid,
                				us.ID as suppliername,
                				sp.`name` as productname,
                				sc.`status`,
                				DATE_FORMAT(sc.useStartedAt, \"%Y-%m-%d\") useStartedAt,
                				DATE_FORMAT(sc.useEndedAt, \"%Y-%m-%d\") useEndedAt,
                				sum(IF(tk.statusTicket!=3, tk.totalAmount,0)) as quantitysoldreal,
                				sum(IF(tk.statusTicket=2, tk.totalAmount,0)) as quantitysolduse,
                				sum(IF(tk.statusTicket=3, tk.totalAmount,0)) quantitysoldcancel,
                				sum(IF(tk.statusTicket!=3, tp.price,0)) as amountsoldreal,
                				sum(IF(tk.statusTicket=2, tp.price,0)) as amountsolduse,
                				sum(IF(tk.statusTicket=3, tp.price,0)) as amountsoldcancel   ";
        $sql = "    FROM tb_ticketPurchasers tp, tb_ticket tk, tb_salechannel sc,tb_channeltypes ct, tb_channels c, tb_sellerproduct sp, tb_user us
                    WHERE sc.vendorItemPackageId=tp.dealId 
                			AND tp.ticketNumber=tk.ticketNumber     
                			AND sc.channelTypeId=ct.type_id
                			AND ct.channelid=c.channel_id
                			AND sc.sellerProductId=sp.sellerProductId
                			AND sp.supplier=us.idx ";

        if ($account['role'] == 0) {} else {
            $sql .= " AND (sp.creator='" . $account['ID'] . "' OR 
                          sp.creator IN (SELECT u2.ID
                                         FROM tb_user u1 ,tb_user u2
								         WHERE u1.ID = '" . $account['ID'] . "' AND u2.idx_parent=u1.idx) ) ";
        }

        $sqlgroupby = " GROUP BY sp.id ";

        if (isset($this->_params['m_search'])) {

            $m_start = $this->_params['m_start'];
            $m_end = $this->_params['m_end'];
            $sql .= " AND ( tp.purchaseDateTime >='$m_start 00:00:00' AND tp.purchaseDateTime <='$m_end 23:59:59' ) ";

            $m_supplier = $this->_params['m_supplier'];
            if ($m_supplier != 0)
                $sql .= " AND sp.supplier=$m_supplier ";

            $m_channel = array();
            if (isset($this->_params['m_channel'])) {
                $m_channel = $this->_params['m_channel'];
                if (count($m_channel) > 0) {
                    $sql .= " AND ( ";
                    foreach ($m_channel as $value => $giatri) {
                        $sql .= "c.channel_id=$giatri OR ";
                    }
                    $sql = mb_substr($sql, 0, - 3);
                    $sql .= " ) ";
                }
            }

            $m_status = $this->_params['m_status'];
            if ($m_status != 10) {
                $sql .= " AND sc.status=$m_status ";
            }

            $m_product = array();
            if (isset($this->_params['m_product'])) {
                $m_product = $this->_params['m_product'];
                if (count($m_product) > 0) {
                    $sql .= " AND ( ";
                    foreach ($m_product as $value => $giatri) {
                        $sql .= " sp.sellerProductId = $giatri OR ";
                    }
                    $sql = mb_substr($sql, 0, - 3);
                    $sql .= " ) ";
                }
            }
            
            $m_little = $this->_params['m_little'];
            $m_big = $this->_params['m_big'];
            if ($m_little != "" || $m_big != "") {
                $sqlgroupby .= " HAVING ";
                if ($m_little != "" && $m_big == "")
                    $sqlgroupby .= " quantitysoldreal >= $m_little";
                if ($m_big != "" && $m_little == "")
                    $sqlgroupby .= " quantitysoldreal <= $m_big";
                if ($m_little != "" && $m_big != "")
                    $sqlgroupby .= " quantitysoldreal >= $m_little AND quantitysoldreal <= $m_big";
            }
            //echo $sqlgroupby;
        } else {
            $m_start = date("Y-m-d");
            $m_end = date("Y-m-d");
            $m_little = "";
            $m_big = "";
            $m_supplier = 0;
            $m_status = 10;
            if (isset($this->_params['method'])){
                $method=$this->_params['method'];
                if($method=='notorder'){
                    $m_status = 3;
                    $m_start = date('Y-m-d', strtotime('-7 day'));
                    $m_end = date("Y-m-d");
                    $sql .= ' AND sc.`status`=3 ';
                    $sql .= " AND ( tp.purchaseDateTime >='$m_start 00:00:00' AND tp.purchaseDateTime <='$m_end 23:59:59' ) ";
                }
            }
            
        }
        $this->_view->setData('m_start', $m_start);
        $this->_view->setData('m_end', $m_end);
        $this->_view->setData('m_channel', $m_channel);
        $this->_view->setData('m_product', $m_product);
        $this->_view->setData('m_status', $m_status);
        $this->_view->setData('m_supplier', $m_supplier);
        $this->_view->setData('m_little', $m_little);
        $this->_view->setData('m_big', $m_big);

        $_SESSION['orderbydetail'] = array(
            "channelname",
            "ASC"
        );
        $orderbydetail = $_SESSION['orderbydetail'];
        $sqlorderby = " ORDER BY " . $orderbydetail[0] . " " . $orderbydetail[1] . "  ";

        // Tham số phân trang
        $length = ($this->_params['length'] ? $this->_params['length'] : DEFAULT_LENGTH);
        $page = ($this->_params['page'] ? $this->_params['page'] : 1);

        $begin = ($page - 1) * $length;

        $this->_view->setData('page', $page);
        $this->_view->setData('length', $length);

        $sqlstatus = " ";
        $this->_model->setQuery("SELECT COUNT(salechannelId) as count, 
                                SUM(quantitysoldreal) as quantitysoldrealtotal , SUM(amountsoldreal)  as amountsoldrealtotal,
                                SUM(quantitysolduse) as quantitysoldusetotal , SUM(amountsolduse)  as amountsoldusetotal,
                                SUM(quantitysoldcancel) as quantitysoldcanceltotal , SUM(amountsoldcancel)  as amountsoldcanceltotal
                                FROM  ( " . $sqlheader . $sql . $sqlstatus . $sqlgroupby . " ) as tb_count");
        $result = $this->_model->readAll();
        $this->_view->setData('count', $result[0]['count']);
        $pagination = $this->paginationParams($result[0]['count'], $this->route('revenuedetail', ['method'=>'detail']));
        $this->_view->setData('pagination', $pagination['pagination']);
        $this->_view->setData('quantitysoldrealtotal', $result[0]['quantitysoldrealtotal']);
        $this->_view->setData('amountsoldrealtotal', $result[0]['amountsoldrealtotal']);
        $this->_view->setData('quantitysoldusetotal', $result[0]['quantitysoldusetotal']);
        $this->_view->setData('amountsoldusetotal', $result[0]['amountsoldusetotal']);
        $this->_view->setData('quantitysoldcanceltotal', $result[0]['quantitysoldcanceltotal']);
        $this->_view->setData('amountsoldcanceltotal', $result[0]['amountsoldcanceltotal']);
        $_SESSION['sqldetail'] = $sqlheader . $sql . $sqlstatus . $sqlgroupby;
        //echo $sqlheader . $sql . $sqlstatus . $sqlgroupby;
        $this->_model->setQuery($sqlheader . $sql . $sqlstatus . $sqlgroupby . $sqlorderby . " LIMIT " . $begin . "," . $length);
        $_SESSION['sqlRevenue'] = $sqlheader . $sql . $sqlstatus . $sqlgroupby . $sqlorderby . " LIMIT " . $begin . "," . $length;
        $revenue = $this->_model->readAll();
        $dem = 0;
        $this->_view->setData('revenue', $revenue);

        $list_supplier = $this->_model->loadRecords('user', [
            'idx_parent' => $account['idx']
        ]);
        $this->_view->setData('list_supplier', $list_supplier);

        $this->_view->setData('dem', $dem);

        $this->_view->render('detail');
    }

    // Phương thức phân trang ajax
    public function paginationdetailAjax()
    {
        $result1 = [
            'flag' => false
        ];
        $sql = $_SESSION['sqldetail'];
        $orderbydetail = $_SESSION['orderbydetail'];
        if (isset($this->_params['sort'])) {
            $sort = $this->_params['sort'];
            if ($orderbydetail[0] == $sort) {
                if ($orderbydetail[1] == "ASC")
                    $orderbydetail[1] = "DESC";
                else
                    $orderbydetail[1] = "ASC";
            } else {
                $orderbydetail[0] = $sort;
                $orderbydetail[1] = "ASC";
            }
        }
        $_SESSION['orderbydetail'] = $orderbydetail;
        $sqlorderby = " ORDER BY " . $orderbydetail[0] . " " . $orderbydetail[1] . "  ";
        // echo $sqlorderby;
        // Tham số phân trang
        $length = ($this->_params['length'] ? $this->_params['length'] : DEFAULT_LENGTH);
        $page = ($this->_params['page'] ? $this->_params['page'] : 1);

        $begin = ($page - 1) * $length;

        $this->_view->setData('page', $page);
        $this->_view->setData('length', $length);

        $this->_model->setQuery("SELECT COUNT(salechannelId) as count, SUM(quantitysoldreal) as quantitysoldrealtotal , SUM(amountsoldreal)  as amountsoldrealtotal
                                FROM  ( " . $sql . " ) as tb_count");

        $result = $this->_model->readAll();
        $this->_view->setData('count', $result[0]['count']);
        $pagination = $this->paginationParams($result[0]['count'], $this->route('revenuedetail', ['method'=>'detail']));

        $result1['divpaging'] = $pagination['pagination'];
        
        $result1['sql']=$sql . $sqlorderby . " LIMIT " . $begin . "," . $length;
        $this->_model->setQuery($sql . $sqlorderby . " LIMIT " . $begin . "," . $length);
        $revenue = $this->_model->readAll();

        $vitri = ($page - 1) * $length;
        $revenuetbody = "";
        foreach ($revenue as $value => $giatri) {
            $vitri ++;
            $l_status = "";
            if ($giatri["status"] == 0)
                $l_status = $this->_view->getItem('language', 'l_status0');
            if ($giatri["status"] == 1)
                $l_status = $this->_view->getItem('language', 'l_status1');
            if ($giatri["status"] == 2)
                $l_status = $this->_view->getItem('language', 'l_status2');
            if ($giatri["status"] == 3)
                $l_status = $this->_view->getItem('language', 'l_status3');
            if ($giatri["status"] == 4)
                $l_status = $this->_view->getItem('language', 'l_status4');
            if ($giatri["status"] == - 1)
                $l_status = $this->_view->getItem('language', 'l_status_1');

            $quantitysolduse = "";
            if ($giatri['quantitysolduse'] != 0)
                $quantitysolduse = $giatri['quantitysolduse'];
            $amountsolduse = "";
            if ($giatri['amountsolduse'] != 0)
                $amountsolduse = number_format($giatri['amountsolduse']);

            $revenuetbody .= '
			     <tr>
					<td>' . $vitri . '</td>
					<td>' . $giatri['channelname'] . '</td>
					<td>' . $giatri['suppliername'] . '</td>
					<td><a href="#" class="vdetail2"  
									data-salechannelId="'.$giatri['salechannelId'].'"
									data-productname="'.$giatri['productname'].'">' . $giatri['productname'] . '</a></td>
					<td>' . $l_status . '</td>
					<td>' . $giatri['useStartedAt'] . '</td>
					<td>' . $giatri['useEndedAt'] . '</td>
					<td>
                        <a href="#" class="vdetail3"
                							data-counttotal="'.($giatri['quantitysoldreal']+$giatri['quantitysoldcancel']).'"
                							data-sumtotal="'.number_format($giatri['amountsoldreal']+$giatri['amountsoldcancel']).'"
                							data-countcancel="'.$giatri['quantitysoldcancel'].'"
                							data-sumcancel="'.number_format($giatri['amountsoldcancel']).'" > '.$giatri['quantitysoldreal'].'</a>
                    </td>
					<td>' . number_format($giatri['amountsoldreal']) . '</td>
					<td>' . $quantitysolduse . '</td>
					<td>' . $amountsolduse . '</td>
					    
				</tr>';
        }
        if(count($revenue)==0)
            $revenuetbody .= '<tr><td colspan="11" class="empty">'. $this->_view->getItem('language',"l_rowemptydata").'</td></tr>';
        $result1['revenuetbody'] = $revenuetbody;
        $result1['flag'] = true;

        echo json_encode($result1);
    }
    // Phương thức download file excel
    public function downloadDetailExcelAjax(){
        $format = Func::config('listrevenuedetailDownloadExcel');
        if($format){
            $sql = $_SESSION['sqlRevenue'];
            $items = $this->_model->calculateRevenueByChannel($sql);

             if($items){
                $format['export']['titleName'] = "aaa";
                $format['export']['description'] = "bbb";
                $excel = new OfficeExcel();
                $excel->write($format['filename'], $items, $format['columns'], $format['export']);
               }
          }
    }

      public function downloadStatusDetailExcelAjax(){
         $format = Func::config('settlementStatusDownloadExcel');
         if($format){
            $sid=$_SESSION['sid'];
             $sqlheader = ' SELECT s.*, u.ID as supplier ';
             $sqlcount = ' SELECT COUNT(userId) as record ';
             $sql=' FROM `tb_settlementuser` s, `tb_user` u
                 WHERE s.id='.$sid;
            $sqlheader1='SELECT c.channel_name as channelname,sp.`name` as productname ,sud.*';  
            $sqlcount1 = ' SELECT COUNT(userId) as record ';
            $sql1 = '
                FROM tb_settlementuserdetail sud, tb_channels c, tb_sellerproduct sp
                WHERE sud.channelId=c.channel_id 
                AND sud.sellerProductId=sp.sellerProductId 
                AND sud.settlementuserId='.$sid;
               $items = $this->_model->searchSettlementStatus($sqlheader.$sql, $sqlcount.$sql,1,0);
               $details = $this->_model->searchSettlementStatus($sqlheader1.$sql1, $sqlcount1.$sql1,10,0);
               $settlementuseradjusted = $this->_model->loadRecords("settlementuseradjusted",['settlementuserId'=>$sid]);
              //  echo '<pre>';
              //  print_r($settlementuseradjusted);
              //  echo'</pre>';
              // exit();
                $excel = new OfficeExcel();
                $excel->writeSellertment("testExcel", $items['data'], $details['data'], $settlementuseradjusted);
               
            }
    }
    
    public function revenuetoptionAjax(){ 
        $result1 = [
            'flag' => false
        ];
        
        $salechannelId=$this->_params['salechannelId'];
        $sql="SELECT tp.optionName,
        			sum(IF(tk.statusTicket<4, tk.totalAmount,0)) as quantitysoldreal,
        			sum(IF(tk.statusTicket=2, tk.totalAmount,0)) as quantitysolduse,
        			sum(IF(tk.statusTicket=3, tk.totalAmount,0)) quantitysoldcancel,
        			sum(IF(tk.statusTicket<4, tp.price,0)) as amountsoldreal,
        			sum(IF(tk.statusTicket=2, tp.price,0)) as amountsolduse,
        			sum(IF(tk.statusTicket=3, tp.price,0)) as amountsoldcancel		
                FROM tb_ticket tk, tb_ticketPurchasers tp,tb_salechannel sc
                WHERE tp.ticketNumber=tk.ticketNumber AND sc.vendorItemPackageId=tp.dealId AND sc.id=$salechannelId	
                GROUP BY sc.sellerProductId;";
        
        $this->_model->setQuery($sql);
        $revenueoption = $this->_model->readAll();
        $revenuetoptiontbody="";
        foreach ($revenueoption as $value => $giatri) {
            $revenuetoptiontbody.='
                            <tr>
								<td>'.$giatri['optionName'].'</td>

								<td>'.($giatri['quantitysoldreal']).'</td>
								<td>'.number_format($giatri['amountsoldreal']).'</td>

								<td>'.$giatri['quantitysoldcancel'].'</td>
								<td>'.number_format($giatri['amountsoldcancel']).'</td>

								<td>'.($giatri['quantitysoldreal']-$giatri['quantitysoldcancel']).'</td>
								<td>'.number_format($giatri['amountsoldreal']-$giatri['amountsoldcancel']).'</td>

								<td>'.$giatri['quantitysolduse'].'</td>
								<td>'.number_format($giatri['amountsolduse']).'</td>
							</tr>
            ';
        }
        
        
        $result1['revenuetoptiontbody'] = $revenuetoptiontbody;
        $result1['flag'] = true;
        
        echo json_encode($result1);
    }

    // Phương thức quyết toán
    public function settlementAction()
    {
        $m_channel = array();
        // Nhà cung cấp
        $list_supplier = $this->_model->loadSupplier(Structure::getUserId());
        $this->_view->setData('list_supplier', $list_supplier);
        // Kênh bán
        $list_channel = $this->_model->loadRecords('channels');
        $this->_view->setData('list_channel', $list_channel);
        foreach ($list_channel as $value => $giatri) {
            $m_channel[]= $giatri['channel_id'];
        }
        
        $sqlheader = 'SELECT c.channel_id, c.channel_cid , c.channel_name, u.idx, u.ID, s.* ';
        $sqlcount = 'SELECT COUNT(c.channel_id) as record ';
        $sql=' FROM `tb_user` u, `tb_channels` c,  `tb_settlementchannel` s 
               WHERE c.channel_id=s.channelId AND s.supplier=u.idx AND c.channel_id = 1 
        ';

        if(Session::get('accountshopping')['role'] > 0){
            $sql .= ' AND ( u.ID ="'.Structure::getUserId(true).' ")';
        }	 
        
        if (isset($this->_params['m_search'])) {
            $m_start = $this->_params['datestart'];
            $m_end = $this->_params['dateend'];
            $sql.=' AND s.`modified` BETWEEN "'.$m_start.' 00:00:00" AND "'.$m_end.' 23:59:59" ';
            $m_supplier= $this->_params['m_supplier'];
            if($m_supplier != 0){
                $sql .= ' AND s.`supplier`='.$m_supplier;
            }
            $m_channel = array();
            if (isset($this->_params['m_channel'])) {
                $m_channel = $this->_params['m_channel'];
                if (count($m_channel) > 0) {
                    $sql .= " AND ( ";
                    foreach ($m_channel as $value => $giatri) {
                        $sql .= " c.`channel_id`=$giatri OR ";
                    }
                    $sql = mb_substr($sql, 0, - 3);
                    $sql .= " ) ";
                }
            }
        }else{
            $m_start = date("Y-m-d");
            $m_end = date("Y-m-d");
            $m_supplier = 0;
        }
        $_SESSION['sqlsettlement']=$sql ;
        //echo $sqlheader.$sql;
        // Danh sách quyết toán
        $length = ($this->_params['length'] ? $this->_params['length'] : DEFAULT_LENGTH);
        $page = ($this->_params['page'] ? $this->_params['page'] : 1);
        $begin = ($page - 1) * $length;
        $items= [];
        $count = $this->_model->countSettlement($sqlcount.$sql);
        $pagination = $this->paginationParams($count['record'], $this->route('revenuesettlement'));
        if($pagination){
            $items = $this->_model->loadSettlement($sqlheader.$sql,$length, $begin);
            $this->_view->setData('length', $pagination['length']);
            $this->_view->setData('pagination', $pagination['pagination']);
            $this->_view->setData('total', $pagination['count']);
        }
        $this->_view->setData('settlement', Helper::createRowRevenueSettlement($items));
        $this->_view->setData('m_start', $m_start);
        $this->_view->setData('m_end', $m_end);
        $this->_view->setData('m_channel', $m_channel);
        $this->_view->setData('m_supplier', $m_supplier);

        $this->_view->render('settlement');
    }
    
    // Phương thức tìm kiếm quyết toán
    public function searchSettlementAndPaginationAjax(){
        $result = ['flag'=>false];
        
        $sqlheader = 'SELECT c.channel_id, c.channel_cid , c.channel_name, u.idx, u.ID, s.* ';
        $sqlcount = 'SELECT COUNT(c.channel_id) as record ';
        $sql= $_SESSION['sqlsettlement'] ;
        
        $length = ($this->_params['length'] ? $this->_params['length'] : DEFAULT_LENGTH);
        $page = ($this->_params['page'] ? $this->_params['page'] : 1);
        $begin = ($page - 1) * $length;
        
        $items = $this->_model->searchSettlement($sqlheader.$sql,$sqlcount.$sql,$length,$begin);
        $pagination = $this->paginationParams($items['count'], $this->route('revenuesettlement'));
        if($pagination){
            $result = $pagination;
            $result['rows'] = Helper::createRowRevenueSettlement($items['data']);
            $result['flag'] = true;
        }
        echo json_encode($result);
    }
    
    // Phương thức download excel quyết toán
    public function downloadSettlementAjax(){
        $format = Func::config('settlementDownloadExcel');           
        if($format){
            $sqlheader = 'SELECT c.channel_id, c.channel_cid , c.channel_name, u.idx, u.ID, s.* ';
            $sqlcount = 'SELECT COUNT(c.channel_id) as record ';
            $sql= $_SESSION['sqlsettlement'] ;
            $items = $this->_model->searchSettlement($sqlheader.$sql,$sqlcount.$sql,10000,0);
            if($items){
                $format['export']['titleName'] = $this->_params['titleName'];
                $format['export']['description'] = $this->_params['description'];
                $excel = new OfficeExcel();
                $excel->write($format['filename'], $items['data'], $format['columns'], $format['export']);
            }
        }
    }

    // Phương thức tình hình quyết toán
    public function statusAction()
    {   
        // Nhà cung cấp
        $list_supplier = $this->_model->loadSupplier(Structure::getUserId());
        $this->_view->setData('list_supplier', $list_supplier);
        $sqlheader = ' SELECT s.*, u.ID as supplier ';
        $sqlcount = ' SELECT COUNT(userId) as record ';
        $sql=' FROM `tb_settlementuser` s, `tb_user` u
                WHERE s.supplierId=u.idx ';
        if(Session::get('accountshopping')['role'] > 0){
            $sql .= ' AND (s.userID="'.Structure::getUserId(true).'" OR u.ID ="'.Structure::getUserId(true).' ")';
        }	 
        
        if (isset($this->_params['m_search'])) {
            $m_key = $this->_params['m_key'];
            $m_start = $this->_params['datestart'];
            $m_end = $this->_params['dateend'];
            $sql .= ' AND s.`modified` BETWEEN "'.$m_start.' 00:00:00" AND "'.$m_end.' 23:59:59" ';
            $m_supplier= $this->_params['m_supplier'];
            if($m_supplier != 0){
                $sql .= ' AND (u.`idx`='.$m_supplier. ' OR u.`idx_parent`='.$m_supplier.')';
            }
            $m_status = $this->_params['m_status'];
            $sql .= ' AND s.`status`='.$m_status.' ';

        }else{
            $m_key = 1;
            $m_start = date("Y-m-d");
            $m_end = date("Y-m-d");
            $m_supplier = 0;
            $m_status = 0;
        }
        
        //$sql .= ' ORDER BY s.settlementday DESC';
        
        $_SESSION['sqlstatus']=$sql ;
        // Xử lý
        $length = ($this->_params['length'] ? $this->_params['length'] : DEFAULT_LENGTH);
        $page = ($this->_params['page'] ? $this->_params['page'] : 1);
        $begin = ($page - 1) * $length;
        $items= [];
        $count = $this->_model->countSettlementUser($sqlcount.$sql);
        //echo $sqlheader.$sql;
        $pagination = $this->paginationParams($count['record'], $this->route('revenuestatus'));
        if($pagination){
            $items = $this->_model->loadSettlementUsers($sqlheader.$sql,$pagination['length'], $pagination['begin']);
            $this->_view->setData('length', $pagination['length']);
            $this->_view->setData('pagination', $pagination['pagination']);
            $this->_view->setData('total', $pagination['count']);
        }
        
        $this->_view->setData('settlementstatus', Helper::createRowRevenueSettlementStatus($items, $this->route('revenuestatusdetail')));
        $this->_view->setData('m_key', $m_key);
        $this->_view->setData('m_start', $m_start);
        $this->_view->setData('m_end', $m_end);
        $this->_view->setData('m_supplier', $m_supplier);
        $this->_view->setData('m_status', $m_status);
        $this->_view->render('status');
    }
    
    // Phương thức tìm kiếm tình hình quyết toán
    public function searchSettlementStausAndPaginationAjax(){
        $result = ['flag'=>false];
        $sqlheader = ' SELECT s.*, u.ID as supplier ';
        $sqlcount = ' SELECT COUNT(userId) as record ';
        $sql= $_SESSION['sqlstatus'] ;
        
        $length = ($this->_params['length'] ? $this->_params['length'] : DEFAULT_LENGTH);
        $page = ($this->_params['page'] ? $this->_params['page'] : 1);
        $begin = ($page - 1) * $length;
        
        $items = $this->_model->searchSettlementStatus($sqlheader.$sql,$sqlcount.$sql,$length,$begin);
        $pagination = $this->paginationParams($items['count'], $this->route('revenuestatus'));
        if($pagination){
            $result = $pagination;
            $result['rows'] = Helper::createRowRevenueSettlementStatus($items['data'], $this->route('revenuestatusdetail'));
            $result['flag'] = true;
        }
        
        echo json_encode($result);
    }
    // Phương thức thay đổi trạng thái
    public function changeSettlementStatusAjax(){       
        $result = ['flag'=>false];       
        if(isset($this->_params['status']) && isset($this->_params['length']) && isset($this->_params['page'])){
            foreach ($this->_params['status'] as $key => $value){              
                if($value['status']==1 || $value['status']==3){ 
                    if($value['status']== 3){
                        $status = 4;
                    }elseif($value['actname'] == 'done'){
                        $status = 3;                       
                    }else{
                        $status = 2;
                    }   
                    $created = date('Y-m-d H:i:s', time());
                    $dataUpdate = [
                        'status'=>$status,
                        'modified'=>$created,
                        'modified_by'=>Structure::getUserId(true),
                    ];
                    if($this->_model->updateRecord('settlementuser', $dataUpdate, ['id'=>$value['id']]) != false){
                        $aStatus = Helper::statusSettlementStatus($status);
                        $this->_model->insertRecord('settlementuserlog', [
                            'settlementuserId'=>$value['id'],
                            'content'=>$aStatus['name'],
                            'created'=>$created,
                            'created_by'=>Structure::getUserId(true)
                        ]);
                    }
                    continue;
                } 
                break;
            }  
            
            if(isset($status)){
                $length = ($this->_params['length'] ? $this->_params['length'] : DEFAULT_LENGTH);
                $page = ($this->_params['page'] ? $this->_params['page'] : 1);
                $begin = ($page - 1) * $length;
                $sqlheader = ' SELECT s.*, u.ID as supplier ';
                $sqlcount = ' SELECT COUNT(userId) as record ';
                $sql= $_SESSION['sqlstatus'] ;
                $items = $this->_model->loadSettlementUsers($sqlheader.$sql,$length, $begin);
                $result['rows'] = Helper::createRowRevenueSettlementStatus($items, $this->route('revenuestatusdetail'));
                $result['flag'] = true;
            }           
        }
        echo json_encode($result);
    }
    
    // Phương thức download excel quyết toán
    public function downloadSettlementStatusAjax(){
        $format = Func::config('settlementStatusDownloadExcel');
        if($format){
            $sqlheader = ' SELECT s.*, u.ID as supplier ';
            $sqlcount = ' SELECT COUNT(userId) as record ';
            $sql= $_SESSION['sqlstatus'] ;
            $items = $this->_model->searchSettlementStatus($sqlheader.$sql,$sqlcount.$sql,10000,0);
            if($items){
                $format['export']['titleName'] = $this->_params['titleName'];
                $format['export']['description'] = $this->_params['description'];
                $excel = new OfficeExcel();
                $excel->write($format['filename'], $items['data'], $format['columns'], $format['export']);
            }
        }
        
    }
    
    // Phương thức chi tiết tình hình quyết toán
    public function statusDetailAction(){        
        $item = $this->_model->loadSettlementUser($this->_params['sid']); 
        $_SESSION['sid']=$this->_params['sid'];
        if($item){
            // Chi tiết bán
            $this->_view->setData('itemstatus', $item);
            $this->_view->setData('actstatus', (($this->_params['act']=='edit')?'':' disabled '));
            
            // Chi tiết tiền điều chỉnh
            $items = $this->_model->loadSettlementUserDetail($this->_params['sid']);
            $this->_view->setData('customstatus', Helper::createRowRevenueSettlementStatusDetail($items));
           
            //Tổng số tiền quyết toán
            $this->_view->setData('settlementuserdetail', $items);
            $settlementuseradjusted = $this->_model->loadRecords("settlementuseradjusted",['settlementuserId'=>$this->_params['sid']]);
            $this->_view->setData('settlementuseradjusted', $settlementuseradjusted);
            $this->_view->render('statusdetail');
        }else{
            $this->pageError();
        } 
    }
    
    // Phương thức hiển thị lịch sử xét duyệt
    public function viewStatusHistoryAjax(){
        //', {'sid': sid}
        $result = ['flag'=>false];
        if(isset($this->_params['sid'])){
            $items = $this->_model->loadRecords('settlementuserlog', ['settlementuserId'=>$this->_params['sid']]);
            if($items){
                $result['flag'] = true;
                $result['rows'] = Helper::createRowRevenueSettlementHistory($items);
            }
        }
        echo json_encode($result);
    }
    
    // Phương thức tạo quyết toán tự động
    public function createSettlementAutoAction(){
        $items1 = $this->_model->loadSettlementAuto1();
        $items2 = $this->_model->loadSettlementAuto2();
        if($items1 && $items2){
            // 1
            foreach ($items1 as $key1 => $value1){
                // insert
                $priceTotal = $value1['amountsolduse'] + $value1['amountsoldexpired'];
                $amountTotal = $value1['quantitysolduse'] + $value1['quantitysoldexpired'];
                $dataInsert = Structure::settlements([
                    'supplier'=>$value1['supplier'],                      
                    'channelId'=>$value1['channelId'],                    
                    'pricetotal'=>$priceTotal,
                    'amounttotal'=>$amountTotal,
                    'feetotal'=>$value1['feetotal'],
                    'settlementtotal'=>$priceTotal + $value1['feetotal'],                       
                ]);
               $this->_model->insertRecord('settlementchannel', $dataInsert);
            }
            // 2
            foreach ($items2 as $key2 => $value2){
                // insert table settlementuser
                $created = date('Y-m-d H:i:s', time());
                $settlementuser = Structure::settlementuser([                       
                    'userId'=>$value2['creator'],
                    'supplierId'=>$value2['supplier'],                       
                    'pricetotal'=>$value2['ticketprice'],
                    'feetotal'=>$value2['feetotal'],
                    'settlementtotal'=>($value2['ticketprice'] + $value2['feetotal']),
                    'modified'=>$created,
                ]);
                $settid = $this->_model->insertRecord('settlementuser', $settlementuser);
                
                if($settid){
                    // insert table settlementuserlog
                    $this->_model->insertRecord('settlementuserlog', Structure::settlementuserlog([
                        'settlementuserId'=>$settid,
                        'content'=>'l_revenue10',
                        'created'=>$created
                    ]));
                    // insert table settlementuserdetail
                    $items3 = $this->_model->loadSettlementAuto3($value2['creator'], $value2['supplier']);
                    if($items3){
                        foreach ($items3 as $key3 => $value3){
                            $settlementuserdetail = Structure::settlementuserdetail([
                                'settlementuserId'=>$settid,
                                'channelId'=>$value3['channelid'],
                                'sellerProductId'=>$value3['sellerProductId'],
                                'price'=>$value3['price'],
                                'amount'=>($value3['quantitysolduse'] + $value3['quantitysoldexpired']), 
                                'pricetotal'=>($value3['amountsolduse'] + $value3['amountsoldexpired']),
                                'feetotal'=>$value3['feetotal']
                            ]);
                            $this->_model->insertRecord('settlementuserdetail', $settlementuserdetail);
                        }
                    }
                    // insert table settlementuseradjust
                    $this->insertTbsettlementuseradjust($settid);                   
                }
            }
            // update
            $this->_model->updateSettlementAuto();
        }
    }
    
    // Phương thức thêm dữ liệu cho bảng settlementuseradjust
    public function insertTbsettlementuseradjust($settid){
        for ($i=1; $i<6; $i++){
            $settlementuseradjust =[
                'settlementUserId' => $settid,
                'amount' => 0,
                'price' => 0,
                'supplyprice' => 0,
                'fee' => 0,
                'pos'=>$i               
            ];
            $this->_model->insertRecord('settlementuseradjusted', $settlementuseradjust);
        }
    }
//từ chối duyệt
    public function Deny_SettlementAjax(){
        $result['flag'] = false;
        // 1, chờ GĐ duyệt, 2 GĐ từ chối duyệt, 3 GĐ duyệt xong, 4 Duyệt xong
            $dataUpdate = [
                'status' => 2
            ];
            $status=2; 
        $updated_Data=$this->_model->updateRecord('settlementuser', $dataUpdate, ['id' => $this->_params['sid']]);
        $created = date('Y-m-d H:i:s', time());
        if($updated_Data != false){
                        $result['flag'] = true;
                        $aStatus = Helper::statusSettlementStatus($status);
                        $this->_model->insertRecord('settlementuserlog', [
                            'settlementuserId'=>$this->_params['sid'],
                            'content'=>$aStatus['name'],
                            'created'=>$created,
                            'created_by'=>Structure::getUserId(true),
                            'status' => $status
                        ]);
                    }
        if($updated_Data){
        $result['flag'] = true;
        }
        echo json_encode($result);
    } //End of Deny_Settlement

    public function Return_SettlementAjax(){
        $result['flag'] = false;
        // 1, chờ GĐ duyệt, 2 GĐ từ chối duyệt, 3 GĐ duyệt xong, 4 Duyệt xong
        $dataUpdate = [
            'status' => 1
        ];
        $status=2;
        $updated_Data=$this->_model->updateRecord('settlementuser', $dataUpdate, ['id' => $this->_params['sid']]);
        $created = date('Y-m-d H:i:s', time());
        if($updated_Data != false){
            $result['flag'] = true;
            $aStatus = Helper::statusSettlementStatus($status);
            $this->_model->insertRecord('settlementuserlog', [
                'settlementuserId'=>$this->_params['sid'],
                'content'=>$aStatus['name'],
                'created'=>$created,
                'created_by'=>Structure::getUserId(true),
                'status' => $status
            ]);
        }
        if($updated_Data){
            $result['flag'] = true;
        }
        echo json_encode($result);
    } //End of Deny_Settlement
     public function SettlementsellerdoneAjax(){
        $result['flag'] = false;
        // 1, chờ GĐ duyệt, 2 GĐ từ chối duyệt, 3 GĐ duyệt xong, 4 Duyệt xong
            $dataUpdate = [
                'status' => 3
            ];
            $status=3; 
        $updated_Data=$this->_model->updateRecord('settlementuser', $dataUpdate, ['id' => $this->_params['sid']]);
        $created = date('Y-m-d H:i:s', time());
        if($updated_Data != false){
                        $result['flag'] = true;
                        $aStatus = Helper::statusSettlementStatus($status);
                        $this->_model->insertRecord('settlementuserlog', [
                            'settlementuserId'=>$this->_params['sid'],
                            'content'=>$aStatus['name'],
                            'created'=>$created,
                            'created_by'=>Structure::getUserId(true),
                            'status' => $status
                        ]);
                    }
        //  if($updated_Data){
        // $result['flag'] = true;
        //     }
        echo json_encode($result);
    } //End of Deny_Settlement

    // Phương thức Upload Excel Chi phí điều chỉnh
    public function Upld_Settlement_excelAjax(){
        $result = ['flag' => false];
       
        if(isset($_FILES['fileupload']) && ($_FILES['fileupload']['error'] == 0)){
            $office = new OfficeExcel();
            $columns = [
                [
                    'title'=>'수량', //Số lượng
                    'key'=>'key1'
                ],
                [
                    'title'=>'판매가', //Giá bán
                    'key'=>'key2'
                ],
                [
                    'title'=>'공급가', //Giá cung
                    'key'=>'key3'
                ],
                [
                    'title'=>'수수료', //Phí
                    'key'=>'key4'
                ],  
            ];

            $dataExcel = $office->readUpld_Settlement($_FILES['fileupload']['tmp_name'],$columns);      
            if($dataExcel['success'] == true){
                $result['flag'] = true;
                $result['data'] = $this->Update_Upld_Settlement($dataExcel['data'],$this->_params['sid']);

               // Ghi vào bảng settlementuserlog
                if($result['data']){
                   $this->_model->insertRecord('settlementuserlog', Structure::settlementuserlog([
                    'settlementuserId'=>$this->_params['sid'],
                    'content'=>'l_revenue13',
                    'created'=>date('Y-m-d H:i:s', time()),
                    'created_by'=>Structure::getUserId(true)
                ]));
                }
                
                $settle_result = $this->_model->loadRecords("settlementuseradjusted",['settlementuserId'=>$this->_params['sid']]);
                $items = $this->_model->loadSettlementUserDetail($this->_params['sid']);
                // Xuat ket qua ra ngoai thong qua string.
                $str='';
                $amount=$pricetotal=$pricesupply=$feetotal=0;
                foreach ($items as $m => $value){
                        $amount+=$value['amount'];
                        $pricetotal+=($value['price']*$value['amount']);
                        $feetotal+=$value['feetotal'];
                        $pricesupply=$pricetotal-$feetotal;
                }
                $pricesupply=$pricetotal-$feetotal;               
                $co=0;
                $str='';
                foreach ($settle_result as $k=>$giatri) {
                 if($k==0){
                          $str .= '<tr>
                                    <td colspan="2" class="tbclsbg">총 판매금액</td>
                                    <td><b>'.$amount.'</b></td>
                                    <td><b>'.$pricetotal.'</b></td>
                                    <td><b>'.$pricesupply.'</b></td>
                                    <td><b>'.$feetotal.'</b></td>
                                   </tr>';}                       
                if($giatri['pos']==1){                   
                            $str .= '
                                    <tr>
                                    <td rowspan="5" class="tbclsbg" style="width: 100px;">조정금액</td>
                                    <td class="tbclsbg" style="width: 200px;">사용 후 취소/환불금액</td>
                                    <td>'.$giatri['amount'].'</td>
                                    <td>'.$giatri['price'].'</td>
                                    <td>'.$giatri['supplyprice'].'</td>
                                    <td>'.$giatri['fee'].'</td></tr>';} 
                if($giatri['pos']==2){
                            $str .= '<td class="tbclsbg" style="width: 200px;">선정산 금액</td>
                                    <td>'.$giatri['amount'].'</td>
                                    <td>'.$giatri['price'].'</td>
                                    <td>'.$giatri['supplyprice'].'</td>
                                    <td>'.$giatri['fee'].'</td></tr>';}
                if($giatri['pos']==3){
                            $str .= '<td class="tbclsbg" style="width: 200px;">취소위약금</td>
                                    <td>'.$giatri['amount'].'</td>
                                    <td>'.$giatri['price'].'</td>
                                    <td>'.$giatri['supplyprice'].'</td>
                                    <td>'.$giatri['fee'].'</td></tr>';}
                if($giatri['pos']==4){
                            $str .= '<td class="tbclsbg" style="width: 200px;">수수료 변경에 따른 판매가/공급가 조정항목</td>
                                    <td>'.$giatri['amount'].'</td>
                                    <td>'.$giatri['price'].'</td>
                                    <td>'.$giatri['supplyprice'].'</td>
                                    <td>'.$giatri['fee'].'</td></tr>';}            
                if($giatri['pos']==5){
                            $str .= '<td class="tbclsbg" style="width: 200px;">기타 조정금액</td>
                                    <td>'.$giatri['amount'].'</td>
                                    <td>'.$giatri['price'].'</td>
                                    <td>'.$giatri['supplyprice'].'</td>
                                    <td>'.$giatri['fee'].'</td></tr>';}
                $amount-=$giatri['amount'];
                $pricetotal-=$giatri['price'];
                $pricesupply-=$giatri['supplyprice'];
                $feetotal-=$giatri['fee'];
                    }//end of foreach                                
                $str .= '<td colspan="2">총 정산금액(총 판매금액-조정금)</td>
                         <td>'.$amount.'</td>
                         <td>'.$pricetotal.'</td>
                         <td>'.$pricesupply.'</td>
                         <td>'.$feetotal.'</td></tr>';                           
                $result['tabl']=$str;
            } 
        }
        echo json_encode($result);
    } //Function
    // + Them vao chi tiet dieu chinh quyet toan
    public function Update_Upld_Settlement($data,$sid){ 
        $str='';
        $dataUpdate=[];
        $i=1;
        foreach ($data as $value) {
            $dataUpdate = [
                'amount' => $value['key1'],
                'price' => $value['key2'],
                'supplyprice' => $value['key3'],
                'fee' => $value['key4']
            ];
        $this->_model->updateRecord('settlementuseradjusted', $dataUpdate, ['settlementuserId' => $sid, 'pos' => $i]);
        $i++;
        }         
    } //End of Upld_Settlement_excelAjax
}
?>