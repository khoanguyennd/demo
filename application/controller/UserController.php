<?php class UserController extends Controller
{
   // Phương thức khởi tạo
    public function __construct($params)
    {
        parent::__construct($params); 
    }
    // Phương thức test
    public function testAction()
    {
        //$this->isLogin(true);
        $date = date('Y-m-d h:i:s', time());
        $data = ['time' => $date];
        $this->_model->insertRecord('test', $data);
    }
    // Phương thức mã hóa password
    public function md5Password($password)
    {
        return md5($password);
        // return md5(md5('*)2^).-+(479&##' . $password . '#8$#@%^457'));
    }
    // Phương thức gửi email
    public function sendCodeToEmail($options, $mode = true)
    {
        if ($options) {
            include (PATH_PLUGINS . "/captcha/simple-php-captcha.php");
            $capcha = captcha();
            if ($capcha) {
                $fields = [
                    'lang' => (Session::get('lang') ? Session::get('lang') : DEFAULT_LANG),
                    'email' => '',
                    'pass' => $capcha['code']
                ];
                $modes = [
                    'code' => 'tbridge_sendcodeconfirm.php',
                    'password' => 'tbridge_sendpassword.php'
                ];
                $url = 'http://175.126.100.209/mail/';
                // Kiểm tra hình thức gửi email qua url
                $url .= (($mode == true) ? $modes['code'] : $modes['password']);
                $options = array_merge($fields, $options);
                //
                $urlParmar = '';
                foreach ($options as $key => $value) {
                    $urlParmar .= $key . '=' . urlencode($value) . '&';
                }
                rtrim($urlParmar, '&');
                // open connection
                $ch = curl_init();
                // set the url, number of POST vars, POST data
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, count($options));
                curl_setopt($ch, CURLOPT_POSTFIELDS, rtrim($urlParmar, '&'));
                // execute post
                $result = curl_exec($ch);
                // close connection
                curl_close($ch);
                return $capcha;
            }
        }
    }

    // Phương thức đăng ký bước 1
    public function signupStep1Action()
    {
        $this->isLogin(true);
        $this->_view->setFileTemplate('login');
        if (Session::get('atax')) {
            $this->_view->setData('atax', explode('-', Session::get('atax')));
        }
        $this->_view->render('signup1');
    }

    // Phương thức đăng ký bước 1
    public function signupStep1Ajax()
    {
        $result = [
            'flag' => false
        ];
        if (isset($this->_params['atax']) && isset($_FILES['fileupload'])) {
            $file = new Upload('fileupload');
            $file->setFileExtension(FILE_EXTENSION);
            $file->setUploadDir(PATH_UPLOAD);
            if (! $file->showError()) {
                // upload
                $result['filename'] = $file->uploadFile(true);
                // kiểm tra mã danh nghiệp tồn tại
                $atax = $this->_params['atax'];
                if ($this->_model->loadRecord('user', [
                    'tax' => $atax
                ]) == false) {
                    $result['flag'] = true;
                    Session::set('atax', $atax);
                    Session::set('imgbusiness', $result['filename']);
//                     $atax= str_replace("-", "", $atax);
//                     $curl = curl_init();
//                     curl_setopt($curl, CURLOPT_URL, 'https://business.api.friday24.com/closedown/'.$atax);
//                     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
//                     curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer 0VWJFYWd3gqzMicMa2ul"));
//                     curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
//                     $data =curl_exec($curl);
//                     curl_close($curl);
//                     $data=json_decode($data, true);
                    
//                     $result['state'] = $data['state'];
//                     if($data['state']=="unregistered"){
//                         $result['flag'] = false;
//                         $result['error'] = "사업자 등록번호를 확인해주세요.";
//                     }else{
//                         $result['state'] = "인증이 성공되었습니다.";
//                     }
                    $result['state'] = "인증이 성공되었습니다.";
                } else {
                    $result['error'] = $this->_view->getItem('language', 'l_exittax');
                }
            } else {
                $result['error'] = $this->convertErrUpload($file->showError());
            }
        }
        echo json_encode($result);
    }
    public function signupCompany1Ajax()
    {
        $result = [
            'flag' => false
        ];

        if (isset($this->_params['atax'])) {
                // kiểm tra mã danh nghiệp tồn tại
            $atax = $this->_params['atax'];
            if ($this->_model->loadRecord('user', [ 'tax' => $atax ]) == false) {
                $result['flag'] = true;
                Session::set('atax', $atax);
//                     $atax= str_replace("-", "", $atax);
//                     $curl = curl_init();
//                     curl_setopt($curl, CURLOPT_URL, 'https://business.api.friday24.com/closedown/'.$atax);
//                     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
//                     curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer 0VWJFYWd3gqzMicMa2ul"));
//                     curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
//                     $data =curl_exec($curl);
//                     curl_close($curl);
//                     $data=json_decode($data, true);
//                     $result['state'] = $data['state'];
//                     if($data['state']=="unregistered"){
//                         $result['state'] = "사업자 등록번호를 확인해주세요.";
//                     }else{
//                         $result['state'] = "인증이완료되었습니다.";
//                     }

                $result['state'] = "인증이완료되었습니다.";
            } else {
                $result['error'] = $this->_view->getItem('language', 'l_exittax'); 
            }
        }
        echo json_encode($result);
    }

    public function signupCompanyAjax()
    {
        $result = [
            'flag' => false
        ];

        if (isset($this->_params['atax'])) {
                // nhập mã danh nghiệp 
            $atax = $this->_params['atax'];
            $result['atax']=$atax;
            if ($atax!='--') { 
                if ($this->_model->loadRecord('user', [ 'tax' => $atax ]) == false) {
                    $result['flag'] = true;
                    Session::set('atax', $atax);                  
                    $result['state'] = "인증이완료되었습니다.";
                } else {
                    $result['error'] = $this->_view->getItem('language', 'l_exittax'); 
                }
                
            }else{
                $result['error'] = $this->_view->getItem('language', 'l_inputtax');
            }
        }
        echo json_encode($result);
    }
    
    // Phương thức gửi mã code tới email
    public function sendCodeAjax()
    {
        $result = ['flag' => false];
        if (isset($this->_params['aemail'])) {
            $aemail = $this->_params['aemail'];
            if (isset($this->_params['acodetax'])) {
                //$acodetax = str_replace('-', '', $this->_params['acodetax']);
                $acodetax = $this->_params['acodetax'];
                $data = $this->_model->loadRecord('user', [
                    'tax' => $acodetax,
                    'email' => $aemail
                ]);
                if ($data) {
                    $capcha = $this->sendCodeToEmail(['email' => $aemail]);
                    if ($capcha) {
                        Session::set('acodetax', $acodetax);
                        Session::set('email', $aemail);
                        Session::set('codeconfirm', $capcha['code']);
                        $result['flag'] = true;
                    }
                }
            }elseif (isset($this->_params['aid'])) {
                $aID = $this->_params['aid'];
                $data = $this->_model->loadRecord('user', [
                    'ID' => $aID,
                    'email' => $aemail
                ]);
                if ($data) {
                    $capcha = $this->sendCodeToEmail(['email' => $aemail]);
                    if ($capcha) {
                        Session::set('aID', $aID);
                        Session::set('email', $aemail);
                        Session::set('codeconfirm', $capcha['code']);
                        $result['flag'] = true;
                    }
                }
            }elseif (isset($this->_params['aperson'])) {
                $capcha = $this->sendCodeToEmail(['email' => $aemail]);
                if (isset($capcha) && isset($capcha['code'])) {
                    $items = [
                        'email' => $aemail,
                        'person' => $this->_params['aperson'],
                        'codeconfirm' => $capcha['code']
                    ];
                    $_SESSION['person'][] = $items;
                    $result['flag'] = true;
                }
            }else {
                $data = $this->_model->loadRecord('user', ['email' => $aemail]);
                $result['sle'] = $data;
                if (! $data) {
                    $capcha = $this->sendCodeToEmail(['email' => $aemail]);
                    if (isset($capcha) && isset($capcha['code'])) {
                        if (isset($this->_params['newid'])) {
                            Session::set('newid', $this->_params['newid']);
                        }
                        Session::set('email', $aemail);
                        Session::set('codeconfirm', $capcha['code']);
                        $result['flag'] = true;
                    }
                }
            }
        }
        echo json_encode($result);
    }

    // Phương thức codeconfirmsignup
    public function checkCodeAjax()
    {
        $result = ['flag' => false];
        if (Session::get('person')) {
            foreach (Session::get('person') as $value) {
                if ($value['codeconfirm'] == $this->_params['accode'] && $value['email'] == $this->_params['aemail']) {
                    $result['flag'] = true;
                    break;
                }
            }
        }else {
            if (isset($this->_params['accode']) && isset($this->_params['aemail'])) {
                if (Session::get('codeconfirm') == $this->_params['accode'] && Session::get('email') == $this->_params['aemail']) {
                    $result['flag'] = true;
                }
            }
        }
        echo json_encode($result);
    }

    // Phương thức đăng ký bước 2
    public function signupStep2Action()
    {
        if (! Session::get('atax')) {
            Url::header($this->route('signupStep1'));
        }
        $listbank = $this->_model->loadRecords('bank'); 
        $this->_view->setData('listbank', $listbank);
        
        $this->_view->setFileTemplate('login');
        $this->_view->render('signup2');
    }

    // Phương thức đăng ký bước 2
    public function signupStep2Ajax()
    {
        $result = ['flag' => false];
        if (Session::get('atax') && isset($this->_params['aid']) && isset($_FILES['fileupload'])) {
            $file = new Upload('fileupload');
            $file->setFileExtension(FILE_EXTENSION);
            $file->setUploadDir(PATH_UPLOAD);
            if (! $file->showError()) {
                // upload
                $result['filename'] = $file->uploadFile(true);
                if (! $file->showError()) {
                    $data = [
                        'ID' => Session::get('newid'),
                        'password' => $this->md5Password($this->_params['apw']),
                        'rperson' => $this->_params['arperson'],
                        'phone' => $this->_params['aphone'],
                        'email' => $this->_params['aemail'],
                        'company' => $this->_params['acompany'],
                        'sperson' => $this->_params['asperson'],
                        'career1' => $this->_params['acareer1'],
                        'career2' => $this->_params['acareer2'],
                        'bank' => $this->_params['abank'],
                        'bankname' => $this->_params['abankname'],
                        'banknumber' => $this->_params['abanknumber'],
                        'tax' => Session::get('atax'),
                        'tax_code' => Session::get('atax'),
                        'imgbank_url' => URL_BASE . "attach/" . URL_UPLOAD . $result['filename'],
                        'imgbank_name' => $result['filename'],
                        'imgbusiness_url' => URL_BASE . "attach/" . URL_UPLOAD . $result['filename'],
                        'imgbusiness_name' => $result['filename']
                    ];
                    if (($usid = $this->_model->insertRecord('user', $data)) != false) {
                        $result['flag'] = $this->_model->insertPerson(Structure::persons([
                            'person_name' => $this->_params['asperson'],
                            'person_phone' => $this->_params['aphone'],
                            'person_email' => $this->_params['aemail'],
                            'userid' => $usid
                        ]));
                        Session::destroy();
                    }
                }
            } else {
                $result['error'] = $this->convertErrUpload($file->showError());
            }
        }
        echo json_encode($result);
    }

    // Phương thức đăng nhập
    public function loginAction()
    {
        $this->isLogin(true);
        //$this->_view->setFileTemplate('login');
        if($_SESSION['mobile']!=0){
            $this->_view->setFileTemplate('login','temple_mobile');
        }else{
            $this->_view->setFileTemplate('login');
        }
        
        if (isset($this->_params['aid'])) {
            $inputs = $this->setInputs([
                'aid',
                'apw',
                'acheck'
            ]);
            if ($inputs['aid'] && $inputs['apw']) {
                $login = $this->_model->loadRecord('user', [
                    'ID' => $inputs['aid'],
                    'password' => $this->md5Password($inputs['apw'])                    
                ]);
                if ($login) {
                    if($login['status'] == 0){
                        $this->setError($this->_view->getItem('language', 'l_accountunactive'));
                    }else{
                        Session::set('lang', $login['lang']);
                        Session::set('accountshopping', [
                            'idx' => $login['idx'],
                            'ID' => $login['ID'],
                            'role' => $login['role'],
                            'area' => $login['area'],
                            'temp' => $login['temp'],
                            'filetmp' => Func::strRandom()
                        ]);
                        if (isset($this->_params['achecked']) && $this->_params['achecked'] == 'on') {
                            $timeout = strtotime("+30 days");
                            setcookie("accountshopping[idx]", $login['idx'], $timeout);
                            setcookie("accountshopping[ID]", $login['ID'], $timeout);
                            setcookie("accountshopping[role]", $login['role'], $timeout);
                            setcookie("accountshopping[area]", $login['area'], $timeout);
                            setcookie("accountshopping[temp]", $login['temp'], $timeout);
                            setcookie("accountshopping[filetmp]", Session::get('accountshopping')['filetmp'], $timeout);
                        }else{
                            $timeout = time() - 3600;
                            //setcookie("accountshopping[idx]", "", $timeout);
                            setcookie("accountshopping[ID]", "", $timeout);
//                             setcookie("accountshopping[role]", "", $timeout);
//                             setcookie("accountshopping[area]", "", $timeout);
//                             setcookie("accountshopping[temp]", "", $timeout);
//                             setcookie("accountshopping[filetmp]", "", $timeout);
                        }
                        $this->isLogin(true);
                    }
                } else {
                    $this->setError($this->_view->getItem('language', 'l_notidpw'));
                }
            }
        }
        $this->_view->setData('error', $this->getError());
        if($_SESSION['mobile']!=0){
            $this->_view->render('login_mobi');
        }else{
            $this->_view->render('login');
        }
    }

    // Phương thức đăng xuất
    public function logoutAction()
    {          
        if (Session::get('accountshopping')) {
            $timeout = time() - 3600;
            Session::delete('accountshopping');
            setcookie("accountshopping[idx]", "", $timeout);
            //setcookie("accountshopping[ID]", "", $timeout);
            setcookie("accountshopping[role]", "", $timeout);
            setcookie("accountshopping[area]", "", $timeout);
            setcookie("accountshopping[temp]", "", $timeout);
            setcookie("accountshopping[filetmp]", "", $timeout);
            Url::header($this->route('login'));
        }
        $this->isLogin();
    }

    // Phương thức finodid
    public function findidAction()
    {
      if($_SESSION['mobile']!=0){
        $this->_view->setFileTemplate('login','temple_mobile');
        $this->_view->render('findid_mobi');
    }else{
        $this->_view->setFileTemplate('login');
        $this->_view->render('findid');
    }
}

    // Phương thức findpw
