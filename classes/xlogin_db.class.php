<?php

class Xlogin_DB {

    public static $CACHE = array(
        'users' => null
    );

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
        //Xlogin-Cache currently unused
        Xlogin::$config['db']['dir_cache'] = File::n(Xlogin::$config['db']['dir_cache']);
        //Utilities::ensure_structure(Xlogin::$config['db']['dir_cache']);
    }

    public function get_users() {
        if (!is_null(self::$CACHE['users']) && is_array(self::$CACHE['users'])) {
            return self::$CACHE['users'];
        }
        if (Xlogin::$config['db']['system'] == 'xlogin') {
            $table = $this->get_table('users');
            if ($table) {
                return self::$CACHE['users'] = $table;
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

    public function create_user($user_data) {
        if (is_array($user_data)) {
            $new_id = $this->_new_id('users');
            $current_users = $this->get_users();
            array_push($current_users, array(
                'id' => $new_id,
                'username' => self::_value($user_data['username'], 'Unknown'),
                'email' => self::_value($user_data['email']),
                'password' => self::_value($user_data['password'], '#no-password#'),
                'email_validated' => false,
                'insert_date' => time(),
                'update_date' => null,
                'delete_date' => null,
            ));
            File::_save_file(Xlogin::$config['db']['dir_db'] . 'users.json', json_encode($current_users));
            //
            self::$CACHE['users'] = null;
            return $new_id;
        }
        return null;
    }

    public function edit_user($userid, $data) {
        global $Xme;
        $access = $userid == $Xme->id;
        $data['update_date'] = time();
        if ($access) {
            if (Xlogin::$config['db']['system'] == 'xlogin') {
                $users = $this->get_users();
                foreach ($users as &$user) {
                    if ($user['id'] == $userid) {
                        foreach ($data as $key => $value) {
                            if ($key != 'id') {
                                $user[$key] = $value;
                            }
                        }
                    }
                }
                File::_save_file(Xlogin::$config['db']['dir_db'] . 'users.json', json_encode($users));
            }
        }
    }

    public function _new_id($table = 'users') {
        switch ($table) {
            case 'user':
            case 'users':
                $items = $this->get_users();
                break;
        }
        $highest_id = 0;
        foreach ($items as $row) {
            if (isset($row['id']) && $row['id'] > $highest_id) {
                $highest_id = intval($row['id']);
            }
        }
        $highest_id++;
        return $highest_id;
    }

    public static function _value($value = 'undefined', $default = 'undefined', $type = 'string') {
        if ($type == 'string') {
            $value = trim($value);
            if (strlen($value) > 0) {
                return $value;
            }
        } else if ($type == 'number') {
            if (is_numeric($value)) {
                return $value;
            }
        }
        return $default;
    }

}
