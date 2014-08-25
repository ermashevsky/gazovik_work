<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <title>Газовик | <?php echo $title;?></title>

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

        <link href="/assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="/assets/css/bootstrap-button.css" rel="stylesheet">
        <link href="/assets/css/bootstrap-fileupload.css" rel="stylesheet">
        <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="/assets/css/datepicker.css" rel="stylesheet">
        <link href="/assets/css/pnotify.core.css" media="all" rel="stylesheet" type="text/css" />
        <link href="/assets/css/jquery.dataTables.css" rel="stylesheet">
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
            
        </style>
    </head>
    <script>
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
                "bDestroy" : false,
                "sServerMethod": "POST",
                "fnServerParams": function (aoData) {
                    aoData.push({
                        "name": "phone", "value": <?php echo $user->phone; ?> });
                    aoData.push({
                        "name":"group", "value":'<?php echo $group->name; ?>'
                        });
                },
                "sAjaxSource": '<?= site_url('general/getCallData'); ?>',
                "sPaginationType": "full_numbers",
                "oLanguage": {
                    "sUrl": "/assets/js/dataTables.russian.txt"
                },
                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                    $('td:eq(6)', nRow).html('<a href="http://192.168.1.4/vtigercrm/index.php?action=UnifiedSearch&module=Home&phone=' + aData[6] + '">' +
                        aData[6] + '</a>');
                    switch(aData[5]){
                    case 'Входящий неотвеченный':
                    $(nRow).css('background-color', '#eed3d7');
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
