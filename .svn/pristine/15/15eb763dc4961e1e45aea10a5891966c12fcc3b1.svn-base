<div id="popup" class="fixed no-print">
	<div class="relative">
		<!-- Popup Loadding -->
		<div class="absolute loading">
			<img src="<?=URL_PUBLIC?>images/loading.svg" alt="loadding">
		</div>
		<!-- Popup Alert -->
		<div class="absolute alert">
			<div class="title">
				<h3><?=$this->language('l_notification')?></h3>				
			</div>
			<div class="content align-center">
				<p>content</p>
			</div>
			<div class="control">
				<input type="hidden"  name="tempUser" id="tempUser" value="0">
				<input type="button" class="btn small hover popupClose" name="close" value="확인">
				<!-- <?=$this->language('l_close')?> -->
			</div>
		</div>
		
		<!-- Popup Confirm -->
		<div class="absolute confirm">
			<div class="title">
				<h3><?=$this->language('l_notification')?></h3>				
			</div>
			<div class="content">
				<p>content</p>
			</div>
			<div class="control">
				<input type="button" class="btn small hover back" name="cancel" value="<?=$this->language('l_back')?>"> 
				<input type="button" class="btn small hover continue" name="continue" value="<?=$this->language('l_continue')?>">
			</div>
		</div>
		
		<!-- Popup Ticket Confirm -->
		<div class="absolute ticketconfirm">
			<div class="title">
				<h3><?=$this->language('l_notification')?></h3>				
			</div>
			<div class="content">
				<p>content</p>
			</div>
			<div class="control">
				<input type="button"
					class="btn small hover continue" name="continue" value="<?=$this->language('l_ok')?>">
				<input type="button" class="btn small hover cancel" name="cancel" value="<?=$this->language('l_Channel35')?>"> 
			</div>
		</div>

		<!-- Popup password -->
		<div class="absolute password" style="max-width: 400px;">
			<form action="#" method="post">
				<div class="title">
					<h3>신규 비밀번호 변경</h3>
				</div>
				<div class="content">
					
					<p>이용자 확인이 완료되었습니다. 신규 비밀번호로 변경 후 이용해주세요</p>
					<div class="form_group clearfix">
						<div class="form_item">
							<div class="inputconfirm">
								<input type="password" name="password" value="" class="input full checkPW" placeholder="<?=$this->language('l_newpassword')?>">
								<p class="note" id="warnpassword" style="color: #f9933b"></p>
							</div>
						</div>
					</div>
					<div class="form_group clearfix">
						<div class="form_item">
							<div class="inputconfirm">
								<input type="password" name="confirmpassword" value="" class="input full confirmPW" placeholder="<?=$this->language('l_confirmpassword')?>">
								<p class="note" id="warncpassword" style="color: #f9933b"></p>
							</div>
						</div>
					</div>
				</div>
				<div class="control">
					<input type="submit" class="btn full small changepassword hover" name="submit" value="확인" disabled="disabled">
				</div>
			</form>
		</div>

		<!-- Popup channel -->
		<div class="absolute channel big">
			<form action="#" method="post">
				<div class="title">
					<h3><?=$this->language('l_Channel5')?></h3>
				</div>
				<div class="content">
					<div class="form_group clearfix">
						<div class="form_group clearfix">
							<div class="form_item col-xs-4">
								<h3><?=$this->language('l_Channel7')?></h3>
							</div>
							<div class="form_item col-xs-8">
								<div class="inputconfirm">
									<input type="text" name="channelname" value=""
										class="input full checkEmpty" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="form_group clearfix">
							<div class="form_item col-xs-4">
								<h3><?=$this->language('l_Channel8')?></h3>
							</div>
							<div class="form_item col-xs-8">
								<div class="inputconfirm">
									<input type="text" name="channelid" value=""
										class="input full checkChannelID" autocomplete="off">
								</div>
							</div>
						</div>
						<div class="form_group clearfix">
							<div class="form_item col-xs-4">
								<h3><?=$this->language('l_type')?></h3>
							</div>
							<div class="form_item col-xs-8 clearfix">
								<div class="col-xs-5">
									<label for="change_files" class="btn hover active small"><?=$this->language('l_Channel36')?></label>
									<input id="change_files" style="display: none;" name="file"
										style="visibility:hidden;" type="file"
										accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
									<script type="text/javascript">
                                        $("#change_files").change(function() {                                          
                                            $('#load_file_name p').html((this.files[0])?this.files[0].name:'');
                                        });
                                    </script>
								</div>
								<div class="col-xs-7">
									<a href="<?=URL_TEMPLATE.'example-channel.xlsx'?>"
										class="btn hover small active"><?=$this->language('l_Channel37')?></a>
								</div>
							</div>
						</div>
						<div class="form_group">
							<div class="form_item" id="load_file_name">
								<p></p>
							</div>
						</div>
					</div>
				</div>
				<div class="control align-center">
					<input type="submit" class="btn small hover full" name="submit" 
						value="<?=$this->language('l_Channel34')?>">
				</div>
			</form>
		</div>

		<!-- Popup notification -->
		<div class="absolute notification big">
			<form action="#" method="post">
				<div class="title">
					<h3><?=$this->language('l_notification15')?></h3>
				</div>
				<div class="content">
					<div class="form_group clearfix">
						<div class="form_item">
							<input type="text" name="title" class="input full" value=""
								placeholder="<?=$this->language('l_Channel38')?>">
						</div>
						<div class="form_item">
							<textarea name="content" class="input full scrollbar" rows="8"
								placeholder="<?=$this->language('l_Channel39')?>" style="overflow:auto"></textarea>
						</div>
					</div>
				</div>
				<div class="control" style="padding-right: 10px;">
					<input type="submit" class="btn small hover" name="submit"
						value="<?=$this->language('l_Channel34')?>">
				</div>
			</form>
		</div>
		<div class="absolute detailnotification big">
				<div class="title">
				</div>
				<div class="content">
					<div class="form_group clearfix">
						<div class="form_item">
							<p></p>
						</div>
						<div class="form_item">
							<textarea name="content" class="input full scrollbar" rows="8"
								placeholder="<?=$this->language('l_Channel39')?>" style="overflow:auto"></textarea>
						</div>
					</div>
				</div>
				<div class="control" style="padding-right: 10px;">
					<input type="submit" class="btn small hover popupClose" name="submit" value="확인">
				</div>

		</div>
		<!-- Popup thêm nhiều nhà cung cấp -->
		<div class="absolute newposts ">
			<div class="title">
				<h3>시설사 개별등록</h3>
			</div>
			<p style="line-height: 20px;">양식다운로드 후 시설사 정보를 입력해서 업로드 해주세요. <br>
                                                                        사업자 등록증,통장사본은 시설사 목록에서 시설사별로 수정을 클릭 후 개별 등록해주세요.
                                                                        </p>
			<div class="btn-group">
				<a class="btn btn-default" id="downloadfile_ncc" style="margin-right: 5px;" href="<?=URL_TEMPLATE."supplier_upload_file.xlsx";?>">양식 다운로드</a>
				<a class="btn btn-default" id="upload_file_NCC">파일업로드</a><span id="load_file_name"><p style="font-size: 12px;float: left;padding: 10px"></p></span>
				<div class="clearfix"></div>
				<input type="file" id="Uploadexcel_NCC" name="fileupload"  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" style="display: none">
				<script>
					$("#Uploadexcel_NCC").change(function() {
						$('#load_file_name p').html(this.files[0].name);
					});
	  			</script>
			</div>
			<div class="control">
				<input type="button" class="btn small hover back" style="width: 60px;" name="cancel" value="취소 ">
				<input type="button" class="btn full small hover" style="width: 60px;" name="submit" id="btnUploadNCC" value="확인 ">
			</div>
		</div>
		<!-- Popup thêm sửa ngày -->
                
        <!-- Popup điều khoản sử dụng -->		
		<div class="absolute popdieukhoan ">
            <div class="ct_content">
                <div class="form_tab">
                    <div class="tab_head">
                        <ul class="clearfix" style="border: 1px solid #a9a9a9;">
                            <li><a href="#tab1" id="rule1" class="active" data-tab="tab1" title=""><?=$this->language('l_dieukhoan')?></a></li>				
                            <li style="border-right:1px solid #a9a9a9;"><a href="#tab2" id="rule2" data-tab="tab2" title="" ><?=$this->language('l_chinhsach')?></a></li>
                            <button style="position: absolute;top: 7px;right: 22px;border: 0px; background: none;font-size: 24px;" class="popupClose">X</button>
                        </ul>
                    </div>
                    <div class="tab_content scrollbar" style="height: 450px">
                        <div id="tab1a"><?php require 'rule/rule1.php'; ?></div>
                        <div id="tab2a"><?php require 'rule/rule2.php'; ?></div>
                    </div>
                </div>
            </div>
		</div>
		
		<div class="absolute listproduct ">
			<form action="#" method="post">
				<div class="title">
					<h3><?=$this->language('l_listproduct18')?></h3>
				</div>
				<div class="content">
					<div class="form_group clearfix">
						<div class="form_item">
							<p><?=$this->language('l_listproduct19')?></p>
						</div>
						<div class="form_item">
							<?=$this->language('l_listproduct20')?> :
							<?php    $m_stopsale = date("Y-m-d");?>
							<input type="text" name="m_stopsale" id="m_stopsale"
								class="input datepick" value="<?=$m_stopsale?>"
								readonly="readonly" />

						</div>

					</div>
				</div>
				<div class="control">
					<input type="button" class="btn small hover back" style="width: 60px;" name="cancel" value="취소 ">
					<input type="button" class="btn full small hover" style="width: 60px;" name="submit"id="btnstopsale" value="확인 ">
				</div>
			</form>
		</div>
		
		<!-- Popup thêm checklist -->
		<div class="absolute checklist ">
			<form action="#" method="post">
				<div class="title">
					<h3>체크리스트발송</h3>
				</div>
				<div class="content">
					<div class="form_group clearfix">
						<div class="form_item">
							<p>체크리스트를 받을 이메일을 입력해주세요.</p>
						</div>
						<div class="form_item">
							<input name="email1" id="email1"  type="text" value="" class="input full"
                                   placeholder="<?= $this->language('l_inputemail') ?>"/>
                            <input name="email2" id="email2" type="text" value="" class="input full"
                                   placeholder="<?= $this->language('l_inputemail') ?>"/>
                            <input name="email3" id="email3" type="text" value="" class="input full"
                                   placeholder="<?= $this->language('l_inputemail') ?>"/>
						</div>

					</div>
				</div>
				<div class="control">
					<input type="button" class="btn small hover back" style="width: 60px;" name="cancel" value="취소 ">
					<input type="button" class="btn full small hover" style="width: 60px;" name="submit" id="btnchecklist" value="확인 ">
				</div>
			</form>
		</div>
		<!-- Popup question -->
		<div class="absolute question big">
			<form action="#" method="post">
				<div class="title">
					<h3><?=$this->language('l_anwserpopup')?></h3>
				</div>
				<div class="content">
					<div class="form_group clearfix">
						<div class="form_item">
							<p>
								<span><?=$this->language('l_nameproduct')?> : </span><a href="#"><?=$this->language('l_nameproduct')?></a>
							</p>
						</div>
						<div class="form_item">
							<input type="text" name="title" class="input full" value="" disabled="disabled" placeholder="<?=$this->language('l_Channel38')?>">
						</div>
						<div class="form_item">
							<textarea name="content" class="input full checkMaxLength" rows="8" maxlength="100" data-text="<?=$this->language('l_warnname')?>" placeholder="<?=$this->language('l_Channel39')?>"></textarea>
							<p class="height1 checkMaxLengthView" style="position: absolute;top: 285px;left: 280px;">0/100 <?= $this->language('l_warnname')?></p>
						</div>
					</div>
				</div>
				<div class="control">
					<input type="submit" class="btn full small hover" name="submit" value="등록완료">
				</div>
			</form>
		</div>

		<!-- Popup view detail in revenue -->
		<div class="absolute revenuedetail1 big">
			<form action="#" method="post">
				<div class="title">
					<h3><?=$this->language('l_revenue1')?></h3>
				</div>
				<div class="content">
					<table class="table">
						<thead>
							<tr>
								<th><?=$this->language('l_quantitysoldorder')?></th>
								<th><?=$this->language('l_amountsoldorder')?></th>
								<th><?=$this->language('l_quantitysoldcancel')?></th>
								<th><?=$this->language('l_amountsoldcancel')?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>100</td>
								<td>2.000.000</td>
								<td>98</td>
								<td>1.960.000</td>
							</tr>
						</tbody>
					</table>
				</div>
			</form>
		</div>
		<div class="absolute revenuedetail3 big">
			<form action="#" method="post">
				<div class="title">
					<h3><?=$this->language('l_revenue1')?></h3>
				</div>
				<div class="content">
					<table class="table">
						<thead>
							<tr>
								<th><?=$this->language('l_quantitysoldorder')?></th>
								<th><?=$this->language('l_amountsoldorder')?></th>
								<th><?=$this->language('l_quantitysoldcancel')?></th>
								<th><?=$this->language('l_amountsoldcancel')?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>100</td>
								<td>2.000.000</td>
								<td>98</td>
								<td>1.960.000</td>
							</tr>
						</tbody>
					</table>
				</div>
			</form>
		</div>
		<!-- Popup view detail in revenue -->
		<div class="absolute revenuedetail2 big" style="max-width: 750px;">
			<form action="#" method="post">
				<div class="title">
					<h3>
						 "<span>abcd</span>" <?=$this->language('l_revenue2')?>
					</h3>
					<p style="padding-top: 10px;"><?=$this->language('l_guiderecipe')?></p>
				</div>
				<div class="content">
					<table class="table">
						<thead>
							<tr>
								<th><?=$this->language('l_nameoption')?></th>
								<th><?=$this->language('l_quantitysoldorder')?></th>
								<th><?=$this->language('l_amountsoldorder')?></th>
								<th><?=$this->language('l_quantitysoldcancel')?></th>
								<th><?=$this->language('l_amountsoldcancel')?></th>
								<th><?=$this->language('l_quantitysoldreal')?></th>
								<th><?=$this->language('l_amountsoldreal')?></th>
								<th><?=$this->language('l_quantitysolduse')?></th>
								<th><?=$this->language('l_amountsolduse')?></th>
							</tr>
						</thead>
						<tbody id="revenuetoptionbody">
							<tr>
								<td>종일권</td>
								<td>100</td>
								<td>2.000.000</td>
								<td>10</td>
								<td>200.000</td>
								<td>90</td>
								<td>1.600.000</td>
								<td></td>
								<td></td>
							</tr>

						</tbody>
					</table>
				</div>
			</form>
		</div>		
		<!-- Popup view history settlementuserlog -->
		<div class="absolute revenuedetaillog big">
			<form action="#" method="post">
				<div class="title">
					<h3>정산서 히스토리</h3>
				</div>
				<div class="content" style="overflow: auto">
					<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>날짜</th>
								<th>상태</th>
								<th>작업자</th>
								<th>비고</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
				</div>
			</form>
		</div>
		<!-- Popup change time editticket2 -->
		<div class="absolute editTimeTicket">
			<form action="#" method="post">
				<div class="title">
					<h3>판매기간 일괄수정</h3>
				</div>
				<div class="content">
					<?php $start = date("Y-m-d");  $end = date("Y-m-t");?>
					<div class="form_group clearfix" style="text-align: center;"> 
						<div class="form_item" style="height: 30px">
							<p class="name">Trạng thái bán</p>
							<input type="radio" name="m_onSale" id="m_onSale1" class="input"  value="1" checked="checked"/>
							<label for="m_onSale1"><?= $this->language('l_status3') ?></label>
							<input type="radio" name="m_onSale" id="m_onSale0" class="input"  value="0" />
							<label for="m_onSale0"><?= $this->language('l_status_1') ?></label>
						</div>
						<div class="form_item">
							<p class="name"><?= $this->language('l_listproduct3') ?></p>
							<input type="text" name="m_useStartedAt" id="m_useStartedAt" class="input" onkeypress='validate(event)' value="<?=$start?>" readonly="readonly" />
						</div>
						<div class="form_item">
							<p class="name"><?= $this->language('l_listproduct4') ?></p>
							<input type="text" name="m_useEndedAt" id="m_useEndedAt" class="input" onkeypress='validate(event)' value="<?=$end?>" readonly="readonly"/>
						</div>
						
						<div class="form_item" id="divsaleStartedAt">
							<p class="name"><?= $this->language('l_addticket22') ?></p>
							<input type="text" name="m_saleStartedAt" id="m_saleStartedAt" class="input" onkeypress='validate(event)' value="<?=$start?>" readonly="readonly"/>
						</div>
						<div class="form_item" id="divsaleEndedAt" >
							<p class="name"><?= $this->language('l_addticket23') ?></p>
							<input type="text" name="m_saleEndedAt" id="m_saleEndedAt" class="input" onkeypress='validate(event)' value="<?=$end?>" readonly="readonly"/>
						</div>
					</div>
				</div>
				<div class="control">
					<input type="button" class="btn small hover back" style="width: 60px;" name="cancel" value="취소 ">
					<input type="button" class="btn full small hover" style="width: 60px;" name="submit"	id="btneditTime" value="확인 ">
				</div>
			</form>
		</div>
		<!-- Popup change price editticket2 -->
		<div class="absolute editPriceTicket">
			<form action="#" method="post">
				<div class="title">
					<h3>가격 일괄수정</h3>
				</div>
				<div class="content">
					<div class="form_group clearfix" style="text-align: center;">
						<div class="form_item">
							<div class="name"><?= $this->language('l_addticket20') ?></div> 
							<input type="text" name="m_price" id="m_price" class="input v-numericprice" onkeypress='validate(event)' value="0" />
						</div>
					</div>
				</div>
				<div class="control">
					<input type="button" class="btn small hover back" style="width: 60px;" name="cancel" value="취소 ">
					<input type="button" class="btn full small hover" style="width: 60px;" name="submit" id="btneditPrice" value="확인 ">
				</div>
			</form>
		</div>
		<!-- Popup change số lượng editticket2 -->
		<div class="absolute editAmountTicket ">
			<form action="#" method="post">
				<div class="title">
					<h3>수량 일괄수정</h3>
				</div>
				<div class="content">
					<div class="form_group clearfix" style="text-align: center;">
						<div class="form_item" >
							<div class="name"><?= $this->language('l_addticket21') ?></div>
							<input type="text" name="m_amount" id="m_amount" class="input v-numericprice" onkeypress='validate(event)' value="0" />
						</div>
					</div>
				</div>
				<div class="control">
					<input type="button" class="btn small hover back" style="width: 60px;" name="cancel" value="취소 ">
					<input type="button" class="btn full small hover" style="width: 60px;" name="submit" id="btneditAmount" value="확인 ">
				</div>
			</form>
		</div>
	<!--duyệt quyết toán-->
		<div class="absolute alert_approve ">
			<form action="#" method="post">
				<div class="title">
					<h3>경고</h3>
				</div>
				<div class="content">
					<div class="form_group clearfix" style="text-align: center;">
						<div class="form_item" >							
							<p>adasdasdas</p>
						</div>
					</div>
				<div class="control">
					<input type="button" class="btn small hover back" style="width: 60px;" name="cancel" value="취소 ">
					<input type="button" class="btn full small hover" style="width: 60px;" name="submit" id="btnApprove" value="확인">
				</div>
			</form>
		</div>

		<div class="absolute channelmatchtype" style="max-width: 785px;">
			<form action="#" method="post">
				<div class="title">
					<h3>채널사별 카테고리 매칭</h3>
				</div>
				<br/>
				<p>분류명 : <span id="spantypebridge">Vé > Du lịch trong nước > Vé > Công viên chủ đề</span></p>
				<div class="contentpopup">
					<ul id="divChannel">
						<li>Coupang</li>
						<li>Coupang</li>
						<li>Coupang</li>
					</ul>
					<ul id="divtypedepth1"></ul>
					<ul id="divtypedepth2"></ul>
					<ul id="divtypedepth3"></ul>
					<ul id="divtypedepth4"></ul>
				</div>
				<div class="control" style="text-align: center;">
					<input type="button" name="" class="btn hover small btnaddmatchtype" value="등록">	
				</div>
				<div class="contentpopup">
					<ul  style="width: 762px" id="divmathtype">
						<li data-typeId="0" data-channeltypeId="0" style="font-weight: bold;">선택채널/카테고리 ( N 개)</li>
						<li data-typeId="0" data-channeltypeId="0"></li>
					</ul>
				</div>
				<div class="control">
					<input type="button" name="" class="btn hover small btnmatchtype" value="매칭">	
				</div>
			</form>
		</div>
	</div>
	
		<!-- Popup điều chỉnh chi phí quyết toán -->
		<div class="absolute adjusted_settle" style="max-width: 450px;">
			<div class="title">
				<h3>정산서 업데이트</h3>
			</div>
			<br>
			<p style="line-height: 20px;">엑셀다운로드 후 상세 정보를 작성해서 엑셀업로드  해주세요.</p>
			<br>
			<div class="btn-group">
				<a class="btn btn-default" data-id="<?=$this->getItem('itemstatus', 'id')?>" id="Dwnld_Settlement_excel" style="margin-right: 5px;" href="<?=URL_TEMPLATE."settlementuser_adjusted.xlsx";?>">Download Excel</a>
				<a class="btn btn-default" id="Upld_Settle_Excel">Upload Excel</a>
				<input type="file" id="Upld_Settlement_excel" name="fileupload"  accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" style="display: none">
				<span id="load_file_name"><span style="font-size: 12px;float: left;padding: 10px"></span></span>
				<script>
					$("#Upld_Settlement_excel").change(function() {
						$('#load_file_name span').html(this.files[0].name);
					});
	  			</script>
			</div>
			<div class="control" style="margin-top: 20px">
				<input type="button" class="btn small hover back" style="width: 80px;" name="cancel" value="취소">
				<input type="button" class="btn full small hover" style="width: 80px;" name="submit" id="btnUpload_excel" data-id="<?=$this->getItem('itemstatus', 'id')?>" value="확인">
			</div>
		</div>
	<div class="popupClose"></div>
</div>