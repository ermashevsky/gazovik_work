<body>
    <div class="container">
        <div class="row-fluid">

            <div class="span10">
                <div class="row-fluid">
                    
                        <h3 style="color:#08c;">Телефонные номера</h3>
                        <div id="infoMessage" class="label label-info"><?php echo $message; ?></div>
                        <table class='display nowrap dataTable dtr-inline' cellspacing="0" width="100%" id="phoneDepts_list">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Номер телефона</th>
                                    <th>Наименование отдела</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $n = 1;
                                foreach ($phone_depts as $rows): ?>
                                    <tr>
                                        <td><?php echo $n++; ?></td>
                                        <td><?php echo $rows->external_number; ?></td>
                                        <td><?php echo $rows->contactName; ?></td>
                                        <td class="pull-right"><button class="btn btn-success btn-mini" onclick="editPhoneRecord(<?php echo $rows->id; ?>);return false;">Редактировать</button> | <button type="button" class="btn btn-danger btn-mini" onclick="deletePhoneRecord(<?php echo $rows->id; ?>);return false;">Удалить</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p><a class="btn btn-info btn-small" href="#" data-toggle="modal" data-target=".bs-example-modal-sm">Добавить запись</a></p>
                    
                </div><!--/row-->
            </div><!--/span-->
            
            <div class="modal hide fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Новая запись</h4>
      </div>
      <div class="modal-body">
   <form class="form-horizontal" id="createPhoneDeptsForm">
<fieldset>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="external_number">Номер телефона</label>
  <div class="controls">
    <input id="external_number" name="external_number" type="text" placeholder="Введите номер телефона" class="input-xlarge" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="contactName">Наименование контакта</label>
  <div class="controls">
    <input id="contactName" name="contactName" type="text" placeholder="Введите наименование контакта" class="input-xlarge">
    
  </div>
</div>
</fieldset>
</form>
     
      </div>
      <div class="modal-footer">
        
          <button type="button" class="btn btn-success btn-small" onclick="createPhoneRecord();return false;">Сохранить</button>
        <button type="button" class="btn btn-danger btn-small" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
 