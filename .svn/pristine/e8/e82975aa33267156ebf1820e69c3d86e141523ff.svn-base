<?php
$list_supplier = $this->getData('list_supplier');
$list_channel = $this->getData('list_channel');

$statusTicket = $this->getData('statusTicket');
$m_start = $this->getData('m_start');
$m_end = $this->getData('m_end');
$m_supplier = $this->getData('m_supplier');
$m_channel = $this->getData('m_channel');
$m_restore = $this->getData('m_restore');
$m_status1 = $this->getData('m_status1');
$m_status2 = $this->getData('m_status2');
$m_status3 = $this->getData('m_status3');
$m_status4 = $this->getData('m_status4');
$m_key = $this->getData('m_key');
$m_name = $this->getData('m_name');

$text_ten_phone_mave = $this->getData('text_ten_phone_mave');
$thoigian = $this->getData('thoigian');
$text_input_boloc = $this->getData('text_input_boloc');
$ncc_id=$this->getData('ncc_id');
$mang_kenh=$this->getData('mang_kenh');

?>
<link rel="stylesheet" type="text/css" href="<?= URL_PUBLIC ?>css/jquery-ui.css" />
<script type="text/javascript" src="<?= URL_PUBLIC ?>js/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $.onchangetime = function (name) {
            var d = new Date();
            $('input.datepick[name="dateend"]').val($.getFormattedDate(d.getFullYear(), (d.getMonth() + 1).toString(), d.getDate().toString()));
            $.datepickMilisecond('input.datepick[name="dateend"]');
            if (name == 'week') {
                d.setDate(d.getDate() - 7);
            }
            if (name == 'today') {
                d.setDate(d.getDate());
            }
            if (name == 'month') {
                d.setMonth(d.getMonth() - 1);
            }
            if (name == 'threemonth') {
                d.setMonth(d.getMonth() - 3);
            }
            $('input.datepick[name="datestart"]').val($.getFormattedDate(d.getFullYear(), (d.getMonth() + 1).toString(), d.getDate().toString()));
            $.datepickMilisecond('input.datepick[name="datestart"]');
        }
        $('.changepick').on('click', function () {
            $(this).closest('td').find('input.btn').removeClass('active');
            $(this).addClass('active');
            $.onchangetime($(this).attr('name'));
        });
        //$('.btn.changepick[name="today"]').click();

        // Hiển thị popup chi tiết 1
        $('table.table').on('click', 'a.vdetail1', function () {
            $.fn_popup(true, 'revenue1');
            return false;
        });
        // Hiển thị popup chi tiêt 2
        $('table.table').on('click', 'a.vdetail2', function () {
            $.fn_popup(true, 'revenue2');
            return false;
        });
        // Thực hiện phân trang
        $('div.ct_content').on('click', '.pagination a', function () {
            var length = $(this).attr('data-length');
            var page = $(this).attr('data-page');
            if (length && page) {
                $.fn_ajax('searchAndPaginationMobi', {'page': page, 'length': length}, function (result) {
                    $.fn_result(result);
                    return false;
                }, true);
            }
            return false;
        });
        // Thay đổi số dòng hiển thị trên một trang
        $('div.order').on('change', 'select.select', function () {
            var length = $(this).val();
            var page = 1;
            if (length && page) {
                $.fn_ajax('searchAndPagination', {'page': page, 'length': length}, function (result) {
                    $.fn_result(result);
                    return false;
                }, true);
            }
            return false;
        });

        // Hàm xử lý kết quả trả về		
        $.fn_result = function (data) {
            if (data.flag == true) {
                $('#tableorder tbody').html(data.rows);
                $('div.ct_content .pagination').closest('div.form_group').remove();
                $('div.ct_content').append(data.pagination);
            }
        }
        // Thực hiện lựa chọn tất cả trong bảng
        $('#tbcheckall').on('click', function () {
            var checked = $(this).get(0).checked;
            $('#tableorder tbody input[type="checkbox"]').each(function () {
                $(this).get(0).checked = checked
            });
        });
        // Thực hiện sử dụng
        $('#confirmuse').on('click', function () {
            var data = $.fn_dataChecked(1, '<?= $this->language('l_orderwarning1') ?>');
            if (data && data.length > 0) {
                if ($(this).attr('data-action') == 'true' && $($.elt_popup + ' .confirm').is(':visible')) {
                    $.fn_confirm(false);
                    $.fn_changestatus(data);
                    $(this).removeAttr('data-action');
                } else {
                    $.fn_confirm(true, {'class': 'changestatus', 'data-action': 'confirmuse'}, '<?= $this->language('l_orderwarning3') ?>');
                    $($.elt_popup).find('.back').val("취소");
                    $($.elt_popup).find('.continue').val("확인");
                    $(this).attr('data-action', 'true');
                }
            }
        });
        // Thực hiện khôi phục
        $('#confirmrestore').on('click', function () {
            var data = $.fn_dataChecked(2, '<?= $this->language('l_orderwarning2') ?>');
            if (data && data.length > 0) {
                if ($(this).attr('data-action') == 'true' && $($.elt_popup + ' .confirm').is(':visible')) {
                    $.fn_confirm(false);
                    $.fn_changestatus(data);
                    $(this).removeAttr('data-action');
                } else {
                    $.fn_confirm(true, {'class': 'changestatus', 'data-action': 'confirmrestore'}, '<?= $this->language('l_orderwarning4') ?>');
                    $($.elt_popup).find('.back').val("취소");
                    $($.elt_popup).find('.continue').val("확인");
                    $(this).attr('data-action', 'true');
                }
            }
        });
        // Thực hiện thay đổi từng dòng
        $('#tableorder tbody input[type="button"]').on('click', function () {
            var element = $(this).closest('tr');
            var status = $(element).attr('data-status');
            if (status > -1 && status < 3) {
                $(element).find('input[type="checkbox"]').get(0).checked = true;
                if (status == 1) {
                    $('#confirmuse').click();
                } else {
                    $('#confirmrestore').click();
                }
            }
        });
        // Tiếp tục thực hiện thay đổi trạng thái
        $($.elt_popup).on('click', '.confirm .changestatus .continue', function () {
            $('#' + $(this).attr('data-action')).click();
        });
        $.fn_dataChecked = function (status, contentAlert) {
            var formdata = [];
            var elemnt = '#tableorder tbody input[type="checkbox"]:checked';
            if ($(elemnt).length > 0) {
                $(elemnt).each(function () {
                    var tbtr = $(this).closest('tr');
                    var cid = $(tbtr).attr('data-id');
                    var cstatus = $(tbtr).attr('data-status');
                    var crestore = $(tbtr).attr('data-restore');
                    if (status == cstatus) {
                        formdata.push({'id': cid, 'status': cstatus, 'restore': crestore});
                    } else {
                        $.fn_alert(true, true, contentAlert);
                        formdata = [];
                        return false;
                    }
                });
            } else {
                $.fn_alert(true, true, '<?= $this->language('l_listproduct7') ?>');
            }
            return formdata;
        }
        $.fn_changestatus = function (data) {
            $.fn_ajax('changeStatus', {'status': data}, function (result) {
                if (result.flag == true) {
                    $.each(result.id, function (index, value) {
                        var element = '#tableorder tbody tr[data-id="' + value + '"]';
                        $(element).attr({
                            'data-status': result.statusid[index],
                            'data-restore': result.restoreid[index]
                        });
                        $(element).find('input[type="checkbox"]').get(0).checked = false;
                        $(element).find('input[type="button"]').val(result.action);
                        $(element).find('td:nth-child(2)').text(result.status);
                        $(element).find('td:nth-child(3)').text(result.restore);
                    });
                }
            }, true);
        }
        // Thực hiện tại xuất file excel
        $('button.downloadExcel').on('click', function (result) {
            var tbody = $('.table').find('td.empty');
            if (tbody.length > 0) {
                //
            } else {
                var titleName = $('#contents .ct_head h3').text();
                var description = $('#contents .ct_head p').text();
                if (titleName && description) {
                    window.open(encodeURI(jsData.urlAjax + 'downloadExcel?titleName=' + titleName + '&description=' + description));
                }
            }

        });
    });
    window.onload = function () {
        document.multiselect('#channelSelect');
    };





