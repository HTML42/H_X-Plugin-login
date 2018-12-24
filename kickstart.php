<?php

#Variables
define('X_LOGIN_PATH', PROJECT_ROOT . 'plugins/login/');
define('X_LOGIN_URL', BASEURL . Request::$requested_clean_path);

#Files
foreach(array('classes/xlogin.class.php', 'classes/xuser.class.php', 'classes/xlogin_db.class.php') as $plugin_file_path) {
    if(is_file(X_LOGIN_PATH . $plugin_file_path)) {
        include X_LOGIN_PATH . $plugin_file_path;
    }
}
