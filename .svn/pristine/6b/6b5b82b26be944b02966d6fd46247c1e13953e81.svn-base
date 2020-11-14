<?php

require PATH_ROOT . '/vendor1/autoload.php';
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;

require PATH_ROOT . '/vendor/autoload.php';
use Google\Cloud\Storage\StorageClient;

class NaverController extends Controller {
    
    // Phương thức khởi tạo
    public function __construct($params) {
        parent::__construct($params);
    }
    public function register_stream_wrapper($projectId)
    {
        $client = new StorageClient(['projectId' => $projectId]);
        $client->registerStreamWrapper();
    }
    
    // Phương thức index
    public function indexAction() {
        $client = new Client(HttpClient::create(['timeout' => 60]));
        //https://nid.naver.com/nidlogin.login
//         $crawler = $client->request('POST', 'https://nid.naver.com/nidlogin.login');
//         $form = $crawler->filter('#frmNIDLogin')->form();
//         $crawler = $client->submit($form, array(
//             'id' => 't-bridge',
//             'pw' => 'coupang135!'
//         ));
        $crawler = $client->request('GET', 'https://nid.naver.com/nidlogin.login');

        $data = [ 'localechange'=>'',
                    'encpw' => '868195f83b3e72b5de44a0c88bb8b7ed442e3a5aff369e7121b2b09eb25618158cd46762b8e40a752beea3dda16ac3dd929b8f4457093450452bddc1ca338802a1ce5657c6d100be3e70ad98cea38318dd028e600c2631ce709c4ff50da38af160d925bd8a2615dbb2485f0cf1fcf891be0a86cae9efd5ce4a886ce2587ef531',
                    'enctp' => 1,
                    'svctype' => 1,
                    'smart_LEVEL' => -1,
                    'bvsd' => ' N4IgLiBcIJwCwFYDsBjAHClBaGBGAbAIZZxoLZqJxa4CmATPQCZlwBmctARlgAwgAaEAGcoIQSAC2UekOFcovOSkVCArgshKQalVqFgAdpu1G9s8Ht4BfIA',
                    'encnm' => ' 100015713',
                    'locale' => ' en_US',
                    'url' => ' https://nid.naver.com/signin/v3/finalize?url=https%3A%2F%2Fnid.naver.com%2Fnidlogin.login&svctype=1',
                    'id' => '',
                    'pw' => ''  ];
        
       $crawler = $client->request('POST', 'https://nid.naver.com/nidlogin.login',$data);
        
        
       $crawler = $client->request('GET', 'https://partner.booking.naver.com/api/businesses/reports?endDate=2020-08-26&startDate=2020-08-26');
        
       echo htmlentities($client->getResponse()->getContent());
        
//         echo '<pre>';
//         print_r($crawler);
//         echo '</pre>';
        
        
    }
}

?>