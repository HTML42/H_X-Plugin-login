<?php

#Variables
define('X_LOGIN_PATH', PROJECT_ROOT . 'plugins/login/');

#Files
foreach(array('classes/xlogin.class.php', 'classes/xuser.class.php') as $plugin_file_path) {
    if(is_file(X_LOGIN_PATH . $plugin_file_path)) {
        include X_LOGIN_PATH . $plugin_file_path;
    }
}
