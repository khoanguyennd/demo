<?php

require PATH_ROOT . '/vendor2/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpClient\HttpClient;

class RestfulApiController extends Controller {
    protected $method = '';
    protected $endpoint = '';
    protected $params = array();
    protected $file = null;

    // Phương thức khởi tạo
    public function __construct($params) {
        parent::__construct($params);
    }

    // Phương thức index
    public function indexAction() {
        $start_date = date("Ymdhis");
        $request = new Request();
        $content = "";
        if ($request->getContent()) {
            $content = $request->getContent();
        }
        $default = [
            'sort' => [
                'column' => "id",
                'order' => "DESC"
            ],
            'limit' => [
                'position' => 0,
                'length' => 1
            ]
        ];
        $result = $this->_model->loadRecords('apiDVC', [], true, $default);
        $status = 0;
        if ($result[0]['status'] == 1) {
            $datajson = '{"rslt": "FAIL","sndTime": "' . $start_date . '"}';
            $status = 0;
        } else {
            $datajson = '{"rslt": "SUCCESS","sndTime": "' . $start_date . '"}';
            $status = 1;
        }
        $data = ['content' => $content, 'response' => $datajson, 'status' => $status];
        $this->_model->insertRecord('apiDVC', $data);
        header('Content-Type: application/json');
        echo $datajson;
    }

    public function logDVCAction() {
        $default = [
            'sort' => [
                'column' => "id",
                'order' => "DESC"
            ],
            'limit' => [
                'position' => 0,
                'length' => 50
            ]
        ];
        $result = $this->_model->loadRecords('apiDVC', [], true, $default);
        foreach ($result as $value => $giatri) {
            $data = json_decode($giatri['content'], true);
            echo '<pre>';
            print_r($data);
            echo '</pre>';

            $data = json_decode($giatri['response'], true);
            echo '<pre>';
            print_r($data);
            echo '</pre>
                
            <hr>';
        }
    }

