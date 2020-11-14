<?php
class View {
	public $_params;
	public $_folderTemplate;
	public $_fileTemplate;
	public $_folderImage;
	public $_folderUpload;
	public $_fileConfig = PATH_CONFIGS. 'views.ini';
	public $_folderView;
	public $_fileView;
	public $_title;
	public $_metaHttp;
	public $_metaName;
	public $_fileCss;
	public $_fileJs;
	public $_data;
	
	// Phương thức khởi tạo
	public function __construct($params) {
		$this->_params = $params;	
		$this->setDefaultData();
		$this->setFolderImage();
		$this->setFolderView();
		$this->setFolderUpload();
		$this->setFileTemplate();
	}

	// Phương thức load
	public function load($onPage = false) {
	    if (file_exists ( $this->_fileConfig )) {
	        $items = parse_ini_file ( $this->_fileConfig, true );
	        if ($items && isset ( $items [$this->_params ['controller']] )) {
	            $this->setMetaHttp ( $items ['metaHttp'] );
	            $this->setMetaName ( $items ['metaName'] );
	            $config = $items [$this->_params ['controller']];
	            $this->setTitle ( $config ['title'] );
	            $css = (isset ( $config ['css'] ) ? $config ['css'] : [ ]);
	            $this->setCss ( array_merge ( $items ['css'], $css ), $onPage );
	            $js = (isset ( $config ['js'] ) ? $config ['js'] : [ ]);
	            $this->setJs ( array_merge ( $items ['js'], $js ), $onPage );
	        }
	    }
	}
	
	// Phương thức render nạp file template
	public function render($fileName, $full = true) {
		$fileName = PATH_APPLICATION . 'view' . DS . strtolower($this->_params ['controller']) . DS . $fileName . '.php';
		if (file_exists ( $fileName )) {
			if ($full == true) {
				$this->setFileView ( $fileName );
				require_once $this->_fileTemplate;
			} else {
				require_once $fileName;
			}
		}
	}
	
	// Phương thức thiết lập thư mục chứa template
	public function setFolderTemplate() {
		$this->_folderTemplate = PATH_PUBLIC;
	}
	
	// Phương thức thiết lập thư mục chứa images
	public function setFolderImage() {
		$this->_folderImage = URL_PUBLIC . 'images' . DS;
	}
	
	// Phương thức thiết lập thư mục chứa upload
	public function setFolderUpload($folder = '') {
		if(empty($folder)){
			if(isset($this->_params['controller'])){
				$folder = $this->_params['controller'];
			}
		}
		$this->_folderUpload = URL_PUBLIC . 'uploads' . DS . $folder . DS;
	}
	
	// Phương thức thiết lập file template
	public function setFileTemplate($filename = 'web', $folder = NULL) {
	    $this->setFolderTemplate ();
		if ($folder == NULL) {
		    $this->_fileTemplate = $this->_folderTemplate . $filename . '.php';
		} else {
		    $this->_fileTemplate = $this->_folderTemplate . $folder . DS . $filename . '.php';
		}
	}
		
	// Phương thức thiết lập file view
	public function setFileView($file) {
		$this->_fileView = $file;
	}
	
	// Phương thức thiết lập thư mục chứa view
	public function setFolderView($folder = '') {
		if(empty($folder)){
			if(isset($this->_params['controller'])){
				$folder = $this->_params['controller'];
			}
		}
		$this->_folderView = PATH_APPLICATION . 'views' . DS . $folder . DS;
	}
	
	// Phương thức thiết lập thẻ meta http
	public function setMetaHttp($metaHttp = array()) {
		if (! empty ( $metaHttp )) {
			foreach ( $metaHttp as $meta ) {
				$meta = explode ( '|', $meta );
				$this->_metaHttp .= '<meta http-equiv="' . $meta [0] . '" content="' . $meta [1] . '">';
			}
		}
	}
	
	// Phương thức thiết lập thẻ meta name
	public function setMetaName($metaName = array()) {
		if (! empty ( $metaName )) {
			foreach ( $metaName as $meta ) {
				$meta = explode ( '|', $meta );
				$this->_metaName .= '<meta name="' . $meta [0] . '" content="' . $meta [1] . '">';
			}
		}
	}
	
