<?php

require_once 'db_connection.php';

$json = file_get_contents('php://input');
$data = json_decode($json);

$fullname = $data->fullname;
$email = $data->email;
$password = $data->password;
$username = $data->username;
$mobile = $data->mobile;

$error='';

if (empty($fullname)) {
    $errors = "fullname is required";
}
else if (empty($email)) {
    $errors = "email is required";
}
else if (empty($password)) {
    $errors = "password is required";
}
else if (empty($username)) {
    $errors = "username is required";
}
else if (empty($mobile)) {
    $errors = "mobile is required";
}
else
{
  $query ="SELECT * FROM users WHERE mobile=?";
  $stmt = $conn->prepare($query);
  $stmt->execute([$mobile]);
  $user = $stmt->fetch();
  if(!$user)
  {
       $insertQuery = "INSERT INTO users (fullname,username, email, password, mobile) VALUES(?, ?, ?, ?,?)";
       $stmt = $conn->prepare($insertQuery);
       $password = password_hash($password, PASSWORD_DEFAULT);
       $result =$stmt->execute([$fullname, $username, $email, $password, $mobile]);
      if($result)
      {
          $response['status']= true;
          $response['message']= "user registered successfully";
      }
      else
      {
          $response['status']= false;
          $response['message']= "error while registering user";
      }
  }
  else{
      $response['status']= false;
      $response['message']= "Mobile Number Already Exist";
  }
 echo json_encode($response);
}
if(isset($error))
    echo json_encode($error);