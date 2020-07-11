<?php
return [
    'columns' => [
        [
            'title' => '대분류',
            'key' => 'type_depth1',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
        ],
        [
            'title' => '중분류',
            'key' => 'type_depth2',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
        ],
        [
            'title' => '소분류',
            'key' => 'type_depth3',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
        ],
        [
            'title' => '세분류',
            'key' => 'type_depth4',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
        ],
        [
            'title' => '연동형태',
            'key' => 'type_linkform',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
        ],
        [
            'title' => 'api값',
            'key' => 'type_apivalue',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
        ],
        [
            'title' => '수수료',
            'key' => 'type_rate',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
        ],
        [
            'title' => 'Active',
            'key' => 'type_status',
            'formatCode' => '0',
            'styleArray' => 0,
            'type' => 'export, import'
        ]
    ],
    'filename' => 't-bridge-types',
    'export' => [
        'titleName' => '',
        'description' => '',
        'format' => [
            'date' => [],
            'numeric' => []
        ],
        'insert' => [
            'type_status' => [
                '1' => 'Y',
                '0' => '-'
            ]
        ]
    ]
];

?>