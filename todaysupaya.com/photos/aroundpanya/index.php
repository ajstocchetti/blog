<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
include $root.'/phpHeader.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<!-- lightbox -->
	<script type="text/javascript" src="/photos/lb/prototype.js"></script>
	<script type="text/javascript" src="/photos/lb/scriptaculous.js?load=effects,builder"></script>
	<script type="text/javascript" src="/photos/lb/lightbox.js"></script>
	<link rel="stylesheet" href="/photos/lb/lightbox.css" type="text/css" media="screen" />
<!-- end lightbox -->

<title>Today's Upaya - Panya Photos</title>
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
	<p class="phototitle">Sights Around Panya</p>
<a href="gecko.JPG" rel="lightbox[xx]" title="my roommate"><img src="thumbs/gecko.JPG"></a>
<a href="geckohide.JPG" rel="lightbox[xx]" title="she is shy"><img src="thumbs/geckohide.JPG"></a>
<a href="spider.JPG" rel="lightbox[xx]" title="my other roommate"><img src="thumbs/spider.JPG"></a>
<a href="butterfly.JPG" rel="lightbox[xx]" title="butterflies hatching"><img src="thumbs/butterfly.JPG"></a>
<a href="butterfly2.JPG" rel="lightbox[xx]"><img src="thumbs/butterfly2.JPG"></a>
<a href="toppings.JPG" rel="lightbox[xx]" title="look at all those pizza toppings"><img src="thumbs/toppings.JPG"></a>
<a href="pizza.JPG" rel="lightbox[xx]" title="Geoffroy enjoying his pizza"><img src="thumbs/pizza.JPG"></a>
<a href="banana.JPG" rel="lightbox[xx]" title="bananas!"><img src="thumbs/banana.JPG"></a>
<a href="rice.JPG" rel="lightbox[xx]" title="rice fields"><img src="thumbs/rice.JPG"></a>
<a href="thai.JPG" rel="lightbox[xx]"><img src="thumbs/thai.JPG"></a>
<a href="grass.JPG" rel="lightbox[xx]"><img src="thumbs/grass.JPG"></a>
<a href="ls1.JPG" rel="lightbox[xx]"><img src="thumbs/ls1.JPG"></a>
<a href="ls2.JPG" rel="lightbox[xx]" title="it sure is pretty here"><img src="thumbs/ls2.JPG"></a>
<a href="sunset.JPG" rel="lightbox[xx]" title=""><img src="thumbs/sunset.JPG"></a>
<a href="party.JPG" rel="lightbox[xx]" title="so we had a costume party..."><img src="thumbs/party.JPG"></a>
	</div>
</div>
</div>
</body>
</html>