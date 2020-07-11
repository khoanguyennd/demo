<?php

class Ticket2Controller extends Controller
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

    public function editticket2Action()
    {    	
    	$sellerProductId = $this->_params['sellerProductId'];    	
    	
        if (isset($this->_params['btnSumit']) && $this->_params['btnSumit'] == "editticket2") {
            
            // update statusedit
            $this->_model->updateRecord('salechannel', ["statusedit" => 1], ['sellerProductId' => $sellerProductId]);
            $step = $this->_params['step'];           
            
            $pricebasic = preg_replace('#\D#m', '', $this->_params['pricebasic']);
            $pricerepresentative = preg_replace('#\D#m', '', $this->_params['pricerepresentative']);
            $inventoryType = $this->_params['inventoryType'];
            $this->_model->updateRecord('sellerproduct', [ 
                                                            'inventoryType' => $inventoryType,
                                                            'pricebasic' => $pricebasic, 
                                                            'pricerepresentative' => $pricerepresentative 
                
            ], [ 'where' => "sellerProductId='$sellerProductId'" ]);
            
            
            $this->_model->updateRecord('travelitems', [ 'isDelete' => "1" ], [ 'where' => "sellerProductId='$sellerProductId'" ]);
            if (isset($this->_params['sellerTravelItemId'])) {
                $sellerTravelItemId = $this->_params['sellerTravelItemId'];
                for ($i = 0; $i < count($sellerTravelItemId); $i ++) {
                    $sellerTravelItemName = $this->_params['name' . $sellerTravelItemId[$i]];
                    $taxType = $this->_params['taxType' . $sellerTravelItemId[$i]];
                    $description = "";
                    $onSale = 1;
                    //if (!isset($this->_params['onSale' . $sellerTravelItemId[$i]]))
                    //    $onSale = 0;
                    $representative = 0;
                    if (isset($this->_params['representative']) && $this->_params['representative'] == $sellerTravelItemId[$i])
                        $representative = 1;
                        // update status or insert
                    $data1 = [
                        'sellerProductId' => $sellerProductId,
                        'sellerTravelItemId' => $sellerTravelItemId[$i],
                        'name' => trim($sellerTravelItemName),
                        'onSale' => $onSale,
                        'description' => $description,
                        'seq' => $i,
                        'taxType' => $taxType,
                        'representative' => $representative
                    ];
                    $data2 = array();
                    $items = $this->_model->loadRecord('travelitems', [
                        'sellerTravelItemId' => $sellerTravelItemId[$i]
                    ]);
                    if ($items) { // update
                        $data2 = [
                            'isDelete' => "0"
                        ];
                        
                        $data = array_merge($data1, $data2);
                        
                        $this->_model->updateRecord('travelitems', $data, [
                            'where' => "sellerTravelItemId='$sellerTravelItemId[$i]'"
                        ]);
                    } else { // insert
                        $data = array_merge($data1, $data2);
                        $this->_model->insertRecord('travelitems', $data);
                    }
                    
                    $usePeriodId = "";
                    $useStartedAt = $this->_params['useStartedAt' . $sellerTravelItemId[$i]];
                    $useEndedAt = $this->_params['useEndedAt' . $sellerTravelItemId[$i]];
                    
                    $this->_model->deleteRecord('useperiod', ["sellerTravelItemId" => $sellerTravelItemId[$i] ]);
                    $this->_model->insertRecord('useperiod', [
                        'sellerTravelItemId' => $sellerTravelItemId[$i],
                        'usePeriodId' => $usePeriodId,
                        'usePeriodName' => $usePeriodId
                    ]);
                    if ($useStartedAt != "") 
                        $this->_model->updateRecord('useperiod', ['useStartedAt' => "$useStartedAt 00:00:00"], ['where' => "sellerTravelItemId='$sellerTravelItemId[$i]'"]);
                    if ($useEndedAt != "") 
                        $this->_model->updateRecord('useperiod', [ 'useEndedAt' => "$useEndedAt 23:59:59" ], [ 'where' => "sellerTravelItemId='$sellerTravelItemId[$i]'" ]);
                    
                    
                    $sellerRateId = "";
                    $rateType = $this->_params['rateType' . $sellerTravelItemId[$i]];
                    $priceType = $this->_params['priceType' . $sellerTravelItemId[$i]];
                    $price = preg_replace('#\D#m', '', $this->_params['price' . $sellerTravelItemId[$i]]);
                    $pricesale = preg_replace('#\D#m', '', $this->_params['pricesale' . $sellerTravelItemId[$i]]);
                    $amount = $this->_params['amount' . $sellerTravelItemId[$i]];
                    $saleStartedAt = $this->_params['saleStartedAt' . $sellerTravelItemId[$i]];
                    $saleEndedAt = $this->_params['saleEndedAt' . $sellerTravelItemId[$i]];
                    $maxPurchaseQtyPerPerson = 10;
                    $maxPurchaseQtyPeriod = 10;
                    
                    $this->_model->deleteRecord('rates', [
                        "sellerTravelItemId" => $sellerTravelItemId[$i]
                    ]);
                    $representative = 1;
                    $this->_model->insertRecord('rates', [
                        'sellerTravelItemId' => $sellerTravelItemId[$i],
                        'sellerRateId' => $sellerRateId,
                        'rateType' => $rateType,
                        'priceType' => $priceType,
                        'price' => $price,
                        'pricesale' => $pricesale,
                        'amount' => $amount,
                        'representative' => $representative,
                        'saleStartedAt' => "$saleStartedAt 00:00:00",
                        'saleEndedAt' => "$saleEndedAt 23:59:59",
                        'maxPurchaseQtyPerPerson' => $maxPurchaseQtyPerPerson,
                        'maxPurchaseQtyPeriod' => $maxPurchaseQtyPeriod,
                        'seq' => 1
                    ]);
                    
                    
                    $this->_model->updateRecord('salechannelitem', [ 'isDelete' => "1" ], 
                      [ 'where' => "sellerProductId='$sellerProductId' AND sellerTravelItemId='$sellerTravelItemId[$i]'" ]);
                    $result =$this->_model->loadRecords('salechannel', ['sellerProductId' => $sellerProductId ,'isDelete' => "0" ] );
                    foreach ($result as $value => $giatri) {
                        if($giatri['channelTypeId']!=0){
                            $data1 = [
                                'sellerProductId' => $sellerProductId,
                                'sellerTravelItemId' => $sellerTravelItemId[$i],
                                'fee' => $giatri["type_rate"],
                                'salechannelId' => $giatri["id"]
                            ];
                            
                            $items = $this->_model->loadRecord('salechannelitem', ['salechannelId' => $giatri["id"],'sellerTravelItemId' =>$sellerTravelItemId[$i]]);
                            if ($items) { // update
                                $data1['isDelete'] = "0";
                                $this->_model->updateRecord('salechannelitem', $data1, [
                                    'where' => "salechannelId=".$giatri['id']." AND sellerTravelItemId=".$sellerTravelItemId[$i]
                                ]);
                            } else { // insert
                                $this->_model->insertRecord('salechannelitem', $data1);
                            }
                        }
                    }
                           
                }
            }
            
            $url = $this->route('editticket'.$step) . "/" . $sellerProductId;
            if($step==2){
            	$this->_view->setData('urlstep', $url);
            }else{
            	Url::header($url);
            }    
        }
            
        $this->_view->setData('sellerProductId', $sellerProductId);
        
        $sql = "SELECT p.* ,
                    DATE_FORMAT(p.saleStartedAt,'%Y-%m-%d') as saleStartedAt1,
                    DATE_FORMAT(p.saleEndedAt,'%Y-%m-%d') as saleEndedAt1,
                    DATE_FORMAT(p.useStartedAt,'%Y-%m-%d') as useStartedAt1,
                    DATE_FORMAT(p.useEndedAt,'%Y-%m-%d') as useEndedAt1
                FROM `tb_sellerproduct` p 
                WHERE p.sellerProductId='$sellerProductId';";
        
        $this->_model->setQuery($sql);
        $list_sellerProduct = $this->_model->readAll();
            
    	$this->_view->setData('list_sellerProduct', $list_sellerProduct);
        
        $list_travelitems = $this->_model->loadRecords('travelitems', [
            'sellerProductId' => $sellerProductId,
            'isDelete' => 0
        ]);
        $list_periodrates = array();
        foreach ($list_travelitems as $value => $giatri) {
            
            $list_useperiod = array();
            $list_rates = array();
            
            $sql = "SELECT s.sellerTravelItemId,s.usePeriodId,s.usePeriodName,
				           DATE_FORMAT(s.useStartedAt,'%Y-%m-%d') as useStartedAt,
				           DATE_FORMAT(s.useEndedAt,'%Y-%m-%d') as useEndedAt
			        FROM `tb_useperiod` s 
                    WHERE s.sellerTravelItemId='" . $giatri["sellerTravelItemId"] . "'";
            $this->_model->setQuery($sql);
            $useperiod = $this->_model->readAll();
            // $useperiod chỉ 1 dòng
            foreach ($useperiod as $value1 => $giatri1) {
                $list_useperiod[] = array(
                    $giatri1['usePeriodId'],
                    $giatri1['usePeriodName'],
                    $giatri1['useStartedAt'],
                    $giatri1['useEndedAt']
                );
            }
            $sql = "SELECT s.*,
				DATE_FORMAT(s.saleStartedAt,'%Y-%m-%d') as saleStartedAt1,
				DATE_FORMAT(s.saleEndedAt,'%Y-%m-%d') as saleEndedAt1
				FROM `tb_rates` s WHERE s.sellerTravelItemId='" . $giatri["sellerTravelItemId"] . "'";
            $this->_model->setQuery($sql);
            $rates = $this->_model->readAll();
            // $rates nhiều dòng
            foreach ($rates as $value1 => $giatri1) {
                $list_rates[] = array(
                    $giatri1['sellerRateId'],
                    $giatri1['rateType'],
                    $giatri1['priceType'],
                    $giatri1['price'],
                    $giatri1['pricesale'],
                    $giatri1['amount'],
                    $giatri1['representative'],
                    $giatri1['saleStartedAt1'],
                    $giatri1['saleEndedAt1'],
                    $giatri1['maxPurchaseQtyPerPerson'],
                    $giatri1['maxPurchaseQtyPeriod']
                );
            }
           
            $list_periodrates[$giatri["sellerTravelItemId"]] = array(
                $list_useperiod,
                $list_rates
            );
        }
        
        $this->_view->setData('list_periodrates', $list_periodrates);
        // $this->_view->setData('list_rates', $list_rates);
        $this->_view->setData('list_travelitems', $list_travelitems);
        $this->_view->render('editticket2');        
    }
    // Phương thức ajax
    public function addOption1Ajax()
    {
        $optionId = round(microtime(true) * 10000);
        $result['optionId'] = $optionId;
        $depth = $this->_params['depth'];
        $str = '<tr id="tbOption1' . $optionId . '">
            	<td>
            		<input name="idOption"  type="hidden" value="' . $optionId . '" />
            		<input name="nameOption1" class="input full" type="text" placeholder="' . $this->_view->getItem('language', 'l_addticket26') . '" value=""/>
            	</td>';
        
        $str .= ($depth == 2) ? ('<td><input name="nameOption2" class="input full" type="text" placeholder="' . $this->_view->getItem('language', 'l_addticket27') . '" value="" /></td>') : '';
        $str .= '<td><input name="price" style="width: 100px;" type="text"  value="0" onkeypress="validate(event)" class="v-numericprice"/></td>
            	<td><input name="pricesale" style="width: 100px;" type="text"  value="0" onkeypress="validate(event)" class="v-numericprice"/></td>
            	<td><select name="rateType" id="rateType' . $optionId . '" style="width: 100px;" class="select small" multiple>
            			<option value="ADULT_DAEIN_AND_CHILD_SOIN">대인/소인동일</option>
            			<option value="ADULT">성인</option>
            			<option value="ADULT_DAEIN">대인</option>
            			<option value="UNIVERSITY_STUDENT">대학생</option>
            			<option value="HIGH_SCHOOL_STUDENT">고등학생</option>
            			<option value="MIDDLE_SCHOOL_STUDENT">중학생</option>
            			<option value="SCHOOL_CHILD">초등학생</option>
            			<option value="HIGH_AND_MIDDLE_SCHOOL_STUDENT">중고생</option>
            			<option value="ELEMENTARY_MIDDLE_AND_HIGH_SCHOOL_STUDENT">초중고생</option>
            			<option value="TEENS">청소년</option>
            			<option value="STUDENT">학생</option>
            			<option value="PRESCHOOL_CHILD">미취학아동</option>
            			<option value="CHILD">아동</option>
            			<option value="CHILD_SOIN">소인</option>
            			<option value="TODDLER">유아</option>
            			<option value="INFANT">영아</option>
            	</select></td>
            	<td>
                    <div class="btnupload">
            			<button type="button" class="btn hover small "  onclick="delOption1(' . $optionId . ');" >' . $this->_view->getItem('language', 'l_delete') . '</button>
            	   </div>
            	</td>
            </tr>
		'; // <option value="BASIC">기본</option>
        $result['data'] = $str;
        echo json_encode($result);
    }
    
    public function addOption2Ajax()
    {
        $optionId = round(microtime(true) * 10000);
        $start = date("Y-m-d");
        $end = date("Y-m-t");
        $result['optionId'] = $optionId;
        $str = '<tr id="tbOption2' . $optionId . '">
            <td>
                <input name="idOption"  type="hidden" value="' . $optionId . '" />
                <input name="rateType"  type="hidden" value="BASIC" />
            	<input name="nameOption" class="input full" type="text" placeholder="' . $this->_view->getItem('language', 'l_addticket26') . '" value=""/>
            </td>
        	<td><input name="saleStartedAt" id="saleStartedAt' . $optionId . '" type="text" value="' . $start . '" style="width: 80px;" readonly="readonly"/> ~
                <input name="saleEndedAt" id="saleEndedAt' . $optionId . '" type="text" value="' . $end . '"  style="width: 80px;" readonly="readonly"/>
            <td><select name="weekendType"  style="min-width: 70px;" class="select small" onchange="changeweekendType(this,' . $optionId . ')">
            			<option value="0">가격동일</option>
                        <option value="1">가격다름</option>
                </select>
            </td>
        	<td><input name="price" type="text" value="0" onkeypress="validate(event)" class="v-numericprice" style="width: 70px;"/></td>
        	<td><input name="pricesale" type="text" value="0" onkeypress="validate(event)" class="v-numericprice" style="width: 70px;"/></td>
            <td id="tdpriceweekend' . $optionId . '">주중가격표기</td>
            <td id="tdpricesaleweekend' . $optionId . '">주중가격표기</td>
            <td><input name="amount" type="text" value="0" onkeypress="validate(event)"  style="width: 40px;"/></td>
        	<td>
                <div class="btnupload">
            			<button type="button" class="btn hover small "  onclick="delOption2(' . $optionId . ');" >' . $this->_view->getItem('language', 'l_delete') . '</button>
            	</div>
        	</td>
        </tr>';
        $result['data'] = $str;
        echo json_encode($result);
    }
    
    public function addTravelItem1Ajax()
    {
        $result = [
            'flag' => false,
            'data' => ''
        ];
        if (isset($this->_params['formdata'])) {
            $formdata = $this->_params['formdata'];
            $sellerTravelItemId = microtime(true) * 10000;
            foreach ($formdata as $value => $giatri) {
                
                foreach ($giatri['rateType'] as $value1 => $giatri1) {
                    $sellerTravelItemId ++;
                    $nameOption = $giatri['nameOption'];
                    $price = $giatri['price'];
                    $pricesale = $giatri['pricesale'];
                    $rateType = $giatri1;
                    $useStartedAt= $giatri['useStartedAt'];
                    $useEndedAt= $giatri['useEndedAt'];
                    $saleStartedAt= $giatri['saleStartedAt'];
                    $saleEndedAt= $giatri['saleEndedAt'];
                    
                    $start = date("Y-m-01");
                    $end = date("Y-m-t");
                    
                    // <input type="hidden" name="rateType'.$sellerTravelItemId.'" value="'.$rateType.'" />
                    ;
                    $result['data'] .= '<tr id="tbTravelItem' . $sellerTravelItemId . '">
                	<td><input type="checkbox" name="checkbox[]" value="' . $sellerTravelItemId . '" /></td>
                	<td><input type="radio" name="representative" onclick="handleClick(this)" value="' . $sellerTravelItemId . '" /></td>
                	<td>' . $sellerTravelItemId . ' <input type="hidden" name="sellerTravelItemId[]" value="' . $sellerTravelItemId . '" />
                        <input type="hidden" name="taxType' . $sellerTravelItemId . '" value="FREE" />
                    </td>
                	<td>
                        <textarea name="name' . $sellerTravelItemId . '" rows="3" style="resize: none">'.$nameOption.'</textarea>
                        <input type="hidden" name="priceType' . $sellerTravelItemId . '" value="OWN_COMPANY_PRICE" />
                    </td>
                    <td>
                        <select name="rateType' . $sellerTravelItemId . '" style="min-width: 75px;width: 75px;padding: 3px 0px 5px 0px;" class="select">
                            <option ' . (($rateType == "BASIC") ? 'selected="selected"' : '') . ' value="BASIC">해당없음</option>
                			<option ' . (($rateType == "ADULT_DAEIN_AND_CHILD_SOIN") ? 'selected="selected"' : '') . ' value="ADULT_DAEIN_AND_CHILD_SOIN">대인/소인동일</option>
                			<option ' . (($rateType == "ADULT") ? 'selected="selected"' : '') . ' value="ADULT">성인</option>
                			<option ' . (($rateType == "ADULT_DAEIN") ? 'selected="selected"' : '') . ' value="ADULT_DAEIN">대인</option>
                			<option ' . (($rateType == "UNIVERSITY_STUDENT") ? 'selected="selected"' : '') . ' value="UNIVERSITY_STUDENT">대학생</option>
                			<option ' . (($rateType == "HIGH_SCHOOL_STUDENT") ? 'selected="selected"' : '') . ' value="HIGH_SCHOOL_STUDENT">고등학생</option>
                			<option ' . (($rateType == "MIDDLE_SCHOOL_STUDENT") ? 'selected="selected"' : '') . ' value="MIDDLE_SCHOOL_STUDENT">중학생</option>
                			<option ' . (($rateType == "SCHOOL_CHILD") ? 'selected="selected"' : '') . ' value="SCHOOL_CHILD">초등학생</option>
                			<option ' . (($rateType == "HIGH_AND_MIDDLE_SCHOOL_STUDENT") ? 'selected="selected"' : '') . ' value="HIGH_AND_MIDDLE_SCHOOL_STUDENT">중고생</option>
                			<option ' . (($rateType == "ELEMENTARY_MIDDLE_AND_HIGH_SCHOOL_STUDENT") ? 'selected="selected"' : '') . ' value="ELEMENTARY_MIDDLE_AND_HIGH_SCHOOL_STUDENT">초중고생</option>
                			<option ' . (($rateType == "TEENS") ? 'selected="selected"' : '') . ' value="TEENS">청소년</option>
                			<option ' . (($rateType == "STUDENT") ? 'selected="selected"' : '') . ' value="STUDENT">학생</option>
                			<option ' . (($rateType == "PRESCHOOL_CHILD") ? 'selected="selected"' : '') . ' value="PRESCHOOL_CHILD">미취학아동</option>
                			<option ' . (($rateType == "CHILD") ? 'selected="selected"' : '') . ' value="CHILD">아동</option>
                			<option ' . (($rateType == "CHILD_SOIN") ? 'selected="selected"' : '') . ' value="CHILD_SOIN">소인</option>
                			<option ' . (($rateType == "TODDLER") ? 'selected="selected"' : '') . ' value="TODDLER">유아</option>
                			<option ' . (($rateType == "INFANT") ? 'selected="selected"' : '') . ' value="INFANT">영아</option>
            	       </select>
                    </td>
                	<td><input type="text" name="price' . $sellerTravelItemId . '" value="' . $price . '" id="price' . $sellerTravelItemId . '" onkeypress="validate(event)" class="price v-numericprice"style="width: 60px;" /></td>
                	<td><input type="text" name="pricesale' . $sellerTravelItemId . '" id="pricesale' . $sellerTravelItemId . '" value="' . $pricesale . '" onkeypress="validate(event)" class="pricesale v-numericprice" style="width: 60px;" /></td>
                	<td><input type="text" name="amount' . $sellerTravelItemId . '" value="0" class="amount v-numericprice" onkeypress="validate(event)" style="width: 40px;" /></td>

                	<td><input type="text" name="useStartedAt' . $sellerTravelItemId . '" id="useStartedAt' . $sellerTravelItemId . '" value="' . $useStartedAt . '" class="useStartedAt" readonly="readonly" style="width: 80px;" /></td>
                	<td><input type="text" name="useEndedAt' . $sellerTravelItemId . '" id="useEndedAt' . $sellerTravelItemId . '" value="' . $useEndedAt . '" class="useEndedAt" readonly="readonly" style="width: 80px;" /></td>
                	<td><input type="text" name="saleStartedAt' . $sellerTravelItemId . '" id="saleStartedAt' . $sellerTravelItemId . '" value="' . $saleStartedAt . '" class="saleStartedAt" readonly="readonly" style="width: 80px;" /></td>
                	<td><input type="text" name="saleEndedAt' . $sellerTravelItemId . '" id="saleEndedAt' . $sellerTravelItemId . '" value="' . $saleEndedAt . '" class="saleEndedAt" readonly="readonly" style="width: 80px;" /></td>
                	<td>' . $this->_view->getItem('language', 'l_addticket25') . '</td>
                </tr>';
                    //<td><a onclick="delTravelItem(' . $sellerTravelItemId . ');" class="btn hover small"> X </a></td>
                }
            }
            $result['flag'] = true;
        }
        echo json_encode($result);
    }
    
    public function addTravelItem2Ajax()
    {
        $result = [
            'flag' => false,
            'data' => ''
        ];
        if (isset($this->_params['formdata'])) {
            $formdata = $this->_params['formdata'];
            $sellerTravelItemId = microtime(true) * 10000;
            $str = '';
            foreach ($formdata as $value => $giatri) {
                $saleStartedAt = $giatri['saleStartedAt'];
                $saleEndedAt = $giatri['saleEndedAt'];
                $inweeks = [];
                $period = new DatePeriod(new DateTime($saleStartedAt), new DateInterval('P1D'), new DateTime($saleEndedAt));
                foreach ($period as $key => $value) {
                    $inweeks[] = array(
                        $value->format('Y-m-d'),
                        $value->format('Y-m-d'),
                        $value->format('N')
                    );
                }
                
                $nameOption = $giatri['nameOption'];
                $price = $giatri['price'];
                $pricesale = $giatri['pricesale'];
                $priceweekend = $giatri['priceweekend'];
                $pricesaleweekend = $giatri['pricesaleweekend'];
                $amount = $giatri['amount'];
                $rateType = $giatri['rateType'];
                foreach ($inweeks as $key => $value) {
                    $sellerTravelItemId ++;
                    $str .= '<tr id="tbTravelItem' . $sellerTravelItemId . '">
                            	<td><input type="checkbox" name="checkbox[]" value="' . $sellerTravelItemId . '" /></td>
                            	<td><input type="radio" name="representative" onclick="handleClick(this)" value="' . $sellerTravelItemId . '" /></td>
                            	<td>' . $sellerTravelItemId . '
                                    <input type="hidden" name="sellerTravelItemId[]" value="' . $sellerTravelItemId . '" /> <input type="hidden" name="taxType' . $sellerTravelItemId . '" value="FREE" /></td>
                            	<td><textarea name="name' . $sellerTravelItemId . '" rows="3"style="resize: none">'.$nameOption.'</textarea>
                                    <input type="hidden" name="priceType' . $sellerTravelItemId . '"value="OWN_COMPANY_PRICE" /></td>
                                <td><select name="rateType' . $sellerTravelItemId . '" style="min-width: 75px;width: 75px;padding: 3px 0px 5px 0px;" class="select">
                                        <option ' . (($rateType == "BASIC") ? 'selected="selected"' : '') . ' value="BASIC">해당없음</option>
                            			<option ' . (($rateType == "ADULT_DAEIN_AND_CHILD_SOIN") ? 'selected="selected"' : '') . ' value="ADULT_DAEIN_AND_CHILD_SOIN">대인/소인동일</option>
                            			<option ' . (($rateType == "ADULT") ? 'selected="selected"' : '') . ' value="ADULT">성인</option>
                            			<option ' . (($rateType == "ADULT_DAEIN") ? 'selected="selected"' : '') . ' value="ADULT_DAEIN">대인</option>
                            			<option ' . (($rateType == "UNIVERSITY_STUDENT") ? 'selected="selected"' : '') . ' value="UNIVERSITY_STUDENT">대학생</option>
                            			<option ' . (($rateType == "HIGH_SCHOOL_STUDENT") ? 'selected="selected"' : '') . ' value="HIGH_SCHOOL_STUDENT">고등학생</option>
                            			<option ' . (($rateType == "MIDDLE_SCHOOL_STUDENT") ? 'selected="selected"' : '') . ' value="MIDDLE_SCHOOL_STUDENT">중학생</option>
                            			<option ' . (($rateType == "SCHOOL_CHILD") ? 'selected="selected"' : '') . ' value="SCHOOL_CHILD">초등학생</option>
                            			<option ' . (($rateType == "HIGH_AND_MIDDLE_SCHOOL_STUDENT") ? 'selected="selected"' : '') . ' value="HIGH_AND_MIDDLE_SCHOOL_STUDENT">중고생</option>
                            			<option ' . (($rateType == "ELEMENTARY_MIDDLE_AND_HIGH_SCHOOL_STUDENT") ? 'selected="selected"' : '') . ' value="ELEMENTARY_MIDDLE_AND_HIGH_SCHOOL_STUDENT">초중고생</option>
                            			<option ' . (($rateType == "TEENS") ? 'selected="selected"' : '') . ' value="TEENS">청소년</option>
                            			<option ' . (($rateType == "STUDENT") ? 'selected="selected"' : '') . ' value="STUDENT">학생</option>
                            			<option ' . (($rateType == "PRESCHOOL_CHILD") ? 'selected="selected"' : '') . ' value="PRESCHOOL_CHILD">미취학아동</option>
                            			<option ' . (($rateType == "CHILD") ? 'selected="selected"' : '') . ' value="CHILD">아동</option>
                            			<option ' . (($rateType == "CHILD_SOIN") ? 'selected="selected"' : '') . ' value="CHILD_SOIN">소인</option>
                            			<option ' . (($rateType == "TODDLER") ? 'selected="selected"' : '') . ' value="TODDLER">유아</option>
                            			<option ' . (($rateType == "INFANT") ? 'selected="selected"' : '') . ' value="INFANT">영아</option>
                        	       </select>
                                </td>
                            	<td><input type="text" name="price' . $sellerTravelItemId . '" value="' . (($value[2] >= 6) ? $priceweekend : $price) . '" id="price' . $sellerTravelItemId . '" onkeypress="validate(event)" class="price v-numericprice" style="width: 60px;" /></td>
                            	<td><input type="text" name="pricesale' . $sellerTravelItemId . '" value="' . (($value[2] >= 6) ? $pricesaleweekend : $pricesale) . '" id="pricesale' . $sellerTravelItemId . '"  onkeypress="validate(event)" class="pricesale v-numericprice" style="width: 60px;" /></td>
                            	<td><input type="text" name="amount'.$sellerTravelItemId.'" value="' . $amount . '" onkeypress="validate(event)" class="amount v-numericprice" style="width: 40px;" /></td>
                            	<td><input type="text" name="useStartedAt' . $sellerTravelItemId . '" id="useStartedAt' . $sellerTravelItemId . '" value="' . $value[0] . '" class="useStartedAt" readonly="readonly" style="width: 80px;" /></td>
                            	<td><input type="text" name="useEndedAt' . $sellerTravelItemId . '" id="useEndedAt' . $sellerTravelItemId . '" value="' . $value[1] . '" class="useEndedAt" readonly="readonly" style="width: 80px;" /></td>
                            	<td><input type="text" name="saleStartedAt' . $sellerTravelItemId . '" id="saleStartedAt' . $sellerTravelItemId . '" value="' . $value[0] . '" class="saleStartedAt" readonly="readonly" style="width: 80px;" /></td>
                            	<td><input type="text" name="saleEndedAt' . $sellerTravelItemId . '" id="saleEndedAt' . $sellerTravelItemId . '" value="' . $value[1] . '" class="saleEndedAt" readonly="readonly" style="width: 80px;" /></td>
                            	    
                            	<td>' . $this->_view->getItem('language', 'l_addticket25') . '</td>
                            	
                          </tr>';
                    //<td><a onclick="delTravelItem(' . $sellerTravelItemId . ');" class="btn hover small"> X </a></td>
                }
            }
            $result['data'] = $str;
            $result['flag'] = true;
        }
        
        echo json_encode($result);
    }
    
    public function addTravelItem3($data)
    {
        $str = '';
        $rateTypes = [
            'BASIC', 'ADULT_DAEIN_AND_CHILD_SOIN', 'ADULT', 'ADULT_DAEIN', 'UNIVERSITY_STUDENT', 'HIGH_SCHOOL_STUDENT',
            'MIDDLE_SCHOOL_STUDENT', 'SCHOOL_CHILD', 'HIGH_AND_MIDDLE_SCHOOL_STUDENT', 'ELEMENTARY_MIDDLE_AND_HIGH_SCHOOL_STUDENT', 'TEENS',
            'STUDENT', 'PRESCHOOL_CHILD', 'CHILD', 'CHILD_SOIN', 'TODDLER', 'INFANT'
        ];
        
        $sellerTravelItemId = microtime(true) * 10000;
        foreach ($data as $key => $value) {
            $rateType = strtoupper($value['key5']);
            if(in_array($value['key5'], $rateTypes)){
                $sellerTravelItemId ++;
                $str .= '<tr id="tbTravelItem' . $sellerTravelItemId . '">
                        	<td><input type="checkbox" name="checkbox[]" value="' . $sellerTravelItemId . '" /></td>
                        	<td><input type="radio" name="representative" onclick="handleClick(this)" value="' . $sellerTravelItemId . '" /></td>
                        	<td>' . $sellerTravelItemId . '
                                <input type="hidden" name="sellerTravelItemId[]" value="' . $sellerTravelItemId . '" /> <input type="hidden" name="taxType' . $sellerTravelItemId . '" value="FREE" /></td>
                        	<td><textarea name="name' . $sellerTravelItemId . '" rows="3"style="resize: none">'.$value['key4'].'</textarea>
                                <input type="hidden" name="priceType' . $sellerTravelItemId . '"value="OWN_COMPANY_PRICE" /></td>
                            <td><select name="rateType' . $sellerTravelItemId . '" style="min-width: 75px;width: 75px;padding: 3px 0px 5px 0px;" class="select">
                                    <option ' . (($rateType == "BASIC") ? 'selected="selected"' : '') . ' value="BASIC">해당없음</option>
                        			<option ' . (($rateType == "ADULT_DAEIN_AND_CHILD_SOIN") ? 'selected="selected"' : '') . ' value="ADULT_DAEIN_AND_CHILD_SOIN">대인/소인동일</option>
                        			<option ' . (($rateType == "ADULT") ? 'selected="selected"' : '') . ' value="ADULT">성인</option>
                        			<option ' . (($rateType == "ADULT_DAEIN") ? 'selected="selected"' : '') . ' value="ADULT_DAEIN">대인</option>
                        			<option ' . (($rateType == "UNIVERSITY_STUDENT") ? 'selected="selected"' : '') . ' value="UNIVERSITY_STUDENT">대학생</option>
                        			<option ' . (($rateType == "HIGH_SCHOOL_STUDENT") ? 'selected="selected"' : '') . ' value="HIGH_SCHOOL_STUDENT">고등학생</option>
                        			<option ' . (($rateType == "MIDDLE_SCHOOL_STUDENT") ? 'selected="selected"' : '') . ' value="MIDDLE_SCHOOL_STUDENT">중학생</option>
                        			<option ' . (($rateType == "SCHOOL_CHILD") ? 'selected="selected"' : '') . ' value="SCHOOL_CHILD">초등학생</option>
                        			<option ' . (($rateType == "HIGH_AND_MIDDLE_SCHOOL_STUDENT") ? 'selected="selected"' : '') . ' value="HIGH_AND_MIDDLE_SCHOOL_STUDENT">중고생</option>
                        			<option ' . (($rateType == "ELEMENTARY_MIDDLE_AND_HIGH_SCHOOL_STUDENT") ? 'selected="selected"' : '') . ' value="ELEMENTARY_MIDDLE_AND_HIGH_SCHOOL_STUDENT">초중고생</option>
                        			<option ' . (($rateType == "TEENS") ? 'selected="selected"' : '') . ' value="TEENS">청소년</option>
                        			<option ' . (($rateType == "STUDENT") ? 'selected="selected"' : '') . ' value="STUDENT">학생</option>
                        			<option ' . (($rateType == "PRESCHOOL_CHILD") ? 'selected="selected"' : '') . ' value="PRESCHOOL_CHILD">미취학아동</option>
                        			<option ' . (($rateType == "CHILD") ? 'selected="selected"' : '') . ' value="CHILD">아동</option>
                        			<option ' . (($rateType == "CHILD_SOIN") ? 'selected="selected"' : '') . ' value="CHILD_SOIN">소인</option>
                        			<option ' . (($rateType == "TODDLER") ? 'selected="selected"' : '') . ' value="TODDLER">유아</option>
                        			<option ' . (($rateType == "INFANT") ? 'selected="selected"' : '') . ' value="INFANT">영아</option>
                    	       </select>
                            </td>
                        	<td><input type="text" name="price' . $sellerTravelItemId . '" value="' . Func::formatPrice($value['key6']) . '" id="price' . $sellerTravelItemId . '" onkeypress="pricesale validate(event)" class="price v-numericprice" style="width: 60px;" /></td>
                        	<td><input type="text" name="pricesale' . $sellerTravelItemId . '" value="' . Func::formatPrice($value['key7']) . '" id="pricesale' . $sellerTravelItemId . '"  onkeypress="validate(event)" class="pricesale v-numericprice" style="width: 60px;" /></td>
                        	<td><input type="text" name="amount'. $sellerTravelItemId .'" value="'. Func::formatPrice($value['key8']).'" onkeypress="validate(event)" class="amount v-numericprice" style="width: 40px;" /></td>
                        	<td><input type="text" name="useStartedAt' . $sellerTravelItemId . '" id="useStartedAt' . $sellerTravelItemId . '" value="' . $this->formatDayFileUpload($value['key9']) . '" class="useStartedAt" readonly="readonly" style="width: 80px;" /></td>
                        	<td><input type="text" name="useEndedAt' . $sellerTravelItemId . '" id="useEndedAt' . $sellerTravelItemId . '" value="' . $this->formatDayFileUpload($value['key10']) . '" class="useEndedAt" readonly="readonly" style="width: 80px;" /></td>
                        	<td><input type="text" name="saleStartedAt' . $sellerTravelItemId . '" id="saleStartedAt' . $sellerTravelItemId . '" value="' . $this->formatDayFileUpload($value['key11']) . '" class="saleStartedAt" readonly="readonly" style="width: 80px;" /></td>
                        	<td><input type="text" name="saleEndedAt' . $sellerTravelItemId . '" id="saleEndedAt' . $sellerTravelItemId . '" value="' . $this->formatDayFileUpload($value['key12']) . '" class="saleEndedAt" readonly="readonly" style="width: 80px;" /></td>
                        	    
                        	<td>' . $this->_view->getItem('language', 'l_addticket25') . '</td>
                        	
                      </tr>';
                //<td><a onclick="delTravelItem(' . $sellerTravelItemId . ');" class="btn hover small"> X </a></td>
            }
        }
        return $str;
    }
    public function formatDayFileUpload($number){
        $unix_date = ($number - 25569) * 86400;
        $number = 25569 + ($unix_date / 86400);
        $unix_date = ($number - 25569) * 86400;
        return gmdate("Y-m-d", $unix_date);
    }
    public function uploadFileExcelAjax(){
        $result = ['flag' => false];
        if(isset($_FILES['fileupload']) && ($_FILES['fileupload']['error'] == 0)){
            $office = new OfficeExcel();
            $columns = [
                [
                    'title'=>'No',
                    'key'=>'key1'
                ],
                [
                    'title'=>'옵션명',
                    'key'=>'key4'
                ],
                [
                    'title'=>'이용자 기준',
                    'key'=>'key5'
                ],
                [
                    'title'=>'정상가',
                    'key'=>'key6'
                ],
                [
                    'title'=>'판매가',
                    'key'=>'key7'
                ],
                [
                    'title'=>'수량',
                    'key'=>'key8'
                ],
                [
                    'title'=>'판매시작일',
                    'key'=>'key9'
                ],
                
                [
                    'title'=>'판매종료일',
                    'key'=>'key10'
                ],
                [
                    'title'=>'유효기간 시작일',
                    'key'=>'key11'
                ],
                [
                    'title'=>'유효기간 종료일',
                    'key'=>'key12'
                ]
            ];
            $dataExcel = $office->read($_FILES['fileupload']['tmp_name'], $columns);
            if($dataExcel['success'] == true){
                $result['flag'] = $dataExcel['success'];
                $result['datafile'] =  $this->addTravelItem3($dataExcel['data']);
            }
        }
        echo json_encode($result);
    }
}
?>