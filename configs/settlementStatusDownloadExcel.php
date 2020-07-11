<?php
return [ 
		'columns' => [ 
			[ 
				'title' => '번호',
				'key' => 'stt',
			    'formatCode' => '0',
			    'styleArray' => 0,
				'type' => 'export, import'
			
			],
		    [
		        'title' => '정산상태',
		        'key' => 'status',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '총판사',
		        'key' => 'userId',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '시설사',
		        'key' => 'supplier',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '정산대상기간',
		        'key' => 'createdstart',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '정산대상기간',
		        'key' => 'createdend',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '지급예정일',
		        'key' => 'settlementday',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '판매가',
		        'key' => 'pricetotal',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '수수료',
		        'key' => 'feetotal',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '정산금액',
		        'key' => 'settlementtotal',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '정산서 최종 등록일시',
		        'key' => 'modified',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '정산서 최종등록자',
		        'key' => 'modified_by',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ]
		],
		'filename' => 'list-settlement-status',
		'export' => [
				'titleName' => '',
				'description' => '',
				'format' => [ 
						'date' => [],
						'numeric' => [
						    'pricetotal',
						    'feetotal',
						    'settlementtotal'
						] 
				],
				'insert' => [						
				    'status'=>[
				        '1'=>'사업장승인대기',
				        '2'=>'사업장승인거부',
				        '3'=>'사업장승인완료',
				        '4'=>'정산완료'
				    ]
				] 
		]
];

?>