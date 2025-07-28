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
//                        and methods to         
/////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////
//Class:      Cart()
//Purpose:    An object oriented approach to a shopping cart
//            Holds items from a catalog, 
//            Indexed by pid ( Product ID),
// 	      and also holds the quantity for that item
//Attributes: $items array, $qtys array
//Methods:    addItem(), delItem(), getContents()
//Credits:    Design of the cart object 
//            adapted from webforce.co.nz/cart
class Cart {

	//Array Holding the Items
	var $items = array();
	//Array Holding quantity, indexed by item's pid
	var $qtys = array(); 


	/////////////////////////////////////////////////
	//Function: addItem()
	//Purpose: add an item-quantity pair to the cart
	//Parameters: pid = unique id of product
	//            qty = quantity of the product
	function addItem($pid,$qty)
	{ 
		if($this->qtys[$pid] > 0) //Increase the quantity
                { 
		     //Increase the quantity by the qty passed into function
		       $this->qtys[$pid] = $qty+$this->qtys[$pid];
		}
		else
		 {
		        //print "A QUANTITY DOESNT YET EXIST";
			$this->items[]=$pid;
			$this->qtys[$pid] = $qty;
 		 }
	}

	/////////////////////////////////////////////////
	//Function: updateItem()
	//Purpose: update an item-quantity pair in the
	//Parameters: pid = unique id of product
	//            qty = quantity of the product
	function updateItem($pid,$qty)
	{ 
		if($this->qtys[$pid] > 0) //Increase the quantity
                { 
		    //Update quantity by assigning the passed qty
		       $this->qtys[$pid] = $qty;
		}
		else
		 {
		        //print "A QUANTITY DOESNT YET EXIST";
			$this->items[]=$pid;
			$this->qtys[$pid] = $qty;
 		 }
	}

	/////////////////////////////////////////////////
	//Function: delItem()
	//Purpose: removes an item from the cart
	//         -sets quantity to 0 and removes it from items array
	//Parameters: pid = unique id of product
	//
	function delItem($pid)
	{ 
		$this->qtys[$pid] = 0;

		$newArray = array();
		//Assign items array to the old array EXCLUDING pid to delete
		foreach($this->items as $item)
		{
			if($item != $pid) //As long as its not the pid to delete
			    $newArray[] = $item;
		}
		$this->items = $newArray; 
	}

	/////////////////////////////////////////////////
	//Function: getContents()
	//Purpose: returns an array which contains the cart's
	//Parameters: none
	//Credits: Loop is similar to the loop 
	//         within webforce.co.nz/cart
	function getContents()
	{ 
		$items = array();
		foreach($this->items as $tmp_item)
		{
			$item['pid'] = $tmp_item;
                        $item['qty'] = $this->qtys[$tmp_item];
                        $items[] = $item;
		}
		return $items;

	} // end of get_contents
}


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
if($_REQUEST['update']) { //AKA add=HAS A VALUE
	$cart->updateItem($_REQUEST['pid'], $_REQUEST['qty']);
}

if($_REQUEST['remove']) {
	$rid = intval($_REQUEST['pid']);
	$cart->delItem($rid);
}

?>

<html><head><title>Shopping Cart</title>
</head>
<body bgcolor="#FFFFFF">

<h1>Chadvelocity.com Shopping Cart</h1>
<a href="javascript:history.go(-1)">Continue Shopping</a>&nbsp&nbsp
<a href="javascript:alert('checkout goes here');">Proceed To Checkout</a>
<br><br>
<?php 

$server = 'localhost'; $user = 'cbent023'; $mydb = 'cbent_db';
$table_name = 'Products';
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


