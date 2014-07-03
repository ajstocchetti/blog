<?php
$haveError = false;
$errStr = "Your request could not be processed for the following reasons:<br />";
$errDetails = "";
$saveError = false;
$valError = false;

$usrName = trim($_POST['userFullName']);
$_POST['userFullName'] = $usrName;
$usrEmail = trim($_POST['emlAdr']);
$_POST['emlAdr'] = $usrEmail;
$usrDisp=trim($_POST['dispName']);
$_POST['dispName']=$usrDisp;
$password = $_POST['pwone'];
$pass2 = $_POST['pwtwo'];

if( $usrName == "")
{	$haveError = true;
	$errStr = $errStr.'Your name is required<br />';
}
if( $usrDisp == "")
{	$haveError = true;
	$errStr = $errStr.'Display name is required<br />';
}
if( $usrEmail == "")
{	$haveError = true;
	$errStr = $errStr.'A valid email address is required<br />';
}
if( $password == "")
{	$haveError = true;
	$errStr = $errStr.'Password cannot be blank<br />';
}
else
{	if( $password != $pass2)
	{	$haveError = true;
		$errStr = $errStr.'Passwords do not match<br />';
	}
}
if( $usrEmail != "")
{	$con = mysqli_connect($_SESSION['sqlServer'], $dbView, $viewPW, 'ajs_blogs');
	if( mysqli_connect_errno())
	{	$haveError = true;
		$errStr .= 'Error connecting to server<br />';
		$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
	}
	else
	{	if( $stmt = mysqli_prepare($con, "SELECT isActive FROM GuestUsers WHERE emailAdr=?"))
		{	mysqli_stmt_bind_param($stmt, "s", $dupEmail);
			$dupEmail = mysqli_real_escape_string($con, $usrEmail);
			mysqli_stmt_execute($stmt);
			if( mysqli_stmt_error($stmt) != "")
			{	$haveError = true; 
				$errStr .= 'Error executing query<br />';
				$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
			}
			mysqli_stmt_bind_result($stmt, $testActive);
			while (mysqli_stmt_fetch($stmt))
			{	$haveError = true;
				$errStr .= 'The email address '.$dupEmail.' already exists';
				if( $testActive == false)
				{ $errStr .= ', but needs to be activated'; }
				$errStr .='<br />';
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


if( $haveError == true)
{	$_GET['errorText'] = $errStr;
	include 'regForm.part.php';
}
else	// SAVE TO DATABASE
{	$con = mysqli_connect($_SESSION['sqlServer'], $dbPost, $postPW, 'ajs_blogs');
	if( mysqli_connect_errno())
	{	$saveError = true;
		$errStr .= 'Error connecting to server<br />';
		$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
	}
	else
	{	if( $stmt = mysqli_prepare($con, "INSERT INTO GuestUsers (userName, emailAdr, password, displayName) values (?, ?, ?, ?)"))
		{	mysqli_stmt_bind_param($stmt, "ssss", $escName, $escEmail, $hashPswd, $escDisp);
			$escEmail = mysqli_real_escape_string( $con, $usrEmail);
			$escName = mysqli_real_escape_string( $con, $usrName);
			$escDisp = mysqli_real_escape_string( $con, $usrDisp);
			$hashPswd = crypt($password, "k6JeW");
			mysqli_stmt_execute($stmt);
			if( mysqli_stmt_error($stmt) != "")
			{	$saveError = true; 
				$errStr .= 'Error executing query<br />';
				$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
			}
			mysqli_stmt_close($stmt);
		}
		else // error preparing statement, should never happen
		{	$saveError = true;
			$errStr .= 'Error preparing query<br />';
			$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
		}
		mysqli_close($con);
	}
	if( $saveError == true)
	{	echo '<h2>There was an error processing your request</h2>';
		echo $errStr;
		echo '<br />Please try again later';
	}
	else // saved new user
	{	// generate registration email
		$con = mysqli_connect($_SESSION['sqlServer'], $dbView, $veiwPW, 'ajs_blogs');
		if( mysqli_connect_errno())
		{	$valError = true;
			$errStr .= 'Error connecting to server<br />';
			$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
		}
		else
		{	if( $stmt = mysqli_prepare($con, "SELECT userID FROM GuestUsers WHERE emailAdr=?"))
			{	mysqli_stmt_bind_param($stmt, "s", $newLogin);
				$newLogin = mysqli_real_escape_string( $con, $usrEmail);
				mysqli_stmt_execute($stmt);
				if( mysqli_stmt_error($stmt) != "")
				{	$valError = true; 
					$errStr .= 'Error executing query<br />';
					$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
				}
				mysqli_stmt_bind_result($stmt, $userID);
				mysqli_stmt_fetch($stmt);
				mysqli_stmt_close($stmt);
			}
			else // error preparing statement, should never happen
			{	$valError = true;
				$errStr .= 'Error preparing query<br />';
				$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
			}
			mysqli_close($con);
		}
		if( ($valError == true) || ($userID == "")) // something went wrong, should be valued
		{ $link = 0; }
		else
		{ $link = (($userID*17)+23); }
		$msg1 = 'Thank you for regestering with Today\'s Upaya. Please follow this link to activate your user: http://www.todaysupaya.com/register/activate.php?val='.$link;
		$subj1 = "User registration for Today's Upaya";
		$admEmail = getAdminEmail();
		$mailheaders = "MIME-Version: 1.0\r\n";
		$mailheaders .= "Content-type: text/html; charset=ISO-8859-1\r\n";
		$mailheaders .= "From: My Web Site <".$admEmail.">\n";
		$mailheaders .= "Reply-To: ".$admEmail;
		mail($usrEmail, $subj1, $msg1); //, $mailheaders);
		
		// let me know
		$message = "New account created for user";
		$message = $message."\nName: ".$usrName;
		$message = $message."\nDisplay Name: ".$usrDisp;
		$message = $message."\nEmail: ".$usrEmail;
		$subj = "New User Created - ".$usrName;
		mail($admEmail, $subj, $message); //, $mailheaders);
		
		// alert user on screen
		echo '<h2>User '.$usrEmail.' was created successfully</h2>
		Please check your email for a link to activate your user';
	}
}
?>