	// Phương thức thiết lập title
	public function setTitle($title) {
	    $this->_title = '<title>' . $title . '</title>';
	}
	
	// Phương thức thiết lập link file css
	public function setCss($option, $onPage = false) {
	    if ($option) {
	        if ($onPage == false) {
	            foreach ( $option as $key => $value ) {
	                if ($value) {
	                    $this->_fileCss .= '<link rel="stylesheet" type="text/css" href="' . URL_PUBLIC . 'css' . DS . $value . '">';
	                }
	            }
	            return;
	        }
	        if ($onPage == true) {
	            $fileObj = new Files ();
	            foreach ( $option as $key => $value ) {
	                $filename = PATH_PUBLIC . 'css' . DS . $value;
	                if ($value && file_exists ( $filename )) {
	                    $this->_fileCss .= $fileObj->read ( $filename, false );
	                }
	            }
	            $this->_fileCss = '<style type="text/css">' . $this->_fileCss . '</style>';
	        }
	    }
	}
	
	// Phương thức thiết lập link file js
	public function setJs($option, $onPage = false) {
	    if ($option) {
	        if ($onPage == false) {
	            $this->_fileJs = '<script type="text/javascript">vdata=' . json_encode ( $this->getData ( 'vdata' ) ) . '</script>';
	            foreach ( $option as $key => $value ) {
	                if ($value) {
	                    $this->_fileJs .= '<script type="text/javascript" src="' . URL_PUBLIC . 'js' . DS . $value . '"></script>';
	                }
	            }
	            return;
	        }
	        if ($onPage == true) {
	            $fileObj = new Files ();
	            $vdata = 'vdata=' . json_encode ( $this->getData ( 'vdata' ) ) . ';';
	            foreach ( $option as $key => $value ) {
	                $filename = PATH_PUBLIC . 'js' . DS . $value;
	                if ($value && file_exists ( $filename )) {
	                    $this->_fileJs .= $fileObj->read ( $filename, false );
	                }
	            }
	            $this->_fileJs = '<script type="text/javascript">' . $vdata . $this->_fileJs . '</script>';
	        }
	    }
	}
			
	// Phương thức thiết lập giá trị mặc định cho js
	public function setDefaultData() {
	    $this->setData ( 'vdata', [
	        'ctrl' => $this->_params ['controller'],
	        'actn' => $this->_params ['action']
	    ] );
	}
	
	// Phương thức thiết lập data
	public function setData($key, $data) {
		$this->_data [$key] = $data;
	}
	
	// Phương thức lấy data
	public function getData($name) {
		if (gettype ( $this->_data ) == 'object') {
			if (isset ( $this->_data->$name )) {
				return $this->_data->$name;
			}
		}
		if (gettype ( $this->_data ) == 'array') {
			if (isset ( $this->_data [$name] )) {
				return $this->_data [$name];
			}
		}
	}
	
	// Phương thức lấy data cấp 2
	public function getItem($name, $item) {
		$data = $this->getData ( $name );
		if($data){
			if (gettype ( $data ) == 'object') {
				if (isset ( $data->$item )) {
					return $data->$item;
				}
			}
			if (gettype ( $data ) == 'array') {
				if (isset ( $data [$item] )) {
					return $data [$item];
				}
			}
		}		
	}
		
	// Phương thức lấy ra đường dẫn route
	public function route($name, $options = []){
	    if($this->_params['route']){
	        return $this->_params['route']->getUrl($name, $options);
	    }
	}
	
	// Phương thức lấy ra ngôn ngữ
	public function language($name){
	    if(isset($this->_data['language'][$name])){
	        return $this->_data['language'][$name];
	    }
	}
	
	// Phương thức thiết lập lỗi
	public function setError($string) {
		$this->_error = $string;
	}
	
	// Phương thức lấy ra lỗi
	public function getError() {
		return $this->_error;
	}
}
?>