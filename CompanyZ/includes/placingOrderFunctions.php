<?php
if (strpos($_SERVER['REQUEST_URI'], "placingOrderFunctions.php") !== false) {
    header("Location: ../index.php");
    die();

}

//transaction
function PoCi543($dataBase)
{
    $valid = true;
    $line = $_POST["SubmitPO"]+1;
    $client = $_POST["cliendId"];
    $poID = $_POST["PoID"];

    //validation user in and adding to zpos of valid
    if($line ==1)
    {
        try {
            $dataBase->begin_Transaction();
            $query = $dataBase->query(
                "Select * from Zpos543 WHERE ZpoNo543 = '$poID';  ");
            $dataBase->commit();
        }
        catch (ErrorException $e)
        {

            $dataBase->rollback();
            return;
        }
        $row = $query->fetch_row();
        if($row)
        {
            echo "<h3>This purchase order number is already in use</h3>";
            $valid = false;
        }
        try {
            $dataBase->begin_Transaction();
            $query = $dataBase->query(
                "Select * from Zclients543 WHERE ZclientId543 = '$client';  ");
            $row = $query->fetch_row();
            $dataBase->commit();
        }
        catch (ErrorException $e)
       {

           $dataBase->rollback();
           return;
       }
        if(!$row)
        {
            echo "<h3>This client does not exist</h3>";
            $valid = false;
        }
        if($valid)
        {
            try {
                $dataBase->begin_Transaction();
                $query = $dataBase->query(
                    "insert into Zpos543 values('$poID', curdate(), 'processing', '$client');  ");
                $dataBase->commit();
            }
            catch (ErrorException $e)
            {

                $dataBase->rollback();
                return;
            }


        }
    }


    //moving to next form
    if($valid) {
        echo
        " <form id='submit' class='mt-5' method='post'> 
            <div id='formTop'>
                <div><h4 id='poLabel'> PoID: </h4><label id='Po' class='users'  >$poID</label> </div> <div> <h4 id='clientLabel'>Client Id:</h4><label class='users'  id='cliend' >$client</label></div>
                <input  value='$poID' id='PoID' class='textField' type='hidden' name='PoID'><input  value='$client'id='cliendId' class='textField' type='hidden' name='cliendId'>
             </div>
             <div id='lines'>
             ";
        for ($x = 0; $x < $line; $x++) {
            if ($x + 1 == $line) {
                echo "
             <div class='line'>
               <label id='partLabel'> Part Number </label><input id='partNum$x'  class='textField' type='text' name='partNum$x'>
               <label id='quantLabel'> Quantity </label><input id='quant$x'  class='textField' type='text' name='quant$x'>
                
               </div>
              ";
            } else {
                $part = $_POST["partNum$x"];
                $quantity = $_POST["quant$x"];
                echo "
             <div class='line'>
               <label id='partLabel'> Part Number </label><input id='partNum$x'  class='textField' type='text' name='partNum$x' value='$part'>
               <label id='quantLabel'> Quantity </label><input id='quant$x'  class='textField' type='text' name='quant$x' value='$quantity'>
                
               </div>
              ";
            }

        }
        echo "
   <button id='newLine' name='SubmitPO' value='$line'>New Line</button><button id='newLine' name='PlaceOrder' value='$line'>Send Ready</button>  </div></form>";


        echo "<h3>Available  Parts</h3>";
        displayParts543($dataBase);
    }
}

