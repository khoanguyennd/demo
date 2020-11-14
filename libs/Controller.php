<?php
class Controller {
	
	// Biáº¿n lÆ°u giÃ¡ trá»‹ $_POS And $_GET
	protected $_params;
	
	// Biáº¿n lÆ°u giÃ¡ trá»‹ input text or texteara
	protected $_inputs;
	
	// Biáº¿n Ä‘á»‘i tÆ°á»£ng Model
	protected $_model;
	
	// Biáº¿n Ä‘á»‘i tÆ°á»£ng View
	protected $_view;
	
	// Biáº¿n Ä‘á»‘i tÆ°á»£ng json
	protected  $_json;
		
	// Biáº¿n lÆ°u giÃ¡ trá»‹ lá»—i
	protected $_error;
	
	// PhÆ°Æ¡ng thÆ°á»›c khá»Ÿi táº¡o
	public function __construct($params) {	    
	    $this->setParams ( $params );
	    $this->setJson();
		$this->setModel();			
		$this->setView();
		$this->setLanguageAjax();
		$this->setJsData();
	}
	
	// PhÆ°Æ¡ng thá»©c thiáº¿t láº­p tham sá»‘
	public function setParams($params) {		
		$this->_params = $params;
	}
	
	// PhÆ°Æ¡ng thá»©c thiáº¿t láº­p data js
	public function setJsData(){
	    if( isset($this->_params['route'])){
    	    $this->_view->setData('jsData', [
    	        'urlAjax' => $this->route('ajax', ['controller'=> $this->_params['controller'] . '/']),
    	        'control'=>$this->_params['controller'],
    	        'action'=>$this->_params['action']
    	    ]);
	    }
	}
			
	/* PhÆ°Æ¡ng thá»©c khá»Ÿi táº¡o Ä‘á»‘i tÆ°á»£ng Model tÆ°Æ¡ng á»©ng vá»›i Controller
	 * $modelName lÃ  tÃªn model Ä‘Æ°á»£c truyá»�n vÃ o
     */
	public function setModel() {
		if(isset($this->_params ['controller'])){
			$modelName = ucfirst($this->_params ['controller']) . 'Model';
		    $fileName = PATH_APPLICATION . DS . 'model' . DS . $modelName . '.php';
			if (file_exists ( $fileName )) {
				require_once $fileName;
				$this->_model = new $modelName ();
			}
		}
	}
	
	/* PhÆ°Æ¡ng thá»©c khá»Ÿi táº¡o Ä‘á»‘i tÆ°á»£ng View */
	public function setView() {
		$this->_view = new View ( $this->_params );
	}
	
	/* PhÆ°Æ¡ng thá»©c khá»Ÿi táº¡o Ä‘á»‘i tÆ°á»£ng Json */
	public function setJson() {
	    $this->_json = new Json();
	}
	
	/* PhÆ°Æ¡ng thá»©c thiáº¿t láº­p ngÃ´n ngá»¯ */
	public function setLanguageAjax() {	   
	    if($this->_params['controller']){
	        $filename = PATH_LANG;	      
	        if(isset($this->_params['lang'])){
	            Session::set('lang', $this->_params['lang']);
	        }
	        if(Session::get('lang')){	           
	            $filename .= Session::get('lang');	         
	            if(Session::get('accountshopping') !== false && Session::get('accountshopping')['area'] != Session::get('lang')){
	                $_SESSION['accountshopping']['area'] = Session::get('lang');
	                $this->_model->updateRecord('user', ['lang'=>Session::get('lang')], ['ID'=>Session::get('accountshopping')['ID']]);
	            }
	        }else{
	            $filename .= DEFAULT_LANG;
	            Session::set('lang', DEFAULT_LANG);
	        }	        
	        $language = require $filename . '.php';
	        Helper::setLanguage($language);
	        OfficeExcel::setLanguage($language);
            OfficeExcel::setLanguage($language);
	        $this->_view->setData('language', $language);
	    }
	}
	
