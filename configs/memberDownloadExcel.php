<?php
return [
    'columns' => [
        [
            'title' => 'No',
            'key' => 'stt',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'            
        ],
        [
            'title' => '상태',
            'key' => 'status',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
            
        ],
        [
            'title' => '아이디',
            'key' => 'ID',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'            
        ],
        [
            'title' => '권한',
            'key' => 'role',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
            
        ],
        [
            'title' => '총판사명',
            'key' => 'ID',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'            
        ],
        [
            'title' => '대표자명',
            'key' => 'sperson',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'            
        ],
        [
            'title' => '회사명',
            'key' => 'company',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'            
        ],
        [
            'title' => '사업자번호',
            'key' => 'tax',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'            
        ],
        [
            'title' => '업태',
            'key' => 'career1',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'            
        ],
        [
            'title' => '업종',
            'key' => 'career2',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'            
        ],
        [
            'title' => '정보관리',
            'key' => 'idx',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'            
        ],
        [
            'title' => '담당자명',
            'key' => 'rperson',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'            
        ],
        [
            'title' => '핸드폰번호',
            'key' => 'phone',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'            
        ],
        [
            'title' => '이메일',
            'key' => 'email',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'            
        ],
    ],
    'filename' => 'member-account',
    'export' => [ 
        'titleName' => '',
        'description' => '',
        'format' => [
            'date' => [],
            'numeric' => []
        ],
        'insert' => [
            'idx' => '정보관리',
            'status' => [
                0 => '승인대기',
                1 => '승인완료'
            ],
            'role'=>[
                0=>'마스터',
                1=>'총판사',
                2=>'시설사'               
            ]
        ]
    ]
    
];

?>