public function findpwAction()
{
  if($_SESSION['mobile']!=0){
    $this->_view->setFileTemplate('login','temple_mobile');
    $this->_view->render('findpw_mobi');
}else{
    $this->_view->setFileTemplate('login');
    $this->_view->render('findpw');
}        
}
    // Phương thức tìm id
public function findidAjax()
{
    $result = [
        'flag' => false
    ];
    $data = $this->_model->loadRecord('user', [
        'tax' => $this->_params['acodetax'],
        'email' => $this->_params['aemail']
    ]);
    if ($data) {
        Session::destroy();
        $result['flag'] = true;
        $result['id'] = $data['ID'];
    }
    echo json_encode($result);
}

    // Phương thức tìm pw
public function findpwAjax()
{
    $result = [
        'flag' => false
    ];
    if (isset($this->_params['aconfirm']) && isset($this->_params['aid']) && Session::get('aID')) {
        if ($this->_params['aconfirm'] == Session::get('codeconfirm')) {
            $data = $this->_model->loadRecord('user', [
                'ID' => Session::get('aID'),
                'email' => Session::get('email')
            ]);
            if ($data) {
                Session::set('changePW', true);
                $result['flag'] = true;
            }
        }
    }
    echo json_encode($result);
}

    // Phương thức thay đổi password sau khi thực hiền tìm pw
