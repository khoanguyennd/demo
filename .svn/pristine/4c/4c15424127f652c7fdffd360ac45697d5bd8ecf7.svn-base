<?php

require PATH_VENDOR . "/autoload.php";

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;

class QuestiontmonController extends Controller {

    // Phương thức khởi tạo
    public function __construct($params) {
        parent::__construct($params);
        $this->isLogin();
        $account = $_SESSION['accountshopping'];
        if ($account['temp'] == 1)
            Url::header($this->route('account') . "#tab1");
    }

    // Phương thức index
    public function indexAction() {
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
        $crawler = $client->click($crawler->selectLink('사용∙처리내역')->link());

        $crawler_buylist = $client->click($crawler->selectLink('구매내역')->link());

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
                if ($i == 0) {
                    $ten_deal = $pieces2[$i];
                }
                if ($i == 1) {
                    $check_ma = explode('(', $pieces2[$i]);
                    if (count($check_ma) > 1) {
                        $id = $check_ma[0];
                        $ma = str_replace(')', '', $check_ma[1]);
                    } else {
                        $id = $check_ma[0];
                        $ma = "";
                    }
                }
                if ($i == 2) {
                    $date = $pieces2[$i];
                }
                if ($i == 3) {
                    $content = $pieces2[$i];
                }
                if ($i == 4) {
                    $re = $pieces2[$i];
                }
                if ($i == 5) {
                    $status = $pieces2[$i];
                }
            }            
            $result = $this->_model->loadRecords('questionstmon', [
                'ten_deal' => $ten_deal,
                'idi' => $id
            ]);
            $data = ['ten_deal' => "$ten_deal",
                'idi' => $id,
                'madonhang' => $ma,
                'ngaydang' => "$date",
                'noidung' => $content,
                'col1' => "$re",
                'col2' => "$status"
            ];        
            if ($result) {                
                //$this->_model->updateRecord('questionstmon', $data, ['where' => "ten_deal='$ten_deal'"]);
            } else {
                $this->_model->insertRecord('questionstmon', $data);
            }
        }        
    }

}

?>