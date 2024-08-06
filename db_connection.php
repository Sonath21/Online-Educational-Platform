<?php
$servername = "webpagesdb.it.auth.gr:3306";
$username = "student4007"; 
$password = "paswword"; 
$dbname = "student4007";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
