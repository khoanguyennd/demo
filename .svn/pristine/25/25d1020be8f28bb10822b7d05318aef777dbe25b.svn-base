<?php 
class Helper{
    
    // Biến lưu ngông ngữ
    static $_language;
    
    static function setLanguage($language){
        self::$_language = $language;
    }
    
    // Hàm khởi tạo tag input html 
    static function createInput($attrObj = []){
        if($attrObj){
            $default = [
                'type'=>'checkbox',
                'name'=>'',
                'value'=>'',                
                'attr'=>'',
                'label'=>'',
                'index'=>false
            ];
            $attrObj = array_merge($default,$attrObj);
            $id = Func::strRandom(8);
            $attr = ($attrObj['attr']?' '.$attrObj['attr']:'');
            $label = ($attrObj['label']?'<label for="'.$id.'">'.$attrObj['label'].'</label>':'');
            $input = '<input type="'.$attrObj['type'].'"'.$attr.' value="'.$attrObj['value'].'" name="'.$attrObj['name'].'" id="'.$id.'">';
            if($attrObj['index'] == true){
                return $label . $input;
            }
            return $input . $label;
        }
    }
    
    // Hàm tạo form html người phụ trách
    static function createPerson($language, $data){
        if(!$data){
            $data = [Structure::persons()];
        }
        return self::createPersonHtml($language, $data);
    }
    // Hàm tạo form html người phụ trách
    static function createPersonHtml($language, $data){
        $strhtml = '';
        foreach ($data as $key => $value){ 
            $hiden = '';
            $action = 'editperson';
            if($value['person_id']==0){
                //$hiden = ' hiden';
                $action = '';
            }           
            $strhtml .= '<div class="form_group clearfix frrow">
                            <div class="row rmclass'.$hiden.'"  data-action="'.$action.'" data-perid="'.$value['person_id'].'">
                                <div class="form_group clearfix">
                                    <div class="form_item col-xs-3">
                                        <h3>'. $language['l_titlepersonresname']. '</h3>
                                    </div>
                                    <div class="form_item col-xs-5">
                                        <div class="inputconfirm">
                                        <input type="text" name="aperson" value="'.$value['person_name'].'" 
                                                class="input full checkEmpty" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form_item col-xs-4"></div>
                                </div>
                                <div class="form_group clearfix">
                                    <div class="form_item col-xs-3">
                                        <h3>'.$language['l_phonenumeric'].'</h3>
                                    </div>
                                    <div class="form_item col-xs-5">
                                        <div class="inputconfirm">
                                            <input type="text" name="aphone" class="input full checkEmpty" value="'.$value['person_phone'].'"  autocomplete="off" onkeypress="validate()">
                                        </div>
                                    </div>
                                    <div class="form_item col-xs-4"></div>
                                </div>
                                <div class="form_group clearfix">
                                    <div class="form_item col-xs-3">
                                        <h3 class="height2">'. $language['l_email']. '</h3>
                            			</div>
                            			<div class="form_item col-xs-5">
                            				<div class="inputconfirm">
                            					<input type="text" name="aemail" value="'.$value['person_email'].'" disabled="disabled" class="input full checkEmail" autocomplete="off" placeholder="'. $language['l_email']. '">
                            				</div>
                            				<p class="note">'. $language['l_warnemail2']. '</p>
                            				<div class="inputconfirm">
                            					<input type="text" class="input full" name="accode" autocomplete="off" disabled="disabled" placeholder="'. $language['l_codeconfirm']. '">
                            				</div>								
                            			</div>							
                            			<div class="form_item col-xs-4 align-left">								
                            				<input type="button" class="btn hover sendCode" hidden="hidden" style="width: 100px;" value="'. $language['l_sendcodeconfirm']. '">
                                            <input type="button" class="btn hover changeEmail" style="width: 100px;" value="'. $language['l_changeemail']. '">
                            				<p style="color: transparent;padding-top: 5px;">hidden</p>
                            				<input type="button" class="btn hover codeConfirm" style="width: 100px;" value="'. $language['l_confirmcodeconfirm']. '">
                            			</div>	
                            		</div>	
                                <div class="form_group control">
                                    <div class="form_item align-center" style="width: 50%; margin:auto">
                                        <input type="button" name="save" value="담당자정보 변경 " class="btn hover btnsave" data-perid="'.$value['person_id'].'">
                                    </div>
                                </div>			
                        	</div>
                            <div class="icons rmclass'.$hiden.'">
                                
                                
                            </div>
                        </div>';
            // <input type="button" name="cancel" value="'.$language['l_Channel35'].'" class="btn hover btncancel">
            //<button type="button" class="btnclose"><i class="far fa-window-close" aria-hidden="true"></i></button>
            //<button type="button" class="btnedit"><i class="far fa-edit" aria-hidden="true"></i></button>
        }
        return $strhtml;
    }

