<?php class ConnectAPIModel extends Model{
	
	// Phương thức khới tạo
	public function __construct(){
		parent::__construct();
	}
	
	// Phương thức lấy dữ liệu cập nhật api	
	public function loadAutoUpdate(){		
		$sql  = 'SELECT c.channel_cid, sp.sellerProductId, sc.travelProductId,sc.channelTypeId, sc.`status`, sc.isDelete, sc.statusedit ';
		$sql .= 'FROM tb_sellerproduct sp, tb_salechannel sc, tb_channeltypes ct, tb_channels c ';
		$sql .= 'WHERE sp.sellerProductId=sc.sellerProductId AND sc.channelTypeId=ct.type_id AND ct.channelid=c.channel_id 
                        AND sc.isDelete=0  AND sc.statusedit=1 AND c.channel_cid="COUPANG" ';
		$sql .= 'ORDER BY c.channel_cid ASC';	
		echo $sql;
		$this->setQuery($sql);
		return $this->readAll();
	}
	// Phương thức lấy dữ liệu cập nhật api
	public function loadAutoUpdateProduct(){
	    $sql  = 'SELECT c.channel_cid, sp.sellerProductId, sc.travelProductId,sc.channelTypeId, sc.`status`, sc.isDelete, sc.statusedit ';
	    $sql .= 'FROM tb_sellerproduct sp, tb_salechannel sc, tb_channeltypes ct, tb_channels c ';
	    $sql .= 'WHERE sp.sellerProductId=sc.sellerProductId AND sc.channelTypeId=ct.type_id AND ct.channelid=c.channel_id
                        AND sc.travelProductId!="" AND ( sc.productId is null OR sc.qcStatus!="COMPLETE_APPROVAL")  AND c.channel_status=1 AND c.channel_cid="COUPANG" ';
	    //AND ( sc.productId is null OR sc.qcStatus!="COMPLETE_APPROVAL")
	    $sql .= 'ORDER BY c.channel_cid ASC  LIMIT 0,1 ';
	    echo $sql;
	    $this->setQuery($sql);
	    return $this->readAll();
	}
	// Phương thức cập nhật dữ liệu khi thêm sản phẩm api
	public function updateProductInsertCoupang($sellerProductId,$channelTypeId,$reponsive){  
		$sql = "UPDATE tb_salechannel sc
                SET sc.`travelProductId`='" . $reponsive['travelProductId'] . "' 
                WHERE sc.`sellerProductId`='" . $reponsive['sellerProductId'] . "' 
                      AND sc.`channelTypeId`=$channelTypeId";
		//, sc.`status`= 3 
	    $this->setQuery($sql);
	    if ($this->execute()) {
	    	foreach ($reponsive['itemCreateResponse'] as $key => $value) {
	            $sql = "UPDATE tb_salechannelitem  sci, tb_salechannel sc
                        SET sci.`travelItemId`='" . $value['travelItemId'] . "' 
                        WHERE sci.`sellerProductId`='" . $reponsive['sellerProductId'] . "' AND sci.`sellerTravelItemId`='" . $value['sellerTravelItemId'] . "' 
                        AND sci.`salechannelId`=sc.id AND sc.`channelTypeId`=$channelTypeId";
	            $this->setQuery($sql);
	            $this->execute();
	        }
	    }
	    return true;
	}
	
	// Phương thức cập nhật dữ liệu khi get sản phẩm api
	public function updateProductGetCoupang($reponsive){
		return $this->updateRecord('salechannel', [
				'vendorItemPackageId'=>$reponsive['vendorItemPackageId'],
				'interlockingChannelType'=>$reponsive['interlockingChannelType'],
				'vendorId'=>$reponsive['vendorId'],
		        'productId'=>$reponsive['productId'],
				'qcStatus'=>$reponsive['qcStatus']
		], [
				'travelProductId'=>$reponsive['travelProductId']
		]);
	}
	
	// Phương thức cập nhật statusedit sau khi kết nối api
	public function updateStatusedit($travelProductId){
	    $sql='UPDATE `tb_salechannel` SET `statusedit`=2,`status`=3 WHERE `travelProductId`='.$travelProductId;
	    $this->setQuery($sql);
	    return $this->execute();
	    //`status`=IF(status = 2 AND qcStatus="COMPLETE_APPROVAL", 3 , status)
	}
	// Phương thức cập nhật sau khi thêm tùy chọn cho sản phẩm api
	public function insertProductTravelItemCoupang($params){		
		if(isset($params['responsive']) && isset($params['salechannelitemid'])){
			foreach ($params['responsive'] as $key => $value){
				if($value['code'] == 200){
					$this->updateRecord('salechannelitem', ['travelItemId'=>$value['data']], ['id'=>$params['salechannelitemid'][$key]]);
				}
			}
			return true;
		}
		return false;		
	}
	// Phương thức cập nhật , insert ticketPurchasers
	public function uiticketPurchasersCoupang($ticketPurchasers){
	    $data=[
	        "userName"=> $ticketPurchasers['userName'],
	        "phoneNumber" => $ticketPurchasers['phoneNumber'],
	        "email" => $ticketPurchasers['email'],
	        "dealId" => $ticketPurchasers['dealId'],
	        "dealName" => $ticketPurchasers['dealName'],
	        "optionId" => $ticketPurchasers['optionId'],
	        "optionName" => $ticketPurchasers['optionName'],
	        "price" => $ticketPurchasers['price'],
	        "purchaseDateTime" => $ticketPurchasers['purchaseDateTime'],
	        "status" => $ticketPurchasers['status']
	       ];
	    if($ticketPurchasers['canceledDateTime']!="")
	        $data["canceledDateTime"] = $ticketPurchasers['canceledDateTime'];
	    
	    $ticketNumber = $ticketPurchasers['ticketNumber'];
	    $item=$this->loadRecord('ticketPurchasers', ['ticketNumber' => $ticketNumber]);
	    if ($item) { // update
	        $this->updateRecord('ticketPurchasers', $data,['where' => "ticketNumber='$ticketNumber'"]);
	    }else{
	        $data["ticketNumber"] = $ticketNumber;
	        $this->insertRecord('ticketPurchasers', $data);
	    }
	       
	}
	// Phương thức cập nhật , insert ticket
	public function uiticketCoupang($ticket){
	    $data=[
	        "useAmount"=> $ticket['useAmount'],
	        "totalAmount" => $ticket['totalAmount'],
	        "statusType" => $ticket['statusType'],
	        "redeemable" => $ticket['redeemable'],
	        "price" => $ticket['price'],
	        "optionId" => $ticket['optionId'],
	        "dealId" => $ticket['dealId'],
	        "purchasedAt" => $ticket['purchasedAt']
	    ];

	    if($ticket['canceledAt']!="")
	        $data["canceledAt"] = $ticket['canceledAt'];
	    
        $ticketNumber = $ticket['ticketNumber'];
        $item=$this->loadRecord('ticket', ['ticketNumber' => $ticketNumber]);
        if ($item) { // update
            $this->updateRecord('ticket', $data,['where' => "ticketNumber='$ticketNumber'"]);
        }else{
            $data["ticketNumber"] = $ticketNumber;
            $this->insertRecord('ticket', $data);
        }
	        
	}
	// Phương thức load apilog
	public function countApiLogs(){
		$sql = 'SELECT COUNT(log_id) as record FROM tb_apilogs';
		$this->setQuery($sql);
		return $this->read();
	}
	public function loadApiLogs($length, $begin=0, $fetch=true){		
		return $this->loadRecords('apilogs', [], true, [
				'sort'=>[
						'column'=>'log_created',
						'order'=>'DESC'
				],
				'limit'=>[
						'position'=>$begin,
						'length'=>$length
				]
		]);
	}
	
}

?>