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
            'title' => '판매채널',
            'key' => 'channelname',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
        ],
        [
            'title' => '시설사',
            'key' => 'suppliername',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
        ],
        [
            'title' => '상품명',
            'key' => 'productname',
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
            'title' => '판매시작일',
            'key' => 'useStartedAt',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
        ],
        [
            'title' => '판매종료일',
            'key' => 'useEndedAt',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
        ],
        [
            'title' => '실판매수량',
            'key' => 'quantitysoldreal',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
        ],
        [
            'title' => '실판매금액',
            'key' => 'amountsoldreal',
            'formatCode' => '#,##0',
            'styleArray' => 0,
            'type' => 'export, import'
        ],
        [
            'title' => '사용처리수량',
            'key' => 'quantitysolduse',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
        ],
        [
            'title' => '사용처리금액',
            'key' => 'amountsolduse',
            'formatCode' => '#,##0',
            'styleArray' => 0,
            'type' => 'export, import'
        ]
    ],
    'filename' => 'list-revenue-detail',
    'export' => [
        'titleName' => '',
        'description' => '',
        'format' => [
            'date' => [],
            'numeric' => []
        ],
        'insert' => [
            'status' => [
                '0' => '임시저장',
                '1' => '승인대기',
                '2' => '판매대기',
                '3' => '판매중',
                '4' => '판매완료',
                '-1' => '판매중지'
            ]
        ]
    ]
];

?>