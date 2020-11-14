<?php
class Structure {
	
	// lấy người dùng	
	static function getUserId($name = false){	 
	    if (Session::get ( 'accountshopping' )) {
	        if($name == true){
	            return Session::get ( 'accountshopping' )['ID'];
	        }
	        if($name == false){
	            return Session::get ( 'accountshopping' )['idx'];
	        }
	    }
		return 0;
	}
	
	// person table
	static function persons( $data = [] ){
		$structure = [
		    'person_id'=>NULL,
		    'person_name'=>'',
		    'person_phone'=>'',
		    'person_email'=>'',
		    'person_created'=>time(),
		    'person_status'=>1,
		    'userid'=>self::getUserId()
		];
		if($data){
			return array_merge($structure, $data);
		}
		return $structure;
	}
	
	// channelstable
	static function channels( $data = [] ){
	    $structure = [
	        'channel_id'=>NULL,
	        'channel_cid'=>'',
	        'channel_name'=>'',
	        'channel_type'=>'',
	        'channel_created'=>time(),
	        'channel_created_by'=>self::getUserId(),
	        'channel_modified'=>0,
	        'channel_modified_by'=>0,
	        'channel_status'=>1,
	        'userid'=>self::getUserId()	       
	    ];
	    if($data){
	        return array_merge($structure, $data);
	    }
	    return $structure;
	}
	
	// channeltypestable
	static function channeltypes( $data = [] ){
	    $structure = [
	        'type_id'=>NULL,
	        'type_depth1'=>'',
	        'type_depth2'=>'',
	        'type_depth3'=>'',
	        'type_depth4'=>'',
	        'type_rate'=>'',
	        'type_created'=>time(),
	        'type_status'=>1,
	        'channelid'=>0
	    ];
	    if($data){
	        return array_merge($structure, $data);
	    }
	    return $structure;
	}
	
	// notification table
	static function notification( $data = [] ){
	    $structure = [
	        'notification_id'=>NULL,
	        'notification_title'=>'',
	        'notification_content'=>'',
	        'notification_created'=>time(),
	        'notification_created_by'=>self::getUserId(true),
	        'notification_modified'=>'',
	        'notification_modified_by'=>'',
	        'notification_status'=>1
	    ];
	    if($data){
	        return array_merge($structure, $data);
	    }
	    return $structure;
	}
	
	// producttype table
	static function producttype( $data = [] ){
	    $structure = [
	        'type_id'=>NULL,
	        'type_parentid'=>0,
	        'type_code'=>'',
	        'type_value'=>'',
	        'type_level'=>0,
	        'type_created'=>time(),
	        'type_created_by'=>self::getUserId(true),
	        'type_modified'=>'',
	        'type_modified_by'=>'',
	        'type_status'=>1,
	        'type_ordering'=>1
	    ];
	    if($data){
	        return array_merge($structure, $data);
	    }
	    return $structure;
	}
	
	// settlementdetails table
	static function settlements( $data = [] ){
	    $structure = [
	        'id'=>NULL,
	        'supplier'=>0,	      
	        'channelId'=>0,
	        'createdstart'=>date('Y-m-d', strtotime("-1 months")),
	        'createdend'=>date('Y-m-d', time()),
	        'pricetotal'=>0,
	        'amounttotal'=>0,
	        'feetotal'=>0,
	        'settlementtotal'=>0,
	        'status'=>1,
	        'modified'=>date('Y-m-d H:i:s', time()),
	        'modified_by'=>'System',
	        'settlementday'=>date('Y-m-d', strtotime("+1 days"))
	    ];
	    if($data){
	        return array_merge($structure, $data);
	    }
	    return $structure;
	}
	
	// settlementusertable
	static function settlementuser( $data = [] ){
	    $structure = [
	        'id'=>NULL,
	        'userId'=>0,
	        'supplierId'=>0,
	        'createdstart'=>date('Y-m-d', strtotime("-1 months")),
	        'createdend'=>date('Y-m-d', time()),
	        'settlementday'=>date('Y-m-d', strtotime("+1 days")),
	        'pricetotal'=>0,
	        'feetotal'=>0,
	        'settlementtotal'=>0,
	        'modified'=>NULL,
	        'modified_by'=>'System',
	        'status'=>'1'
	    ];
	    if($data){
	        return array_merge($structure, $data);
	    }
	    return $structure;
	}
	
	// settlementuseradjust
	static function settlementuseradjust( $data = [] ){
	    $structure = [
	        'id'=>NULL,
	        'settlementuserId'=>0,
	        'type'=>1,
	        'amount'=>0,
	        'pricetotal'=>0,
	        'feetotal'=>0,	        
	    ];
	    if($data){
	        return array_merge($structure, $data);
	    }
	    return $structure;
	}
	
	// settlementuserdetail
	static function settlementuserdetail( $data = [] ){
	    $structure = [
	        'id'=>NULL,
	        'settlementuserId'=>0,
	        'channelId'=>0,
	        'sellerProductId'=>'',
	        'price'=>0,
	        'amount'=>0,
	        'pricetotal'=>0,
	        'feetotal'=>0,
	        'statusnew'=>1
	    ];
	    if($data){
	        return array_merge($structure, $data);
	    }
	    return $structure;
	}
	
	// settlementuserlog
	static function settlementuserlog( $data = [] ){
	    $structure = [
	        'id'=>NULL,
	        'settlementuserId'=>0,
	        'content'=>'',
	        'created'=>NULL,
	        'created_by'=>'System',
	        'status'=>1
	    ];
	    if($data){
	        return array_merge($structure, $data);
	    }
	    return $structure;
	}
	
	// settlementuserlog
	static function apilogs( $data = [] ){
		$structure = [
				'log_id'=>NULL,
				'channelcid'=>'',			
				'sellerProductId'=>'',
				'travelProductId'=>'',
				'log_action'=>'',
				'log_result'=>'',
				'log_responsive'=>'',
				'log_created'=>time(),
				'log_status'=>1
		];
		if($data){
			return array_merge($structure, $data);
		}
		return $structure;
	}
	
	
	
}
?>