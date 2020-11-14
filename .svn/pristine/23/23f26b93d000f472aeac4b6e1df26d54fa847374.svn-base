<?php
class Route
{
	protected $_params; // Lưu tham số của hằng số $_GET và $_POST (type array)
    
    protected $_route; // Lưu tên của phương thức get (type array)

    protected $_controller; // Lưu tên controller và phương thức hoặc lưu function (type array)
       
    protected $_excute; // Lưu điều kiện thực hiện cho phương thức get (type boolean)
    
    protected $_url; // Lưu đường dẫn url hiện tại (type string)
    
    protected $_domain; // Lưu tên domain (type string)
    
    protected $_where; // Lưu tên where (type array)
    
    protected $_prefix; // Lưu tên where (type array)

    public function __construct(){
    	// Thiết lập tham số
    	$this->setParams();
    	// Thiết lập url
    	$this->setUrl();    	
    }
    
    // Phương thức thiết lập params
    protected function setParams($key = null, $value = null)
    {
        if($key !== null && $value !== null){           
            $this->_params[$key] = $value;           
    	}else{
    	    $this->_params = array_merge($_GET, $_POST);
    	}
    }
    
    // Phương thức thiết lập đường dẫn url
    protected function setUrl()
    {
        if (empty ( URL )) {
            $this->pageError ();
        } else {
            $this->_url = URL;
        }
    }
    
    // Phương thức thiết lập giá trị từ khóa
    protected function setItems($path, $options = []){    	
    	preg_match_all('#{([A-z0-9]+)\??}#', $path, $matches);
    	if(isset($matches[0])){
    		$items = [];
    		foreach ($matches[0] as $key => $value){  
    			$replace = '([A-z0-9_\-]+)';
    			if($this->_where){
    				if(isset($this->_where[$matches[1][$key]])){
    					$replace = $this->_where[$matches[1][$key]];
    				}
    			}    			
    			$items[$matches[1][$key]] = preg_replace(['#{'.$matches[1][$key].'}#', '#{'.$matches[1][$key].'\?}#'], [$replace, $replace.'?'], $value);
    		}
    		return $items;
    	}
    }
    
    // Phương thức kiểm tra đường dẫn url
    protected function isPathUrl($data){        
    	if($data){
    		preg_match($data['pattern'], $this->_url, $matches);
    		if($matches){
    			$this->_excute = $data;
    			$i = 1;
    			$params = [];
    			foreach ($data['item'] as $key => $value){
    				$value = ((isset($matches[$i])) ? $matches[$i] : '');
    				$this->setParams($key, $value);
    				$i++;
    			}
    		}
    	}
    }
    
    // Phương thức thiết lập pattern
    protected function setPattern(){
    	if($this->_route){
    		foreach ($this->_route as $key => $value){    		   
    			$value['item'] = $this->setItems($value['path'], $this->_where);
    			$pattern = '#'.preg_replace(['#/#', '#-#'], ['\/', '\-'], URL_BASE . $value['path']);
    			$pattern .= ($value['controllerAction'])?'$#':'#';
    			foreach ($value['item'] as $subkey => $subvalue){
    				$pattern = preg_replace(
    						[
    								'#{'.$subkey.'}#',
    								'#\/?{'.$subkey.'\?}#',
    								'#\-?{'.$subkey.'\?}#'
    						],
    						[
    								$subvalue,
    								'/?'.$subvalue,
    								'-?'.$subvalue
    						],$pattern);
    			}
    			$value['pattern'] = $pattern;
    			$this->_route[$key] = $value;
    			$this->isPathUrl($value);
    		}
    	}
    }
    
    // Phương thức thực hiện chương trình
    protected function excute(){        
        if($this->_excute){
            if(gettype($this->_excute['controllerAction']) == 'object'){
                return $this->_excute['controllerAction']($this);
            }
            if($this->_excute['controllerAction'] == null){ // ajax
                $controllerName = ucfirst($this->_params['controller']) . 'Controller';
                $actionName = $this->_params['action'] . 'Ajax';
                // Tạo đối tượng Controller và gọi phương thức xử lý
                $this->createController($controllerName, $actionName);
                return;
            }
            if(strpos($this->_excute['controllerAction'], '@') !== false){
                $items = explode('@', $this->_excute['controllerAction']);
                if($items){
                    $this->_params['controller'] = $items[0];
                    $this->_params['action'] = $items[1];
                    $controllerName = ucfirst($this->_params['controller']) . 'Controller';
                    $actionName = $this->_params['action'] . 'Action';
                    // Tạo đối tượng Controller và gọi phương thức xử lý
                    $this->createController($controllerName, $actionName);
                }
            }
        }else{
            $this->pageError();
        }
    }
    
    // Phương thức khởi tạo đối tượng controller
    protected function createController($controllerName, $actionName){
        $fileName = PATH_APPLICATION . 'controller' . DS . $controllerName . '.php';
        if (file_exists($fileName)) {
            require $fileName;
            $this->_params['route'] = $this;
            $this->_controller = new $controllerName($this->_params);
            $this->callMethod($actionName);
        }else{
            $this->pageError();
        }
    }
    
    // Phương thước gọi phương thức xử lý
    protected function callMethod($actionName){
        if (method_exists($this->_controller, $actionName) == true) {
            $this->_controller->$actionName();
        } else {
            $this->_controller->pageError();
        }
    }
    
    // Phương thức thông báo lỗi
    protected function pageError(){
        $this->_controller = new Controller(['controller'=>'', 'action'=>'']);
        $this->_controller->pageError();
    }
    
    // Phương thức thiết lập đường dẫn
    public function get($name, $path, $controllerAction = null){
        // Thiết lập tham số cho route
        $this->_route[] = [
            'name'=> $name,
            'path'=> (($this->_prefix)?$this->_prefix:'') . $path . (($controllerAction == null) ? '/{controller}/{action}' : ''),
            'controllerAction' => $controllerAction
        ];
        // Trả về parent
        return $this;
    }
    
    // Phương thức thiết lập điều kiện cho đường dẫn
    public function where($options){
    	if(is_array($options)){  
    		foreach ($options as $key => $value){
    			if(substr($value, 0,1) !== '('){
    				$value = '('.$value.')';    				
    			}
    			$this->_where[$key] = $value;
    		}
    	}
    }
    
    // Phương thức thiết lập nhóm đường dẫn
    public function groups($prefix, $func){
    	if(gettype($func) == 'object'){
    		$this->_prefix = $prefix;
    		$func($this);
    		$this->_prefix = null;
    	}
    }
    
    // Phương thức trả về đường dẫn url
    public function getUrl($routeName, $options = []){
    	$url = '';
    	if($this->_route){
    		foreach ($this->_route as $key => $value){
    			if($value['name'] == $routeName){
    			    $url = URL_BASE. $value['path'];
    				break;
    			}
    		}
    		$pattern = ['#\/?\-?{.*#'];
    		$replace = [''];
    		if($options){
    			foreach ($options as $key => $value){
    				array_unshift($pattern, '#{'.$key.'\??}#');
    				array_unshift($replace, $value);
    			}
    		}
    		$url = preg_replace($pattern, $replace, $url);
    	}
    	return $url;
    }
    
	// Phương thức kết thúc chương trình
    public function __destruct(){
    	// Thiết lập pattern
    	$this->setPattern();
    	// Thực hiện chương trình
    	$this->excute();
    }

}

?>