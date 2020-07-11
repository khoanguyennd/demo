<?php
require PATH_ROOT . '/vendor1/autoload.php';
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;

require PATH_ROOT . '/vendor/autoload.php';
use Google\Cloud\Storage\StorageClient;

class TmonController extends Controller {

    // Phương thức khởi tạo
    public function __construct($params) {
        parent::__construct($params);
    }
  
    public function register_stream_wrapper($projectId) {
        $client = new StorageClient(['projectId' => $projectId]);
        $client->registerStreamWrapper();
    }

    // Phương thức index
    public function indexAction() {
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('POST', 'https://ps.tmon.co.kr');

        $form = $crawler->selectButton("로그인")->form();
        $crawler = $client->submit($form, array(
            'secureLogin' => false,
            'install_nos' => 'Y',
            'login_id' => '티브리지',
            'passwd' => 'coupang135!'));
        $crawler = $client->click($crawler->selectLink('다음에 변경하기')->link());
        $crawler = $client->click($crawler->selectLink('사용∙처리내역')->link());
        $crawler_buylist = $client->click($crawler->selectLink('구매내역')->link());

        $start_date = (date("Y") - 1) . "." . date("m.d");
        $end_date = date("Y.m.d");
        $crawler = $client->request('GET', 'https://ps.tmon.co.kr/daily/buylist?excel=Y&main_deal_srl=1957699002%2C1850249946&deal_srl=&branch_srl=&status_type=AV&page=1&ticket_status_type=ALL&mbiz_yn=N&simple_search=N&deal_start_date=&dealType=AV&use_date=%EC%82%AC%EC%9A%A9%EC%9D%BC&start_date=' . $start_date . '&end_date=' . $end_date . '&searchKey=phone_number&searchVal=');
        //https://ps.tmon.co.kr/daily/buylist?excel=Y&main_deal_srl=3458517230%2C3453097426%2C3419164362%2C2748997650%2C2763873162%2C2743756794%2C2742079898%2C2736868354%2C2661681598%2C2573836258%2C2572876002%2C2545678134%2C2389016678%2C2362594582%2C2362504322%2C2005358110%2C1957699002%2C1917435262%2C1880009050%2C1879575974%2C1850249946%2C1834866614&deal_srl=&branch_srl=&status_type=ALL&page=1&ticket_status_type=ALL&mbiz_yn=N&simple_search=N&deal_start_date=&dealType=AV&use_date=%EC%82%AC%EC%9A%A9%EC%9D%BC&start_date=2019.07.06&end_date=2020.07.06&searchKey=phone_number&searchVal=
        // header('Content-Type: application/json');
        $response = $client->getResponse();
        $content = $response->getContent();
        //file_put_contents('gs://klkim-project.appspot.com/buylist.xlsx', $content);
        $this->register_stream_wrapper("klkim-project");
        $fp = fopen("gs://klkim-project.appspot.com/buylist.xlsx", 'w');
        fwrite($fp, $content);
        fclose($fp);
    }

