<?php

session_start();
$host = "localhost:3307";
$username = "root";
$password = "root";
$dbname = "mydb";


$dataBase = new mysqli($host, $username, $password, $dbname);

if ($dataBase->connect_error) {
    die("Database Unreachable.");
}


echo "<html>";
$client = $_GET['client'];
$po = $_GET['po'];
$senTransactionID = $_GET['transactionID'];

//validate po and client

$valid = true;

$transactionID = 0;
if(isset( $_GET['abort']))
{
    $dataBase->rollback();
    $dataBase->query("insert into xlog543 values( '$senTransactionID','abort', current_time())");
}
else {
//logging
    if ($senTransactionID == 0) {
        $query = $dataBase->query("Select xtransactionID543 from xlog543 ORDER BY xtransactionID543 DESC LIMIT 1;");
        $row = $query->fetch_row();
        $transactionID = $row[0] + 1;
        $dataBase->query("insert into xlog543 values( '$transactionID','active', current_time())");
        echo " <p id ='transID' name='$transactionID'>$transactionID</p>";
    }
    try {
        $dataBase->begin_Transaction();
        $query = $dataBase->query(
            "Select * from Xpos543 WHERE XpoNo543 = '$po';  ");
        $row = $query->fetch_row();
        if ($row) {
            echo "<h3 id='invalidPO'>This purchase order number is already in use</h3>";
            $valid = false;
        }
        $query = $dataBase->query(
            "Select * from Xclients543 WHERE XclientId543 = '$client';  ");
        $row = $query->fetch_row();
        if (!$row) {
            echo "<h3 id=''>This client does not exist</h3>";
            $valid = false;
        }
        if ($valid) {
            $query = $dataBase->query(
                "insert into Xpos543 values('$po', curdate(), 'processing', '$client');  ");

            $lineNum = $_GET['lineNum'];
            for ($x = $lineNum - 1; $x >= 0; $x--) {

                $part = $_GET["partNum$x"];
                $quantity = $_GET["quant$x"];
                $query = $dataBase->query(
                    "insert into Xlines543 values('$part', 'l$x','$po', NULL, '$quantity');");


            }
            if (!isset($_GET['commit'])) {
                echo "<p id ='done'>ready</p>";
                $dataBase->rollback();
                $dataBase->query("insert into xlog543 values( '$senTransactionID','am ready', current_time())");
            }
        }
        echo "</html>";
        if ($senTransactionID != 0 and isset($_GET['commit'])) {
            echo "<p id ='done'>done</p>";
            $dataBase->query("insert into xlog543 values( '$senTransactionID','commit', current_time())");
            $dataBase->commit();
        }
    } catch (ErrorException $e) {
        echo "<p id ='abort'>abort</p>
              <p id ='done'>$transactionID</p>";
        $dataBase->query("insert into xlog543 values( '$transactionID','abort', current_time())");

        $dataBase->rollback();
        return;
    }
}
$dataBase->close();

