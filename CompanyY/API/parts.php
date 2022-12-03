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
//logging
$query = $dataBase->query("Select ytransactionID543 from ylog543 ORDER BY ytransactionID543 DESC LIMIT 1;");
$row = $query->fetch_row();
$transactionID = $row[0] +1;
$dataBase->query("insert into ylog543 values( '$transactionID','active', current_time() )");
try {
    $dataBase->begin_Transaction();
    $query = $dataBase->query(
        "Select * from Yparts543;  ");



    while ($row = $query->fetch_row()) {
        echo "<tr class='$row[0]'> ";

        echo "<th>$row[0]</th>
                      <th>$row[1]</th>
                      <th>$row[2]</th>
                      <th > $row[3]</th>
                       <th style='display: none'>$row[4]</th>
                        <th style='display: none'>Y</th>";

        echo "</tr> ";

    }
    $dataBase->query("insert into ylog543 values( '$transactionID','commit', current_time() )");
    $dataBase->commit();
}
catch (ErrorException $e)
{
    $dataBase->query("insert into ylog543 values( '$transactionID','abort', current_time() )");
    $dataBase->rollback();
    return;
}


$dataBase->close();






