<?php

class Xlogin {

    const TEMPLATES = array(
        'login' => X_LOGIN_PATH . 'templates/login.php',
        'signup' => X_LOGIN_PATH . 'templates/signup.php',
        'script_email_confirmation' => X_LOGIN_PATH . 'templates/script_email_confirmation.php',
        'js_vars' => X_LOGIN_PATH . 'templates/js_vars.php',
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
            'label_username' => 'Benutzername',
            'label_password' => 'Passwort',
            'placeholder_username' => 'Benutzername',
            'placeholder_password' => 'Passwort',
            'button_submit' => 'Login',
            'callback' => null,
        ),
        'signup' => array(
            'form_css_class' => 'xlogin_form',
            'label_username' => 'Benutzername',
            'label_email' => 'E-Mail',
            'label_password' => 'Passwort',
            'label_password2' => 'Passwort wiederholen',
            'placeholder_username' => 'Benutzername',
            'placeholder_email' => 'E-Mail',
            'placeholder_password' => 'Passwort',
            'placeholder_password2' => 'Passwort wiederholen',
            'button_submit' => 'Registration',
            'callback' => null,
        ),
        'validation' => array(
            'username' => array(
                'min-length' => 2,
                'max-length' => 32
            ),
            'password' => array(
                'min-length' => 4
            )
        ),
        'confirmation' => array(
            'response_success' => 'Email successful confirmed.',
            'response_error' => 'Request Wrong.',
            'redirect_text' => 'You will be redirected in 5 seconds..',
            'redirect_ms' => 5000,
            'redirect_url' => 'index.html',
            'callback' => null,
        )
    );

    public static function password($string) {
        return sha1($string . 'XL!');
    }

    public static function session($key, $value = '#undefined#') {
        if (isset($_SESSION['xlogin']) && $_SESSION['xlogin'] != Utilities::remote_ip()) {
            return null;
        }
        $session_key = 'xlogin_data_' . md5(__FILE__);
        if ($value === '#undefined#') {
            if (!isset($_SESSION[$session_key])) {
                return null;
            }
            return (isset($_SESSION[$session_key][$key]) ? $_SESSION[$session_key][$key] : null);
        } else {
            if (!isset($_SESSION['xlogin'])) {
                $_SESSION['xlogin'] = Utilities::remote_ip();
            }
            if (!isset($_SESSION[$session_key]) || !is_array($_SESSION[$session_key])) {
                $_SESSION[$session_key] = array();
            }
            $_SESSION[$session_key][$key] = $value;
        }
        return true;
    }

}
