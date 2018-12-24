<?php

class Xlogin_DB {

    public function __construct() {
        switch (Xlogin::$config['db']['system']) {
            case 'mysql':
                //ToDo: Create Mysql-Login
                break;
            case 'xlogin':
                Xlogin::$config['db']['dir_db'] = File::n(Xlogin::$config['db']['dir_db']);
                Utilities::ensure_structure(Xlogin::$config['db']['dir_db']);
                break;
        }
        Xlogin::$config['db']['dir_cache'] = File::n(Xlogin::$config['db']['dir_cache']);
        Utilities::ensure_structure(Xlogin::$config['db']['dir_cache']);
    }

    public function get_users() {
        if (Xlogin::$config['db']['system'] == 'xlogin') {
            $table = $this->get_table('users');
            if ($table) {
                return $table;
            } else {
                return array();
            }
        }
        return null;
    }

    public function get_user($id = 0) {
        if (Xlogin::$config['db']['system'] == 'xlogin') {
            foreach ($this->get_users() as $user) {
                if ($user['id'] == $id) {
                    return $user;
                }
            }
            return null;
        }
        return null;
    }

    public function get_table($table) {
        if (Xlogin::$config['db']['system'] == 'xlogin') {
            $File_table = File::instance(Xlogin::$config['db']['dir_db'] . $table . '.json');
            if ($File_table->exists) {
                return $File_table->get_json();
            } else {
                return null;
            }
        }
        return null;
    }

}