	/* PhÆ°Æ¡ng thá»©c kiá»ƒm tra ngÆ°á»�i dÃ¹ng Ä‘Äƒng nháº­p
	 * $flag: true khÃ´ng Ä‘Äƒng nháº­p khÃ´ng chuyá»ƒn trang, Ä‘Ã£ Ä‘Äƒng nháº­p chuyá»ƒn trang
	 * $flag: false khÃ´ng Ä‘Äƒng nháº­p Ä‘Æ°á»£c chuyá»ƒn trang, Ä‘Ã£ Ä‘Äƒng nháº­p khÃ´ng chuyá»ƒn trang
	 */
	public function isLogin($flag = false) {	   
	    // Check Cookie
	    if (Session::get ( 'accountshopping' ) == false && isset($_COOKIE['accountshopping']['ID'])){
	        Session::set ( 'accountshopping', $_COOKIE['accountshopping']);
	    }
	    // Check login
	    if (Session::get ( 'accountshopping' ) == false) { // khÃ´ng Ä‘Äƒng nháº­p
	        if($flag === false){
	            Url::header($this->route('login'));
	        }
	    } else { // Ä‘Ã£ Ä‘Äƒng nháº­p
	        if ($flag === true) {
	            // Kiá»ƒm tra Ä‘Æ°á»�ng dáº«n Ä‘á»ƒ chuyá»ƒn hÆ°á»›ng
	            Url::header($this->route('home'));
	        }
	    }	   
	}
	
	/* PhÆ°Æ¡ng thá»©c láº¥y giÃ¡ trá»‹ tá»« form input hoÄƒc texteara vÃ  tráº£ vá»� giÃ¡ trá»‹ cá»§a máº£ng
	 * $Option lÃ  máº£ng truyá»�n vÃ o vá»›i tÃªn cá»§a input
	 * $prefix lÃ  tiá»�n tá»‘ cá»§a báº£ng trong sql
     */
	public function setInputs($option = array(), $prefix = NULL) {
		if ($option) {
			$prefix = ($prefix !== NULL) ? $prefix .= '_' : '';
			foreach ( $option as $name ) {
				if (! empty ( $_POST )) {
					$this->_inputs [$prefix . $name] = ((isset ( $_POST [$name] )) ? trim ( $_POST [$name] ) : '');
					continue;
				}
				if (isset ( $_FILES [$name] )) {
					if ($_FILES [$name] ['error'] == 0) {
						$this->_inputs [$prefix . $name] = $_FILES [$name] ['name'];
					}
				}
			}
			return $this->_inputs;
		}
		return false;
	}
	
	/* PhÆ°Æ¡ng thá»©c thÃªm 1 pháº§n tá»­ vÃ o máº£ng input hoÄƒc texteara*/
	public function appendInput($key, $value) {
		$this->_inputs[$key] = $value;
	}
	
	/* PhÆ°Æ¡ng thá»©c tráº£ vá»� máº£ng tá»« form input hoÄƒc texteara */
	public function getInputs($key = NULL){
	    if($key == NULL){
		  return $this->_inputs;
	    }else{	        
	        if(isset($this->_inputs[$key])){
	            return $this->_inputs[$key];
	        }else{
	            $this->setError($this->_view->getItem('language', 'l_inputisset'));
	        }
	        return '';
	    }
	}
	
	/* PhÆ°Æ¡ng thá»©c kiá»ƒm tra giÃ¡ trá»‹ rá»—ng cá»§a pháº§n tá»­ máº£ng input hoáº·c texteara */
	public function isInputs($option = array()) {
	    if ($option) {
	        foreach ( $option as $name ) {
	            if(empty($this->getInputs($name))){
	                $this->setError($this->_view->getItem('language', 'l_inputempty'));
	                break;
	            }
	        }
	        return ($this->isError()) ? false : true;
	    }
	    return false;
	}	
	
	/* PhÆ°Æ¡ng thÆ°Ì�c gÆ°Ì‰i dÆ°Ìƒ liÃªÌ£u Ä‘ÃªÌ�n mÃ´Ì£t trang */
	public function postCurl($url, $data){
	    if($url && $data){
	        $curl = curl_init($url);
	        $content = json_encode($data);
	        curl_setopt($curl, CURLOPT_HEADER, false);
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
	        curl_setopt($curl, CURLOPT_POST, true);
	        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
	        $response = curl_exec($curl);
	        curl_close($curl);
	        return $response;
	    }
	}
	
	/* PhÆ°Æ¡ng thá»©c gÃ¡n giÃ¡ trá»‹ lá»—i */
	public function setError($error){
	    $this->_error = $error;
	}
	
