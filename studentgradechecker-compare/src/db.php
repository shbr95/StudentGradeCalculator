<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$servername = "db";
$username_db = "root";
$password_db = "my_secret_password";
$db = "studentgradechecker-db";
$port =  3306;   

$mysqli = mysqli_connect($servername, $username_db, $password_db, $db, $port);



$mysqli->set_charset('utf8mb4');
mysqli_set_charset($mysqli, 'utf8mb4');



if($mysqli->connect_error){
    echo "Connection failed: ".$conn->connect_error;
} else {
    
    
}

