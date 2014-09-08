<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <title>Газовик | <?php echo $title; ?></title>

        <script src="/assets/js/jquery.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/bootstrap-button.js"></script>
        <script src="/assets/js/bootstrap-fileupload.js"></script>
        <script src="/assets/js/bootstrap-notify.js"></script>
        <script src="/assets/js/bootbox.min.js"></script>
        <script src="/assets/js/bootstrap-progressbar.js"></script>
        <script src="/assets/js/bootstrap-datepicker.js"></script>
        <script src="/assets/js/locales/bootstrap-datepicker.ru.js"></script>
        <script src="http://gaz.dialog64.ru:8383/socket.io/socket.io.js"></script>
        <script src="/assets/js/jquery.dataTables.js"></script>
        <script src="/assets/js/dataTables.tableTools.js"></script>
        <script src="/assets/js/jquery.nicescroll.js"></script>
        <script type="text/javascript" src="/assets/js/pnotify.core.js"></script>
        <script type="text/javascript" src="/assets/js/jquery.tablesorter.js"></script>

        <link href="/assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="/assets/css/bootstrap-button.css" rel="stylesheet">
        <link href="/assets/css/bootstrap-fileupload.css" rel="stylesheet">
        <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="/assets/css/datepicker.css" rel="stylesheet">
        <link href="/assets/css/pnotify.core.css" media="all" rel="stylesheet" type="text/css" />
        <link href="/assets/css/jquery.dataTables.css" rel="stylesheet">
        <link href="/assets/css/theme.default.css" rel="stylesheet">
        <link href="/assets/css/theme.blue.css" rel="stylesheet">
        <link href="/assets/css/theme.ice.css" rel="stylesheet">
        <link href="/assets/css/theme.jui.css" rel="stylesheet">
        <!-- Loading Flat UI -->
        <!--        <link href="/assets/css/flat-ui.css" rel="stylesheet">
                <link href="/assets/css/demo.css" rel="stylesheet">-->
        <link rel="stylesheet" type="text/css" href="/assets/css/notifIt.css">

        <link rel="shortcut icon" href="images/favicon.ico">


        <style>
            table{
                font-size: 13px;
            }

            #cdrTable_info, #cdrTable_paginate{
                margin-top: 10px;
                font-size: 13px;
            }
            .dataTables_length select {
                width: auto !important;
                font-size: 13px;
            }
            .dataTables_length label{
                font-size: 13px;
            }
            .dataTables_filter input{
                width: 120px;
                height:30px;
                font-size: 13px;
            }
            .dataTables_filter label{
                font-size: 13px;
            }
            #Content{
                overflow: auto;
                height: 100px;
                margin-bottom: 10px;
                width:600px;
                position: absolute;
                top:8px;
                left:300px;
            }
            .better-active {
                background-color: #89cefa;
                color: #014783;
                padding:5px;
            }

            .DTTT_container{
                margin-bottom: 25px;
                margin-left: 200px;
                position:absolute;
            }

            #ToolTables_cdrTable2_0{

            }

            .tablesorter {
                width: auto;
            }
            .tablesorter .tablesorter-filter {
                width: 50px;
            }

            #dialogInfoCall{
                width:auto;
                margin-right:10px;
            }

        </style>
    </head>
    <script>
        function getCallHistory(call_id) {
            console.info(call_id);
            $.post('<?php echo site_url('/general/getCallHistory'); ?>', {'call_id': call_id},
            function(data) {
                var counter = 1;
                $("#callInfoTable").empty();
                var tableHeader = "<table id='infoCall' class='tablesorter'><thead><tr><th>#</th><th>Внутр.номер</th><th>Дата</th><th>Время</th><th>Продолжительность</th><th>Событие</th><th>Вызывающий</th><th>Принимающий</th></tr></thead></table>";
                $("#callInfoTable").append(tableHeader);
                $.each(data, function(i, value) {
                    $("#infoCall").append("<tr><td>" + counter++ + "</td><td>" + data[i].internal_number + "</td><td>" + data[i].call_date + "</td><td>" + data[i].call_time + "</td><td>" + data[i].duration + "</td><td>" + data[i].call_type + "</td><td>" + data[i].src + "</td><td>" + data[i].dst + "</td></tr>");
                });
                $("#callInfoTable").append("</table>");

                $(".tablesorter").tablesorter({
                    theme: 'blue',
                    // sort on the first column and second column in ascending order
                    sortList: [[0, 0], [1, 0]]
                });

                $("#dialogInfoCall").on("show", function() {    // wire up the OK button to dismiss the modal when shown
                    $(this).css({
                        'left': '50%',
                        'margin-left': function() {
                            return -($(this).width() / 2);
                        }
                    });

                    $("#dialogInfoCall a.btn").on("click", function(e) {
                        console.log("button pressed");   // just as an example...
                        $("#dialogInfoCall").modal('hide');     // dismiss the dialog
                    });
                });

                // remove the event listeners when the dialog is hidden
                $("#dialogInfoCall").bind("hide", function() {
                    // remove event listeners on the buttons
                    $("#dialogInfoCall a.btn").unbind();
                });

                $("#dialogInfoCall").modal({// wire up the actual modal functionality and show the dialog
                    "backdrop": "static",
                    "keyboard": true,
                    "show": true                     // ensure the modal is shown immediately
                });

            }, 'json');
        }

        $(document).ready(function() {

            var url = window.location.href;

            // Will also work for relative and absolute hrefs
            $('ul.nav li a').filter(function() {
                return this.href === url;
            }).addClass('better-active');

            $("#phoneNumber").val('<?php echo $user->phone; ?>');
            $("#group").val('<?php echo $group->name; ?>');

//            $("#Content").niceScroll({cursorcolor:"#3a87ad"});
            function notify(message) {
//                var data = new PNotify({
//                    title: false,
//                    text: message,
//                    styling: "bootstrap3",
//                    type: "success",
//                    delay: 8000,
//                    shadow: true,
//                    width: "600px",
//                    insert_brs: true,
//                    addclass: "stack-topcenter"
//                });

            }

            var oTable = $('table#cdrTable2').dataTable({
                "bProcessing": true,
                "bDestroy": false,
                "sServerMethod": "POST",
                "fnServerParams": function(aoData) {
                    aoData.push({
                        "name": "phone", "value": <?php echo $user->phone; ?>});
                    aoData.push({
                        "name": "group", "value": '<?php echo $group->name; ?>'
                    });
                },
                "sAjaxSource": '<?= site_url('general/getCallDataForDay'); ?>',
                "sPaginationType": "full_numbers",
                "oLanguage": {
                    "sUrl": "/assets/js/dataTables.russian.txt"
                },
                "fnRowCallback": function(nRow, aData, iDisplayIndex) {
                    $('td:eq(6)', nRow).html('<a href="http://192.168.1.4/vtigercrm/index.php?action=UnifiedSearch&module=Home&phone=' + aData[6] + '">' +
                            aData[6] + '</a>');
                    switch (aData[5]) {
                        case 'Входящий звонок':
                            $(nRow).css('background-color', 'rgb(217, 237, 247)');
                            break;
                        case 'Разговор':
                            $(nRow).css('background-color', 'rgb(252, 248, 227)');
                            break;
                        case 'Звонок завершен':
                            $(nRow).css('background-color', 'rgb(223, 240, 216)');
                            break;  
                          
                    }
                    return nRow;
                },
                "dom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "/assets/swf/copy_csv_xls.swf",
                    "aButtons": [
                        {
                            "sExtends": "csv",
                            "sButtonText": "Сохранить в CSV",
                            "sButtonClass": "btn btn-success btn-small pull-right"
                        }
                    ]
                }
            });

//            var tt = new $.fn.dataTable.TableTools( oTable );
// 
//            $( tt.fnContainer() ).insertBefore('div.dataTables_wrapper');

        });

    </script>
    <div class="page-header">

        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid pull-right">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li><a>Здравствуйте, <?php echo $user->username; ?></a></li>   
                            <li><a href="/"><i class="icon-home icon-white"> </i>Звонки онлайн</a></li>
                            <li><a href="/general/callForDay"><i class="icon-calendar icon-white"> </i>Звонки за сегодня</a></li>
                            <li><a href="/general/statistic"><i class="icon-list"> </i>Статистика</a></li>
                            <?php
                            if ($this->ion_auth->is_admin()) {
                                ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-wrench icon-white"> </i>Админка<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/auth/"><i class="icon-user icon-white"> </i>Пользователи</a></li>
                                        <li><a href="/auth/phoneDepts"><i class="icon-tasks icon-white"> </i>Телефонные номера</a></li>
                                        <li><a href="/auth/mailsettings"><i class="icon-envelope"> </i>Настройки SMTP сервера</a></li>
                                    </ul>
                                </li>          
                            <?php } ?>
                            <li class="pull-right"><a href="/auth/logout"><i class="icon-arrow-right icon-white"> </i>Выход</a></li>

                        </ul>
                    </div><!-- /.nav-collapse -->
                </div><!-- /.container -->
            </div><!-- /.navbar-inner -->
        </div><!-- /.navbar -->
    </div>
</ul>
</div>
</div>
</div>
</div>
</div>
<input type="hidden" name="phoneNumber" id="phoneNumber" value="" />
<input type="hidden" name="group" id="group" value="" />
