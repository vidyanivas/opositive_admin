<?php
session_start();
ini_set('display_errors', 1);
$conn = new mysqli("localhost", "root", "", "vny_opositive");
if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}
