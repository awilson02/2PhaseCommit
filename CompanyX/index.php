<?php

    require_once "db.php";
    require_once "includes/mainButtonfunctions.php";
    require_once "includes/displayTable.php";
    require_once "includes/placingOrderFunctions.php";
    $line = 0;

?>



<!DOCTYPE html>
<html lang = "en">

<head >
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
</head>




<body>
<section id="top">
    <h1>Company X!</h1>

</section>
<header>
    <title> Company X! </title>
</header>
<div id="buttons">
    <form id="buttonForm"  method="post">
        <button id="PO" name="PlaceOrderForm">Place Order</button>
        <div id="clientId">
            <button id="VO" name="ViewOrderForm">View an Order</button>
        </div>

        <div id="clientId">

            <button id="VOS" name="ViewOrdersForm">View orders</button>
        </div>

        <button id="PA" name="Parts">Available Parts</button>
    </form>


</div>


</body>

<!-- Forms for each button -->
<?php
if(isset($_POST["PlaceOrderForm"]))
{
    PlaceOrderForm543();

}
else if(isset($_POST["ViewOrdersForm"])) {

    ViewOrdersForm543();

}

else if(isset($_POST["ViewOrderForm"]))
{

    ViewOrderForm543();

}?>
<!-- Purchase Order Form -->
<?php

if(isset($_POST["SubmitPO"]))
{
    PoCi543($dataBase);
}



?>

<!-- Table Output -->

<?php

if(isset($_POST["PlaceOrder"]))
{
   placing543($dataBase);

}
else if(isset($_POST["ViewOrders"]))
{

    displayPo543($dataBase);

}


else if(isset($_POST["Parts"]))
{

    Parts543($dataBase);
}

else if(isset($_POST["ViewOrder"]))
{

    displayOrder543($dataBase);

}?>

</html>