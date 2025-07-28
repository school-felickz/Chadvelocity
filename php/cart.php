<?php

/////////////////////////////////////////////////////////////////////////////////
//        Author:         Chad Bentz
//        URL:            cis.kutztown.edu/~cbent023/travel/php/cart.php
//        Course:         Cis242-010,     Fall 2006
//        Instructor:     Dr. Tan
//        Due Date:       End of semester,(shopping cart = due November 21,2006)
//        Assignment:     Final Project
//        Description:    PHP file to implement a Session based shopping cart,
//			  A cart class is used to hold Product Id-Quantity pairs
//                        and methods to be used for holding items added to the cart        
/////////////////////////////////////////////////////////////////////////////////


include "cartClass.php"; //Class for the shopping cart INCLUDES BEFORE SESSION.

session_start(); //session start before <html> tag

//Session Handling

//Local $cart is the SESSION['Cart']
$cart =& $_SESSION['Cart'];  
//if the cart doesn't yet exist, create a new cart
if(!is_object($cart)) $cart = new Cart();

//REQUEST HANDLING (POST OR GET FOR NOW)

if($_REQUEST['add']) { //AKA add=HAS A VALUE
//	$product = $products[$_REQUEST['pid']];
	$cart->addItem($_REQUEST['pid'], $_REQUEST['qty']);
}
if($_REQUEST['update']) { //AKA update=HAS A VALUE
	$cart->updateItem($_REQUEST['pid'], $_REQUEST['qty']);
}

if($_REQUEST['remove']) { //AKA remove has a value
	$rid = intval($_REQUEST['pid']);
	$cart->delItem($rid);
}

?>

<html><head><title>Shopping Cart</title>
</head>
<body bgcolor="#FFFFFF">

<h1>Chadvelocity.com Shopping Cart</h1>
<a href="javascript:history.go(-1)">Continue Shopping</a>&nbsp&nbsp
<a href="./customer.php">Proceed To Checkout</a>
<br><br>
<?php 

//Set up configuration
$server = 'localhost'; 
$user = 'cbent023'; 
$mydb = 'cbent_db';
$table_name = 'Products';

//mySQL connection code borrowed and adapted from Dr. Joo Tan's Examples

$connect = mysql_connect($server, $user);

if (!$connect) die('connect failed, ' . mysql_error()); // connect to MySQL
if (!mysql_select_db($mydb)) die('select failed, ' . mysql_error()); // select a database

//Build Products Array
// select
$query = "SELECT * FROM $table_name";
if (!$results_id = mysql_query($query, $connect)) die('select failed, ' . mysql_error());
else
{
 //Load the items into a local array
	$products = array();
	$prodIdx = 1;
	while ($row = mysql_fetch_row($results_id))
	{
  	  //Reference products by PID
	  $products[$prodIdx] = array("pid"=>$row[0],"name"=>$row[1],"type"=>$row[2],"cost"=>$row[3],"img"=>$row[4]);
	  $prodIdx++;
	}
}//As long as DB SELECT succeeded
mysql_close($connect);

//Construct an html table to display the contents of the shopping cart
print '<table border="0" cellpadding="8" cellspacing="1">';
print '<th bgcolor="#C0C0C0"><th bgcolor="#C0C0C0">Description<th bgcolor="#C0C0C0">Type'.
      '<th bgcolor="#C0C0C0">Cost<th bgcolor="#C0C0C0">Qty<th bgcolor="#C0C0C0"><th bgcolor="#C0C0C0">Total';

//We must keep track of the running subtotal of each item
$subtotal = 0.00;
//Make it a double for sure!
settype($subtotal, double);
$frmct=1;
	foreach($cart->getContents() as $item) //Use of cart getContents loop was adapted from webforce.co.nz/cart
	 {
	        //A "product" is selected from the Products array which was populated via the Database
		$product = $products[$item['pid']];  

		print "<tr>";
		print "<td><img src='".$product['img']."'></td>";
        //Users do not care about the pid!		print "<td>".$item['pid']."</td>";
		print "<td>".$product['name']."</td>";
		print "<td>".$product['type']."</td>";
		print "<td>$".$product['cost']."</td>";
	//Get quantity from cart, do error checking for an integer on submit
	//Use hidden value for the PID to send to the query String, along with
	//the qty and either submital type (add or remove)
		print "<td><form name='form".$frmct."' method=get ".
                      "onsubmit='return /^\d{1,}$/.test(this.qty.value)'/>".
		      "<input type='textarea' id='qty' name='qty' value='".$item['qty']."'size='1'></td>".
		      "<td><input type='submit' name='update' value='Update Qty'><br>".
		      "<input type='submit' name='remove' value='   Remove  '".
		      " onclick='if(isNaN(form".$frmct.".qty.value)) form".$frmct.".qty.value=0'/>".
		      "<input type='hidden' name='pid' value='".$item['pid']."'/></form></td>";
	//Update the running subtotal(subtotal += current product cost * current product quantity)
    	        $subtotal += $product['cost']*$item['qty'];
		print "<td>$".number_format($product['cost']*$item['qty'],2)."</td>"; //2 digit decimal!
		print "</tr>";
	  $frmct++;
	}
	
	print '<tr>';
	print '<td></td><td></td>';
	print '<td></td><td></td><td></td>';
	print '<td bgcolor="#C0C0C0">Subtotal:</td><td>$'.number_format($subtotal,2).'</td>';
	print '</tr>';
	print '</table>';
?>


</body>
</html>


