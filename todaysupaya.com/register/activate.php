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
	<?php
		$val = isset($_GET['val']) ? $_GET['val'] : "notset";
		$admEmail = getAdminEmail();
		$errStr = 'There was a problem loading this page. Please try the link from your email again. If problems continue, contact the site admin:';
		$errStr .= '<a href="mailto:'.$admEmail.'">'.$admEmail.'</a><br /><br />';
		$haveError = false;
		$errDetails = "";

		do{
		if( $val == "notset")
		{	$haveError = true;
			$errStr .= "No user selected<br />";
			$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
			break;
		}
		settype($val, 'integer');
		if( $val == 0 || $val == 1)
		{	$haveError = true;
			$errStr .= "Error with user ID<br />";
			$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
			break;
		}

		$con = mysqli_connect($_SESSION['sqlServer'], $dbPost, $postPW, 'ajs_blogs');
		if( mysqli_connect_errno())
		{	$haveError = true;
			$errStr .= 'Error connecting to server<br />';
			$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
		}
		else
		{	// { $link = (($userID*17)+23); }
			$userID = (($val - 23)/17);
			// I should check that user exists first, but i havent done that yet
			if( $stmt = mysqli_prepare($con, "UPDATE GuestUsers SET isActive = ? where userID = ?"))
			{	mysqli_stmt_bind_param($stmt, "ss", $active, $userID);
				$active = true;
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
		} while (false);
		if ($haveError == true)
		{	echo '<h2>Oops...something went wrong</h2>';
			echo $errStr;
		}
		else
		{	echo '<h2>Your account has been activated</h2>';
			echo '<a href=/login>Click here to log in</a>';
		}
	?>
	</div>
	</div>
</div>
</div>
</body>
</html>