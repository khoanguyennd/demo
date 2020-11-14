<?php

class Ticket1Controller extends Controller
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

    // Phương thức addticket
    public function addticketAction()
    {
        if (isset($this->_params['btnSumit']) && $this->_params['btnSumit'] == "addticket") { 
            $aid = "";
            if (isset($_SESSION['accountshopping'])) {
                $mang = $_SESSION['accountshopping'];
                $aid = $mang["ID"];
            }
            $step = $this->_params['step'];
            $sellerProductId = $this->_params['sellerProductId'];
            $cityId = $this->_params['cityId']; 
            $districtId = 0;
            if (isset($this->_params['districtId'])) {
                $districtId = $this->_params['districtId']; 
            }
            $wardId = 0;
            if (isset($this->_params['wardId'])) {
                $wardId = $this->_params['wardId'];
            }
            $name = $this->_params['name'];
            $supplier = $this->_params['supplier'];
            $settlement = $this->_params['settlement'];
            $displayKeyword = $this->_params['displayKeyword'];
            $displayCategoryCode = $this->_params['displayCategoryCode'];
            //$pricebasic = preg_replace('#\D#m', '', $this->_params['pricebasic']);
            //$pricerepresentative = preg_replace('#\D#m', '', $this->_params['pricerepresentative']);
            $type1Id = $this->_params['type1Ids'];
            $type2Id = $this->_params['type2Ids'];
//             $type3Id = $this->_params['type3Id'];
//             $type4Id = 0;
//             if (isset($this->_params['type4Id'])) {
//                 $type4Id = $this->_params['type4Id'];
//             }
            $data = $this->_model->loadRecord('sellerproduct', [ 'sellerProductId' => $sellerProductId ]);
            if (!$data) { // insert

                $this->_model->insertRecord('sellerproduct', [
                    'sellerProductId' => $sellerProductId,
                    'travelTypeId' => $cityId,
                    'productDetailTypeId' => $districtId,
                    'wardId' => $wardId,
                    'idType1' => $type1Id,
                    'idType2' => $type2Id,
                    'name' => $name,
                    'supplier' => "$supplier",
                    'settlement' => "$settlement",
                    'displayKeyword' => $displayKeyword,
                    'displayCategoryCode' => $displayCategoryCode,
                    'creator' => $aid
                ]);
                if (isset($_SESSION['searchtags'])) {
                    $this->_model->deleteRecord('searchtags', [
                        "sellerProductId" => $sellerProductId
                    ]);
                    $list_searchtags = $_SESSION['searchtags'];
                    foreach ($list_searchtags as $key => $value) {
                        $this->_model->insertRecord('searchtags', ['sellerProductId' => $sellerProductId,'searchTags' => $value]);
                    }
                    unset($_SESSION['searchtags']);
                }

                $this->_model->updateRecord('salechannel', ['isDelete' => "1" ], ['where' => "sellerProductId='$sellerProductId'"]);
                // nếu có thì update status=0
                // nếu ko có thì insert status=0
                if (isset($this->_params['channelId'])) {
                    $channelId = $this->_params['channelId'];
                    $channelTypeId = $this->_params['type_id'];
                    $type_rate = $this->_params['type_rate'];
                    for ($i = 0; $i < count($channelId); $i++) {
                        $data = [
                            'sellerProductId' => $sellerProductId,
                            'channelId' => $channelId[$i],
                            'channelTypeId' => $channelTypeId[$i],
                            'type_rate' => $type_rate[$i],
                            'status' => 0
                        ];
                        $item = $this->_model->loadRecord('salechannel', [ 'sellerProductId' => $sellerProductId,'channelTypeId' => $channelTypeId[$i] ]);
                        $oid = 0;
                        if ($item) { // update
                            $data['isDelete']= "0";
                            $oid = $item['id'];
                            $this->_model->updateRecord('salechannel', $data, ['where' => "id='$oid'"]);
                        } else {
                            $this->_model->insertRecord('salechannel', $data);
                            $oid = $this->_model->getLastId();
                        }
                        
                        $data = array();
                        if (isset($this->_params['useStartedAt']))
                            $data['useStartedAt'] = $this->_params['useStartedAt'];
                            if (isset($this->_params['useEndedAt']))
                                $data['useEndedAt'] = $this->_params['useEndedAt'];
                                else
                                    $data['useEndedAt'] = "9999-12-31";
                                    $this->_model->updateRecord('salechannel',$data, ['where' => "id='$oid'"]);
                    }
                }
                
                
                $data=array();
                $data['nolimittime']=0;
                if (isset($this->_params['checknotlimit']))
                    $data['nolimittime']=1;
                if (isset($this->_params['useStartedAt'])) {
                    $useStartedAt = $this->_params['useStartedAt'];
                if(isset($this->_params['useEndedAt']))
                    $useEndedAt= $this->_params['useEndedAt'];
                else
                    $useEndedAt = "9999-12-31";
                    $data['useStartedAt'] = "$useStartedAt 00:00:00";
                    $data['useEndedAt'] = "$useEndedAt 23:59:59";
                }
                if (isset($this->_params['saleStartedAt'])) {
                    $saleStartedAt = $this->_params['saleStartedAt'];
                    $saleEndedAt = $this->_params['saleEndedAt'];
                    $data['saleStartedAt'] = "$saleStartedAt 00:00:00";
                    $data['saleEndedAt'] = "$saleEndedAt 23:59:59";
                }
                $this->_model->updateRecord('sellerproduct', $data, ['where' => "sellerProductId='$sellerProductId'" ]);
                
//                 $email1 = $this->_params['email1'];
//                 $email2 = $this->_params['email2'];
//                 $email3 = $this->_params['email3'];
//                 $this->_model->deleteRecord('emailcheck', [ "sellerProductId" => $sellerProductId ]);
//                 $this->_model->insertRecord('emailcheck', [
//                     'sellerProductId' => $sellerProductId,
//                     'email1' => $email1,
//                     'email2' => $email2,
//                     'email3' => $email3
//                 ]);

                $url = $this->route('editticket' . $step) . "/" . $sellerProductId;
                Url::header($url);
            }
        } else {

            $sellerProductId = microtime(true) * 10000;
            if (isset($this->_params['sellerProductId'])) {
                $sellerProductId = $this->_params['sellerProductId'];
            }
            $this->_view->setData('sellerProductId', $sellerProductId);

            $sql = "SELECT c.channel_id,c.channel_name
                FROM  tb_channels c
                ORDER BY c.channel_id";
            $this->_model->setQuery($sql);
            $list_channel = $this->_model->readAll();
            $this->_view->setData('list_channel', $list_channel);
            
            $sql =' SELECT p.type_code ,p.type_value , p1.type_code as type_code1 ,p1.type_value as type_value1
                    FROM tb_producttypes p INNER JOIN tb_producttypes p1 ON p1.type_parentid=p.type_id
                    WHERE p.type_level=1';        
            $this->_model->setQuery($sql);
            $data = $this->_model->readAll();
            $tbridgetype1=$tbridgetype2=[];
            foreach ($data as $value => $giatri)
            {
                $tbridgetype1[$giatri['type_code']]=$giatri['type_value'];
                $tbridgetype2[$giatri['type_code']][$giatri['type_code1']]=$giatri['type_value1'];
            }
            $this->_view->setData('tbridgetype1', $tbridgetype1);
            $this->_view->setData('tbridgetype2', $tbridgetype2);
            
            $sql = 'SELECT ct.*
                    FROM  tb_channeltypes ct, tb_matchtype mt INNER JOIN (  SELECT p3.type_id, p1.type_code
            																FROM tb_producttypes p1,tb_producttypes p2,tb_producttypes p3 
            																WHERE p2.type_parentid=p1.type_id AND p3.type_parentid=p2.type_id) d ON mt.typeId=d.type_id
                    WHERE mt.channeltypeId=ct.type_id AND d.type_code="'.$data[0]['type_code1'].'"
                    AND ct.channelid='.$list_channel[0]['channel_id'].'
                    GROUP BY ct.type_depth1,ct.type_depth2,ct.type_depth3,ct.type_depth4
                    ORDER BY ct.type_id;';
            $this->_model->setQuery($sql);
            $data = $this->_model->readAll();
            $type_depth=[];
            foreach ($data as $value => $giatri)
            {
                $type_depth[$giatri['type_depth1']][$giatri['type_depth2']][$giatri['type_depth3']][$giatri['type_depth4']]=[$giatri['type_id'],$giatri['type_rate']];
            }
            $this->_view->setData('type_depth', $type_depth);
            
            $_SESSION['PeriodId'] = 0;
            
            $list_city = $this->_model->loadRecords('city');
            $list_district = $this->_model->loadRecords('district', [], true, ['limit' => ['length' => 1000 ] ]);
            $list_ward = $this->_model->loadRecords('ward', [], true, ['limit' => ['length' => 1000]]);
            $this->_view->setData('onloadsearchtags', $this->onloadsearchtagsAjax());
            $this->_view->setData('list_city', $list_city);
            $this->_view->setData('list_district', $list_district);
            $this->_view->setData('list_ward', $list_ward);
            $account = $_SESSION['accountshopping'];
            $list_supplier = $this->_model->loadRecords('user', [
                'idx_parent' => $account['idx']
            ]);
            $this->_view->setData('list_supplier', $list_supplier);
            $this->_view->setData('onloadsalechannel', $this->onloadsalechannelAjax($sellerProductId));
            $this->_view->render('addticket');
        }
    }

    public function editticket1Action()
    {
        $sellerProductId = $this->_params['sellerProductId'];
        if (isset($this->_params['btnSumit']) && $this->_params['btnSumit'] == "editticket1") {
            // update statusedit
            //$data = [ 'statusedit' => 1, 'status' => 0 ];
            $this->_model->updateRecord('salechannel', [ "statusedit" => 1 ], [ 'sellerProductId' => $sellerProductId ]);
            $step = $this->_params['step'];
            
            $cityId = $this->_params['cityId'];
            $districtId = 0;
            if (isset($this->_params['districtId'])) {
                $districtId = $this->_params['districtId'];
            }
            $wardId = 0;
            if (isset($this->_params['wardId'])) {
                $wardId = $this->_params['wardId'];
            }

            $name = $this->_params['name'];
            $displayKeyword = $this->_params['displayKeyword'];
            $displayCategoryCode = $this->_params['displayCategoryCode'];
            //$pricebasic = preg_replace('#\D#m', '', $this->_params['pricebasic']);
            //$pricerepresentative = preg_replace('#\D#m', '', $this->_params['pricerepresentative']);
            $type1Id = $this->_params['type1Ids'];
            $type2Id = $this->_params['type2Ids'];
//             $type3Id = $this->_params['type3Id'];
//             $type4Id = "";
//             if (isset($this->_params['type4Id'])) {
//                 $type4Id = $this->_params['type4Id'];
//             }

            
            $settlement = $this->_params['settlement'];
            $data=['sellerProductId' => $sellerProductId,
                'travelTypeId' => $cityId,
                'productDetailTypeId' => $districtId,
                'idType1' => $type1Id,
                'idType2' => $type2Id,
                'wardId' => $wardId,
                'name' => $name,
                'settlement' => "$settlement",
                'displayKeyword' => $displayKeyword,
                'displayCategoryCode' => $displayCategoryCode];
            if(isset($this->_params['supplier'])){
                $data['$supplier'] = $this->_params['supplier'];
            }
            $this->_model->updateRecord('sellerproduct', $data , ['where' => "sellerProductId=$sellerProductId"]);

            if (isset($_SESSION['searchtags'])) {
                $list_searchtags = $_SESSION['searchtags'];
                $this->_model->deleteRecord('searchtags', [
                    "sellerProductId" => $sellerProductId
                ]);
                foreach ($list_searchtags as $key => $value) {
                    $this->_model->insertRecord('searchtags', ['sellerProductId' => $sellerProductId,'searchTags' => $value]);
                }
                unset($_SESSION['searchtags']);
            }

            $this->_model->updateRecord('salechannel', ['isDelete' => "1" ], ['where' => "sellerProductId='$sellerProductId'"]);
                    // nếu có thì update status=0
                    // nếu ko có thì insert status=0
            if (isset($this->_params['channelId'])) {
                $channelId = $this->_params['channelId'];
                $channelTypeId = $this->_params['type_id'];
                $type_rate = $this->_params['type_rate'];
                for ($i = 0; $i < count($channelId); $i++) {
                    $data = [
                        'sellerProductId' => $sellerProductId,
                        'channelId' => $channelId[$i],
                        'channelTypeId' => $channelTypeId[$i],
                        'type_rate' => $type_rate[$i]
                    ];
                    //'status' => 0
                    $item = $this->_model->loadRecord('salechannel', [ 'sellerProductId' => $sellerProductId,'channelTypeId' => $channelTypeId[$i] ]);
                    $oid = 0;
                    if ($item) { // update
                        $data['isDelete']= "0";
                        $oid = $item['id'];
                        $this->_model->updateRecord('salechannel', $data, ['where' => "id='$oid'"]);
                    } else {
                        $this->_model->insertRecord('salechannel', $data);
                        $oid = $this->_model->getLastId();
                    }

                    $data = array();
                    if (isset($this->_params['useStartedAt']))
                        $data['useStartedAt'] = $this->_params['useStartedAt'];
                    if (isset($this->_params['useEndedAt']))
                        $data['useEndedAt'] = $this->_params['useEndedAt'];
                    else
                        $data['useEndedAt'] = "9999-12-31";
                    $this->_model->updateRecord('salechannel',$data, ['where' => "id='$oid'"]);
                }
            }
            
            $data=array();
            
            $data['nolimittime']=0;
            if (isset($this->_params['checknotlimit']))
                $data['nolimittime']=1;
            
            if (isset($this->_params['useStartedAt'])) {
                $useStartedAt = $this->_params['useStartedAt'];
                if(isset($this->_params['useEndedAt']))
                    $useEndedAt= $this->_params['useEndedAt'];
                else
                    $useEndedAt = "9999-12-31";
                $data['useStartedAt'] = "$useStartedAt 00:00:00";
                $data['useEndedAt'] = "$useEndedAt 23:59:59";
            }
            if (isset($this->_params['saleStartedAt'])) {
                $saleStartedAt = $this->_params['saleStartedAt'];
                $saleEndedAt = $this->_params['saleEndedAt'];
                $data['saleStartedAt'] = "$saleStartedAt 00:00:00";
                $data['saleEndedAt'] = "$saleEndedAt 23:59:59";
            }
            $this->_model->updateRecord('sellerproduct', $data, ['where' => "sellerProductId='$sellerProductId'" ]);

            $url = $this->route('editticket' . $step) . "/" . $sellerProductId;
            if ($step == 1) {
                $this->_view->setData('urlstep', $url);
            } else {
                Url::header($url);
            }
        }

        $list_sellerProduct = $this->_model->loadRecords('sellerproduct', [
            'sellerProductId' => $sellerProductId
        ]);
        
        $noedit=0;
        $items = $this->_model->loadRecords('salechannel', [ 'sellerProductId' => $sellerProductId,'isDelete' => 0 ]);
        foreach ($items as $value => $item){
            if($item['status']==3)
                $noedit=1;
        }
        $this->_view->setData('noedit', $noedit);
        
        // Kiểm tra $sellerProductId tồn tại
        if (!$list_sellerProduct) {
            $this->pageError();
            return false;
        }
        $this->_view->setData('sellerProductId', $sellerProductId);
        
        $sql = "SELECT c.channel_id,c.channel_name
                FROM  tb_channels c 
                ORDER BY c.channel_id";
        $this->_model->setQuery($sql);
        $list_channel = $this->_model->readAll();
        $this->_view->setData('list_channel', $list_channel);
        $sql =' SELECT p.type_code ,p.type_value , p1.type_code as type_code1 ,p1.type_value as type_value1
                    FROM tb_producttypes p INNER JOIN tb_producttypes p1 ON p1.type_parentid=p.type_id
                    WHERE p.type_level=1';
        $this->_model->setQuery($sql);
        $data = $this->_model->readAll();
        $tbridgetype1=$tbridgetype2=[];
        foreach ($data as $value => $giatri)
        {
            $tbridgetype1[$giatri['type_code']]=$giatri['type_value'];
            $tbridgetype2[$giatri['type_code']][$giatri['type_code1']]=$giatri['type_value1'];
        }
        $this->_view->setData('tbridgetype1', $tbridgetype1);
        $this->_view->setData('tbridgetype2', $tbridgetype2);
       
        $sql = 'SELECT ct.*
                    FROM  tb_channeltypes ct, tb_matchtype mt INNER JOIN (  SELECT p3.type_id, p1.type_code
            																FROM tb_producttypes p1,tb_producttypes p2,tb_producttypes p3
            																WHERE p2.type_parentid=p1.type_id AND p3.type_parentid=p2.type_id) d ON mt.typeId=d.type_id
                    WHERE mt.channeltypeId=ct.type_id AND d.type_code="'.$list_sellerProduct[0]['idType2'].'"
                    AND ct.channelid='.$list_channel[0]['channel_id'].'
                    GROUP BY ct.type_depth1,ct.type_depth2,ct.type_depth3,ct.type_depth4
                    ORDER BY ct.type_id;';
        $this->_model->setQuery($sql);
        $data = $this->_model->readAll();
        $type_depth=[];
        foreach ($data as $value => $giatri)
        {
            $type_depth[$giatri['type_depth1']][$giatri['type_depth2']][$giatri['type_depth3']][$giatri['type_depth4']]=[$giatri['type_id'],$giatri['type_rate']];
        }
        $this->_view->setData('type_depth', $type_depth);
        $_SESSION['PeriodId'] = 0;
        $list_city = $this->_model->loadRecords('city');
        $list_district = $this->_model->loadRecords('district', [], true, ['limit' => ['length' => 1000]]);
        $list_ward = $this->_model->loadRecords('ward', [], true, ['limit' => [ 'length' => 1000 ]]);
        $this->_view->setData('list_ward', $list_ward);
        $this->_view->setData('list_city', $list_city);
        $this->_view->setData('list_district', $list_district);

        //$this->_view->setData('list_sellerProduct', $list_sellerProduct);

        $list_searchtags = $this->_model->loadRecords('searchtags', [
            'sellerProductId' => $sellerProductId
        ]);
        $list_temp = array();
        $i = 0;
        foreach ($list_searchtags as $value => $giatri) {
            $list_temp[$i] = $giatri['searchTags'];
            $i++;
        }
        $_SESSION['searchtags'] = $list_temp;

        $sql = "SELECT p.* ,
                        DATE_FORMAT(p.saleStartedAt,'%Y-%m-%d') as saleStartedAt1,
                        DATE_FORMAT(p.saleEndedAt,'%Y-%m-%d') as saleEndedAt1,
                        DATE_FORMAT(p.useStartedAt,'%Y-%m-%d') as useStartedAt1,
                        DATE_FORMAT(p.useEndedAt,'%Y-%m-%d') as useEndedAt1
                FROM `tb_sellerproduct` p WHERE p.sellerProductId='$sellerProductId';";

        $this->_model->setQuery($sql);
        $list_sellerProduct = $this->_model->readAll();
        if (!$list_sellerProduct) {
            $this->pageError();
            return false;
        }
        $this->_view->setData('list_sellerProduct', $list_sellerProduct);
        $account = $_SESSION['accountshopping'];
        $list_supplier = $this->_model->loadRecords('user', [
            'idx_parent' => $account['idx']
        ]);
        $this->_view->setData('list_supplier', $list_supplier);
        $this->_view->setData('onloadsearchtags', $this->onloadsearchtagsAjax());
        $this->_view->setData('onloadsalechannel', $this->onloadsalechannelAjax($sellerProductId));
        $this->_view->render('editticket1');
    }


    // Phương thức ajax
    public function addsalechannelAjax()
    {
        $type_depth1 = $this->_params['id_type1'];
        $type_depth2 = $this->_params['id_type2'];
        $type_depth3 = $this->_params['id_type3'];
        $type_depth4 = $this->_params['id_type4'];
        
        $sql = 'SELECT ct.* ,c.channel_name
                FROM tb_channeltypes ct,tb_channels c 
                WHERE ct.channelid=c.channel_id AND ct.type_depth1="'.$type_depth1.'" AND ct.type_depth2="'.$type_depth2.'" AND ct.type_depth3="'.$type_depth3.'" AND ct.type_depth4="'.$type_depth4.'"';
        //echo $sql;
        $this->_model->setQuery($sql);
        $list_channel = $this->_model->readAll();
        $str="";
        foreach ($list_channel as $value => $giatri) {
            if ($giatri['type_id'] == "") {
                $giatri['type_id'] = 0;
                $giatri['type_rate'] = 0;
            }
            $str .= '<div style="padding: 10px;">
                        <input name="channelId[]" type="hidden" value="'. $giatri['channelid'].'" >
                        <input name="type_id[]" type="hidden" value="'. $giatri['type_id'].'" >
                        <input name="type_rate[]" type="hidden" value="'. $giatri['type_rate'].'" >
                        <p style="padding: 5px;display: inline;">-  ' . $giatri['channel_name'] . ' : ';
            if ($giatri['type_id'] != 0) {
                $str4 = "";
                if ($giatri['type_depth4'] != "") {
                    $str4 = ' > ' . $giatri['type_depth4'];
                }
                $str .= $giatri['type_depth1'] . ' > ' . $giatri['type_depth2'] . ' > ' . $giatri['type_depth3'] . $str4 . ' (' . $giatri['type_rate'] . '%)';
            } else {
                $str .= '...';
            }
            $str .= '</p>';
            $str.='<a class="btn hover small delTypeChannel" style="padding: 5px;"> X </a>
            </div>';
        }
        echo $str;
    }
    public function onloadsalechannelAjax($sellerProductId)
    {
        $sql = "SELECT c.channel_id,c.channel_name,ct.channelid,ct.type_id,ct.type_depth1,ct.type_depth2,ct.type_depth3,ct.type_depth4,ct.type_rate  
                FROM tb_channels c ,tb_channeltypes ct , tb_salechannel sc
                WHERE c.channel_id =ct.channelid AND ct.type_id=sc.channelTypeId AND sc.isDelete=0
                			AND sc.sellerProductId=$sellerProductId";
        $this->_model->setQuery($sql);
        $list_channel = $this->_model->readAll();
        $str="";
        foreach ($list_channel as $value => $giatri) {
            if ($giatri['type_id'] == "") {
                $giatri['type_id'] = 0;
                $giatri['type_rate'] = 0;
            }
            $str .= '<div style="padding: 10px;">
                        <input name="channelId[]" type="hidden" value="'. $giatri['channel_id'].'" >     
                        <input name="type_id[]" type="hidden" value="'. $giatri['type_id'].'" >
                        <input name="type_rate[]" type="hidden" value="'. $giatri['type_rate'].'" >     
                        <p style="padding: 5px;display: inline;">-  ' . $giatri['channel_name'] . ' : ';
            if ($giatri['type_id'] != 0) {
                $str4 = "";
                if ($giatri['type_depth4'] != "") {
                    $str4 = ' > ' . $giatri['type_depth4'];
                }
                $str .= $giatri['type_depth1'] . ' > ' . $giatri['type_depth2'] . ' > ' . $giatri['type_depth3'] . $str4 . ' (' . $giatri['type_rate'] . '%)';
            } else {
                $str .= '...';
            }
            $str .= '</p>';
            $str.='<a class="btn hover small delTypeChannel" style="padding: 5px;"> X </a>
                </div>';
        }
        return $str;
    }

    public function onloadsearchtagsAjax()
    {
        $tags = '';
        if (isset($_SESSION['searchtags'])) {
            // $list_searchtags = $_SESSION['searchtags'];
            foreach ($_SESSION['searchtags'] as $key => $value) {
                $tags .= "<span data-tag='" . $value . "'>" . $value . "<a class='delsearchtags btn hover small' data-key='" . $key . "'>X</a></span>";
            }
        }
        return $tags;
    }

    public function addsearchtagsAjax()
    {
        $result = [
            'flag' => false
        ];
        if (isset($this->_params['searchtags'])) {
            $searchtags = explode(",", $this->_params['searchtags']);
            if (isset($_SESSION['searchtags']) && count($_SESSION['searchtags']) < 10) {
                $searchtags = array_merge($_SESSION['searchtags'], $searchtags);
            }
            $searchtags = array_unique($searchtags); // duy nhất
            $searchtags = array_map('trim', $searchtags); // trim
            $searchtags = array_filter($searchtags); // bỏ ""
            if (count($searchtags) > 10) {
                $result['flag'] = false;
            } else {
                $result['flag'] = true;
                $_SESSION['searchtags'] = $searchtags;
            }
        }
        $result['data'] = $this->onloadsearchtagsAjax();
        echo json_encode($result);
    }

    public function delsearchtagsAjax()
    {
        $result = [
            'flag' => false
        ];
        if (isset($this->_params['key']) && isset($_SESSION['searchtags'])) {
            unset($_SESSION['searchtags'][$this->_params['key']]);
        }
        echo json_encode($result);
    }
    public function changeChannelAjax()
    {
        $channel_id = $this->_params['channel_id'];
        $code_depth1 = $this->_params['code_depth1'];
        $code_depth2= $this->_params['code_depth2'];
        $sql = 'SELECT ct.*
                    FROM  tb_channeltypes ct, tb_matchtype mt INNER JOIN (  SELECT p3.type_id, p1.type_code
            																FROM tb_producttypes p1,tb_producttypes p2,tb_producttypes p3
            																WHERE p2.type_parentid=p1.type_id AND p3.type_parentid=p2.type_id) d ON mt.typeId=d.type_id
                    WHERE mt.channeltypeId=ct.type_id AND d.type_code="'.$code_depth2.'"
                    AND ct.channelid='.$channel_id.'
                    GROUP BY ct.type_depth1,ct.type_depth2,ct.type_depth3,ct.type_depth4
                    ORDER BY ct.type_id;';
        
        $this->_model->setQuery($sql);
        $data = $this->_model->readAll();
       
        $type_depth=[];
        foreach ($data as $value => $giatri)
        {
            $type_depth[$giatri['type_depth1']][$giatri['type_depth2']][$giatri['type_depth3']][$giatri['type_depth4']]=[$giatri['type_id'],$giatri['type_rate']];
        }
        $_SESSION['type_depth']=$type_depth;
        $str = '<select class="select small full" class="TextBoxField" onchange="changeType1(this.value)" name="type1Id" id="type1Id">';
        $i = 0;$type_depth1="";
        foreach ($type_depth as $value => $giatri) {
            if ($i == 0)
                $type_depth1 = $value;
            $i++;
            $selected="";
            if( $type_depth1 == $value) $selected='selected="selected"';
            $str .= '<option value="'.$value.'" '.$selected.'>'. $value. '</option>';
        }
        $str .= '</select>';
        $result['otype1']=$str;
        
        $str = '<select class="select small full" class="TextBoxField" onchange="changeType2(this.value)" name="type2Id" id="type2Id">';
        $i = 0;$type_depth2="";
        if(isset($type_depth[$type_depth1]))
            foreach ($type_depth[$type_depth1] as $value => $giatri) {
                if ($i == 0)
                    $type_depth2 = $value;
                $i++;
                $selected="";
                if( $type_depth2 == $value) $selected='selected="selected"';
                $str .= '<option value="'.$value.'" '.$selected.'>'. $value. '</option>';
            }
        $str .= '</select>';
        $result['otype2']=$str;
        
        $str = '<select class="select small full" class="TextBoxField" onchange="changeType3(this.value)" name="type3Id" id="type3Id">';
        $i = 0;$type_depth3="";
        if(isset($type_depth[$type_depth1][$type_depth2]))
            foreach ($type_depth[$type_depth1][$type_depth2]  as $value => $giatri) {
                if ($i == 0)
                    $type_depth3 = $value;
                $i++;
                $selected="";
                if( $type_depth3 == $value) $selected='selected="selected"';
                $str .= '<option value="'.$value.'" '.$selected.'>'. $value. '</option>';
            }
        $str .= '</select>';
        $result['otype3']=$str;
        
        $str = '<select class="select small full" class="TextBoxField" name="type4Id" id="type4Id" onchange="onloadsalechannel()">';
        if(isset($type_depth[$type_depth1][$type_depth2][$type_depth3]))
            if(count($type_depth[$type_depth1][$type_depth2][$type_depth3])>0){
                $i = 0;$type_depth4="";
                foreach ($type_depth[$type_depth1][$type_depth2][$type_depth3]   as $value => $giatri) {
                    if ($i == 0)
                        $type_depth4 = $value;
                        $i++;
                        $selected="";
                        if( $type_depth4 == $value) $selected='selected="selected"';
                        $str .= '<option value="'.$value.'" '.$selected.'>'. $value. '</option>';
                }
        }
        $str .= '</select>';
        $result['otype4']=$str;
        echo json_encode($result);
    }
    public function changeType1Ajax()
    {
        $type_depth = $_SESSION['type_depth'];
        $type_depth1 = $this->_params['id_type1'];
        $str = '<select class="select small full" class="TextBoxField" onchange="changeType2(this.value)" name="type2Id" id="type2Id">';
        $i = 0;$type_depth2="";
        if(isset($type_depth[$type_depth1]))
        foreach ($type_depth[$type_depth1] as $value => $giatri) {
            if ($i == 0)
                $type_depth2 = $value;
            $i++;
            $selected="";
            if( $type_depth2 == $value) $selected='selected="selected"';
            $str .= '<option value="'.$value.'" '.$selected.'>'. $value. '</option>';
        }
        $str .= '</select>';
        $result['otype2']=$str;
        
        $str = '<select class="select small full" class="TextBoxField" onchange="changeType3(this.value)" name="type3Id" id="type3Id">';
        $i = 0;$type_depth3="";
        if(isset($type_depth[$type_depth1][$type_depth2]))
            foreach ($type_depth[$type_depth1][$type_depth2]  as $value => $giatri) {
                if ($i == 0)
                    $type_depth3 = $value;
                    $i++;
                    $selected="";
                    if( $type_depth3 == $value) $selected='selected="selected"';
                    $str .= '<option value="'.$value.'" '.$selected.'>'. $value. '</option>';
            }
        $str .= '</select>';
        $result['otype3']=$str;
        
        $str = '<select class="select small full" class="TextBoxField" name="type4Id" id="type4Id" onchange="onloadsalechannel()">';
        if(isset($type_depth[$type_depth1][$type_depth2][$type_depth3]))
            if(count($type_depth[$type_depth1][$type_depth2][$type_depth3])>0){
                $i = 0;$type_depth4="";
                foreach ($type_depth[$type_depth1][$type_depth2][$type_depth3]   as $value => $giatri) {
                    if ($i == 0)
                        $type_depth4 = $value;
                        $i++;
                        $selected="";
                        if( $type_depth4 == $value) $selected='selected="selected"';
                        $str .= '<option value="'.$value.'" '.$selected.'>'. $value. '</option>';
                }
        }
        $str .= '</select>';
        $result['otype4']=$str;
        echo json_encode($result);
    }

    public function changeType2Ajax()
    {
        $type_depth = $_SESSION['type_depth'];
        $type_depth1 = $this->_params['id_type1'];
        $type_depth2 = $this->_params['id_type2'];
        
        $str = '<select class="select small full" class="TextBoxField" onchange="changeType3(this.value)" name="type3Id" id="type3Id">';
        $i = 0;$type_depth3="";
        if(isset($type_depth[$type_depth1][$type_depth2]))
        foreach ($type_depth[$type_depth1][$type_depth2]  as $value => $giatri) {
            if ($i == 0)
                $type_depth3 = $value;
            $i++;
            $selected="";
            if( $type_depth3 == $value) $selected='selected="selected"';
            $str .= '<option value="'.$value.'" '.$selected.'>'. $value. '</option>';
        }
        $str .= '</select>';
        $result['otype3']=$str;
        
        $str = '<select class="select small full" class="TextBoxField" name="type4Id" id="type4Id" onchange="onloadsalechannel()">';
        if(isset($type_depth[$type_depth1][$type_depth2][$type_depth3]))
            if(count($type_depth[$type_depth1][$type_depth2][$type_depth3])>0){
                $i = 0;$type_depth4="";
                foreach ($type_depth[$type_depth1][$type_depth2][$type_depth3]   as $value => $giatri) {
                    if ($i == 0)
                        $type_depth4 = $value;
                        $i++;
                        $selected="";
                        if( $type_depth4 == $value) $selected='selected="selected"';
                        $str .= '<option value="'.$value.'" '.$selected.'>'. $value. '</option>';
                }
        }
        $str .= '</select>';
        $result['otype4']=$str;
        echo json_encode($result);
    }
    public function changeType3Ajax()
    {
        $type_depth = $_SESSION['type_depth'];
        $type_depth1 = $this->_params['id_type1'];
        $type_depth2 = $this->_params['id_type2'];
        $type_depth3 = $this->_params['id_type3'];
        $str="";
        $str = '<select class="select small full" class="TextBoxField" name="type4Id" id="type4Id" onchange="onloadsalechannel()">';
        if(isset($type_depth[$type_depth1][$type_depth2][$type_depth3]))
            if(count($type_depth[$type_depth1][$type_depth2][$type_depth3])>0){
                $i = 0;$type_depth4="";
                foreach ($type_depth[$type_depth1][$type_depth2][$type_depth3]   as $value => $giatri) {
                    if ($i == 0)
                        $type_depth4 = $value;
                    $i++;
                    $selected="";
                    if( $type_depth4 == $value) $selected='selected="selected"';
                    $str .= '<option value="'.$value.'" '.$selected.'>'. $value. '</option>';
                }
            }
        $str .= '</select>';
        $result['otype4']=$str;
        echo json_encode($result);
    }

    public function changecityAjax()
    {
        $id_city = $this->_params['ocity'];
        $list_city = $_SESSION['list_city'];
        $list_district = $_SESSION['list_district'];
        $str = '<select class="select small full" class="TextBoxField" name="districtId"onchange="changedistrict(this.value)" id="districtId">';
        $i = 0;
        foreach ($list_district as $value => $giatri) {
            if ($giatri["id_city"] == $id_city) {
                if($i==0)  $id_district= $giatri["id"];
                $i++;
                $str .= '<option value="' . $giatri["id"] . '">' . $giatri["name"] . '</option>';
            }
        }
        $str .= '</select>';
        $result['str']=$str;
        
        $list_district = $_SESSION['list_district'];
        $list_ward = $_SESSION['list_ward'];
        $dem = 0;
        foreach ($list_ward as $value => $giatri) {
            if ($giatri["id_district"] == $id_district) {
                $dem++;
            }
        }
        $str="";
        if ($dem > 0) {
            $str = '<select class="select small full" class="TextBoxField" name="wardId" >';
            $i = 0;
            foreach ($list_ward as $value => $giatri) {
                if ($giatri["id_district"] == $id_district) {
                    $i++;
                    $str .= '<option value="' . $giatri["id"] . '">' . $giatri["name"] . '</option>';
                }
            }
            $str .= '</select>';
        }
        $result['str1']=$str;
        
        echo json_encode($result);
    }

    public function changedistrictAjax()
    {
        $id_district = $this->_params['odistrict'];
        $list_district = $_SESSION['list_district'];
        $list_ward = $_SESSION['list_ward'];
        $dem = 0;
        foreach ($list_ward as $value => $giatri) {
            if ($giatri["id_district"] == $id_district) {
                $dem++;
            }
        }
        $str="";
        if ($dem > 0) {
            $str = '<select class="select small full" class="TextBoxField" name="wardId" >';
            $i = 0;
            foreach ($list_ward as $value => $giatri) {
                if ($giatri["id_district"] == $id_district) {
                    $i++;
                    $str .= '<option value="' . $giatri["id"] . '">' . $giatri["name"] . '</option>';
                }
            }
            $str .= '</select>';
        }
        $result['str']=$str;
        echo json_encode($result);
    }


}

?>