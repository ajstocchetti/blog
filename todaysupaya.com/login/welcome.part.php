<?php
$userName = "";
$welcomeText = '<h2>You are logged in.</h2>';

if( isset($_POST['loginEmail']))
{	$userName = $_POST['loginEmail'];
	if( $userName != "")
	{ $welcomeText = '<h2>You are logged in as '.$userName.'.</h2>.'; }
}
echo $welcomeText;
?>
<br />
<a href="logout.php">Click here to log out</a>