<?php 

class QuestionModel extends Model{
	
	// Phương thức khới tạo
	public function __construct(){
		parent::__construct();		
	}
	
	// 
	public function createSql01($method){
		$sql = 'SELECT * FROM `'.$this->setTable('question').'` WHERE ';
		if($method == 'unreply'){
			$sql .= '`question_status`=1';
		}else{
			$sql .= '`question_created` BETWEEN "'.strtotime("-7 days").'" AND "'.time().'"';
		}
		return $sql;
	}
	
	// Phương thức lấy ra tổng số dòng question
	public function countQuestion($sql){
	    $this->setQuery($sql);
	    return $this->read();
	}
	
	// Phương thức lấy ra danh sách câu hỏi
	public function loadQuestions($sql, $length, $begin=0){
		$sql .= $this->createOptions([
				'sort'=>[
					'column'=>'question_created',
					'order'=>'DESC'
				],
				'limit'=>[
					'position'=>$begin,
					'length'=>$length
				]]);
		$this->setQuery($sql);
		return $this->readAll();	   
	}
	
	// Phương thức lấy ra danh sách câu hỏi download Excel
	public function loadQuestionsDownload(){
	    return $this->loadRecords('question');
	}
	
	
	// Phương thức lấy ra câu hỏi
	public function loadQuestion($qsid){
	    return $this->loadRecord('question', ['question_id'=>$qsid]);
	}
	
	// Phương thức cập nhật câu trả lời
	public function updateQuestion($data, $where){
	    return $this->updateRecord('question', $data, $where);
	}
	
	// phương thức tiềm kiếm hỏi đáp
	public function searchQuestion($params){
	    $sql1 = 'SELECT COUNT(`question_id`) as record ';
	    $sql2 = 'SELECT * ';
	    $sql = 'FROM `'.$this->setTable('question').'` WHERE ';
	    
	    // Trạng thái
	    if($params['method'] == 'unreply'){
	    	$sql .= '`question_status`=1';
	    }else{
	    	// Từ ngày tháng đến ngày tháng
	    	$sql .= '`question_created` BETWEEN "'.$params['datestart'].'" AND "'.$params['dateend'].'"';
	    	if($params['status'] != 'all'){
	    		$sql .= ' AND `question_status`="'.$params['status'].'"';
	    	}
	    }
	    
	    // Nhà cung cấp supplier: "all" => supplier  chưa làm
	    // Kênh bán channelsell: =>channelsell chưa làm
	    
	    // Từ khóa
	    if($params['keyword']){
	        $col = str_replace('question', 'question_', $params['keyid']);
	        $keyword = ($params['keyid']== 'questionid')?(int)Func::getValue('numeric',$params['keyword']):$params['keyword'];
	        $sql .= ' AND `'.$col.'` LIKE "%'.$keyword.'%"';
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
	                'column'=>'question_created',
	                'order'=>'DESC'
	            ],
	            'limit'=>[
	                'position'=>$begin,
	                'length'=>$length
	            ]]);
	    }
// 	    echo $sql;
        // count       
	    $this->setQuery($sql1);	 
	    $count = $this->read();
	    $data = [];
	    if($count){
	        // data
	        $this->setQuery($sql);
	        $data= $this->readAll();	       
	        return [
		        'count'=>($count['record'])?$count['record']:0,
		        'data'=>$data	        		
		    ];
	    }


	}
	
	// Phương thức lấy ra danh sách nhà cung cấp
	public function loadSupplier($usid, $fetch = true){
	    $sql = 'SELECT idx, ID FROM `'.$this->setTable('user').'` WHERE idx=? OR idx_parent=?';
	    $this->setQuery($sql);
	    return $this->readAll($fetch, [$usid, $usid]);
	}
}

?>