<body>
    <div class="container-fluid">
        <div class="row">

            <div class="span10">
                <div class="row-fluid">
                    <div class="span12">
                        <h3>Редактирование пользователя</h3>

                        <div class="box-content">	
                            <?php echo form_open("auth/edit_user/" . $this->uri->segment(3),'class="form-inline"'); ?>
                            <p>Логин:<br />
                                <?php echo form_input($username); ?>
                            </p>
                            <p>Email:<br />
                                <?php echo form_input($email); ?>
                            </p>

                            <p>Телефон (внутр.)<br />
                                <?php echo form_input($phone); ?>
                            </p>
                            
                            <p>Пароль:*<br />
                            <?php echo form_password($password);?>
                            </p>

                                <p>Пароль (повторить):<br />
                            <?php echo form_password($password_confirm);?>
                            </p>

                            <p>Член групп</p>
                            <?php foreach ($groups as $group):?>
                            <label class="checkbox">
                            <?php
                                    $gID=$group['id'];
                                    $checked = null;
                                    $item = null;
                                    foreach($currentGroups as $grp) {
                                            if ($gID == $grp->id) {
                                                    $checked= ' checked="checked"';
                                            break;
                                            }
                                    }
                            ?>
                            <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                            <?php echo $group['name'];?>
                            </label>
                            <?php endforeach?>
                            <br/>
                            <p><span class="label label-info">* - Заполняется, если меняете данные параметры.</span></p>
                            
                            <?php //echo form_input($user_id);?>
                            <p><?php echo form_submit('submit', 'Сохранить','class="btn btn-info btn-small"'); ?> <a href="/auth/" class="btn btn-small btn-danger">Назад</a></p>


                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>