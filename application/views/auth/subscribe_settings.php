<body>
    <div class="container">
        <div class="row-fluid">

            <div class="span10">
                <div class="row-fluid">
                    
                        <h3 style="color:#08c;">Настройка рассылки ежедневной статистики</h3>
                        <div id="infoMessage" class="label label-info"><?php echo $message; ?></div>
                        <table class='display nowrap dataTable dtr-inline' cellspacing="0" width="100%" id="phoneDepts_list">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Наименование контакта</th>
                                    <th>Email адрес</th>
                                    <th>Статус рассылки</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $n = 1;
                                foreach ($phone_depts as $rows): ?>
                                    <tr>
                                        <td><?php echo $n++; ?></td>
                                        <td><?php echo $rows->contactName; ?></td>
                                        <td><?php echo $rows->email; ?></td>
                                        <td><?php
                                        
                                        if($rows->status === 'active'){
                                            echo '<span class="label label-success">'.$rows->status.'</span>';
                                        }else{
                                            echo '<span class="label label-important">'.$rows->status.'</span>';
                                        }
                                        
                                        ?></td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-mini" onclick="updateStatus('<?php echo $rows->id; ?>', '<?php echo $rows->status; ?>');return false;">Статус рассылки</button>
                                        </td>
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
        <h4 class="modal-title" id="myModalLabel">Новый контакт рассылки</h4>
      </div>
      <div class="modal-body">
   <form class="form-horizontal" id="addEmailItemForm">
<fieldset>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="email">Email</label>
  <div class="controls">
    <input id="emailItem" name="email" type="text" placeholder="Введите email адрес" class="input-xlarge" required="">
    
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
        
          <button type="button" class="btn btn-success btn-small" onclick="addEmailItem();return false;">Сохранить</button>
        <button type="button" class="btn btn-danger btn-small" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
 