    // Hàm tạo một dòng cho bảng import excel phân loại kênh bán
    static function createRowChannelType($data){
        $strHtml = '';
        if($data){
            foreach ($data as $key => $value){

                $totalChannelByid = $value['count'];

                $strHtml .= '<tr data-id="'.$value['channel_id'].'" data-cid="'.$value['channel_cid'].'">
                    <td>'.$value['channel_name'].'</td>
                    <td>'.$value['channel_cid'].'</td>
                    <td>
                        <span>'.$totalChannelByid.'</span>
                        <input type="button" name="download" value="'.self::$_language['l_Channel26'].'" data-cid="'.$value['channel_id'].'" class="btn hover active dowloadexcel">
                    </td>
                    <td>'.$value['ID'].'</td>
                    <td>'.date('Y-m-d', $value['channel_created']).'</td>
                    <td><input type="button" name="download" value="'.self::$_language['l_edit'].'" class="btn hover active editpost"></td>
                    </tr>';
            }
        }else{
            $strHtml = '<tr><td colspan="6" class="empty">'.self::$_language['l_rowemptydata'].'</td></tr>';
        }
        return $strHtml;
    }
    
    // Hàm tạo dòng cho bảng thông báo
    static function createRowNotification($data){
        $strHtml = '';
        if($data){
            foreach ($data as $key => $value){
                $strHtml .= '<tr>
					    <td>'.($key+1).'</td>
					    <td style="text-align: left;"><a name="detailnotification" class="detailnotification"  data-noid="'.$value['notification_id'].'">'.$value['notification_title'].'</a></td>
					    <td>'.$value['notification_created_by'].'</td>
					    <td>'.date('Y-m-d H:i:s',$value['notification_created']).'</td>
					    <td>'.$value['notification_modified_by'].'</td>
					    <td>'.(($value['notification_modified'])?date('Y-m-d H:i:s',$value['notification_modified']):'').'</td>
					    <td>
					        <input type="button" name="editnotification" value="'.self::$_language['l_edit'].'" data-noid="'.$value['notification_id'].'" class="btn hover active editnotification">
					    </td>
					</tr>';
            }
        }else{
            $strHtml = '<tr><td colspan="7" class="empty">'.self::$_language['l_rowemptydata'].'</td></tr>';
        }
        return $strHtml;
    }
    static function createRowNotification1($data){
        $strHtml = '';
        if($data){
            foreach ($data as $key => $value){
                $strHtml .= '<tr>
					    <td>'.($key+1).'</td>
					    <td style="text-align: left;"><a name="detailnotification" class="detailnotification"  data-noid="'.$value['notification_id'].'">'.$value['notification_title'].'</a></td>
					    <td>'.date('Y-m-d H:i:s',$value['notification_created']).'</td>
					</tr>';
            }
        }else{
            $strHtml = '<tr><td colspan="3" class="empty">'.self::$_language['l_rowemptydata'].'</td></tr>';
        }
        return $strHtml;
    }
    // Hàm lấy ra trạng thái của member
    static function statusMember($status){
        if ($status== 1){
            return self::$_language['l_status_6'];
        }
        return self::$_language['l_status1'];
    }
    
    // Hàm lấy ra quyền hạng của member
    static function rolesMember($role){
        if ($role== 0){
            return self::$_language['l_master'];
        }
        if ($role== 1){
            return self::$_language['l_seller'];
        }
        if ($role== 2){
            return self::$_language['l_supplier'];
        }
    }
    
