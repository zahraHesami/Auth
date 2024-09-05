<?php
require_once 'db_connection.php';
header('Content-type: text/html; charset=utf-8');

$json = file_get_contents('php://input');
$data = json_decode($json, true);



if (!empty($data->username) && !empty( $data->password)&& isset($data->username,  $data->password)) {

    $username = $data->username;
    $password = $data->password;
    $loginQuery="SELECT * FROM users WHERE username=? ";
    $stmt = $conn->prepare($loginQuery);
    $result=$stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user) {
     if (password_verify($password, $user['password'])) {
         session_start();
         $_SESSION['id'] = $user['id'];
         $response['status'] = true;
         $response['message'] = "Login Successful";
         $response['data'] = $user;
     }
     else
     {
         $response['status'] = false;
         $response['message'] = "Login Failed ,wronge password  or username";
     }
    }
    else
    {
        $response['status'] = false;
        $response['message'] = 'Invalid username or password';
    }

}
else
{
    $response['status'] = false;
    $response['message'] ='please fill all the required fields';
}

echo json_encode($response);
