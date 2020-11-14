<?php

class DashboardModel extends Model{
    
    // Phương thức khới tạo
    public function __construct(){
        parent::__construct();
    }
    
    // Phương thức load load_trandau_chitiet
    public function load_trandau_chitiet($trandau_id, $thanhvien_id , $orderby , $limit){
        $sql  = "SELECT * FROM `trandau_chitiet` WHERE trandau_id=" . $trandau_id . " AND thanhvien_id=" . $thanhvien_id . "  order by luot $orderby ";
        if($limit!=0)
            $sql .= " LIMIT 0,$limit";
        $this->setQuery($sql);
        return $this->readAll();
    }
    
    // Phương thức load load_trandau_chitiet
    public function load_trandau_chitiets($trandau_id, $thanhvien_id_1,$thanhvien_id_2, $orderby , $limit){
        $sql  = "SELECT * FROM `trandau_chitiet` WHERE trandau_id=" . $trandau_id . " AND (thanhvien_id=" . $thanhvien_id_1 . " OR thanhvien_id=" . $thanhvien_id_2 . ") order by luot $orderby ";
        if($limit!=0)
            $sql .= " LIMIT 0,$limit";
        $this->setQuery($sql);
        $result= $this->readAll();
        $data[0]=[];
        $data[1]=[];
        foreach ($result as $value=>$giatri){
            if($giatri['thanhvien_id']==$thanhvien_id_1 )
                $data[$value][]=$giatri;
            if($giatri['thanhvien_id']==$thanhvien_id_2 )
                $data[$value][]=$giatri;
        }
        return $data;
    }
    // Phương thức load load_trandau_thanhvien
    public function load_trandau_thanhvien($trandau_id){
        $sql  = "SELECT * FROM `trandau_thanhvien` WHERE trandau_id=" . $trandau_id . " order by id DESC";
        $this->setQuery($sql);
        return $this->readAll();
    }
    // Phương thức load load_trandau_thanhvien
    public function loadthanhvien($thanhvien_id_1,$thanhvien_id_2){
        $sql  = "SELECT * FROM `thanhvien` WHERE id=" . $thanhvien_id_1 . " OR id=" . $thanhvien_id_2 . "";
        $this->setQuery($sql);
        return $this->readAll();
    }
    // Phương thức load load_trandau_thanhvien
    public function load_doidau($thanhvien_id_1,$thanhvien_id_2){
        $sql  = " SELECT trandau_id 
                  FROM trandau_thanhvien 
                  WHERE thanhvien_id= " . $thanhvien_id_1;
        $this->setQuery($sql);

        $doidau=$this->readAll();
        $listTranDau = [];
        foreach ($doidau as $key => $val) {
            $listTranDau[] = $val['trandau_id'];
        }
        if(!count($listTranDau)) return 0;

        $sql  = " SELECT count(trandau_id) as trandau 
                  FROM trandau_thanhvien 
                  WHERE trandau_id IN (" . implode(',', $listTranDau) . ") AND thanhvien_id= " . $thanhvien_id_2;
                     
        $this->setQuery($sql);
        return (int)$this->readAll()[0]['trandau'];
    }
   
    // Phương thức load load_thanh_tich
    public function load_thanh_tich( $thanhvien_id_1,$thanhvien_id_2){

        $sql  = '   SELECT tv.id, COUNT(ct.thanhvien_id) as total,SUM(ct.diem) as total_diem,SUM(ct.time) as total_thoigian
                    FROM thanhvien tv LEFT JOIN trandau_chitiet ct ON tv.id=ct.thanhvien_id
                    WHERE tv.id='.$thanhvien_id_1.' OR tv.id='.$thanhvien_id_2.'
                    GROUP BY tv.id ';
        $this->setQuery($sql);
        return $this->readAll();
    } 
    
    // Phương thức load trung binh tich luy của thanhvien
    public function avgThanhvien($thanhvien_id){
        $sql  = 'SELECT COUNT(thanhvien_id) as total,SUM(diem) as total_diem,SUM(time) as total_thoigian FROM trandau_chitiet WHERE thanhvien_id='.$thanhvien_id;
        $this->setQuery($sql);
        $result = $this->read();
        $tong_luot=$result['total'];
        $tong_diem=$result['total_diem'];
        $tong_thoigian=$result['total_thoigian'];
        if($tong_luot==0){
            $trungbinh_tichluy=0;
            //$trungbinh_thoigian_player1=0;
        }else{
            $trungbinh_tichluy=$tong_diem/$tong_luot;
            //$trungbinh_thoigian_player1=$tong_thoigian/$tong_luot;
        }
        return $trungbinh_tichluy;
    }