function placing543($dataBase)
{
    echo "<div style='display: none'> ";
    Parts543();
    echo "</div> ";
    $valid = true;
    $line = $_POST["PlaceOrder"];
    $poID = $_POST["PoID"];

    //get parts company quantity from table
    $dom = new DOMDocument();
    $html = ob_get_contents();
    $dom->loadHTML( $html );

    $dom->load("http://localhost/4140A3/CompanyZ/displayTable.php");

    $rows = $dom->getElementsByTagName('tr');

    $partsNoAr = array();
    $priceAr = array();
    $quantityAr = array();
    $companyAr = array();

    $dupsNum = array();
    $dupQ = array();
    $dupPrice = array();
    $dupCompany = array();

    $dubs = true;

    foreach( $rows as $row)
    {
        if( strcmp($row->childNodes[1]->nodeValue,"PartNumber") == 0)
        {
         $dubs = false;
        }
        if($dubs)
        {

            array_push($dupsNum, $dom->saveHTML($row->childNodes[1]));
            array_push($dupPrice, $row->childNodes[7]->nodeValue);
            array_push($dupQ, $row->childNodes[9]->nodeValue);
            array_push($dupCompany, $row->childNodes[11]->nodeValue);
        }
        else {

            array_push($partsNoAr, $dom->saveHTML($row->childNodes[1]));
            array_push($priceAr, $row->childNodes[7]->nodeValue);
            array_push($quantityAr, $row->childNodes[9]->nodeValue);
            array_push($companyAr, $row->childNodes[11]->nodeValue);
        }
    }



    //validating user in
    for($x = $line-1; $x>=0;$x--)
    {

        $part = $_POST["partNum$x"];
        $quantity = $_POST["quant$x"];

        $check = "<th>".$part."</th>";

        $index =  array_search($check , $partsNoAr);


        if($quantity>$quantityAr[$index]) {

            //check for dups


            if( in_array($check, $dupsNum))
            {
                $index2 = array_search($check,$dupsNum);

                if($quantity<$dupQ[$index2]){

                echo "Not enough quantity at that price. New price is ".$dupPrice[$index2];

                $partsNoAr[$index] = $dupsNum[$index2];
                $priceAr[$index] = $dupPrice[$index2];
                $quantityAr[$index] = $dupQ[$index2];


                $companyAr[$index] = $dupCompany[$index2];

                }

                else {
                    echo "<h3> Not Enough Quantity available order rejected</h3>";
                    $valid = false;
                    break;
                }
            }
            else {

                echo "<h3> Not Enough Quantity available order rejected</h3>";
                $valid = false;
                break;
            }
        }
    }
    if($valid)
    {
        //logging
        $query = $dataBase->query("Select ztransactionID543 from zlog543 ORDER BY ztransactionID543 DESC LIMIT 1;");
        $row = $query->fetch_row();
        $transactionID = $row[0] +1;
        $dataBase->query("insert into zlog543 values( '$transactionID','active', current_time() )");

    //X


        $numOfx = 0;
        $numOfy = 0;
        //create url to for Companies API
        $urlX = "http://localhost/4140A3/CompanyX/API/placingOrder.php?client=c7";
        $urlY = "http://localhost/4140A3/CompanyY/API/placingOrder.php?client=c7";
        for($x = $line-1; $x>=0;$x--)
        {
            $part = $_POST["partNum$x"];
            $check = "<th>".$part."</th>";
            $index =  array_search($check , $partsNoAr);
            $quantity = $_POST["quant$x"];


            if( strcmp( $companyAr[$index],  "X") ==0 )
            {

                $urlX = $urlX."&partNum$numOfx=".  $part. "&quant$numOfx=".$quantity ;
                $numOfx ++;
            }
            else
            {
                $urlY = $urlY."&partNum$numOfy=".  $part. "&quant$numOfy=".$quantity ;
                $numOfy ++;
            }


        }


        $urlY = $urlY."&lineNum=".$numOfy;
        $urlX = $urlX."&lineNum=".$numOfx;
        $urlY = $urlY."&transactionID="."0";
        $urlX = $urlX."&transactionID="."0";

        $dataBase->query("insert into zlog543 values( '$transactionID','waiting', current_time() )");
      //submitting a PO with valid number to company
      $response1 = null;
      $x  = 1;
        $transID = 0 ;
        $temp1 ="";
        while (true and $numOfx >0)
        {

            $temp1 = $urlX . "&po=po$x";
            if($transID == 0)
            {
                $temp1 = $temp1."&transactionID=0";
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "$temp1");

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response1 = curl_exec($ch);
            curl_close($ch);

            $dom = (new DOMDocument());
            $dom->loadHTML($response1);
            if($transID == 0) {
                $element = $dom->getElementById("transID")->getAttribute("name");
                $transID = 1;
                $urlX = $urlX . "&transactionID=" . $element;
            }

            $element = $dom->getElementById("invalidPO");
            if($element == null) {
                $element = $dom->getElementById("invalidC");
                if($element == null) {

                    echo "X is ".$response1;


                    break;
                }



            }

            $x = $x +1;
        }


       $y = 1;
       $transID = 0 ;
       $temp2 = "";
        $response2 = null;
        while (true and $numOfy >0)
        {

            $temp2 = $urlY . "&po=po$y";
            if($transID == 0)
            {
                $temp2 = $temp2."&transactionID=0";
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "$temp2");

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response2 = curl_exec($ch);
            curl_close($ch);

            $dom = (new DOMDocument());
            $dom->loadHTML($response2);
            if($transID == 0) {
                $element = $dom->getElementById("transID")->getAttribute("name");
                $transID = 1;
                $urlY = $urlY . "&transactionID=" . $element;
            }

            $element = $dom->getElementById("invalidPO");
            if($element == null) {
                $element = $dom->getElementById("invalidC");
                if($element == null) {

                    echo "Y is ".$response2;

                    break;
                }



            }

            $y = $y +1;
        }

        //Checking for aborting
        $dom->loadHTML($response1);
        $element1 = $dom->getElementById("abort");
        $dom->loadHTML($response2);
        $element2 = $dom->getElementById("abort");

        if($element1 == null and $element2 == null) {

            echo "<p> Participants Voted Commit. Sending Commit message</p>";
            $temp1 = $temp1."&commit=yes";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "$temp1");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);

            $temp2 = $temp2."&commit=yes";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "$temp2");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);

            curl_close($ch);
            echo "order Completed";
            $dataBase->query("insert into zlog543 values( '$transactionID','commit', current_time() )");

        }
        else
        {

            $temp1 = $temp1."&abort=yes";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "$temp1");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);

            $temp2 = $temp2."&abort=yes";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "$temp2");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);

            curl_close($ch);
            echo "order Aborted";
            $dataBase->query("insert into zlog543 values( '$transactionID','abort', current_time() )");
            return;
        }




        //STORING IN Z DB

        for($i = $line-1; $i>=0;$i--)
        {

            $part = $_POST["partNum$i"];
            $quantity = $_POST["quant$i"];
            $check = "<th>".$part."</th>";

            $index =  array_search($check , $partsNoAr);


            $num = $y;
            $comp = 'Y';

            if( strcmp( $companyAr[$index],  "X") ==0 )
            {
                $num = $x;
                $comp = 'X';
            }
            $in = $priceAr[$index];
            try {
                $dataBase->begin_Transaction();

                $query = $dataBase->query(
                    "insert into Zlines543 values('$part','l$i','$poID','$comp' ,'po$num', '$in', '$quantity');");
                $dataBase->commit();
            }
            catch (ErrorException $e)
            {

                $dataBase->rollback();
                return;
            }





        }


        //Y

    }

}
?>