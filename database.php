<?php

$host = "localhost";
$dbname = "login_db";
$username = "root";
$password = "A123456789B";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;