	public function getInnering($idTrandau){  
		$infoInnering = array();
        $infoInnering['innering'] = 1;
        $infoInnering['user_current'] = 1;
        $infoInnering['timess'] = 0;
        
        $sql ="SELECT MAX(luot) as luotco, thanhvien_id,SUM(time) as timess   FROM trandau_chitiet WHERE trandau_id=" . $idTrandau . " GROUP BY(thanhvien_id)";

        $this->setQuery($sql);
        $innering = $this->readAll();
        
        if(isset($innering) && count($innering) ==2){    	
            $infoInnering['timess']+=$innering[0]['timess'];
            $infoInnering['timess']+=$innering[1]['timess'];
            
        	if($innering[0]['luotco'] == $innering[1]['luotco']){
        		$infoInnering['innering'] = (int)$innering[0]['luotco'] + 1;
        		$infoInnering['user_current'] = 1;
        	} else {
        		$innering[0]['luotco'] > $innering[1]['luotco'] ? $infoInnering['innering'] = $innering[0]['luotco'] :  $infoInnering['innering'] = $innering[1]['luotco'];
        		$infoInnering['user_current'] = 0;        		
        	}        	
        } elseif(count($innering)==1) {
            $infoInnering['timess']+=$innering[0]['timess'];
        	$infoInnering['user_current'] = 0;
        }
        return $infoInnering;
    }

    public function getTotalTime($idTrandau){
    	$sql ="SELECT SUM(time) as timess  FROM trandau_chitiet WHERE trandau_id=" . $idTrandau;
        $this->setQuery($sql);
        $time = $this->read();
        return $time['timess'];
    }

    public function getTotalPointUser($idTrandau, $userId){
    	$sql ="SELECT SUM(diem) as diem  FROM trandau_chitiet WHERE trandau_id=" . $idTrandau . " AND thanhvien_id = $userId";
    	$this->setQuery($sql);
        $diem = $this->read();
        return $diem['diem']  > 0 ? $diem['diem'] : 0;
    }

    public function getTotalPoint2User($idTrandau, $thanhvien_trandau_id){
        $sql ="SELECT SUM(diem) as diem FROM trandau_chitiet WHERE trandau_id=" . $idTrandau . " AND thanhvien_trandau_id = $thanhvien_trandau_id";

        $this->setQuery($sql);
        $diem = $this->read();
        return $diem['diem']  > 0 ? $diem['diem'] : 0;;
    }

    public function getHistoryPointUser($idTrandau, $userId){
    	$pointHistory = array();
    	$sql = "SELECT * FROM trandau_chitiet WHERE trandau_id=" . $idTrandau . " AND thanhvien_id = $userId ORDER BY id DESC";
    	$this->setQuery($sql);
        $pointHistory = $this->readAll();
        return $pointHistory;
    }

    public function checkTranDauBegin($idTrandau){
        $sql = 'SELECT COUNT(*) as record FROM trandau_chitiet WHERE trandau_id=' . $idTrandau;
        $this->setQuery($sql);
        return (int)$this->read()['record']; 
    }
    
    public function trandauchitiet_start3($trandau_id){
        $sql = "SELECT thanhvien_trandau_id,content,time,timesave FROM `trandau_chitiet` WHERE trandau_id=" . $trandau_id . " order by id DESC";
        $this->setQuery($sql);
        return $this->readAll();
    }
    public function trandauthanhvien_start3($trandau_id){
        $sql = "SELECT tv.id,tv.thanhvien_name,tv.diem as diemketthuc,MAX(ct.id) as idx,ct.diem ,ct.thanhvien_trandau_id,MAX(uw.thutu) as thutu
                FROM trandau_thanhvien tv LEFT JOIN (
                                                    SELECT id,diem,thanhvien_trandau_id
                                                    FROM trandau_chitiet
                                                    WHERE id IN (
                                                                    SELECT max(id) as idx 
                                                                    FROM trandau_chitiet 
                                                                    WHERE trandau_id=$trandau_id
                                                                    GROUP BY thanhvien_trandau_id
                                                    )) ct ON tv.id=ct.thanhvien_trandau_id
                                        LEFT JOIN`trandau_userwin` uw ON tv.id=uw.thanhvien_trandau_id
                WHERE tv.trandau_id=$trandau_id
                GROUP BY tv.id
                ORDER BY tv.thanhvien_name,tv.id;";
        $this->setQuery($sql);
        return $this->readAll();
    }
}

?>