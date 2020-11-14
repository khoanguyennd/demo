<?php
$account = $_SESSION['accountshopping'];
$page = $this->getData('page');
$length = $this->getData('length');
$m_start = $this->getData('m_start');
$m_end = $this->getData('m_end');
$m_channel = $this->getData('m_channel');
$m_product = $this->getData('m_product');
$m_status = $this->getData('m_status');
$m_supplier = $this->getData('m_supplier');
$m_little = $this->getData('m_little');
$m_big = $this->getData('m_big');

$list_supplier = $this->getData('list_supplier');
$list_channel = $this->getData('list_channel');
$list_product = $this->getData('list_product');
$revenue = $this->getData('revenue');
$quantitysoldrealtotal = $this->getData('quantitysoldrealtotal');
$amountsoldrealtotal = $this->getData('amountsoldrealtotal');
$quantitysoldusetotal = $this->getData('quantitysoldusetotal');
$amountsoldusetotal = $this->getData('amountsoldusetotal');
$quantitysoldcanceltotal = $this->getData('quantitysoldcanceltotal');
$amountsoldcanceltotal = $this->getData('amountsoldcanceltotal');
?>

<link rel="stylesheet" type="text/css"
      href="<?= URL_PUBLIC ?>css/jquery-ui.css" />
<script type="text/javascript" src="<?= URL_PUBLIC ?>js/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $.onchangetime = function (name) {
            var d = new Date();
            $('input.datepick[name="m_end"]').val($.getFormattedDate(d.getFullYear(), (d.getMonth() + 1).toString(), d.getDate().toString()));
            $.datepickMilisecond('input.datepick[name="m_end"]');
            if (name == 'today') {
                d.setDate(d.getDate());
            }
            if (name == 'week') {
                d.setDate(d.getDate() - 7);
            }
            if (name == 'month') {
                d.setMonth(d.getMonth() - 1);
            }
            $('input.datepick[name="m_start"]').val($.getFormattedDate(d.getFullYear(), (d.getMonth() + 1).toString(), d.getDate().toString()));
            $.datepickMilisecond('input.datepick[name="m_start"]');
        }
        $('.changepick').on('click', function () {
            $(this).closest('td').find('input.btn').removeClass('active');
            $(this).addClass('active');
            $.onchangetime($(this).attr('name'));
        });

        // Hiển thị popup chi tiết 1
        $('table.table').on('click', 'a.vdetail1', function () {
            var counttotal = $(this).attr('data-counttotal');
            var sumtotal = $(this).attr('data-sumtotal');
            var countcancel = $(this).attr('data-countcancel');
            var sumcancel = $(this).attr('data-sumcancel');
            $.fn_popup(true, 'revenuedetail1', true);
            $($.elt_popup).find('.revenuedetail1 tbody').html('<tr><td>' + counttotal + '</td><td>' + sumtotal + '</td><td>' + countcancel + '</td><td>' + sumcancel + '</td></tr>');
            return false;
        });

        // Hiển thị popup chi tiết 3
        $('table.table').on('click', 'a.vdetail3', function () {
            var counttotal = $(this).attr('data-counttotal');
            var sumtotal = $(this).attr('data-sumtotal');
            var countcancel = $(this).attr('data-countcancel');
            var sumcancel = $(this).attr('data-sumcancel');
            $.fn_popup(true, 'revenuedetail3', true, false);
            $($.elt_popup).find('.revenuedetail3 tbody').html('<tr><td>' + counttotal + '</td><td>' + sumtotal + '</td><td>' + countcancel + '</td><td>' + sumcancel + '</td></tr>');
            return false;
        });
        // Hiển thị popup chi tiêt 2
        $('table.table').on('click', 'a.vdetail2', function () {
            var salechannelId = $(this).attr('data-salechannelId');
            var productname = $(this).attr('data-productname');

            $.fn_ajax('revenuetoption', {'salechannelId': salechannelId}, function (result) {
                $.fn_popup(true, 'revenuedetail2', true, false);
                $($.elt_popup).find('.revenuedetail2 tbody').html(result.revenuetoptiontbody);
                $($.elt_popup).find('.revenuedetail2 .title span').html(productname);
                return false;
            });


            return false;
        });



        // Thực hiện phân trang
        $('div.revenue').on('click', '.pagination a', function () {
            var length = $(this).attr('data-length');
            var page = $(this).attr('data-page');
            if (length && page) {
                $.fn_ajax('paginationdetail', {'page': page, 'length': length}, function (result) {
                    $.fn_result(result);
                }, true);
            }
            return false;
        });
        // Thay đổi số dòng hiển thị trên một trang
        $('div.revenue').on('change', 'select.select', function () {
            var length = $(this).val();
            if (length) {
                $.fn_ajax('paginationdetail', {'page': 1, 'length': length}, function (result) {
                    $.fn_result(result);
                }, true);
            }
            return false;
        });

        $('div.revenue').on('click', 'a.sort', function () {
            //alert($('select.select').val());
            var sort = $(this).attr('data-sort');
            var length = document.getElementById('selectlength').value;
            if (sort) {
                $.fn_ajax('paginationdetail', {'page': 1, 'length': length, 'sort': sort}, function (result) {
                    $.fn_result(result);
                }, true);
            }
            return false;
        });
        // Hàm xử lý kết quả trả về		
        $.fn_result = function (data) {
            if (data.flag == true) {
                document.getElementById('revenuetbody').innerHTML = data.revenuetbody;
                document.getElementById('divpaging').innerHTML = data.divpaging;
            }
        }

        // Thực hiện tại xuất file excel
        $('button.downloadExcel').on('click', function (result) {

            var tbody = $('#revenuetbody').find('td.empty');
            if (tbody.length > 0) {
                //
            } else {
                window.open(jsData.urlAjax + 'downloadDetailExcel');
            }

        });
    });
    window.onload = function () {
        document.multiselect('#channelSelect');
        document.multiselect('#productSelect');
    };
