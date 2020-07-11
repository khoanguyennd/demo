<?php

require PATH_ROOT . '/vendor1/autoload.php';

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;

require PATH_ROOT . '/vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

class WemakepriceController extends Controller {

    // Phương thức khởi tạo
    public function __construct($params) {
        parent::__construct($params);
    }

    public function register_stream_wrapper($projectId) {
        $client = new StorageClient(['projectId' => $projectId]);
        $client->registerStreamWrapper();
    }

    function callAPI($method, $url, $data) {
        $token = "Bearer eyJ0eXAiOiJKV1QiLCJyZWdEYXRlIjoxNTk0MTkxMjY2NjY2LCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiIzYWVmNzUyZC1iYjRhLTRmMWQtOGU2Ni00YjcxZjNlMDY0MjUiLCJzdWIiOiJXT05ERVJUT1VSIiwicGFydG5lcl9pZCI6InRicmlkZ2UxIiwic2FwX3BhcnRuZXJfaWQiOiIzNDQyIiwicGFydG5lcl9uYW1lIjoiKOyjvCnti7DruIzrpqzsp4AiLCJidXNpbmVzc19uYW1lIjoiKOyjvCnti7DruIzrpqzsp4AiLCJhdXRob3JpdHlfdHlwZSI6IlBBUlRORVIiLCJhdXRob3JpdHlfZ3JvdXBfY2QiOiJHUDAyMCIsImRvbWFpbl90eXBlIjoiVG91ckFjdGl2aXR5IiwiZGVwYXJ0bWVudF9jZCI6IldTVDAwMDAxMTciLCJkZXBhcnRtZW50X25hbWUiOiLslaHti7DruYTti7DtjIztirgiLCJleHAiOjE1OTQyMzQ0NjZ9.0GIFrMli9dbX-NwW772VxL2wy7i5ozth6RJqDW8asDY";
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
            'Content-Type: application/json',
            'Authorization: ' . $token
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure");
        }
        curl_close($curl);
        //print_r($result);
        return $result;
    }

    // Phương thức index
    public function indexAction() { //tour        
        $url = "https://tour-partner-api.wonders.app/v1/partner/activity/reservations/tickets?used=false&reservationTicketStatuses=B,R,F&ticketSearchDateType=PAID_DATE&startDate=2020-01-01&endDate=2020-07-08&partnerType=id&bookerType=name&reservationType=booking&goodsIdType=wid&pageSize=30&pageNumber=1&ticketOrderBy=PAID_DATE&locationType=DOMESTIC";
        $obj = $this->callAPI("GET", $url, null);
        $obj = json_decode($obj, TRUE);        
        $totalCount = $obj['totalCount'];
        for ($i = 0; $i < $totalCount; $i++) {
            $createdBy = $obj["results"][$i]["createdBy"];
            $createdAt = $obj["results"][$i]["createdAt"];
            $updatedBy = $obj["results"][$i]["updatedBy"];
            $updatedAt = $obj["results"][$i]["updatedAt"];
            $id = $obj["results"][$i]["id"];
            $reservationId = $obj["results"][$i]["reservationId"];
            $optionId = $obj["results"][$i]["optionId"];
            $optionName = $obj["results"][$i]["optionName"];
            $ticketCodeId = $obj["results"][$i]["ticketCodeId"];
            $ticketCode = $obj["results"][$i]["ticketCode"];
            $price = $obj["results"][$i]["price"];
            $couponPrice = $obj["results"][$i]["couponPrice"];
            $cancelFeePrice = $obj["results"][$i]["cancelFeePrice"];
            $status = $obj["results"][$i]["status"];
            $statusName = $obj["results"][$i]["statusName"];
            $useStart = $obj["results"][$i]["useStart"];
            $useEnd = $obj["results"][$i]["useEnd"];
            $used = $obj["results"][$i]["used"];
            $usedAt = $obj["results"][$i]["usedAt"];
            $unUsedTicketRefundType = $obj["results"][$i]["unUsedTicketRefundType"];
            $unUsedTicketRefund = $obj["results"][$i]["unUsedTicketRefund"];
            $unUsedTicketRefundAt = $obj["results"][$i]["unUsedTicketRefundAt"];
            $canceledAt = $obj["results"][$i]["canceledAt"];
            $partnerGoodsCode = $obj["results"][$i]["partnerGoodsCode"];
            $additionalInformation = $obj["results"][$i]["additionalInformation"];
            $orderNo = $obj["results"][$i]["reservation"]["orderNo"];
            $goodsId = $obj["results"][$i]["reservation"]["goodsId"];
            $goodsName = $obj["results"][$i]["reservation"]["goodsName"];
            $partnerId = $obj["results"][$i]["reservation"]["partnerId"];
            $partnerName = $obj["results"][$i]["reservation"]["partnerName"];
            $category1Name = $obj["results"][$i]["reservation"]["category1Name"];
            $category2Name = $obj["results"][$i]["reservation"]["category2Name"];
            $category3Name = $obj["results"][$i]["reservation"]["category3Name"];
            $category4Name = $obj["results"][$i]["reservation"]["category4Name"];
            $reservationStatus = $obj["results"][$i]["reservation"]["reservationStatus"];
            $reservationStatusName = $obj["results"][$i]["reservation"]["reservationStatusName"];
            $bookerName = $obj["results"][$i]["reservation"]["bookerName"];
            $bookerTel = $obj["results"][$i]["reservation"]["bookerTel"];
            $bookerEmail = $obj["results"][$i]["reservation"]["bookerEmail"];
            $mid = $obj["results"][$i]["reservation"]["mid"];
            $travelersNumber = $obj["results"][$i]["reservation"]["travelersNumber"];
            $paidAt = $obj["results"][$i]["reservation"]["paidAt"];
            $scheduleKind = $obj["results"][$i]["reservation"]["scheduleKind"];
            $reservationType = $obj["results"][$i]["reservation"]["reservationType"];
            $wid = $obj["results"][$i]["reservation"]["wid"];            
            $ticket = [
                'useAmount' => 0,
                'totalAmount' => 1,
                'ticketNumber' => $ticketCode,
                'statusType' =>0,
                'price' => $price,
                'optionId' => $optionId,
                'dealId' => $goodsId,
                'purchasedAt' => $createdAt,
                'restoreTicket' => 1,
                'statusTicket' => 0
            ];
            //print_r($ticket);
            
            $result1 = $this->_model->loadRecord('ticket', ['ticketNumber' => $ticketCode]);
            if ($result1) {
                $this->_model->updateRecord('ticket', $ticket, ['ticketNumber' => $ticketCode]);
            } else {
                $this->_model->insertRecord('ticket', $ticket);
            }
            $ticketPurchasers = [
                'orderNumber' => 0,
                'ticketNumber' => $ticketCode,
                'userName' => $bookerName,
                'phoneNumber' => $bookerTel,
                'email' => $bookerEmail,
                'dealId' => $goodsId,
                'dealName' => $goodsName,
                'optionId' => $optionId,
                'optionName' => $optionName,
                'price' => $price,
                'purchaseDateTime' => $createdAt,
                'status' => 0
            ];
            //print_r($ticketPurchasers);
            
            $result2 = $this->_model->loadRecord('ticketPurchasers', ['ticketNumber' => $ticketCode]);
            if ($result2) {
                $this->_model->updateRecord('ticketPurchasers', $ticketPurchasers, ['ticketNumber' =>$ticketCode]);
            } else {
                $this->_model->insertRecord('ticketPurchasers', $ticketPurchasers);
            }
        }




        /*
          $ticketCode=$obj["results"][0]["ticketCode"];
          $reservationId=$obj["results"][0]["reservationId"];
          $goodsName=$obj["results"][0]["reservation"]["goodsName"];
          $optionName=$obj["results"][0]["optionName"];
          $useEnd=$obj["results"][0]["useEnd"];
          $statusName=$obj["results"][0]["statusName"];
          $price=$obj["results"][0]["price"];
          $bookerName=$obj["results"][0]["reservation"]["bookerName"];
          $bookerTel=$obj["results"][0]["reservation"]["bookerTel"];
          $mid=$obj["results"][0]["reservation"]["mid"];
          $wid=$obj["results"][0]["reservation"]["wid"];
          $goodsId=$obj["results"][0]["reservation"]["goodsId"];
          $createdAt=$obj["results"][0]["createdAt"]; */
    }

    public function index1Action() {   //biz
        $client = new Client(HttpClient::create(['timeout' => 60]));

        //$data=[ "u_id" => "tbridge1"];
        //$crawler = $client->request('POST', 'https://biz.wemakeprice.com/member/login/salt/',$data); =>login_salt
        //         login_salts = login_salt.substr(1,1) + login_salt.substr(4,1) + login_salt.substr(8,1) + login_salt.substr(12,1);
        //         loginProcess = 0;
        //         => $('#uhs').val($.sha1(login_salts+$.sha1(upw))+login_salts);
        //         =>upw = login_salt.substr(3,1) + login_salt.substr(5,2) + login_salt.substr(10,2) + login_salt.substr(15,1);
        $data = ["u_id" => "tbridge1",
            "u_pw" => '227632',
            "u_idsave" => 'undefined',
            "u_hs" => '766c657dd3759946ee054f5e33ee56706a354ebb2010'];
        //login
        $crawler = $client->request('POST', 'https://biz.wemakeprice.com//member/login/result/', $data);

        $crawler = $client->request('GET', 'https://biz.wemakeprice.com/svc_settle/ticket_list/retrieved');

        echo '<pre>';
        print_r($crawler);
        echo '</pre>';
    }

}

?>