public function changepwAjax()
{
    $result = [
        'flag' => false
    ];
    if (isset($this->_params['password']) && Session::get('changePW') && Session::get('aID')) {
        $data = $this->_model->updateRecord('user', [
            'password' => $this->md5Password($this->_params['password'])
        ], [
            'ID' => Session::get('aID')
        ]);
        if ($data) {
            Session::destroy();
            $result['flag'] = true;
        }
    }
    echo json_encode($result);
}

    // Phương thức account
public function accountAction()
{
    $this->isLogin();
    $account = $_SESSION['accountshopping'];
    if (isset($_POST['tab3submit'])) {
        $data1 = [
            'company' => $this->_params['acompany'],
            'sperson' => $this->_params['asperson'],
            'career1' => $this->_params['acareer1'],
            'career2' => $this->_params['acareer2'],
            'bank' => $this->_params['abank'],
            'bankname' => $this->_params['abankname'],
            'banknumber' => $this->_params['abanknumber']
        ];
        $data2 = array();
        if (isset($_FILES['bankfile']) && $_FILES['bankfile']['name'] != "") {
            $file = new Upload('bankfile');
            $file->setFileExtension(FILE_EXTENSION);
            $file->setUploadDir(PATH_UPLOAD);
            if (! $file->showError()) {
                    // upload
                $filename = $file->uploadFile(true);
                $data2 = [
                    'imgbank_url' => URL_BASE . "attach/" . URL_UPLOAD . $filename,
                    'imgbank_name' => $filename
                ];
            } else {
                $result['error'] = $this->convertErrUpload($file->showError());
            }
        }
        $data = array_merge($data1, $data2);
        $this->_model->updateRecord('user', $data, ['ID' => $account['ID'] ]);
        $parking_fee=0;
        if(isset($this->_params['aparking_fee']))
            $parking_fee=preg_replace('#\D#m','',$this->_params['aparking_fee']);
        
        $data = [
            'userid' => $account['idx'],
            'roadFullAddr' => $this->_params['aroadFullAddr'],
            'jibunAddr' => $this->_params['ajibunAddr'],
            'zipNo' => $this->_params['azipNo'],
            'nation' => "대한민국",
            'city' => $this->_params['asiNm'],
            'district' => $this->_params['asggNm'],
            'timework' => $this->_params['atimework'],
            'dayoff' => $this->_params['adayoff'],
            'phonetable' => $this->_params['aphonetable'],
            'phoneadvisory' => $this->_params['aphoneadvisory'],
            'phonecancel' => $this->_params['aphonecancel'],
            'hotline' => $this->_params['ahotline'],
            'parking' => $this->_params['checkparking'],
            'parking_fee' => $parking_fee,
            'website' => $this->_params['awebsite'], 
            'email' => $this->_params['aemail'],
            'fax' => $this->_params['afax']
        ];
        $userinfo = $this->_model->loadRecord('userinfo', [ 'userid' => $account['idx'] ]);
        if ($userinfo) {
            $this->_model->updateRecord('userinfo', $data, [ 'userid' => $account['idx'] ]);
        } else {
            $this->_model->insertRecord('userinfo', $data);
        }
        $url = $this->route('account' )."#tab3";
        $this->_view->setData('urlstep', $url);

    }
        // Hiển thị form người phụ trách
    $items = $this->_model->loadPersons(Structure::getUserId());
    $element = Helper::createPerson($this->_view->getData('language'), $items);
    $this->_view->setData('personHtml', $element);

    if ($account['role'] != 0) {
        $user = $this->_model->loadRecord('user', [ 'ID' => $account['ID']  ]);
        $this->_view->setData('user', $user);

        $userinfo = $this->_model->loadRecord('userinfo', [ 'userid' => $account['idx'] ]);
        $this->_view->setData('userinfo', $userinfo);

        $listbank= $this->_model->loadRecords('bank');
        $this->_view->setData('listbank', $listbank);

        // Tham số phân trang
        $length = ($this->_params['length'] ? $this->_params['length'] : DEFAULT_LENGTH);
        $page = ($this->_params['page'] ? $this->_params['page'] : 1);
        $begin = ($page - 1) * $length;
        $this->_view->setData('page', $page);
        $this->_view->setData('length', $length);
        if(isset($_SESSION['checknotuse']) && $_SESSION['checknotuse']=="true"){
            $sql=' AND u.idx IN ( SELECT sp.supplier FROM tb_sellerproduct sp WHERE sp.creator="'.$account['ID'].'")';
        }else{
            $sql=' ';
        }
        $account = $_SESSION['accountshopping'];
        $this->_model->setQuery("SELECT count(*) as count FROM tb_user u LEFT JOIN tb_userinfo uf ON u.idx=uf.userid WHERE u.idx_parent=".$account['idx'].$sql);
        $result = $this->_model->readAll();
        $this->_view->setData('count', $result[0]['count']);

        $pagination = $this->paginationParams($result[0]['count'], $this->route('listproduct'));
        $this->_view->setData('pagination', $pagination['pagination']);

        $this->_model->setQuery("SELECT * FROM tb_user u LEFT JOIN tb_userinfo uf ON u.idx=uf.userid WHERE u.idx_parent=". $account['idx'].$sql. " LIMIT " . $begin . "," . $length);
        $userncc = $this->_model->readAll();
        $divsupllier=$this->loadSuplliersAjax($userncc);
        $this->_view->setData('divsupllier', $divsupllier);
    }

    $this->_view->render('account');
}

