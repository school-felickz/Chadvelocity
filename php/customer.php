<?php

/////////////////////////////////////////////////////////////////////////////////
//        Author:         Chad Bentz
//        URL:            cis.kutztown.edu/~cbent023/travel/php/customer.php
//        Course:         Cis242-010,     Fall 2006
//        Instructor:     Dr. Tan
//        Due Date:       End of semester,
//			  (customer info & confirmation due Nov 28), final project Dec 8th
//        Assignment:     Final Project
//        Description:    PHP file to implement a way for the customer purchasing
//			  items from the online store  to enter his/her  
//			  information.  Once the input is verified it will be sent
//			  to the confirmation page for customer review.
/////////////////////////////////////////////////////////////////////////////////


session_start(); //session start before <html> tag



/*

$_SESSION['fname']
$_SESSION['phone']
$_SESSION['addr1']
$_SESSION['addr2']
$_SESSION['city']
$_SESSION['state']
$_SESSION['zip']
$_SESSION['email']
*/

?>

<html>
<head>
<title>Travel Agency Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" type="text/javascript"><!--

function checkValues()
{

    var str = document.getElementById('lname').value;
    var pattern = /^[A-Za-z]{1,30}$/;  
    //alert(str.search(pattern));
	//Verfy that the user has entered a valid last name
	if (str.search(pattern) == -1)
	  {
   		document.getElementById('lname').style.backgroundColor="red";
		alert("Please fill out a valid Last Name (EX: Smith) ");
   		document.getElementById('lname').style.backgroundColor="";
		return false;
	  }

    var str = document.getElementById('fname').value;
    var pattern = /^[A-Za-z]{1,30}$/;  
	//Verfy that the user has entered a valid first name
	if (str.search(pattern) == -1)
	  {
   		document.getElementById('fname').style.backgroundColor="red";
		alert("Please fill out a valid First Name (EX: John) ");
   		document.getElementById('fname').style.backgroundColor="";
		return false;
	  }
	  
    var str = document.getElementById('phone').value;
    var pattern = /^\d{3}-\d{3}-\d{4}$/;  //
	//Verfy that the user has entered a valid phone number	   
	 if (str.search(pattern) == -1)
	   {
	   	document.getElementById('phone').style.backgroundColor="red";
		alert("Please fill out a valid Phone Number (EX: 555-555-1234) ");
	   	document.getElementById('phone').style.backgroundColor="";
		return false;
	   }

    var str = document.getElementById('addr1').value;
    var pattern = /^\w|\s{1,50}$/;  
	//Verfy that the user has entered a valid Address1
	if (str.search(pattern) == -1)
	  {
		document.getElementById('addr1').style.backgroundColor="red";
		alert("Please fill out a valid Address1 ");
		document.getElementById('addr1').style.backgroundColor="";
		return false;
	  }

    var str = document.getElementById('addr2').value;
    var pattern = /^\w|\s{0,50}$/;  
	//Verfy that the user has entered a valid Address2
	if (str.search(pattern) == -1)
	  {
		document.getElementById('addr2').style.backgroundColor="red";
		alert("Please fill out a valid Address2 ");
		document.getElementById('addr2').style.backgroundColor="";
		return false;
	  }

    var str = document.getElementById('city').value;
    var pattern = /^[A-Za-z]{1,25}$/;  
	//Verfy that the user has entered a valid city
	if (str.search(pattern) == -1)
	  {
		document.getElementById('city').style.backgroundColor="red";
		alert("Please fill out a valid City");
		document.getElementById('city').style.backgroundColor="";
		return false;
	  }

	//Verfy that the user has entered a State
	 if( document.form1.state.value == "Choose")
		{
		  document.getElementById('state').style.backgroundColor="red";
		  alert("Please Select A State");
		  document.getElementById('state').style.backgroundColor="";
		  return false;		
		}

    var str = document.getElementById('zip').value;
    var pattern = /^\d{5}$/;  
	//Verfy that the user has entered a valid zip number	   
	 if (str.search(pattern) == -1)
	   {
		document.getElementById('zip').style.backgroundColor="red";
		alert("Please fill out a valid Zip Code (5 digit format) ");
		document.getElementById('zip').style.backgroundColor="";
		return false;
	   }

    var str = document.getElementById('email').value;
    var pattern = /^\S{1,}@\S{2,}\.\S{3}$/;  //
	//Verfy that the user has entered a valid email
	 if (str.search(pattern) == -1) 
	   {
		document.getElementById('email').style.backgroundColor="red";
		alert("Please fill out a valid Email (EX: chad@cool.com) ");
		document.getElementById('email').style.backgroundColor="";
		return false;
	   }

	return true;	
}


//This function is called when the button named "Submit"
//is pressed.  It calls checkValues which will validate
//the form, and if it passes validation, then force the 
//form to submit and cause the form' action event.
function submitform()
{
	//As long as no errors on the form SUBMIT it
		if( checkValues() )
    		{	
		  //alert("should be submitting...");
		 document.form1.submit(); //force the form to submit
		//Php sessions now handle the submit, move over http requests!


		}
}