    // Phương thức readBuylist
    public function readBuylistAction() {
        require_once PATH_PLUGINS . 'PHPExcel/PHPExcel/IOFactory.php';
        require_once PATH_PLUGINS . 'PHPExcel/PHPExcel.php';

        $url = "https://klkim-project.appspot.com.storage.googleapis.com/buylist.xls";
        $filecontent = file_get_contents($url);
        $tmpfname = tempnam(sys_get_temp_dir(), "tmpxls");
        file_put_contents($tmpfname, $filecontent);

        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
        $objPHPExcel = $excelReader->load($tmpfname);

        $sheet = $objPHPExcel->getSheet(0);
        $Totalrow = $sheet->getHighestRow();
        $data = [];
        for ($i = 4; $i <= $Totalrow; $i++) {
            $data[$i - 4]["1"] = $sheet->getCell('A' . $i)->getValue()->getPlainText();  // mã đơn hàng
            $data[$i - 4]["2"] = $sheet->getCell('B' . $i)->getValue()->getPlainText();  // mã vé
            $data[$i - 4]["3"] = $sheet->getCell('C' . $i)->getValue()->getPlainText();  // Tên người đặt
            $data[$i - 4]["4"] = $sheet->getCell('D' . $i)->getValue()->getPlainText();  // Số điện thoại người đặt
            $data[$i - 4]["5"] = $sheet->getCell('E' . $i)->getValue()->getPlainText();  // Email người đặt
            $data[$i - 4]["6"] = $sheet->getCell('F' . $i)->getValue()->getPlainText();  // Tên người nhận (null)
            $data[$i - 4]["7"] = $sheet->getCell('G' . $i)->getValue()->getPlainText();  // Số điện thoại người nhận (null)
            $data[$i - 4]["8"] = $sheet->getCell('H' . $i)->getValue()->getPlainText();  // Email người nhận (null)
            $data[$i - 4]["9"] = $sheet->getCell('I' . $i)->getValue()->getPlainText();  // Mã deal
            $data[$i - 4]["10"] = $sheet->getCell('J' . $i)->getValue()->getPlainText(); // Tên deal
            $data[$i - 4]["11"] = $sheet->getCell('K' . $i)->getValue()->getPlainText(); // Tên option
            $data[$i - 4]["12"] = $sheet->getCell('L' . $i)->getValue()->getPlainText(); // số tiền mua
            $data[$i - 4]["13"] = $sheet->getCell('M' . $i)->getValue()->getPlainText(); // số tiền giảm
            $data[$i - 4]["14"] = $sheet->getCell('N' . $i)->getValue()->getPlainText(); // giá cung cấp
            $data[$i - 4]["15"] = $sheet->getCell('O' . $i)->getValue();                 // tỷ lệ phí
            $data[$i - 4]["16"] = $sheet->getCell('P' . $i)->getValue()->getPlainText(); // Trạng thái vé
            $data[$i - 4]["17"] = $sheet->getCell('Q' . $i)->getValue()->getPlainText(); // Trạng thái đặt
            $data[$i - 4]["18"] = $sheet->getCell('R' . $i)->getValue()->getPlainText(); // Thời gian mua
            if ($sheet->getCell('S' . $i)->getValue())
                $data[$i - 4]["19"] = $sheet->getCell('S' . $i)->getValue()->getPlainText();
            else
                $data[$i - 4]["19"] = $sheet->getCell('S' . $i)->getValue();            // Thời gian sử dụng
            $data[$i - 4]["20"] = $sheet->getCell('T' . $i)->getValue()->getPlainText(); // Ghi chú
            $data[$i - 4]["21"] = $sheet->getCell('U' . $i)->getValue()->getPlainText(); // Tên option 1
            $data[$i - 4]["22"] = $sheet->getCell('V' . $i)->getValue()->getPlainText(); // Tên option 2
            $data[$i - 4]["23"] = $sheet->getCell('W' . $i)->getValue()->getPlainText(); // Tên option 3
            $data[$i - 4]["24"] = $sheet->getCell('X' . $i)->getValue()->getPlainText(); // Tên option 4
            $data[$i - 4]["25"] = $sheet->getCell('Y' . $i)->getValue()->getPlainText(); // Tên option 5
        }
        foreach ($data as $key => $value) {
            $statusTicket = 1;
            //사용가능 có sẵn  사용완료 hoàn thành 입금대기 chờ gởi tiền
            if ($value[16] == '사용가능')
                $statusTicket = 1;
            if ($value[16] == '사용완료')
                $statusTicket = 2;
            if ($value[16] == '입금대기')
                $statusTicket = 1;
            $ticket = [
                'useAmount' => 0,
                'totalAmount' => 1,
                'ticketNumber' => $value[2],
                'statusType' => $value[16],
                'price' => $value[12],
                'optionId' => 0,
                'dealId' => $value[9],
                'purchasedAt' => $value[18],
                'restoreTicket' => 1,
                'statusTicket' => $statusTicket
            ];
            //'canceledAt' => $value[18],
            $result1 = $this->_model->loadRecord('ticket', ['ticketNumber' => $value[2]]);
            if ($result1) {
                $this->_model->updateRecord('ticket', $ticket, ['ticketNumber' => $value[2]]);
            } else {
                $this->_model->insertRecord('ticket', $ticket);
            }
            $ticketPurchasers = [
                'orderNumber' => $value[1],
                'ticketNumber' => $value[2],
                'userName' => $value[3],
                'phoneNumber' => $value[4],
                'email' => $value[5],
                'dealId' => $value[9],
                'dealName' => $value[10],
                'optionId' => 0,
                'optionName' => $value[11],
                'price' => $value[12],
                'purchaseDateTime' => $value[18],
                'status' => $value[17]
            ];
            //'canceledDateTime' => $value[9],
            $result2 = $this->_model->loadRecord('ticketPurchasers', ['ticketNumber' => $value[2]]);
            if ($result2) {
                $this->_model->updateRecord('ticketPurchasers', $ticketPurchasers, ['ticketNumber' => $value[2]]);
            } else {
                $this->_model->insertRecord('ticketPurchasers', $ticketPurchasers);
            }
        }
    }
    // Phương thức cancel
    public function cancelAction() {
        set_time_limit(500);
        $client = new Client(HttpClient::create(['timeout' => 600]));
        $crawler = $client->request('POST', 'https://ps.tmon.co.kr');
        $form = $crawler->selectButton("로그인")->form();
        $crawler = $client->submit($form, array(
            'secureLogin' => false,
            'install_nos' => 'Y',
            'login_id' => '티브리지',
            'passwd' => 'coupang135!'));
        $crawler = $client->click($crawler->selectLink('다음에 변경하기')->link());
        $crawler = $client->click($crawler->selectLink('사용∙처리내역')->link());
        $start_date = (date("Y") - 1) . "." . date("m.d");
        $end_date = date("Y.m.d");
        $crawler = $client->request('GET', 'https://ps.tmon.co.kr/daily/cancelTicketList?main_deal_srl=1957699002%2C1850249946&deal_srl=&branch_srl=&status_type=AV&page=1&ticket_status_type=ALL&mbiz_yn=N&simple_search=N&deal_start_date=&dealType=AV&use_date=%EC%82%AC%EC%9A%A9%EC%9D%BC&start_date=' . $start_date . '&end_date=' . $end_date . '&searchKey=phone_number&searchVal=&_=1593571258362');
        // $html_string = $crawler->outerHtml();
        //$pieces_mang = explode('<input type="hidden" id="totalCount" value="', $html_string);
        $totalCount= $crawler->filter('#totalCount')->each(function (Crawler $node, $i) {
            return $node->attr('value');
        });
        $data = $crawler->filter('tr')->each(function (Crawler $node, $i) {
                $data[]= $node->filter('input')->each(function (Crawler $node1, $j) {
                    return $node1->attr('value');
                });
                $data[]= $node->filter('label')->each(function (Crawler $node1, $j) {
                    $html=$node1->html();
                    $html = str_replace(' ', '', $html);$html = str_replace('-', '', $html);
                    $html = str_replace('<em>', '', $html);$html = str_replace('</em>', '', $html);
                    $html = str_replace('<strong>', '', $html);//$html = str_replace('</strong>', '', $html);
                    $html = str_replace('<span>', '', $html);$html = str_replace('</span>', '', $html);
                    return trim($html);
                });
                $data[]= $node->filter('td')->each(function (Crawler $node1, $j) {
                    $html=$node1->html();
                    $html = str_replace(',', '', $html);
                    $html = str_replace('<em>', '', $html);$html = str_replace('</em>', '', $html);
                    $html = str_replace('<strong>', '', $html);//$html = str_replace('</strong>', '', $html);
                    $html = str_replace('<span>', '', $html);$html = str_replace('</span>', '', $html);
                    return trim($html);
                });
                return $data;
        });
        array_pop($data);
        $page = ceil((int) $totalCount[0] / 10);
        if ($page > 1) {
            for ($k = 2; $k <= $page; $k++) {
                $crawler = $client->request('GET', 'https://ps.tmon.co.kr/daily/cancelTicketList?main_deal_srl=1957699002%2C1850249946&deal_srl=&branch_srl=&status_type=AV&page=' . $k . '&ticket_status_type=ALL&mbiz_yn=N&simple_search=N&deal_start_date=&dealType=AV&use_date=%EC%82%AC%EC%9A%A9%EC%9D%BC&start_date=' . $start_date . '&end_date=' . $end_date . '&searchKey=phone_number&searchVal=&_=1593571258362');
                $data1 = $crawler->filter('tr')->each(function (Crawler $node, $i) {
                    $data[]= $node->filter('input')->each(function (Crawler $node1, $j) {
                        return $node1->attr('value');
                    });
                    $data[]= $node->filter('label')->each(function (Crawler $node1, $j) {
                        $html=$node1->html();
                        $html = str_replace(' ', '', $html);$html = str_replace('-', '', $html);
                        $html = str_replace('<em>', '', $html);$html = str_replace('</em>', '', $html);
                        $html = str_replace('<strong>', '', $html);//$html = str_replace('</strong>', '', $html);
                        $html = str_replace('<span>', '', $html);$html = str_replace('</span>', '', $html);
                        return trim($html);
                    });
                    $data[]= $node->filter('td')->each(function (Crawler $node1, $j) {
                        $html=$node1->html();
                        $html = str_replace(',', '', $html);
                        $html = str_replace('<em>', '', $html);$html = str_replace('</em>', '', $html);
                        $html = str_replace('<strong>', '', $html);//$html = str_replace('</strong>', '', $html);
                        $html = str_replace('<span>', '', $html);$html = str_replace('</span>', '', $html);
                        return trim($html);
                    });
                    return $data;
                });
                array_pop($data1);
                $data = array_merge($data, $data1);
                sleep(10);
            }
        }
        for ($i = 0; $i < $totalCount[0]; $i++) {
            $statusTicket = 3;
            $purchasedAt = str_replace('.', '-', $data[$i][2][5]);
            $purchasedAt = str_replace('(', '', $purchasedAt);
            $purchasedAt = str_replace(')', '', $purchasedAt);
            
            $canceledAt = str_replace('.', '-', $data[$i][2][6]);
            $canceledAt = str_replace('(', '', $canceledAt);
            $canceledAt = str_replace(')', '', $canceledAt);
            
            $ticketNumber=$data[$i][1][0];
            $price = (int)$data[$i][2][3];
            $ticket = [
                'useAmount' => 0,
                'totalAmount' => 1,
                'ticketNumber' => $ticketNumber,
                'price' =>  $price,
                'purchasedAt' => $purchasedAt,
                'canceledAt' => $canceledAt,
                'statusTicket' => $statusTicket
            ];
            //'statusType' => $value[16],
            //'optionId' => 0,
            //'dealId' => $value[9],
            //'restoreTicket' => 1,
            //'canceledAt' => $value[18],
            $result1 = $this->_model->loadRecord('ticket', ['ticketNumber' => $ticketNumber ]);
            if ($result1) {
                $this->_model->updateRecord('ticket', $ticket, ['ticketNumber' => $ticketNumber ]);
            } else {
                $this->_model->insertRecord('ticket', $ticket);
            }
            //echo '<textarea disabled>'.$data[$i][2][2].'</textarea>';
            $pieces = explode('</strong>', $data[$i][2][2]);
            if(isset($pieces[1])) $pieces[1]="";
            $ticketPurchasers = [
                'ticketNumber' => $data[$i][1][0],
                'userName' =>$data[$i][2][0],
                'phoneNumber' => $data[$i][2][1],
                'dealName' => trim($pieces[0]),
                'optionName' => trim($pieces[1]),
                'price' => $data[$i][2][3],
                'purchaseDateTime' =>$purchasedAt,
                'canceledDateTime' => $canceledAt,
                'status' => 'CANCEL_COMPLETE'
            ];
            //'orderNumber' => $value[1],
            //'email' => $value[5],
            //'dealId' => $value[9],
            //'optionId' => 0,
            //'canceledDateTime' => $value[9],
            $result2 = $this->_model->loadRecord('ticketPurchasers', ['ticketNumber' => $data[$i][1][0] ]);
            if ($result2) {
                $this->_model->updateRecord('ticketPurchasers', $ticketPurchasers, ['ticketNumber' =>$data[$i][1][0] ]);
            } else {
                $this->_model->insertRecord('ticketPurchasers', $ticketPurchasers);
           }
        }
    }