public function setSessionAjax()
{
    $_SESSION['checknotuse']=$this->_params['checknotuse'];
}
    // Phương thức phân trang ajax
public function paginationlistsuplierAjax()
{
    $result1 = ['flag' => false];
        // Tham số phân trang
    $length = ($this->_params['length'] ? $this->_params['length'] : DEFAULT_LENGTH);
    $page = ($this->_params['page'] ? $this->_params['page'] : 1);
    $begin = ($page - 1) * $length;
    $account = $_SESSION['accountshopping'];

    if(isset($_SESSION['checknotuse']) && $_SESSION['checknotuse']=="true"){
        $sql=' AND u.idx IN ( SELECT sp.supplier FROM tb_sellerproduct sp WHERE sp.creator="'.$account['ID'].'")';
    }else{
        $sql=' ';
    }
    $this->_model->setQuery("SELECT count(*) as count FROM tb_user u LEFT JOIN tb_userinfo uf ON u.idx=uf.userid WHERE u.idx_parent=" . $account['idx'].$sql);
    $result = $this->_model->readAll();
    $this->_view->setData('count', $result[0]['count']);

    $pagination = $this->paginationParams($result[0]['count'], $this->route('listproduct'));
    $result1['pagination'] = $pagination['pagination'];

    $this->_model->setQuery("SELECT * FROM tb_user u LEFT JOIN tb_userinfo uf ON u.idx=uf.userid WHERE u.idx_parent=". $account['idx'].$sql . " LIMIT " . $begin . "," . $length);
    $userncc = $this->_model->readAll();
    $divsupllier=$this->loadSuplliersAjax($userncc);
    $result1['divsupllier'] = $divsupllier;

    $result1['flag'] = true;
    echo json_encode($result1);
}

public function loadSuplliersAjax($userncc)
{
    $str = '';
        //(사용) hoặc k0 sử dụng (미사용)
    foreach ($userncc as $key => $value) {
        $str .= '<tr>
        <td><input type="button" name="download" value="수정" data-cid="12" class="btn hover active dowloadexcel" onclick="showPopupeditSupplier(' . $value['idx'] . ');"></td>
        <td>' . $value['company'] . '</td>
        <td>' . $value['ID'] . '</td>
        <td>사용</td>
        <td>' . $value['rperson'] . '</td>
        <td>' . $value['phone'] . '</td>
        <td>' . $value['sperson'] . '</td>
        <td>' . $value['tax'] . '</td>
        <td>' . $value['career1'] . '/' . $value['career2'] . '</td>
        <td>' . $value['bank'] . '</td>
        <td>' . $value['banknumber'] . '</td>
        <td>' . $value['roadFullAddr'] . '</td>
        <td>' . $value['phonetable'] . '</th>
        </tr>';
    }
    return $str;
}
    // Phương thức account