//--></script>
</head>

<!--background = lightblue//-->
<!--When the page loads then set focus and reset all fields//-->
<body style="text-align:left " bgcolor="#FFFFFF"
     onload="javascript: document.getElementById('lname').focus(); document.getElementById('form1').reset();">
   
<h1 align=center> Please fill out your contact information</h1>

<!-- Travel Agency Form//-->
  <!-- When the form loads, set focus and clear form//-->
<form name="form1" id="form1" method="get" action = "./confirmation.php">

<!-- Table with no boarders for NEATNESS//-->
<table border='0' cellspacing='0' cellpadding='0' align=center>
	<tr><!-- TEXT FIELD //-->
		<td>Last Name: </td>
		<td><input type="text" name="lname" id="lname" size="30" 
		    value=<?php if($_SESSION['lname']) print $_SESSION['lname']; ?> >(ex: Smith)</td>
	</tr>

	<tr><!-- TEXT FIELD //-->
		<td>First Name: </td>
		<td><input type="text" name="fname" id="fname" size="30"
			value=<?php if($_SESSION['fname']) print $_SESSION['fname']; ?> >(ex: John)</td>
	</tr>

	<tr><!-- TEXT FIELD //-->
		<td>Phone: </td>
		<td><input type="text" name="phone" id="phone" size="20" 
			value=<?php if($_SESSION['phone']) print $_SESSION['phone']; ?> >(ex: 333-555-6789)</td>
	</tr>

	<tr><!-- TEXT FIELD //-->
		<td>Address1: </td>
		<td><input type="text" name="addr1" id="addr1" size="50"
				value=<?php if($_SESSION['addr1']) print $_SESSION['addr1']; ?> ></td>
	</tr>

	<tr><!-- TEXT FIELD //-->
		<td>Address2: </td>
		<td><input type="text" name="addr2" id="addr2" size="50"
				value=<?php if($_SESSION['addr2']) print $_SESSION['addr2']; ?> ></td>
	</tr>

	<tr><!-- TEXT FIELD //-->
		<td>City: </td>
		<td><input type="text" name="city" id="city" size="25"
				value=<?php if($_SESSION['city']) print $_SESSION['city']; ?> ></td>
	</tr>

	<tr><!-- DROP DOWN SELECTION BOX (special thanks to yellowpages.com for the list of states//-->
		<td>State: </td>
		<td>
	<select  class="textbox" name="state" id="state" >
	<option value=<?php if($_SESSION['state']) print $_SESSION['state']; ?> > 
		<?php if($_SESSION['state']) print $_SESSION['state']; else print "Choose"; ?>
	<option value="AK">AK<option value="AL">AL<option value="AR">AR<option value="AZ">AZ<option value="CA">CA
	<option value="CO">CO<option value="CT">CT<option value="DC">DC<option value="DE">DE<option value="FL">FL
	<option value="GA">GA<option value="HI">HI<option value="IA">IA<option value="ID">ID<option value="IL">IL
	<option value="IN">IN<option value="KS">KS<option value="KY">KY<option value="LA">LA<option value="MA">MA
	<option value="MD">MD<option value="ME">ME<option value="MI">MI<option value="MN">MN<option value="MO">MO
	<option value="MS">MS<option value="MT">MT<option value="NC">NC<option value="ND">ND<option value="NE">NE
	<option value="NH">NH<option value="NJ">NJ<option value="NM">NM<option value="NV">NV<option value="NY">NY
	<option value="OH">OH<option value="OK">OK<option value="OR">OR<option value="PA">PA<option value="RI">RI
	<option value="SC">SC<option value="SD">SD<option value="TN">TN<option value="TX">TX<option value="UT">UT
	<option value="VA">VA<option value="VT">VT<option value="WA">WA<option value="WI">WI<option value="WV">WV
	<option value="WY">WY
	</select>  			
		</td>
	</tr>

	<tr><!-- TEXT FIELD //-->
		<td>Zip Code: </td>
		<td><input type="text" name="zip" id="zip" size="5"
				value=<?php if($_SESSION['zip']) print $_SESSION['zip']; ?> >(ex: 19508)</td>
	</tr>

	<tr><!-- TEXT FIELD //-->
		<td>Email: </td>
		<td><input type="text" name="email" id="email" size="20"
				value=<?php if($_SESSION['email']) print $_SESSION['email']; ?> >(ex: chad@cool.com)</td>
	</tr>
		
</table>

<br>
<br>
<br>

<!-- not a submit, rather a button called submit//-->
 <center>
  <input type="button" value="Submit"
         onclick="javascript: submitform()" >
  <input type="reset">
 </center>
</form>
</body>
</html><!-- Close of Webpage //-->


