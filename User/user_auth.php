<?php
require_once '../DB_Connect/db_connection.php';
function register($email, $password, $firstname, $lastname, $chinsesname, $phonenumber, $location) {
	// connect to db
	$conn = db_connect ();
	$result = $conn->query ( "select * from customers where email='" . $email . "'" );
	
	if (! $result) {
		echo "Could not excute query!";
	}
	
	if ($result->num_rows > 0) {
?>
	<script type="text/javascript" language="JavaScript">
		var r = confirm("This Email already been registered! Press \"OK\" to register again! or \"Cancel\" to go back!");
		if (r == true) {
			document.location.href = "register.html";
		} else {
			document.location.href = "../index.html";
		}
	</script>
<?php
		exit ();
	}
	
	$result = $conn->query ( "insert into customers values ('" . NULL . "', '" . $email . "', sha1('" . $password . "'), '" . $firstname . "', '" . $lastname . "', '" . $chinsesname . "', '" . $phonenumber . "', '" . $location . "')" );
	
	if (! $result) {
		throw new Exception ( "Could not register you in database - please try again later." );
	}
	
	return true;
}

session_start();

function login($email, $password) {
	// connect to db
	$conn = db_connect();
	$result = $conn->query("select * from customers where email='" . $email . "'");
	$row=$result->fetch_assoc();
	$username = $row['email'];
	$passwd = $row['password'];
	$_SESSION['firstname']=$row['firstname'];
	$_SESSION['lastname']=$row['lastname'];
	$_SESSION['phone']=$row['phonenumber'];
	$_SESSION['cid'] = $row['cid'];
	$_SESSION['email'] = $row['email'];
	$_SESSION['chinesename'] = $row['chinesename'];
	$_SESSION['phonenumber'] = $row['phonenumber'];
	if (! $result) {
		echo "Could not excute query!";
	}
	
	if ($username != $email) {
?>
	<script type="text/javascript" language="JavaScript">
		var r = confirm("This User is not exist! Press \"OK\" to login again! or \"Cancel\" to home!");
		if (r == true) {
			document.location.href = "login.html";
		} else {
			document.location.href = "../index.html";
		}
	</script>
<?php 	
	return false;	
	}
	if (sha1($password) != $passwd) {
?>
	<script type="text/javascript" language="JavaScript">
		var r = confirm("Password is incorrect! Press \"OK\" to login again! or \"Cancel\" to home!");
		if (r == true) {
			document.location.href = "login.html";
		} else {
			document.location.href = "../index.html";
		}
	</script>	
<?php 
	return false;
    }
    return true;
}
?>

