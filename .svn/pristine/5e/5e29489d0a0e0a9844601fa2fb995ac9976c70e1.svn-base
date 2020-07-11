<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$url = 'https://openapi.openbanking.or.kr/v2.0/inquiry/receive';
$method = "POST";
$strjson='{
“bank_tran_id”: "F123456789U4BC34239Z",
"cntr_account_type": "N",
"cntr_account_num": "1101230000678",
“bank_code_std“: "097",
“account_num”: "3001230000678",
"print_content": "홍길동송금",
"tran_amt": "10000",
"req_client_name":   “홍길동”,
"req_client_bank_code":   "097",
"req_client_account_num":   “1221230000678”,
"req_client_num":   “HONGGILDONG1234”,
"transfer_purpose":   “TR”,
"sub_frnc_name":   “하위가맹점”,
"sub_frnc_num":   “123456789012”,
"sub_frnc_business_num":   “1234567890”,
"cms_num":   “93848103221”
}';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type:application/json; charset=UTF-8"));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $strjson);

$result = curl_exec($curl);
$httpcode = curl_getinfo($curl);
curl_close($curl);

echo '<pre>';
echo ($result);
print_r($httpcode);
echo '</pre>';

?>