    /* PhÆ°Æ¡ng thá»©c kiá»ƒm tra lá»—i
     * True: cÃ³ lá»—i
     * False: khÃ´ng cÃ³ lá»—i
     */
    public function isError(){
        if(empty($this->_error)){
            return false;
        }
        return true;
    }
        
    /* PhÆ°Æ¡ng thá»©c tráº£ vá»� giÃ¡ trá»‹ lá»—i */
    public function getError(){
        return $this->_error;
    }
   
    /* PhÆ°Æ¡ng thá»©c chuyá»ƒn vá»� trang lá»—i */
    public function pageError(){
        $this->_view->setFileTemplate('error');
        require_once $this->_view->_fileTemplate;
    }    
    
    // PhÆ°Æ¡ng thá»©c láº¥y ra Ä‘Æ°á»�ng dáº«n route
    public function route($name, $options = []){
        if($this->_params['route']){
            return $this->_params['route']->getUrl($name, $options);
        }
    }
    
    // PhÆ°Æ¡ng thá»©c chuyá»ƒn Ä‘á»•i ngÃ´n ngá»¯ lá»—i cho class upload
    public function convertErrUpload($error){
        if($error=='errExtension'){
            return $this->_view->getItem('language', 'l_errExtension') . ' ( '.FILE_EXTENSION.' )';
        }
        if($error=='errSize'){
            return $this->_view->getItem('language', 'l_errSize') . ' '.FILE_SIZE;
        }
        if($error=='errFolder'){
            return $this->_view->getItem('language', 'l_errFolder');
        }
    }
    
    // PhÆ°Æ¡ng thá»©c kiá»ƒm tra ID
    public function checkIDAjax()
    {
        $result = ['flag'=>false];
        if ($this->_params['aid']) {
            if ($this->_model->loadRecord('user', [
                'ID' => $this->_params['aid']
            ]) == false) {
                $result['flag'] = true;
            }
        }
        echo json_encode($result);
    }

    // PhÆ°Æ¡ng thá»©c tráº£ vá»� tham sá»‘ pagination
    public function paginationParams($count, $link, $ditance = 5){
        $length = ($this->_params['length']?$this->_params['length']:DEFAULT_LENGTH);
        $pageCurrent = ($this->_params['page']?$this->_params['page']:1);
        $begin = ($pageCurrent - 1) * $length;
        $pageTotal = ceil($count / $length);   
        $pagination = '';
        if($pageTotal > 1){
            $start = 1;
            $end = $pageTotal;
            if($pageTotal > $ditance){
                $ditance1 = floor($ditance / 2);
                $start = $pageCurrent - $ditance1;
                $end = $pageCurrent + $ditance1;                
                if($start<1){
                    $start = 1;
                    $end = $ditance;
                }
                if($end>$pageTotal){
                    $start = $pageTotal- $ditance;
                    $end = $pageTotal;
                }
            }
            $pagination= Helper::createPagination($pageTotal, $pageCurrent, $start, $end, $length, $link); 
        }               
        return [
            'count'=>$count,
            'length'=>$length,
            'begin'=>$begin,
            'pagination'=>$pagination
        ];
    }
    public function paginationParamsmobi($count, $link, $ditance = 5){
        $length = ($this->_params['length']?$this->_params['length']:100);
        $pageCurrent = ($this->_params['page']?$this->_params['page']:1);
        $begin = ($pageCurrent - 1) * $length;
        $pageTotal = ceil($count / $length);   
        $pagination = '';
        if($pageTotal > 1){
            $start = 1;
            $end = $pageTotal;
            if($pageTotal > $ditance){
                $ditance1 = floor($ditance / 2);
                $start = $pageCurrent - $ditance1;
                $end = $pageCurrent + $ditance1;                
                if($start<1){
                    $start = 1;
                    $end = $ditance;
                }
                if($end>$pageTotal){
                    $start = $pageTotal- $ditance;
                    $end = $pageTotal;
                }
            }
            $pagination= Helper::createPagination($pageTotal, $pageCurrent, $start, $end, $length, $link); 
        }               
        return [
            'count'=>$count,
            'length'=>$length,
            'begin'=>$begin,
            'pagination'=>$pagination
        ];
    }
}
?>