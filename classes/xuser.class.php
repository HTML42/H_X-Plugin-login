<?php

class Xuser {

    public $id;
    public $username;
    public $email;
    public $email_validated = null;
    public $hash = null;
    public $ext = array();
    public static $INSTANCE_CACHE = array();

    public function __construct($userid = 0) {
        global $XLDB;
        if (!is_numeric($userid)) {
            $userid = 0;
        }
        if ($userid > 0) {
            $user_data = $XLDB->get_user($userid);
        } else {
            $user_data = array();
        }
        $this->fill_data($user_data);
    }

    public function fill_data($data = array()) {
        $data = (array) $data;
        $this->id = (isset($data['id']) && is_numeric($data['id']) ? intval($data['id']) : 0);
        $this->username = (isset($data['username']) && strval($data['username']) ? $data['username'] : 'Unknown');
        $this->email = (isset($data['email']) && strval($data['email']) ? $data['email'] : 'no@email.com');
        $this->email_validated = (isset($data['email_validated']) && boolval($data['email_validated']) ? $data['email_validated'] : false);
        $this->hash = (isset($data['hash']) && strval($data['hash']) ? $data['hash'] : strtoupper(md5($this->id . '||' . $this->email)));
    }

    public function add_extension($ext_name, $ext_value) {
        $this->ext[$ext_name] = $ext_value;
    }

    public static function load($userid) {
        if (is_numeric($userid)) {
            if (!isset(self::$INSTANCE_CACHE[$userid])) {
                self::$INSTANCE_CACHE[$userid] = new Xuser($userid);
            }
            return self::$INSTANCE_CACHE[$userid];
        } else {
            return new Xuser();
        }
    }

    public function output() {
        $output = array(
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'email_validated' => $this->email_validated,
            'ext' => array(),
        );
        foreach ($this->ext as $extension_name => $extension) {
            if (isset($extension->data_public)) {
                $extension_variables = (array) $extension;
                unset($extension_variables['data_public']);
                if ($extension->data_public && !is_array($extension->data_public)) {
                    $output['ext'][$extension_name] = $extension_variables;
                } else if (is_array($extension->data_public) && !empty($extension->data_public)) {
                    $output['ext'][$extension_name] = array();
                    foreach ($extension->data_public as $extension_key) {
                        if (isset($extension_variables[$extension_key])) {
                            $output['ext'][$extension_name][$extension_key] = $extension_variables[$extension_key];
                        }
                    }
                }
            }
        }
        return $output;
    }

    public function email_confirmation() {
        $email_response = Emails::create('confirmation', $this->email, $this);
        return $email_response;
    }

    public static function get_id_by_username($username) {
        global $XLDB;
        $userid = 0;
        $users = $XLDB->get_users();
        foreach ($users as $user) {
            if ($user['username'] == $username) {
                $userid = $user['id'];
                break;
            }
        }
        if ($userid <= 0) {
            foreach ($users as $user) {
                if (strtolower($user['username']) == strtolower($username)) {
                    $userid = $user['id'];
                    break;
                }
            }
        }
        return $userid;
    }

    public static function get_by_username($username) {
        return Xuser::load(self::get_id_by_username($username));
    }

    public function is_me() {
        global $Xme;
        return $this->id == $Xme->id;
    }

}
