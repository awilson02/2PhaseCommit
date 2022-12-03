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

if(isset( $_GET['abort']))
{
    $dataBase->rollback();
    $dataBase->query("insert into xlog543 values( '$senTransactionID','abort', current_time() )");
}else {
//validate po and client
//logging
    if ($senTransactionID == 0) {
        $query = $dataBase->query("Select ytransactionID543 from ylog543 ORDER BY ytransactionID543 DESC LIMIT 1;");
        $row = $query->fetch_row();
        $transactionID = $row[0] + 1;
        $dataBase->query("insert into ylog543 values( '$transactionID','active',  current_time() )");
        echo " <p id ='transID' name='$transactionID'>$transactionID</p>";
    } else {
        $transactionID = $senTransactionID;
    }

    try {

        $dataBase->begin_Transaction();
        $valid = true;
        $query = $dataBase->query(
            "Select * from Ypos543 WHERE YpoNo543 = '$po';  ");
        $row = $query->fetch_row();
        if ($row) {
            echo "<h3 id='invalidPO'>This purchase order number is already in use</h3>";
            $valid = false;
        }
        $query = $dataBase->query(
            "Select * from Yclients543 WHERE YclientId543 = '$client';  ");
        $row = $query->fetch_row();
        if (!$row) {
            echo "<h3>This client does not exist</h3>";
            $valid = false;
        }
        if ($valid) {
            $query = $dataBase->query(
                "insert into Ypos543 values('$po', curdate(), 'processing', '$client');  ");

            $lineNum = $_GET['lineNum'];
            for ($x = $lineNum - 1; $x >= 0; $x--) {

                $part = $_GET["partNum$x"];
                $quantity = $_GET["quant$x"];
                $query = $dataBase->query(
                    "insert into Ylines543 values('$part', 'l$x','$po', NULL, '$quantity');");


            }

            if (!isset($_GET['commit'])) {
                echo "<p id ='done'>ready</p>";
                $dataBase->rollback();
                $dataBase->query("insert into ylog543 values( '$transactionID',' am ready',  current_time() )");
            }


        }


        echo "</html>";
        if ($senTransactionID != 0 and isset($_GET['commit'])) {
            echo "<p id ='done'>done</p>";
            $dataBase->query("insert into ylog543 values( '$senTransactionID','commit',  current_time() )");
            $dataBase->commit();
        }

    } catch (ErrorException $e) {
        echo "<p id ='done'>abort</p>
              <p id ='done'>$transactionID</p>";
        $dataBase->query("insert into ylog543 values( '$transactionID','abort',  current_time() )");
        $dataBase->rollback();
        return;
    }
}
$dataBase->close();

