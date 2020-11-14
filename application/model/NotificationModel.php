<?php 

    class NotificationModel extends Model{
	
    	// Phương thức khới tạo
    	public function __construct(){
    		parent::__construct();
    	}
	   
    	// Phương thức thêm mới một thông báo
    	public function insertNotification($data){
    	    return $this->insertRecord('notifications', $data);
    	}
    	
    	// Phương thức lấy ra thông báo
    	public function loadNotifications($length, $begin=0){
    	    return $this->loadRecords('notifications', [], true, [
    	        'sort'=>[
    	            'column'=>'notification_created',
    	            'order'=>'DESC'    	           
    	        ],
    	        'limit'=>[
    	            'position'=>$begin,
    	            'length'=>$length
    	        ]
    	    ]);
    	}
    	
    	// Phương thức cập nhật thông báo
    	public function updateNotification($data, $where){
    	    return $this->updateRecord('notifications', $data, $where);
    	}
    	
    	// Phương thức tìm kiếm tiêu đề thông báo
    	public function searchQuestion($params){     	  
    	    $sql1 = 'SELECT COUNT(`notification_id`) as record ';
    	    $sql2 = 'SELECT * ';
    	    $sql = 'FROM `'.$this->setTable('notifications').'`';
    	    if($params['keyword']){
    	        $sql .= ' WHERE `notification_title` LIKE "%'.addslashes($params['keyword']).'%"';
    	    }
    	    $sql1 .= $sql;
    	    $sql = $sql2 . $sql;
    	    // Options
    	    if(isset($params['length']) && isset($params['page'])){
    	        $length = ($params['length']?$params['length']:DEFAULT_LENGTH);
    	        $pageCurrent = ($params['page']?$params['page']:1);
    	        $begin = ($pageCurrent - 1) * $length;
    	        $sql .= $this->createOptions([
    	            'sort'=>[
    	                'column'=>'notification_created',
    	                'order'=>'DESC'
    	            ],
    	            'limit'=>[
    	                'position'=>$begin,
    	                'length'=>$length
    	            ]]);
    	    }    	  
    	    // count
    	    $this->setQuery($sql1);
    	    $count = $this->read();
    	    $data = [];
    	    if($count){
    	        // data
    	        $this->setQuery($sql);
    	        $data= $this->readAll();
    	    }
    	    return [
    	        'count'=>($count['record'])?$count['record']:0,
    	        'data'=>$data
    	    ];
    	}
	
    	// Phương thức lấy ra tổng số thông báo
    	public function countNotification(){
    	    $sql = 'SELECT COUNT(notification_id) as record FROM ' . $this->setTable('notifications');
    	    $this->setQuery($sql);
    	    return $this->read();
    	}
}

?>