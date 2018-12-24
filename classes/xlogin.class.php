<?php

class Xlogin {

    const TEMPLATES = array(
        'login' => X_LOGIN_PATH . 'templates/login.php',
        'registration' => X_LOGIN_PATH . 'templates/registration.php',
    );

    public static $config = array(
        'db' => array(
            'system' => 'xlogin',
            'username' => '',
            'password' => '',
            'port' => '',
            'dir_db' => PROJECT_ROOT . '_xlogin_db',
            'dir_cache' => PROJECT_ROOT . '_xlogin_cache',
        ),
        'login' => array(
            'form_css_class' => 'xlogin_form',
            'placeholder_username' => 'Benutzername..',
            'placeholder_password' => 'Passwort..',
            'button_submit' => 'Login',
            'button_cancel' => 'Abbrechen',
        )
    );
    
    public static function password($string) {
        return sha1($string . 'XL!');
    }

}
