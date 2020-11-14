<?php class Ticket3Controller extends Controller
{
    // Phương thức khởi tạo
    public function __construct($params)
    {
        parent::__construct($params);
        $this->isLogin();
        $account = $_SESSION['accountshopping'];
        if($account['temp']==1)
            Url::header($this->route('account')."#tab1");
    }

    // Phương thức mã hóa password
    public function md5Password($password)
    {
        return md5($password);
        // return md5(md5('*)2^).-+(479&##' . $password . '#8$#@%^457'));
    }

    public function editticket3Action()
    {
    	$sellerProductId = $this->_params['sellerProductId'];

        if (isset($this->_params['btnSumit']) && $this->_params['btnSumit'] == "editticket3") {
            // update statusedit
            //$data = [ 'statusedit' => 1, 'status' => 0 ];
            $this->_model->updateRecord('salechannel', ["statusedit" => 1], ['sellerProductId' => $sellerProductId]);           
            $step = $this->_params['step'];            
            $maxPurchaseTime = $this->_params['maxPurchaseTime'];
            $maxPurchaseQuantity = $this->_params['maxPurchaseQuantity'];
            $adultOnly = $this->_params['adultOnly'];
            $notice = $this->_params['notice'];
            $usageNotice = $this->_params['usageNotice'];
            $this->_model->updateRecord('sellerproduct',
            [
                'maxPurchaseTime' => "$maxPurchaseTime",
                'maxPurchaseQuantity' => "$maxPurchaseQuantity",
                'adultOnly' => "$adultOnly",
                'additionalInfoPrompt' => "$notice",
                'usageNotice' => "$usageNotice"
            ],
            [ 'where' => "sellerProductId='$sellerProductId'" ]);

            $cancelPolicyId = $this->_params['cancelPolicyId'];
            $cancelType = $this->_params['cancelType'];
            
            $cancelPeriodType = $this->_params['cancelMarkType1'];
            $cancelPeriodType1=$this->_params['cancelPeriodType1'];
            $cancelPeriodType2=$this->_params['cancelPeriodType2'];
            
            $refundOnBusinessDay = 0;
            if (isset($this->_params['refundOnBusinessDay']))
                $refundOnBusinessDay = $this->_params['refundOnBusinessDay'];

            $refundUnusedTicket = 0;
            if (isset($this->_params['refundUnusedTicket']))
                $refundUnusedTicket = $this->_params['refundUnusedTicket'];
            $cancelNotice = $this->_params['cancelNotice'];
            if ($this->_params['UNUSE_REFUND_ALL'] == 1) {
                $cancelMarkType = "UNUSE_REFUND_ALL";
                $cancelType ="AUTO";
            } 
            else 
            {
                if ($this->_params['range'] == 1) {
                    //nếu 1 cho mặc đinh UNUSE_REFUND_ALL_BEFORE_ONE_DAY
                    $cancelMarkType = "UNUSE_REFUND_ALL_BEFORE_ONE_DAY";
                    $cancelPeriodType=$this->_params['cancelMarkType1'];
                    $cancelPeriodType1=$this->_params['cancelPeriodType1'];
                    $cancelPeriodType2=$this->_params['cancelPeriodType2'];
                }
                if ($this->_params['range'] == 2) {
                    $cancelMarkType = $this->_params['cancelMarkType2'];
                }
                if ($this->_params['range'] == 3) {
                    $cancelMarkType = $this->_params['cancelMarkType3'];
                }
            }
            $data=[ 'cancelPolicyId' => "$cancelPolicyId",
                    'notice' => "$cancelNotice",
                    'cancelType' => "$cancelType",
                    'cancelPeriodType' => "$cancelPeriodType",
                    'cancelPeriodType1' => "$cancelPeriodType1",
                    'cancelPeriodType2' => "$cancelPeriodType2",
                    'cancelMarkType' => "$cancelMarkType",
                    'refundOnBusinessDay' => "$refundOnBusinessDay",
                    'refundUnusedTicket' => "$refundUnusedTicket"];
            $result = $this->_model->loadRecords('cancelpolicy', [ 'sellerProductId' => $sellerProductId ]);
            if ($result) {
                $this->_model->updateRecord('cancelpolicy', $data , ['where' => "sellerProductId='$sellerProductId'"]);
            } else {
                $data1=['sellerProductId' => $sellerProductId];
                $data2=array_merge($data1,$data);
                $this->_model->insertRecord('cancelpolicy', $data2);
            }

            if (isset($this->_params['cancelPolicyId' . $cancelPolicyId])) {
                $this->_model->deleteRecord('refundrates', [
                    "cancelPolicyId" => $cancelPolicyId
                ]);
            }
            if ($this->_params['range'] == 2) {
                if (isset($this->_params['cancelPolicyId' . $cancelPolicyId])) {
                    $refundRatesId = $this->_params['cancelPolicyId' . $cancelPolicyId];
                    $conditionDays = $this->_params['conditionDays' . $cancelPolicyId];
                    $conditionTime = $this->_params['conditionTime' . $cancelPolicyId];
                    $refundRate = $this->_params['refundRate' . $cancelPolicyId];
                    for ($i = 0; $i < count($refundRatesId); $i ++) {
                        $cancellable = 0;
                        if (isset($this->_params['cancellable' . $refundRatesId[$i]]))
                            $cancellable = 1;
                        $this->_model->insertRecord('refundrates', [
                            'cancelPolicyId' => $cancelPolicyId,
                            'refundRatesId' => $refundRatesId[$i],
                            'conditionDays' => $conditionDays[$i],
                            'conditionTime' => $conditionTime[$i],
                            'refundRate' => $refundRate[$i],
                            'cancellable' => $cancellable
                        ]);
                    }
                }
            }

            $url = $this->route('editticket'.$step) . "/" . $sellerProductId;
            if($step==3){
            	$this->_view->setData('urlstep', $url);
            }else{
            	Url::header($url);
            }
        }
        	
        	$list_sellerProduct = $this->_model->loadRecords('sellerproduct', [
        			'sellerProductId' => $sellerProductId
        	]);
        	// Kiểm tra $sellerProductId tồn tại
        	if(!$list_sellerProduct){
        		$this->pageError();
        		return  false;
        	}
            $this->_view->setData('sellerProductId', $sellerProductId);
            $this->_view->setData('list_sellerProduct', $list_sellerProduct);
            
            $list_cancelpolicy = $this->_model->loadRecords('cancelpolicy', [
                'sellerProductId' => $sellerProductId
            ]);           
           
            $this->_view->setData('list_cancelpolicy', $list_cancelpolicy);

            $list_refundrates = array();
            foreach ($list_cancelpolicy as $value => $giatri) {
                $result = $list_cancelpolicy = $this->_model->loadRecords('refundrates', [
                    'cancelPolicyId' => $giatri["cancelPolicyId"]
                ]);
                foreach ($result as $value1 => $giatri1) {
                    $list_refundrates[] = array(
                        $giatri1['refundRatesId'],
                        $giatri1['conditionDays'],
                        $giatri1['conditionTime'],
                        $giatri1['refundRate'],
                        $giatri1['cancellable']
                    );
                }
            }

            $this->_view->setData('list_refundrates', $list_refundrates);
            
            $this->_view->render('editticket3');
        
    }

    // Phương thức ajax
    public function addrefundRatesAjax()
    {
        $refundRatesId = microtime(true) * 10000;
        $cancelPolicyId = $this->_params['cancelPolicyId'];

        $str='<div id="tbrefundRates'.$refundRatesId.'" class="contBox" style="padding: 5px">
                	<input name="cancelPolicyId'.$cancelPolicyId.'[]" id="cancelPolicyId'.$refundRatesId.'" type="hidden" value="'.$refundRatesId.'" />사용일 
                	<input type="text" name="conditionDays'.$cancelPolicyId.'[]" id="conditionDays'.$refundRatesId.'" value="1" onkeypress="validate(event)" 
                            style="width: 50px; height: 24px;margin-right: 10px;margin-left: 5px;" placeholder="" />시간
                	<input type="text" name="conditionTime'.$cancelPolicyId.'[]" id="conditionTime'.$refundRatesId.'" value="00:00:00" 
                            style="width: 120px; height: 24px;margin-right: 10px;margin-left: 5px;" placeholder="HH:mm:ss" class="conditionTime" maxlength="8" />환분율 
                	<input type="text" name="refundRate'.$cancelPolicyId.'[]" id="refundRate'.$refundRatesId.'" class="v-numeric" class="refundRate" maxlength="3" value="50" 
                            style="width: 50px; height: 24px;margin-right: 10px;margin-left: 5px;" placeholder="70% is 70" /> 
                	<a onclick="delrefundRates('.$refundRatesId.');" class="btn hover small"> X </a>    
               </div>
        ';
        //<input name="cancellable'.$refundRatesId.'" id="cancellable'.$refundRatesId.'" type="checkbox" />
        //<label for="cancellable'.$refundRatesId.'">취소가능 여부</label>
        echo $str;
    }
}
?>