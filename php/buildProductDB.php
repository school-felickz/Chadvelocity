<html><head><title>Create Product Table</title></head>
<!-- 
	Author: 	Chad Bentz
	URL: 		cis.kutztown.edu/~cbent023/travel/php/buildDB.php
	Course:         Cis242-010, 	Fall 2006
	Instructor:	Dr. Tan
	Due Date: 	End of semester, (Shopping cart = November 20, 2006)
	Assignment: 	Final Project
	Credit:   	
			Page:   http://faculty.kutztown.edu/tan/cis242/datafiles/create_product_table2.txt
			Author: Joo Tan, Create Product Table Example
	Description:	
			Design and Implement a Travel/Vaction Site utilizing a catalog, shopping cart while
	                storing data in mySQL databases and using php server code.

	Output:         A mySQL table name Products in the cbent_db is created by running this .php file.
			It is then populated with the information in the products.txt file for easy upkeep.	

-->

<body>
<?php

//	Credit:  	Page:   http://faculty.kutztown.edu/tan/cis242/datafiles/create_product_table2.txt
//			Author: Joo Tan, Create Product Table Example


//Set up configuration
$server = 'localhost';
$user = 'cbent023';
$mydb = 'cbent_db';
$table_name = 'Products';



$connect = mysql_connect($server, $user); 
if (!$connect) die('connect failed, ' . mysql_error()); // connect to MySQL

if (!mysql_select_db($mydb)) die('select failed, ' . mysql_error()); // select a database

// delete a table
$query = "DROP TABLE IF EXISTS $table_name";
if (!mysql_query($query, $connect)) die('drop failed, ' . mysql_error());

// create a table
$query = "CREATE TABLE $table_name ";
$query = $query . "(ProductID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, ";
$query = $query . "ProductName VARCHAR(50), ProductType VARCHAR(20), Cost DECIMAL(10,2), Images VARCHAR(50))";
if (!mysql_query($query, $connect)) die('create failed, ' . mysql_error());

// insert into a table  (JUST HERE FOR EXAMPLE)
/*
$query = "INSERT INTO $table_name VALUES('0', 'Canon Powershot A510', '225.00', 'canon_powershot_a510_tn.gif')";
if (!mysql_query($query, $connect)) die('insert into failed, ' . mysql_error());
$query = "INSERT INTO $table_name VALUES('0', 'Canon Powershot A520', '179.94', 'canon_powershot_a520_tn.gif')";
if (!mysql_query($query, $connect)) die('insert into failed, ' . mysql_error());
*/


// load data from a text file
// dir of file /users/student/cbent023/public_html/travel/php/products.txt
$query = "LOAD DATA INFILE '/users/student/cbent023/public_html/travel/php/products.txt' INTO TABLE $table_name FIELDS TERMINATED BY ', '";
if (!mysql_query($query, $connect)) die('load data failed, ' . mysql_error());

// select 
$query = "SELECT * FROM $table_name";
if (!$results_id = mysql_query($query, $connect)) die('select failed, ' . mysql_error());
print '<table border=1>';
print '<th>ProductID<th>ProductName<th>ProductType<th>Cost<th>Image';
while ($row = mysql_fetch_row($results_id))
{
	print '<tr>';
	print "<td>$row[0]</td>";         //The automatically incremented Primary Key
	print "<td>$row[1]</td>";	  //Name of the product
	print "<td>$row[2]</td>";	  //Type of the product
	print "<td>\$ $row[3]</td>";	  //Cost of the product
	print '<td><img src="' . $row[4] . '" /> </td>';
	print '</tr>';
}

mysql_close($connect);
?></body></<html>











