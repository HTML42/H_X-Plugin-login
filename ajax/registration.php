<?php

$response = array(
    'status' => 400,
    'resposne' => array(),
    'errors' => array(),
    'error_code' => 0
);

if (isset($_POST['user']) && is_array($_POST['user']) && isset($_POST['user']['username']) && isset($_POST['user']['password'])) {
    $username = Utilities::validate($_POST['user']['username']);
    $pw = @Xlogin::password($_POST['user']['password']);
    //
    if ($username && strlen($username) < 2) {
        array_push($response['errors'], 'Username too short.');
    }
    if (in_array(strtolower($username), array('xtreme'))) {
        array_push($response['errors'], 'Username can\'t be used.');
    }
    if (strlen($pw) < 4) {
        array_push($response['errors'], 'Password too short.');
    }
    //
    if (!empty($response['errors'])) {
        $response['error_code'] = 2;
    } else {
        //Success
    }
} else {
    array_push($response['errors'], 'Wrong post-data.');
    $response['error_code'] = 1;
}

echo json_encode($response);

die;