    // Hàm tạo dòng cho bảng người dùng
    static function createRowMember($data){
        $strHtml = '';
        if($data){
            foreach ($data as $key => $value){      
                $str='-';;
                if($value['status']==0)
                    $str='<input type="checkbox" name="checkbox"  value="'.$value['idx'].'">';
                $strHtml .= '<tr data-id="'.$value['idx'].'">
                                <td class="checkbox" data-checkbox="'.$value['idx'].'" >'.$str.'</td>
								<td><input type="button" name="edit" value="'.self::$_language['l_edit'].'" class="btn hover active" onclick="showPopueditUser('.$value['idx'].');"></td>
								<td class="status" data-status="'.$value['idx'].'">'.self::statusMember($value['status']).'</td>
								<td>'.$value['ID'].'</td>
								<td>'.self::rolesMember($value['role']).'</td>
								<td>'.$value['ID'].'</td>
								<td>'.$value['sperson'].'</td>
								<td>'.$value['company'].'</td>
								<td>'.$value['tax'].'</td>
								<td>'.$value['career1'].'/'.$value['career2'].'</td>
								<td>'.self::$_language['l_accountinfo'].'</td>
								<td>'.$value['rperson'].'</td>
								<td>'.$value['phone'].'</td>
								<td>'.$value['email'].'</td>
							</tr>';
            }
        }else{
            $strHtml = '<tr><td colspan="14" class="empty">'.self::$_language['l_rowemptydata'].'</td></tr>';
        }
        return $strHtml;
    }

    // Hàm phân trang
    // $pageCurrenttrang hiện tại
    // $pageTotal Tổng số trang
    // $length giới hạn record
    // $link đường dẫn
    // $start Trang bắt đầu
    // $end Trang kết thúc
    static function createPagination($pageTotal, $pageCurrent, $start, $end, $length, $link){        
        $str = '';
        if($pageCurrent > 1){
            $str = '<a href="'.$link .'/1/'. $length .'" data-length="'.$length.'" data-page="1">&laquo;&laquo;</a>';
            $str .= '<a href="'.$link .'/'.($pageCurrent- 1).'/'. $length .'" data-length="'.$length.'" data-page="'.($pageCurrent- 1).'">&laquo;</a>';
        }
        for($i = $start; $i < ($end+1); $i++){
            $active = ($pageCurrent==$i)?' class="active"':'';
            $str .= '<a href="'.$link .'/'.$i.'/'. $length .'"'.$active.' data-length="'.$length.'" data-page="'.$i.'">'.$i.'</a>';
        }
        if($pageTotal > $pageCurrent){
            $str .= '<a href="'.$link .'/'.($pageCurrent + 1).'/'. $length .'" data-length="'.$length.'" data-page="'.($pageCurrent + 1).'">&raquo;</a>';
            $str .= '<a href="'.$link .'/'.$pageTotal.'/'. $length .'" data-length="'.$length.'" data-page="'.$pageTotal.'">&raquo;&raquo;</a>';
        }
        return '<div class="form_group">
    		<div style="text-align: center;">
    			<div class="pagination">'.$str.'</div>
    		</div></div>';
    }
    
    // Phương thức tạo html cho menu phân loại T-Gridge
    static function createMenuTgridge($data){
        if($data){
            $result = self::createMenuTgridgeHtml($data);
            if($result){
                $search = [                   
                    '</li><ul class="ch_child"><li>',
                    '</li><ul class="ch_child"></ul></ul><li>',
                    '</li><ul class="ch_child"></ul></ul></ul>',
                    '</ul></ul>',
                    '<ul class="ch_child"></ul>',                    
                ];
                $replace= [                   
                    '<ul class="ch_child"><li>',
                    '</li></ul></li><li>',
                    '</li></ul></li></ul></li>',
                    '</ul></li></ul>',
                    ''
                ];
                return str_replace($search, $replace, $result);
            }
        }
    }
    // Phương thức tạo html cho menu phân loại T-Gridge ĐỆ QUY
    static function createMenuTgridgeHtml($data, $parent=0, $level = 1){
        if($data){
            $result = '<ul class="'.(($parent==0)?'ch_parrent':'ch_child').'">';
            foreach ($data as $key => $value){
                if($value['type_parentid'] == $parent){
                    $result .= self::createMenuTgridgeLiHtml($value, $level);
                    unset($data[$key]);                    
                    $result .= self::createMenuTgridgeHtml($data, $value['type_id'], $level+1);                   
                }
            }
            $level = 1;
            $result .= '</ul>';
            return $result;
        }
    }
    // Phương thức tạo một thẻ LI cho menu phân loại T-Gridge
    static function createMenuTgridgeLiHtml($data, $level){
        return '<li><a href="#" title="'.$data['type_value'].'" data-typeid="'.$data['type_id'].'" data-parentid="'.$data['type_parentid'].'" data-status="'.$data['type_status'].'" data-level="'.$level.'"><i class="fas fa-chn"></i>'.$data['type_value'].'</a></li>';
    }
    