</script>
<div class="ct_head">
    <h3><?= $this->language('l_managerevenue1') ?></h3>
    <p>
        <?= date('m') ?>월<?= date('d') ?>일 <?= date('H') ?>시<?= date('i') ?>분 기준으로 수집된 매출내역입니다.(5분 단위 업데이트)  
        <a href="" class="btn small" onclick='document.getElementById("mform").submit();'><?= $this->language('l_update') ?></a>
    </p>
</div>
<div class="ct_content">
    <div class="form_group">
        <form class="search_member" action="<?= $this->route('revenuedetail', ['method' => 'detail']) ?>" method="POST" name="mform" id="mform">
            <table class="table">
                <tr>
                    <th><?= $this->language('l_timefind') ?></th>
                    <td colspan="3">
                        <input type="text" class="input datepick" name="m_start" value="<?= $m_start ?>" readonly="readonly" style="max-width: 100px;"> 
                        <span>~</span> 
                        <input type="text" class="input datepick" name="m_end" value="<?= $m_end ?>" readonly="readonly" style="max-width: 100px;">
                        <input type="button" class="btn changepick small" name="today" value="<?= $this->language('l_today') ?>">
                        <input type="button" class="btn small changepick" name="week" value="<?= $this->language('l_1week') ?>">
                        <input type="button" class="btn small changepick" name="month" value="<?= $this->language('l_1month') ?>">
                    </td>
                    <td rowspan="5" style="line-height: 40px; width: 100px;">
                        <input type="submit" class="btn small full hover" name="m_search" value="<?= $this->language('l_search') ?>"> 
                        <input type="submit" class="btn small full hover reset" name="m_reset" value="<?= $this->language('l_reset') ?>">
                    </td>
                </tr>
                <tr>
                    <th><?= $this->language('l_supplier') ?></th>
                    <td style="width: 260px;">
                        <select name="m_supplier" id="supplier" class="select small full">
                            <option <?php if ($m_supplier == 0) echo 'selected="selected"'; ?> value="0"><?= $this->language('l_question4') ?></option>	
                            <option <?php if ($m_supplier == $account['idx']) echo 'selected="selected"'; ?> value="<?= $account['idx'] ?>"><?= $account['ID'] ?></option>	
                            <?php foreach ($list_supplier as $value => $giatri) { ?>
                                <option <?php if ($m_supplier == $giatri['idx']) echo 'selected="selected"'; ?> value="<?= $giatri['idx'] ?>"><?= $giatri['ID'] ?></option>
                            <?php } ?>	
                        </select>
                    </td>
                    <th><?= $this->language('l_channelsell') ?></th>
                    <td>
                        <select class="select small full" name="m_channel[]" id='channelSelect' multiple>
                            <?php foreach ($list_channel as $value => $giatri) { ?>
                                <option <?php if (in_array($giatri[0], $m_channel)) echo 'selected="selected"'; ?> value='<?= $giatri[0] ?>'><?= $giatri[1] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><?= $this->language('l_status') ?></th>
                    <td colspan="3">
                        <ul class="clearfix">
                            <li>
                                <input <?php if ($m_status == 10) echo ' checked="checked"'; ?> type="radio" id="forstatus10" name="m_status" value="10"> 
                                <label for="forstatus10"><?= $this->language('l_status10') ?></label>
                            </li>
                            <li>
                                <input <?php if ($m_status == 0) echo ' checked="checked"'; ?> type="radio" id="forstatus0" name="m_status" value="0"> 
                                <label for="forstatus0"><?= $this->language('l_status0') ?></label>
                            </li>

                            <li style="display: none">
                                <input <?php if ($m_status == 1) echo ' checked="checked"'; ?> type="radio" id="forstatus1" name="m_status" value="1"> 
                                <label for="forstatus1"><?= $this->language('l_status1') ?></label>
                            </li>
                            <li>
                                <input <?php if ($m_status == 2) echo ' checked="checked"'; ?> type="radio" id="forstatus2" name="m_status" value="2"> 
                                <label for="forstatus2"><?= $this->language('l_status2') ?></label>
                            </li>
                            <li>
                                <input <?php if ($m_status == 3) echo ' checked="checked"'; ?> type="radio" id="forstatus3" name="m_status" value="3"> 
                                <label for="forstatus3"><?= $this->language('l_status3') ?></label>
                            </li>
                            <li>
                                <input <?php if ($m_status == -1) echo ' checked="checked"'; ?> type="radio" id="forstatus_1" name="m_status" value="-1"> 
                                <label for="forstatus_1"><?= $this->language('l_status_1') ?></label>
                            </li>
                            <li>
                                <input <?php if ($m_status == 4) echo ' checked="checked"'; ?> type="radio" id="forstatus4" name="m_status" value="4"> 
                                <label for="forstatus4"><?= $this->language('l_status4') ?></label>
                            </li>

                        </ul>

                    </td>
                </tr>
                <tr>
                    <th><?= $this->language('l_chooseproduct') ?></th>
                    <td><select class="select small full" name="m_product[]"
                                id='productSelect' multiple>
                                    <?php foreach ($list_product as $value => $giatri) { ?>
                                <option <?php if (in_array($giatri["sellerProductId"], $m_product)) echo 'selected="selected"'; ?> value="<?= $giatri["sellerProductId"] ?>"><?= $giatri['name'] ?></option>
                            <?php } ?>
                        </select></td>
                    <th><?= $this->language('l_quantitysoldreal') ?></th>
                    <td>
                        <input type="text" class="input" name="m_little" value="<?= $m_little ?>" style="max-width: 100px;" onkeypress='validate(event)'>
                        <span>~</span> 
                        <input type="text" class="input" name="m_big" value="<?= $m_big ?>" style="max-width: 100px;" onkeypress='validate(event)'>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="form_group clearfix revenue" >
        <div class="form_table">
            <div class="table_head bgwhite">
                <div class="ctrl_head clearfix">
                    <div class="title col-xs-12">
                        <h3><?= $this->language('l_synthetic') ?></h3>
                    </div>
                </div>
            </div>
            <div class="table_content">
                <table class="table" id="notification">
                    <thead>
                        <tr>
                            <th><?= $this->language('l_quantitysoldreal') ?></th>
                            <th><?= $this->language('l_amountsoldreal') ?></th>
                            <th><?= $this->language('l_quantitysolduse') ?></th>
                            <th><?= $this->language('l_amountsolduse') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <a href="#" title="" class="vdetail1" 
                                   data-counttotal="<?= ($quantitysoldrealtotal + $quantitysoldcanceltotal) ?>"
                                   data-sumtotal="<?= number_format($amountsoldrealtotal + $amountsoldcanceltotal) ?>"
                                   data-countcancel="<?= $quantitysoldcanceltotal ?>"
                                   data-sumcancel="<?= number_format($amountsoldcanceltotal) ?>"><?= $quantitysoldrealtotal ?></a>
                            </td>
                            <td><?= number_format($amountsoldrealtotal) ?></td>
                            <td><?php if ($quantitysoldusetotal != 0) echo $quantitysoldusetotal; ?></td>
                            <td><?php if ($amountsoldusetotal != 0) echo number_format($amountsoldusetotal); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br>
        <div class="form_table">
            <div class="table_head bgwhite">
                <div class="ctrl_head clearfix">
                    <div class="title col-xs-1">
                        <h3><?= $this->language('l_mbtotal') . $this->getData('total') ?> <?= $this->getData('count') ?> <?= $this->language('l_notification16') ?></h3>
                    </div>
                    <div class="icons col-xs-2">
                        <select name="" class="select" id="selectlength">
                            <option value="20"
                                    <?= (($this->getData('length') == 20) ? 'selected' : '') ?>>20 <?= $this->language('l_notification8') ?></option>
                            <option value="50"
                                    <?= (($this->getData('length') == 50) ? 'selected' : '') ?>>50 <?= $this->language('l_notification8') ?></option>
                            <option value="100"
                                    <?= (($this->getData('length') == 100) ? 'selected' : '') ?>>100 <?= $this->language('l_notification8') ?></option>
                        </select>
                    </div>
                    <div class="icons col-xs-2">
                        <button type="button" name="" class="btn hover downloadExcel"><?= $this->language('l_Channel26') ?></button>
                    </div>
                </div>
            </div>
            <div class="table_content clearfix">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?= $this->language('l_listproduct5') ?></th>
                            <th style="background: powderblue;"><a class="sort" data-sort="channelname"><?= $this->language('l_channelsell') ?></a></th>
                            <th style="background: powderblue;"><a class="sort" data-sort="suppliername"><?= $this->language('l_supplier') ?></a></th>
                            <th><?= $this->language('l_nameproduct') ?></th>
                            <th><?= $this->language('l_status') ?></th>
                            <th><?= $this->language('l_listproduct3') ?></th>
                            <th><?= $this->language('l_listproduct4') ?></th>
                            <th style="background: powderblue;"><a class="sort" data-sort="quantitysoldreal"><?= $this->language('l_quantitysoldreal') ?></a></th>
                            <th style="background: powderblue;"><a class="sort" data-sort="amountsoldreal"><?= $this->language('l_amountsoldreal') ?></a></th>
                            <th><?= $this->language('l_quantitysolduse') ?></th>
                            <th><?= $this->language('l_amountsolduse') ?></th>
                        </tr>
                    </thead>
                    <tbody id="revenuetbody">
                        <?php
                        $vitri = ($page - 1) * $length;
                        foreach ($revenue as $value => $giatri) {
                            $vitri++;
                            ?>
                            <tr>
                                <td><?= $vitri ?></td>
                                <td><?= $giatri['channelname'] ?></td>
                                <td><?= $giatri['suppliername'] ?></td>
                                <td>
                                    <a href="#" class="vdetail2" 
                                       data-salechannelId="<?= $giatri['salechannelId'] ?>" 
                                       data-productname="<?= $giatri['productname'] ?>"><?= $giatri['productname'] ?></a>
                                </td>
                                <td>
                                    <?php
                                    if ($giatri["status"] == 0)
                                        echo $this->language("l_status0");
                                    if ($giatri["status"] == 1)
                                        echo $this->language("l_status1");
                                    if ($giatri["status"] == 2)
                                        echo $this->language("l_status2");
                                    if ($giatri["status"] == 3)
                                        echo $this->language("l_status3");
                                    if ($giatri["status"] == 4)
                                        echo $this->language("l_status4");
                                    if ($giatri["status"] == - 1)
                                        echo $this->language("l_status_1");
                                    ?>
                                </td>
                                <td><?= $giatri['useStartedAt'] ?></td>
                                <td><?= $giatri['useEndedAt'] ?></td>
                                <td><a href="#" class="vdetail3"
                                       data-counttotal="<?= ($giatri['quantitysoldreal'] + $giatri['quantitysoldcancel']) ?>"
                                       data-sumtotal="<?= number_format($giatri['amountsoldreal'] + $giatri['amountsoldcancel']) ?>"
                                       data-countcancel="<?= $giatri['quantitysoldcancel'] ?>"
                                       data-sumcancel="<?= number_format($giatri['amountsoldcancel']) ?>"

                                       ><?= $giatri['quantitysoldreal'] ?></a></td>
                                <td><?= number_format($giatri['amountsoldreal']) ?></td>
                                <td><?php if ($giatri['quantitysolduse'] != 0) echo $giatri['quantitysolduse'] ?></td>
                                <td><?php if ($giatri['amountsolduse'] != 0) echo number_format($giatri['amountsolduse']); ?></td>
                            </tr>
                            <?php
                        }
                        if ($this->getData('count') == 0)
                            echo '<tr><td colspan="11" class="empty">' . $this->language("l_rowemptydata") . '</td></tr>';
                        ?>
                    </tbody>
                </table>
            </div>

            <div id="divpaging">
                <?= $this->getData('pagination') ?>
            </div>
        </div>
    </div>
</div>