public function memberAction()
{
    // Kiểm tra đăng nhập
    $this->isLogin();
    $account = $_SESSION['accountshopping'];
    if($account['temp']==1)
        Url::header($this->route('account')."#tab1");

    $items= [];
    $accid=Structure::getUserId();

    $sqlheader="SELECT u1.*,u2.ID as ID_parent";
    $sql = " FROM tb_user u1 LEFT JOIN tb_user u2 ON u1.idx_parent=u2.idx
    WHERE u1.idx!=$accid ";
    $sqlcount="SELECT COUNT(u1.idx) as record";
    if (isset($this->_params['m_search'])) {
        $m_status = $this->_params['m_status'];
        if ($m_status != -1)
            $sql .= " AND u1.status=$m_status ";

        $m_role = $this->_params['m_role'];
        if ($m_role != -1)
            $sql .= " AND u1.role=$m_role ";

        $m_career1 = $this->_params['m_career1'];
        $sql .= " AND u1.career1 LIKE '%$m_career1%' ";
        $m_career2 = $this->_params['m_career2'];
        $sql .= " AND u1.career2 LIKE '%$m_career2%' ";

        $m_key = $this->_params['m_key'];
        $m_name= $this->_params['m_name'];
        if ($m_key == -1)
            $sql .= " AND ( u1.company LIKE '%$m_name%' OR u1.ID LIKE '%$m_name%' OR u1.sperson LIKE '%$m_name%' OR u1.rperson LIKE '%$m_name%' ) ";
        if ($m_key == 1)
            $sql .= " AND u1.company LIKE '%$m_name%' ";
        if ($m_key == 2)
            $sql .= " AND u1.ID LIKE '%$m_name%' ";
        if ($m_key == 3)
            $sql .= " AND u1.sperson LIKE '%$m_name%' ";
        if ($m_key == 4)
            $sql .= " AND u1.rperson LIKE '%$m_name%' ";
    }else{
        $m_status = -1;
        $m_role = -1;
        $m_career1 = "";
        $m_career2 = "";
        $m_key = -1;
        $m_name= "";
    }
    $sql.=" ORDER BY u1.idx DESC ";
    $_SESSION['sqlmember'] = $sql;
    $this->_view->setData('m_status', $m_status);
    $this->_view->setData('m_role', $m_role);
    $this->_view->setData('m_career1', $m_career1);
    $this->_view->setData('m_career2', $m_career2);
    $this->_view->setData('m_key', $m_key);
    $this->_view->setData('m_name', $m_name);
        //echo $sqlheader.$sql;
    if(isset($this->_params['length']) && isset($this->_params['page'])){
        $count = $this->_model->countMember($sqlcount.$sql);
        $pagination = $this->paginationParams($count['record'], $this->route('member'));
        if($pagination){
            $items = $this->_model->loadMember($sqlheader.$sql, $pagination['length'], $pagination['begin']);
            $this->_view->setData('length', $pagination['length']);
            $this->_view->setData('pagination', $pagination['pagination']);
            $this->_view->setData('total', $pagination['count']);
        }
    }        
    $this->_view->setData('memberList', Helper::createRowMember($items));
    $this->_view->render('member');
}
public function adduserAction()
{
    $this->isLogin();
    $account = $_SESSION['accountshopping'];

    if (isset($_POST['frmsubmit'])) {

        $role=$this->_params['role'];
        $data0 = array();
        $data0 = [
            'ID' => $this->_params['aid'],
            'password' => $this->_params['apw'],
            'company' => $this->_params['acompany'],
            'email' => $this->_params['aemail'],
            'role' => $role
        ];
        $data1 = array();
        $data2 = array();
        $data3 = array();
        $data4 = array();

        if($role!=0){

            $data1 = [
                'rperson' => $this->_params['arperson'],
                'phone' => $this->_params['aphone'],
                'sperson' => $this->_params['asperson'],
                'career1' => $this->_params['acareer1'],
                'career2' => $this->_params['acareer2'],
                'tax' => $this->_params['atax1'] . "-" . $this->_params['atax2'] . "-" . $this->_params['atax3'],
                'tax_code' => $this->_params['atax1'] . "-" . $this->_params['atax2'] . "-" . $this->_params['atax3'],
                'tax1' => $this->_params['atax1'],
                'tax2' => $this->_params['atax2'],
                'tax3' => $this->_params['atax3'],
                'bank' => $this->_params['abank'],
                'bankname' => $this->_params['abankname'],
                'banknumber' => $this->_params['abanknumber']
            ];
            
            if ($_POST['role']==2) {
                $data2 = ['idx_parent' => $this->_params['idx_parent']];
            }
            if ($_POST['role']==1) {
                $data2 = ['idx_parent' => 0];
            }
            
            if (isset($_FILES['taxfile']) && $_FILES['taxfile']['name'] != "") {
                $file = new Upload('taxfile');
                $file->setFileExtension(FILE_EXTENSION);
                $file->setUploadDir(PATH_UPLOAD);
                if (! $file->showError()) {
                    // upload
                    $filename = $file->uploadFile(true);
                    $data3 = [
                        'imgbusiness_url' => URL_BASE . "attach/" . URL_UPLOAD . $filename,
                        'imgbusiness_name' => $filename
                    ];
                } else {
                    $result['error'] = $this->convertErrUpload($file->showError());
                }
            }
            
            if (isset($_FILES['bankfile']) && $_FILES['bankfile']['name'] != "") {

                $file = new Upload('bankfile');
                $file->setFileExtension(FILE_EXTENSION);
                $file->setUploadDir(PATH_UPLOAD);
                if (! $file->showError()) {
                    // upload
                    $filename = $file->uploadFile(true);
                    $data4 = [
                        'imgbank_url' => URL_BASE . "attach/" . URL_UPLOAD . $filename,
                        'imgbank_name' => $filename
                    ];
                } else {

                    $result['error'] = $this->convertErrUpload($file->showError());
                }
            }
        }
        $data = array_merge($data0, $data1, $data2, $data3, $data4);
        $this->_model->insertRecord('user', $data);
    }

    $usersell = $this->_model->loadRecords('user', [
        'role' => 1
    ]);
    $this->_view->setData('usersell', $usersell);

    $listbank = $this->_model->loadRecords('bank');
    $this->_view->setData('listbank', $listbank);
    $this->_view->setFileTemplate('popup');
    $this->_view->render('adduser');
}


