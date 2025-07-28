<?php

/////////////////////////////////////////////////////////////////////////////////
//        Author:         Chad Bentz
//        URL:            cis.kutztown.edu/~cbent023/travel/php/thankyou.php
//        Course:         Cis242-010,     Fall 2006
//        Instructor:     Dr. Tan
//        Due Date:       End of semester
//        Assignment:     Final Project
//        Description:    Implement a database containing all orders placed to 
//			  the travel agency
/////////////////////////////////////////////////////////////////////////////////


include "cartClass.php"; //Class for the shopping cart INCLUDES BEFORE SESSION.

session_start(); //session start before <html> tag

//Session Handling

//Local $cart is the SESSION['Cart']
$cart =& $_SESSION['Cart'];
//if the cart doesn't yet exist, create a new cart
if(!is_object($cart)) $cart = new Cart();

//REQUEST HANDLING (POST OR GET FOR NOW)

if($_REQUEST['paytype']) { //AKA HAS A VALUE
      $_SESSION['paytype'] = $_REQUEST['paytype'];
}

?>
<html>
<head>

<script language="javascript" type="text/javascript"></script>
<title>Thankyou</title>
</head>
<body bgcolor="#FFFFFF">
<center>
<h1>Thankyou!</h1>
</center>


<?php


//SQL TO BUILD THE PRODUCTS ARRAY

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




//      Credit:         Page:   http://faculty.kutztown.edu/tan/cis242/datafiles/create_product_table2.txt
//                      Author: Joo Tan, Create Product Table Example


//Set up configuration
$server = 'localhost';
$user = 'cbent023';
$mydb = 'cbent_db';
$table_name = 'Purchases';



$connect = mysql_connect($server, $user);
if (!$connect) die('connect failed, ' . mysql_error()); // connect to MySQL

if (!mysql_select_db($mydb)) die('select failed, ' . mysql_error()); // select a database

// delete a table
/*
$query = "DROP TABLE IF EXISTS $table_name";
if (!mysql_query($query, $connect)) die('drop failed, ' . mysql_error());
*/

// create a table
/*
$query = "CREATE TABLE IF NOT EXISTS $table_name ";
$query = $query . "(ProductID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,  ";
$query = $query . "ProductName VARCHAR(50), ProductType VARCHAR(20), Cost DECIMAL(10,2), Images VARCHAR(50))";
*/

$query = "CREATE TABLE IF NOT EXISTS $table_name ";
$query = $query . "(Oid INT UNSIGNED NOT NULL, ";
$query = $query . "Timestamp TIMESTAMP NOT NULL, ";
$query = $query . "ProductName VARCHAR(50), Quantity DECIMAL(4,0), Name VARCHAR(61), Address VARCHAR(101))";
if (!mysql_query($query, $connect)) die('create failed, ' . mysql_error());


// insert into a table
/*
$query = "INSERT INTO $table_name VALUES('0', 'Canon Powershot A510', '225.00', 'canon_powershot_a510_tn.gif')";
if (!mysql_query($query, $connect)) die('insert into failed, ' . mysql_error());
$query = "INSERT INTO $table_name VALUES('0', 'Canon Powershot A520', '179.94', 'canon_powershot_a520_tn.gif')";
if (!mysql_query($query, $connect)) die('insert into failed, ' . mysql_error());
*/



	$query = "SELECT Oid  FROM $table_name ORDER BY Oid";
	if (!$results_id = mysql_query($query, $connect)) die('select failed, ' . mysql_error());
	while ($row = mysql_fetch_row($results_id))
	{
	 $lastoid = $row[0];
	}
	//print "<br>".$lastoid."=lastoid";

	$lastoid ++; //This will setup our database to have the same oid for each item purchased
	


	//Get the contents of the cart
	foreach($cart->getContents() as $item) //Use of cart getContents loop was adapted from webforce.co.nz/cart
	 {

	        //A "product" is selected from the Products array which was populated via the Database
		$product = $products[$item['pid']];  

/*		
		print $product['name'];
		print $item['qty'];
		print $_SESSION['fname']." ".$_SESSION['lname'];
		print $_SESSION['addr1']." ".$_SESSION['addr2'];
		print "<br>";
*/


		$query = "INSERT INTO $table_name(Oid, ProductName, Quantity, Name, Address) ";
		$query = $query . "VALUES('".$lastoid."', '".$product['name']."', '".$item['qty']."', '";
		$query = $query . $_SESSION['fname']." ".$_SESSION['lname']."', '";
		$query = $query . $_SESSION['addr1']." ".$_SESSION['addr2']."')";
		if (!mysql_query($query, $connect)) die('insert into failed, ' . mysql_error());

	}




/*
// load data from a text file
// dir of file /users/student/cbent023/public_html/travel/php/products.txt
$query = 
"LOAD DATA INFILE '/users/student/cbent023/public_html/travel/php/products.txt' INTO TABLE $table_name FIELDS TERMINATED BY ', '";
if (!mysql_query($query, $connect)) die('load data failed, ' . mysql_error());
*/


// select

//$query = "SELECT *, Unix_Timestamp(Timestamp) FROM $table_name ORDER BY Oid DESC";
$query = "SELECT * FROM $table_name ORDER BY Oid DESC";
if (!$results_id = mysql_query($query, $connect)) die('select failed, ' . mysql_error());
print '<CENTER>';
print '<table border=1>';
print '<th>OrderID<th>TimePurchased<th>Product<th>Qty<th>Name<th>Address';
while ($row = mysql_fetch_row($results_id))
{
//$date=date("m-d-Y H:i:sa",$row[1]); 

        print '<tr>';
        print "<td>$row[0]</td>";         //Oid
        print "<td>$row[1]</td>";         //Time
        print "<td>$row[2]</td>";         //Product
        print "<td>$row[3]</td>";         //Qty
        print "<td>$row[4]</td>";         //Name
        print "<td>$row[5]</td>";         //Address
        print '</tr>';
//	print '<script>alert("size is'.sizeof($row).'")</script>';
}
print '</table>';
print '<CENTER>';
mysql_close($connect);
?>

</body>
</html>














