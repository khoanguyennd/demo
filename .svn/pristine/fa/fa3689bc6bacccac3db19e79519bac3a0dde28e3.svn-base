<?php
date_default_timezone_set("GMT+0");

$datetime = date("ymd").'T'.date("His").'Z';
$method = "GET";
$path = "/v2/providers/travel_backbone_api/apis/ticket-api/v1/mock-up/purchasers";
$query = "searchStartDateTime=20170906000000&searchEndDateTime=20200906235959&offset=0&limit=1000";

$message = $datetime.$method.$path.$query;

// replace with your own accessKey
$ACCESS_KEY = "687fb6f0-46eb-446a-ac32-89f121551452";
// replace with your own secretKey
$SECRET_KEY = "bbc2b44a71ea88560e65652b51a286f7aadb42ac";

$algorithm = "HmacSHA256";

$signature = hash_hmac('sha256', $message, $SECRET_KEY);

$authorization  = "CEA algorithm=HmacSHA256, access-key=".$ACCESS_KEY.", signed-date=".$datetime.", signature=".$signature;

//replace prod url when you need
$url = 'https://api-gateway.coupang.com'.$path.'?'.$query;

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type:  application/json;charset=UTF-8", "Authorization:".$authorization));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
$httpcode = curl_getinfo($curl);
$err     = curl_errno($curl);
$errmsg  = curl_error($curl) ;
curl_close($curl);

echo '<pre>';
print_r ($httpcode);

echo ($result);

echo ($err);
echo ($errmsg);

?>