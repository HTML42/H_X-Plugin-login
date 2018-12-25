<?php

$GLOBALS['FLAG_email_confirmation'] = true;

$request = isset($_GET['request']) ? json_decode(base64_decode($_GET['request']), true) : array();

if (isset($request['id']) && isset($request['hash'])) {
    if (is_numeric($request['id']) && is_string($request['hash']) && strlen($request['hash']) > 5) {
        $User = new Xuser($request['id']);
        if ($User->hash == $request['hash']) {
            $GLOBALS['XLDB']->edit_user($User->id, array(
                'email_validated' => true
            ));
            echo '<div class="xlogin_notice xlogin_notice_success">' . Xlogin::$config['confirmation']['response_success'] . '</div>';
            //
            if (is_string(Xlogin::$config['confirmation']['redirect_url']) && strlen(Xlogin::$config['confirmation']['redirect_url']) > 2) {
                echo '<div class="xlogin_notice">' . Xlogin::$config['confirmation']['redirect_text'] . '</div>';
                echo '<script text="text/javascript">';
                echo 'setTimeout(\'location.href="' . Xlogin::$config['confirmation']['redirect_url'] . '"\', ' . Xlogin::$config['confirmation']['redirect_ms'] . ');';
                echo '</script>';
            }
        } else {
            echo '<div class="xlogin_notice xlogin_notice_error">' . Xlogin::$config['confirmation']['response_error'] . ' #8</div>';
        }
    } else {
        echo '<div class="xlogin_notice xlogin_notice_error">' . Xlogin::$config['confirmation']['response_error'] . ' #7</div>';
    }
} else {
    echo '<div class="xlogin_notice xlogin_notice_error">' . Xlogin::$config['confirmation']['response_error'] . ' #6</div>';
}
