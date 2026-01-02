<?php
$conn = new mysqli("sql210.infinityfree.com", "if0_40771087", "PMd4UB2BUK5", "if0_40771087_todolist");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected Successfully";
?>


