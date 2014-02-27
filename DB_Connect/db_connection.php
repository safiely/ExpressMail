<?php
header("Content-type: text/html; charset=utf-8");
function db_connect() {
	$result = new mysqli("localhost", "em_user", "password", "expressmail");
	if (!$result) {
		throw new Exception("Could not connect to database server");
	} else {
		return $result;
	}
}