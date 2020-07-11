<?php
require 'plugins/prints/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\CapabilityProfile;

class PosPrinter{
	
	// đối tượng printer
	public $_printer;
	
	// Giá trị lỗi
	public $_error;
	
	// Phương thức khởi tạo kết nối máy in
	public function __construct(){
		try {			
			$profile = CapabilityProfile::load("P822D");
			$connector = new NetworkPrintConnector(Func::getClientIp(), 9100);
			$this->_printer = new Printer($connector, $profile);
		} catch ( Exception $e ) {
			$this->_error = $e -> getMessage();
			//die ( $e -> getMessage() );			
		}
	}
	
	// Phương thức in nội dung bình luận
	public function comment($id, $name, $phone, $mess){
		if($this->_printer){
			$this->_printer->setJustification($this->_printer::JUSTIFY_RIGHT);
			$this->_printer->text("MD: ". $id. "\n");
			$this->_printer->setTextSize(2, 2);
			$this->_printer->setJustification($this->_printer::JUSTIFY_CENTER);
			$this->_printer->setDoubleStrike(true);
			$this->_printer->text(strtoupper(Func::convertUnicode($name))."\n");			
			$this->_printer->setDoubleStrike(false);			
			if($phone){
				$this->_printer->text('( '.$phone." )\n");
			}
			$this->_printer->feed(2);
			$this->_printer->text(Func::convertUnicode($mess)."\n");
			
			$this->_printer->feed(1);
			$this->_printer->setTextSize(1, 1);
			$this->_printer->setJustification($this->_printer::JUSTIFY_RIGHT);
			$this->_printer->text("https://thunganonline.com\n");
			$this->_printer->cut();
		}
	}
	
	public function bills($data){
		if($data){
			$this->_printer->setTextSize(3, 3);
			$this->_printer->setJustification($this->_printer::JUSTIFY_CENTER);
			$this->_printer->setDoubleStrike(true);
			$this->_printer->text("00E1 Liên Shop\n");
			
			$this->_printer->feed(2);			
			$this->_printer->setDoubleStrike(false);			
			$this->_printer->setJustification();
			$this->_printer->setTextSize(1, 1);
			
			$this->_printer -> text("Khach hang: Trương Minh Hải\n");
			$this->_printer -> text("Dien thoai: 0843954595\n");
			$this->_printer -> text("Dia chi: 63 Bình Nam, Xã Bình Hòa Trung, Huyện Mộc Hóa, Tỉnh Long An\n");
			
			$this->_printer->setUnderline(2);
			$date = date('d/m/Y H:i:s', time());			
			$this->_printer -> text($date ."          ". $date. "\n");
			
			$this->_printer->setUnderline(false);
			$this->_printer->setLineSpacing(80);
			$this->_printer->setDoubleStrike(true);			
			$this->_printer -> text("S.Pham         G.Gia   SL     D.Gia       T.Tien\n");
			
			$this->_printer->setDoubleStrike(false);
			$this->_printer -> text("Quần Tây            1      135.000       135.000\n");
			$this->_printer->setUnderline(2);
			$this->_printer -> text("Quần Caro           1      150.000       150.000\n");
			$this->_printer->setUnderline(false);
			
			$this->_printer->setEmphasis(true);
			$this->_printer -> text("Tong tien                                285.000\n");
			$this->_printer -> text("Tien ship                                 30.000\n");
			//$this->_printer -> text("Giam gia                                     0\n");
			//$this->_printer -> text("Phu thu                                      0\n");
			//$this->_printer -> text("Tru no                                       0\n");
			//$this->_printer -> text("Chuyen khoan                                 0\n");
			$this->_printer -> text("Thanh toan                               315.000\n");
			
			$this->_printer->cut();
		}
	}
	
	// Phương thức ngắt kết nối máy in
	public function __destruct()
	{
		if($this->_printer){
			$this->_printer->close();
		}
	}
	
}

?>

