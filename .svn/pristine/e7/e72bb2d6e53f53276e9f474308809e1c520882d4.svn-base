<?php
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://business.api.friday24.com/closedown/1231212345');
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer 0VWJFYWd3gqzMicMa2ul"));
curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
$data =curl_exec($curl);
curl_close($curl);
$data=json_decode($data, true);
echo $data['state'];
?>