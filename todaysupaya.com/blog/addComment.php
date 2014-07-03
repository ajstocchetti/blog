<?php
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
include $root.'/phpHeader.inc.php';

$haveError = false;
$errStr = '<h2>There were errors processing your request:</h2>';
$errDetails = "";

$entryID = "";
$userCom = "";
$userID = getSessionId();

if( isset($_POST['entry']))
{ $entryID = $_POST['entry']; }
else
{	$haveError = true;
	$errStr .= 'Blog post not found<br />';
	$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
}
if( isset($_POST['userComment']))
{ $userCom = $_POST['userComment']; }
else
{	$haveError = true;
	$errStr .= 'Your comment was lost<br />';
	$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
}
if( $userCom == "")
{	$haveError = true;
	$errStr .= 'No comment entered<br />';
}

if( $haveError == false)
{
	$con = mysqli_connect($_SESSION['sqlServer'], 'ajs_webpost', 'safeguard', 'ajs_blogs');
	if( mysqli_connect_errno())
	{	$haveError = true;
		$errStr .= 'Error connecting to server<br />';
		$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
	}
	else
	{	if( $stmt = mysqli_prepare($con, "INSERT INTO blogComments (entryID, userID, comment) values (?, ?, ?)"))
		{	//mysqli_stmt_bind_param($stmt, "sss", $entryID, $userID, $escComments);
			//$escComments = mysqli_real_escape_string( $con, $userCom);
			mysqli_stmt_bind_param($stmt, "sss", $entryID, $userID, $userCom);
			mysqli_stmt_execute($stmt);
			if( mysqli_stmt_error($stmt) != "")
			{	$haveError = true; 
				$errStr .= 'Error executing query<br />';
				$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
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
}
if( $haveError == false)
{	$link = '/blog/index.php#'.$entryID;
	header("Location: $link");
	exit;
}
else
{ $errStr .= 'Please use the back button on your browser and try again.'; }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Today's Upaya - Test</title>
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
	echo $errStr;
	?>
	</div>
</div>
</div>
</body>
</html>