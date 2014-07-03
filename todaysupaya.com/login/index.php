<?php 
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
include $root.'/phpHeader.inc.php';
//make sure we check cookie before this

$nextPage = 'login.part.php';
if( !isSetSession()) // session is not set, so just got here or are currently logging in
{	if( isset($_REQUEST['loginfo']))
	{	// already submitted data
		$login = $_POST['userID'];
		$password = $_POST['password'];
		$logInError = false;
		$errStr = '<h2>Login failed due to:</h2>';
		// validate credentials
		$con = mysqli_connect($_SESSION['sqlServer'], $dbView, $viewPW, 'ajs_blogs');
		if( mysqli_connect_errno())
		{	$logInError = true;
			$errStr .= 'Error connecting to server<br />';
			$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
		}
		else
		{	if( $stmt = mysqli_prepare($con, "SELECT userID, isActive, adminHold, password from GuestUsers where emailAdr = ?"))
			{	mysqli_stmt_bind_param($stmt, "s", $escPostID);
				$escPostID = mysqli_real_escape_string( $con, $login);
				mysqli_stmt_execute($stmt);
				if( mysqli_stmt_error($stmt) != "")
				{	$logInError = true; 
					$errStr .= 'Error executing query<br />';
					$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
				}
				mysqli_stmt_bind_result($stmt, $userID, $isAct, $admHold, $dbPassword);
				mysqli_stmt_fetch($stmt);
				// validate results
				if( $userID == "")
				{	$logInError = true;
					$errStr .= 'User '.$login.' does not exist<br />';
				}
				elseif( $isAct == false)
				{	$logInError = true;
					$errStr .= 'Your account has not been activated. Please follow the link in your email to activate your account<br />';
				}
				elseif( $admHold == true)
				{	$logInError = true;
					$errStr .= 'Your account has been disabled by the site administrator<br />';
				}
				elseif( $dbPassword != crypt($password, "k6JeW"))
				{	$logInError = true;
					$errStr .= 'Password is incorrect<br />';
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
		if( $logInError == true)
		{	$_POST['errorText'] = $errStr;}
		else // everything checks out
		{
			setSessionUser($userID);
			$_POST['loginEmail'] = $login;
			$nextPage = 'welcome.part.php';
		}
	} // closes loginfo not set
}	// closes $_SESSION is not set
else // session is set, but verify that its an active user
{	$sessionID = getSessionId();
	$conError = false;
	$errStr = "";
	$errDetails = "";
	$haveError = false;
	
	if( $sessionID > 0)
	{	$con = mysqli_connect($_SESSION['sqlServer'], $dbView, $viewPW, 'ajs_blogs');
		if( mysqli_connect_errno())
		{	$conError = true;
			$errStr .= 'Error connecting to server<br />';
			$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
		}
		else
		{	if( $stmt = mysqli_prepare($con, "SELECT emailAdr, isActive, adminHold from GuestUsers where userID = ?"))
			{	mysqli_stmt_bind_param($stmt, "s", $escUserID);
				$escUserID = mysqli_real_escape_string( $con, $sessionID);
				mysqli_stmt_execute($stmt);
				if( mysqli_stmt_error($stmt) != "")
				{	$conError = true; 
					$errStr .= 'Error executing query<br />';
					$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
				}
				mysqli_stmt_bind_result($stmt, $email, $reg, $admHold);
				mysqli_stmt_fetch($stmt);
				if(($email == "") || ($reg == false) || ($admHold == true))
				{$haveError = true; }				
				mysqli_stmt_close($stmt);
			}
			else // error preparing statement, should never happen
			{	$conError = true;
				$errStr .= 'Error preparing query<br />';
				$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
			}
			mysqli_close($con);
		}
	}
	if( $haveError == true)
	{ clearAllLogin(true); } // nextpage is login form
	else
	{	// if connection error, assume session user is correct
		$_POST['loginEmail'] = $email;
		$nextPage = 'welcome.part.php';
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
<title>Today's Upaya - Login</title>

<link rel="icon" type="image/png" href="/favicon.png" />
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
		include $nextPage;
		?>
		
		</div>
</div>
</div>
</body>
</html>