public function edituserAction()
{
    $this->isLogin();
    $account = $_SESSION['accountshopping'];
    if (isset($_POST['frmsubmit'])) {

        //'company' => $this->_params['acompany'],
        //'email' => $this->_params['aemail'],
        $data0 = array();
        $data0 = [
            'company'   => $this->_params['acompany'],
            'email'     => $this->_params['aemail']
        ];

        $data1 = array();
        if ($_POST['role']==2 || $_POST['role']==1) {
            $data1 = [
                'rperson'       => $this->_params['arperson'],
                'phone'         => $this->_params['aphone'],
                'sperson'       => $this->_params['asperson'],
                'career1'       => $this->_params['acareer1'],
                'career2'       => $this->_params['acareer2'],
                'tax'           => $this->_params['atax1'] . "-" . $this->_params['atax2'] . "-" . $this->_params['atax3'],
                'tax_code'      => $this->_params['atax1'] . "-" . $this->_params['atax2'] . "-" . $this->_params['atax3'],
                'tax1'          => $this->_params['atax1'],
                'tax2'          => $this->_params['atax2'],
                'tax3'          => $this->_params['atax3'],
                'bank'          => $this->_params['abank'],
                'bankname'      => $this->_params['abankname'],
                'banknumber'    => $this->_params['abanknumber']
            ];
        }

        $data2 = array();
        if ($_POST['role']==2) {
            $data2 = ['idx_parent' => $this->_params['idx_parent']];
        }

        $data3 = array();
        if (isset($_FILES['taxfile']) && $_FILES['taxfile']['name'] != "") {
            $file = new Upload('taxfile');
            $file->setFileExtension(FILE_EXTENSION);
            $file->setUploadDir(PATH_UPLOAD);
            if (! $file->showError()) {
                    // upload
                $filename = $file->uploadFile(true);
                $data3 = [
                    'imgbusiness_url' => URL_BASE . "attach/" . URL_UPLOAD . $filename,
                    'imgbusiness_name' => $filename
                ];
            } else {
                $result['error'] = $this->convertErrUpload($file->showError());
            }
        }

        $data4 = array();
        if (isset($_FILES['bankfile']) && $_FILES['bankfile']['name'] != "") {

            $file = new Upload('bankfile');
            $file->setFileExtension(FILE_EXTENSION);
            $file->setUploadDir(PATH_UPLOAD);
            if (! $file->showError()) {
                    // upload
                $filename = $file->uploadFile(true);
                $data4 = [
                    'imgbank_url' => URL_BASE . "attach/" . URL_UPLOAD . $filename,
                    'imgbank_name' => $filename
                ];
            } else {

                $result['error'] = $this->convertErrUpload($file->showError());
            }
        }

        $data = array_merge($data0, $data1, $data2, $data3, $data4);

        $nid = $_POST['idx'];
        $this->_model->updateRecord('user', $data, [
            'idx' => $nid
        ]);
    }

    if ($this->_params['idx']) {
        $idx = $this->_params['idx'];
        $this->_view->setData('idx', $idx);
        $this->_view->setData('act', "edit");
        $usersell = $this->_model->loadRecords('user', [
            'role' => 1
        ]);
        $this->_view->setData('usersell', $usersell);
        $user = $this->_model->loadRecord('user', [
            'idx' => $idx
        ]);
        $this->_view->setData('user', $user);
    } else {
        $this->_view->setData('act', "add");
    }

    $listbank = $this->_model->loadRecords('bank');
    $this->_view->setData('listbank', $listbank);
    $this->_view->setFileTemplate('popup');
    $this->_view->render('edituser');
}

    // Phương thức tìm kiếm member account
public function memberPaginationAjax(){
    $result = ['flag'=>false];   
        // Tham số phân trang
    $length = ($this->_params['length'] ? $this->_params['length'] : DEFAULT_LENGTH);
    $page = ($this->_params['page'] ? $this->_params['page'] : 1);
    $begin = ($page - 1) * $length;
    $sqlheader="SELECT u1.*,u2.ID as ID_parent";
    $sql = $_SESSION['sqlmember'];
    $sqlcount="SELECT COUNT(u1.idx) as record";
        //echo $sqlheader.$sql;
    $count = $this->_model->countMember($sqlcount.$sql);
    $pagination = $this->paginationParams($count['record'], $this->route('member'));
    if($pagination){
        $items = $this->_model->loadMember($sqlheader.$sql, $length, $begin);
        $result = $pagination;
        $result['rows'] = Helper::createRowMember($items);
        $result['flag'] = true;
    }
    echo json_encode($result);
}

    // Phương thức thay đổi trạng thái account
public function changeStatusAjax(){
    $result = ['flag'=>false];
    if(isset($this->_params['arid'])){
        if($this->_model->changeStatus('1', $this->_params['arid']) != false){
                    // send mail
            $result['flag'] = true;
            $result['status'] = $this->_view->language('l_status_6');
        }
    }
    echo json_encode($result);
}

    // Phương thức download danh sách account
public function downloadMemberAjax(){        
    if(isset($this->_params['titleName']) && isset($this->_params['description'])){
        $format = Func::config('memberDownloadExcel');
        if($format){
            $sqlheader="SELECT u1.*,u2.ID as ID_parent";
            $sql = $_SESSION['sqlmember'];
            $items = $this->_model->loadMember($sqlheader.$sql);
               // $items = $this->_model->loadRecords('user');
            if($items){
                $format['export']['titleName'] = $this->_params['titleName'];
                $format['export']['description'] = $this->_params['description'];
                $excel = new OfficeExcel();
                $excel->write($format['filename'], $items, $format['columns'], $format['export']);                    
            }
        }
    }
}
    // Phương thức thay đổi password sau khi thực hiền tìm pw
public function changepwUserAjax()
{
    $result = [
        'flag' => false
    ];
    if (isset($this->_params['email'])) {
        $capcha = $this->sendCodeToEmail(['email' => $this->_params['email']], false);
        $result['capcha'] =  $capcha['code'];
        if ($capcha) {
            $data = $this->_model->updateRecord('user', [
                'password' => $this->md5Password( $capcha['code']),
                'temp' => 1
            ], [
                'ID' => $this->_params['ID']
            ]);
            $result['flag'] = true;
        }
    }
    echo json_encode($result);
}

