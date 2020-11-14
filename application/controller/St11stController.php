<?php 
//  $_SESSION['encryptedLoginName'] =  '5c9930fcf66bf5d4fe8803db86387a427b56b013452be0c765b9011d179c105f38f590019b05ee1503dcf5ed29dcda81b9b641603b34cf7a927c9f3e5fc8202b6db9e4d7b9963d75994f8623a46d5971f80b5d186cd982a87ad7bb134834bfa732939c06e523e1ca81d161e6d628c7da0adc290832d191d5c66f9aa80b9a7097';
//  $_SESSION['encryptedPassWord'] =  '5aaae845004b40e1133f7c7428500e11836b648aebf3dbbf22b6a570649c3b0db7d4bc47c5a28b7a7ba3f1fac7e5cc4e9b1a0efce66627db241a15a1b9e1f7662432509ac9493d52bfdbc055fa8ab7730a89749aa75bc8fb6f76fff5cefdc95c82fc6dc69a8fc187e238b1b9cdbfcd226e730c19e99d708d92e3960517c9bd79';
 
if(!isset($_POST['encryptedLoginName'])){
  //session_start();
//   $_SESSION['encryptedLoginName'] =  $_POST['encryptedLoginName'];
//   $_SESSION['encryptedPassWord'] =  $_POST['encryptedPassWord'];
}else{
   
$time = round(microtime(true) * 1000); ?>
<script type="text/javascript" src="https://www.11st.co.kr/js/common/rsa.js?noCache=<?=$time?>"></script>
<form name="login_form" method="POST" action="">
        <input type="hidden" id="encryptedLoginName" name="encryptedLoginName" value="">
        <input type="hidden" id="encryptedPassWord" name="encryptedPassWord" value="">
        <input type="hidden" id="priority" name="priority" value="">
        <input type="hidden" name="authMethod" value="login">
        <input type="hidden" name="returnURL" value="">
        <input type="hidden" name="loginName" id="user-id"  value="ysjlabs">
        <input type="hidden" id="passWord" name="passWord" value='yakeun87!@' >

</form>
<script>
function checkForm() {
    var form = document.login_form;
   
    try {
        if(rsa){

            try{
                form.priority.value=96;
                form.encryptedLoginName.value=rsa.encrypt('ysjlabs');
                form.encryptedPassWord.value=rsa.encrypt('yakeun87!@');
                form.loginName.value = "";
                form.passWord.value = "";
            }catch(ex){
                Logger.LoggingMsg('ID/PW RSA encrypt 오류');
            }
        }
    } catch(ex){
        Logger.LoggingMsg('로그인 자바스크립트 오류');
    }

    form.submit();
}
checkForm();
</script>
<?php }?>
<?php
require PATH_ROOT . '/vendor1/autoload.php';
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;

require PATH_ROOT . '/vendor/autoload.php';
use Google\Cloud\Storage\StorageClient;
class St11stController extends Controller {
    
    // Phương thức khởi tạo
    public function __construct($params) {
        parent::__construct($params);
    }
 
