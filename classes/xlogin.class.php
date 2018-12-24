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

    public static function session($key, $value = '#undefined#') {
        if (isset($_SESSION['xlogin']) && $_SESSION['xlogin'] != Utilities::remote_ip()) {
            return null;
        }
        if ($value === '#undefined#') {
            if (!isset($_SESSION['xlogin_data'])) {
                return null;
            }
            return (isset($_SESSION['xlogin_data'][$key]) ? $_SESSION['xlogin_data'][$key] : null);
        } else {
            if (!isset($_SESSION['xlogin'])) {
                $_SESSION['xlogin'] = Utilities::remote_ip();
            }
            if (!isset($_SESSION['xlogin_data']) || !is_array($_SESSION['xlogin_data'])) {
                $_SESSION['xlogin_data'] = array();
            }
            $_SESSION['xlogin_data'][$key] = $value;
        }
        return true;
    }

}
