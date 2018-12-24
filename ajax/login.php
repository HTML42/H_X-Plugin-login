<?php

include ROOT . 'library/bootstrap.php';

$response = array(
    'status' => 400,
    'response' => array(),
    'errors' => array(),
    'error_code' => 0
);

if (isset($_POST['user']) && is_array($_POST['user']) && isset($_POST['user']['username']) && isset($_POST['user']['password'])) {
    $username = Utilities::validate($_POST['user']['username']);
    $pw = @Xlogin::password($_POST['user']['password']);
    //
    $match = false;
    $userid = 0;
    foreach ($this->get_users() as $user) {
        if (($user['username'] == $username || $user['email'] == $username) && $user['password'] == $pw) {
            $match = true;
            $userid = $user['id'];
        }
    }
    if ($match) {
        //Success
        $response['status'] = 200;
        $response['response'] = 'Login Successful.';
    } else {
        array_push($response['errors'], 'Username or password wrong.');
        $response['error_code'] = 2;
    }
} else {
    array_push($response['errors'], 'Wrong post-data.');
    $response['error_code'] = 1;
}

echo json_encode($response);
