<?php

include '../../../xtreme/library/bootstrap.php';

$response = array(
    'status' => 400,
    'response' => array(),
    'errors' => array(),
    'error_code' => 0
);

if (isset($_POST['user']) && is_array($_POST['user']) && isset($_POST['user']['username']) && isset($_POST['user']['password'])) {
    $username = Utilities::validate($_POST['user']['username']);
    $pw = Xlogin::password($_POST['user']['password']);
    //
    $match = false;
    $userid = 0;
    foreach ($XLDB->get_users() as $user) {
        if (($user['username'] == $username || $user['email'] == $username) && $user['password'] == $pw) {
            $match = true;
            $userid = intval($user['id']);
            break;
        }
    }
    if ($match) {
        Xlogin::session('userid', $userid);
        $response['status'] = 200;
        $response['response'] = array(
            'userid' => $userid,
            'user' => $user,
        );
    } else {
        array_push($response['errors'], 'Username or password wrong.');
        $response['error_code'] = 2;
    }
} else {
    array_push($response['errors'], 'Wrong post-data.');
    $response['error_code'] = 1;
}

App::$mime = 'application/json';
Response::deliver(json_encode($response));
