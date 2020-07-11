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
		        'title' => '채널사명',
		        'key' => 'channel_name',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '시설사',
		        'key' => 'ID',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '정산유형',
		        'key' => 'channel_id', // tạm thời
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '정산차수',
		        'key' => 'channel_cid', // tạm thời
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '정산지급비율',
		        'key' => 'idx', // tạm thời
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
		        'title' => '정산예상일',
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
		        'title' => '채널수수료',
		        'key' => 'feetotal',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		    [
		        'title' => '채널입금가',
		        'key' => 'settlementtotal',
		        'formatCode' => '0',
		        'styleArray' => 0,
		        'type' => 'export, import'
		        
		    ],
		],
		'filename' => 'list-settlement',
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
				    'channel_id'=>'월정산',
				    'channel_cid'=>'차 1',
				    'idx'=>'100%'
				] 
		]
];

?>