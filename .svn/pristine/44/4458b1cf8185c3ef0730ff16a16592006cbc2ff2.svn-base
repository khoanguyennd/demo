<?php

class Upload
{

    // Biến lưu trữ tên tập tin
    public $_fileName;

    // Biến lưu trữ kích thước tập tin
    public $_fileSize;

    // Biến lưu trữ phần mỡ rộng của tập tin
    public $_fileExtension;

    // Biến lưu trữ đường dẫn tạm của tập tin
    public $_fileTmp;

    // Biến lưu trữ đường dẫn upload
    public $_uploadDir;

    // Biến lưu trữ các giá trị lỗi
    public $_errors = null;

    // Phương thức khởi tạo
    public function __construct($file = null)
    {
        if ($file != null) {
            $fileInfo = $_FILES [$file];
            $this->_fileName = $fileInfo ['name'];
            $this->_fileSize = $fileInfo ['size'];
            $this->_fileTmp = $fileInfo ['tmp_name'];
            $this->_fileExtension = $this->getFileExtension();
            //$this->setFileExtension(FILE_EXTENSION);
            $this->setFileSize(FILE_SIZE);
        }
    }

    // Phương thức lấy phần mở rộng
    public function getFileExtension()
    {
        $exten = strtolower(pathinfo($this->_fileName, PATHINFO_EXTENSION));
        return $exten;
    }

    // Phương thức get filename
    public function getFileName()
    {
        return $this->_fileName;
    }

    // Phương thức get fileTmp
    public function getFileTmp()
    {
        return $this->_fileTmp;
    }

    // Phương thức thiết lập phần mở rộng
    public function setFileExtension($strExtension)
    {
        if (strpos($strExtension, $this->_fileExtension) === false) {
            $this->_errors = 'errExtension';//"Định dạng tập tin không hợp lệ! ( ". $strExtension ." )";
        }
    }

    // Phương thức thiết lập kích thước tối thiều và kích thước tối đa (đơn vị tính B)
    public function setFileSize($max)
    {
        $maxNumber = $this->conSize(Func::getValue('numeric', $max), Func::getValue('string', $max));
        if ($this->_fileSize > $maxNumber) {
            $this->_errors = 'errSize';//"Kích thước tập tin không phù hợp! ( max: ". $max .")";
        }
    }

    // Phương thức thiết lập đường dẫn đến folder
    public function setUploadDir($dir)
    {
        $dir = PATH_ROOT . DS . "attach/" . $dir;//localhost

        //$dir="gs://".$dir;//host GAE
        if (file_exists($dir)) {
            $this->_uploadDir = $dir;
        } else {
            $this->_errors = 'errFolder'; //"Thư mục không hợp lệ!";
        }
    }

    // Phương thức kiểm tra điều kiện upload của tập tin
    public function isValidate()
    {
        $flag = false;
        if ($this->_errors == null) {
            $flag = true;
        }
        return $flag;
    }

    /*public function register_stream_wrapper($projectId) {
        $client = new StorageClient(['projectId' => $projectId]);
        $client->registerStreamWrapper();
    }*/
    // Phương thức upload tập tin
    public function uploadFile($rename = true)
    {
        //register_stream_wrapper("klkim-project");

        $filename = $this->_fileName;
        if ($rename == true) {
            $filename = $this->randomString();
            $destination = $this->_uploadDir . $filename;
        } else {
            $destination = $this->_uploadDir . $filename;
        }
        @move_uploaded_file($this->_fileTmp, $destination);
        return $filename;
    }

    // Phương thức hiển thị lỗi
    public function showError()
    {
        return $this->_errors;
    }

    // Phương thức random
    public function randomString($lenth = 15)
    {
        $search = '.' . $this->_fileExtension;
        $replace = '_' . time() . '.' . $this->_fileExtension;
        return str_replace($search, $replace, $this->_fileName);
    }

    // Phương thức chuyển đổi đơn vị của tập tin
    public function conSizeUnit($totalDigit = 2, $ditance = ' ')
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        for ($i = 0; $i < count($units); $i++) {
            if ($this->_fileSize >= 1024) {
                $this->_fileSize = $this->_fileSize / 1024;
            } else {
                $unit = $units[$i];
                break;
            }
        }
        return round($this->_fileSize, $totalDigit) . $ditance . $unit;
    }

    // Phương thức chuyển đổi đơn vị của tập tin
    public function conSize($number, $unit)
    {
        $units = array('KB', 'MB', 'GB', 'TB');
        for ($i = 0; $i < count($units); $i++) {
            if ($units[$i] != strtoupper($unit)) {
                $number *= 1024;
            } else {
                $number *= 1024;
                break;
            }
        }
        return $number;
    }
}

?>