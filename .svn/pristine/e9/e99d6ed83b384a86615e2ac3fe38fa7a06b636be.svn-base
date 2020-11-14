<?php

class ThanhvienController extends Controller {

    // Phương thức khởi tạo
    public function __construct($params) {
        //$this->isLogin();
        parent::__construct($params);
    }

    // Phương thức index
    public function indexAction() {
        $this->_view->render('index');        
    }

    // Phương thức phân trang ajax
    public function paginationAjax() {
        $result1 = ['flag' => false];
        // Tham số phân trang
        $length = ($this->_params['length'] ? $this->_params['length'] : DEFAULT_LENGTH);
        $page = ($this->_params['page'] ? $this->_params['page'] : 1);
        $begin = ($page - 1) * $length;

        $sqlheader = "SELECT q.*,d.*";
        $sqlcount = 'SELECT COUNT(q.`question_id`) as record ';
        $sql = $_SESSION['sqlquestion'];

        $this->_model->setQuery("SELECT count(*) as count " . $sql);
        $result = $this->_model->readAll();
        $this->_view->setData('count', $result[0]['count']);

        $count = $this->_model->countQuestion($sqlcount . $sql);
        $pagination = $this->paginationParams($count['record'], $this->route('question', ['method' => 'anwser']));
        $result1['divpaging'] = $pagination['pagination'];

        $items = $this->_model->loadQuestions($sqlheader . $sql, $length, $begin);

        $result1['divquestionbody'] = Helper::createRowQuestion($items, $length, $begin);
        $result1['flag'] = true;

        echo json_encode($result1);
    }


}

?>