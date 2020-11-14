<?php
function autoload($className){
    //kiểm tra xem file tồn tại không
    $fileName = PATH_APPLICATION . 'controller' . DS . $className. '.php';       
    if(file_exists($fileName)){
        //Nếu tồn tại thì nhúng file vào.
            require_once($fileName);
    }
}

spl_autoload_register('autoload');