    // Phương thức đệ quy hỗ trợ cho xuất file excel
    static function productType($data, $parent = 0, $level = 1, $tmp = []){
        if($data){
            $result = [];
            foreach ($data as $key => $value){
                if($value['type_parentid'] == $parent){
                    if(!$tmp){
                        $tmp = array_merge($tmp,['type_depth1'=>'','type_depth2'=>'','type_depth3'=>'','type_depth4'=>'','type_status'=>'']);
                    }
                    $tmp['type_depth'.$level] = $value['type_value'];
                    $tmp['type_status'] = $value['type_status'];
                    $tmp['type_level'] = $level;
                    $tmp['type_id'] = $value['type_id'];
                    $tmp['type_parentid'] = $value['type_parentid'];
                    unset($data[$key]);
                    $child = self::productType($data, $value['type_id'], $level+1, $tmp);
                    $result[] = $tmp;
                    $result = array_merge($result, $child);
                    continue;
                }
                $tmp['type_depth'.$level] = '';
                $tmp['type_status'] = '';
            }
            return $result;
        }
    }
    
    // Phương thức tạo dòng cho bảng hỏi đáp
    static function catchuoi($chuoi,$gioihan){
        if(strlen($chuoi)<=$gioihan){
            return  $chuoi;
        }else{
            
            if(strpos($chuoi," ",$gioihan) > $gioihan){
                $new_gioihan=strpos($chuoi," ",$gioihan);
                //$new_chuoi = substr($chuoi,0,$new_gioihan)."...";
//                 /$new_chuoi = mb_substr($chuoi,0,$new_gioihan,'UTF-8')."...";
                $new_chuoi = mb_substr($chuoi,0,$gioihan,'UTF-8')."...";
                return  $new_chuoi;
            } else{
                //$new_chuoi = substr($chuoi,0,$gioihan)."...";
                $new_chuoi= mb_substr($chuoi,0,$gioihan,'UTF-8');
                return $new_chuoi;
            }
        }
    }
    
    static function createRowQuestion($data, $length, $begin){
        $strHtml = '';
        if($data){
            foreach ($data as $key => $value){
                $manage = '답변등록';
                $statusReply = self::$_language['l_anwserbefore'];
                if($value['question_status']==2){
                    $statusReply = self::$_language['l_anwserdone'];
                    $manage = '답변보기';
                }
                $begin=$begin+1;
                $strHtml .= '<tr>
                                <td>'.($begin).'</td>
                                <td><input type="button" name="action" value="'.$manage.'" data-qsid="'.$value['question_id'].'" data-channel="'.$value['channel_name'].'" data-dealid="'.$value['dealId'].'" class="btn hover active manager"></td>
                                <td style="text-align:left">'.$statusReply.'</td>
                                <td style="text-align:left">'.$value['channel_name'].'</td>
                                <td style="text-align:left">'.$value['channel_name'].''.$value['question_id'].'</td>
                                <td style="text-align:left">'.self::catchuoi($value['question_content'], 10).'</td>
                                <td style="text-align:left">'.$value['dealId'].'</td>
                                <td style="text-align:left">'.$value['optionName'].'</td>
                                <td style="text-align:left">'.$value['orderNumber'].'</td>
                                <td style="text-align:left">'.$value['question_purchase'].'</td>
                                <td style="text-align:left">'.$value['question_name'].'</td>
                                <td style="text-align:left">'.date('Y-m-d H:i:s', strtotime($value['question_created'])).'</td>
                            </tr>';
            }
        }else{
            $strHtml = '<tr><td colspan="12" class="empty">'.self::$_language['l_rowemptydata'].'</td></tr>';
        }
        return $strHtml;
    }
    // Phương thức tạo dòng cho bảng hỏi đáp mobi
    static function createRowQuestionmobi($data, $length, $begin){
        $strHtml = '';
        if($data){
            foreach ($data as $key => $value){
                
                $manage = self::$_language['l_anwser'];
                $statusReply = self::$_language['l_anwserbefore'];
                if($value['reply_created']){                    
                    $statusReply = self::$_language['l_anwserdone'];
                    $manage = self::$_language['l_edit'];
                }
                $begin=$begin+1;
                $strHtml .= '<div class="list_cauhoi">
                            <p class="p_channel_cauhoi"><span>'.$value['channel_name'].'</span></p>
                            <div class="list_cauhoi_1">                        
                                <p class="p_list_cauhoi_1">
                                    <span class="p_list_cauhoi_span_email">'.$value['question_name'].'</span> 
                                    <span class="p_list_cauhoi_span_time"> '.date('Y-m-d H:i:s', strtotime($value['question_created'])).'</span>
                                </p>
                                <p>'.$value['question_content'].'</p>
                            </div>
                            <div class="list_cauhoi_2">
                                <input type="button" name="action" value="'.$manage.'" data-qsid="'.$value['question_id'].'" data-channel="'.$value['channel_name'].'" data-dealid="'.$value['dealId'].'" class="btn hover active manager">
                            </div><div class="cl"></div>
                        </div>';
                
                
            }
        }       
        return $strHtml;
    }
    static function createRowQuestionChannel($data, $length, $begin){
        $strHtml = '';
        if($data){
            $tong=1;            
            foreach ($data as $key => $value){                
                $manage = self::$_language['l_anwser'];
                $statusReply = self::$_language['l_anwserbefore'];
                if($value['reply_created']){ 
                    $statusReply = self::$_language['l_anwserdone'];
                    $manage = self::$_language['l_edit'];
                }
                $begin=$begin+1;
                $strHtml .= '<tr>                                                
                            <td style="position: relative; width: 80%; border-right: 0px; padding-top: 50px; text-align: left; padding-left: 20px;">
                                <span style="position: absolute; top: 0px; left: 0px;background: #376092; padding: 10px 10px 10px 5px; color: #fff;">
                                    '.$value['channel_name'].'
                                </span>
                                <p>
                                    <span class="p_list_cauhoi_span_email">'.$value['question_name'].'</span>
                                    <span class="p_list_cauhoi_span_time"> '.date('Y-m-d H:i:s', strtotime($value['question_created'])).'</span>
                                </p>
                                <p>'.$value['question_content'].'</p>
                            </td>
                            <td style="width: 20%; text-align: center; border-left:0px;">                                                    
                                <input type="button" name="action" value="'.$manage.'" data-qsid="'.$value['question_id'].'" class="btn hover active manager">
                            </td>
                        </tr>';
                if(count($data)!=$tong){
                    $strHtml .= '<tr style="height: 30px; border: 0px"><td colspan="2"></td></tr>';
                }
                $tong++;
            }
        }else{
            $strHtml = '<tr><td colspan="12" class="empty">'.self::$_language['l_rowemptydata'].'</td></tr>';
        }        
        return $strHtml;
    }
    
