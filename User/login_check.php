<?php
require_once 'user_auth.php';

$email = $_POST ['txtUserName'];
$password = $_POST ['txtUserPwd'];

if (login($email, $password)) {
	header("Location: test.php");
}
