<body>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span16">
                <div class="row-fluid">
                    <!--                   <h3 style="color:#08c;">Статистика звонков</h3>-->
                    <table id='cdrTable2' class='display nowrap dataTable dtr-inline' cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Внутренний номер
                                </th>
                                <th>
                                    Дата
                                </th>
                                <th>
                                    Время
                                </th>
                                <th>
                                    Продолжительность
                                </th>
                                <th>
                                    Тип звонка
                                </th>
                                <th>
                                    Вызывающая сторона
                                </th>
                                <th>
                                    Принимающая сторона
                                </th>
                                <th>
                                    Контакт
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
        <div class="row-fluid">
            <div class="span16" id="excel_table_block">
            </div>
        </div>
    </div>
    <div id="delete_dialog"></div>
    <div id="dialogInfoCall" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">История перевода звонка</h4>
                </div>
                <!-- dialog body -->
                <div class="modal-body">
                    <div id="callInfoTable"></div>
                </div>
                <!-- dialog buttons -->
                <div class="modal-footer"><button type="button" data-dismiss="modal" class="btn btn-mini btn-danger">Закрыть</button></div>
            </div>
        </div>
    </div>
</body>
<!--<footer>
        <p>Телекоммуникационная компания <a href="http://dialog64.ru" target="_blank">«Диалог»</a> 2013. | Телефон / факс: (8452) 740-740 E-mail: info@dialog64.ru
                </p>
</footer>-->
</html>