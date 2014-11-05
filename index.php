<?php
	//FORCE DISPLAY OF ERRORS TO BROWSER
	//ini_set("display_errors", 1);
	//ERROR_REPORTING(E_ALL);
	//INCLUDE CONNECTION/MISC FUNCTION PAGES
	include "function_page.php";
	include "db_connect.php";
	//BEGIN SESSION
	session_start();
?>

<!DOCTYPE html PUBLIC "http://babbage.cs.missouri.edu/~cs3380f12grp1/">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Description of our online store page." />
<meta name="keywords" content="keywords, will, go here, when determined" />
<meta name="author" content="Team" />
<link rel="stylesheet" type="text/css" href="reset.css" media="screen" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen,print" />
<title>gangnam // groceries</title> 
</head>
<body>

<div id="mainContainer" class="clearfix">

<div id="header">
<a href="index.php">
<img src='images/banner.png' alt='gangnam // groceries' width ='890' height = '90'>
</a>
</div><!--// end #header //-->

<div id="navHorizontal">
	<fieldset name='search'>
	<form method='GET' action='search.php'>
		
		<label for='search' >search for items: </label>
		<input type='text' name='search' />	
		<input type='submit' name='submit', value='search.' />
	</form>
	</fieldset>
</div><!--// end #navHorizontal //-->

<div id="columnOne">

<?php
	
	//Begin IF user logged in statements
	if(isset($_SESSION['userid'])) {
?>

<h2>cart.</h2>
<div id="navVertical">
	<fieldset name = "cart">
	<ul>these are cart items.
<?php
	//Check if user has current active cart
	$cartCheck = hasCart($_SESSION['userid']);
	//IF user does not have current cart
	if($cartCheck == null) {
?>
	<li>cart is empty.  :[</li>
	</ul>
<?php
	//End IF user does not have current cart
	}
	//IF user has current cart
	if($cartCheck) {
		getCartItems($cartCheck['orderid']);	
?>
	</ul>
<?php
	//End IF user has current cart
	}
?>
	<a href="access_cart.php">view cart or check out.</a>
	<a href="logout.php">logout.</a>
	</fieldset>
</div><!--// end #navVertical //-->

<?php
	//End IF user logged in statements
	}
	
	//Begin IF user not logged in statements
	if(!isset($_SESSION['userid'])) {
?>

<!--// display login form //-->
<h2>login.</h2>

<?php 
	//Perform checks for error handling
	//IF user tries to skip to login page
	if(isset($_SESSION['log_try'])) {
		echo "<FONT COLOR=\"CC0000\">enter login info.<br /><br /></FONT>";
		unset($_SESSION['log_try']);
	}
	//IF username not found
	if(isset($_SESSION['bad_user'])) {
		echo "<FONT COLOR=\"CC0000\">username not found.<br /><br /></FONT>";
		unset($_SESSION['bad_user']);
	}
	//IF bad password
	if(isset($_SESSION['bad_pass'])) {
		echo "<FONT COLOR=\"CC0000\">password incorrect.<br /><br /></FONT>";
		unset($_SESSION['bad_pass']);
	}
	if(isset($_SESSION['username'])) {
		echo "<FONT COLOR=\"CC0000\">" . $_SESSION['username'] . " is username.<br /><br /></FONT>";
	}
	if(isset($_SESSION['username'])) {
		echo "<FONT COLOR=\"CC0000\">" . $_SESSION['userid'] . " is user id.<br /><br /></FONT>";
	}
?>	

<div id="navVertical">
	<fieldset name = "login">
	<form method='POST' action='login.php'>
		<label for='username' >username </label>
		<input type='text' name='username' /><br />
		<label for='password' >password </label>
		<input type='password' name='password' /><br />
		<input type='submit' name='submit' value='log in.' />
	</form>
	<p> <a href='register2.php'>new user?</a></p>
	</fieldset>
</div><!--// end #navVertical //-->

<?php
	//End IF user not logged in statements
	}
?>

<p>please choose your category. now.</p>

</div><!--// end #columnOne //-->


<div id="columnTwo">

<?php
	if(isset($_SESSION['order_placed'])) {
		echo "<FONT COLOR=\"CC0000\" align=\"center\"><b>Your order has been placed!</b><br /><br /></FONT>";	
		unset($_SESSION['order_placed']);
	}
?>
<!-- ROW 1, COL 1 -->
<div class="img">
  <a href="search.php?category=5">
  <img src="images/1-grain.png" alt="Grain Category" width="110" height="90">
  </a>
  <div class="desc">grain.</div>
</div>
<!-- ROW 1, COL 2 -->
<div class="img">
  <a href="search.php?category=6">
  <img src="images/2-dairy.png" alt="Dairy Category" width="110" height="90">
  </a>
  <div class="desc">dairy.</div>
</div>
<!-- ROW 1, COL 3 -->
<div class="img">
  <a href="search.php?category=3">
  <img src="images/3-fruit.png" alt="Fruit Category" width="110" height="90">
  </a>
  <div class="desc">fruits.</div>
</div>
<br />
<!-- ROW 2, COL 1 -->
<div class="img">
  <a href="search.php?category=4">
  <img src="images/4-vegetable.png" alt="Vegetable Category" width="110" height="90">
  </a>
  <div class="desc">vegetables.</div>
</div>
<!-- ROW 2, COL 2 -->
<div class="img">
  <a href="search.php?category=1">
  <img src="images/5-meat.png" alt="Meat Category" width="110" height="90">
  </a>
  <div class="desc">meats.</div>
</div>
<!-- ROW 2, COL 3 -->
<div class="img">
  <a href="search.php?category=2">
  <img src="images/6-beverage.png" alt="Beverage Category" width="110" height="90">
  </a>
  <div class="desc">beverages.</div>
</div>
<!-- END GALLERY -->

</div><!--// end #columnTwo //-->


<div id="columnThree">

<?php 
	//IF user logged in
	if(isset($_SESSION['userid'])) {
?>

<?php
	$checkRecent = checkRecent($_SESSION['userid']);
	if(($checkRecent['recent_1'] != null) && ($checkRecent['recent_2'] != null)) {
?>
		<h2>recent.</h2>
		<p>recently viewed items:</p>
<?php
		itemQuery($checkRecent['recent_1']);
		itemQuery($checkRecent['recent_2']);
	}
	else {
?>
		<h2>random.</h2>
		<p>random items:</p>
<?php
		printRandItem();
		printRandItem();
	}
?>

<?php
	//End IF user logged in
	}
	
	//IF user not logged in
	if(!isset($_SESSION['userid'])) {
?>

<h2>random.</h2>
<p>random items:</p>
<?php
	
	//print to page, edit FOR loop to adjust number of printed items
	printRandItem();
	printRandItem();
?>

<?php
	//End IF user not logged in
	}
?>

</div><!--// end #columnThree //-->

<div id="footer">
<p><a href="index.php" title="footer link">Home</a>&nbsp;|&nbsp;<a href="copyright.php"footer link">Copyright</a>&nbsp;|&nbsp;
<a href="privacy.php" title="footer link">Privacy Policy</a>&nbsp;|&nbsp;<a href="contact.php" title="footer link">Contact Us</a></p>
</div><!--// end #footer //-->

</div><!--// end #mainContainer //-->

</body>
</html>
