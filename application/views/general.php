<body>
    
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span16">
                <div class="row-fluid">
<!--                    <h3 style="color:#08c;">Звонки онлайн</h3>-->
                    <div id="cdrTableBlock">
                        Тип звонка
                        <select name="call_type" id="call_type">
                            <option value="ALL">Все</option>
                            <option value="IR">Только входящие</option>
                            <option value="IA">Только разговор</option>
                            <option value="I">Только завершенные</option>
                        </select>
<?php if($this->ion_auth->is_admin()){ ?>
<table id='cdrTable' class='display nowrap dataTable dtr-inline' cellspacing="0" width="100%">
<?php }else{?>
<table id='cdrTable<?php echo $user->username; ?>' class='display nowrap dataTable dtr-inline' cellspacing="0" width="100%">    
<?php } ?>    
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

<iframe name="iframeVTiger" id="iframeVTiger" frameborder="1" ></iframe>
                </div>
            </div>

        </div>
        <div class="row-fluid">
            <div class="span16" id="excel_table_block">

<!--                <legend><i class="icon-eye-open"></i> Просмотр Excel-файла</legend>-->

            </div>
        </div>
    </div>
    <div id="delete_dialog"></div>
</body>
<!--<footer>
        <p>Телекоммуникационная компания <a href="http://dialog64.ru" target="_blank">«Диалог»</a> 2013. | Телефон / факс: (8452) 740-740 E-mail: info@dialog64.ru
                </p>
</footer>-->
</html>