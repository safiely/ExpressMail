<?php
header("Content-type: text/html; charset=utf-8");
session_start();
echo $_SESSION['cid'];
?>
<br>
<?php 
echo $_SESSION['email'];
?>
<br>
<?php 
echo $_SESSION['chinesename'];
?>
<br>
<?php 
echo $_SESSION['phonenumber'];
?>