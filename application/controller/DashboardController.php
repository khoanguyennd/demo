<?php

class DashboardController extends Controller {

    // Phương thức khởi tạo
    public function __construct($params) {
        parent::__construct($params);
    }

    // Phương thức index
    public function indexAction() {
        $this->isLogin();
        $account = $_SESSION['accountshopping'];
        if ($account['temp'] == 1)
            Url::header($this->route('account') . "#tab1");

        
        $items = $this->_model->loadProduct();
        
        $dashboard = [
            'productTotal' => [
                'amount' => 0,
                'url' => $this->route('listproduct', ['method' => 'insale'])
            ],
            'productEnd' => [
                'amount' => 0,
                'url' => $this->route('listproduct', ['method' => 'endsale'])
            ],
            'productStart' => [
                'amount' => 0,
                'url' => $this->route('listproduct', ['method' => 'onsale'])
            ],
            'productAmountToday' => [
                'amount' => 0,
                'url' => $this->route('order', ['method' => 'today'])
            ],
            'productAmountUnuse' => [
                'amount' => 0,
                'url' => $this->route('order', ['method' => 'unuse'])
            ],
            'revenueNotOrder' => [
                'amount' => 0,
                'url' => $this->route('listproduct', ['method' => 'notorder'])
                //'url' => $this->route('revenuedetail', ['method' => 'notorder'])
            ],
            'questionNotReply' => [
                'amount' => 0,
                'url' => $this->route('question', ['method' => 'unreply'])
            ],
            'charjs' => [
                'day' => []
            ]
        ];
        if ($items) {
            $created = strtotime(date('Y-m-d', time()));
            foreach ($items as $value) {
                if ($value['status'] == 2) {
                    // Số sản phẩm thời gian thực
                    $dashboard['productTotal']['amount'] += 1;
                    if (strtotime($value['useEndedAt']) == $created) {
                        //Số sản phẩm sắp kết thúc
                        $dashboard['productEnd']['amount'] += 1;
                    }
                } else { // 3
                    // Số sản phẩm sắp mở
                    $dashboard['productStart']['amount'] += 1;
                }
            }
        }
        // Đơn hàng
        $item = $this->_model->countTicketsToday(date('Y-m-d', time()));
        $dashboard['productAmountToday']['amount'] = $item['amount'];
        $item = $this->_model->countTicketsUnuse();
        $dashboard['productAmountUnuse']['amount'] = $item['amount'];
        // Danh thu
        $item = $this->_model->countRevenue();
        $dashboard['revenueNotOrder']['amount'] = $item['amount'];
        // Câu hỏi
        $item = $this->_model->countQuestion();
        $dashboard['questionNotReply']['amount'] = $item['amount'];
        // Charjs
        $timed1 = strtotime("-7 days");
        $timed2 = strtotime("-14 days");
        $daytime = 60 * 60 * 24;
        $data1 = [];
        $data2 = [];
        $data3 = [];
        $data4 = [];
        for ($i = 1; $i < 8; $i++) {
            $dashboard['charjs']['day'][] = date('m/d', $timed1 + $daytime * $i);
            $data1[date('Y-m-d', $timed1 + $daytime * $i)] = 0;
            $data2[date('Y-m-d', $timed2 + $daytime * $i)] = 0;
            $data3[date('Y-m-d', $timed1 + $daytime * $i)] = 0;
            $data4[date('Y-m-d', $timed2 + $daytime * $i)] = 0;
        }
        $sql = 'SELECT DATE_FORMAT(t.purchasedAt,"%Y-%m-%d") date, COUNT(tp.ticketNumber) amount
              FROM tb_ticket t,tb_ticketPurchasers tp 
                                LEFT JOIN tb_salechannel sc ON tp.dealId=sc.vendorItemPackageId 
                                LEFT JOIN tb_sellerproduct sp ON sc.sellerProductId=sp.sellerProductId
              WHERE tp.ticketNumber = t.ticketNumber AND t.statusTicket!=3 ';
        $account = $_SESSION['accountshopping'];
        if ($account['role'] == 0) {
            
        } else {
//             $sql .= ' AND (sp.creator="' . $account['ID'] . '" OR sp.creator IN (SELECT u2.ID
//                                                                          FROM tb_user u1 ,tb_user u2
// 		                                                                 WHERE u1.ID = "' . $account['ID'] . '" AND u2.idx_parent=u1.idx) ) ';
            
            $sql.= " AND (sp.supplier='".$account['idx']."' OR sp.supplier IN (SELECT u2.idx FROM tb_user u1 ,tb_user u2
								                                                WHERE u1.idx = '".$account['idx']."' AND u2.idx_parent=u1.idx) ) ";
        }
        $sql .= ' GROUP BY date';
        
        $this->_model->setQuery($sql);
        $result = $this->_model->readAll();
        foreach ($result as $value => $giatri) {
            foreach ($data1 as $value1 => $giatri1) {
                if ($value1 == $giatri['date'])
                    $data1[$giatri['date']] = $giatri['amount'];
            }
            foreach ($data2 as $value2 => $giatri2) {
                if ($value2 == $giatri['date'])
                    $data2[$giatri['date']] = $giatri['amount'];
            }
        }
        $data11 = [];
        foreach ($data1 as $value1 => $giatri1) {
            $data11[] = $giatri1;
        }
        $data22 = [];
        foreach ($data2 as $value2 => $giatri2) {
            $data22[] = $giatri2;
        }
        
        
        
        
        $sql = 'SELECT DATE_FORMAT(t.modifiedTicket,"%Y-%m-%d") date, COUNT(tp.ticketNumber) amount
                  FROM tb_ticket t,tb_ticketPurchasers tp 
                                LEFT JOIN tb_salechannel sc ON tp.dealId=sc.vendorItemPackageId 
                                LEFT JOIN tb_sellerproduct sp ON sc.sellerProductId=sp.sellerProductId
                  WHERE tp.ticketNumber = t.ticketNumber AND t.statusTicket=2 ';
        $account = $_SESSION['accountshopping'];
        if ($account['role'] == 0) {
            
        } else {
//             $sql .= ' AND (sp.creator="' . $account['ID'] . '" OR sp.creator IN (SELECT u2.ID
// 			                                                                         FROM tb_user u1 ,tb_user u2
// 					                                                                 WHERE u1.ID = "' . $account['ID'] . '" AND u2.idx_parent=u1.idx) ) ';
            
            $sql.= " AND (sp.supplier='".$account['idx']."' OR sp.supplier IN (SELECT u2.idx FROM tb_user u1 ,tb_user u2
								                                                WHERE u1.idx = '".$account['idx']."' AND u2.idx_parent=u1.idx) ) ";
            
        }
        $sql .= ' GROUP BY date';
        
        $this->_model->setQuery($sql);
        $result = $this->_model->readAll();
        foreach ($result as $value => $giatri) {
            foreach ($data3 as $value1 => $giatri1) {
                if ($value1 == $giatri['date'])
                    $data3[$giatri['date']] = $giatri['amount'];
            }
            foreach ($data4 as $value2 => $giatri2) {
                if ($value2 == $giatri['date'])
                    $data4[$giatri['date']] = $giatri['amount'];
            }
        }
        $data33 = [];
        foreach ($data3 as $value1 => $giatri1) {
            $data33[] = $giatri1;
        }
        $data44 = [];
        foreach ($data4 as $value2 => $giatri2) {
            $data44[] = $giatri2;
        }



        $this->_view->setData('data11', $data11);
        $this->_view->setData('data22', $data22);
        $this->_view->setData('data33', $data33);
        $this->_view->setData('data44', $data44);
        // Set data
        $this->_view->setData('charjs', $dashboard['charjs']);
        $this->_view->setData('revenueNotOrder', $dashboard['revenueNotOrder']);
        $this->_view->setData('questionNotReply', $dashboard['questionNotReply']);
        $this->_view->setData('productTotal', $dashboard['productTotal']);
        $this->_view->setData('productEnd', $dashboard['productEnd']);
        $this->_view->setData('productStart', $dashboard['productStart']);
        $this->_view->setData('productAmountToday', $dashboard['productAmountToday']);
        $this->_view->setData('productAmountUnuse', $dashboard['productAmountUnuse']);
        //tâm add thêm cho mobi
        $user_info = $this->_model->loadRecord('user', [
            'idx' => $_SESSION['accountshopping']['idx']
        ]);
        $default = [
            'limit' => ['position' => 0, 'length' => 5],
            'sort' => ['column' => 'notification_created', 'order' => 'DESC']
        ];
        $result = $this->_model->loadRecords('notifications', [], true, $default);
        $sqlheader = 'SELECT tp.*,tk.statusTicket,tk.restoreTicket';
        $sqlcount = 'SELECT COUNT(tp.id) as record ';
        $sql = '  FROM `tb_ticket` tk,`tb_ticketPurchasers` tp 
											LEFT JOIN tb_salechannel sc ON tp.dealId=sc.vendorItemPackageId
											LEFT JOIN tb_channeltypes ct ON sc.channelTypeId=ct.type_id
											LEFT JOIN tb_channels c ON ct.channelid=c.channel_id
											LEFT JOIN tb_sellerproduct sp ON sc.sellerProductId=sp.sellerProductId';
        $sql .= ' WHERE tp.ticketNumber=tk.ticketNumber ';
        if ($account['role'] == 0) {
            
        } else {
            //$sql .= " AND (sp.creator='" . $account['ID'] . "' OR sp.creator IN (SELECT u2.ID FROM tb_user u1 ,tb_user u2 WHERE u1.ID = '" . $account['ID'] . "' AND u2.idx_parent=u1.idx) ) ";
            
            $sql.= " AND (sp.supplier='".$account['idx']."' OR sp.supplier IN (SELECT u2.idx FROM tb_user u1 ,tb_user u2
								                                                WHERE u1.idx = '".$account['idx']."' AND u2.idx_parent=u1.idx) ) ";
        }
        $sql_muaxong = "AND tk.statusTicket=1"; // mua xong
        $sql_sudung = "AND tk.statusTicket=2"; // vé sử dụng
        //hom qua
        $get_thoigian = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
        $m_start = date("Y-m-d", $get_thoigian);
        $m_end = date("Y-m-d", $get_thoigian);
        $sql_homqua = ' AND tp.purchaseDateTime BETWEEN "' . $m_start . ' 00:00:00" AND "' . $m_end . ' 23:59:59" ';
        $homqua_show = date("m.d", $get_thoigian);
        $items_homqua_muaxong = $this->_model->loadOrder($sqlheader . $sql . $sql_muaxong . $sql_homqua, $sqlcount . $sql . $sql_muaxong . $sql_homqua, DEFAULT_LENGTH);
        $items_homqua_sudung = $this->_model->loadOrder($sqlheader . $sql . $sql_sudung . $sql_homqua, $sqlcount . $sql . $sql_sudung . $sql_homqua, DEFAULT_LENGTH);
       ;
        
        $tong_muaxong_homqua = $items_homqua_muaxong['count'];
        $tong_sudung_homqua = $items_homqua_sudung['count'];
        //hom nay
        $get_thoigian = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $m_start = date("Y-m-d", $get_thoigian);
        $m_end = date("Y-m-d", $get_thoigian);
        $sql_homnay = ' AND tp.purchaseDateTime BETWEEN "' . $m_start . ' 00:00:00" AND "' . $m_end . ' 23:59:59" ';
        $homnay_show = date("m.d", $get_thoigian);
        $items_homnay_muaxong = $this->_model->loadOrder($sqlheader . $sql . $sql_muaxong . $sql_homnay, $sqlcount . $sql . $sql_muaxong . $sql_homnay, DEFAULT_LENGTH);
        $items_homnay_sudung = $this->_model->loadOrder($sqlheader . $sql . $sql_sudung . $sql_homnay, $sqlcount . $sql . $sql_sudung . $sql_homnay, DEFAULT_LENGTH);
        $tong_muaxong_homnay = $items_homnay_muaxong['count'];
        $tong_sudung_homnay = $items_homnay_sudung['count'];

        $this->_view->setData('company', $user_info['company']);
        $this->_view->setData('notification_mobi', $result);

        $this->_view->setData('homqua_show', $homqua_show);
        $this->_view->setData('tong_muaxong_homqua', $tong_muaxong_homqua);
        $this->_view->setData('tong_sudung_homqua', $tong_sudung_homqua);

        $this->_view->setData('homnay_show', $homnay_show);
        $this->_view->setData('tong_muaxong_homnay', $tong_muaxong_homnay);
        $this->_view->setData('tong_sudung_homnay', $tong_sudung_homnay);

        //doanh thu
        $sqlheader = "SELECT d.id as salechannelId,
                    			sum(IF(tk.statusTicket!=3, tk.totalAmount,0)) as quantitysoldreal,
                    			sum(IF(tk.statusTicket=2, tk.totalAmount,0)) as quantitysolduse,
                    			sum(IF(tk.statusTicket=3, tk.totalAmount,0)) quantitysoldcancel,
                    			sum(IF(tk.statusTicket!=3, tp.price,0)) as amountsoldreal,
                    			sum(IF(tk.statusTicket=2, tp.price,0)) as amountsolduse,
                    			sum(IF(tk.statusTicket=3, tp.price,0)) as amountsoldcancel  ";
            $sql = "    FROM  tb_ticket tk, tb_ticketPurchasers tp LEFT JOIN (SELECT sc.id , sc.vendorItemPackageId,sp.supplier
																			FROM tb_salechannel sc,tb_channeltypes ct, tb_channels c, tb_sellerproduct sp, tb_user us
																			WHERE sc.channelTypeId=ct.type_id
																						AND ct.channelid=c.channel_id
																						AND sc.sellerProductId=sp.sellerProductId
																						AND sp.supplier=us.idx) d
														              ON d.vendorItemPackageId=tp.dealId 
                        
                        WHERE tp.ticketNumber=tk.ticketNumber ";
        
