<?php
return [ 
		'columns' => [ 
				[ 
						'title' => 'STT', // Tiêu đề cột
						'key' => 'stt', // Từ khóa lấy dữ liệu
						'type' => 'export, report, import'  // cho phép xuất nhập báo cáo
				
				],
				[ 
						'title' => 'Tiêu đề cột 1',
						'key' => 'col_key1',
						'type' => 'export, report, import' 
				
				],
				[ 
						'title' => 'Tiêu đề cột 2',
						'key' => 'col_key2',
						'type' => 'export, report, import' 
				
				] 
		],
		'filename' => 'tên tập tin khi xuất file xlsx',
		'export' => [  // Tham số khi xuất dữ liệu
				'titleName' => 'Tên tiêu đề của tập tin',
				'description' => 'Mô tả nội dung tập tin',
				'format' => [ 
						'date' => [  // Liệt kê từ khóa dữ liệu định dạng ngày/tháng/năm
								'col_key1',
								'col_key2' 
						],
						'numeric' => [  // Liệt kê từ khóa dữ liệu định dạng số tiền
								'col_key1',
								'col_key2' 
						] 
				],
				'insert' => [ 
						'col_key1' => 'test', // nội dung cố định
						'col_key2' => [  // nội dung gắn theo giá trị
								'value1' => 'test1',
								'value2' => 'test2' 
						] 
				] 
		] 

];

?>