    // Phương thức cancel
    public function refundAction() {
        set_time_limit(500);
        $client = new Client(HttpClient::create(['timeout' => 600]));
        $browser = new HttpBrowser(HttpClient::create());
        $crawler = $client->request('POST', 'https://ps.tmon.co.kr');
        $form = $crawler->selectButton("로그인")->form();
        $crawler = $client->submit($form, array(
            'secureLogin' => false,
            'install_nos' => 'Y',
            'login_id' => '티브리지',
            'passwd' => 'coupang135!'));

        $crawler = $client->click($crawler->selectLink('다음에 변경하기')->link());
        $crawler = $client->click($crawler->selectLink('사용∙처리내역')->link());

        $start_date = (date("Y") - 1) . "." . date("m.d");
        $end_date = date("Y.m.d");
        $crawler = $client->request('GET', 'https://ps.tmon.co.kr/daily/refundTicketList?main_deal_srl=1957699002%2C1850249946&deal_srl=&branch_srl=&status_type=AV&page=1&ticket_status_type=ALL&mbiz_yn=N&simple_search=N&deal_start_date=&dealType=AV&use_date=%EC%82%AC%EC%9A%A9%EC%9D%BC&start_date=' . $start_date . '&end_date=' . $end_date . '&searchKey=phone_number&searchVal=&_=1593571258362');
        $html_string = $crawler->outerHtml();

        $result = str_replace('<html><body>', '', $html_string);
        $result = str_replace('<tr class="frst">', '', $result);
        $result = str_replace('<td>', '', $result);
        $result = str_replace('</td>', '', $result);
        $result = str_replace('</tr>', '', $result);
        $result = str_replace('<tr style="display:none">', '', $result);
        $result = str_replace('</body></html>', '', $result);
        $result = str_replace('<br>', '', $result);
        $pieces_mang = explode('<input type="hidden" id="totalCount" value="', $result);
        $content = $pieces_mang[0];
        $totalCount = $pieces_mang[1];
        $totalCount = str_replace('">', '', $totalCount);

        if ($totalCount != 0) {
            $pieces = explode('<tr>', $content);
            for ($i = 0; $i < count($pieces); $i++) {
                //$rows_mang = explode('style="font-size:12px;">', $pieces[$i]);
                $result_rows = preg_replace('/\s+/', '', $pieces[$i]);
                $result_rows = str_replace('<strong>', '', $result_rows);
                $result_rows = str_replace('</strong>', '', $result_rows);
                $result_rows = str_replace('</label>', '', $result_rows);
                $result_rows = str_replace('<tdclass="deal_name">', '', $result_rows);
                $result_rows = str_replace('</th>', '', $result_rows);
                $result_rows = str_replace('<span>', '', $result_rows);
                $result_rows = str_replace('</span>', '', $result_rows);
                $result_rows = str_replace('<em>', '#!', $result_rows);
                $result_rows = str_replace('</em>', '#!', $result_rows);
                $result_rows = str_replace('-#!', '-', $result_rows);
                $result_rows = str_replace('#!#!', '#!', $result_rows);
                $result_rows = str_replace('#!#!', '#!', $result_rows);
                $pieces_1 = explode('#!', $result_rows);
                for ($j = 0; $j < count($pieces_1); $j++) {
                    echo $j . "-" . $pieces_1[$j] . "<br/>";
                }
            }

            $page = ceil((int) $totalCount / 10);
            if ($page > 1) {
                for ($k = 2; $k <= $page; $k++) {
                    $crawler = $client->request('GET', 'https://ps.tmon.co.kr/daily/refundTicketList?main_deal_srl=1957699002%2C1850249946&deal_srl=&branch_srl=&status_type=AV&page=' . $k . '&ticket_status_type=ALL&mbiz_yn=N&simple_search=N&deal_start_date=&dealType=AV&use_date=%EC%82%AC%EC%9A%A9%EC%9D%BC&start_date=' . $start_date . '&end_date=' . $end_date . '&searchKey=phone_number&searchVal=&_=1593571258362');
                    $html_string = $crawler->outerHtml();
                    $result = str_replace('<html><body>', '', $html_string);
                    $result = str_replace('<tr class="frst">', '', $result);
                    $result = str_replace('<td>', '', $result);
                    $result = str_replace('</td>', '', $result);
                    $result = str_replace('</tr>', '', $result);
                    $result = str_replace('<tr style="display:none">', '', $result);
                    $result = str_replace('</body></html>', '', $result);
                    $result = str_replace('<br>', '', $result);

                    $pieces_mang = explode('<input type="hidden" id="totalCount" value="', $result);
                    $content = $pieces_mang[0];
                    $pieces = explode('<tr>', $content);
                    echo "<span style='color:red'>" . $k . "</span>";
                    for ($i = 0; $i < count($pieces); $i++) {
                        $rows_mang = explode('style="font-size:12px;">', $pieces[$i]);
                        $result_rows = preg_replace('/\s+/', '', $rows_mang[1]);
                        $result_rows = str_replace('<strong>', '', $result_rows);
                        $result_rows = str_replace('</strong>', '', $result_rows);
                        $result_rows = str_replace('</label>', '', $result_rows);
                        $result_rows = str_replace('<tdclass="deal_name">', '', $result_rows);
                        $result_rows = str_replace('</th>', '', $result_rows);
                        $result_rows = str_replace('<span>', '', $result_rows);
                        $result_rows = str_replace('</span>', '', $result_rows);
                        $result_rows = str_replace('<em>', '#!', $result_rows);
                        $result_rows = str_replace('</em>', '#!', $result_rows);
                        $result_rows = str_replace('-#!', '-', $result_rows);
                        $result_rows = str_replace('#!#!', '#!', $result_rows);
                        $result_rows = str_replace('#!#!', '#!', $result_rows);
                        $pieces_1 = explode('#!', $result_rows);
                        for ($j = 0; $j < count($pieces_1); $j++) {
                            echo "<span style='color:red'>" . $k . "_" . $j . "</span>";
                            echo $j . "-" . $pieces_1[$j] . "<br/>";
                        }
                        echo "<hr/>";
                    }
                    sleep(10);
                }
            }
        } else {
            echo "Không có dữ liệu để cập nhật";
        }
    }

