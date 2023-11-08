Overview:
========
Simple E-Commerce System: a web interface that implements a simple and secure e-commerce system using PHP and MySQL.

Used Tools:
==========
- Apache/2.2.22 (Ubuntu)
- MySQL client version: 5.5.24
- PHP extension: mysqli

- phpMyAdmin version: 3.4.10.1deb1


Application Structure:
=====================

index.php
---------
First page of the application. This page shows the store window with products, price and store availability.
The user can Log In if he's already registered or Sign Up if he's not.
Doing the Log In, the user will be redirected to the Store page.
If a User Session is open, all the requests for the Index page will be redirected to the Store page.
Dependencies:
	index.php -> Log In -> store.php
	index.php -> Sign Up -> register.html

register.html
-------------
User Registration From.
Dependencies:
	register.html -> Register -> registration.php

registration.php
----------------
This module gets the user paramters from the Registration Form, performs the appropriate checks and writes the user data in the database (user table).
Dependencies:
	registration.php -> index.php

store.php
---------
In this page the user can choose the products he wants to buy. A lateral bar indicates the log status and the cart status.
Dependencies:
	store.php -> Add Items to the Cart -> addcart.php
	store.php -> Show the Cart -> showcart.php

addcart.php
-----------
This module gets the cart parameters from the Add To Cart Form, performs the appropriate checks and write the cart data in the database (cart table).
At the end of all the operation, the module redirects the user to the Store page.
Dependencies:
	addcart.php -> store.php

showcart.php
-----------
This page shows the Cart with products, quantity and total amount of chosen products.
The user can pay for the chosen products (putting the credit card parameters), empty the cart or go back to the store.
Dependencies:
	showcart.php -> Checkout -> pay.php
	showcart.php -> Empty Cart -> emptycart.php
	showcart.php -> store.php

emptycart.php
-------------
This module deletes from the database the data from the cart table for the currently logged on user.
At the end of all the operations, the module redirects the user to the Store page.
Dependencies:
	emptycart.php -> store.php

pay.php
-------
This module gets the credit card parameters from the Payment Form, checks if the chosen products are still available on the store and than simulates a payment transation.
The payment transation is performed using a random function.
In case of successful transation, the module empties the cart.
Dependencies:
	pay.php -> store.php

LOGOUT
------
It's possible do the Log Out from different pages using the lateral bar.
The Log Out operation redirects the user to the Index page.
Pages:
	store.php
	showcart.pgp
	pay.php	


Database Tables:
===============

- products -
------------------------------
| id | item | prize | number |
------------------------------
	- id: 		product id;
	- item: 	product name;
	- prize: 	product price;
	- number: 	product availability.

- users -
--------------------------------------------------------------------
| name | surname | country | address | email | username | password |
--------------------------------------------------------------------

- cart -
----------------------------
| sid | id_item | quantity |
----------------------------
	- sid: 		$_SESSION['username'] (super global variable);
	- id_item : 	product id;
	- quantity:	item quantity to buy.

- sessions -
-------------------------
| sid | sdata | sexpire |
-------------------------
	- sid: 		session id;
	- sdata:	session data corresponding with $_SESSION['username'];
	- sexpire:	session expiration time.


NOTE ABOUT THE CART AND THE SESSION MANAGEMENT:
==============================================
Adding items to the cart the database table product is not modified so the product availability remains unchanged until the successful payment.
In the Session Garbage Collector, a cart connected to a session is deleted if the session expires or if it is destroyed.


ATOMIC OPERATIONS / LOCKS:
=========================

New User Registration
	File: 		registration.php
	Locked tables: 	users(WRITE)

Add items to the cart
	File: 		addcart.php
	Locked tables:	cart(WRITE)

Empty the cart
	File:           addcart.php
        Locked tables:  cart(WRITE)

Payment 
	File:		pay.php
	Locked tables:	products(WRITE), cart(WRITE)	
	
Session Garbage Collector
	File:		class_session.php
	Locked tables:	cart(WRITE), sessions(WRITE)