    // Phương thức lấy ra trạng thái đơn hàng
    static function statusOrder($status){
        $result = ['name'=>'', 'action'=>''];
        //1 mua xong, 2 xử dụng xong, 3 hoàn tiền xong, -1 hết hiệu lực xử dụng        
        switch ($status){            
            case 2:
                $result['name'] = self::$_language['l_orderusedone'];
                $result['action'] = self::$_language['l_confirmrestore'];
                break;
            case 3:
                $result['name'] = self::$_language['l_orderreturnprice'];
                break;
            case -1:
                $result['name'] = self::$_language['l_orderdie'];
                break;
            default:
                $result['name'] = self::$_language['l_orderdone'];
                $result['action'] = self::$_language['l_confirmuse'];
        }
        return $result;
    }
    
    // Phương thức tạo dòng cho danh sách đơn hàng
    static function createRowOrder($data){
        $strHtml = '';      
        if($data){
            foreach ($data as $key => $value){                
                $status = self::statusOrder($value['statusTicket']);
                //<td>'.(($status['action'])?'<input type="button" name="action" value="'.$status['action'].'" class="btn hover active">':'-').'</td>
                $href='#';
                if($value['channel_name'] == 'COUPANG' ){
                    $href="https://trip.coupang.com/tp/products/".$value['dealId'];
				}
				if($value['channel_name'] == 'TMON' ){	
			     	 $href="http://www.tmon.co.kr/deal/".$value['dealId'];
				}
				if($value['channel_name'] == 'WMAKE' ){
				    $href="https://tour.wd.wemakeprice.com/activity/direct/detail/".$value['dealId'];
				}
				if($value['channel_name'] == 'G(ysjlabs)' ){
				    $href="http://item.gmarket.co.kr/Item?goodscode=".$value['dealId'];
				}
				if($value['channel_name'] == 'A(ysjlabs)' ){
				    $href="http://itempage3.auction.co.kr/detailview.aspx?ItemNo=".$value['dealId'];
				}
				if($value['channel_name'] == '11ST' ){
				    $href="http://www.11st.co.kr/products/".$value['dealId'];
				}
				
				
				$optionId= $value['optionId'];
				if($value['optionId'] == '0' || $value['optionId'] == '' ){
				    $optionId='-';
				}
                $strHtml .= '<tr data-id="'.$value['ticketNumber'].'" data-status="'.$value['statusTicket'].'" data-restore="'.$value['restoreTicket'].'">
    							<td><input type="checkbox" name="checkbox" value="'.$value['id'].'"></td>
    							<td>'.$status['name'].'</td>
    							<td>'.($value['restoreTicket']?'Y':'-').'</td>
    							<td>'.$value['channel_name'].'</td>
    							<td>'.$value['channel_name'].'-'.$value['id'].'</td>            						
								<td>'.$value['ticketNumber'].'</td>
								<td>'.$value['purchaseDateTime'].'</td>
								<td>'.$value['orderNumber'].'</td>								
								<td>'.$value['sellerProductId'].' ('.$value['dealId'].')</td>
								<td>'.$optionId.'</td>
								<td><a href="'.$href.'" target="_blank">'.$value['dealName'].'</a></td>
								<td>'.$value['optionName'].'</td>
								<td>'.$value['userName'].'</td>
								<td>'.$value['phoneNumber'].'</td>
                                <td>'.number_format($value['price']).'</td>
							</tr>';
                //'.$value['sellerticket_id'].'
            }
        }else{
            $strHtml = '<tr><td colspan="16" class="empty">'.self::$_language['l_rowemptydata'].'</td></tr>';            
        }
        return $strHtml;
    }
    // Phương thức tạo dòng cho danh sách đơn hàng
    static function createRowOrderMobi($data){
        $strHtml = '';      
        if($data){
            foreach ($data as $key => $value){                
                $status = self::statusOrder($value['statusTicket']);    
                $strHtml .='<tr style="border-spacing: 15px;" data-id="'.$value['ticketNumber'].'" data-status="'.$value['statusTicket'].'" data-restore="'.$value['restoreTicket'].'">
                        <td style="position: relative; width: 20%; text-align: center; border-right:0px;">
                            <input type="checkbox" name="checkbox" value="'.$value['id'].'">
                            <span class="rows_order_span">'.$status['name'].'</span>
                        </td>
                        <td style="width: 80%; border-left: 0px; padding-top: 15px;">
                            <p><b>'.self::$_language['l_tbridge'].' : '.$value['channel_name'] . '-' . $value['id'].'</b></p>
                            <p><b>'.self::$_language['l_Channel7'].': '.$value['channel_name'].'</b></p>
                            <p>'.$value['productname'].'</p>
                            <p>'.$value['optionName'].'</p>
                            <p>'.$value['userName'].' ['. $value['phoneNumber'].']</p>
                            <p>'.$value['purchaseDateTime'].'</p>
                        </td>
                    </tr>
                    <tr id="'.$value['ticketNumber'].'" style="height: 30px; border: 0px"><td colspan="2"></td></tr>';
                /*
                $strHtml .= '<tr data-id="'.$value['ticketNumber'].'" data-status="'.$value['statusTicket'].'" data-restore="'.$value['restoreTicket'].'">
    							<td><input type="checkbox" name="checkbox" value="'.$value['id'].'"></td>
    							<td>'.$status['name'].'</td>
    							<td>'.($value['restoreTicket']?'Y':'-').'</td>
    							<td>'.$value['channel_name'].'</td>
    							<td>'.$value['channel_name'].'-'.$value['id'].'</td>            						
								<td>'.$value['ticketNumber'].'</td>
								<td>'.$value['purchaseDateTime'].'</td>
								<td>'.$value['dealId'].'</td>								
								<td>'.$value['sellerProductId'].' ('.$value['travelProductId'].')</td>
								<td>'.$value['optionId'].'</td>
								<td><a href="#" target="_blank">'.$value['productname'].'</a></td>
								<td>'.$value['optionName'].'</td>
								<td>'.$value['userName'].'</td>
								<td>'.$value['phoneNumber'].'</td>
                                <td>'.$value['price'].'</td>
							</tr>';*/
            }
        }else{
            $strHtml = '<tr><td colspan="16" class="empty">'.self::$_language['l_rowemptydata'].'</td></tr>';  
            $strHtml .= '<tr style="height: 30px; border: 0px"><td colspan="2"></td></tr>';
        }
        return $strHtml;
    }
    
    
    // Phương thức tạo dòng cho danh sách đơn hàng statusTicket
    static function createRowOrderStatusTicket($data){
        $strHtml = '';      
        if($data){
            foreach ($data as $key => $value){                
                $status = self::statusOrder($value['statusTicket']);                
                $strHtml .='<tr style="border-spacing: 15px;" data-id="'.$value['ticketNumber'].'" data-status="'.$value['statusTicket'].'" data-restore="'.$value['restoreTicket'].'">
                    <td style="position: relative; width: 20%; text-align: center; border-right:0px;">
                        <input type="checkbox" name="checkbox" value="'.$value['id'].'">
                        <span class="rows_order_span">'.$status['name'].'</span>
                    </td>
                    <td style="width: 80%; border-left: 0px; padding-top: 15px;">
                        <p><b>'.self::$_language['l_tbridge'].' : '.$value['channel_name'].'-'.$value['id'].'</b></p>
                        <p><b>'.self::$_language['l_Channel7'].': '.$value['channel_name'].'</b></p>
                        <p>'.$value['productname'].'</p>
                        <p>'.$value['optionName'].'</p>
                        <p>'.$value['userName'].' ['.$value['phoneNumber'].']</p>
                        <p>'.$value['purchaseDateTime'].'</p>
                    </td>
                </tr>
                <tr style="height: 30px; border: 0px"><td colspan="2"></td></tr>';
            }
        }else{
            $strHtml = '<tr><td colspan="16" class="empty">'.self::$_language['l_rowemptydata'].'</td></tr>';            
        }
        return $strHtml;
    }
    

