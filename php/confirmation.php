<?php

/////////////////////////////////////////////////////////////////////////////////
//        Author:         Chad Bentz
//        URL:            cis.kutztown.edu/~cbent023/travel/php/confirmation.php
//        Course:         Cis242-010,     Fall 2006
//        Instructor:     Dr. Tan
//        Due Date:       End of semester,(shopping cart = due November 28,2006)
//        Assignment:     Final Project
//        Description:    PHP file to confirm a shoppers personal information,
//			  and display the contents of their cart for CONFIRMATION
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


//Store customer info into session

if($_REQUEST['lname']) { //AKA if has a value
	$_SESSION['lname'] = $_REQUEST['lname'];
}
if($_REQUEST['fname']) { //AKA if has a value
	$_SESSION['fname'] = $_REQUEST['fname'];
}
if($_REQUEST['phone']) { //AKA if has a value
	$_SESSION['phone'] = $_REQUEST['phone'];
}
if($_REQUEST['addr1']) { //AKA if has a value
	$_SESSION['addr1'] = $_REQUEST['addr1'];
}
if($_REQUEST['addr2']) { //AKA if has a value
	$_SESSION['addr2'] = $_REQUEST['addr2'];
}
if($_REQUEST['city']) { //AKA if has a value
	$_SESSION['city'] = $_REQUEST['city'];
}
if($_REQUEST['state']) { //AKA if has a value
	$_SESSION['state'] = $_REQUEST['state'];
}
if($_REQUEST['zip']) { //AKA if has a value
	$_SESSION['zip'] = $_REQUEST['zip'];
}
if($_REQUEST['state']) { //AKA if has a value
	$_SESSION['email'] = $_REQUEST['email'];
}


?>

<html><head>
<title>Shopping Cart</title>
<script language="javascript" type="text/javascript"><!--


//CODE ADAPTED FROM JOO TAN, KUTZTOWN UNIVERSITY
var mylocation = document.location.toString();  //Gets the URL string
var index1 = mylocation.indexOf("?");  //Find first occurance of the '?' 
									   //Meaning the start of the Query String
queryString = mylocation.substring(index1 + 1);  //queryString begins with first name

Pairs = new Array();
Pairs = queryString.split("&");/* Pairs[0] = "lname=Bentz", Pairs[1] = "fname=Chad" */

/////////////////////////////////
////GET THE PAIRED VALUES////////
/////////////////////////////////

Lname      = Pairs[0].split("=");
Fname      = Pairs[1].split("=");
Phone      = Pairs[2].split("=");
Address1    = Pairs[3].split("=");
Address2    = Pairs[4].split("=");
City       = Pairs[5].split("=");
State      = Pairs[6].split("=");
Zip        = Pairs[7].split("=");
Email      = Pairs[8].split("=");


function verifyForm(Formname)
{


	//Verfy that the user has entered a destination
		for(i=0;i<3;i++)
		{
		  if(Formname.paytype[i].checked == true) 
	    	     {
			Formname.submit();
			return true;
		     } 
		}
		
		alert("Please Select A Pay Type");
		return false;

}
//--></script>
</head>
<body bgcolor="#FFFFFF">
<CENTER>
	<!-- HEADING OF BODY == Form Submitter's first name //-->
	<h2 align=center> 
 	<span>
 		<script language="javascript"><!--
			 //document.writeln(Aname[1].replace('+', ' '));
			 document.writeln(Fname[1]);
 		//--></script>
 	</span>
    , Please Confirm Your Information and Products Selected!</h2>