//         c.channel_name as channelname,
//         sp.`supplier` as supplierid,
//         us.ID as suppliername,
//         sp.`name` as productname,
//         sc.`status`,
//         DATE_FORMAT(sc.useStartedAt, \"%Y-%m-%d\") useStartedAt,
//                 				DATE_FORMAT(sc.useEndedAt, \"%Y-%m-%d\") useEndedAt,
        if ($account['role'] == 0) {
            
        } else {
//             $sql .= " AND (d.creator='" . $account['ID'] . "' OR   d.creator IN ( SELECT u2.ID
//                                                                                   FROM tb_user u1 ,tb_user u2
//                                                                                   WHERE u1.ID = '" . $account['ID'] . "' AND u2.idx_parent=u1.idx) ) ";
            $sql.= " AND (d.supplier='".$account['idx']."' OR d.supplier IN (SELECT u2.idx FROM tb_user u1 ,tb_user u2
								                                                WHERE u1.idx = '".$account['idx']."' AND u2.idx_parent=u1.idx) ) ";
        }
        $get_thoigian = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
        $m_start = date("Y-m-d", $get_thoigian);
        $m_end = date("Y-m-d", $get_thoigian);
        $sql_homqua = " AND ( tp.purchaseDateTime >='$m_start 00:00:00' AND tp.purchaseDateTime <='$m_end 23:59:59' ) ";
        $get_thoigian = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $m_start = date("Y-m-d", $get_thoigian);
        $m_end = date("Y-m-d", $get_thoigian);
        $sql_homnay = " AND ( tp.purchaseDateTime >='$m_start 00:00:00' AND tp.purchaseDateTime <='$m_end 23:59:59' ) ";

        $sqlgroupby = " GROUP BY d.id ";

        $this->_model->setQuery("SELECT COUNT(salechannelId) as count, 
                                        SUM(quantitysoldreal) as quantitysoldrealtotal , 
                                        SUM(amountsoldreal)  as amountsoldrealtotal,
                                        SUM(quantitysolduse) as quantitysoldusetotal , 
                                        SUM(amountsolduse)  as amountsoldusetotal,
                                        SUM(quantitysoldcancel) as quantitysoldcanceltotal ,
                                        SUM(amountsoldcancel)  as amountsoldcanceltotal
                                 FROM  ( " . $sqlheader . $sql . $sql_homqua . $sqlgroupby . " ) as tb_count");
        $result_homqua = $this->_model->readAll();

        $this->_model->setQuery("SELECT COUNT(salechannelId) as count, 
                                        SUM(quantitysoldreal) as quantitysoldrealtotal , SUM(amountsoldreal)  as amountsoldrealtotal,
                                        SUM(quantitysolduse) as quantitysoldusetotal , 
                                        SUM(amountsolduse)  as amountsoldusetotal,
                                        SUM(quantitysoldcancel) as quantitysoldcanceltotal , 
                                        SUM(amountsoldcancel)  as amountsoldcanceltotal
                                FROM  ( " . $sqlheader . $sql . $sql_homnay . $sqlgroupby . " ) as tb_count");
        $result_homnay = $this->_model->readAll();

        $this->_view->setData('amountsoldrealtotal_homqua', $result_homqua[0]['amountsoldrealtotal']);
        $this->_view->setData('amountsoldusetotal_homqua', $result_homqua[0]['amountsoldusetotal']);

        $this->_view->setData('amountsoldrealtotal_homnay', $result_homnay[0]['amountsoldrealtotal']);
        $this->_view->setData('amountsoldusetotal_hpmnay', $result_homnay[0]['amountsoldusetotal']);
        
        //end doanh thu        
        //tong cau hoi
        $sqlheader = "SELECT q.*,d.*";
        $sql = ' FROM  `tb_question` q LEFT JOIN (SELECT  sc.travelProductId,sc.sellerProductId,sc.vendorItemPackageId,sp.supplier,sp.name
                                                                        FROM tb_salechannel sc, tb_sellerproduct sp
                                                                        WHERE sc.sellerProductId=sp.sellerProductId) d
                                            ON q.dealId=d.vendorItemPackageId
                     WHERE q.question_status=1 AND q.isDelete=0 ';
        $user_id = $account['idx'];
        if ($account['role'] != 0) {
            if ($account['role'] == 1) {
                //lay ds các ncc  
                $res = $this->_model->setQuery('SELECT idx,idx_parent FROM `tb_user` WHERE idx=' . $user_id . ' OR idx_parent=' . $user_id);
                $userncc = $this->_model->readAll();
                $array_ncc = array();
                foreach ($userncc as $rows_user) {
                    $array_ncc[] = $rows_user['idx'];
                }
                $sql .= " AND d.supplier IN (" . implode(',', $array_ncc) . ")";
            } elseif ($account['role'] == 2) {
                //nhà cung cấp
                $sql .= " AND d.supplier=" . $user_id;
            }
        }
        
        $this->_model->setQuery($sqlheader.$sql);
        $tongcauhoi = $this->_model->readAll();
        
       
        
        if ($_SESSION['mobile'] != 0) {
            $this->_view->setData('tongcauhoi', count($tongcauhoi));
            $this->_view->setFileTemplate('web', 'temple_mobile');
            $this->_view->render('index_mobi');
        } else {
            $this->_view->render('index');
        }
    }

    // Trang chủ
    public function homeAction(){	
        if($_SESSION['mobile']!=0){
            Url::header($this->route('dashboard'));
        }
        $this->isLogin(true);	
            $this->_view->setFileTemplate('home'); 
            $this->_view->render('home');
    }

}

?>