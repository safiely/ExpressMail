<?php
require_once 'user_auth.php';
// create variable
$email = $_POST ['txtUserName'];
$password = $_POST ['txtUserPwd'];
$conf_pass = $_POST ['txtUserPwd_2'];
$firstname = $_POST ['txtCoName'];
$lastname = $_POST ['txtReceiverName'];
$chinesename = $_POST ['hz_realname'];
$phonenumber = $_POST ['txtTelPhone'];
$location = $_POST ['txtCoWebSite'];

// register
if (register ( $email, $password, $firstname, $lastname, $chinesename, $phonenumber, $location )) {
?>
<script type="text/javascript" language="JavaScript">
	if (confirm("Registration Successful! Click \"OK\" to Login! or Go back to Home!")) {
		document.location.href="http://localhost/Projects/ExpressMail/User/login.html";
	} else {
		document.location.href="http://localhost/Projects/ExpressMail/home.php";
	}
</script>	

<?php 
}
?>