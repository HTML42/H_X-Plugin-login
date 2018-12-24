<form action="<?= X_LOGIN_URL ?>" method="post" data-xlogin class="<?= Xlogin::$config['login']['form_css_class'] ?>">
    <fieldset>
        <label class="form_row">
            <div class="form_label">Benutzername</div>
            <div class="form_input">
                <input type="text" name="user[username]" placeholder="<?= Xlogin::$config['login']['placeholder_username'] ?>" />
            </div>
        </label>
        <label class="form_row">
            <div class="form_label">Passwort</div>
            <div class="form_input">
                <input type="text" name="user[password]" placeholder="<?= Xlogin::$config['login']['placeholder_password'] ?>" />
            </div>
        </label>
    </fieldset>
    <fieldset>
        <div class="form_row form_row_buttons">
                <input type="reset" name="cancel" value="<?= Xlogin::$config['login']['button_cancel'] ?>" />
                <input type="submit" name="submit_x" value="<?= Xlogin::$config['login']['button_submit'] ?>" />
        </div>
    </fieldset>
</form>
