<?php
if (strpos($_SERVER['REQUEST_URI'], "displayTable.php") !== false) {
    header("Location: ../index.php");
    die();

}

function displayPo543($dataBase)
{
    $client = $_POST["cliendId"];
    echo "  <form id='submit' class='mt-5' method='post'> 
              <label id='clientLabel'> Client Id </label><input  value='$client' id='cliendId' class='textField' type='text' name='cliendId'><button id='ordersSubbmit' name='ViewOrders'>Search</button>
              </form>";
    //logging
    $query = $dataBase->query("Select xtransactionID543 from xlog543 ORDER BY xtransactionID543 DESC LIMIT 1;");
    $row = $query->fetch_row();
    $transactionID = $row[0] +1;
    $dataBase->query("insert into xlog543 values( '$transactionID','active', current_time())");

    try {
        $dataBase->begin_Transaction();
        $query = $dataBase->query(
            "Select * from Xpos543 WHERE XclientId543 = '$client';  ");

        echo "<table id='results'>";
        echo "<tr> 
                <th>PONumber</th>
                <th>Date</th>
                <th>Status</th>
                <th>Client</th>
               </tr>";
        while($row = $query->fetch_row()) {
            echo "<tr> ";
            foreach($row as $x)
            {
                echo "<th> $x</th>";
            }
            echo "</tr> ";

        }

        echo "</table>";
    $dataBase->query("insert into xlog543 values( '$transactionID','commit', current_time())");
    $dataBase->commit();
}
catch (ErrorException $e)
   {
       $dataBase->query("insert into xlog543 values( '$transactionID','abort', current_time())");
       $dataBase->rollback();
       return;
   }
}
function displayParts543($dataBase)
{
    //logging
    $query = $dataBase->query("Select xtransactionID543 from xlog543 ORDER BY xtransactionID543 DESC LIMIT 1;");
    $row = $query->fetch_row();
    $transactionID = $row[0] +1;
    $dataBase->query("insert into xlog543 values( '$transactionID','active', current_time())");

    try {
        $dataBase->begin_Transaction();
        $query = $dataBase->query(
            "Select * from Xparts543;  ");

        echo "<table id='results'>";
        echo "<tr> 
                <th>PartNumber</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
               </tr>";
        while($row = $query->fetch_row()) {
            echo "<tr> ";

            echo "<th> $row[0]</th>
                      <th> $row[1]</th>
                      <th> $row[2]</th>
                      <th> $row[3]</th>";

            echo "</tr> ";

        }

        echo "</table>";
        $dataBase->query("insert into xlog543 values( '$transactionID','commit', current_time())");
        $dataBase->commit();
    }
    catch (ErrorException $e)
    {
        $dataBase->query("insert into xlog543 values( '$transactionID','abort', current_time())");
        $dataBase->rollback();
        return;
    }
}

function displayOrder543($dataBase)
{
    $poID = $_POST["PoID"];
    echo "  <form id='submit' class='mt-5' method='post'> 
     <label id='poLabel'> PoID </label><input id='PoID' class='textField' type='text' name='PoID' value='$poID'><button id='vosubmit' name='ViewOrder'>Search</button>
     </form>";

    //logging
    $query = $dataBase->query("Select xtransactionID543 from xlog543 ORDER BY xtransactionID543 DESC LIMIT 1;");
    $row = $query->fetch_row();
    $transactionID = $row[0] +1;
    $dataBase->query("insert into xlog543 values( '$transactionID','active', current_time())");
    try {
        $dataBase->begin_Transaction();
        $query = $dataBase->query(
            "Select * from Xlines543 WHERE XpoNo543 = '$poID';  ");

        echo "<table id='results'>";
        echo "<tr> 
                <th>partNumber</th>
                <th>LineNumber</th>
                <th>PONumber</th>
                <th>Price</th>
                <th>Quantity</th>
               </tr>";
        while($row = $query->fetch_row()) {
            echo "<tr> ";
            foreach($row as $x)
            {
                echo "<th> $x</th>";
            }
            echo "</tr> ";

        }

        echo "</table>";
        $dataBase->query("insert into xlog543 values( '$transactionID','commit', current_time())");
        $dataBase->commit();
    }
    catch (ErrorException $e)
    {
        $dataBase->query("insert into xlog543 values( '$transactionID','abort', current_time())");
        $dataBase->rollback();
        return;
    }

}
?>