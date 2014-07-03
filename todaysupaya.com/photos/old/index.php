<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
include $root.'/phpHeader.inc.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Today's Upaya - Old Photos</title>
<!-- lightbox -->
	<script type="text/javascript" src="/photos/lb/prototype.js"></script>
	<script type="text/javascript" src="/photos/lb/scriptaculous.js?load=effects,builder"></script>
	<script type="text/javascript" src="/photos/lb/lightbox.js"></script>
	<link rel="stylesheet" href="/photos/lb/lightbox.css" type="text/css" media="screen" />
<!-- end lightbox -->
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
	<p class="phototitle">Old Photos</p>
	<a href="bike.jpg" rel="lightbox[xx]" title="Bike"><img src="thumbs/bike.JPG"></a>
<a href="varanasitrain.jpg" rel="lightbox[xx]" title="unconditional love"><img src="thumbs/varanasitrain.JPG"></a>
<a href="nightfood.jpg" rel="lightbox[xx]" title="india street vendor at night"><img src="thumbs/nightfood.JPG"></a>
<a href="thaifence.jpg" rel="lightbox[xx]" title="fence"><img src="thumbs/thaifence.JPG"></a>
<a href="statuefront.jpg" rel="lightbox[xx]" title="buddha statue"><img src="thumbs/statuefront.JPG"></a>
<a href="statueback.jpg" rel="lightbox[xx]" title="statue from behind"><img src="thumbs/statueback.JPG"></a>
<a href="nightmarket-col.jpg" rel="lightbox[xx]" title="chaing mai street food"><img src="thumbs/nightmarket-col.JPG"></a>
<a href="nightmarket-bw.jpg" rel="lightbox[xx]" title="chaing mai street food (bw)"><img src="thumbs/nightmarket-bw.JPG"></a>
<a href="lamp.jpg" rel="lightbox[xx]" title="lamp"><img src="thumbs/lamp.JPG"></a>
<a href="greentree.jpg" rel="lightbox[xx]" title="tree"><img src="thumbs/greentree.JPG"></a>
<a href="guardian.jpg" rel="lightbox[xx]" title="guardian"><img src="thumbs/guardian.JPG"></a>
<a href="tlg-panorama.jpg" rel="lightbox[xx]" title="tiger leaping gorge"><img src="thumbs/tlg-panorama.JPG"></a>
	</div>
</div>
</div>
</body>
</html>