public function supplierAction()
{
    $this->isLogin();
    $account = $_SESSION['accountshopping'];

    if (isset($_POST['frmsubmit'])) {
        $act = $this->_params['act'];
        $data1 = [
            'ID' => $this->_params['aid'],
            'idx_parent' => $this->_params['idx_parent'],
            'password' => $this->md5Password($this->_params['apw']),
            'rperson' => $this->_params['arperson'],
            'phone' => $this->_params['aphone'],
            'email' => $this->_params['aemail'],
            'company' => $this->_params['acompany'],
            'sperson' => $this->_params['asperson'],
            'career1' => $this->_params['acareer1'],
            'career2' => $this->_params['acareer2'],
            'tax' => $this->_params['atax1'] . "-" . $this->_params['atax2'] . "-" . $this->_params['atax3'],
            'tax_code' => $this->_params['atax1'] . "-" . $this->_params['atax2'] . "-" . $this->_params['atax3'],
            'tax1' => $this->_params['atax1'],
            'tax2' => $this->_params['atax2'],
            'tax3' => $this->_params['atax3'],
            'bank' => $this->_params['abank'],
            'bankname' => $this->_params['abankname'],
            'banknumber' => $this->_params['abanknumber'],
            'role' => 2
        ];

        $data2 = array();
        if (isset($_FILES['taxfile']) && $_FILES['taxfile']['name'] != "") {
            $file = new Upload('taxfile');
            $file->setFileExtension(FILE_EXTENSION);
            $file->setUploadDir(PATH_UPLOAD);
            if (! $file->showError()) {
                    // upload
                $filename = $file->uploadFile(true);
                $data2 = [
                    'imgbusiness_url' => URL_BASE . "attach/" . URL_UPLOAD . $filename,
                    'imgbusiness_name' => $filename
                ];
            } else {
                $result['error'] = $this->convertErrUpload($file->showError());
            }
        }

        $data3 = array();
        if (isset($_FILES['bankfile']) && $_FILES['bankfile']['name'] != "") {

            $file = new Upload('bankfile');
            $file->setFileExtension(FILE_EXTENSION);
            $file->setUploadDir(PATH_UPLOAD);
            if (! $file->showError()) {
                    // upload
                $filename = $file->uploadFile(true);
                $data3 = [
                    'imgbank_url' => URL_BASE . "attach/" . URL_UPLOAD . $filename,
                    'imgbank_name' => $filename
                ];
            } else {

                $result['error'] = $this->convertErrUpload($file->showError());
            }
        }

        $data = array_merge($data1, $data2, $data3);
        if ($act == 'add') {
            $this->_model->insertRecord('user', $data);
            $nid = $this->_model->getLastId();
        } else {
            $nid = $_POST['idx'];
            $this->_model->updateRecord('user', $data, [
                'idx' => $nid
            ]);
        }
        $parking_fee=0;
        if(isset($this->_params['aparking_fee']))
            $parking_fee=preg_replace('#\D#m','',$this->_params['aparking_fee']);
        $data = [
            'userid' => $nid,
            'roadFullAddr' => $this->_params['aroadFullAddr'],
            'jibunAddr' => $this->_params['ajibunAddr'],
            'zipNo' => $this->_params['azipNo'],
            'nation' => "대한민국",
            'city' => $this->_params['asiNm'],
            'district' => $this->_params['asggNm'],
            'timework' => $this->_params['atimework'],
            'dayoff' => $this->_params['adayoff'],
            'phonetable' => $this->_params['aphonetable'],
            'phoneadvisory' => $this->_params['atimework'],
            'phonecancel' => $this->_params['aphonecancel'],
            'hotline' => $this->_params['ahotline'],
            'parking' => $this->_params['checkparking'],
            'parking_fee' => $parking_fee,
            'website' => $this->_params['website'],
            'email' => $this->_params['email'],
            'fax' => $this->_params['fax']
        ];
        if ($act == 'add') {
            $this->_model->insertRecord('userinfo', $data);
        } else {
            $this->_model->updateRecord('userinfo', $data, [
                'userid' => $nid
            ]);
        }
    }

    if ($this->_params['idx']) {
        $idx = $this->_params['idx'];
        $this->_view->setData('idx', $idx);
        $this->_view->setData('act', "edit");
        $user = $this->_model->loadRecord('user', [
            'idx' => $idx
        ]);
        $this->_view->setData('user', $user);
        $userinfo = $this->_model->loadRecord('userinfo', [
            'userid' => $idx
        ]);
        $this->_view->setData('userinfo', $userinfo);
    } else {
        $this->_view->setData('act', "add");
    }
    $listbank = $this->_model->loadRecords('bank');
    $this->_view->setData('listbank', $listbank);
    $this->_view->setFileTemplate('popup');
    $this->_view->render('supplier');
}

    // Phương thức thay đổi password sau khi đăng nhập
public function changepwloginAjax()
{
    $result = [
        'flag' => false
    ];
    if (isset($this->_params['password']) && isset($this->_params['aID'])) {
        if (Session::get('accountshopping')['ID'] == $this->_params['aID']) {
            $data = $this->_model->updateRecord('user', [
                'password' => $this->md5Password($this->_params['password']),
                'temp' => 0
            ], [
                'ID' => $this->_params['aID']
            ]);

            if ($data) {
                $result['flag'] = true;
            }
        }
    }
    echo json_encode($result);
}

    // Phương thức thay đổi hoặc thêm người phụ trách
public function changePersonAjax()
{
    $result = [
        'flag' => false
    ];
    $result['data']=$this->_params['persons'];
    foreach ($this->_params['persons'] as $key => $value) {
        if ($value['action'] == 'editperson' && $value['perid'] > 0) {
                // edit
            $person = [
                'person_name' => $value['aperson'],
                'person_phone' => $value['aphone'],
                'person_email' => $value['aemail']
            ];
            $this->_model->editPerson($person, [ 'person_id' => $value['perid'] ]);
        } else {
                // insert
            $person = Structure::persons([
                'person_name' => $value['aperson'],
                'person_phone' => $value['aphone'],
                'person_email' => $value['aemail']
            ]);
            $this->_model->insertPerson($person);
        }
        $result['flag']=true;
    }
    echo json_encode($result);
}

    // Phương thức xóa thông tin một người phụ trách
public function deletePersonAjax()
{
    $result = [
        'flag' => false
    ];
    if (isset($this->_params['pid']) && isset($this->_params['pemail'])) {
        $result['pid'] = $this->_params['pid'];
        $result['flag'] = $this->_model->deletePerson($this->_params['pid'], $this->_params['pemail']);
    }
    echo json_encode($result);
}

    // Hàm xóa file cache json or file in folder images