    // Phương thức index
    public function indexAction($start_date = null, $end_date = null) {
        if ($start_date == null && $end_date == null) {
            $start_date = (date("Y") - 1)  . date("md");
            $end_date = date("Ymd");
        }

        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('POST', 'https://login.11st.co.kr/auth/front/selleroffice/login.tmall?returnURL=http://soffice.11st.co.kr');
        
        $form = $crawler->selectButton("로그인")->form();
        $crawler = $client->submit($form, array(
            'encryptedLoginName' => '5c9930fcf66bf5d4fe8803db86387a427b56b013452be0c765b9011d179c105f38f590019b05ee1503dcf5ed29dcda81b9b641603b34cf7a927c9f3e5fc8202b6db9e4d7b9963d75994f8623a46d5971f80b5d186cd982a87ad7bb134834bfa732939c06e523e1ca81d161e6d628c7da0adc290832d191d5c66f9aa80b9a7097',
            'encryptedPassWord' => '5aaae845004b40e1133f7c7428500e11836b648aebf3dbbf22b6a570649c3b0db7d4bc47c5a28b7a7ba3f1fac7e5cc4e9b1a0efce66627db241a15a1b9e1f7662432509ac9493d52bfdbc055fa8ab7730a89749aa75bc8fb6f76fff5cefdc95c82fc6dc69a8fc187e238b1b9cdbfcd226e730c19e99d708d92e3960517c9bd79',
            'loginName' => 'ysjlabs',
            'passWord' => 'yakeun87!@'));
        $data = [
            'encryptedLoginName'=> '75af1daa73e96bf48beaf632088af7d65d4b26d39ed4c6be2705ca2be7fbe31a87bee07c30e6d95a6800f7e25d837ce6766a45a345b9ca6e36359070577e2e5c8146f532d110a9f7a15838b5e8d6c32e51b72bc0f65ab8f8187d216e28381a92cca716bbbf25a818cf4dd95b4c0ef46bf1318599a6456c666002cefee094b17e',
            'encryptedPassWord'=> '58186cc9c573d9061b9d505b2745be8b98351f05a6aac6c62845a41cd044889e2f3f5f595359b98a29f709abe1092dd58341a3d7260545d1eb5aafc0efad5f73aeedbeaa453923a53a8a7d57a42da8195de1c076e314dd4099336007fb418a9d8fc08034c6591720018d508b924626cdcce7f8d82dedfe0f67ab65e6eb3e053a',
            'priority'=> 93,
            'authMethod'=> 'login',
            'returnURL'=> 'http://soffice.11st.co.kr?ts=1596181197873',
            'loginName'=> 'ysjlabs',
            'passWord' => 'yakeun87!@',
        ];
        $crawler = $client->request('POST', 'https://login.11st.co.kr/auth/front/selleroffice/logincheck.tmall', $data);
 
        $data = [
            'method' => 'getOrderLogisticsList',
            'listType' => 'orderingLogistics',
            'start'=> 0,
            'limit'=> 30,
            'shDateType'=> '01',
            'shDateFrom'=> $start_date,
            'shDateTo'=> $end_date,
            'shBuyerType'=> '',
            'shBuyerText'=>'',
            'shProductStat'=> 'ALL',
            'shDelayReport' => '',
            'shPurchaseConfirm' => '',
            'shGblDlv'=> 'N',
            'prdNo' => '',
            'shStckNo' => '',
            'shOrderType' => 'on',
            'shToday' => '',
            'shDelay'=> '',
            'addrSeq'=> '',
            'isAbrdSellerYn' => '',
            'abrdOrdPrdStat' => '',
            'isItalyAgencyYn' => '',
            'shErrYN' => '',
            'gblRcvrNm' => '%EA%B8%80%EB%A1%9C%EB%B2%8C%ED%86%B5%ED%95%A9%EB%B0%B0%EC%86%A1%EC%A7%80',
            'gblRcvrMailNo'=> '17382',
            'gblRcvrBaseAddr'=> '%EA%B2%BD%EA%B8%B0%EB%8F%84%20%EC%9D%B4%EC%B2%9C%EC%8B%9C%20%EB%A7%88%EC%9E%A5%EB%A9%B4%20%EB%A7%88%EB%8F%84%EB%A1%9C%20177%20',
            'gblRcvrDtlsAddr'=>' %EA%B2%BD%EA%B8%B0%EB%8F%84%20%EC%9D%B4%EC%B2%9C%EC%8B%9C%20%EB%A7%88%EC%9E%A5%EB%A9%B4%20%EB%A7%88%EB%8F%84%EB%A1%9C%20177%20%204%EC%B8%B5%20%EC%A0%84%EC%84%B8%EA%B3%84%5BEMS%5D%EB%B0%B0%EC%86%A1%20%EB%8B%B4%EB%8B%B9%EC%9E%90',
            'gblRcvrTlphn'=> '1599-5115',
            'gblRcvrPrtblNo'=> '000-000-0000',
            'shOrdLang'=> '',
            'shDlvClfCd'=> '',
            'shVisitDlvYn'=> 'N',
            'shUsimDlvYn'=> 'N'
        ];

        $crawler = $client->request('POST', 'https://soffice.11st.co.kr/escrow/OrderingLogisticsAction.tmall?method=getOrderLogisticsList&listType=orderingLogistics&start=0&limit=30&shDateType=01&shDateFrom='. $start_date . '&shDateTo=' . $end_date . '&shBuyerType=&shBuyerText=&shProductStat=ALL&shDelayReport=&shPurchaseConfirm=&shGblDlv=N&prdNo=&shStckNo=&shOrderType=on&shToday=&shDelay=&addrSeq=&isAbrdSellerYn=&abrdOrdPrdStat=&isItalyAgencyYn=&shErrYN=&gblRcvrNm=%25EA%25B8%2580%25EB%25A1%259C%25EB%25B2%258C%25ED%2586%25B5%25ED%2595%25A9%25EB%25B0%25B0%25EC%2586%25A1%25EC%25A7%2580&gblRcvrMailNo=17382&gblRcvrBaseAddr=%25EA%25B2%25BD%25EA%25B8%25B0%25EB%258F%2584%2520%25EC%259D%25B4%25EC%25B2%259C%25EC%258B%259C%2520%25EB%25A7%2588%25EC%259E%25A5%25EB%25A9%25B4%2520%25EB%25A7%2588%25EB%258F%2584%25EB%25A1%259C%2520177%2520&gblRcvrDtlsAddr=%25EA%25B2%25BD%25EA%25B8%25B0%25EB%258F%2584%2520%25EC%259D%25B4%25EC%25B2%259C%25EC%258B%259C%2520%25EB%25A7%2588%25EC%259E%25A5%25EB%25A9%25B4%2520%25EB%25A7%2588%25EB%258F%2584%25EB%25A1%259C%2520177%2520%25204%25EC%25B8%25B5%2520%25EC%25A0%2584%25EC%2584%25B8%25EA%25B3%2584%255BEMS%255D%25EB%25B0%25B0%25EC%2586%25A1%2520%25EB%258B%25B4%25EB%258B%25B9%25EC%259E%2590&gblRcvrTlphn=1599-5115&gblRcvrPrtblNo=000-000-0000&shOrdLang=&shDlvClfCd=&shVisitDlvYn=N&shUsimDlvYn=N', $data);
        $dataOrder = json_decode($client->getResponse()->getContent(),true);
        // echo "<pre>";
        // print_r($dataOrder);
        // die;
        if ($dataOrder['orderingLogistics']) {
            foreach ($dataOrder['orderingLogistics'] as $items) {
                //$sellerProductId = microtime(true) * 10000;
                if (isset($items['INVC_NO'])) {
                    $ticket = [
                        'ticketNumber' => $items['INVC_NO'],
                        'purchasedAt' => $items['ORD_STL_END_DT'], // Ngày đặt hàng
                        'price' => str_replace(',' , '', $items['SEL_PRC']), // giá bán
                        'useAmount' => $items['ORD_QTY'],// $items['ORDER_AMT'], // Số lượng đơn đặt hàng
                        'totalAmount' => $items['ORD_QTY'],
                        'dealId' => $items['PRD_NO']
                    ];
                    $result = $this->_model->loadRecords('ticket', ['ticketNumber' => $items['INVC_NO']]);
                    if ($result) {
                        $this->_model->updateRecord('ticket', $ticket, ['ticketNumber' => $items['INVC_NO']]);
                    }else {
                        $this->_model->insertRecord('ticket', $ticket);
                    }                    
                    $dealName=str_replace('<DIV style="TEXT-ALIGN: center; PADDING-BOTTOM: 2px; MARGIN-TOP: 0px; TEXT-OVERFLOW: ellipsis; OVERFLOW: hidden"><FONT style="CURSOR: pointer; TEXT-DECORATION: underline">', '', $items['PRD_NM_VIEW']);
                    $dealName=str_replace('</FONT></DIV>', '', $dealName);
                    $ticketPurchasers = [
                        'orderNumber' => $items['ORD_NO'], //
                        'ticketNumber' => $items['INVC_NO'],
                        'purchaseDateTime' => $items['ORD_STL_END_DT'], // Ngày đặt hàng
                        'price' => str_replace(',' , '', $items['SEL_PRC']), // giá bán
                        'fee' => str_replace(',' , '', $items['SEL_FEE_RT']), // Phí dịch vụ
                        'dealId' => $items['PRD_NO'], //
                        'dealName' => $dealName,
                        'optionId' => "",
                        'optionName' => "",
                        'userName' => $items['MEM_ID'], // Người mua (ID)
                        'phoneNumber' => $items['RCVR_PRTBL_NO'], //   Thông tin liên lạc 2
                        'channel_name' =>  "11ST"
                    ];
                    
                    $result = $this->_model->loadRecords('ticketPurchasers', ['ticketNumber' => $items['INVC_NO']]);
                    if ($result) {
                        $this->_model->updateRecord('ticketPurchasers', $ticketPurchasers, ['ticketNumber' => $items['INVC_NO']]);
                    }else {
                        $this->_model->insertRecord('ticketPurchasers', $ticketPurchasers);
                    }
                    
                    
                }
            }
        }
        
    }

    // Upload file đăng ký sản phẩm
    public function uploadFileProductAction() {
        if(isset($_FILES['fileToUpload'])) {
            $office = new OfficeExcel(); 
            // echo '<pre>';
            // print_r($_FILES['fileToUpload']);
            $dataExcel = $office->readuploadProductS11ST($_FILES['fileToUpload']['tmp_name'],  0); 

            foreach ($dataExcel as $key =>$product) {
               
                // echo '<pre>';
                // print_r($product);

                $data = [
                    'site' => trim($product['C']),
                    'salesID' => trim($product['D']),
                    'productName' => trim($product['E']),
                    'nickname' => trim($product['F']),
                    'productGroupClassification' => trim($product['G']),
                    'mainCategory' => trim($product['H']),
                    'middleCategory' => trim($product['I']),
                    'subclass' => trim($product['J']),
                    'salesFormat' => trim($product['L']),
                    'serviceProduct' => trim($product['M']),
                    'reservationPeriod' => trim($product['N']),
                    'estimatedWarehousingDate' => trim($product['O']),
                    'salesPeriod' => trim($product['P']),
                    'productStatus' => trim($product['Q']),
                    'numberOfMonthsOfUse' => trim($product['R']),
                    'salePriceAttheTimeOfPurchase' => trim($product['S']),
                    'dateOfManufacture' => trim($product['T']),
                    'effectiveDate' => trim($product['U']),
                    'appearanceFunctionSpecifics' => trim($product['V']),
                    'imageRegistration' => trim($product['W']),
                    'availableForPurchaseByMinors' => trim($product['X']),
                    'origin' => trim($product['Y']),
                    'vatDutyFreeProducts' => trim($product['Z']),
                    'overseasPurchasingAgentPrd' => trim($product['AA']),
                    'price' => trim($product['AB']),
                    'availableStock' => trim($product['AC']),
                    'detailedExplanation' => trim($product['AD']),
                    'productType' => trim($product['AE']),
                    'partnerProductURL' => trim($product['AF']),
                    'firstDepartureDate' => trim($product['AG']),
                    'lastDepartureDate' => trim($product['AH']),
                    'selectCityProvince' => trim($product['AI']),
                    'selectCityCountyGu' => trim($product['AJ']),
                    'aplBgnDy' => trim($product['AK']),
                    'aplEndDy' => trim($product['AL']),
                    'deliveryAvailableArea' => trim($product['AM']),
                    'shippingMethod' => trim($product['AN']),
                    'ShippingCourier' => trim($product['AO']),
                    'shipmentType' => trim($product['AP']),
                    'weekday' => trim($product['AQ']),
                    'shippingAddress' => trim($product['AR']),
                    'returnExchangeAddress' => trim($product['AS']),
                    'burden' => trim($product['AT']),
                    'typeOfShippingCost' => trim($product['AU']),
                    'shippingFee' => trim($product['AV']),
                    'returnshippingfee' => trim($product['AW']),
                    'exchangeShippingCost' => trim($product['AX']),
                    'asInformation' => trim($product['AY']),
                    'returnExchangeInformation' => trim($product['AZ']),
                    'createtime' => date( "Y-m-d h:i:s"),
                ];

                // echo '<pre>';
                // print_r($data);
                $insertS11St = $this->_model->insertRecord('need_send_to_11', $data);
                if ($insertS11St) echo 'Data insert is successful! at row: ' . ((int)$key + 6) . '</br>';
                else echo 'Data insert is unsuccessful! at row: ' . ((int)$key + 6) . '</br>';
            }

        }else{
        
            echo '<form action="" method="POST" enctype="multipart/form-data" >
                        <input type="file" name="fileToUpload"/>
                        <input type="submit" name="submit" value="submit"/>  
                </form>';
        
        }
    }


