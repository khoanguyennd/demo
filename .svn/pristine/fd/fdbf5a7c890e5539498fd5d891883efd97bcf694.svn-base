<?php
class ConnectAPIController extends Controller {
    private $_Api; // Đối tượng Api tương ứng
    private $_name; // Tên Api tương ứng
    
    // Phương thức khởi tạo
    public function __construct($params) {
        parent::__construct ( $params );
    }
    
    // Phương thức thiết lập Api
    public function setApi($apiName = 'COUPANG') {
        if ($apiName) {
            $this->_name = ucfirst ($apiName);
            $apiName = $this->_name . 'Api';
            $this->_Api = new $apiName ();
        }
    }
    
    // Phương thức thêm tùy chọn của một sản phẩm
    public function insertProductTravelItem($travelProductId){
        if($this->_Api){
            $result = $this->_Api->insertProductTravelItem($travelProductId); 
            if($result){
                $modelname = 'insertProductTravelItem' . $this->_name; 
                return $this->_model->$modelname( $result );
            }
        }
        return false;
    }
        
    // Phương thức tự động cập nhật API
    // Start
    // Phương thức cập nhật dữ liệu sau khi thêm sản phẩm
    public function updateProductInsert($sellerProductId,$channelTypeId,$reponsive) { 
    	if ($reponsive['code'] == 200) {
    		$modelname = 'updateProductInsert' . $this->_name;
    		return $this->_model->$modelname($sellerProductId,$channelTypeId, $reponsive['data'] );
    	}
    	return false;
    }    
    // Phương thức cập nhật dữ liệu sau khi get sản phẩm
    public function updateDataProduct($reponsive){
    	if($reponsive['code']==200){
    		$modelname = 'updateProductGet' . $this->_name;
    		return $this->_model->$modelname( $reponsive['data'] );    	
    	}
    }
    // Phương thức lưu log sau khi gọi autoUpdateAction
    public function saveLogs($action, $channelcid, $sellerProductId, $travelProductId, $reponsive){    
    	$result = ($reponsive['code']==200)?'SUCCESS':'ERROR';
    	// Insert log
    	$this->_model->insertRecord('apilogs', Structure::apilogs([
    			'channelcid'=>$channelcid,
    			'sellerProductId'=>$sellerProductId, 
    			'travelProductId'=>$travelProductId,
    			'log_action'=>$action,
    			'log_result'=>$result,
    			'log_responsive'=>json_encode($reponsive)
    	]));
    }
//     [timestamp] => 2020-06-22T07:46:35.901+0000
//     [status] => 500
//     [error] => Internal Server Error
//     [message] => No message available
//     [path] => /v1/marketplace/travel/tickets/264700725123100672
    // Phương thức tự động cập nhật API
    public function autoUpdateAction(){
    	$items = $this->_model->loadAutoUpdate();
    	if($items){
    		foreach ($items as $key => $value){
    			$flag = false;
    			$action = 'UPDATE';
    			$reponsive = [];
    			echo '<pre>';
    			print_r($value); 
    			echo '</pre>';
    			// Tạo đối tượng API
    			if(!$this->_Api || $this->_name != ucfirst($value['channel_cid'])){
    				$this->setApi($value['channel_cid']); 
    			}    			
    			// Điều kiện
    			if($value['status'] == 2 || $value['status'] == 3 || $value['status'] == 4){    				
    				//isDelete = 1 onsSale = false; true
    				$flag = true;    				
    				$onsale = ($value['isDelete'])?false:true;
    				if($value['travelProductId']){
    				    $travelProductId = $value['travelProductId'];
    					// Cập nhật sản phẩm    		
    				    $reponsive = $this->_Api->editProduct($value['sellerProductId'],$travelProductId, $onsale);
//     				    $ch = curl_init();
//     				    curl_setopt($ch, CURLOPT_URL, "http://tbridge.lavianspa.com/testing-api.html/editProduct/".$value['sellerProductId']."/".$travelProductId."");
//     				    $reponsive=curl_exec($ch);
//     				    curl_close($ch);
    				}else{
    					$action = 'INSERT';
    					// Thêm sản phẩm
    					$reponsive = $this->_Api->insertProduct($value['sellerProductId'],$value['channelTypeId'], $onsale);
    					// Cập nhật dữ liệu
    					$this->updateProductInsert($value['sellerProductId'],$value['channelTypeId'],$reponsive);    	
    					if(isset($reponsive['data']['travelProductId'])){
    					    $travelProductId = $reponsive['data']['travelProductId'];
    					}
    				}
    				// Thêm apilogs    					
    			    //$this->saveLogs($action, $value['channel_cid'], $value['sellerProductId'], $travelProductId, $reponsive);
    						
    			}else{ // 0, 1, -1
    				// update api onSale = false
    				if(!empty($value['travelProductId'])){
    					// Cập nhật
    					$flag = true;
    					$travelProductId = $value['travelProductId'];
    				    $reponsive = $this->_Api->editProduct($value['sellerProductId'], $travelProductId, false);
    				}
//     				if($reponsive){   
//     				    // Thêm apilogs
//     				    $this->saveLogs($action, $value['channel_cid'], $value['sellerProductId'], $travelProductId, $reponsive);
//     				}    
    			}
    			//sleep(20);
    			if(isset($travelProductId)){
    			    $this->_Api->updateFeeAmount($travelProductId);
    			    
    			    if($flag == true){
    			        $this->_model->updateStatusedit($travelProductId);
    			    }
    			    // Lấy dữ liệu sản phẩm (Cập nhật sql)
    			    $reposive1=$this->_Api->getProduct( $travelProductId);
    			    $this->updateDataProduct($reposive1);
    			   
    			}
    			echo '<pre>';
    			print_r($reponsive);
    			echo '</pre>';
    			echo '<hr>';
    		}    		
    	}   
    	// 0 lưu tạm, 1 chờ duyệt, 2: chờ bán, 3 đang bán, 4 bán xong, -1 ngưng bán
    	// status: 0,1,-1 update api onSale = false
    	// status: 2 insert api travelproductid<>"" insert || update => get
    	// status: 3, 4 get api=>update sql
    }
    