    // Phương thức multi
    public function multiAction() {
        set_time_limit(500);
        $client = new Client(HttpClient::create(['timeout' => 600]));
        $browser = new HttpBrowser(HttpClient::create());
        $crawler = $client->request('POST', 'https://ps.tmon.co.kr');
        $form = $crawler->selectButton("로그인")->form();
        $crawler = $client->submit($form, array(
            'secureLogin' => false,
            'install_nos' => 'Y',
            'login_id' => '티브리지',
            'passwd' => 'coupang135!'));
        $crawler = $client->click($crawler->selectLink('다음에 변경하기')->link());
        $crawler = $client->click($crawler->selectLink('사용∙처리내역')->link());

        $start_date = (date("Y") - 1) . "." . date("m.d");
        $end_date = date("Y.m.d");
        $crawler = $client->request('GET', 'https://ps.tmon.co.kr/daily/multibizReserveTicketList?dealType=DN&reservationStatus=ALL&searchDateType=BUY_DATE&startDate=' . $start_date . '&endDate=' . $end_date . '&searchType=PHONE_NUMBER&searchKeyword=&mainDealSrl=&page=1&status_type=&ticket_status_type=&_=1593660495832');
        $html_string = $crawler->outerHtml();
        $result = str_replace('<html><body>', '', $html_string);
        $result = str_replace('</body></html>', '', $result);
        $result = str_replace('<input type="hidden" id="error" value="">', '', $result);
        $result = str_replace('<span>', '', $result);
        $result = str_replace('</span>', '', $result);
        $result = str_replace('<br>', '', $result);
        $result = str_replace('<em>', '', $result);
        $result = str_replace('</em>', '', $result);
        $pieces_mang = explode('<input type="hidden" id="reserveCount" name="reserveCount" value="', $result);
        $content = $pieces_mang[0];
        $totalCount = $pieces_mang[1];
        $totalCount = preg_replace('/\s+/', '', $totalCount);
        $totalCount = str_replace('"></td></tr>', '', $totalCount);
        if ($totalCount != 0) {
            $pieces = explode('<tr class="frst">', $content);
            for ($i = 1; $i < count($pieces); $i++) {
                $rows_mang = $pieces[$i];
                $rows_mang = str_replace('</tr>', '', $rows_mang);
                $rows_mang = str_replace('<tr style="display:none;">', '', $rows_mang);
                $rows_mang = preg_replace('/\s+/', '', $rows_mang);
                $rows_mang = str_replace('<td>', '#!', $rows_mang);
                $rows_mang = str_replace('</td>', '#!', $rows_mang);
                $rows_mang = str_replace('#!#!', '#!', $rows_mang);
                $rows_mang = str_replace('#!#!', '#!', $rows_mang);
                $rows_mang = explode('</div>', $rows_mang);
                $first = $rows_mang[0];
                $second = $rows_mang[1];
                $first = explode('</label>', $first);
                $first = $first[0];
                $first = explode('<labelfor="ch', $first);
                $first = $first[1];
                $first = explode('">', $first);
                $first = $first[1];
                $mang = $first . $second;
                $pieces_1 = explode('#!', $mang);
                for ($j = 0; $j < count($pieces_1) - 1; $j++) {
                    echo $j . "-" . $pieces_1[$j] . "<br/>";
                }
            }
            $page = ceil((int) $totalCount / 10);
            if ($page > 1) {
                for ($k = 2; $k <= $page; $k++) {
                    $crawler = $client->request('GET', 'https://ps.tmon.co.kr/daily/multibizReserveTicketList?dealType=DN&reservationStatus=ALL&searchDateType=BUY_DATE&startDate=' . $start_date . '&endDate=' . $end_date . '&searchType=PHONE_NUMBER&searchKeyword=&mainDealSrl=&page=' . $k . '&status_type=&ticket_status_type=&_=1593660495832');
                    $html_string = $crawler->outerHtml();
                    $result = str_replace('<html><body>', '', $html_string);
                    $result = str_replace('</body></html>', '', $result);
                    $result = str_replace('<input type="hidden" id="error" value="">', '', $result);
                    $result = str_replace('<span>', '', $result);
                    $result = str_replace('</span>', '', $result);
                    $result = str_replace('<br>', '', $result);
                    $result = str_replace('<em>', '', $result);
                    $result = str_replace('</em>', '', $result);
                    $pieces_mang = explode('<input type="hidden" id="reserveCount" name="reserveCount" value="', $result);
                    $content = $pieces_mang[0];
                    $pieces = explode('<tr class="frst">', $content);
                    for ($i = 1; $i < count($pieces); $i++) {
                        $rows_mang = $pieces[$i];
                        $rows_mang = str_replace('</tr>', '', $rows_mang);
                        $rows_mang = str_replace('<tr style="display:none;">', '', $rows_mang);
                        $rows_mang = preg_replace('/\s+/', '', $rows_mang);
                        $rows_mang = str_replace('<td>', '#!', $rows_mang);
                        $rows_mang = str_replace('</td>', '#!', $rows_mang);
                        $rows_mang = str_replace('#!#!', '#!', $rows_mang);
                        $rows_mang = str_replace('#!#!', '#!', $rows_mang);
                        $rows_mang = explode('</div>', $rows_mang);
                        $first = $rows_mang[0];
                        $second = $rows_mang[1];
                        $first = explode('</label>', $first);
                        $first = $first[0];
                        $first = explode('<labelfor="ch', $first);
                        $first = $first[1];
                        $first = explode('">', $first);
                        $first = $first[1];
                        $mang = $first . $second;
                        $pieces_1 = explode('#!', $mang);
                        for ($j = 0; $j < count($pieces_1) - 1; $j++) {
                            echo $j . "-" . $pieces_1[$j] . "<br/>";
                        }
                    }
                    sleep(10);
                }
            }
        }
    }