    // Đăng ký sản phẩm
    public function applyProductInfoAction() {
//         echo '<pre>';
//         print_r($_POST);
        
//         print_r($_FILES);
        
//         echo json_encode($_POST)."<br>";
        
//         echo json_encode($_FILES)."<br>";

// //         die();
        $client = new Client( HttpClient::create(['timeout' => 60]));
        // đăng nhập
        $crawler = $client->request('POST', 'https://login.11st.co.kr/auth/front/selleroffice/logincheck.tmall');
        $form = $crawler->selectButton("로그인")->form();
        $crawler = $client->submit($form, array(
            'encryptedLoginName'=> '9c7db06852fbbf8698ad4dc5998697c2a215300ae99bfa2cfefc633e219783d15774d2ce55ef41366172d92a4c7404164295673f726074bcc9e6ea708999d7b2f7eb26a8d8c239732b716a0f781112faa1d5540c4bab6474972bebd1f2daa69c244f4450792f6d9ea3171544fc4e61692a4d2652980b440e4013fb4c1dfac0cd',
            'encryptedPassWord'=> '9f914d7c95360c590c6d22ddbde670a917316b0e37d766d43babfcc32208ce488f8a69eab512fa9bbd63733301a52d0acadbbe81c904c5d341d2235581ff059de14f83ff0cec1fc699a86d558fc9ad993469147390733f70e4c85197bb38dc8831dcfc23a95137d1ddab1486d346ee268bf3835fc94faf423aa4c1738dc61799',
            'priority'=> 96,
            'authMethod'=> 'login',
            'returnURL'=> 'http://soffice.11st.co.kr?ts=1601958706442',
            'loginName'=> 'ysjlabs',
            'passWord' => 'yakeun87!@',));
       
//         // image
//         $data =[
//             'categoryNo' => '1129326',
//             'imagePath' => 'http://cdn.011st.com/11dims/resize/600x600/quality/75/11src/pd/20/7/7/0/0/9/6/MGSEh/2941770096_B.jpg'
//         ];

//         $crawler = $client->request('GET', 'https://apis.11st.co.kr/product/hulk/v2/productCleansing/image?' . http_build_query($data));
//         $content =$client->getResponse()->getContent();
//         echo '<pre>';
//         print_r($content);
//         echo '</pre>';
        
        //$content =$client->getResponse()->getContent();
        echo '<pre>';
        $client->xmlHttpRequest('GET', 'https://soffice.11st.co.kr/product/UnitProductRegAction.tmall?method=regForm&urlType=SO');
        
        $client->xmlHttpRequest('GET', 'https://soffice.11st.co.kr/product/UnitProductRegAjaxAction.tmall?dispCtgrNo=1129331&method=getOptInfoByCtgr');
        
        
        $jsonData = file_get_contents("http://stylehanquoc.com/Screenshot_10.png");
        $client->xmlHttpRequest('POST', 'https://apis.11st.co.kr/product/hulk/v2/preprocess/image/B',[],[],[],$jsonData);
        $image = json_decode($client->getResponse()->getContent(),true);
        echo $image['data'];
        
        
        $client->xmlHttpRequest('GET', 'https://apis.11st.co.kr/product/hulk/v2/productCleansing/image?categoryNo=1129331&imagePath='.$image['data']);
        $content =json_decode($client->getResponse()->getContent(),true);
        print_r($content);
        
        $client->xmlHttpRequest('OPTIONS', 'https://apis.11st.co.kr/product/hulk/v2/productCleansing/image?categoryNo=1129331&imagePath='.$image['data']);
        $content =$client->getResponse()->getContent();
        print_r($content);
        
        
        $data= [
            'ctgrNo' => '1129331',
            'urlType' => 'SO',
        ];
        $client->xmlHttpRequest('POST', 'https://soffice.11st.co.kr/product/ProductRegAjax.tmall?method=getServiceProductComboDataList',$data);
        $content = json_decode($client->getResponse()->getContent(),true);
        //print_r($content);
        
        // https://apis.11st.co.kr/product/hulk/v2/productCleansing/prdNm               kiểm tra sạch sản phẩm
        $data = [
            'prdNm'=> 'aaaaa',
            'mCtgr'=> '1017871'
        ];
        
        $crawler = $client->xmlHttpRequest('POST', 'https://apis.11st.co.kr/product/hulk/v2/productCleansing/prdNm', $data);
        $content =json_decode($client->getResponse()->getContent(),true);
        print_r($content);
        
        //https://apis.11st.co.kr/product/hulk/v2/productCleansing/advrtStmt       kiểm tra sạch vản bản
        $data = [
        'prdNm' => 'aaaaa',
        'advrtStmt' => 'aaaaa'
                ];
        
        $crawler = $client->request('POST', 'https://apis.11st.co.kr/product/hulk/v2/productCleansing/advrtStmt', $data);
        $content =json_decode($client->getResponse()->getContent(),true);
        print_r($content);
   
        
        $data= [
            'dispCtgrNo' => '1129331',
            'content' => 'aaaaa'
        ];
        $client->xmlHttpRequest('POST', 'https://soffice.11st.co.kr/tns/tnsKeywdPrdFilterAjax.tmall?method=getKeywdPrdFilterCnt',$data);
        $content =json_decode($client->getResponse()->getContent(),true);
        print_r($content);
        
        
        $data= [
            'dispCtgrNo' => '1129331',
            'content' => ''
        ];
        $client->xmlHttpRequest('POST', 'https://soffice.11st.co.kr/tns/tnsKeywdPrdFilterAjax.tmall?method=getKeywdPrdFilterCnt',$data);
        $content =json_decode($client->getResponse()->getContent(),true);
        print_r($content);
        
        // đăng ký sản phẩm
        
        $data = [   //1129331:Y:03:N:09::N:01::Y:N
            'method' => 'applyProductInfo',
            'stdPrdYn' => 'Y',
            'prdNo' => '',
            'userNo' => '61539422',
            'selMnbdNo' => '61539422',
            'memTyp' => '02',
            'prdTypCd' => '10',
            'orgPrdTypCd' => '',
            'dispCtgrNo' => '1129331',
            'originDispCtgrNo' => '',
            'sellerAuth' => 'Y',
            'dispCtgrStatCd' => '03',
            'dispCtgrUseYn' => 'Y',
            'rootCtgrNo' => '117025',
            'mnfcYN' => '',
            'dispCtgrPrdTypCd' => '09',
            'serviceCouponYN' => 'N',
            'mobileYn' => 'N',
            'HtmlDetail' => 'aaaa',
            'HtmlDetailJson' => '',
            'intfreeApplyYn' => 'Y',
            'selMthdCd' => '01',
            'setTypCd' => '01',
            'selStatCd' => '',
            'autoPrcsedStartDy' => '',
            'preSelPrdClfCd' => '',
            'preSelMthdCd' => '01',
            'preCategory2' => '1017871',
            'preCategory3' => '1017872',
            'originSelPrc' => '',
            'mobile1WonApprvAsk' => '',
            'selLimitQty' => '0',
            'selMinLimitQty' => '0',
            'buyUntQty' => '0',
            'checkAbrdBrandYn' => 'N',
            'isAbrdInteg' => 'false',
            'checkYes24' => 'false',
            'checkSoYes24' => 'false',
            'checkKyoBo' => 'false',
            'sndPlnTrm' => '4',
            'suplDtyfrPrdClfCd' => '01',
            'mrgnPolicyCd' => '',
            'shopNo' => '',
            'cyberMoney' => '0',
            'hasPoint' => '2425',
            'dispAmount' => '0',
            'dispRealAmount' => '0',
            'payAmount' => '0',
            'payCommonCoupon' => 'N',
            'payCouponAmount' => '0',
            'preDispAmount' => '0',
            'saleStartDate' => '20201015',
            'saleEndDate' => '20210211',
            'preStartDate' => '2020/10/15',
            'obCouponCobuyRate' => '0',
            'obCouponDispItemRate' => '0',
            'sellerItemEventYn' => 'N',
            'sellerCash' => '0',
            'mobileSellerYN' => 'N',
            'allkeyword' => '',
            'lowPrcCompExYn' => '',
            'ctgrPntPreExYn' => '',
            'productSCashChargUrl' => 'https://soffice.11st.co.kr/loyalty/CyberMoneyChargeAction.tmall?method=CyberMoneyCharge',
            'productSPointChargUrl' => 'https://soffice.11st.co.kr/loyalty/AuthSellerPointCondition.tmall?method=goSellerPointChargePage%26chargeDomain=soSellerPrdInfo',
            'prdCopyYn' => 'N',
            'prdCopyYnOpt' => 'N',
            'reRegPrdNo' => '',
            'reRegYn' => '',
            'reNewYn' => 'N',
            'displayYn' => '',
            'popYn' => '',
            'formType' => 'N',
            'createCd' => '0200',
            'regTypeCd' => '',
            'styleCtgrNo' => '195046',
            'maxLimitQty' => '0',
            '_help_msg_' => '',
            'applyInfo' => '[{prdNo:0,dispItemList:[],dispAutoItemList:[],listAdCupnList:[]}]',
            'frSellerYN' => 'N',
            'frPrdNo' => '',
            'pdEventCnt' => '0',
            'evtConfirmCnt' => '0',
            'cHkPrdStatCd' => '01',
            'svcAreaCd' => '',
            'townPrdYn' => 'N',
            'selNo' => '61539422',
            'simpleYn' => 'N',
            'isTownExcelUser' => 'N',
            'townSellerCertType' => '',
            'dispCtgrGblDlvYn' => 'N',
            'sellerGblDlvYn' => 'Y',
            'infoTypeCtgrNo' => '891011',
            'prdInfoTmpltNo' => '0',
            'isCtgrAttr' => 'N',
            'adultCtgr' => 'N',
            'adltCrtfYn' => 'Y',
            'rentalCategoryYn' => 'N',
            'oriPrdSelQty' => '',
            'offerDispLmtYn' => 'N',
            'cellClickRowIdx' => '',
            'bookClfCd' => '',
            'isAbrdSubInteg' => 'false',
            'seriesPrdYn' => 'false',
            'minusCtlgNo' => '',
            'prdTypCdChangeYn' => '',
            'eventPrdYn' => '',
            'employeeNo' => '',
            'ktb_agent' => '',
            'rsvSchdlYN' => 'N',
            'prdRiousQty' => '0',
            'svcCnAreaRgnAddrCd' => '',
            'svcCnAreaRgnClfCd' => '',
            'svcCnAreaSidoNm' => '',
            'svcCnAreaSiGunGuNm' => '',
            'svcCnAreaUeupMyonNm' => '',
            'svcCnAreaUeupMyonCd' => '',
            'bindProduct' => 'false',
            'addtInfoList' => '[]',
            'browserValue' => 'Chrome+86',
            'tourDateAttrNos' => '',
            'recomCtgrNos' => '',
            'validated' => 'validated',
            'isTWDSeller' => 'false',
            'isTWDCategory' => 'false',
            'currentYY' => '2020',
            'noUseOptionYn' => 'N',
            'is11PayView' => 'true',
            'otherPrdRegYn' => 'N',
            'isUpdate' => 'false',
            'canChangeStdPrdNm' => 'true',
            'preModelNo' => '',
            'ctlgModelNo' => '',
            'modelExistYn' => 'N',
            'factory' => '',
            'brandNm' => '',
            'preModelNm' => '',
            'ctlgNo' => '',
            'ctlgSvcClf' => '',
            'ctlgUseYn' => '',
            'martPrdYn' => '',
            'newMartPrdYn' => 'N',
            'brandNmTmp' => '',
            'brandCdTmp' => '',
            'cmAttrYn' => '',
            'chgModel' => '',
            'brand' => '',
            'modelNm' => '',
            'prdNm' => 'bbbbb',
            'prdclnsg_api_req_prd_nm' => 'bbbbb',
            'advrtStmt' => '',
            'prdclnsg_api_req_advrt_stmt' => '',
            'sellerPrdNmEn' => '7JiB7Ja0LOyIq%2ByekOunjCDsnoXroKUg6rCA64ql7ZWp64uI64ukLg==',
            'sellerPrdNmCn' => '7KSR6rWt7Ja0LOyYgeyWtCzsiKvsnpDrp4wg7J6F66ClIOqwgOuKpe2VqeuLiOuLpC4=',
            'sellerPrdNmEnPre' => '',
            'sellerPrdNmCnPre' => '',
            'engDispYn' => 'Y',
            'prdNmEng' => '영어,숫자만 입력 가능합니다.',
            'recentCtgr' => '1129331:117025%3E1017871%3E1017872%3E1129331',
            'selPrdTypCd' => '10',
            'chkSelMthdCd' => '01',
            'prdStatCd' => '01',
            'useMon' => '',
            'useMonTxt' => '',
            'paidSelPrc' => '',
            'usedMnfcDy' => '',
            'usedEftvDy' => '',
            'specialNoteComboBox' => '외관일부파손',
            'exteriorSpecialNote' => '',
            'selTermUseYn' => 'Y',
            'selPrdClfCd' => '120:108',
            'aplBgnDy' => '2020/10/15',
            'aplBgnHh' => '00',
            'aplBgnMi' => '00',
            'aplBgnSs' => '00',
            'aplEndDy' => '2021/02/11',
            'aplEndHh' => '23',
            'aplEndMi' => '59',
            'aplEndSs' => '59',
            'autoPrcsClfCd' => '',
            'fpSelTermUseYn' => 'Y',
            'selPrdClfFpCd' => '-1:-1',
            'useLimitDay' => '',
            'usePrdClfCd' => '0:500',
            'useBgnDy' => '',
            'useEndDy' => '',
            'wrhsPlnDy' => '',
            'prdRiousQtyYN' => 'N',
            'dlvProcCanDD' => '1',
            'clickPrdNumber' => '01',
            'imageKindChk' => '01',
            'uploadHost' => 'http://image.11st.co.kr',
            'uploadPath' => '/data1/upload/imgprd',
            'isFreeImageSize' => 'N',
            'productImageCapaCheckSize' => '3145728',
            'productImageCapaSize' => '3MB',
            'prdImage01' => 'Screenshot_10.png',
            'prdImage01_FileNm' => 'C:\Screenshot_10.png',
            'prdImageNo01' => '',
            'prdImageEditorUrl01' => '',
            'prdImageEditorRealName01' => '',
            'prdImageUrl01' => '',
            'prdImageUrl01Host' => '',
            'prdImageChk01' => 'Y',
            'prdImagePath01' => '/product/tmp/reg/20201014/61539422/61539422_20201014111613187_MFpHN.png',
            'prdImage02' => '',
            'prdImage02_FileNm' => '',
            'prdImageNo02' => '',
            'prdImageEditorUrl02' => '',
            'prdImageEditorRealName02' => '',
            'prdImageUrl02' => '',
            'prdImageUrl02Host' => '',
            'prdImageChk02' => 'N',
            'prdImagePath02' => '',
            'prdImage03' => '',
            'prdIage03_FileNm' => '',
            'prdImageNo03' => '',
            'prdImageEditorUrl03' => '',
            'prdImageEditorRealName03' => '',
            'prdImageUrl03' => '',
            'prdImageUrl03Host' => '',
            'prdImageChk03' => 'N',
            'prdImagePath03' => '',
            'prdImage04' => '',
            'prdImage04_FileNm' => '',
            'prdImageNo04' => '',
            'prdImageEditorUrl04' => '',
            'prdImageEditorRealName04' => '',
            'prdImageUrl04' => '',
            'prdImageUrl04Host' => '',
            'prdImageChk04' => 'N',
            'prdImagePath04' => '',
            'prdImage05' => '',
            'prdImage05_FileNm' => '',
            'prdImageNo05' => '',
            'prdImageEditorUrl05' => '',
            'prdImageEditorRealName05' => '',
            'prdImageUrl05' => '',
            'prdImageUrl05Host' => '',
            'prdImageChk05' => 'N',
            'prdImagePath05' => '',
            'dealImageSize' => '3145728',
            'dealImageSizeView' => '3MB',
            'dealImageWidthLimit' => '720',
            'dealImageHeightLimit' => '360',
            'prdImageUrl09' => '',
            'prdImage09' => '',
            'prdImage09_FileNm' => '',
            'prdImage010' => '',
            'prdImage010_FileNm' => '',
            'prdImageNo010' => '',
            'prdImageEditorUrl010' => '',
            'prdImageEditorRealName010' => '',
            'prdImageUrl010' => '',
            'prdImageUrl010Host' => '',
            'prdImageChk010' => 'N',
            'minorSelCnYn' => 'Y',
            'materialInfo' => '',
            'orgnTypCd' => '01',
            'orgnNm' => '',
            'beefTraceNo' => '',
            'beefTraceDtl' => '',
            'chkSuplDtyfrPrdClfCd' => '01',
            'yearEndTaxYn' => 'N',
            'certInfoCnt' => '0',
            'crtfGrpObjClfCd01' => '01',
            'crtfGrpExptTypCd01' => '',
            'crtfGrpObjClfCd02' => '01',
            'crtfGrpObjClfCd03' => '01',
            'crtfGrpObjClfCd04' => '05',
            'medNum1' => '',
            'medNum2' => '',
            'medNum3' => '',
            'theaterMnfcDy' => '',
            'theaterEftvDy' => '',
            'seatTyp' => 'Y',
            'theaterNm' => '',
            'theaterAreaInfo' => '',
            'selPrc' => '1,000',
            'calcSelFeeAmt' => '80',
            'addtInfo01' => '0',
            'addtInfo02' => '0',
            'addtInfo03' => '0',
            'colTitle' => '',
            'colValue0' => '',
            'colValue1' => '',
            'colValue2' => '',
            'colCount' => '',
            'colOptPrice' => '',
            'colPuchPrc' => '',
            'colMrgnRt' => '',
            'colMrgnAmt' => '',
            'colAprvStatCd' => '',
            'prdStckStatCd' => '',
            'colBarCode' => '',
            'colOptWght' => '',
            'colCstmAplPrc' => '',
            'optClfCd' => '01',
            'optChangeYn' => 'Y',
            'txtColCnt' => '',
            'optTypCd' => '',
            'martPrdYn' => '',
            'colSellerStockCd' => '',
            'twdCatalogMapCd' => '',
            'ptnrPrdSellerYN' => 'N',
            'prdExposeClfCd' => '00',
            'addProductMaxCnt' => '0',
            'addProductMaxIdx' => '0',
            'dispPrrtRnk' => '0',
            'prdSelQty' => '100',
            'rsvSchdlClfCd' => '01',
            'rsvSchdlModifyYN' => 'N',
            'maktPrc' => '',
            'maktRt' => '',
            'mpContractTypCd' => '01',
            'hdRepFeeYN' => '',
            'moblieFeeGrpNm' => '선택하세요',
            'moblieFeeNm' => '선택하세요',
            'mobileMthFee' => '',
            'contractTermCd' => '',
            'mobilePhoneInstallmentArr' => '',
            'mpFeeNo' => '',
            'mrgnRt' => '',
            'mrgnAmt' => '',
            'puchRt' => '',
            'puchPrc' => '',
            'cstmAplPrc' => '',
            'prdCautions' => '',
            'notDealPage' => 'true',
            'chkPrdDescWrite' => 'Y',
            'designTemplate' => 'Y',
            'templateType' => 'basic',
            'layoutType' => '1',
            'descTypeCode' => '99',
            'callbygridYNStr' => 'N',
            'smartOptionYN' => '',
            'introHtmlDetail' => '',
            'outroHtmlDetail' => '',
            'prdDtlDescStr' => '',
            'reviewDispYn' => 'Y',
            'prdImage08' => '',
            'prdImage08_FileNm' => '',
            'prdImageNo08' => '',
            'prdImageEditorUrl08' => '',
            'prdImageEditorRealName08' => '',
            'prdImageUrl08' => '',
            'prdImageUrl08Host' => '',
            'prdImageChk08' => 'N',
            'movieObjNo' => '0',
            'svcCanRgnClfCd' => '01',
            'previousSvcCanRgnClfCd' => '',
            'prdAttrNm' => '색상',
            'prdAttrNo' => '200044',
            'prdAttrCd' => '11835',
            'prdAttrType' => 'null',
            'prdAttrChkNo' => '200044',
            '200044' => '상품상세설명 참조',
            'chkattrValueNm0' => '상품상세설명 참조',
            'prdAttrNm' => '세탁방법 및 취급시 주의사항',
            'prdAttrNo' => '200054',
            'prdAttrCd' => '23756520',
            'prdAttrType' => '02',
            'prdAttrChkNo' => '200054',
            '200054' => '상품상세설명 참조',
            'chkattrValueNm1' => '상품상세설명 참조',
            'prdAttrNm' => '제조국',
            'prdAttrNo' => '200121',
            'prdAttrCd' => '23759095',
            'prdAttrType' => '02',
            'prdAttrChkNo' => '200121',
            '200121' => '상품상세설명 참조',
            'chkattrValueNm2' => '상품상세설명 참조',
            'prdAttrNm' => '제조연월',
            'prdAttrNo' => '200167',
            'prdAttrCd' => '23759308',
            'prdAttrType' => '02',
            'prdAttrChkNo' => '200167',
            '200167' => '상품상세설명 참조',
            'chkattrValueNm3' => '상품상세설명 참조',
            'prdAttrNm' => '제품 소재',
            'prdAttrNo' => '200177',
            'prdAttrCd' => '23759468',
            'prdAttrType' => '02',
            'prdAttrChkNo' => '200177',
            '200177' => '상품상세설명 참조',
            'chkattrValueNm4' => '상품상세설명 참조',
            'prdAttrNm' => '제조자/수입품의 경우 수입자를 함께 표기',
            'prdAttrNo' => '200144',
            'prdAttrCd' => '11905',
            'prdAttrType' => '01',
            'prdAttrChkNo' => '200144',
            '200144' => '상품상세설명 참조',
            'chkattrValueNm5' => '상품상세설명 참조',
            'prdAttrNm' => '치수',
            'prdAttrNo' => '200229',
            'prdAttrCd' => '23760034',
            'prdAttrType' => '02',
            'prdAttrChkNo' => '200229',
            '200229' => '상품상세설명 참조',
            'chkattrValueNm6' => '상품상세설명 참조',
            'prdAttrNm' => 'A/S 책임자와 전화번호',
            'prdAttrNo' => '200282',
            'prdAttrCd' => '23760437',
            'prdAttrType' => '02',
            'prdAttrChkNo' => '200282',
            '200282' => '상품상세설명 참조',
            'chkattrValueNm7' => '상품상세설명 참조',
            'prdAttrNm' => '품질보증기준',
            'prdAttrNo' => '200259',
            'prdAttrCd' => '23760386',
            'prdAttrType' => '02',
            'prdAttrChkNo' => '200259',
            '200259' => '상품상세설명 참조',
            'chkattrValueNm8' => '상품상세설명 참조',
            'prdAttrNm' => '발행처',
            'prdAttrNo' => '269115',
            'prdAttrCd' => '11811',
            'prdAttrType' => '01',
            'prdAttrChkNo' => '269115',
            '269115' => '상품상세설명 참조',
            'chkattrValueNm9' => '상품상세설명 참조',
            'prdAttrNm' => '종류',
            'prdAttrNo' => '269117',
            'prdAttrCd' => '11908',
            'prdAttrType' => '01',
            'prdAttrChkNo' => '269117',
            '269117' => '상품상세설명 참조',
            'chkattrValueNm10' => '상품상세설명 참조',
            'prdAttrNm' => '티켓명',
            'prdAttrNo' => '269118',
            'prdAttrCd' => '11942',
            'prdAttrType' => 'null',
            'prdAttrChkNo' => '269118',
            '269118' => '상품상세설명 참조',
            'chkattrValueNm11' => '상품상세설명 참조',
            'prdDetailOutLink' => '',
            'prdSvcBgnDy' => '',
            'prdSvcEndDy' => '',
            'ticketSvcBgnDy' => '',
            'ticketSvcBgnTime' => '',
            'ticketSvcEndDy' => '',
            'ticketSvcEndTime' => '',
            'agencyBsnsNo' => '',
            'agencyNm' => '',
            'agencyBsnsSt' => '',
            'gencyItm' => '',
            'rptvNm' => '',
            'rptvTlphnNoNo' => '',
            'rptvEmailAddr' => '',
            'enpPlcAddr' => '',
            'preVwCd' => '',
            'freeGiftTgNo1' => '',
            'freeGiftTgNo2' => '',
            'infoAddText' => '',
            'selMnbdNckNmSeq' => '933027',
            'releaseYY' => '',
            'releaseMM' => '',
            'modelCd' => '',
            'sellerPrdCd' => '',
            'selMinLimitTypCd' => '00',
            'selLimitTypCd' => '00',
            'bcktExYn' => 'Y',
            'orderCmltOutLink' => '',
            'mudvdLabel' => '',
            'mnfcDy' => '',
            'eftvDy' => '',
            'mainTitle' => '',
            'transInfo' => '',
            'picInfo' => '',
            'isbn13Cd' => '',
            'isbn10Cd' => '',
            'bookAddCd' => '',
            'prcCmpExpYn' => 'Y',
            'giftNm' => '',
            'giftAplBgnDt_old' => '2020/10/14',
            'giftAplEndDt_old' => '2020/10/14',
            'giftAplBgnDt' => '2020/10/14',
            'giftAplEndDt' => '2020/10/14',
            'giftImageUrl_UploadYn' => 'N',
            'giftImageUrl_File' => '',
            'giftImageUrl_FileNm' => '',
            'giftImageUrl_Path' => '',
            'giftInfo' => '',
            'gftPackTypCd' => '01',
            'coCardBnft' => '',
            'instCstDesc' => '',
            'frgftDesc' => '',
            'etcInfo' => '',
            'rcptIsuCnYn' => 'Y',
            'todayDlvCnYn' => 'N',
            'appmtDyDlvCnYn' => 'N',
            'bndlDlvCnYn' => 'Y',
            'bsnDealClf' => '01',
            'dlvClf' => '02',
            'outMemNo' => '61539422',
            'inMemNo' => '61539422',
            'abrdInCd' => '',
            'kglFreePickupYN' => 'N',
            'tmplYn' => 'N',
            'isAbrdIntegId' => 'false',
            'isAbrdSubIntegId' => 'false',
            'itgAddrSeq' => '0',
            'globalOutMemNo' => '0',
            'globalInMemNo' => '0',
            'incFormType' => 'N',
            'wholeYn' => 'N',
            'frCtrCd' => '',
            'pdEventCnt' => '0',
            'prdCopyYn' => 'N',
            'bakPrdWght' => '',
            'bakGblHsCode' => '',
            'gblDlvYnValue' => 'N',
            'hasPermToSecureInstall' => 'false',
            'selTempleteInput' => '790596',
            'gblDlvYn' => '',
            'gblHsCode' => '',
            'dlvCnAreaCd' => '03',
            'dlvWyCd' => '04',
            'dlvEtprsCd' => '',
            'dlvSendCloseTmpltNo' => '694389',
            'sendClfCd' => '02',
            'sendCmplTerm' => '1',
            'wkdayPayCmplHm' => '',
            'satPayCmplHm' => '',
            'mbAddrLocation02' => '01',
            'outAddrSeq' => '5',
            'mbAddrLocation03' => '01',
            'inAddrSeq' => '6',
            'mbAddrLocation07' => '',
            'visitExchAddrSeq' => '',
            'mbAddrLocation05' => '',
            'globalOutAddrSeq' => '',
            'globalOutAddrNM' => '',
            'mbAddrLocation06' => '',
            'globalInAddrSeq' => '',
            'globalInAddrNM' => '',
            'chkDlvClf' => '02',
            'prdWght' => '',
            'exptDlvCst' => '',
            'volumeWidth' => '',
            'volumeColumn' => '',
            'volumeHeight' => '',
            'ntNo' => '',
            'dlvCstInstBasiCd' => '01',
            'cmbBndlDlvCnYn' => 'Y',
            'sellerBasiDlvCstTxt' => '',
            'dlvCstPayTypCd' => '03',
            'addrBasiDlvCstTxt' => '무료@1원 미만 구매/무료@1원 이상 구매',
            'dlvCnt2' => '999999999',
            'mbAddrLocation04' => '',
            'visitAddrSeq' => '',
            'abrdCnDlvCst' => '',
            'rtngdDlvCst' => '2,500',
            'rtngdDlvCd' => '02',
            'exchDlvCst' => '5,000',
            'ASDetail' => '1544-2602',
            'rtngExchDetail' => '1544-2602',
            'selInfoTempleteNm' => '템플릿 이름을 입력해 주세요.',
            'addQueryCont' => '',
            'addQueryHintCont' => '',
            'refundTargetFlag' => 'false',
            'dispItemNo' => '181',
            'selDisplayItemTerm' => '0',
            'svcBgnDy' => '2020-10-14',
            'selAutoDisplayItemTerm' => '0',
            'selAutoDisplayItemTerm' => '0',
            'svcEndDy' => '2020-11-13',
            'refundTargetFlag' => 'false',
            'dispItemNo' => '343',
            'selDisplayItemTerm' => '0',
            'svcBgnDy' => '2020-10-14',
            'selAutoDisplayItemTerm' => '0',
            'selAutoDisplayItemTerm' => '0',
            'svcEndDy' => '2020-11-13',
            'refundTargetFlag' => 'false',
            'dispItemNo' => '400',
            'svcBgnDy' => '2020-10-14',
            'selAutoDisplayItemTerm' => '0',
            'selAutoDisplayItemTerm' => '0',
            'refundTargetFlag' => 'false',
            'dispItemNo' => '201',
            'svcBgnDy' => '2020-10-14',
            'selAutoDisplayItemTerm' => '0',
            'selAutoDisplayItemTerm' => '0',
            'refundTargetFlag' => 'false',
            'dispItemNo' => '182',
            'svcBgnDy' => '2020-10-14',
            'selAutoDisplayItemTerm' => '0',
            'selAutoDisplayItemTerm' => '0',
            'payPoint' => '0',
            'payCash' => '0',
            'payCyberMoney' => '0',
            'payCouponAmount09' => '0',
            'dscCouponTerm09' => '0',
       ];
        
        $post= [
                    'prdImage01' => [
                        'name' => 'Screenshot_10.png',
                        //'type' => 'image/png',
                        'tmp_name' => "http://stylehanquoc.com/Screenshot_10.png",
                        //'error' => '0',
                        //'size' => '40775'
                    ],
//                     'prdImage02' => [],
//                     'prdImage03' => [],
//                     'prdImage04' => [],
//                     'prdImage05' => [],
//                     'prdImage08' => [],
//                     'prdImage09' => [],
//                     'prdImage010' => [],
//                     'giftImageUrl_File' => []
            ];
        $method= 'POST';
        $url = 'https://soffice.11st.co.kr/product/UnitProductRegAction.tmall?method=applyProductInfo';
        $crawler=$client->xmlHttpRequest($method,$url,$data,$post);
        print_r($crawler->outerHtml());
        
    }
        
