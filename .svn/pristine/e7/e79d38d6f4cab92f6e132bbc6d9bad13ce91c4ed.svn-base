<?php 
    class NotificationController extends Controller{
        
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
            $items= [];
            if(isset($this->_params['length']) && isset($this->_params['page'])){
                $count = $this->_model->countNotification();
                $pagination = $this->paginationParams($count['record'], $this->route('notification'));
                if($pagination){
                    $result = $pagination;                    
                    $items = $this->_model->loadNotifications($pagination['length'], $pagination['begin']);
                    $this->_view->setData('length', $pagination['length']);
                    $this->_view->setData('pagination', $pagination['pagination']);
                    $this->_view->setData('total', $pagination['count']);
                }
            }           
            $account = $_SESSION['accountshopping'];
            if($account['role']==0){
                $this->_view->setData('notification', Helper::createRowNotification($items));
            }else{
                $this->_view->setData('notification', Helper::createRowNotification1($items));
            }
            
            $this->_view->render('index');
        }
        
        // Phương thức thêm mới thông báo
        public function notificationAjax(){           
            $result = ['flag'=>false, 'type'=>'add'];
            if(isset($this->_params['title']) && isset($this->_params['content'])){
                if(isset($this->_params['noid']) && $this->_params['noid']){ // chỉnh sửa
                    $nofification = [
                        'notification_title'=>$this->_params['title'],
                        'notification_content'=>$this->_params['content'],
                        'notification_modified'=>time(),
                        'notification_modified_by'=>Session::get ( 'accountshopping' )['ID'],
                    ];
                    if($this->_model->updateNotification($nofification, ['notification_id'=>$this->_params['noid']])){
                        $result['flag'] = true;
                        $result['type'] = 'edit';
                        $result['id'] = $this->_params['noid'];
                        $result['title'] = $this->_params['title'];
                        $result['name'] = $nofification['notification_modified_by'];
                        $result['time'] = date('Y-m-d H:i:s', time());
                    }
                }else{ // thêm mới
                    $nofification = Structure::notification([
                        'notification_title'=>$this->_params['title'],
                        'notification_content'=>$this->_params['content']
                    ]);
                    if(($noid = $this->_model->insertNotification($nofification)) != false){
                        $result['flag'] = true;
                        $nofification['notification_id'] = $noid;
                        $account = $_SESSION['accountshopping'];
                        if($account['role']==0){
                            $result['row'] = Helper::createRowNotification([$nofification]);
                        }else{
                            $result['row'] = Helper::createRowNotification1([$nofification]);
                        }
                       
                    }
                }
            }
            echo json_encode($result);
        }
        
        // Phương thức chỉnh sửa thông báo
        public function editNotificationAjax(){
            $result = ['flag'=>false];
            if(isset($this->_params['noid'])){
                $item = $this->_model->loadRecord('notifications', ['notification_id'=>$this->_params['noid']]);
                if($item){                    
                    $result['flag'] = true;
                    $result['id'] = $item['notification_id'];
                    $result['title'] = $item['notification_title'];
                    $result['content'] = $item['notification_content'];
                }
            }
            echo json_encode($result);
        }
        
        // Phương thức tìm kiếm tiêu đề thông báo
        public function searchAndPaginationAjax(){
            $result = ['flag'=>false];
            if(isset($this->_params['page']) && isset($this->_params['length'])){
                $items = $this->_model->searchQuestion($this->_params);
                $pagination = $this->paginationParams($items['count'], $this->route('notification'));
                if($pagination){
                    $result = $pagination;
                    $account = $_SESSION['accountshopping'];
                    if($account['role']==0){
                        $result['rows'] = Helper::createRowNotification($items['data']);
                    }else{
                        $result['rows'] = Helper::createRowNotification1($items['data']);
                    }
                    
                    $result['flag'] = true;
                }
            }
            echo json_encode($result);
        }
                
    }


?>