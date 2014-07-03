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
	<?php

$haveError = false;
$errStr = "";
$errDetails = "";

$con = mysqli_connect($_SESSION['sqlServer'], $dbView, $viewPW, 'ajs_blogs');
if( mysqli_connect_errno())
{	$haveError = true;
	$errStr .= 'Error connecting to server<br />';
	$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
}
else
{	if( $stmt = mysqli_prepare($con, "SELECT entryID, filepath FROM blog_entries ORDER BY entryID DESC"))
	{	mysqli_stmt_execute($stmt);
		if( mysqli_stmt_error($stmt) != "")
		{	$haveError = true; 
			$errStr .= 'Error executing query<br />';
			$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
		}
		mysqli_stmt_bind_result($stmt, $entryID, $filePath);
		while (mysqli_stmt_fetch($stmt))
		{	// display the blogs
			displayBlog($entryID, $filePath);
			echo '<div><br /><br /></div>';
		}
		mysqli_stmt_close($stmt);
	}
	else // error preparing statement, should never happen
	{	$haveError = true;
		$errStr .= 'Error preparing query<br />';
		$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
	}
	mysqli_close($con);
}

?>
	</div>
</div>
</div>
</body>
</html>