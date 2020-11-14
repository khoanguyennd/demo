<?php 
    class QuestionController extends Controller{
        
        // Phương thức khởi tạo
        public function __construct($params){
            parent::__construct($params);
            $this->isLogin();
            $account = $_SESSION['accountshopping'];
            if($account['temp']==1)
                Url::header($this->route('account')."#tab1");
        }
                
        // Phương thức index
        public function indexAction(){ 
            $account = $_SESSION['accountshopping'];  
            $items= [];
            $list_channel = array();
            $m_channel = array();
            $channel = $this->_model->loadRecords('channels');
            foreach ($channel as $value => $giatri) {
                $list_channel[] = array(
                    $giatri['channel_id'],
                    $giatri['channel_name']
                );
                $m_channel[]= $giatri['channel_id'];
            }
            $this->_view->setData('list_channel', $list_channel);
            $supplier = $this->_model->loadSupplier(Structure::getUserId()); 
            $this->_view->setData('supplierSelect', $supplier);
            
            
            $sqlheader = "SELECT * ";
            $sqlcount ='SELECT COUNT(`question_id`) as record ';
            $sql = " FROM tb_question WHERE ";
            
            if($account['role']==0){
                $sql.= " 1";
            }else{
                $sql.= " 1 ";
            }
            
            if (isset($this->_params['m_search'])) {
                $m_start = $this->_params['datestart'];
                $m_end = $this->_params['dateend'];
                $sql .= ' AND `question_created` BETWEEN "'.strtotime($m_start.' 00:00:00').'" AND "'.strtotime($m_end.' 23:59:59').'" ';
                $m_status = $this->_params['m_status'];
                if($m_status != 0){
                    $sql .= ' AND `question_status`="'.$m_status.'"';
                }
                
                $m_supplier = $this->_params['m_supplier'];
//                 if ($m_supplier != 0)
//                     $sql .= "AND p.supplier=$m_supplier ";
                    
                $m_channel = array();
                if (isset($this->_params['m_channel'])) {
                    $m_channel = $this->_params['m_channel'];
//                     if (count($m_channel) > 0) {
//                         $sql .= "AND ( ";
//                         foreach ($m_channel as $value => $giatri) {
//                             $sql .= "d.channel_id=$giatri OR ";
//                         }
//                         $sql = mb_substr($sql, 0, - 3);
//                         $sql .= " ) ";
//                     }
                }
                
                $m_key = $this->_params['m_key'];
                $m_name = $this->_params['m_name'];
                if ($m_key == 0)
                    $sql .= " AND question_message LIKE '%$m_name%' ";
                if ($m_key == 1)
                    $sql .= " AND productname LIKE '%$m_name%' ";
                if ($m_key == 2)
                    $sql .= " AND optionname LIKE '%$m_name%' ";
                if ($m_key == 3)
                    $sql .= " AND question_name LIKE '%$m_name%' ";
                if ($m_key == 4)
                    $sql .= " AND question_id LIKE '%$m_name%' ";

            } else {
                $date = date("Y-m-d");
                $date = strtotime(date("Y-m-d", strtotime($date)) . "-2 months");
                //$m_start = date("Y-m-d", $date);
                $m_start = date("Y-m-d");
                $m_end = date("Y-m-d");
                $m_supplier = 0;
                $m_status = 0;
                $m_key = 0;
                $m_name = "";
                if($this->_params['method'] == 'unreply'){
                    $sql .= ' AND `question_status`=1 ';
                }
                    
            }
            $this->_view->setData('m_start', $m_start);
            $this->_view->setData('m_end', $m_end);
            $this->_view->setData('m_channel', $m_channel);
            $this->_view->setData('m_status', $m_status);
            $this->_view->setData('m_supplier', $m_supplier);
            $this->_view->setData('m_key', $m_key);
            $this->_view->setData('m_name', $m_name);
            
            $_SESSION['sqlquestion'] = $sql;
        	$count = $this->_model->countQuestion($sqlcount.$sql);
            if($_SESSION['mobile']!=0){
                $pagination = $this->paginationParamsmobi($count['record'], $this->route('question', ['method'=>'anwser']));
            }else{
                $pagination = $this->paginationParams($count['record'], $this->route('question', ['method'=>'anwser']));
            }            
            
            $items = $this->_model->loadQuestions($sqlheader.$sql, $pagination['length'], $pagination['begin']);                   
            $this->_view->setData('length', $pagination['length']);
            $this->_view->setData('pagination', $pagination['pagination']);
            $this->_view->setData('total', $pagination['count']);                    
            // Nhà cung cấp
            $this->_view->setData('question', Helper::createRowQuestion($items, $pagination['length'], $pagination['begin']));
            $this->_view->setData('question_mobi', Helper::createRowQuestionmobi($items, $pagination['length'], $pagination['begin']));
            
            if($_SESSION['mobile']!=0){
                $this->_view->setFileTemplate('web','temple_mobile');
                $this->_view->render('index_mobi');
            }else{
                $this->_view->render('index');
            }
        }
        // Phương thức index
        public function channelAction(){ 
            $account = $_SESSION['accountshopping'];
            $items= [];
            $channelname = $this->_params['channelname'];
            $list_channel = array();
            $m_channel = array();
            $channel = $this->_model->loadRecords('channels');
            foreach ($channel as $value => $giatri) {
                $list_channel[] = array(
                    $giatri['channel_id'],
                    $giatri['channel_name']
                );
                $m_channel[]= $giatri['channel_id'];
            }
            $this->_view->setData('list_channel', $list_channel);
            $supplier = $this->_model->loadSupplier(Structure::getUserId());
            $this->_view->setData('supplierSelect', $supplier);
            
            
            $sqlheader = "SELECT * ";
            $sqlcount ='SELECT COUNT(`question_id`) as record ';
            $sql = " FROM tb_question WHERE ";
            if($channelname!=""){
                $sql.= " `channel_name` LIKE '".$channelname."' ";
            }
            //if($this->_params['method'] == 'unreply'){
                $sql .= ' AND `question_status`=1 ';
            //}
            /*if($account['role']==0){
                $sql.= " 1";
            }else{
                $sql.= " 1 ";
            }*/
            
            //echo $sql; die();
            $_SESSION['sqlquestion'] = $sql;
            $count = $this->_model->countQuestion($sqlcount.$sql);
            if($_SESSION['mobile']!=0){
                $pagination = $this->paginationParamsmobi($count['record'], $this->route('questionchannel', ['channelname'=>'channelname']));
            }else{
                $pagination = $this->paginationParams($count['record'], $this->route('questionchannel', ['channelname'=>'channelname']));
            }         
            
            
            $items = $this->_model->loadQuestions($sqlheader.$sql, $pagination['length'], $pagination['begin']);    
            //echo $sqlheader.$sql; die();
            
            $this->_view->setData('length', $pagination['length']);
            $this->_view->setData('pagination', $pagination['pagination']);
            $this->_view->setData('total', $pagination['count']);                    
            // Nhà cung cấp            
            $this->_view->setData('question', Helper::createRowQuestionChannel($items, $pagination['length'], $pagination['begin']));
            
            $this->_view->setData('namechannel', $channelname);
            
            if($_SESSION['mobile']!=0){
                $this->_view->setFileTemplate('web','temple_mobile');
                $this->_view->render('channels_mobi');
            }else{
                $this->_view->render('index');
            }
        }
        // Phương thức phân trang ajax
        public function paginationAjax()
        {
            $result1 = [ 'flag' => false ];
            // Tham số phân trang
            $length = ($this->_params['length'] ? $this->_params['length'] : DEFAULT_LENGTH);
            $page = ($this->_params['page'] ? $this->_params['page'] : 1);
            $begin = ($page - 1) * $length;
            
            $sqlheader = "SELECT * ";
            $sqlcount ='SELECT COUNT(`question_id`) as record ';
            $sql = $_SESSION['sqlquestion'];
            
            $this->_model->setQuery("SELECT count(*) as count " . $sql);
            $result = $this->_model->readAll();
            $this->_view->setData('count', $result[0]['count']);
            
            $count = $this->_model->countQuestion($sqlcount.$sql);
            $pagination = $this->paginationParams($count['record'], $this->route('question', ['method'=>'anwser']));
            $result1['divpaging'] = $pagination['pagination'];
  
            $items = $this->_model->loadQuestions($sqlheader.$sql, $length, $begin);
            $result1['divquestionbody'] =  Helper::createRowQuestion($items, $length, $begin);
            
            $result1['flag'] = true;
            
            echo json_encode($result1);
            
            
        }
        // Phương thức phân trang ajax
        public function paginationmobiAjax()
        {
            $result1 = [ 'flag' => false ];
            // Tham số phân trang
            $length = ($this->_params['length'] ? $this->_params['length'] : DEFAULT_LENGTH);
            $page = ($this->_params['page'] ? $this->_params['page'] : 1);
            $begin = ($page - 1) * $length;
            
            $sqlheader = "SELECT * ";
            $sqlcount ='SELECT COUNT(`question_id`) as record ';
            $sql = $_SESSION['sqlquestion'];
            
            $this->_model->setQuery("SELECT count(*) as count " . $sql);
            $result = $this->_model->readAll();
            $this->_view->setData('count', $result[0]['count']);
            
            $count = $this->_model->countQuestion($sqlcount.$sql);
            $pagination = $this->paginationParams($count['record'], $this->route('question', ['method'=>'anwser']));
            $result1['divpaging'] = $pagination['pagination'];
  
            $items = $this->_model->loadQuestions($sqlheader.$sql, $length, $begin);
            $result1['divquestionbody'] =  Helper::createRowQuestionmobi($items, $length, $begin);            
            $result1['flag'] = true;            
            echo json_encode($result1);            
            
        }
        // Phương thức hiển thị form trả lời hoặc chỉnh sửa
        public function viewformAjax(){
            $result = ['flag'=>false];
            if(isset($this->_params['qsid']) && is_numeric($this->_params['qsid'])){
                $item = $this->_model->loadQuestion($this->_params['qsid']);
                if($item){                    
                    $result['qsid'] = $item['question_id'];
                    $result['qsproduct'] = $item['dealId'];
                    $result['qsproductlink'] = '#';
                    $result['createdreply'] = $item['reply_created'];
                    $result['qsmessage'] = $item['question_content'];
                    $result['qsreply'] = $item['reply_content'];
                    $result['flag'] = true;
                    
                }
            }
            echo json_encode($result);
        }
        
        // Phương thức thực hiện trả lời hoặc chỉnh sửa câu trả lời
        public function excuteformAjax(){           
            $result = ['flag'=>false, 'createdreply'=>''];
            if(isset($this->_params['qsid']) && isset($this->_params['messagereply'])){                
                $result2 = $this->_model->loadRecord('question', ['question_id' => $this->_params['qsid']]);
                if ($result2) {
                    if($result2['reply_created']!=""){
                        $data = [
                            'reply_content'=> $this->_params['messagereply'],
                            'question_status'=>2
                        ];  
                    }else{
                        $data = [
                            'reply_content'=> $this->_params['messagereply'],
                            'question_status'=>2,
                            'reply_created'=>date("Y-m-d H:i:s"),
                        ];
                    }
                    if($this->_model->updateQuestion($data, ['question_id'=>$this->_params['qsid']]) != false){
                        $result['flag'] = true;
                    }
                }
            }
            echo json_encode($result);
        }
        
        // Phương thức download Excel
        public function downloadExcelAjax()
        {
            $format = Func::config('questionDownloadExcel');
            if($format){
                $sqlheader = "SELECT * ";
                $sql = $_SESSION['sqlquestion'];
                $items = $this->_model->loadQuestions($sqlheader.$sql,10000, 0);
                if($items){
                    $format['export']['titleName'] = $this->_params['titleName'];
                    $format['export']['description'] = $this->_params['description'];
                    $excel = new OfficeExcel();
                    $excel->writeQuestion($format['filename'], $items, $format['columns'], $format['export'],$this->_params['titleName']);
                }
            }
        }
        
    }
?>