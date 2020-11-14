<?php
    function callAPI($method, $url, $data){
        $curl = curl_init();
        $data='{	"sndDate":"20180717053933",
 
                    "dvc": { "dvcId":"T01001002021",
                        
                        "sts":"1"},

                        
                    "cmrList":[
                            
                        {"cmrId":"C01001002",  "sts":"1" },
                        
                        {"cmrId":"C00001001","sts":"2"},
                        
                        {"cmrId":"C01001003","sts":"1"}
                    ]
            
        }';
        
        switch ($method){
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
            'Authorization: gfhjui',
            'APIkey: 2222222222',
            'token: 111111111111111111111',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        print_r($result);
        //return $result;
    } 
    //callAPI("POST", "http://tbridge.lavianspa.com/restfulApi.html", null)
    callAPI("POST", "http://localhost:7070/symfony-beginning/public/index.php/api/jsonData/45", null);
    //callAPI("POST", "http://localhost:7070/demo_goutte/index.php?id=12", null);
?>