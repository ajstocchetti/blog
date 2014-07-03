<?php

function displayBlog($entryID, $filePath="", $hideComments = false, $supNewComments = false)
{	if( $entryID == "")
	{ return; }
	
$con = mysqli_connect($_SESSION['sqlServer'], $dbView, $viewPW, 'ajs_blogs');
	if( mysqli_connect_errno())
	{	$haveError = true;
		$errStr .= 'Error connecting to server<br />';
		$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
	}
	else	
	{	$haveError = false;
		$errStr = "";
		$errDetails = "";
		{	$entryID = mysqli_real_escape_string( $con, $entryID);
			if( $stmt = mysqli_prepare($con, "SELECT filepath, disableComment from blog_entries WHERE entryID = ?"))
			{	mysqli_stmt_bind_param($stmt, "s", $entryID);
				mysqli_stmt_execute($stmt);
				if( mysqli_stmt_error($stmt) != "")
				{	$haveError = true; 
					$errStr .= 'Error executing query<br />';
					$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
				}
				mysqli_stmt_bind_result($stmt, $filePathEntry, $supCommentsEntry);	// when getting values
				mysqli_stmt_fetch($stmt);
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

	if( $filePath == "") //get the filepath
	{	$filePath = $filePathEntry;	}
	$root = $_SERVER['DOCUMENT_ROOT'];
	$fullPath = $root.'/blogs/'.$filePath;
	if( !file_exists($fullPath))
	{ return; }
	
	//display blog
	echo '<a id="'.$entryID.'"></a>';
	include $fullPath;
	
	//user comments
	if($hideComments == false)
	{	$commentErr = false;
		$errStr = "";
		$errDetails = "";

		$con = mysqli_connect($_SESSION['sqlServer'], $dbView, $viewPW, 'ajs_blogs');
		if( mysqli_connect_errno())
		{	$commentErr = true;
			$errStr .= 'Error connecting to server<br />';
			$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
		}
		else
		{	if( $stmt = mysqli_prepare($con, "SELECT userID, comment, isDeleted FROM blogComments where entryID = ?"))
			{	mysqli_stmt_bind_param($stmt, "s", $entryID);
				$entryID = mysqli_real_escape_string( $con, $entryID);
				mysqli_stmt_execute($stmt);
				if( mysqli_stmt_error($stmt) != "")
				{	$commentErr = true; 
					$errStr .= 'Error executing query<br />';
					$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
				}
				mysqli_stmt_bind_result($stmt, $userID, $comment, $isDel);
				while (mysqli_stmt_fetch($stmt))
				{	if( $isDel == false)
					{	$userName = getUsersName($userID);
						echo '<div class="userComment">';
						echo '<i>'.$userName.' says:</i> '.$comment;
						echo '</div>';
					}
				}
				mysqli_stmt_close($stmt);
			}
			else // error preparing statement, should never happen
			{	$commentErr = true;
				$errStr .= 'Error preparing query<br />';
				$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
			}
			mysqli_close($con);
			if( $commentErr == true)
			{	echo '<div class="userComment">';
				echo 'There were errors looking up comments for this entry';
				echo '</div>';
			}
		}
	//end comment lookup
	
	// new comments
	// can suppress comments at the individual blog level,  suppression at either level will be respected
	if( ($supNewComments == false) and ($supCommentsEntry == false))
	{	if( isSetSession())
		{	// post a new comment
			echo	'<div class="userComment">
					Enter a comment (200 char max):
					<form action="/blog/addComment.php" method="post">
					<textarea rows="4" cols="60" maxlength="350" name="userComment"></textarea>
					<br />
					<input type="submit" value="Add Comment">
					<input type="hidden" name="entry" value="'.$entryID.'">
					</form>
					</div><br /><br />';
		}
		else
		{	// tell user to log in
			echo '<div class="userComment">';
			echo '<a href="/login">Log in</a> to post a comment';
			echo '</div>';
		}
	} // end new comments
	}// end comments
}


// gets user display name based on userID
// first look to $_session, then to SQL database
// if nothing is found, we return 'somebody'
function getUsersName($userID)
{	$retName = "";
	$sessId = 'user-'.$userID;
	if( isset( $_SESSION[$sessId]))
	{ $retName = $_SESSION[$sessId]; }
	else
	{ // sql lookup
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
		{	if( $stmt = mysqli_prepare($con, "SELECT displayName FROM GuestUsers where userID = ?"))
			{	mysqli_stmt_bind_param($stmt, "s", $escUID);
				$escUID = mysqli_real_escape_string( $con, $userID);
				mysqli_stmt_execute($stmt);
				if( mysqli_stmt_error($stmt) != "")
				{	$haveError = true; 
					$errStr .= 'Error executing query<br />';
					$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
				}
				mysqli_stmt_bind_result($stmt, $dispName);
				mysqli_stmt_fetch($stmt);
				
				if( $dispName != "")
				{	$retName = $dispName;
					$_SESSION[$sessId] = $retName;
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
	if( $retName == "")
	{ $retName = 'Somebody'; }
	return $retName;
}
?>