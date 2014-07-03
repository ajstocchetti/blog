<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
include $root.'/phpHeader.inc.php';
clearAllLogin(true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Today's Upaya</title>
<link rel="icon" type="image/png" href="/favicon.gif" />
<link rel="stylesheet" type="text/css" href="/style.css" />
</head>

<body>
<div class="header">
	<?php
	include $root.'/header.part.php';
	?>
</div>
<br />

<div class="minScreen">

<div class="menu">
	<?php
	include $root.'/menu.part.php';
	?>
</div>

<div class="left">
	<div class="space">&nbsp;</div>
	<div class="content">
	<div class="post">
	<h2>You have been successfully logged out</h2>
	<form action="index.php"><input type="submit" value="Log In"></form>
	<br />
	<form action="/"><input type="submit" value="Return to Home"></form>
	</div>
	</div>
</div>
</div>
</body>
</html>