</script>
<link rel="stylesheet" type="text/css" href="<?= URL_PUBLIC ?>css/jquery-ui.css" />
<script type="text/javascript" src="<?= URL_PUBLIC ?>js/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $.onchangetime = function (name) {
            var d = new Date();
            $('input.datepick[name="dateend"]').val($.getFormattedDate(d.getFullYear(), (d.getMonth() + 1).toString(), d.getDate().toString()));
            $.datepickMilisecond('input.datepick[name="dateend"]');
            if (name == 'week') {
                d.setDate(d.getDate() - 7);
            }
            if (name == 'today') {
                d.setDate(d.getDate());
            }
            if (name == 'month') {
                d.setMonth(d.getMonth() - 1);
            }
            if (name == 'threemonth') {
                d.setMonth(d.getMonth() - 3);
            }
            $('input.datepick[name="datestart"]').val($.getFormattedDate(d.getFullYear(), (d.getMonth() + 1).toString(), d.getDate().toString()));
            $.datepickMilisecond('input.datepick[name="datestart"]');
        }
        $('.changepick').on('click', function () {
            $(this).closest('td').find('input.btn').removeClass('active');
            $(this).addClass('active');
            $.onchangetime($(this).attr('name'));
        });
        //$('.btn.changepick[name="today"]').click();

        // Hiển thị popup chi tiết 1
        $('table.table').on('click', 'a.vdetail1', function () {
            $.fn_popup(true, 'revenue1');
            return false;
        });
        // Hiển thị popup chi tiêt 2
        $('table.table').on('click', 'a.vdetail2', function () {
            $.fn_popup(true, 'revenue2');
            return false;
        });
        // Thực hiện phân trang
        $('div.ct_content').on('click', '.pagination a', function () {
            var length = $(this).attr('data-length');
            var page = $(this).attr('data-page');
            if (length && page) {
                $.fn_ajax('searchAndPagination', {'page': page, 'length': length}, function (result) {
                    $.fn_result(result);
                    return false;
                }, true);
            }
            return false;
        });
        // Thay đổi số dòng hiển thị trên một trang
        $('div.order').on('change', 'select.select', function () {
            var length = $(this).val();
            var page = 1;
            if (length && page) {
                $.fn_ajax('searchAndPagination', {'page': page, 'length': length}, function (result) {
                    $.fn_result(result);
                    return false;
                }, true);
            }
            return false;
        });

        // Hàm xử lý kết quả trả về		
        $.fn_result = function (data) {
            if (data.flag == true) {
                $('#tableorder tbody').html(data.rows);
                $('div.ct_content .pagination').closest('div.form_group').remove();
                $('div.ct_content').append(data.pagination);
            }
        }
        // Thực hiện lựa chọn tất cả trong bảng
        $('#tbcheckall').on('click', function () {
            var checked = $(this).get(0).checked;
            $('#tableorder tbody input[type="checkbox"]').each(function () {
                $(this).get(0).checked = checked
            });
        });
        // Thực hiện sử dụng
        $('#confirmuse').on('click', function () {
            var data = $.fn_dataChecked(1, '<?= $this->language('l_orderwarning1') ?>');
            if (data && data.length > 0) {
                if ($(this).attr('data-action') == 'true' && $($.elt_popup + ' .confirm').is(':visible')) {
                    $.fn_confirm(false);
                    $.fn_changestatus(data);
                    $(this).removeAttr('data-action');
                } else {
                    $.fn_confirm(true, {'class': 'changestatus', 'data-action': 'confirmuse'}, '<?= $this->language('l_orderwarning3') ?>');
                    $($.elt_popup).find('.back').val("취소");
                    $($.elt_popup).find('.continue').val("확인");
                    $(this).attr('data-action', 'true');
                }
            }
        });
        // Thực hiện khôi phục
        $('#confirmrestore').on('click', function () {
            var data = $.fn_dataChecked(2, '<?= $this->language('l_orderwarning2') ?>');
            if (data && data.length > 0) {
                if ($(this).attr('data-action') == 'true' && $($.elt_popup + ' .confirm').is(':visible')) {
                    $.fn_confirm(false);
                    $.fn_changestatus(data);
                    $(this).removeAttr('data-action');
                } else {
                    $.fn_confirm(true, {'class': 'changestatus', 'data-action': 'confirmrestore'}, '<?= $this->language('l_orderwarning4') ?>');
                    $($.elt_popup).find('.back').val("취소");
                    $($.elt_popup).find('.continue').val("확인");
                    $(this).attr('data-action', 'true');
                }
            }
        });
        // Thực hiện thay đổi từng dòng
        $('#tableorder tbody input[type="button"]').on('click', function () {
            var element = $(this).closest('tr');
            var status = $(element).attr('data-status');
            if (status > -1 && status < 3) {
                $(element).find('input[type="checkbox"]').get(0).checked = true;
                if (status == 1) {
                    $('#confirmuse').click();
                } else {
                    $('#confirmrestore').click();
                }
            }
        });
        // Tiếp tục thực hiện thay đổi trạng thái
        $($.elt_popup).on('click', '.confirm .changestatus .continue', function () {
            $('#' + $(this).attr('data-action')).click();
        });
        $.fn_dataChecked = function (status, contentAlert) {
            var formdata = [];
            var elemnt = '#tableorder tbody input[type="checkbox"]:checked';
            if ($(elemnt).length > 0) {
                $(elemnt).each(function () {
                    var tbtr = $(this).closest('tr');
                    var cid = $(tbtr).attr('data-id');
                    var cstatus = $(tbtr).attr('data-status');
                    var crestore = $(tbtr).attr('data-restore');
                    if (status == cstatus) {
                        formdata.push({'id': cid, 'status': cstatus, 'restore': crestore});
                    } else {
                        $.fn_alert(true, true, contentAlert);
                        formdata = [];
                        return false;
                    }
                });
            } else {
                $.fn_alert(true, true, '<?= $this->language('l_listproduct7') ?>');
            }
            return formdata;
        }
        $.fn_changestatus = function (data) {
            $.fn_ajax('changeStatus', {'status': data}, function (result) {
                if (result.flag == true) {
                    $.each(result.id, function (index, value) {
                        var element = '#tableorder tbody tr[data-id="' + value + '"]';
                        $(element).attr({
                            'data-status': result.statusid[index],
                            'data-restore': result.restoreid[index]
                        });
                        $(element).find('input[type="checkbox"]').get(0).checked = false;
                        $(element).find('input[type="button"]').val(result.action);
                        $(element).find('td:nth-child(2)').text(result.status);
                        $(element).find('td:nth-child(3)').text(result.restore);
                    });
                }
            }, true);
        }
        // Thực hiện tại xuất file excel
        $('button.downloadExcel').on('click', function (result) {
            var tbody = $('.table').find('td.empty');
            if (tbody.length > 0) {
                //
            } else {
                var titleName = $('#contents .ct_head h3').text();
                var description = $('#contents .ct_head p').text();
                if (titleName && description) {
                    window.open(encodeURI(jsData.urlAjax + 'downloadExcel?titleName=' + titleName + '&description=' + description));
                }
            }

        });
    });
    window.onload = function () {
        document.multiselect('#channelSelect');
    };