    // Phương thức tạo multipe select option
    static function createMultipeSelectOption($data, $value, $name, $id = 'mtpselect1', $multiple = true, $checked = []){        
        $strChecked = $ipchecked = $otselected = '';
        $multiple = ($multiple)?' multiple':'';
        $strOption = '<option value="all">'.self::$_language['l_question4'].'</option>';
        $strList = '<li class="selectall"><input type="checkbox" value="all" checked><label>'.self::$_language['l_question4'].'</label></li>';
        if($data){
            foreach ($data as $k => $v){
                if(!$checked && $multiple){
                    $ipchecked = ' checked ';
                    $otselected = ' selected ';
                }else{
                    if(in_array($v[$value], $checked)){
                        $ipchecked = ' checked="checked"';
                        $otselected = ' selected="selected"';
                        $strChecked .= ', ' . $v[$name];
                    }
                }                
                $strOption .= '<option value="'.$v[$value].'"'.$otselected.'>'.$v[$name].'</option>';
                $strList .= '<li><input type="checkbox"'.$ipchecked.' value="'.$v[$value].'"><label>'.$v[$name].'</label></li>';
            }
        }
        $count = count($checked?$checked:($multiple?$data:[1]));
        return '<div class="multipleselect">
                    <select hidden="hidden" id="'.$id.'" name="'.$id.($multiple?'[]':'').'"'.$multiple.'>'.$strOption.'</select>
                    <div class="selectinput">
                        <input value="'.($strChecked?substr($strChecked, 2):self::$_language['l_question4']).'" readonly="readonly">
                        <span class="item" id="selectitem">'.$count.'</span>
                        <span class="arrowdown">&nbsp;</span>
                    </div>
                    <ul class="selectlist scrollbar'.$multiple.'">'.$strList.'</ul>
                </div>';	
    }
    
