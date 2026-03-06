<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "logins";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else {//echo "Connected";

}