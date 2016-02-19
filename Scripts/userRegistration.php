<?php


require("Conn.php");
require("MySQLDao.php");

$email = htmlentities($_POST["email"]);
$password = htmlentities($_POST["password"]);

returnValue = array();

if(empty($email) || empty($password)) {
$returnValue["statue"] = "error";
$returnValue["message"] = "Missing required field";
echo json_encode($returnValue);
return;
}

$dao = new MySQLDao();
$dao->openConnection();
$userDetails = $dao->getUserDetails($email);

if(!empty($userDetails)) {

$returnValue["status"] = "error";
$returnValue["message"] = "User already exists";
echo json_encode($returnValue);
return;
}

$secure_password = md5($password); //password encryption

$result = $dao->registerUser($email,$secure_password);

if($result) {

$resultValue["status"] = "Success";
$returnValue["message"] = "User is registered";
echo json_encode($returnValue);
return;
}

$dao->closeConnection();

?>