    public function getProductAction($start_date = null, $end_date = null) {
        if ($start_date == null && $end_date == null) {
            $start_date = (date("Y") - 1)  . date("md");
            $end_date = date("Ymd");
        }
        
        $client = new Client( HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('POST', 'https://login.11st.co.kr/auth/front/selleroffice/login.tmall?returnURL=http://soffice.11st.co.kr');
        
        $form = $crawler->selectButton("로그인")->form();
        $crawler = $client->submit($form, array(
            'encryptedLoginName' => '5c9930fcf66bf5d4fe8803db86387a427b56b013452be0c765b9011d179c105f38f590019b05ee1503dcf5ed29dcda81b9b641603b34cf7a927c9f3e5fc8202b6db9e4d7b9963d75994f8623a46d5971f80b5d186cd982a87ad7bb134834bfa732939c06e523e1ca81d161e6d628c7da0adc290832d191d5c66f9aa80b9a7097',
            'encryptedPassWord' => '5aaae845004b40e1133f7c7428500e11836b648aebf3dbbf22b6a570649c3b0db7d4bc47c5a28b7a7ba3f1fac7e5cc4e9b1a0efce66627db241a15a1b9e1f7662432509ac9493d52bfdbc055fa8ab7730a89749aa75bc8fb6f76fff5cefdc95c82fc6dc69a8fc187e238b1b9cdbfcd226e730c19e99d708d92e3960517c9bd79',
            'loginName' => 'ysjlabs',
            'passWord' => 'yakeun87!@'));
        $data = [
            'encryptedLoginName'=> '75af1daa73e96bf48beaf632088af7d65d4b26d39ed4c6be2705ca2be7fbe31a87bee07c30e6d95a6800f7e25d837ce6766a45a345b9ca6e36359070577e2e5c8146f532d110a9f7a15838b5e8d6c32e51b72bc0f65ab8f8187d216e28381a92cca716bbbf25a818cf4dd95b4c0ef46bf1318599a6456c666002cefee094b17e',
            'encryptedPassWord'=> '58186cc9c573d9061b9d505b2745be8b98351f05a6aac6c62845a41cd044889e2f3f5f595359b98a29f709abe1092dd58341a3d7260545d1eb5aafc0efad5f73aeedbeaa453923a53a8a7d57a42da8195de1c076e314dd4099336007fb418a9d8fc08034c6591720018d508b924626cdcce7f8d82dedfe0f67ab65e6eb3e053a',
            'priority'=> 93,
            'authMethod'=> 'login',
            'returnURL'=> 'http://soffice.11st.co.kr?ts=1596181197873',
            'loginName'=> 'ysjlabs',
            'passWord' => 'yakeun87!@',
        ];
        $crawler = $client->request('POST', 'https://login.11st.co.kr/auth/front/selleroffice/logincheck.tmall', $data);
        $crawler = $client->request('POST', 'https://soffice.11st.co.kr/product/SellProductAjaxAction.tmall?method=getSellProductListJSON&srchTyp=prdNew&start=0&limit=30&prdNo=&prdNm=&searchType=PRDNO&dateType=CREATE&category1=&category2=&category3=&category4=&chkSelStatCds=&selMthdCd=&createDt=&createDtTo=&stckQty=&remainSelDt=&premiumAplDt=&dlvCstInstBasiCd=&dlvCstPayTypCd=&premiumPlusAplDt=&data=&searchListingItemClsf=&drivingListingItemClsf=&shopNo=&prdTypCd=&omPrdYn=&svcAreaCd=&stdPrdYn=');
        $content = html_entity_decode($client->getResponse()->getContent());
        $content= substr($content,1);
        $content= substr($content,0,-1);
        $dataProduct = json_decode($content,true);
        
        for ($i = 0; $i < $dataProduct['TOTAL_COUNT']; $i++) {
            $goodsId= $dataProduct['DATA_LIST'][$i]['prdNo'];
            $result = $this->_model->loadRecords('salechannel', ['travelProductId' =>$goodsId]);
            if ($result) {
                $this->_model->updateRecord('salechannel', ['channelId' => 6, 'productId' => $goodsId, 'vendorItemPackageId' =>$goodsId] , ['travelProductId' => $goodsId]);
            }else {
                $this->_model->insertRecord('salechannel', ['travelProductId' => $goodsId , 'channelId' => 6, 'productId' => $goodsId, 'vendorItemPackageId' => $goodsId]);
            }
        }
    }
    public function questionAction($start_date = null, $end_date = null) {

        if ($start_date == null && $end_date == null) {
            $start_date = (date("Y") - 1) . '/' .  date("m/d");
            $end_date = date("Y/m/d"); 
        }
        //echo str_replace("/","-", $start_date).' 00:00:00';
        $this->_model->updateRecord('question', ['isDelete' => 1], ['where' => 'question_created > "'.str_replace("/","-", $start_date).' 00:00:00" AND channel_name="11ST"']);  
        
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('POST', 'https://login.11st.co.kr/auth/front/selleroffice/login.tmall?returnURL=http://soffice.11st.co.kr');
        $form = $crawler->selectButton("로그인")->form();
        $crawler = $client->submit($form, array(
            'encryptedLoginName' => '5c9930fcf66bf5d4fe8803db86387a427b56b013452be0c765b9011d179c105f38f590019b05ee1503dcf5ed29dcda81b9b641603b34cf7a927c9f3e5fc8202b6db9e4d7b9963d75994f8623a46d5971f80b5d186cd982a87ad7bb134834bfa732939c06e523e1ca81d161e6d628c7da0adc290832d191d5c66f9aa80b9a7097',
            'encryptedPassWord' => '5aaae845004b40e1133f7c7428500e11836b648aebf3dbbf22b6a570649c3b0db7d4bc47c5a28b7a7ba3f1fac7e5cc4e9b1a0efce66627db241a15a1b9e1f7662432509ac9493d52bfdbc055fa8ab7730a89749aa75bc8fb6f76fff5cefdc95c82fc6dc69a8fc187e238b1b9cdbfcd226e730c19e99d708d92e3960517c9bd79',
            'loginName' => 'ysjlabs',
            'passWord' => 'yakeun87!@'));

        $data = [
            'encryptedLoginName'=> '75af1daa73e96bf48beaf632088af7d65d4b26d39ed4c6be2705ca2be7fbe31a87bee07c30e6d95a6800f7e25d837ce6766a45a345b9ca6e36359070577e2e5c8146f532d110a9f7a15838b5e8d6c32e51b72bc0f65ab8f8187d216e28381a92cca716bbbf25a818cf4dd95b4c0ef46bf1318599a6456c666002cefee094b17e',
            'encryptedPassWord'=> '58186cc9c573d9061b9d505b2745be8b98351f05a6aac6c62845a41cd044889e2f3f5f595359b98a29f709abe1092dd58341a3d7260545d1eb5aafc0efad5f73aeedbeaa453923a53a8a7d57a42da8195de1c076e314dd4099336007fb418a9d8fc08034c6591720018d508b924626cdcce7f8d82dedfe0f67ab65e6eb3e053a',
            'priority'=> 93,
            'authMethod'=> 'login',
            'returnURL'=> 'http://soffice.11st.co.kr?ts=1596181197873',
            'loginName'=> 'ysjlabs',
            'passWord' => 'yakeun87!@',
        ];

        $crawler = $client->request('POST', 'https://login.11st.co.kr/auth/front/selleroffice/logincheck.tmall', $data);

        $data = [
            'method' => 'getQnaTempListJSON'
        ];

        $crawler = $client->request('POST', 'https://soffice.11st.co.kr/product/AuthUnityBoardAction.tmall', $data);

        $data = [
            'method' => 'getProductQnaSellerListJSON',
            'start'=> 0,
            'limit'=> 300, // get 300
            'prdNoBox' => '',
            'sltTxtGubun'=> 'name',
            'searchQnaDtlsCd' => '',
            'answerStatus' => '',
            'srchTxt' => '',
            'startDate'=> $start_date,
            'endDate'=> $end_date,
            'periodPart'=> '01',
            'supplyCmNo'=> 'undefined',
            'searchClsf'=> 'NORMAL',
            'ntCodeType' => '',
            'trnsStatCd'=> '',
            'isPaging'=> 'Y'
        ];
        //prdNoBox: 26' => '767173
        // lấy tổng số câu hỏi    
        $crawler = $client->request('POST', 'https://soffice.11st.co.kr/product/AuthUnityBoardAction.tmall', $data);
        $dataQuestions = $client->getResponse()->getContent();
        $dataQuestions = substr($dataQuestions, 1);
        $dataQuestions = substr($dataQuestions, 0,-1);
        $dataQuestions = json_decode($dataQuestions, true);
        
        if ($dataQuestions['BOARD_LIST']) {
            foreach ($dataQuestions['BOARD_LIST'] as $items) {
                $result = $this->_model->loadRecords('question', ['inquiryId' => trim($items['subInfoNo']),'channel_name'=>'11ST']);
                $data = [
                    'question_name' => trim($items['memberBO']['memID']),
                    'question_content' => trim($items['unityBoardInfoBO']['unityBoardInfoContentBO']['brdInfoCont']),
                    'question_created' => trim($items['unityBoardInfoBO']['createDt']),
                    'dealId' => $items['unityBoardInfoBO']['brdInfoClfNo'], //$items['subInfoNo'],
                    'channel_name' => '11ST',
                    'inquiryId' => $items['subInfoNo'], //$items['productBO']['prdNo']
                    'isDelete' => 0
                ];
                if (!empty($items['answerCont'])) {
                    $data['question_status'] = 2;
                    $data['reply_name'] = trim($items['answerCont']);
                    $data['reply_created'] = trim($items['answerDt']);
                }

                if ($result) {
                    $this->_model->updateRecord('question', $data, ['inquiryId' => trim($items['subInfoNo']) ,'channel_name'=>'11ST']);
                } else {
                    $this->_model->insertRecord('question', $data);
                }
            }
        }
    }

    public function replyQuestionAction($inquiryId, $content){
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('POST', 'https://login.11st.co.kr/auth/front/selleroffice/login.tmall?returnURL=http://soffice.11st.co.kr');
        $form = $crawler->selectButton("로그인")->form();
        $crawler = $client->submit($form, array(
            'encryptedLoginName' => '5c9930fcf66bf5d4fe8803db86387a427b56b013452be0c765b9011d179c105f38f590019b05ee1503dcf5ed29dcda81b9b641603b34cf7a927c9f3e5fc8202b6db9e4d7b9963d75994f8623a46d5971f80b5d186cd982a87ad7bb134834bfa732939c06e523e1ca81d161e6d628c7da0adc290832d191d5c66f9aa80b9a7097',
            'encryptedPassWord' => '5aaae845004b40e1133f7c7428500e11836b648aebf3dbbf22b6a570649c3b0db7d4bc47c5a28b7a7ba3f1fac7e5cc4e9b1a0efce66627db241a15a1b9e1f7662432509ac9493d52bfdbc055fa8ab7730a89749aa75bc8fb6f76fff5cefdc95c82fc6dc69a8fc187e238b1b9cdbfcd226e730c19e99d708d92e3960517c9bd79',
            'loginName' => 'ysjlabs',
            'passWord' => 'yakeun87!@'));

        $data = [
            'encryptedLoginName'=> '75af1daa73e96bf48beaf632088af7d65d4b26d39ed4c6be2705ca2be7fbe31a87bee07c30e6d95a6800f7e25d837ce6766a45a345b9ca6e36359070577e2e5c8146f532d110a9f7a15838b5e8d6c32e51b72bc0f65ab8f8187d216e28381a92cca716bbbf25a818cf4dd95b4c0ef46bf1318599a6456c666002cefee094b17e',
            'encryptedPassWord'=> '58186cc9c573d9061b9d505b2745be8b98351f05a6aac6c62845a41cd044889e2f3f5f595359b98a29f709abe1092dd58341a3d7260545d1eb5aafc0efad5f73aeedbeaa453923a53a8a7d57a42da8195de1c076e314dd4099336007fb418a9d8fc08034c6591720018d508b924626cdcce7f8d82dedfe0f67ab65e6eb3e053a',
            'priority'=> 93,
            'authMethod'=> 'login',
            'returnURL'=> 'http://soffice.11st.co.kr?ts=1596181197873',
            'loginName'=> 'ysjlabs',
            'passWord' => 'yakeun87!@',
        ];

        $crawler = $client->request('POST', 'https://login.11st.co.kr/auth/front/selleroffice/logincheck.tmall', $data);

        $data = [
            'method' => 'getQnaTempListJSON'
        ];

        $crawler = $client->request('POST', 'https://soffice.11st.co.kr/product/AuthUnityBoardAction.tmall', $data);

        $start_date = (date("Y") - 1) . '/' .  date("m/d");
        $end_date = date("Y/m/d");

        $data = [
            'method' => 'getProductQnaSellerListJSON',
            'start'=> 0,
            'limit'=> 30,
            'prdNoBox' => '',
            'sltTxtGubun'=> 'name',
            'searchQnaDtlsCd' => '',
            'answerStatus' => '',
            'srchTxt' => '',
            'startDate'=> $start_date,
            'endDate'=> $end_date,
            'periodPart'=> '01',
            'supplyCmNo'=> 'undefined',
            'searchClsf'=> 'NORMAL',
            'ntCodeType' => '',
            'trnsStatCd'=> '',
            'isPaging'=> 'Y'
        ];

        $crawler = $client->request('POST', 'https://soffice.11st.co.kr/product/AuthUnityBoardAction.tmall', $data);

        $dataQuestions = $client->getResponse()->getContent();
        $dataQuestions = substr($dataQuestions, 1, strlen($dataQuestions) -1);
        $dataQuestions = substr($dataQuestions, 0, strlen($dataQuestions) -1);
        $dataQuestions = json_decode($dataQuestions, true);

        $hgrnkBrdInfoNo = '';
        $brdInfoClfNo ='';
        $buyerId ='';

        foreach ($dataQuestions['BOARD_LIST'] as $question) {
            if ($inquiryId == $question['subInfoNo']) {
                $hgrnkBrdInfoNo = $question['unityBoardInfoBO']['brdInfoNo'];
                $brdInfoClfNo = $question['unityBoardInfoBO']['brdInfoClfNo'];
                $buyerId = $question['memberBO']['memID'];
                break;
            }
        }
        // echo $hgrnkBrdInfoNo . '-' . $brdInfoClfNo . '-' . $buyerId;
        // die();
        $data = [
            'brdInfoNo' => $inquiryId,//'148175316'
            'hgrnkBrdInfoNo' => $hgrnkBrdInfoNo,//'148097117'
            'brdInfoClfNo' => $brdInfoClfNo,//'2770257979' dealId
            'brdInfoCont' => $content,
            'brdInfoSbjct' => '',
            'method' => 'updateProductQnaAnswer',
            'buyerId' => $buyerId,//'mjdi****'
            'flag' => 'sellerPrdQna',
            'partFlag' => 'seller',
            'searchClsf' => 'NORMAL',
            'ntCodeType' => '',
            'prdNoBox' => '(unable to decode value)',
            'sltTxtGubun' => 'name',
            'srchTxt' => '',
            'searchQnaDtlsCd' => '',
            'startDate' => $start_date,
            'endDate' => $end_date,
            'sltDuration' => 'RECENT_MONTH',
            'answerStatus' => '',
            'sltQnaTemp' => '',
            'answerCont' => $content
        ];
        $crawler = $client->request('POST', 'https://soffice.11st.co.kr/product/ProductQnaUpdate.tmall', $data);
        return $crawler;
    }
}

?>