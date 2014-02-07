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
			document.location.href = "http://localhost/Projects/ExpressMail/User/register.html";
		} else {
			document.location.href = "http://localhost/Projects/ExpressMail/index.html";
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

function login($email, $password) {
	// connect to db
	$conn = db_connect();
	$result = $conn->query("select * from customers where email='" . $email . "'");
	$row=$result->fetch_assoc();
	$username=$row['email'];
	$passwd = $row['password'];
	if (! $result) {
		echo "Could not excute query!";
	}
	
	if ($username != $email) {
?>
	<script type="text/javascript" language="JavaScript">
		var r = confirm("This User is not exist! Press \"OK\" to login again! or \"Cancel\" to home!");
		if (r == true) {
			document.location.href = "http://localhost/Projects/ExpressMail/User/login.html";
		} else {
			document.location.href = "http://localhost/Projects/ExpressMail/index.html";
		}
	</script>
<?php 		
	}
	if (sha1($password) != $passwd) {
?>
	<script type="text/javascript" language="JavaScript">
		var r = confirm("Password is incorrect! Press \"OK\" to login again! or \"Cancel\" to home!");
		if (r == true) {
			document.location.href = "http://localhost/Projects/ExpressMail/User/login.html";
		} else {
			document.location.href = "http://localhost/Projects/ExpressMail/index.html";
		}
	</script>	
<?php 
    }
    return true;
}
?>

