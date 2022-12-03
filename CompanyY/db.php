
<?php

if (strpos($_SERVER['REQUEST_URI'], "db.php") !== false) {
    header("Location: ../index.php");
    die();

}
session_start();
$host = "localhost:3307";
$username = "root";
$password = "root";
$dbname = "mydb";

$dataBase = new mysqli($host, $username, $password, $dbname);

if ($dataBase->connect_error) {
    die("Database Unreachable.");
}

?>