    // Phương thức tạo dòng cho danh sách quyết toán
    static function createRowRevenueSettlement($data){
        $strHtml = '';
        if($data){
            foreach ($data as $key => $value){               
                $strHtml .= '<tr>
    							<td>'.$value['channel_name'].'</td>
    							<td>'.$value['ID'].'</td>	
    							<td>'.self::$_language['l_revenuemonth'].'</td>
    							<td>'.self::$_language['l_revenuelog'].' 1</td>
    							<td>100%</td>
    							<td>'.$value['createdstart'].' ~ '.$value['createdend'].'</td>
    							<td>'.$value['settlementday'].'</td>
    							<td>'.Func::formatPrice($value['pricetotal']).'</td>
    							<td>'.Func::formatPrice($value['feetotal']).'</td>
    							<td>'.Func::formatPrice($value['pricetotal'] + $value['feetotal']).'</td>					
    						</tr>';
            }
        }else{
            $strHtml = '<tr><td colspan="10" class="empty">'.self::$_language['l_rowemptydata'].'</td></tr>';
        }
        return $strHtml;
    }
    
    // Phương thức tạo dòng cho danh sách quyết toán
    static function createRowRevenueSettlementStatus($data, $link){
        $strHtml = '';
        if($data){
            foreach ($data as $key => $value){
                $status = self::statusSettlementStatus($value['status']);
                $strHtml .= '<tr data-id="'.$value['id'].'" data-status="'.$value['status'].'">
    							<td>'.$status['checked'].'</td>
    							<td><a href="'.$link.'/'.$status['key'].'/'.$value['id'].'" class="abtn" target="_blank">'.self::$_language[$status['action']].'</a></td>						
    							<td>'.self::$_language[$status['name']].'</td>							
    							<td>'.$value['userId'].'</td>							
    							<td>'.$value['supplier'].'</td>							
    							<td>'.$value['createdstart'].' ~ '.$value['createdend'].'</td>							
    							<td>'.$value['settlementday'].'</td>							
    							<td>'.Func::formatPrice($value['pricetotal']).'</td>							
    							<td>'.Func::formatPrice($value['feetotal']).'</td>							
    							<td>'.Func::formatPrice($value['settlementtotal']).'</td>							
    							<td>'.$value['modified'].'</td>							
    							<td>'.$value['modified_by'].'</td>						
    						</tr>';
            }
        }else{
            $strHtml = '<tr><td colspan="12" class="empty">'.self::$_language['l_rowemptydata'].'</td></tr>';
        }
        return $strHtml;
    }
    
