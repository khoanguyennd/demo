<?php 
// Thiết lập đường dẫn cho chương trình
class Url{    
    
    /* Phương thức tạo đường dẫn thận thiện cho người dùng
     * $string: tên đường dẫn
     * $params: mảng trong đó key: là từ khóa, $value là giá trị
     */
    static function link($string, $params = []){
        if($string){
        	$string = Func::convertUnicode($string, '-') . '.html';
            if($params){
                foreach ($params as $key => $value){
                    $string .= '&' . $key . '=' . $value;
                }                
            }
            return $string;
        }
    }
    
    /* Phương thức chuyển trang
     * $link: đường dẫn cần chuyển
     */
    static function header($link){
    	header('Location: ' . $link);
        exit();
    }

}

?>