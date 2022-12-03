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
    $query = $dataBase->query("Select ztransactionID543 from zlog543 ORDER BY ztransactionID543 DESC LIMIT 1;");
    $row = $query->fetch_row();
    $transactionID = $row[0] +1;
    $dataBase->query("insert into zlog543 values( '$transactionID','active',  current_time() )");

    try {
        $dataBase->begin_Transaction();




        $query = $dataBase->query(
            "Select * from Zpos543 WHERE ZclientId543 = '$client';  ");

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
        $dataBase->query("insert into zlog543 values( '$transactionID','commit',  current_time() )");
        $dataBase->commit();
    }
    catch (ErrorException $e)
    {
        $dataBase->query("insert into zlog543 values( '$transactionID','abort',  current_time() )");
        $dataBase->rollback();
        return;
    }


}
function displayParts543()
{

    //getting the parts from X and Y
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost/4140A3/CompanyY/API/parts.php");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response1 = curl_exec($ch);
    curl_close($ch);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost/4140A3/CompanyX/API/parts.php");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response2 = curl_exec($ch);
    curl_close($ch);




    $finalHTML=  $response1. $response2 ;


     $dom = (new DOMDocument());
     $dom->loadHTML($finalHTML);

     $rows = $dom->getElementsByTagName('tr');


    $classChecker= array();
    $elementArray = array();

    echo "<table id='dups' style='display: none'>";
    //printing the parts
    foreach( $rows as $element)
    {
        if(in_array($element->getAttribute("class"),$classChecker,true))
        {

            $index =  array_search($element->getAttribute("class"), $classChecker);


            $temp = array_slice($elementArray, $index , $index +1);
            if( $dom->saveHTML($element->childNodes[7]) < $dom->saveHTML($temp->childNodes[7]))
          {


              $dup = $dom->saveHTML($temp);
              echo  $dup;

             unset($classChecker[ $index ]);
             unset($elementArray[ $index ]);
             array_push($elementArray, $dom->saveHTML($element));
             array_push($classChecker, $element->getAttribute("class"));
          }
            else
            {

                $dup = $dom->saveHTML($element);
                echo  $dup;
            }


        }
        else
      {

            array_push($elementArray, $dom->saveHTML($element));
            array_push($classChecker, $element->getAttribute("class"));
      }


   }


    echo "</table>";


    echo "<table id='results'>";
    echo "<tr> 
            <th>PartNumber</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
           </tr>";
   while(count($elementArray) != 0)
    {
       echo array_pop($elementArray);
   }

    echo "</table>";


}

function displayOrder543($dataBase)
{

    $poID = $_POST["PoID"];
    echo "  <form id='submit' class='mt-5' method='post'> 
     <label id='poLabel'> PoID </label><input id='PoID' class='textField' type='text' name='PoID' value='$poID'><button id='vosubmit' name='ViewOrder'>Search</button>
     </form>";
    //logging
    $query = $dataBase->query("Select ztransactionID543 from zlog543 ORDER BY ztransactionID543 DESC LIMIT 1;");
    $row = $query->fetch_row();
    $transactionID = $row[0] +1;
    $dataBase->query("insert into zlog543 values( '$transactionID','active',  current_time() )");
    try {
        $dataBase->begin_Transaction();


        $query = $dataBase->query(
            "Select * from Zlines543 WHERE ZpoNo543 = '$poID';  ");

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
                echo "<th>$x</th>";
            }
            echo "</tr> ";

        }

       echo "</table>";

        $dataBase->query("insert into zlog543 values( '$transactionID','commit',  current_time() )");
        $dataBase->commit();
    } catch (ErrorException $e)
    {
        $dataBase->query("insert into zlog543 values( '$transactionID','abort',  current_time() )");
        $dataBase->rollback();
        return;
    }
}