public function deleteFileCache($day = 1){
    $handle = opendir(PATH_CACHE);       
    while (($filename = readdir($handle)) != false){          
        if(strlen($filename) > 2){
            $pathfile = PATH_CACHE. $filename;               
            if(file_exists($pathfile)){
                $file = new Files();                    
                if($file->get($pathfile)){
                    $filetime = @filemtime($pathfile);
                    if($filetime){
                        if( (time() - $filetime) / 86400 > $day){
                            $file->delete($pathfile);
                        }
                    }
                }
            }
        }
    }
}
    // Upload Excel nhiều nhà cung cấp
public function Uploadexcel_NCCAjax(){
    $result = ['flag' => false];
    if(isset($_FILES['fileupload']) && ($_FILES['fileupload']['error'] == 0)){
        $office = new OfficeExcel();
        $columns = [
            [
                'title'=>'아이디(필수)', //ID (bắt buộc)
                'key'=>'key1'
            ],
            [
                'title'=>'비밀번호(필수)', //Mật khẩu được yêu cầu
                'key'=>'key2'
            ],
            [
                'title'=>'담당자명(필수)', //Tên người liên hệ (bắt buộc)
                'key'=>'key3'
            ],
            [
                'title'=>'담당자 연락처(필수)', //so dien thoai nguoi liên hệ (bắt buộc)
                'key'=>'key4'
            ],
            [
                'title'=>'담당자 이메일(필수)', //Email liên hệ (bắt buộc)
                'key'=>'key5'
            ],
            [
                'title'=>'회사명(필수)', //Tên công ty (bắt buộc)
                'key'=>'key6'
            ],
            [
                'title'=>'대표자명(필수)', //Tên đại diện (bắt buộc)
                'key'=>'key7'
            ],
            [
                'title'=>'사업자번호(필수)', //ma so dang ky kinh doanh
                'key'=>'key8'
            ],
            [
                'title'=>'업태(필수)', //Điều kiện kinh doanh (bắt buộc)
                'key'=>'key9'
            ],
            [
                'title'=>'업종(필수)', //Công nghiệp (bắt buộc)
                'key'=>'key10'
            ],
            [
                'title'=>'계좌은행(필수)', //Tài khoản ngân hàng (bắt buộc)
                'key'=>'key11'
            ],
            [
                'title'=>'계좌소유주명(필수)', //Chủ tài khoản (Bắt buộc)
                'key'=>'key12'
            ],
            [
                'title'=>'계좌번호(필수)', //Số tài khoản (bắt buộc)
                'key'=>'key13'
            ],
            [
                'title'=>'주소(필수)', //Địa chỉ (bắt buộc)
                'key'=>'key14'
            ],
            [
                'title'=>'대표전화(필수)', //Điện thoại đại diện (bắt buộc)
                'key'=>'key15'
            ],
            [
                'title'=>'휴대전화', //Điện thoại di động
                'key'=>'key16'
            ],
            [
                'title'=>'구매문의전화', //Điện thoại yêu cầu mua hàng
                'key'=>'key17'
            ],
            [
                'title'=>'취소문의전화', //Điện thoại yêu cầu hủy
                'key'=>'key18'
            ],
            [
                'title'=>'주차여부(필수)', //Bãi đậu xe (bắt buộc)
                'key'=>'key19'
            ],
            [
                'title'=>'주차가격', //Giá đỗ xe
                'key'=>'key20'
            ],         
        ];
        $dataExcel = $office->readNCC($_FILES['fileupload']['tmp_name'],$columns);
        if($dataExcel['success'] == true){
            $result['flag'] = $dataExcel['success'];
            $result['data'] =  $this->addSupplierInfo($dataExcel['data']);  
        }
    }
    echo json_encode($result);
}

// Them nhieu nha cung cap vao Database va hien thi ket qua ra view
public function addSupplierInfo($data)
{   
   $str = ''; 
    foreach ($data as $key => $value) {
        $tax=$value['key8'];
        $pieces = explode("-", $tax);    

        $data1 = [
            'ID' => $value['key1'],
            'idx_parent' => $_SESSION['accountshopping']['idx'],
            'password' => $this->md5Password($value['key2']),
            'rperson' => $value['key3'],
            'phone' => $value['key4'],
            'email' => $value['key5'],
            'company' => $value['key6'],
            'sperson' => $value['key7'],
            'tax' => $tax,
            'tax_code' => $tax,
            'tax1' => $pieces[0],
            'tax2' => $pieces[1],
            'tax3' => $pieces[2],
            'career1' => $value['key9'],
            'career2' => $value['key10'],
            'bank' => $value['key11'],
            'bankname' => $value['key12'],
            'banknumber' => $value['key13'],
            'role' => 2
        ];
        $this->_model->insertRecord('user', $data1);
        $nid = $this->_model->getLastId();
        $parking_fee=0;
        if(isset($value['aparking_fee']))
            $parking_fee=preg_replace('#\D#m','',$value['aparking_fee']);
        $data2 = [
            'userid' => $nid,
            'roadFullAddr' => $value['key14'],
            'phonetable' => $value['key15'],
            'hotline' => $value['key16'],
            'phoneadvisory' => $value['key17'],
            'phonecancel' => $value['key18'],
            'parking' => $value['key19'],
            'parking_fee' => $value['key20']
        ];
        $this->_model->insertRecord('userinfo', $data2);
        $str .= '
            <tr>
            <td><input type="button" name="download" value="수정" data-cid="'.$nid.'." class="btn hover active dowloadexcel" onclick="showPopupeditSupplier('.$nid.');"></td>
            <td>'.$value['key6'].'</td> 
            <td>'.$value['key1'].'</td> 
            <td>'.$value['key5'].'</td> 
            <td>'.$value['key3'].'</td> 
            <td>'.$value['key4'].'</td> 
            <td>'.$value['key7'].'</td> 
            <td>'.$value['key8'].'</td> 
            <td>'.$value['key9'].'</td> 
            <td>'.$value['key11'].'</td> 
            <td>'.$value['key13'].'</td> 
            <td>'.$value['key14'].'</td> 
            <td>'.$value['key15'].'</td>
            </tr>'; 
        }
   return $str;
    }
}
?>