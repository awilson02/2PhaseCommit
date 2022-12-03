<?php
if (strpos($_SERVER['REQUEST_URI'], "mainButtonfunctions.php") !== false) {
    header("Location: ../index.php");
    die();

}

function PlaceOrderForm543()
{
    $line = 0;

    echo "  <form id='submit' class='mt-5' method='post'> 
             <label id='poLabel'> PoID </label><input id='PoID' class='textField' type='text' name='PoID'> <label id='clientLabel'> Client Id </label><input id='cliendId' class='textField' type='text' name='cliendId'><button id='ordersSubbmit' value=0 name='SubmitPO'>Submit Order</button>
              </form>";
}


function ViewOrdersForm543()
{
    echo "  <form id='submit' class='mt-5' method='post'> 
              <label id='clientLabel'> Client Id </label><input id='cliendId' class='textField' type='text' name='cliendId'><button id='ordersSubbmit' name='ViewOrders'>Search</button>
              </form>";
}

function ViewOrderForm543()
{
    echo "  <form id='submit' class='mt-5' method='post'> 
     <label id='poLabel'> PoID </label><input id='PoID' class='textField' type='text' name='PoID'><button id='vosubmit' name='ViewOrder'>Search</button>
     </form>";
}

function Parts543($dataBase)
{

    displayParts543($dataBase);
}
?>