    public function sendAction() {
        $data = '{	"sndDate":"20180717053933",
                "dvc": { "dvcId":"T01001002021", "sts":"1"},
                "cmrList":[
                    {"cmrId":"C01001002",  "sts":"1" },
                    {"cmrId":"C00001001","sts":"2"},
                    {"cmrId":"C01001003","sts":"1"}
                ]
        }';
        $url = "http://localhost:8000/RestfulApi/public/index.php/api/jsonData";
        $obj = $this->callAPI1("POST", $url, null);
        //$this -> callAPI("POST", "http://tbridge.lavianspa.com/restfulApi.html");
    }

    function callAPI1($method, $url, $data) {
        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        echo $url;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        print_r($result);
    }

    public function callAPI($method, $url) {
        $httpClient = HttpClient::create();

        $data = [
            'name' => 'khoa nguyen',
            'address' => '132 d2 P.25 Binh Thanh',
        ];
        if ($method === "POST")
            $response = $httpClient->request($method, $url, ['body' => $data]);
        else
            $response = $httpClient->request($method, $url);

        $statusCode = $response->getStatusCode();
        //echo $statusCode . "\n";
        $contentType = $response->getHeaders()['content-type'][0];
        //echo $contentType . "\n";

        return $response->getContent();
    }

    public function loginApiAction() {
        $request = new Request();
        $content = "";
        if ($request->getContent()) {
            $content = $request->getContent();
        }
        $data = json_decode($content, true);
        /* $data = [
          'username' => 'orchipro',
          'password' => '123456@a'
          ]; */

        $output = [
            'result' => false,
            'msg' => 'please check data input'
        ];
        $output['POST'] = $_POST;
        $method = $_SERVER['REQUEST_METHOD'];
        $data_result = [];
        if (isset($data['username']) && isset($data['password'])) {
            $username = $data['username'];
            $password = $data['password'];
            $login = $this->_model->loadRecord('user', [
                'ID' => $username,
                'password' => md5($password)
            ]);
            if ($login) {
                if ($login['status'] == 0) {
                    $output['msg'] = $this->_view->getItem('language', 'l_accountunactive');
                } else {
                    $output['result'] = true;
                    $output['msg'] = 'Login Successfully';
                    $data_result['account_idx'] = $login['idx'];
                    $data_result['account_ID'] = $login['ID'];
                    $data_result['account_role'] = $login['role'];
                }
            }
        } else {
            $output['msg'] = 'Missing data input';
        }
        $output['params'] = $this->_params;
        $output['data'] = $data_result;
        //$output['data_result'] = $data_result;
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    public function dashboardApiAction() {
        $s1 = microtime(true) ;
        $request = new Request();
        $content = "";
        if ($request->getContent()) {
            $content = $request->getContent();
        }
        $data = json_decode($content, true);
//        $data = [
//            'account_idx' => '20',
//            'account_ID' => 'orchipro',
//            'account_role' => 0,
//        ];

        $output = [
            'result' => false,
            //'msg' => 'please check data input'
        ];
        //$output['data'] = $data;

        //$method = $_SERVER['REQUEST_METHOD'];
        if (isset($data['account_idx']) && isset($data['account_ID']) && isset($data['account_role'])) {
            //get data
            $items = $this->_model->loadProduct($data['account_idx'], $data['account_ID'], $data['account_role']);
            $dashboard = [
                'productAmountUnuse' => [
                    'amount' => 0,
                    'url' => $this->route('order', ['method' => 'unuse'])
                ],
                'charjs' => [
                    'day' => []
                ]
            ];
            // Đơn hàng
            $item = $this->_model->countTicketsUnuse($data['account_idx'], $data['account_ID'], $data['account_role']);
            $dashboard['productAmountUnuse']['amount'] = $item['amount'];
            
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

            if ($data['account_role'] == 0) {
                
            } else {
                $sql .= ' AND (sp.creator="' . $data['account_ID'] . '" OR sp.creator IN (SELECT u2.ID
                                                                                         FROM tb_user u1 ,tb_user u2
                		                                                                 WHERE u1.ID = "' . $data['account_ID'] . '" AND u2.idx_parent=u1.idx) ) ';
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
            if ($data['account_role'] == 0) {
                
            } else {
                $sql .= ' AND (sp.creator="' . $data['account_ID'] . '" OR sp.creator IN ( SELECT u2.ID
			                                                                             FROM tb_user u1 ,tb_user u2
				                                                                         WHERE u1.ID = "' . $data['account_ID'] . '" AND u2.idx_parent=u1.idx) ) ';
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
            //tâm add thêm cho mobi
            $user_info = $this->_model->loadRecord('user', ['idx' => $data['account_idx']]);
            $default = ['limit' => ['position' => 0, 'length' => 5], 'sort' => ['column' => 'notification_created', 'order' => 'DESC']];
            $result = $this->_model->loadRecords('notifications', [], true, $default);
            foreach ($result as $r) {
                $data_noti[] = [   'notification_created' => date('y.m.d', $r['notification_created']), 
                                   'notification_title' => $r['notification_title'], 
                                   'notification_content' =>$r['notification_content']
                    
                ];
            }
            
            
            $sqlheader = 'SELECT tp.*,tk.statusTicket,tk.restoreTicket';
            $sqlcount = 'SELECT COUNT(tp.id) as record ';
            $sql = '  FROM `tb_ticket` tk,`tb_ticketPurchasers` tp
											LEFT JOIN tb_salechannel sc ON tp.dealId=sc.vendorItemPackageId
											LEFT JOIN tb_channeltypes ct ON sc.channelTypeId=ct.type_id
											LEFT JOIN tb_channels c ON ct.channelid=c.channel_id
											LEFT JOIN tb_sellerproduct sp ON sc.sellerProductId=sp.sellerProductId ';
            $sql .= ' WHERE tp.ticketNumber=tk.ticketNumber ';
            if ($data['account_role'] == 0) {
                
            } else {
                $sql .= " AND (sp.creator='" . $data['account_ID'] . "' OR sp.creator IN (SELECT u2.ID 
                                                                                        FROM tb_user u1 ,tb_user u2 
                                                                                        WHERE u1.ID = '" . $data['account_ID'] . "' AND u2.idx_parent=u1.idx) ) ";
            }


            $sql_muaxong = " AND tk.statusTicket=1 "; // mua xong
            $sql_sudung = " AND tk.statusTicket=2 "; // vé sử dụng
            //hom qua
            $get_thoigian = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
            $m_start = date("Y-m-d", $get_thoigian);
            $m_end = date("Y-m-d", $get_thoigian);
            $sql_homqua = ' AND tp.purchaseDateTime BETWEEN "' . $m_start . ' 00:00:00" AND "' . $m_end . ' 23:59:59" ';

            $homqua_show = date("m.d", $get_thoigian);
            $items_homqua_muaxong = $this->_model->loadOrder($sqlheader . $sql . $sql_muaxong . $sql_homqua, $sqlcount . $sql . $sql_muaxong . $sql_homqua, DEFAULT_LENGTH);
            $items_homqua_sudung = $this->_model->loadOrder($sqlheader . $sql . $sql_sudung . $sql_homqua, $sqlcount . $sql . $sql_sudung . $sql_homqua, DEFAULT_LENGTH);
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
            //doanh thu


            $sqlheader = "SELECT d.id as salechannelId,
                    			sum(IF(tk.statusTicket!=3, tk.totalAmount,0)) as quantitysoldreal,
                    			sum(IF(tk.statusTicket=2, tk.totalAmount,0)) as quantitysolduse,
                    			sum(IF(tk.statusTicket=3, tk.totalAmount,0)) quantitysoldcancel,
                    			sum(IF(tk.statusTicket!=3, tp.price,0)) as amountsoldreal,
                    			sum(IF(tk.statusTicket=2, tp.price,0)) as amountsolduse,
                    			sum(IF(tk.statusTicket=3, tp.price,0)) as amountsoldcancel  ";
            $sql = "    FROM  tb_ticket tk, tb_ticketPurchasers tp LEFT JOIN (SELECT sc.id , sc.vendorItemPackageId,sp.creator
																			FROM tb_salechannel sc,tb_channeltypes ct, tb_channels c, tb_sellerproduct sp, tb_user us
																			WHERE sc.channelTypeId=ct.type_id
																						AND ct.channelid=c.channel_id
																						AND sc.sellerProductId=sp.sellerProductId
																						AND sp.supplier=us.idx) d
														              ON d.vendorItemPackageId=tp.dealId
                
                        WHERE tp.ticketNumber=tk.ticketNumber ";
            if ($data['account_role'] == 0) {
                
            } else {
                $sql .= " AND (d.creator='" . $data['account_ID'] . "' OR d.creator IN (SELECT u2.ID
                                                                                          FROM tb_user u1 ,tb_user u2
                                                                                          WHERE u1.ID = '" . $data['account_ID'] . "' AND u2.idx_parent=u1.idx) ) ";
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
                                            SUM(quantitysoldreal) as quantitysoldrealtotal , SUM(amountsoldreal)  as amountsoldrealtotal,
                                            SUM(quantitysolduse) as quantitysoldusetotal , SUM(amountsolduse)  as amountsoldusetotal,
                                            SUM(quantitysoldcancel) as quantitysoldcanceltotal , SUM(amountsoldcancel)  as amountsoldcanceltotal
                                     FROM  ( " . $sqlheader . $sql . $sql_homqua . $sqlgroupby . " ) as tb_count");
            $result_homqua = $this->_model->readAll();

            $this->_model->setQuery("SELECT COUNT(salechannelId) as count, 
                                            SUM(quantitysoldreal) as quantitysoldrealtotal , SUM(amountsoldreal)  as amountsoldrealtotal,
                                            SUM(quantitysolduse) as quantitysoldusetotal , SUM(amountsolduse)  as amountsoldusetotal,
                                            SUM(quantitysoldcancel) as quantitysoldcanceltotal , SUM(amountsoldcancel)  as amountsoldcanceltotal
                                     FROM  ( " . $sqlheader . $sql . $sql_homnay . $sqlgroupby . " ) as tb_count");
            $result_homnay = $this->_model->readAll();

            $amountsoldrealtotal_homqua = $result_homqua[0]['amountsoldrealtotal'] ? $result_homqua[0]['amountsoldrealtotal'] : "0";
            $amountsoldrealtotal_homnay = $result_homnay[0]['amountsoldrealtotal'] ? $result_homnay[0]['amountsoldrealtotal'] : "0";
            $amountsoldusetotal_homqua = $result_homqua[0]['amountsoldusetotal'] ? $result_homqua[0]['amountsoldusetotal'] : "0";
            $amountsoldusetotal_hpmnay = $result_homnay[0]['amountsoldusetotal'] ? $result_homnay[0]['amountsoldusetotal'] : "0";
            //tong cau hoi
            $sqlheader = "SELECT q.*,d.*";
            $sql = ' FROM  `tb_question` q LEFT JOIN (SELECT  sc.travelProductId,sc.sellerProductId,sc.vendorItemPackageId,sp.supplier,sp.name
                                                                        FROM tb_salechannel sc, tb_sellerproduct sp
                                                                        WHERE sc.sellerProductId=sp.sellerProductId) d
                                            ON q.dealId=d.vendorItemPackageId
                     WHERE q.question_status=1  AND q.isDelete=0  ';

            $user_id = $data['account_idx'];
            if ($data['account_role'] != 0) {
                if ($data['account_role'] == 1) {
                    $res = $this->_model->setQuery('SELECT idx,idx_parent FROM `tb_user` WHERE idx=' . $user_id . ' OR idx_parent=' . $user_id);
                    $userncc = $this->_model->readAll();
                    $array_ncc = array();
                    foreach ($userncc as $rows_user) {
                        $array_ncc[] = $rows_user['idx'];
                    }
                    $sql .= " d.supplier IN (" . implode(',', $array_ncc) . ")";
                } elseif ($data['account_role'] == 2) {
                    $sql .= " d.supplier=" . $user_id;
                }
            }
            $this->_model->setQuery($sqlheader . $sql);
            $tongcauhoi = $this->_model->readAll();
            // end get data
            $output['result'] = TRUE;
            $output['company_name'] = $user_info['company'];
            $output['order_number'] = $dashboard['productAmountUnuse']['amount'];
            $output['question_number'] = count($tongcauhoi);

            $output['homqua_show'] = $homqua_show;
            $output['homnay_show'] = $homnay_show;

            $output['amountsoldrealtotal_homqua'] = $amountsoldrealtotal_homqua == "" ? 0 : $amountsoldrealtotal_homqua;
            $output['amountsoldrealtotal_homnay'] = $amountsoldrealtotal_homnay == "" ? 0 : $amountsoldrealtotal_homnay;
            $output['amountsoldusetotal_homqua'] = $amountsoldusetotal_homqua == "" ? 0 : $amountsoldusetotal_homqua;
            $output['amountsoldusetotal_hpmnay'] = $amountsoldusetotal_hpmnay == "" ? 0 : $amountsoldusetotal_hpmnay;

            $output['tong_muaxong_homqua'] = $tong_muaxong_homqua == "" ? 0 : $tong_muaxong_homqua;
            $output['tong_muaxong_homnay'] = $tong_muaxong_homnay == "" ? 0 : $tong_muaxong_homnay;
            $output['tong_sudung_homqua'] = $tong_sudung_homqua == "" ? 0 : $tong_sudung_homqua;
            $output['tong_sudung_homnay'] = $tong_sudung_homnay == "" ? 0 : $tong_sudung_homnay;

            $output['data11'] = $data11;
            $output['data22'] = $data22;
            $output['data33'] = $data33;
            $output['data44'] = $data44;
            $output['notifications'] = $data_noti;
        } else {
            //$output['msg'] = 'Missing data input';
        }
        $s2 = microtime(true) ;
        $output['time'] = ($s2-$s1);
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    public function orderApiAction() {
        $s1 = microtime(true) * 10000;
        $request = new Request();
        $content = "";
        if ($request->getContent()) {
            $content = $request->getContent();
        }
        $data = json_decode($content, true);

//          $search=[
//               "text_ten_phone_mave"=>"",
//               "thoigian"=>"1_2020-08-13_2020-08-13",
//               "checked_kenh"=>"all",
//               "check_ncc"=>"all"
//           ];
//           $data = [
//               'account_idx' => '20',
//               'account_ID' => 'orchipro',
//               'account_role' => 0,
//               'method' => '',
//               'page' => '1',
//               'datasearch' => $search
//           ]; 
        $output = [
            'result' => false,
            'msg' => 'please check data input'
        ];
        
        
        if (isset($data['account_idx']) && isset($data['account_ID']) && isset($data['account_role']) && isset($data['method']) && isset($data['page'])) {
            $sqlheader = 'SELECT tp.*,tk.statusTicket,tk.restoreTicket, sp.sellerProductId , sp.name  as productname';
            $sqlcount = 'SELECT COUNT(tp.id) as record ';
            $sql = ' FROM `tb_ticket` tk,`tb_ticketPurchasers` tp LEFT JOIN tb_salechannel sc ON tp.dealId=sc.vendorItemPackageId
											LEFT JOIN tb_channeltypes ct ON sc.channelTypeId=ct.type_id
											LEFT JOIN tb_channels c ON ct.channelid=c.channel_id
											LEFT JOIN tb_sellerproduct sp ON sc.sellerProductId=sp.sellerProductId ';
            $sql .= ' WHERE tp.ticketNumber=tk.ticketNumber ';
            if ($data['account_role'] == 0) {
                
            } else {
                $sql .= " AND (sp.creator='" . $data['account_ID'] . "' OR sp.creator IN (SELECT u2.ID FROM tb_user u1 ,tb_user u2
    			                                                                WHERE u1.ID = '" . $data['account_ID'] . "'
                                                                                 AND u2.idx_parent=u1.idx) ) ";
            }
            if ($data['method'] == 'unuse') {
                $sql .= ' AND tk.`statusTicket`=1';
            } elseif ($data['method'] == 'done') {
                $sql .= ' AND tk.`statusTicket`=1';
            } elseif ($data['method'] == 'use') {
                $sql .= ' AND tk.`statusTicket`=2';
            } elseif ($data['method'] == 'returnprice') {
                $sql .= ' AND tk.`statusTicket`=3';
            } elseif ($data['method'] == 'die') {
                $sql .= ' AND tk.`statusTicket`=-1';
            } elseif ($data['method'] == 'refundmoney') {
                $sql .= ' AND tk.`statusTicket`=-3';
            }
            //search            
            if (!empty($data['datasearch'])) {
                $text_ten_phone_mave = $data['datasearch']['text_ten_phone_mave'];
                if ($text_ten_phone_mave != "") {
                    $sql .= ' AND (sp.`name` LIKE "%' . $text_ten_phone_mave . '%" '
                            . 'OR tp.`dealName` LIKE "%' . $text_ten_phone_mave . '%" '
                            . 'OR tp.`phoneNumber` LIKE "%' . $text_ten_phone_mave . '%" '
                            . 'OR tp.`ticketNumber` LIKE "%' . $text_ten_phone_mave . '%")';
                }
                $thoigian = $data['datasearch']['thoigian'];
                $array_time = explode("_", $thoigian);
                $type_time = $array_time[0];
                $datestart = $array_time[1];
                $dateend = $array_time[2];
                if ($type_time == 0) {
                    $sql .= '';
                } elseif ($type_time == 1) {//hôm qua
                    $get_thoigian = mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"));
                    $m_start = date("Y-m-d", $get_thoigian);
                    $m_end = date("Y-m-d", $get_thoigian);
                    $sql .= ' AND tp.purchaseDateTime BETWEEN "' . $m_start . ' 00:00:00" AND "' . $m_end . ' 23:59:59" ';
                } elseif ($type_time == 2) {//hôm nay
                    $get_thoigian = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                    $m_start = date("Y-m-d", $get_thoigian);
                    $m_end = date("Y-m-d", $get_thoigian);
                    $sql .= ' AND tp.purchaseDateTime BETWEEN "' . $m_start . ' 00:00:00" AND "' . $m_end . ' 23:59:59" ';
                } elseif ($type_time == 3) {//7 ngày gần nhất
                    $get_thoigian = mktime(0, 0, 0, date("m"), date("d") - 7, date("Y"));
                    $m_start = date("Y-m-d", $get_thoigian);
                    $m_end = date("Y-m-d");
                    $sql .= ' AND tp.purchaseDateTime BETWEEN "' . $m_start . ' 00:00:00" AND "' . $m_end . ' 23:59:59" ';
                } elseif ($type_time == 4) {//1 tháng gần nhất
                    $get_thoigian = mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"));
                    $m_start = date("Y-m-d", $get_thoigian);
                    $m_end = date("Y-m-d");
                    $sql .= ' AND tp.purchaseDateTime BETWEEN "' . $m_start . ' 00:00:00" AND "' . $m_end . ' 23:59:59" ';
                } elseif ($type_time == 5) {//3 tháng gần nhất
                    $get_thoigian = mktime(0, 0, 0, date("m") - 3, date("d"), date("Y"));
                    $m_start = date("Y-m-d", $get_thoigian);
                    $m_end = date("Y-m-d");
                    $sql .= ' AND tp.purchaseDateTime BETWEEN "' . $m_start . ' 00:00:00" AND "' . $m_end . ' 23:59:59" ';
                } elseif ($type_time == 6) {//6 tháng gần nhất
                    $get_thoigian = mktime(0, 0, 0, date("m") - 6, date("d"), date("Y"));
                    $m_start = date("Y-m-d", $get_thoigian);
                    $m_end = date("Y-m-d");
                    $sql .= ' AND tp.purchaseDateTime BETWEEN "' . $m_start . ' 00:00:00" AND "' . $m_end . ' 23:59:59" ';
                } else {// nhập trực tiếp
                    $m_start = $datestart;
                    $m_end = $dateend;
                    $sql .= ' AND tp.purchaseDateTime BETWEEN "' . $m_start . ' 00:00:00" AND "' . $m_end . ' 23:59:59" ';
                }
                $checked_kenh = $data['datasearch']['checked_kenh'];
                if ($checked_kenh != "all") {
                    $sql .= " AND ( ";
                    $array_kenh = explode("_", $checked_kenh);
                    for ($i = 0; $i < count($array_kenh); $i++) {
                        $sql .= 'tp.`channel_name`="' . $array_kenh[$i] . '" OR ';
                    }
                    $sql = mb_substr($sql, 0, - 3);
                    $sql .= " ) ";
                }
                $check_ncc = $data['datasearch']['check_ncc'];
                if ($check_ncc != "all") {
                    $sql .= ' AND sp.supplier=' . $check_ncc . '';
                }
            }
            //echo $sqlheader.$sql;
            //end search
            $length = 50;
            $pageCurrent = $data['page'];
            $begin = ($pageCurrent - 1) * $length;
            $result = $this->_model->loadOrder($sqlheader . $sql, $sqlcount . $sql, $length, $begin);
            $output['result'] = TRUE;
            $result['page'] = $data['page'];
            $output['list_order'] = $result;
            
        } else {
            $output['msg'] = 'Missing data input';
        }
        $s2 = microtime(true) * 10000;
        $output['time'] = ($s2-$s1);
        header('Content-Type: application/json');
        echo json_encode($output);
        
        
    }

    public function questionApiAction() {
        $request = new Request();
        $content = "";
        if ($request->getContent()) {
            $content = $request->getContent();
        }
        $data = json_decode($content, true);
        /* $data = [
          'account_idx' => 88,
          'account_ID' => 123456,
          'account_role' => 0,
          'method' => 'unreply',
          'page' => '1',
          ]; */

        $output = [
            'result' => false,
            'msg' => 'please check data input'
        ];
        if (isset($data['account_idx']) && isset($data['account_ID']) && isset($data['account_role'])) {
            $sqlheader = "SELECT q.*,d.*";
            $sqlcount = 'SELECT COUNT(q.`question_id`) as record ';
            $sql = ' FROM `tb_question` q LEFT JOIN (SELECT sc.travelProductId,sc.sellerProductId,sc.productId,sp.supplier,sp.name
                                                FROM tb_salechannel sc,tb_sellerproduct sp
                                                WHERE sc.sellerProductId=sp.sellerProductId ) d
                                        ON q.dealId=d.productId ';
            $sql .= ' WHERE  isDelete=0 AND ';
            $user_id = $data['account_idx'];
            if ($data['account_role'] != 0) {
                if ($data['account_role'] == 1) {
                    //lay ds các ncc
                    $sql .= " AND d.supplier IN ( SELECT u.idx FROM `tb_user` u WHERE u.idx=$user_id OR u.idx_parent=$user_id)";
                } elseif ($data['account_role'] == 2) {
                    //nhà cung cấp
                    $sql .= " AND d.supplier=" . $user_id;
                }
            }
            $date = date("Y-m-d");
            $date = strtotime(date("Y-m-d", strtotime($date)) . "-2 months");
            $m_start = date("Y-m-d", $date);
            $m_end = date("Y-m-d");
            $m_supplier = 0;
            $m_status = 1;
            $m_key = 0;
            $m_name = "";
            if ($data['method'] == 'unreply') {
                $sql .= ' AND q.`question_status`=1 ';
            } else {
                $sql .= ' AND q.`question_status`=' . $m_status . ' ';
            }
            //$this->_model->setQuery($sqlheader.$sql);
            //$result = $this->_model->readAll();
            $length = 50;
            $pageCurrent = $data['page'];
            $begin = ($pageCurrent - 1) * $length;
            $result = $this->_model->loadQuestions($sqlheader . $sql, $sqlcount . $sql, $length, $begin);
            $output['result'] = TRUE;
            $output['list_question'] = $result;
        } else {
            $output['msg'] = 'Missing data input';
        }
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    public function QuestionChannelApiAction() {
        $request = new Request();
        $content = "";
        if ($request->getContent()) {
            $content = $request->getContent();
        }
        $data = json_decode($content, true);
        /* $data = [
          'account_idx' => 88,
          'account_ID' => 123456,
          'account_role' => 0,
          'channel_name' => 'WMAKE',
          'method' => 'unreply',
          'page' => '1',
          ]; */
        $output = [
            'result' => false,
            'msg' => 'please check data input'
        ];
        if (isset($data['account_idx']) && isset($data['account_ID']) && isset($data['account_role']) && isset($data['channel_name'])) {
            $sqlheader = "SELECT q.*,d.*";
            $sqlcount = 'SELECT COUNT(q.`question_id`) as record ';
            $sql = ' FROM `tb_question` q LEFT JOIN (SELECT sc.travelProductId,sc.sellerProductId,sc.productId,sp.supplier,sp.name
                                                FROM tb_salechannel sc,tb_sellerproduct sp
                                                WHERE sc.sellerProductId=sp.sellerProductId ) d
                                        ON q.dealId=d.productId ';
            $sql .= ' WHERE 1';
            $user_id = $data['account_idx'];
            if ($data['account_role'] != 0) {
                if ($data['account_role'] == 1) {
                    //lay ds các ncc
                    $sql .= " AND d.supplier IN ( SELECT u.idx FROM `tb_user` u WHERE u.idx=$user_id OR u.idx_parent=$user_id)";
                } elseif ($data['account_role'] == 2) {
                    //nhà cung cấp
                    $sql .= " AND d.supplier=" . $user_id;
                }
            }
            $date = date("Y-m-d");
            $date = strtotime(date("Y-m-d", strtotime($date)) . "-2 months");
            $m_start = date("Y-m-d", $date);
            $m_end = date("Y-m-d");
            $m_supplier = 0;
            $m_status = 1;
            $m_key = 0;
            $m_name = "";
            if ($data['method'] == 'unreply') {
                $sql .= ' AND q.`question_status`=1 ';
            } else {
                $sql .= ' AND q.`question_status`=' . $m_status . ' ';
            }
            if ($data['channel_name'] != "") {
                $sql .= " AND q.`channel_name` LIKE '" . $data['channel_name'] . "' ";
            }

            $length = 50;
            $pageCurrent = $data['page'];
            $begin = ($pageCurrent - 1) * $length;
            $result = $this->_model->loadQuestions($sqlheader . $sql, $sqlcount . $sql, $length, $begin);

            $output['result'] = TRUE;
            $output['list_question'] = $result;
        } else {
            $output['msg'] = 'Missing data input';
        }
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    public function channelApiAction() {
        $request = new Request();
        $content = "";
        if ($request->getContent()) {
            $content = $request->getContent();
        }
        $data = json_decode($content, true);
        /* $data = [
          'account_idx' => 88,
          'account_ID' => 123456,
          'account_role' => 0,
          ]; */
        $output = [
            'result' => false,
            'msg' => 'please check data input'
        ];
        if (isset($data['account_idx']) && isset($data['account_ID']) && isset($data['account_role'])) {
            $list_channel = $this->_model->loadRecords('channels');
            $this->_view->setData('list_channel', $list_channel);
            //$m_channel['all'] = "전체";
            foreach ($list_channel as $value => $giatri) {
                $m_channel[] = $giatri['channel_name'];
            }
          
            $output['channelApi'] = $m_channel;
            
            $all = [["idx" => "all", "company" => "전체"]];
            $list_supplier = $this->_model->loadSupplier($data['account_idx'], $data['account_role']);
            array_splice($list_supplier, 0, 0, $all);
            $output['nccApi'] = $list_supplier;
            
            $output['result'] = true;
            $output['msg'] = 'Successfull data ';
        }
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    public function nccApiAction() {
        $request = new Request();
        $content = "";
        if ($request->getContent()) {
            $content = $request->getContent();
        }
        $data = json_decode($content, true);
        /* $data = [
          'account_idx' => 88,
          'account_ID' => 123456,
          'account_role' => 1,
          ]; */
        $output = [
            'result' => false,
            'msg' => 'please check data input'
        ];
        if (isset($data['account_idx']) && isset($data['account_ID']) && isset($data['account_role'])) {
            $all = [["idx" => "all", "company" => "전체"]];
            $list_supplier = $this->_model->loadSupplier($data['account_idx'], $data['account_role']);
            array_splice($list_supplier, 0, 0, $all);
            $output['result'] = true;
            $output['data'] = $list_supplier;
            $output['msg'] = 'Successfull data ';
        }
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    public function changestatusApiAction() {
        $request = new Request();
        $content = "";
        if ($request->getContent()) {
            $content = $request->getContent();
        }
        $data = json_decode($content, true);
        /*$ticket = [];
        $ticket[] = array("id" => 382071413374, "status" => 2, "restore" => 0);
        $ticket[] = array("id" => 382071287772, "status" => 2, "restore" => 0);
        $data = [
            'account_idx' => 88,
            'account_ID' => 123456,
            'account_role' => 1,
            'array_ticket' => $ticket,
        ];
        echo "<pre>";
        print_r($data);

        if (count($data['array_ticket']) > 0) {
            for ($i = 0; $i < count($data['array_ticket']); $i++) {
                echo $data['array_ticket'][$i]['id'];
                echo $data['array_ticket'][$i]['status'];
                echo $data['array_ticket'][$i]['restore'];
                echo "<br/>";
            }
        }*/        
        $output = [
            'result' => false,
            'msg' => 'please check data input'
        ];
        if (isset($data['account_idx']) && isset($data['account_ID']) && isset($data['account_role']) && isset($data['array_ticket'])) {

            if (count($data['array_ticket']) > 0) {
                $j=0;
                for ($i = 0; $i < count($data['array_ticket']); $i++) {
                    $id=$data['array_ticket'][$i]['id'];
                    $status=$data['array_ticket'][$i]['status'];
                    $restore=$data['array_ticket'][$i]['restore'];
                    $result = $this->_model->loadRecord('ticket', ['ticketNumber' => $id]);
                    if($result){
                        $this->_model->changeStatusTicket($id, $status, $restore);
                        $j++;
                    }                    
                }
            }
            $output['result'] = true;
            $output['countupdate'] = count($data['array_ticket']);
            $output['countupdate_success'] = $j;
            $output['msg'] = 'Successfull data ';
        }
        header('Content-Type: application/json');
        echo json_encode($output);
    }

    function callAPITest($method, $url, $data) {

        $curl = curl_init();
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        //echo $url;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json;charset=UTF-8'
        ));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        //echo $result;
        return $result;
    }

    public function testApiAction() {
        $method = 'POST';
        $url = 'http://tbridge.lavianspa.com/dashboardApi.html';
        $data = [
            'account_idx' => '20',
            'account_ID' => 'orchipro',
            'account_role' => 0,
        ];
        // $search = [
        //     "text_ten_phone_mave" => "89",
        //     "thoigian" => "0_2020-08-13_2020-08-13",
        //     "checked_kenh" => "all",
        //     "check_ncc" => "all"
        // ];
        // $data = [
        //     'account_idx' => 88,
        //     'account_ID' => 123456,
        //     'account_role' => 0,
        //     'method' => '',
        //     'page' => '1',
        //     'datasearch' => $search
        // ];
        //
        echo '<pre>';
        print_r( json_decode($this->callAPITest($method, $url, json_encode($data)) ) );
    }

    public function sendmailApiAction() {
        echo "<pre>";
        print_r($_POST);
    }

//    public function testApiAction() {
//        $data = [
//             'lang' => 'vn',
//                'email' => 'hoangtamau@gmail.com',
//                'data' => 'aâ'
//        ];
//        
//        $url = 'http://175.126.100.209/mail/tbridge_sendproduct.php';
//        // Kiểm tra hình thức gửi email qua url
//        
//        // open connection
//        $ch = curl_init();
//        // set the url, number of POST vars, POST data
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//        
//        // execute post
//        $result = curl_exec($ch);
//        // close connection
//        curl_close($ch);
//        
//        echo $result;
//    }
}

?>