<h6><br>

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
print '<th bgcolor="#C0C0C0">Description<th bgcolor="#C0C0C0">Type'.
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
//		print "<td><img src='".$product['img']."'></td>";
        //Users do not care about the pid!		print "<td>".$item['pid']."</td>";
		print "<td>".$product['name']."</td>";
		print "<td>".$product['type']."</td>";
		print "<td>$".$product['cost']."</td>";
		print "<td>".$item['qty']."</td>";
		print "<td><form name='form".$frmct."' action='./cart.php'>";
		print "<input type='submit' value='Update'></form></td>";

	//Update the running subtotal(subtotal += current product cost * current product quantity)
    	        $subtotal += $product['cost']*$item['qty'];
		print "<td>$".number_format($product['cost']*$item['qty'],2)."</td>"; //2 digit decimal!
		print "</tr>";
	  $frmct++;
	}
	
	print '<tr>';
	print '<td></td><td></td>';
	print '<td></td><td></td>';
	print '<td bgcolor="#C0C0C0">Subtotal:</td><td>$'.number_format($subtotal,2).'</td>';
	print '</tr>';
	print '</table>';


?>
<!-- HTML CODE ADAPTED FROM JOO TAN EXAMPLE: 
http://faculty.kutztown.edu/tan/cis242/datafiles/page2.htm
 //-->
</h6><table width=75% cellpadding=20> <!--Table with two columns for tidy upkeep //-->
<td bgcolor="#C0C0C0"> <!-- DISPLAY OUTPUT SPANS IN A H3 SIZE //-->
    <h3>Contact Information</h3><h4>
	Name:
    <span id="spanName" style="color: green ">
 		<script language="javascript"><!--
 			//Output the submitter's name
 			document.getElementById('spanName').innerHTML = Fname[1]+" "+Lname[1];
 		//--></script>
 	</span><br>
 	Phone: 
	<span id="spanPhone" style="color: green ">
 		<script language="javascript"><!--
 			//Output the phone number as sent
 			document.getElementById('spanPhone').innerHTML = Phone[1];
 		//--></script>
 	</span> <br>

 	Address: 
	<span id="spanAddr" style="color: green ">
 		<script language="javascript"><!--
			if( Address2[1] == "" )
 			  document.getElementById('spanAddr').innerHTML = Address1[1].replace('+', ' ');
			else 
 			  document.getElementById('spanAddr').innerHTML = Address1[1].replace('+', ' ')+
						", " + Address2[1].replace('+', ' ');
 		//--></script>
 	</span> <br>

 	City: 
	<span id="spanCity" style="color: green ">
 		<script language="javascript"><!--
 			document.getElementById('spanCity').innerHTML = City[1];
 		//--></script>
 	</span> <br>

 	State: 
	<span id="spanState" style="color: green ">
 		<script language="javascript"><!--
 			//Output the state
 			document.getElementById('spanState').innerHTML = State[1];
 		//--></script>
 	</span> <br>

 	Zipcode: 
	<span id="spanZip" style="color: green ">
 		<script language="javascript"><!--
 			//Output the zip
 			document.getElementById('spanZip').innerHTML = Zip[1];
 		//--></script>
 	</span> <br>


	Email:
	<span style="color: green ">
	 	<script language="javascript"><!--
		     //Replace %40 Encoding with the @ symbol
			 document.writeln(Email[1].replace('\%40', '@'));
 		//--></script>
	</span>
	<br>
        <input type="button" onClick="javascript:history.go(-1)" value="Edit Info">
   </h4>
</td>
<td bgcolor="#C0C0C0">
<?php
//Payment Types
	print '<h3>Payment Type</h3>';
	print '<br>';
	print '<form id="navbuttons" name="navbuttons" action="./thankyou.php" >';
	print '<input type="radio" name="paytype" value="Phone" id="radio_phone">Phone<br>';
  	print '<input type="radio" name="paytype" value="Email" id="radio_email">Email<br>';
  	print '<input type="radio" name="paytype" value="Credit Card" id="radio_credit">Credit Card<br><br>';
	print 'Total:&nbsp;&nbsp;&nbsp;$'.number_format($subtotal,2).'<br>';
	print "<br><input type='button' value='CANCEL' onClick=javascript:history.go(-2) >";
	print '<input type="button" value="FINALIZE ORDER" onClick="javascript:verifyForm(navbuttons);">';
	print '</form>';

?>
</td>
</table>
<br><br>




</CENTER>
</body>
</html>










