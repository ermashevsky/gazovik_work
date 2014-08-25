<body>
    <div class="container-fluid">
        <div class="row">

            <div class="span16">
                <div class="row-fluid">
                    
<h3 style="color:#08c;">Настройки почтового сервера</h3>
<form class="form-inline" id="smtp_form">
<fieldset>
<?php
foreach ($mailsettings as $value):
    echo "<input type='hidden' name='id' id='id' value='".$value->id."' />";
?>
<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="smtp_host">Адрес SMTP сервера</label>
  <div class="controls">
      <input id="smtp_host" name="smtp_host" type="text" placeholder="Введите адрес smtp сервера" class="input-xlarge" required="" value="<?php echo $value->smtp_host; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="smtp_port">Порт SMTP сервера</label>
  <div class="controls">
    <input id="smtp_port" name="smtp_port" type="text" placeholder="Введите порт smtp сервера" class="input-xlarge" required="" value="<?php echo $value->smtp_port; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="smtp_user">Пользователь</label>
  <div class="controls">
    <input id="smtp_user" name="smtp_user" type="text" placeholder="Введите имя пользователя" class="input-xlarge" value="<?php echo $value->smtp_user; ?>">
    
  </div>
</div>

<!-- Password input-->
<div class="control-group">
  <label class="control-label" for="smtp_pass">Пароль</label>
  <div class="controls">
    <input id="smtp_pass" name="smtp_pass" type="password" placeholder="Введите пароль" class="input-xlarge" required="" value="<?php echo $value->smtp_pass; ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="smtp_timeout">Таймаут сервера</label>
  <div class="controls">
    <input id="smtp_timeout" name="smtp_timeout" type="text" placeholder="Введите значение таймаута сервера" class="input-xlarge" value="<?php echo $value->smtp_timeout; ?>">
    
  </div>
</div>
<?php
endforeach;
?>

<!-- Password input-->
<div class="control-group">
  <label class="control-label" for="password_confirm"> </label>
  <div class="controls">
      <button type="button" class="btn btn-success btn-small" onclick="updateSMTPParameters();return false;">Сохранить</button>
  </div>
</div>
</fieldset>
</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>