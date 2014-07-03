<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
include $root.'/phpHeader.inc.php';
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
<a href="old"><img src="old/thumbs/lamp.JPG" style="vertical-align:middle" />&nbsp;&nbsp; some old photos</a><br /><br />
<a href="sala"><img src="sala/thumbs/IMG_9940.JPG" style="vertical-align:middle" />&nbsp;&nbsp; sala build</a><br /><br />
<a href="aroundpanya"><img src="aroundpanya/thumbs/thai.JPG" style="vertical-align:middle" />&nbsp;&nbsp; sights around panya</a><br /><br />
	</div>
</div>
</div>
</body>
</html>