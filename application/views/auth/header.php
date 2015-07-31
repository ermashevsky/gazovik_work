<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofollow"/>
        <title>Газовик | <?php echo $title; ?></title>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/bootstrap-button.js"></script>
        <script src="/assets/js/bootstrap-fileupload.js"></script>
        <script src="/assets/js/bootstrap-notify.js"></script>
        <script src="/assets/js/jquery.uploadify.min.js"></script>
        <script src="/assets/js/bootbox.js"></script>
        <script src="/assets/js/jquery.dataTables.js"></script>



        <link href="/assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/assets/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="/assets/css/bootstrap-button.css" rel="stylesheet">
        <link href="/assets/css/bootstrap-fileupload.css" rel="stylesheet">
        <link href="/assets/css/font-awesome.min.css" rel="stylesheet">
        <link href="/assets/css/jquery.dataTables.css" rel="stylesheet">
        <link href="/assets/css/jquery.dataTables_themeroller.css" rel="stylesheet">
        <style>
            .modal {
                outline: none;
                position: absolute;
                margin-top: 0;
                top: 20%;
                overflow: visible; /* allow content to popup out (i.e tooltips) */
                width:500px;
            }

            .modal-backdrop, 
            .modal-backdrop.fade.in{
                opacity: 0.7;
                filter: alpha(opacity=70);
                background: #fff;
            }

            div.dataTables_length label {
                float: left;
                text-align: left;
                margin-left: 30px;
            }

            div.dataTables_length select {
                width: 75px;
            }

            div.dataTables_filter label {
                float: right;
            }

            div.dataTables_info {
                padding-top: 8px;
                margin-left: 30px;
            }

            div.dataTables_paginate {
                float: right;
                margin: 0;
            }

            table.table {
                clear: both;
                margin-bottom: 6px !important;
                max-width: none !important;
            }

            table.table thead .sorting,
            table.table thead .sorting_asc,
            table.table thead .sorting_desc,
            table.table thead .sorting_asc_disabled,
            table.table thead .sorting_desc_disabled {
                cursor: pointer;
                *cursor: hand;
            }

            table.table thead .sorting { background: url('/assets/img/sort_both.png') no-repeat center right; }
            table.table thead .sorting_asc { background: url('/assets/img/sort_asc.png') no-repeat center right; }
            table.table thead .sorting_desc { background: url('/assets/img/sort_desc.png') no-repeat center right; }

            table.table thead .sorting_asc_disabled { background: url('/assets/img/sort_asc_disabled.png') no-repeat center right; }
            table.table thead .sorting_desc_disabled { background: url('/assets/img/sort_desc_disabled.png') no-repeat center right; }

            table.dataTable th:active {
                outline: none;
            }

            /* Scrolling */
            div.dataTables_scrollHead table {
                margin-bottom: 0 !important;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }

            div.dataTables_scrollHead table thead tr:last-child th:first-child,
            div.dataTables_scrollHead table thead tr:last-child td:first-child {
                border-bottom-left-radius: 0 !important;
                border-bottom-right-radius: 0 !important;
            }

            div.dataTables_scrollBody table {
                border-top: none;
                margin-bottom: 0 !important;
            }

            div.dataTables_scrollBody tbody tr:first-child th,
            div.dataTables_scrollBody tbody tr:first-child td {
                border-top: none;
            }

            div.dataTables_scrollFoot table {
                border-top: none;
            }




            /*
             * TableTools styles
             */
            .table tbody tr.active td,
            .table tbody tr.active th {
                background-color: #08C;
                color: white;
            }

            .table tbody tr.active:hover td,
            .table tbody tr.active:hover th {
                background-color: #0075b0 !important;
            }

            .table-striped tbody tr.active:nth-child(odd) td,
            .table-striped tbody tr.active:nth-child(odd) th {
                background-color: #017ebc;
            }

            table.DTTT_selectable tbody tr {
                cursor: pointer;
                *cursor: hand;
            }

            div.DTTT .btn {
                color: #333 !important;
                font-size: 12px;
            }

            div.DTTT .btn:hover {
                text-decoration: none !important;
            }


            ul.DTTT_dropdown.dropdown-menu a {
                color: #333 !important; /* needed only when demo_page.css is included */
            }

            ul.DTTT_dropdown.dropdown-menu li:hover a {
                background-color: #0088cc;
                color: white !important;
            }

            /* TableTools information display */
            div.DTTT_print_info.modal {
                height: 150px;
                margin-top: -75px;
                text-align: center;
            }

            div.DTTT_print_info h6 {
                font-weight: normal;
                font-size: 28px;
                line-height: 28px;
                margin: 1em;
            }

            div.DTTT_print_info p {
                font-size: 14px;
                line-height: 20px;
            }



            /*
             * FixedColumns styles
             */
            div.DTFC_LeftHeadWrapper table,
            div.DTFC_LeftFootWrapper table,
            table.DTFC_Cloned tr.even {
                background-color: white;
            }

            div.DTFC_LeftHeadWrapper table {
                margin-bottom: 0 !important;
                border-top-right-radius: 0 !important;
                border-bottom-left-radius: 0 !important;
                border-bottom-right-radius: 0 !important;
            }

            div.DTFC_LeftHeadWrapper table thead tr:last-child th:first-child,
            div.DTFC_LeftHeadWrapper table thead tr:last-child td:first-child {
                border-bottom-left-radius: 0 !important;
                border-bottom-right-radius: 0 !important;
            }

            div.DTFC_LeftBodyWrapper table {
                border-top: none;
                margin-bottom: 0 !important;
            }

            div.DTFC_LeftBodyWrapper tbody tr:first-child th,
            div.DTFC_LeftBodyWrapper tbody tr:first-child td {
                border-top: none;
            }

            div.DTFC_LeftFootWrapper table {
                border-top: none;
            }
            .modal-body {
                max-height: 800px;
            }

            .better-active {
                background-color: #89cefa;
                color: #014783;
                padding:5px;
            }
            #phoneDepts_list{
                font-size: 13px;
            }

            #phoneDepts_list_wrapper{
                width:90%;
            }
        </style>
        <script type="text/javascript">
            /* Set the defaults for DataTables initialisation */
            $.extend(true, $.fn.dataTable.defaults, {
                "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sUrl": "http://www.sprymedia.co.uk/dataTables/lang.txt"
                }
            });


            /* Default class modification */
            $.extend($.fn.dataTableExt.oStdClasses, {
                "sWrapper": "dataTables_wrapper form-inline"
            });


            /* API method to get paging information */
            $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
            {
                return {
                    "iStart": oSettings._iDisplayStart,
                    "iEnd": oSettings.fnDisplayEnd(),
                    "iLength": oSettings._iDisplayLength,
                    "iTotal": oSettings.fnRecordsTotal(),
                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                    "iPage": oSettings._iDisplayLength === -1 ?
                            0 : Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                    "iTotalPages": oSettings._iDisplayLength === -1 ?
                            0 : Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                };
            };


            /* Bootstrap style pagination control */
            $.extend($.fn.dataTableExt.oPagination, {
                "bootstrap": {
                    "fnInit": function(oSettings, nPaging, fnDraw) {
                        var oLang = oSettings.oLanguage.oPaginate;
                        var fnClickHandler = function(e) {
                            e.preventDefault();
                            if (oSettings.oApi._fnPageChange(oSettings, e.data.action)) {
                                fnDraw(oSettings);
                            }
                        };

                        $(nPaging).addClass('pagination').append(
                                '<ul>' +
                                '<li class="prev disabled"><a href="#">&larr; ' + oLang.sPrevious + '</a></li>' +
                                '<li class="next disabled"><a href="#">' + oLang.sNext + ' &rarr; </a></li>' +
                                '</ul>'
                                );
                        var els = $('a', nPaging);
                        $(els[0]).bind('click.DT', {action: "previous"}, fnClickHandler);
                        $(els[1]).bind('click.DT', {action: "next"}, fnClickHandler);
                    },
                    "fnUpdate": function(oSettings, fnDraw) {
                        var iListLength = 5;
                        var oPaging = oSettings.oInstance.fnPagingInfo();
                        var an = oSettings.aanFeatures.p;
                        var i, ien, j, sClass, iStart, iEnd, iHalf = Math.floor(iListLength / 2);

                        if (oPaging.iTotalPages < iListLength) {
                            iStart = 1;
                            iEnd = oPaging.iTotalPages;
                        }
                        else if (oPaging.iPage <= iHalf) {
                            iStart = 1;
                            iEnd = iListLength;
                        } else if (oPaging.iPage >= (oPaging.iTotalPages - iHalf)) {
                            iStart = oPaging.iTotalPages - iListLength + 1;
                            iEnd = oPaging.iTotalPages;
                        } else {
                            iStart = oPaging.iPage - iHalf + 1;
                            iEnd = iStart + iListLength - 1;
                        }

                        for (i = 0, ien = an.length; i < ien; i++) {
                            // Remove the middle elements
                            $('li:gt(0)', an[i]).filter(':not(:last)').remove();

                            // Add the new list items and their event handlers
                            for (j = iStart; j <= iEnd; j++) {
                                sClass = (j == oPaging.iPage + 1) ? 'class="active"' : '';
                                $('<li ' + sClass + '><a href="#">' + j + '</a></li>')
                                        .insertBefore($('li:last', an[i])[0])
                                        .bind('click', function(e) {
                                            e.preventDefault();
                                            oSettings._iDisplayStart = (parseInt($('a', this).text(), 10) - 1) * oPaging.iLength;
                                            fnDraw(oSettings);
                                        });
                            }

                            // Add / remove disabled classes from the static elements
                            if (oPaging.iPage === 0) {
                                $('li:first', an[i]).addClass('disabled');
                            } else {
                                $('li:first', an[i]).removeClass('disabled');
                            }

                            if (oPaging.iPage === oPaging.iTotalPages - 1 || oPaging.iTotalPages === 0) {
                                $('li:last', an[i]).addClass('disabled');
                            } else {
                                $('li:last', an[i]).removeClass('disabled');
                            }
                        }
                    }
                }
            });


            /*
             * TableTools Bootstrap compatibility
             * Required TableTools 2.1+
             */
            if ($.fn.DataTable.TableTools) {
                // Set the classes that TableTools uses to something suitable for Bootstrap
                $.extend(true, $.fn.DataTable.TableTools.classes, {
                    "container": "DTTT btn-group",
                    "buttons": {
                        "normal": "btn",
                        "disabled": "disabled"
                    },
                    "collection": {
                        "container": "DTTT_dropdown dropdown-menu",
                        "buttons": {
                            "normal": "",
                            "disabled": "disabled"
                        }
                    },
                    "print": {
                        "info": "DTTT_print_info modal"
                    },
                    "select": {
                        "row": "active"
                    }
                });

                // Have the collection use a bootstrap compatible dropdown
                $.extend(true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
                    "collection": {
                        "container": "ul",
                        "button": "li",
                        "liner": "a"
                    }
                });
            }


            /* Table initialisation */
            $(document).ready(function() {

                var url = window.location.href;

                // Will also work for relative and absolute hrefs
                $('ul.nav li a').filter(function() {
                    return this.href === url;
                }).addClass('better-active');
                
                $('#user_list').dataTable({
                    "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sUrl": "/assets/js/dataTables.russian.txt"
                    }
                });
            
            
                $('#phoneDepts_list').dataTable({
                    "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sUrl": "/assets/js/dataTables.russian.txt"
                    }
                });

            });

            function create_user() {
                form = $("#create_user_form").serialize();

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('auth/create_user'); ?>",
                    data: form,
                    success: function(data) {
                        $(".modal.fade.bs-example-modal-sm").modal('hide');
                    }

                });
                event.preventDefault();
                return false;  //stop the actual form post !important!
            }
            
            function updateSMTPParameters(){
                    form = $("#smtp_form").serialize();

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('auth/updateSmtpParameters'); ?>",
                    data: form,
                    success: function(data) {
                        window.location.reload();
                    }

                });
                event.preventDefault();
                return false;  //stop the actual form post !important!
            }

            function createPhoneRecord() {
                form = $("#createPhoneDeptsForm").serialize();

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('auth/createPhoneDeptsRecord'); ?>",
                    data: form,
                    success: function(data) {
                        $(".modal.fade.bs-example-modal-sm").modal('hide');
                        window.location.reload();
                    }

                });
                event.preventDefault();
                return false;  //stop the actual form post !important!
            }
            
            function deletePhoneRecord(id) {
                bootbox.dialog({
                    message: "Вы действительно хотите удалить запись?",
                    title: "Удаление записи",
                    buttons: {
                        success: {
                            label: "Да",
                            className: "btn-success btn-small",
                            callback: function() {
                                clearRecord(id);
                                window.location.reload();
                            }
                        },
                        danger: {
                            label: "Нет",
                            className: "btn-danger btn-small",
                            callback: function() {
                                bootbox.hideAll();
                                
                            }
                        }
                    }
                });
            }
            function clearRecord(id){
                $.post('<?php echo site_url('/general/deletePhoneDeptsRecord'); ?>', {'id': id},
                function(data) {
                    
                });
            }
            
            function deleteUserRecord(id) {
                bootbox.dialog({
                    message: "Вы действительно хотите удалить пользователя?",
                    title: "Удаление пользователя",
                    buttons: {
                        success: {
                            label: "Да",
                            className: "btn-success btn-small",
                            callback: function() {
                                clearUserRecord(id);
                                window.location.reload();
                            }
                        },
                        danger: {
                            label: "Нет",
                            className: "btn-danger btn-small",
                            callback: function() {
                                bootbox.hideAll();
                                
                            }
                        }
                    }
                });
            }
            function clearUserRecord(id){
                $.post('<?php echo site_url('/general/delete_user'); ?>', {'id': id},
                function(data) {
                    
                });
            }
            
            function editPhoneRecord(id){
                $.post('<?php echo site_url('/general/getPhoneDeptsRecord'); ?>', {'id': id},
                function(data) {
                    
                    $.each(data,function(i,val){
                        
                        var html = '<form class="form-horizontal" id="editPhoneDeptsForm">';
                            html+='<fieldset>';
                            html+='<div class="control-group">';
                            html+='<label class="control-label" for="edit_external_number">Номер телефона</label>';
                            html+='<div class="controls">';
                            html+='<input id="id" name="id" type="hidden" value="'+data[i].id+'" />';
                            html+='<input id="edit_external_number" name="edit_external_number" type="text" placeholder="Введите номер телефона" class="input-xlarge" value="'+data[i].external_number+'"required="">';
                            html+='</div>';
                            html+='</div>';
                            html+='<div class="control-group">';
                            html+='<label class="control-label" for="edit_contactName">Наименование контакта</label>';
                            html+='<div class="controls">';
                            html+='<input id="edit_contactName" name="edit_contactName" type="text" placeholder="Введите наименование контакта" class="input-xlarge" value="'+data[i].contactName+'">';
                            html+='</div>';
                            html+='</div>';
                            html+='</fieldset>';
                            html+='</form>';
                            
                            
                    bootbox.dialog({
                    message: html,
                    title: "Редактирование записи",
                    buttons: {
                        success: {
                            label: "Сохранить",
                            className: "btn-success btn-small",
                            callback: function() {
                                updateRecord();
                                window.location.reload();
                            }
                        },
                        danger: {
                            label: "Отмена",
                            className: "btn-danger btn-small",
                            callback: function() {
                                bootbox.hideAll();
                                
                            }
                        }
                    }
                });
                    });
                },'json');
            }
            
            function updateRecord(){
                form = $("#editPhoneDeptsForm").serialize();

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('general/updatePhoneDeptsRecord'); ?>",
                    data: form,
                    success: function(data) {

                    }

                });
                event.preventDefault();
                return false;  //stop the actual form post !important!
            }
            
        </script>

    </head>

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
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-wrench icon-white"> </i>Админка<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="/auth/"><i class="icon-user icon-white"> </i>Пользователи</a></li>
                                    <li><a href="/auth/phoneDepts"><i class="icon-tasks icon-white"> </i>Телефонные номера</a></li>
                                    <li><a href="/auth/mailsettings"><i class="icon-envelope"> </i>Настройки SMTP сервера</a></li>
                                </ul>
                            </li>          
                            <li><a href="#" id="restartNodeServer"><i class="icon-repeat"> </i>Перезапуск службы</a></li>
                            <li class="pull-right"><a href="/auth/logout"><i class="icon-arrow-right icon-white"> </i>Выход</a></li>

                        </ul>
                    </div><!-- /.nav-collapse -->
                </div><!-- /.container -->
            </div><!-- /.navbar-inner -->
        </div><!-- /.navbar -->
    </div>