    // Phương thức lấy trạng thái của revenuesettlementstatus
    static function statusSettlementStatus($status){       
        // 4 Duyệt xong
        $result = [
            'checked'=>'-',
            'action'=>'l_revenue09',
            'name'=>'l_revenue24',
            'key'=>'view'
        ]; 
        // 1 Chờ GĐ duyệt
        if($status == 1){
            $result['name'] = 'l_revenue10';
            if(Session::get('accountshopping')['role']>0){
                $result['checked'] = '<input type="checkbox" name="checked" value="checked">';
            }
        }
        // 2 GĐ từ chối duyệt
        if($status == 2){
            $result['name'] = 'l_revenue12';
            if(Session::get('accountshopping')['role']==0){
                $result['action'] = 'l_revenue13';
                $result['key'] = 'edit';
            }
        }        
        // 3 GĐ duyệt xong
        if($status == 3){
            $result['name'] = 'l_revenue11';
            if(Session::get('accountshopping')['role']==0){
                $result['checked'] = '<input type="checkbox" name="checked" value="checked">';
            }
        }
        return $result;
    }

    // Phương thức tạo dòng cho danh sách tình hình quyết toán chi tiết
    static function createRowRevenueSettlementStatusDetail($data){
        $result = [
            'strHtml'=>'',
            'totalHtml'=>''
        ];       
        if($data){
            $amount=0;
            $pricetotal=0;
            $feetotal=0;
            foreach ($data as $key => $value){   
                $amount+=$value['amount'];
                $pricetotal+=($value['price']*$value['amount']);
                $feetotal+=$value['feetotal'];
                $statusmew=self::$_language['l_statusmew0'];
                if($value['statusnew']==1)
                    $statusmew=self::$_language['l_statusmew1'];
                $result['strHtml'] .= '<tr>
                        					<td>'.$statusmew.'</td>
                        					<td>'.$value['channelname'].'</td>
                        					<td>'.$value['productname'].'</td>
                        					<td>'.number_format($value['price']).'</td>
                        					<td>'.$value['amount'].'</td>
                        					<td>'.number_format($value['pricetotal']).'</td>
                        					<td>'.number_format($value['pricetotal']-$value['feetotal']).'</td>
                        					<td>'.number_format($value['feetotal']).'</td>
                        				</tr>';
                
            }
            
            $result['totalHtml'] = '<th>'.$amount.'</th>
                					<th>'.number_format($pricetotal).'</th>
                					<th>'.number_format($pricetotal-$feetotal).'</th>
                					<th>'.number_format($feetotal).'</th>';
            
        }else{
            $result['strHtml']= '<tr><td colspan="8" class="empty">'.self::$_language['l_rowemptydata'].'</td></tr>';
        }
        return $result;
    }
    
    // Phương thức tạo dòng cho danh sách lịch sử quyết toán
    static function createRowRevenueSettlementHistory($data){
        $strHtml = '';
        if($data){
        	foreach ($data as $value){
        		$strHtml .= '<tr>
							<td>'.$value['created'].'</td>
							<td>'.self::$_language[$value['content']].'</td>
							<td>'.$value['created_by'].'</td>
							<td></td>
						</tr>';
        	}
        }else{
        	$strHtml = '<tr><td colspan="4" class="empty">'.self::$_language['l_rowemptydata'].'</td></tr>';
        }
        return $strHtml;
    }
    
}

?>