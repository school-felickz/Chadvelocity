<?php

$query = "INSERT INTO $table_name(Oid, ProductName, Quantity, Name, Address) ";
$query = $query . "VALUES('".$lastoid."', '".$product['name']."', '".$item['qty']."', '";
$query = $query . $_SESSION['fname']." ".$_SESSION['lname']."', '";
$query = $query . $_SESSION['addr1']." ".$_SESSION['addr2']."')";
if (!mysql_query($query, $connect)) die('insert into failed, ' . mysql_error());

?>