    public function questionAction() {
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $browser = new HttpBrowser(HttpClient::create());
        $crawler = $client->request('POST', 'https://ps.tmon.co.kr');
        $form = $crawler->selectButton("로그인")->form();
        $crawler = $client->submit($form, array(
            'secureLogin' => false,
            'install_nos' => 'Y',
            'login_id' => '티브리지',
            'passwd' => 'coupang135!'));
        $crawler = $client->click($crawler->selectLink('다음에 변경하기')->link());
        $crawler = $client->click($crawler->selectLink('고객문의 관리')->link());
        $start_date = (date("Y") - 1) . "." . date("m.d");
        $end_date = date("Y.m.d");
        $crawler = $client->request('GET', 'https://ps.tmon.co.kr/inquiry/detail?page=1&main_deal_srl=3458517230&srchCategory=ALL&srchStartDate=2020-04-28&srchEndDate=2020-07-03&srchKeyword=&_=1593766736319');
        $html_string = $crawler->outerHtml();
        $result = str_replace("'", '"', $html_string);
        $result = str_replace("'", '"', $result);
        $result = str_replace('<html><body>', '', $result);
        $result = str_replace('</body></html>', '', $result);
        $result = explode('<tbody>', $result);
        $result = $result[1];
        $result = explode('</tbody>', $result);
        $page = $result[1];
        $pieces_page = explode('inquiry?page=', $page);
        for ($h = 0; $h < count($pieces_page); $h++) {
            $string_page = $pieces_page[$h];
        }
        $number_page = explode('&', $string_page);
        $number_page = $number_page[0];
        $result = $result[0];
        $pieces = explode('<tr>', $result);
        for ($k = 1; $k < count($pieces); $k++) {            
            $pieces1 = explode('</td>', $pieces[$k]);
            $cot1 = $pieces1[0];
            $cot2 = $pieces1[1];
            $cot3 = $pieces1[2];
            $cot4 = $pieces1[3];
            $cot1 = str_replace('<td class="deal">', '', $cot1);
            $cot2 = explode('</p>', $cot2);
            $check_anwer = count($cot2);
            if ($check_anwer > 2) {
                $cot2_anwer = $cot2[1];
            } else {
                $cot2_anwer = "";
            }
            $cot2 = $cot2[0];
            $cot2 = str_replace('<td class="content">', '', $cot2);
            $cot2 = str_replace('<strong class="uid">', '', $cot2);
            $cot2 = str_replace('</strong>', '', $cot2);
            $cot2 = str_replace('<p>', '', $cot2);
            $cot2 = str_replace('<span class="date">', '#!', $cot2);
            $cot2 = str_replace('</span>', '#!', $cot2);
            $cot3 = explode('">', $cot3);
            $cot3 = $cot3[1];
            $cot3 = str_replace('</span>', '', $cot3);
            $cot4 = str_replace('<td>', '', $cot4);
            $result_rows = $cot1 . "#!" . $cot2 . "#!" . $cot3 . "#!" . $cot4;
            $result_rows = preg_replace('/\s+/', ' ', $result_rows);
            $pieces2 = explode('#!', $result_rows);
            for ($i = 0; $i < count($pieces2); $i++) {
                if ($i == 0) {$deal_name = $pieces2[$i];}
                if ($i == 1) {
                    $check_ma = explode('(', $pieces2[$i]);
                    if (count($check_ma) > 1) {
                        $username = $check_ma[0];
                        $ma = str_replace(')', '', $check_ma[1]);
                    } else {
                        $username = $check_ma[0];
                        $ma = "";
                    }
                }
                if ($i == 2) {$datetime = $pieces2[$i];}
                if ($i == 3) {$content = $pieces2[$i];}
                if ($i == 4) {$purchase = $pieces2[$i];}
                if ($i == 5) {$status = $pieces2[$i];}
            }
            $result = $this->_model->loadRecords('question', [
                'deal_name' => $deal_name,
                'username' => $username,
                'date_created' => $datetime
            ]);
            $data = ['deal_name' => "$deal_name",
                'username' => $username,
                'order_number' => 1,
                'purchase' => $purchase,
                'status' => "$status",
                'deal_id' => 0,
                'date_created' => $datetime
            ];
            if ($result) {
                $result_re = $this->_model->loadRecord('question', [
                    'deal_name' => $deal_name,
                    'username' => $username,
                    'date_created' => $datetime
                ]);
                $question_id = $result_re["question_id"];
            } else {
                $this->_model->insertRecord('question', $data);
                $question_id = $this->_model->getLastId();
                $data_content = ['question_id' => "$question_id",
                    'type' => 0,
                    'username' => $username,
                    'datetime' => $datetime,
                    'content' => "$content"
                ];
                $this->_model->insertRecord('questioncontent', $data_content);
            }
            /* echo "Tên deal:" . $ten_deal . "<br/>";
              echo "ID:" . $id . "<br/>";
              echo "Mã đơn hàng:" . $ma . "<br/>";
              echo "Ngày đăng:" . $date . "<br/>";
              echo "Nội dung:" . $content . "<br/>";
              echo "구매여부:" . $re . "<br/>";
              echo "답변여부:" . $status . "<br/>"; */
            if ($check_anwer > 2) {
                $cot2_anwer = explode('<strong class="pid">', $cot2_anwer);
                $cot2_anwer = $cot2_anwer[1];
                $cot2_anwer = explode('<div class="options">', $cot2_anwer);
                $cot2_anwer_1 = $cot2_anwer[0];
                $cot2_anwer_2 = $cot2_anwer[1];
                $cot2_anwer_2 = explode('<p>', $cot2_anwer_2);
                $cot2_anwer_2 = $cot2_anwer_2[1];
                $cot2_anwer = $cot2_anwer_1 . "#!" . $cot2_anwer_2;
                $cot2_anwer = str_replace('<span class="date">', '', $cot2_anwer);
                $cot2_anwer = str_replace('</strong>', '#!', $cot2_anwer);
                $cot2_anwer = str_replace('</span>', '', $cot2_anwer);
                $cot2_anwer = preg_replace('/\s+/', ' ', $cot2_anwer);
                $pieces_anwer = explode('#!', $cot2_anwer);
                for ($m = 0; $m < count($pieces_anwer); $m++) {
                    if ($m == 0) {$username_anwer = $pieces_anwer[$m];}
                    if ($m == 1) {$date_anwer = $pieces_anwer[$m];}
                    if ($m == 2) {$content_anwer = $pieces_anwer[$m];}
                }
                $result = $this->_model->loadRecords('questioncontent', [
                    'username' => $username_anwer,
                    'datetime' => $date_anwer
                ]);
                $data_content = ['question_id' => "$question_id",
                    'type' => 1,
                    'username' => $username_anwer,
                    'datetime' => $date_anwer,
                    'content' => "$content_anwer"
                ];
                if ($result) {} else {$this->_model->insertRecord('questioncontent', $data_content);}
            }
        }
        if ($number_page > 1) {
            for ($p = 2; $p <= $number_page; $p++) {
                $crawler = $client->request('GET', 'https://ps.tmon.co.kr/inquiry/detail?page=' . $p . '&main_deal_srl=3458517230&srchCategory=ALL&srchStartDate=2020-04-28&srchEndDate=2020-07-03&srchKeyword=&_=1593766736319');
                $html_string = $crawler->outerHtml();
                $result = str_replace("'", '"', $html_string);
                $result = str_replace("'", '"', $result);
                $result = str_replace('<html><body>', '', $result);
                $result = str_replace('</body></html>', '', $result);
                $result = explode('<tbody>', $result);
                $result = $result[1];
                $result = explode('</tbody>', $result);
                $page = $result[1];
                $pieces_page = explode('inquiry?page=', $page);
                for ($h = 0; $h < count($pieces_page); $h++) {
                    $string_page = $pieces_page[$h];
                }
                $number_page = explode('&', $string_page);
                $number_page = $number_page[0];
                $result = $result[0];
                $pieces = explode('<tr>', $result);
                for ($k = 1; $k < count($pieces); $k++) {                    
                    $pieces1 = explode('</td>', $pieces[$k]);
                    $cot1 = $pieces1[0];
                    $cot2 = $pieces1[1];
                    $cot3 = $pieces1[2];
                    $cot4 = $pieces1[3];
                    $cot1 = str_replace('<td class="deal">', '', $cot1);
                    $cot2 = explode('</p>', $cot2);
                    $check_anwer = count($cot2);
                    if ($check_anwer > 2) {
                        $cot2_anwer = $cot2[1];
                    } else {
                        $cot2_anwer = "";
                    }
                    $cot2 = $cot2[0];
                    $cot2 = str_replace('<td class="content">', '', $cot2);
                    $cot2 = str_replace('<strong class="uid">', '', $cot2);
                    $cot2 = str_replace('</strong>', '', $cot2);
                    $cot2 = str_replace('<p>', '', $cot2);
                    $cot2 = str_replace('<span class="date">', '#!', $cot2);
                    $cot2 = str_replace('</span>', '#!', $cot2);
                    $cot3 = explode('">', $cot3);
                    $cot3 = $cot3[1];
                    $cot3 = str_replace('</span>', '', $cot3);
                    $cot4 = str_replace('<td>', '', $cot4);
                    $result_rows = $cot1 . "#!" . $cot2 . "#!" . $cot3 . "#!" . $cot4;
                    $result_rows = preg_replace('/\s+/', ' ', $result_rows);
                    $pieces2 = explode('#!', $result_rows);
                    for ($i = 0; $i < count($pieces2); $i++) {
                        if ($i == 0) {$deal_name = $pieces2[$i];}
                        if ($i == 1) {
                            $check_ma = explode('(', $pieces2[$i]);
                            if (count($check_ma) > 1) {
                                $username = $check_ma[0];$ma = str_replace(')', '', $check_ma[1]);
                            } else {
                                $username = $check_ma[0];$ma = "";
                            }
                        }
                        if ($i == 2) {$datetime = $pieces2[$i];}
                        if ($i == 3) {$content = $pieces2[$i];}
                        if ($i == 4) {$purchase = $pieces2[$i];}
                        if ($i == 5) {$status = $pieces2[$i];}
                    }
                    $result = $this->_model->loadRecords('question', [
                        'deal_name' => $deal_name,
                        'username' => $username,
                        'date_created' => $datetime
                    ]);
                    $data = ['deal_name' => "$deal_name",
                        'username' => $username,
                        'order_number' => 1,
                        'purchase' => $purchase,
                        'status' => "$status",
                        'deal_id' => 0,
                        'date_created' => $datetime
                    ];
                    if ($result) {
                        $result_re = $this->_model->loadRecord('question', [
                            'deal_name' => $deal_name,
                            'username' => $username,
                            'date_created' => $datetime
                        ]);
                        $question_id = $result_re["question_id"];
                    } else {
                        $this->_model->insertRecord('question', $data);
                        $question_id = $this->_model->getLastId();
                        $data_content = ['question_id' => "$question_id",
                            'type' => 0,
                            'username' => $username,
                            'datetime' => $datetime,
                            'content' => "$content"
                        ];
                        $this->_model->insertRecord('questioncontent', $data_content);
                    }
                    /*
                      echo "Tên deal:" . $ten_deal . "<br/>";
                      echo "ID:" . $id . "<br/>";
                      echo "Mã đơn hàng:" . $ma . "<br/>";
                      echo "Ngày đăng:" . $date . "<br/>";
                      echo "Nội dung:" . $content . "<br/>";
                      echo "구매여부:" . $re . "<br/>";
                      echo "답변여부:" . $status . "<br/>"; */
                    if ($check_anwer > 2) {
                        $cot2_anwer = explode('<strong class="pid">', $cot2_anwer);
                        $cot2_anwer = $cot2_anwer[1];

                        $cot2_anwer = explode('<div class="options">', $cot2_anwer);
                        $cot2_anwer_1 = $cot2_anwer[0];
                        $cot2_anwer_2 = $cot2_anwer[1];
                        $cot2_anwer_2 = explode('<p>', $cot2_anwer_2);
                        $cot2_anwer_2 = $cot2_anwer_2[1];
                        $cot2_anwer = $cot2_anwer_1 . "#!" . $cot2_anwer_2;
                        $cot2_anwer = str_replace('<span class="date">', '', $cot2_anwer);
                        $cot2_anwer = str_replace('</strong>', '#!', $cot2_anwer);
                        $cot2_anwer = str_replace('</span>', '', $cot2_anwer);
                        $cot2_anwer = preg_replace('/\s+/', ' ', $cot2_anwer);
                        $pieces_anwer = explode('#!', $cot2_anwer);
                        for ($m = 0; $m < count($pieces_anwer); $m++) {
                            if ($m == 0) {
                                $username_anwer = $pieces_anwer[$m];
                            }
                            if ($m == 1) {
                                $date_anwer = $pieces_anwer[$m];
                            }
                            if ($m == 2) {
                                $content_anwer = $pieces_anwer[$m];
                            }
                        }
                        $result = $this->_model->loadRecords('questioncontent', [
                            'username' => $username_anwer,
                            'datetime' => $date_anwer
                        ]);
                        $data_content = ['question_id' => "$question_id",
                            'type' => 1,
                            'username' => $username_anwer,
                            'datetime' => $date_anwer,
                            'content' => "$content_anwer"
                        ];
                        if ($result) {} else {$this->_model->insertRecord('questioncontent', $data_content);}
                    }
                }
            }
        }
    }

    public function question1Action() {
        //http://www.tmon.co.kr/deal/1850249946
//         $client = new Client(HttpClient::create(['timeout' => 60]));
//         $crawler = $client->request('GET', 'https://www.tmon.co.kr/deal/1850249946#tab=qna-section');
        
//         echo ($crawler->outerHtml());
        $client = new Client(HttpClient::create(['timeout' => 600]));
        $url = "http://tbridge.lavianspa.com/restfulApi.html";
        $data = [
            'name' => 'khoa nguyen',
            'address' => '132 d2 P.25 Binh Thanh'
        ];
        $response = $client->request('GET', $url );
        
        echo '<pre>';
        print_r($response->outerHtml());
        echo '</pre>';
       
    }

}

?>