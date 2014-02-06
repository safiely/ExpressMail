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
			document.location.href = "http://localhost/Projects/ExpressMail/home.php";
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
?>