<?php

/////////////////////////////////////////////////////////////////////////////////
//        Author:         Chad Bentz
//        URL:            cis.kutztown.edu/~cbent023/travel/php/cartClass.php
//        Course:         Cis242-010,     Fall 2006
//        Instructor:     Dr. Tan
//        Due Date:       End of semester,(shopping cart = due November 21,2006)
//        Assignment:     Final Project
//        Description:    
//			  This cart class is used to hold Product Id-Quantity pairs
//                        and methods to be used in a shopping cart        
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



