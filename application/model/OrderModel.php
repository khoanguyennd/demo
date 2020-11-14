<?php 

class OrderModel extends Model{
	
	// Phương thức khới tạo
	public function __construct(){
		parent::__construct();
	}
	
	// Phương thức tạo câu truy vấn 01
	public function createSql01(){
	    $sql  = 'SELECT tkt.*, scit.travelItemId, scl.travelProductId, tvit.`name` as travelname, spd.`name` as productname, cl.channel_name, scit.sellerProductId ';
	    $sql .= 'FROM  `'.$this->setTable('tickets').'` tkt, 
                        '.$this->setTable('salechannelitem').' scit, 
                        '.$this->setTable('salechannel').' scl, 
                        '.$this->setTable('channeltypes').' clt, 
                        '.$this->setTable('channels').' cl, 
                        '.$this->setTable('sellerproduct').' spd, 
                        '.$this->setTable('travelitems').' tvit ';
	    $sql .= 'WHERE tkt.salechannelitemid=scit.id 
                        AND scit.salechannelId=scl.id 
                        AND scl.channelTypeId=clt.type_id 
                        AND clt.channelid=cl.channel_id 
                        AND scl.sellerProductId=spd.sellerProductId 
                        AND scit.sellerTravelItemId=tvit.sellerTravelItemId ';                      
	    if(Session::get('accountshopping')['role'] > 0){
	        $sql .= 'AND cl.userid='.Structure::getUserId();
	    }	   
	    return $sql;	 
	}
	
	// Phương thức tạo câu truy vấn cho search và download
	public function createSql02($params){
	    // Từ ngày tháng đến ngày tháng	    
		if($params['method']=='today'){
	    	$sql = ' AND tkt.`ticket_created` BETWEEN "'.date('Y-m-d H:i:s', strtotime("-1 days")).'" AND "'.date('Y-m-d H:i:s', time()).'"';
		}elseif($params['method']=='unuse'){
	    	$sql = ' AND tkt.`ticket_status`=1';
	    }else{
	    	$sql = ' AND tkt.`ticket_created` BETWEEN "'.date('Y-m-d H:i:s', $params['datestart']).'" AND "'.date('Y-m-d H:i:s', $params['dateend']).'"';
	    }
	    
	    // Nhà cung cấp supplier: "all" spd.`supplier`
	    if($params['supplier'] != 'all'){
	        $sql .= ' AND spd.`supplier`='.$params['supplier'];
	    }
	    // Kênh bán channelsell: [] cl.`channel_cid`
	    if(isset($params['channelsell']) && $params['channelsell']){
	        $sql .= ' AND cl.`channel_cid` IN ('.$this->convertId($params['channelsell']).')';;
	    }
	    // Khôi phục
	    if($params['restore'] == 'true'){
	        $sql .= ' AND tkt.`ticket_restore`>0';
	    }
	    // Trạng thái
	    if(isset($params['status']) && $params['status']){
	        // 0 mua xong, 1 xử dụng xongm 2 hoàn tiền xong, -1 hết hiệu lực xử dụng
	        $sql .= ' AND tkt.`ticket_status` IN ('.$this->convertId($params['status']).')';
	    }
	    // Keyword
	    if($params['keyid'] && $params['keyword']){
	        $conKeyId = [
	            1 => 'spd.`name`',
	            2 => 'tvit.`name`',
	            3 => 'tkt.`ticked_name`',
	            4 => 'tkt.`order_id`',
	            5 => 'scit.`sellerProductId`',
	            6 => 'scl.travelProductId',
	            7 => 'scit.sellerTravelItemId',
	            8 => 'scit.travelItemId'
	        ];
	        if(isset($conKeyId[$params['keyid']])){
	            $sql .= ' AND '.$conKeyId[$params['keyid']].' LIKE "%'.$params['keyword'].'%"';
	        }
	    }	   
	    return $sql;
	}
	
	// Phương thức tính tổng số dòng
	public function countOrder($fetch = true){
	    $sql = $this->createSql01();	    
	    $sql = 'SELECT COUNT(tkt.id) as record '.substr($sql, strpos($sql, 'FROM'));	   
	    $this->setQuery($sql);
	    return $this->read($fetch);
	}
	
	// Phương thức lấy ra danh sách đơn hàng
	public function loadOrder( $sql, $sql1 , $length, $begin = 0, $fetch = true){
	    
	    $sql .= $this->createOptions([
	        'sort'=>[
	            'column'=>'tp.purchaseDateTime',
	            'order'=>'DESC'
	        ],
	        'limit'=>[
	            'position'=>$begin,
	            'length'=>$length
	        ]
	    ]);	   
	    //echo $sql;
	    // count
	    $this->setQuery($sql1);
	    $count = $this->read($fetch);
	    $data = [];
	    if($count){
	        // data
	        $this->setQuery($sql);
	        $data= $this->readAll($fetch);
	    }
	    return [
	        'count'=>($count['record'])?$count['record']:0,
	        'data'=>$data
	    ];	    
	}
	
	// Phương thức lấy ra danh sách nhà cung cấp
	public function loadSupplier($usid, $fetch = true){	    
	    $sql = 'SELECT idx, ID, company FROM `'.$this->setTable('user').'`';
	    if(Session::get('accountshopping')['role'] > 0){
	        $sql .= ' WHERE idx="'.$usid.'" OR idx_parent="'.$usid.'"';
	    }	   
	    $this->setQuery($sql);
	    return $this->readAll($fetch);
	}
	// Phương thức thai đổi trạng thái tickets
	public function changeStatusTicket($id, $status, $restore = 0){
	    return $this->updateRecord('ticket', [
	        'statusTicket'=>$status,
	        'restoreTicket'=>$restore,
	        'editStatus'=> 1,
	        'modifiedTicket'=>date('Y-m-d H:i:s', time())
	    ], ['ticketNumber'=>$id]);
	}
	
	// Phương thức load dữ liệu download
	public function downloadExcel($sql){
	    $sql .= $this->createOptions([
	        'sort'=>[
	            'column'=>'tp.purchaseDateTime',
	            'order'=>'DESC'
	        ],
	        'limit'=>[
	            'position'=> 0,
	            'length'=> 10000
	        ]
	    ]);
	    $this->setQuery($sql);
	    return $this->readAll();
	}
        // Phương thức tính tổng số dòng
	public function countOrderStatus($statusTicket){	    
	    $sql = 'SELECT COUNT(tb_ticket.id) as record FROM `tb_ticket` WHERE statusTicket='.$statusTicket;	   
	    $this->setQuery($sql);
            $count_result=$this->read();
	    return $count_result['record'];
	}
}

?>