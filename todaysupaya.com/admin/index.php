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
	
	function loginForm()
	{	echo '<form action="index.php" method="post" target="_self">
		<b>User Name:</b><br />
		<input type="text" size="20" name="userid"><br />
		<b>Password:</b><br /><input type="password" size="20" name="password"><br />
		<br />
		<input type="submit" value="Login">
		<input type="hidden" name="nextpage" value="login">
		</form>';
	}
	
	function blogForm()
	{
		echo'<form action="index.php" method="post" target="_self">
		<input type="submit" value="Logout">
		<input type="hidden" name="nextpage" value="logout">
		</form>
		</div>
		<br />
		<div class="post">

		<form action="index.php" method="post">';

			$blTitle = "";
			$blLoc = "";
			$blYear = "";
			$blMonth = "";
			$blDay = "";
			$blDate = "";
			$blPermalink = "";
			$blPost = "";
			$blSupComments = "";

			if (isset($_POST['title'])) {$blTitle = trim($_POST['title']);	}
			if (isset($_POST['location'])) {$blLoc = trim($_POST['location']);	}
			if (isset($_POST['year'])) {$blYear = trim($_POST['year']);	}
			if (isset($_POST['month'])) {$blMonth = $_POST['month']-1;	}
			if (isset($_POST['day'])) {$blDay = trim($_POST['day']);	}
			if (isset($_POST['dateOvr'])) {$blDate = trim($_POST['dateOvr']);	}
			if (isset($_POST['permalink'])) {$blPermalink = trim($_POST['permalink']);	}
			if (isset($_REQUEST['posthtml'])) {$blPost = $_REQUEST['posthtml'];	}
			if (isset($_POST['supComments'])) {$blSupComments = " checked=\"checked\"";}	// i dont like that it only chcks if supComments is set, and doesnt check the value, but for now it works
			// if this changes, will also need to change saveBlog
			
			/***** NOTES ON DATE
			2 sql columns
				discreteDate - type of date
				overrideDate - type of text
			if override date is filled in, display that, else, discrete date
			must have a disc date - will use for chron display; upload inst will just be for me
			*/
			if( $blDay == "" && $blYear == "")
			{	$dateAry = getDate();
				$blYear = $dateAry["year"];
				$blDay = $dateAry["mday"];
				$blMonth = $dateAry["mon"]-1;
			}
			$monthAry = Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

		echo '<table>
			<tr>
			<td>Title:</td>
			<td><input type="text" size="60" maxlength="200" name="title" value="'.$blTitle.'"></td>
			</tr><tr>
			<td>Location:</td>
			<td><input type="text" size="60" maxlength="120" name="location" value="'.$blLoc.'"></td>
			</tr><tr>
			<td>Discrete date:</td>
			<td><input type="text" maxlength="4" name="year" value="'.$blYear.'">
			<select name="month">';
			for ($x=0; $x<count($monthAry); $x++)
			{	echo '<option value='.($x+1);
				if( $x == $blMonth)
				{	echo ' selected';	}
				echo '>'.$monthAry[$x].'</option>';
			}
			echo '</select>&nbsp;<input type="text" maxlength="2" name="day" value="'.$blDay.'"></td>
			</tr><tr>
			<td>Date override:</td>
			<td><input type="text" size="60" maxlength="120" name="dateOvr" value="'.$blDate.'"></td>
			</tr><tr>
			<td>Suppress comments:</td>
			<td><input type="checkbox" name="supComments"'.$blSupComments.'></td>
			</tr><tr>
			<td>Permalink address:</td>
			<td><input type="text" size="30" maxlength="30" name="permalink" value="'.$blPermalink.'"></td>
			</tr>
		</table>
		<input type="submit" value="Add Post">
		<input type="hidden" name="nextpage" value="addblog">
		<br />
		<textarea rows="20" cols="80" name="posthtml">'.$blPost.'</textarea>
		';
		echo '<br />
		<input type="submit" value="Add Post">
		<input type="hidden" name="nextpage" value="addblog">
		</form>';
	}
	
	function isValidDate($year, $day, $month)
	{	// integer check
		$y1 = $year;
		settype($year, 'integer');
		if ($y1 != $year)
		{	return false;	}
		$d1 = $day;
		settype($day, 'integer');
		if ($d1 != $day)
		{	return false;	}
		// year validity
		$dateAry = getDate();
		$checkYear = $dateAry["year"];
		if ($year != $checkYear)	// must be present year
		{	return false;	}
		return checkdate($month, $day, $year);	//make sure day-month combo is valid
	}
	
	function adminError()
	{
		echo '<h2>Oops...something went wrong</h2>';
		if( !isset($_SESSION['admin_user']))
		{ echo 'You were not logged in with admin priveledges<br />'; }
		if( !isset($_POST['nextpage']))
		{ echo 'Nextpage was not set<br />'; }
		else
		{	$np = $_POST['nextpage'];
			echo 'Could not load page '.$np.'<br />';
		}
		unset($_SESSION['admin_user']);
		echo '<br />';
		loginForm();
	}
	
	function saveBlog()
	{	$blTitle = trim($_POST['title']);
		$blLoc = trim($_POST['location']);
		$blYear = trim($_POST['year']);
		$blDay = trim($_POST['day']);
		$blMonth = $_POST['month'];
		$blDate = trim($_POST['dateOvr']);
		$blPermalink = trim($_POST['permalink']);
		$blPost = $_REQUEST['posthtml'];
		$blSupComments = isset($_POST['supComments']);

		$blgDir = $_SERVER['DOCUMENT_ROOT'].'/blogs/';
		$haveError = false;
		$errStr = 'Post failed to save due to:<br />';
		$errDetails = "";

		if ($blTitle == '')
		{	$haveError = true;
			$errStr = $errStr.'Entry title missing<br />';
		}
		if (!isValidDate($blYear, $blDay, $blMonth))
		{	$haveError = true;
			$errStr = $errStr.'Discrete date is not valid<br />';
		}
		else
		{	$blDiscreteDate = mktime(12, 0, 0, $blMonth, $blDay, $blYear);	}
		$fileExt = '.part.php';
		$fileName = preg_replace("/[^A-Za-z0-9]/", '', $blTitle); //str_replace(' ','',$blTitle);
		$fullPath = $blgDir.$fileName.$fileExt;
		if( file_exists($fullPath))
		{	$fileName = $fileName.'-'.date('YMd-His');
			$fullPath = $blgDir.$fileName.$fileExt;
			if( file_exists($fullPath))
			{	$haveError = true;
				$errStr = $errStr.'Could not create file on server<br />';
			}
		}
		if( $haveError == false)	// create file on server
		{	if ($blDate != "")
			{	$dispDate = $blDate;	}
			else
			{	$dispDate = date("j F Y", $blDiscreteDate);	}
			$handle = fopen($fullPath, 'w');
			// meta data, should we even keep this?
			fwrite($handle, "<!-- Title: $blTitle -->\n");
			fwrite($handle, "<!-- Location: $blLoc -->\n");
			fwrite($handle, "<!-- Date: $dispDate -->\n");
			//grab title/date/loc from boxes
			fwrite($handle, "<div class=\"post\">\n");
			fwrite($handle, "$dispDate \n<br />\n");
			if( $blLoc != '')
			{	fwrite($handle, "$blLoc \n");	}
			fwrite($handle, "<div class=\"title\">$blTitle</div>\n<br />\n");
			// bulk of post
			fwrite($handle, $blPost);
			//close
			fwrite($handle, "</div>");
			fclose($handle);
			
			if( !file_exists($fullPath))	// Check that file saved properly
			{	$haveError = true;
				$errStr = $errStr.'There was a problem writing to file<br />';
			}
		}

		if( $haveError == false)	//	no problems so far, lets try to save to the database
		{	$con = mysqli_connect($_SESSION['sqlServer'], $dbPost, $postPW, 'ajs_blogs');
			if( mysqli_connect_errno())
			{	$haveError = true;
				$errStr .= 'Error connecting to server<br />';
				$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
			}
			else
			{	if( $stmt = mysqli_prepare($con, "INSERT INTO blog_entries (title, location, dateDiscrete, dateOverride, permalink, filepath, disableComment) VALUES (?, ?, ?, ?, ?, ?, ?)"))
				{	mysqli_stmt_bind_param($stmt, "sssssss", $escTitle, $escLoc, $sqlDiscDate, $escDate, $escPL, $fullName, $blSupComments);
					$escTitle = mysqli_real_escape_string( $con, $blTitle);
					$escLoc = mysqli_real_escape_string( $con, $blLoc);
					$sqlDiscDate = date("Y-m-d H:i:s", $blDiscreteDate);	//YYYY-MM-DD HH:MM:SS
					$escDate = mysqli_real_escape_string( $con, $blDate);
					$escPL = mysqli_real_escape_string( $con, $blPermalink);
					$fullName = $fileName.$fileExt;
					mysqli_stmt_execute($stmt);
					if( mysqli_stmt_error($stmt) != "")
					{	$haveError = true; 
						$errStr .= 'Error executing query<br />';
						$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
					}
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
		{	echo 'Blog uploaded successfully!';
			// clear out old data for new post
			unset($_POST['title']);
			unset($_POST['location']);
			unset($_POST['dateOvr']);
			unset($_POST['year']);
			unset($_POST['day']);
			unset($_POST['month']);
			unset($_POST['permalink']);
			unset($_REQUEST['posthtml']);	
			unset($_POST['supComments']);
			blogForm(); // and load the page again for another post
		}
		else
		{	echo '<h2>Oops...Something went wrong</h2>';
			echo $errStr.'<br />';
			echo $errDetails.'<br />';
			blogForm();
		}
	}	
	//end of functions

	// page loading logic
	if( !isset($_POST['nextpage']))	// nextpage not set
	{	if( isset($_SESSION['admin_user']))
		{ adminError(); }
		else
		{ loginForm(); }
	}

	else // nextpage is set
	{	$nextPage = $_POST['nextpage'];	
		
		if( $nextPage == "login")
		{	$userid = $_POST['userid'];
			$password = $_POST['password'];
			$errorType = "";

			if ($password != $adminPW)
			{ $errorType = "password"; }
			if ($userid != $adminUser)
			{ $errorType = "user"; }
			if( $errorType != "")
			{	unset ($_SESSION['admin_user']);
				echo '<h2>Login unsuccessful</h2>
					Invalid '.$errorType.'<br /><br />';
				loginForm();
			}
			else
			{	$_SESSION['admin_user'] = $userid;
				echo '<h2>Welcome '.$userid.'</h2>';
				blogForm();;
			}
	}
		
		elseif( $nextPage == "logout" )
		{	unset($_SESSION['admin_user']);
			echo '<h2>You have successfully logged out</h2>
				<a href="index.php">Log back in</a><br />
				<a href="/">Back to home</a>';
		}
		
		elseif( $nextPage == "addblog")
		{	if( !isset($_SESSION['admin_user']))
			{ adminError(); }
			else
			{ saveBlog(); } // need to check saveblog
		}
		
		/*
		elseif( $nextPage == "bloggood")
		{	// checked for admin loging when submitting blog, no need to do it here
			echo '<h2>Blog successfully saved</h2>';
			blogForm();
		}
		*/
		
		else //what is nextpage set to?
		{ admError(); }
	}
	?>
	</div>
<br />
</div>
</div>
</body>
</html>