    // End
    
    public function autoUpdateProductAction(){
        $items = $this->_model->loadAutoUpdateProduct();
        if($items){
            foreach ($items as $key => $value){
                // Tạo đối tượng API
                if(!$this->_Api || $this->_name != ucfirst($value['channel_cid'])){
                    $this->setApi($value['channel_cid']);
                }  
                // Lấy dữ liệu sản phẩm (Cập nhật sql)
                $reposive=$this->_Api->getProduct( $value['travelProductId']);
                $this->updateDataProduct($reposive);
                echo '<pre>';
                print_r($reposive);
                echo '</pre>';
                echo '<hr>';
            }
        }

    }
    
    // Phương thức tự động cập nhật Ticket API
    public function autoUpdateTicketAction(){
        $item = $this->_model->loadRecord('ticket', ['editStatus'=>1]); 
        //  statusTicket : 1 mua xong, 2: sử dụng xong, 3 hoàn tiền xong(hủy), -1 hết hiệu lực
        //  editStatus : 0 đã edit, 1 cần edit
        $items = $this->_model->loadRecords('ticket'); 
        foreach ($items as $key => $value){
            // Xử lý sử dụng và khôi phục vé
            if($value['editStatus']==1){
                $this->setApi();
                echo $value['ticketNumber'];
                $reponsive=[
                    "code"=> 200,
                    "message" => "CANCEL_COMPLETE"
                ];
                if($value['statusTicket']==1)
                    $reponsive = $this->_Api->unuseTicket($value['ticketNumber']);
                    
                    if($value['statusTicket']==2)
                        $reponsive = $this->_Api->useTicket($value['ticketNumber']);
                        
                        echo '<pre>';
                        print_r($reponsive);
                        echo '</pre>';
                        
                        $this->saveLogs("TICKET1", "COUPANG", $value['ticketNumber'], "", $reponsive);
                        $this->_model->updateRecord('ticket', ['editStatus'=>0],['where' => "ticketNumber='".$value['ticketNumber']."'"]);
            }
            // xử lý hủy vé
            if($value['statusType']=="CANCEL_COMPLETE" && $value['statusTicket']!=3){
                $this->_model->updateRecord('ticket', ['statusTicket'=>3],['where' => "ticketNumber='".$value['ticketNumber']."'"]);
                $reponsive=[
                    "code"=> 200,
                    "message" => "CANCEL_COMPLETE"
                ];
                $this->saveLogs("TICKET2", "COUPANG", $value['ticketNumber'] , "", $reponsive);
            }
            // xử lý vé hết hạn
        }
    }
    // End
    // Trang hiển thị logs
    public function logAction(){
    	$items= [];
    	if(isset($this->_params['length']) && isset($this->_params['page'])){
    		$count = $this->_model->countApiLogs();
    		$pagination = $this->paginationParams($count['record'], $this->route('logApi'));
    		if($pagination){
    			$result = $pagination;
    			$items = $this->_model->loadApiLogs($pagination['length'], $pagination['begin']);
    			$this->_view->setData('length', $pagination['length']);
    			$this->_view->setData('pagination', $pagination['pagination']);
    			$this->_view->setData('total', $pagination['count']);
    		}
    	}
    	$this->_view->setData('apilogs', $this->createRowApiLogs($items)); 
    	$this->_view->render('log');
    }
    // Phương thức tạo dòng cho danh sách lịch sử quyết toán
    public function createRowApiLogs($data){
    	$strHtml = '';
    	if($data){
    		foreach ($data as $key => $value){
    			$strHtml .= '<tr>
								<td>'.($key+1).'</td>
								<td>'.$value['channelcid'].'</td>
								<td>'.$value['sellerProductId'].'</td>
								<td>'.$value['travelProductId'].'</td>
								<td>'.$value['log_action'].'</td>
								<td><a href="'.$this->route('logsingeApi', ['lgid'=>$value['log_id']]).'" target="_blank">'.$value['log_result'].'</a></td>
								<td>'.date('Y-m-d H:i:s',$value['log_created']).'</td>
							</tr>';
    		}
    	}else{
    		$strHtml = '<tr><td colspan="7" class="empty">'.$this->_view->language('l_rowemptydata').'</td></tr>';
    	}
    	return $strHtml;
    }
	// Phương thức hiển thị log chi tiết
    public function logsingeAction(){    
    	$item = $this->_model->loadRecord('apilogs', ['log_id'=>$this->_params['lgid']]);    
    	if($item){
    		$item['log_responsive'] = json_decode($item['log_responsive'], true);
    		
    		echo '<pre>';
    		print_r($item);
    		echo '</pre>';
    	}
    }
    
    
    
    
    // Phương thức test
    public function testingAction(){
        if($this->_params['method']){
        	$this->setApi();
            $reposive = [];
            $method = $this->_params['method'];
            if($method=='insertProduct'){ // Thêm sản phẩm
            	$reposive = $this->_Api->insertProduct($this->_params['apiid1']);
            }
            if($method=='getProduct'){ // Lấy sản phẩm 
                $reposive = $this->_Api->getProduct($this->_params['apiid1']);
                $this->updateDataProduct($reposive);
            }
            
            if($method=='getProductList'){ // Lấy danh sách sản phẩm
                $reposive = $this->_Api->getProductList();
            }
            if($method=='editProduct'){ // sửa sản phẩm
                $reposive = $this->_Api->editProduct($this->_params['apiid1'], $this->_params['apiid2']);
            }
            if($method=='deleteProduct'){ // xóa sản phẩm
                $reposive = $this->_Api->deleteProduct($this->_params['apiid1']);
            }
            if($method=='insertProductTravelItem'){ // Thêm option
            	$reposive = $this->_Api->insertProductTravelItem($this->_params['apiid1']);
            }
            if($method=='editProductTravelItem'){ // Edit option
                $reposive = $this->_Api->editProductTravelItem($this->_params['apiid1'], $this->_params['apiid2']);
            }
            if($method=='deleteProductTravelItem'){ // Delete option
                $reposive = $this->_Api->deleteProductTravelItem( $this->_params['apiid1'], $this->_params['apiid2']);
            }
            if($method=='updateFeeAmount'){ // Update Fee Amount
                $reposive = $this->_Api->updateFeeAmount($this->_params['apiid1']);
            }
            if($method=='getInventoryList'){ // Get InventoryList
                $reposive = $this->_Api->getInventoryList( $this->_params['apiid1']);
            }
            /////////////////////////////////////////////////////////////////////////////////////////////////
            if($method=='useTicket'){ // use Ticket process
                $reposive = $this->_Api->useTicket($this->_params['apiid1']);
            }
            if($method=='useMultiTicket'){ // use multi Ticket process
                $reposive = $this->_Api->useMultiTicket($this->_params['apiid1']);
            }
            if($method=='unuseTicket'){ // use Ticket process
                $reposive = $this->_Api->unuseTicket($this->_params['apiid1']);
            }
            if($method=='unuseMultiTicket'){ // use multi Ticket process
                $reposive = $this->_Api->useMultiTicket($this->_params['apiid1']);
            }
            if($method=='getInfoBuyerTicket'){ // 
                $reposive = $this->_Api->getInfoBuyerTicket();
                if(isset($reposive['totalCount'])){
                    $totalCount=$reposive['totalCount'];
                    $ticketPurchasers=$reposive['ticketPurchasers'];
                    for ($i=0 ;$i<$totalCount;$i++) {
                        $this->_model->uiticketPurchasersCoupang($ticketPurchasers[$i]);
                        $reposive1 = $this->_Api->getDetailTicket($ticketPurchasers[$i]['ticketNumber']);
                        if($reposive1['code']="0000"){
                            $ticket=$reposive1['ticket'];
                            $this->_model->uiticketCoupang($ticket);
                        }
                        echo '<pre>';
                        print_r($reposive1);
                        echo '</pre>';
                    }
                }
            }
            if($method=='getDetailTicket'){ // 
                $reposive = $this->_Api->getDetailTicket($this->_params['apiid1']);
            }
            if($method=='getDetailMultiTicket'){ //
                $reposive = $this->_Api->getDetailMultiTicket();
            }
            /////////////////////////////////////////////////////////////////////////////////////////////////////
            if($method=='getInfoBuyerTicketV2'){ //
                $reposive = $this->_Api->getInfoBuyerTicketV2();
            }
            echo '<pre>';
            print_r($reposive);
            echo '</pre>';
        }else{
            $this->_view->setFileTemplate('testapi');
            require $this->_view->_fileTemplate;
        }
    }
}
?>