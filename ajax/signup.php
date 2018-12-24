<?php

include '../../../xtreme/library/bootstrap.php';

$response = array(
    'status' => 400,
    'resposne' => array(),
    'errors' => array(),
    'error_code' => 0
);

if(X_LOGIN) {
    array_push($response['errors'], 'You are already logged in.');
    $response['error_code'] = 6;
} else if (isset($_POST['user']) && is_array($_POST['user']) &&
        isset($_POST['user']['username']) && isset($_POST['user']['email']) &&
        isset($_POST['user']['password']) && isset($_POST['user']['password2'])) {
    $username = Utilities::validate($_POST['user']['username']);
    $username_lower = strtolower($username);
    $email = Utilities::validate($_POST['user']['email']);
    $email_lower = strtolower($email);
    $pw = @Xlogin::password($_POST['user']['password']);
    $pw_match = $_POST['user']['password'] == $_POST['user']['password2'];
    //
    if (!$username || strlen($username) < Xlogin::$config['validation']['username']['min-length']) {
        array_push($response['errors'], 'Username too short.');
    }
    if (!$username || strlen($username) > Xlogin::$config['validation']['username']['max-length']) {
        array_push($response['errors'], 'Username too long.');
    }
    if (in_array(strtolower($username), array('xtreme'))) {
        array_push($response['errors'], 'Username can\'t be used.');
    }
    if (strlen($pw) < Xlogin::$config['validation']['password']['min-length']) {
        array_push($response['errors'], 'Password too short.');
    }
    if (!$pw_match) {
        array_push($response['errors'], 'Passwords do not match.');
    }
    //
    if (!empty($response['errors'])) {
        $response['error_code'] = 5;
    } else {
        //Check with DB
        foreach ($XLDB->get_users() as $user) {
            if (strtolower($user['username']) == $username_lower) {
                array_push($response['errors'], 'Username already in use.');
            } else if (strtolower($user['email']) == $email_lower) {
                array_push($response['errors'], 'E-Mail already in use.');
            }
        }
        //
        if (!empty($response['errors'])) {
            $response['error_code'] = 4;
        } else {
            //Success
            $userid = $XLDB->create_user(array(
                'username' => $username,
                'email' => $email,
                'password' => $pw,
            ));
            Xlogin::session('userid', $userid);
            $response['status'] = 200;
            $response['response'] = array(
                'userid' => $userid,
                'username' => $username,
                'email' => $email,
            );
        }
    }
} else {
    array_push($response['errors'], 'Wrong post-data.');
    $response['error_code'] = 3;
}

App::$mime = 'application/json';
Response::deliver(json_encode($response));
