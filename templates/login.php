<form action="<?= X_LOGIN_URL ?>" method="post" data-xlogin="login" class="<?= Xlogin::$config['login']['form_css_class'] ?>">
    <fieldset>
        <label class="form_row">
            <div class="form_label"><?= Xlogin::$config['login']['label_username'] ?></div>
            <div class="form_input">
                <input type="text" name="user[username]" placeholder="<?= Xlogin::$config['login']['placeholder_username'] ?>" />
            </div>
        </label>
        <label class="form_row">
            <div class="form_label"><?= Xlogin::$config['login']['label_password'] ?></div>
            <div class="form_input">
                <input type="password" name="user[password]" placeholder="<?= Xlogin::$config['login']['placeholder_password'] ?>" />
            </div>
        </label>
    </fieldset>
    <fieldset>
        <div class="form_row form_row_buttons">
                <input type="submit" name="submit_x" value="<?= Xlogin::$config['login']['button_submit'] ?>" />
        </div>
    </fieldset>
    <?php if(X_LOGIN) { ?>
        <div class="xlogin_already_logged_in"><div class="xlogin_logoutlink"><div class="xlogin_logoutlink_text">Logout</div></div></div>
        <div class="xlogin_already_logged_in_spacer"></div>
    <?php } ?>
</form>
