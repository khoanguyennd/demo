<?php 

class UserModel extends Model{
	
	// Phương thức khới tạo
	public function __construct(){
		parent::__construct();
	}
	
	// Phương thức lấy ra tổng số thành viên
	public function countNotification(){
	    $sql = 'SELECT COUNT(idx) as record FROM ' . $this->setTable('user');
	    $this->setQuery($sql);
	    return $this->read();
	}
	
    // Phương thức hiển thị danh sách người phụ trách
    public function loadPersons($usid){
        return $this->loadRecords('persons', ['userid'=>$usid]);
    }
    
    // Phương thức xóa thôn tin người phụ trách
    public function insertPerson($data){        
        if($this->insertRecord('persons', $data)!= false){
            return true;
        }
        return false;
    }
    
    // Phương thức xóa thôn tin người phụ trách
    public function editPerson($data, $where){
        if($this->updateRecord('persons', $data, $where) != false){
            return true;
        }
        return false;
    }
    
    // Phương thức xóa thôn tin người phụ trách
    public function deletePerson($pid, $pemail){
        if($this->deleteRecord('persons', ['person_id'=>$pid, 'person_email'=>$pemail]) != false){
            return true;
        }
        return false;
    }

    // Phương thức lấy ra danh sách member
    public function loadMember($sql, $length = 0, $position = 0, $fetch = true){
        //if( $length != 0 && $position != 0)
        if( $length != 0)
        $sql .= $this->createOptions([           
            'limit'=>[
                'position'=>$position,
                'length'=>$length
            ]            
        ]);

        $this->setQuery($sql);
        return $this->readAll($fetch);
    }
    
    // Phương thức tính tổng memeber
    public function countMember($sql, $fetch = true){
        $this->setQuery($sql);
        return $this->read();
    }

    // Phương thức thay đổi trạng thái account
    public function changeStatus($status, $arrid){
        if(is_array($arrid)){
            $sql = 'UPDATE `' . $this->setTable('user') . '` SET `status`=? WHERE `idx` IN (' . $this->convertId($arrid) .')';
            $this->setQuery($sql);
            $this->execute([$status]);
            return $this->getRowCount();
        }
    }

    // Phương thức tìm kiếm member account
    public function searchMemberAcount($params){
        //accid 'keyword' 'col'], 'status''role']
        $sql1 = 'SELECT COUNT(u1.`idx`) as record ';
        $sql2 = 'SELECT u1.*,u2.ID as ID_parent ';
        $sql = 'FROM `'.$this->setTable('user').'` u1 LEFT JOIN `'.$this->setTable('user').'` u2 ON u1.idx_parent=u2.idx  WHERE u1.idx!='.$params['accid'];
        $where = [];
        if($params['status']!= 'all'){
            $item = 0;
            if($params['status']== 'active'){
                $item = 1;
            }
            $sql .= ' AND u1.`status`='.$item;           
        }
        if($params['role']!= 'all'){
            $item= 0;
            if($params['role']== 'seller'){
                $item= 1;
            }
            if($params['role']== 'supplier'){
                $item= 2;
            }
            $sql .= ' AND u1.`role`='.$item;
        }
        if($params['keyword']){
            $sql .= ' AND u1.`' .addslashes($params['col']).'` LIKE "%'.$params['keyword'].'%"';
        } 
        $sql1 = $sql1.$sql;
        $sql = $sql2.$sql;
        // Options
        if(isset($params['length']) && isset($params['page'])){
            $length = ($params['length']?$params['length']:DEFAULT_LENGTH);
            $pageCurrent = ($params['page']?$params['page']:1);
            $begin = ($pageCurrent - 1) * $length;
            $sql .= $this->createOptions([
                'sort'=>[
                    'column'=>'idx',
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
}

?>