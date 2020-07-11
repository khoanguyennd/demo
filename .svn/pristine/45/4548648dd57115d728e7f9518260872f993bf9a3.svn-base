<?php

class Files{
	
	// Get file
	public function get( $path ){		
		$pathinfo = pathinfo($path);
		if(isset($pathinfo['extension'])){
			return $pathinfo['basename'];
		}
		return false;
	}
	
	// Get folder
	public function getFolder( $path ){
		$pathinfo = pathinfo($path);
		if(isset($pathinfo['extension'])){
			return $pathinfo['dirname'];
		}
		return $path;
	}
	
	// Đọc file $type: true = array || false: text
	public function read( $path, $type = true ){
	    if(file_exists($path)){
	        if($type == true){
	           return file($path);
	        }
	        if($type == false){
	            return file_get_contents($path);
	        }
		}
		return false;
	}
	
	// Ghi file
	public function write( $path, $source ){
	    if(file_exists($path)){
		    $fp = fopen($path, 'a');
		}else{
		    $fp = fopen($path, 'w');
		}
		fwrite($fp, $source);
		fclose($fp);
	}
	
	// Rename file
	public function copy($pathOld, $pathNew){
		if(file_exists($pathOld) && file_exists($this->getFolder($pathNew))){
			return copy($pathOld, $pathNew);
		}
		return false;
	}
	
	// Copy file
	public function rename( $path, $newname ){
	    if(file_exists($path)){
	        $pathFilenamenew = $this->getFolder($path) . DIRECTORY_SEPARATOR . $newname;
	        return rename($path, $pathFilenamenew);
		}
		return false;
	}
	
	// Delete file
	public function delete( $path ){		
		if(file_exists($path)){
			return @unlink($path);		
		}
		return false;
	}
	
}

?>