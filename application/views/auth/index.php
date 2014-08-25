<body>
    <div class="container-fluid">
        <div class="row">

            <div class="span16">
                <div class="row-fluid">
                    
                        <h3 style="color:#08c;">Пользователи</h3>
                        <div id="infoMessage" class="label label-info"><?php echo $message; ?></div>
                        <table class='display nowrap dataTable dtr-inline' cellspacing="0" width="100%" id="user_list">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Логин</th>
                                    <th>Email</th>
                                    <th>Телефон</th>
                                    <th>Роль (Группа)</th>
<!--                                    <th>Уведомление по email</th>-->
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $n = 1;
                                foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo $n++; ?></td>
                                        <td><?php echo $user->username; ?></td>
                                        <td><?php echo $user->email; ?></td>
                                        <td><?php echo $user->phone; ?></td>
                                        <td>
                                            <?php foreach ($user->groups as $group): ?>
                                                <?php echo $group->name; ?><br />
                                            <?php endforeach ?>
                                        </td>
<!--                                        <td>
                                            <?php if($user->email_notification === '1'){
                                                echo "Уведомлять";
                                            }else{
                                                echo "Не уведомлять";
                                            }
                                            ?>
                                        </td>-->
                                        <td><?php echo ($user->active) ? anchor("auth/deactivate/" . $user->id, 'Активен', array('class' => 'btn btn-info btn-mini')) : anchor("auth/activate/" . $user->id, 'Заблокирован', array('class' => 'btn btn-danger btn-mini')); ?></td>
                                        <td><?php echo anchor("auth/edit_user/" . $user->id, 'Редактировать', array('class' => 'btn btn-success btn-mini'));?> | <button type="button" class="btn btn-danger btn-mini" onclick="deleteUserRecord(<?php echo $user->id; ?>);return false;">Удалить</button></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p><a class="btn btn-info btn-small" href="#" data-toggle="modal" data-target=".bs-example-modal-sm">Добавить пользователя</a></p>
                    
                </div><!--/row-->
            </div><!--/span-->
            
            <div class="modal hide fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Новый пользователь</h4>
      </div>
      <div class="modal-body">
   <form class="form-horizontal" id="create_user_form">
<fieldset>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="login">Логин</label>
  <div class="controls">
    <input id="login" name="login" type="text" placeholder="Введите логин" class="input-xlarge" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="email">Email</label>
  <div class="controls">
    <input id="email" name="email" type="text" placeholder="Введите email" class="input-xlarge">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="phone">Телефон (внутр.)</label>
  <div class="controls">
    <input id="phone" name="phone" type="text" placeholder="Введите внутренний телефон" class="input-xlarge" required="">
    
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="group">Группа (Роль)</label>
  <div class="controls">
    <select id="group" name="group" class="input-xlarge">
      <option>Администратор</option>
      <option>Менеджер</option>
    </select>
  </div>
</div>

<!-- Password input-->
<div class="control-group">
  <label class="control-label" for="password">Пароль (не менее 8 символов)</label>
  <div class="controls">
    <input id="password" name="password" type="password" placeholder="Введите пароль" class="input-xlarge" required="">
    
  </div>
</div>

<!-- Password input-->
<div class="control-group">
  <label class="control-label" for="password_confirm">Повтор пароля</label>
  <div class="controls">
    <input id="password_confirm" name="password_confirm" type="password" placeholder="Повторите пароль" class="input-xlarge" required="">
    
  </div>
</div>

</fieldset>
</form>
     
      </div>
      <div class="modal-footer">
        
          <button type="button" class="btn btn-success btn-small" onclick="create_user();return false;">Сохранить</button>
        <button type="button" class="btn btn-danger btn-small" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>           
