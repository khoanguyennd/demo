<?php
require PATH_ROOT . '/vendor2/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpClient\HttpClient;
class RestfulApiController extends Controller {
    protected $method   = '';
    protected $endpoint = '';
    protected $params   = array();
    protected $file     = null;
    
    // Phương thức khởi tạo
    public function __construct($params) {
        parent::__construct($params);
       
    }
    // Phương thức index
    public function indexAction() { 
        $start_date = date("Ymdhis");
        $request = new Request();
        $content="";
        if ($request->getContent()) {
            $content= $request->getContent();
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
        $result = $this->_model->loadRecords('apiDVC',[],true,$default);
        $status=0;
        if($result[0]['status'] == 1 ){
            $datajson='{"rslt": "FAIL","sndTime": "'.$start_date.'"}';
            $status=0;
        }else{
            $datajson='{"rslt": "SUCCESS","sndTime": "'.$start_date.'"}';
            $status=1;
        }
        
        $data=['content' => $content, 'response' => $datajson, 'status' => $status];
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
        $result = $this->_model->loadRecords('apiDVC',[],true,$default);
        foreach ($result as $value => $giatri){
            $data=json_decode ($giatri['content'],true);
            echo '<pre>';
            print_r($data);
            echo '</pre>';

            $data=json_decode ($giatri['response'],true);
            echo '<pre>';
            print_r($data);
            echo '</pre>

            <hr>';
        }
    }
    
    public function sendAction() { 
       $data='{	"sndDate":"20180717053933",
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
    
    function callAPI1($method, $url, $data){
        $curl = curl_init();
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
        echo $url;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        print_r($result);
    } 
    public function callAPI($method, $url)
    {
        $httpClient = HttpClient::create();
        
        $data = [
            'name' => 'khoa nguyen',
            'address' => '132 d2 P.25 Binh Thanh',
        ];
        if($method === "POST")
            $response = $httpClient->request($method, $url, [ 'body' => $data]);
        else
            $response = $httpClient->request($method, $url);
        
        $statusCode = $response->getStatusCode();
        //echo $statusCode . "\n";
        $contentType = $response->getHeaders()['content-type'][0];
        //echo $contentType . "\n";
        
        return $response->getContent();
                
    }
    
    
    
}

?>