</script>
<div class="ct_content">
    <div class="form_group clearfix order" style="padding: 5px;">		
        <div class="t_header_qldh">
            <a href="<?= $this->route('dashboard') ?>">
                <img src="<?= URL_PUBLIC ?>temple_mobile/img/back.png" alt=""/>
            </a>
            <h2><?= $this->language('l_manageorder') ?></h2>
        </div>
        <div class="t_menu_qldh">
            <ul>
                <li><a href="<?=$this->route('order', ['method'=>'sale'])?>"><?=$this->language("l_toanbo")?></a></li>
                <li <?php if($statusTicket==1){?>class="t_active"<?php }?>><a href="<?=$this->route('orderstatus')?>/1"><?=$this->language("l_orderdone")?></a></li>
                <li <?php if($statusTicket==2){?>class="t_active"<?php }?>><a href="<?=$this->route('orderstatus')?>/2"><?=$this->language("l_orderusedone")?></a></li>
                <li <?php if($statusTicket==3){?>class="t_active"<?php }?>><a href="<?=$this->route('orderstatus')?>/3"><?=$this->language("l_orderreturnprice")?></a></li>
                <li <?php if($statusTicket==-1){?>class="t_active"<?php }?>><a href="<?=$this->route('orderstatus')?>/-1"><?=$this->language("l_orderdie")?></a></li>                
            </ul>
        </div>
        <div class="t_search_qldh">
            <form action="<?= $this->route('order', ['method' => 'sale']) ?>" method="POST">
                <p><input type="text" name="text_ten_phone_mave" id="text_ten_phone_mave" value="" placeholder="<?=$this->language("l_textsearch")?>" /></p>
                <p class="t_qldh_p_select" id="myBtn" style="position: relative;">
                    <input style="text-align: center;" type="text" id="show_text_search" value="<?=$text_input_boloc?>" disabled="" />
                    <img style="position: absolute; top: 17px; right: 9px; width: 25px;" src="<?= URL_PUBLIC ?>temple_mobile/img/ic_boloc.png" alt=""/>
                </p>
                <!-- The Modal -->
                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h3><?=$this->language("l_dieukien")?>  &nbsp;&nbsp;<input class="button_reset" type="button" value="Reset" /></h3>
                        <div class="tt_search">
                            <h4><?=$this->language("l_timefind")?></h4>
                            <input name="thoigian" type="radio" id="toanbo" value="0" checked="checked" />
                            <input name="thoigian" type="radio" id="homqua" value="1" />
                            <input name="thoigian" type="radio" id="homnay" value="2" />
                            <input name="thoigian" type="radio" id="7ngay" value="3" />
                            <input name="thoigian" type="radio" id="1thang" value="4" />
                            <input name="thoigian" type="radio" id="3thang" value="5" />
                            <input name="thoigian" type="radio" id="6thang" value="6" />
                            <input name="thoigian" type="radio" id="tructiep" value="7" />
                            <p class="toanbo selected"><?=$this->language("l_toanbo")?></p>
                            <p class="homqua"><?=$this->language("l_homqua")?></p>
                            <p class="homnay"><?=$this->language("l_homnay")?></p>
                            <p class="7ngay" style="margin-right: 0px; width: 25%;"><?=$this->language("l_7ngay")?></p>
                            <p class="1thang"><?=$this->language("l_1thang")?></p>
                            <p class="3thang"><?=$this->language("l_3thang")?></p>
                            <p class="6thang"><?=$this->language("l_6thang")?></p>
                            <p class="tructiep" style="margin-right: 0px; width: 25%;">
                                <?=$this->language("l_tructiep")?>
                            </p><div style="clear: both;"></div>
                            <div class="divdate" style="background: #d9d9d9; padding: 10px;">
                                <div style="width: 32%; margin-right: 2%; float: left;">
                                    <b style="font-size: 18px;"><?=$this->language("l_tructiepthoigian")?></b>
                                </div>
                                <div style="width: 30%; margin-right: 2%; float: left;">
                                    <input name="datestart" class="datepick" style="width: 100%; height: 30px;" type="text" value="<?=date('Y-m-d')?>" />
                                </div>
                                <div style="width: 2%; float: left; height: 30px; line-height: 30px; margin-right: 2%;">-</div>
                                <div style="width: 30%; float: left;">
                                    <input name="dateend" class="datepick" style="width: 100%; height: 30px;" type="text" value="<?=date('Y-m-d')?>" />
                                </div><div class="cl"></div>
                            </div>
                        </div>
                        <div class="k_search">
                            <h4><?=$this->language("l_kenhsearch")?></h4>
                            <p id="pchannel0" class="selectedkenh" onclick="mycheckbox(0, <?= count($list_channel) ?>)">
                                <input class="checked_kenh" name="checked_kenh[]" id="channel0" type="checkbox" checked="checked" value="0_Toàn bộ"/> <?=$this->language("l_toanbo")?>
                            </p>
                            <?php $i = 1; ?>
                            <?php foreach ($list_channel as $value => $giatri) { ?>
                                <p id="pchannel<?= $i ?>" onclick="mycheckbox(<?= $i ?>, <?= count($list_channel) ?>)">
                                    <input class="checked_kenh" name="checked_kenh[]" id="channel<?= $i ?>" type="checkbox" value="<?= $giatri['channel_id'] . "_" . $giatri['channel_name'] ?>"/> 
                                    <?= $giatri['channel_name'] ?>
                                </p>
                                <?php
                                $i++;
                            }
                            ?>
                        </div><div class="cl"></div>
                        <div id="ncc_search" class="ncc_search">
                            <h4><?=$this->language("l_supplier")?></h4>
                            <p id="ncc0" onclick="selectncc(0,<?php echo count($list_supplier); ?>)" class="selectedncc">
                                <input type="radio" name="check_ncc" id="nccinput0" checked="checked" value="0_Toàn bộ"/> <?=$this->language("l_toanbo")?>
                            </p>
                            <?php $i = 1; ?>
                            <?php foreach ($list_supplier as $value => $giatri) { ?>
                                <p id="ncc<?= $i ?>" onclick="selectncc(<?= $i ?>,<?php echo count($list_supplier); ?>)">
                                    <input name="check_ncc" id="nccinput<?= $i ?>" type="radio" value="<?= $giatri['idx'] . "_" . $giatri['company'] ?>"/> 
                                    <?= $giatri['company'] ?>
                                </p>
                                <?php
                                $i++;
                            }
                            ?><div class="cl"></div>
                        </div>
                        <div class="div_apdung_search">
                            <input class="apdung_search" type="button" value="<?=$this->language("l_apdung")?>" />
                        </div>
                        <div class="cl"></div>
                    </div>
                </div>
                <!-- end The Modal -->
                <input type="submit" name="m_search_mobi" class="btn_submit_search" value="" />
                <div class="cl"></div>
            </form>
        </div>
        <div class="table_head bgwhite">
            <div class="ctrl_head clearfix">
                <div class="title t_action">
                    <p class="p_t_action_1"><?= $this->language('l_mbtotal') . $this->getData('total') ?> <?= $this->language('l_notification16') ?></p>
                    <p class="p_t_action_2">      
                        <button type="button" name="confirmuse" id="confirmuse" class="btn hover"><?= $this->language('l_confirmuse') ?></button>
                        <button type="button" name="confirmrestore" id="confirmrestore" class="btn hover"><?= $this->language('l_confirmrestore') ?></button>
                    </p>
                </div>
            </div>
        </div>
        <table class="table" id="tableorder">
            <!--<thead>
                <tr>
                    <th><input type="checkbox" name="checkbox" id="tbcheckall" value="all"></th>
                    <th>&nbsp;</th>						
                </tr>
            </thead>-->
            <style>                
                .table tr{background: #fff !important; margin-bottom: 10px !important; border: 1px solid #a9a9a9;}
                .table td{text-align: left; padding-left: 10px; border: 0px;}
            </style>
            <tbody>                        
                <?=$this->getData('ordertbody')?>   
            </tbody>
        </table>

    </div>
    <?= $this->getData('pagination') ?>
</div>
<script>
    function selectncc(giatri, countlist) {
        $('input:radio[name=ncc_search]').each(function () {
            $(this).prop('checked', false);
        });
        for (var i = 0; i < countlist + 1; i++) {
            $("#ncc" + i).removeClass('selectedncc');
        }
        $("#ncc" + giatri).addClass('selectedncc');
        document.getElementById("nccinput" + giatri).checked = true;
    }
</script>
<script language="javascript">
    function mycheckbox(vitri, soluong) {
        //$("#pchannel" + vitri).addClass('selected');
        //$("#channel"+vitri).prop('checked', true);
        if (vitri == 0) {
            for (var i = 1; i < soluong + 1; i++) {
                $("#channel" + i).prop('checked', false);
                $("#pchannel" + i).removeClass('selectedkenh');
            }
        } else {
            var checkBox = document.getElementById("channel" + vitri);
            if (checkBox.checked == true) {
                $("#pchannel" + vitri).removeClass('selectedkenh');
                $("#channel" + vitri).prop('checked', false);
            } else {
                $("#pchannel" + vitri).addClass('selectedkenh');
                $("#channel" + vitri).prop('checked', true);
            }
            $("#pchannel0").removeClass('selectedkenh');
            $("#channel0").prop('checked', false);
        }
        //alert(vitri);
        var checkBox = document.getElementById("channel" + vitri);
        if (checkBox.checked == true) {
            $("#pchannel" + vitri).addClass('selectedkenh');
            $("#channel" + vitri).prop('checked', true);
        } else {
            $("#pchannel" + vitri).removeClass('selectedkenh');
            $("#channel" + vitri).prop('checked', false);
        }


        var flag = 0;
        for (var i = 0; i < soluong + 1; i++) {
            var checkBox = document.getElementById("channel" + i);
            if (checkBox.checked == true) {
                flag = 1;
            }
        }
        if (flag == 0) {
            $("#pchannel0").addClass('selectedkenh');
            $("#channel0").prop('checked', true);
        }
    }
</script>
<script>
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function () {
        modal.style.display = "block";
    }
    span.onclick = function () {
        modal.style.display = "none";
    }
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<script>
    $(document).ready(function () {
        $(".apdung_search").click(function () {
            var thoigian;
            var radios = document.getElementsByName('thoigian');
            for (var i = 0, length = radios.length; i < length; i++) {
                if (radios[i].checked) {
                    thoigian = radios[i].value;
                }
            }
            var text_show_thoigian = "";
            if (thoigian == 0) {
                text_show_thoigian = "Toàn bộ";
            }
            if (thoigian == 1) {
                text_show_thoigian = "Hôm qua";
            }
            if (thoigian == 2) {
                text_show_thoigian = "Hôm nay";
            }
            if (thoigian == 3) {
                text_show_thoigian = "7 ngày gần nhất";
            }
            if (thoigian == 4) {
                text_show_thoigian = "1 tháng gần nhất";
            }
            if (thoigian == 5) {
                text_show_thoigian = "3 tháng gần nhất";
            }
            if (thoigian == 6) {
                text_show_thoigian = "6 tháng gần nhất";
            }
            if (thoigian == 7) {
                text_show_thoigian = "Nhập trực tiếp";
            }

            var checked_kenh = "";
            var checked_kenh_name = "";
            var inputElements = document.getElementsByClassName('checked_kenh');
            for (var i = 0; inputElements[i]; ++i) {
                if (inputElements[i].checked) {
                    var str = inputElements[i].value;
                    var res = str.split("_");
                    checked_kenh = checked_kenh + res[0] + ",";
                    checked_kenh_name = checked_kenh_name + res[1] + ",";
                }
            }
            var check_ncc = "";
            var check_ncc_name = "";
            var radios = document.getElementsByName('check_ncc');
            for (var i = 0, length = radios.length; i < length; i++) {
                if (radios[i].checked) {
                    var str = radios[i].value;
                    var res = str.split("_");
                    check_ncc = res[0];
                    check_ncc_name = res[1];
                }
            }
            document.getElementById("show_text_search").value = "#" + text_show_thoigian + " # " + checked_kenh_name + " # " + check_ncc_name;
            document.getElementById("myModal").style.display = "none";
        });// end button apdung

        $(".button_reset").click(function () {
            document.getElementById("toanbo").checked = true;
            document.getElementById("homqua").checked = false;
            document.getElementById("homnay").checked = false;
            document.getElementById("7ngay").checked = false;
            document.getElementById("1thang").checked = false;
            document.getElementById("3thang").checked = false;
            document.getElementById("6thang").checked = false;
            document.getElementById("tructiep").checked = false;
            $(".selected").removeClass('selected');
            $(".toanbo").addClass('selected');
            $('.divdate').css("display", "none");

            for (var k = 0; k <<?= count($list_channel) ?> + 1; k++) {
                if (k == 0) {
                    $("#pchannel" + k).addClass('selectedkenh');
                    $("#channel" + k).prop('checked', true);
                } else {
                    $("#pchannel" + k).removeClass('selectedkenh');
                    $("#channel" + k).prop('checked', false);
                }

            }
            for (var j = 0; j <<?= count($list_supplier) ?> + 1; j++) {
                if (j == 0) {
                    $("#ncc" + j).addClass('selectedncc');
                    document.getElementById("nccinput" + j).checked = true;
                } else {
                    $("#ncc" + j).removeClass('selectedncc');
                    document.getElementById("nccinput" + j).checked = false;
                }
            }

        });// end button reset

        $(".toanbo").click(function () {
            document.getElementById("toanbo").checked = true;
            document.getElementById("homqua").checked = false;
            document.getElementById("homnay").checked = false;
            document.getElementById("7ngay").checked = false;
            document.getElementById("1thang").checked = false;
            document.getElementById("3thang").checked = false;
            document.getElementById("6thang").checked = false;
            document.getElementById("tructiep").checked = false;
            $(".selected").removeClass('selected');
            $(this).addClass('selected');
            $('.divdate').css("display", "none");
        });
        $(".homqua").click(function () {
            document.getElementById("toanbo").checked = false;
            document.getElementById("homqua").checked = true;
            document.getElementById("homnay").checked = false;
            document.getElementById("7ngay").checked = false;
            document.getElementById("1thang").checked = false;
            document.getElementById("3thang").checked = false;
            document.getElementById("6thang").checked = false;
            document.getElementById("tructiep").checked = false;
            $(".selected").removeClass('selected');
            $(this).addClass('selected');
            $('.divdate').css("display", "none");
        });
        $(".homnay").click(function () {
            document.getElementById("toanbo").checked = false;
            document.getElementById("homqua").checked = false;
            document.getElementById("homnay").checked = true;
            document.getElementById("7ngay").checked = false;
            document.getElementById("1thang").checked = false;
            document.getElementById("3thang").checked = false;
            document.getElementById("6thang").checked = false;
            document.getElementById("tructiep").checked = false;
            $(".selected").removeClass('selected');
            $(this).addClass('selected');
            $('.divdate').css("display", "none");
        });
        $(".7ngay").click(function () {
            document.getElementById("toanbo").checked = false;
            document.getElementById("homqua").checked = false;
            document.getElementById("homnay").checked = false;
            document.getElementById("7ngay").checked = true;
            document.getElementById("1thang").checked = false;
            document.getElementById("3thang").checked = false;
            document.getElementById("6thang").checked = false;
            document.getElementById("tructiep").checked = false;
            $(".selected").removeClass('selected');
            $(this).addClass('selected');
            $('.divdate').css("display", "none");
        });
        $(".1thang").click(function () {
            document.getElementById("toanbo").checked = false;
            document.getElementById("homqua").checked = false;
            document.getElementById("homnay").checked = false;
            document.getElementById("7ngay").checked = false;
            document.getElementById("1thang").checked = true;
            document.getElementById("3thang").checked = false;
            document.getElementById("6thang").checked = false;
            document.getElementById("tructiep").checked = false;
            $(".selected").removeClass('selected');
            $(this).addClass('selected');
            $('.divdate').css("display", "none");
        });
        $(".3thang").click(function () {
            document.getElementById("toanbo").checked = false;
            document.getElementById("homqua").checked = false;
            document.getElementById("homnay").checked = false;
            document.getElementById("7ngay").checked = false;
            document.getElementById("1thang").checked = false;
            document.getElementById("3thang").checked = true;
            document.getElementById("6thang").checked = false;
            document.getElementById("tructiep").checked = false;
            $(".selected").removeClass('selected');
            $(this).addClass('selected');
            $('.divdate').css("display", "none");
        });
        $(".6thang").click(function () {
            document.getElementById("toanbo").checked = false;
            document.getElementById("homqua").checked = false;
            document.getElementById("homnay").checked = false;
            document.getElementById("7ngay").checked = false;
            document.getElementById("1thang").checked = false;
            document.getElementById("3thang").checked = false;
            document.getElementById("6thang").checked = true;
            document.getElementById("tructiep").checked = false;
            $(".selected").removeClass('selected');
            $(this).addClass('selected');
            $('.divdate').css("display", "none");
        });
        $(".tructiep").click(function () {
            document.getElementById("toanbo").checked = false;
            document.getElementById("homqua").checked = false;
            document.getElementById("homnay").checked = false;
            document.getElementById("7ngay").checked = false;
            document.getElementById("1thang").checked = false;
            document.getElementById("3thang").checked = false;
            document.getElementById("6thang").checked = false;
            document.getElementById("tructiep").checked = true;
            $(".selected").removeClass('selected');
            $(this).addClass('selected');
            $('.divdate').toggle(500);
        });
    });
</script>