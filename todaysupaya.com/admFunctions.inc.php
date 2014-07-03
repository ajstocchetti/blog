<?php
// ************************************************************
// database passwords
// ************************************************************
require_once($_SERVER['DOCUMENT_ROOT'].'../DBLogins.php'); 


// ************************************************************
// server functions
// ************************************************************
function setSqlServer()
{	if( strpos($_SERVER['DOCUMENT_ROOT'], 'C:/wamp/www') === 0 )	// 3 ='s so we match on type (int, not false)
	{ $_SESSION['sqlServer'] = 'localhost'; }	// on my computer
	else
	{ $_SESSION['sqlServer'] = 'mysql.todaysupaya.com'; } // on the web
}
function checkSqlServer()
{	if( !isset($_SESSION['sqlServer']))
	{	setSqlServer(); }
}

// ************************************************************
// site admin
// ************************************************************
function getAdminEmail()
{ return 'ajstocchetti@gmail.com'; }


// ************************************************************
// Cookie functions
// $_COOKIE['TU_login']
// ************************************************************
function setLoginCookie($userID)
{ setcookie("TU_login", $userID, time()+2592000, '/', 'todaysupaya.com'); }

function isSetCookie()
{	if( isset($_COOKIE["TU_login"]))
	{ return true; }
	else
	{ return false; }
}

function clearLoginCookie()
{ setcookie("TU_login", "", time()-86400, '/', 'todaysupaya.com'); }

function getLoginCookie()
{ return $_COOKIE["TU_login"]; }

// ************************************************************
// session login functions
// $_SESSION['db_user']
// ************************************************************
function setSessionUser($userID)
{ $_SESSION['db_user'] = $userID; }

function isSetSession()
{	if( isset($_SESSION['db_user']))
	{ return true; }
	else
	{ return false; }
}

function clearSessionUser()
{	if( isSetSession())		// just to be safe
	{ unset($_SESSION['db_user']); }
}

function getSessionId()
{	if( isSetSession())
	{ return $_SESSION['db_user']; }
	else
	{ return -100; }
}

// ************************************************************
// log out functions
// ************************************************************
function clearAllLogin($inHeader = false)
{	if( $inHeader == true)
	{ clearLoginCookie(); }
	clearSessionUser();
}

// ************************************************************
// log in functions
// ************************************************************
// sets the $_SESSION variable with user ID
// should be called when loading every page
function setUserId($inHeader = true)
{	if( isSetSession())
	{ return getSessionId(); }
	else
	{	if( isSetCookie() )
		{	$conError = false;
			$errStr = "";
			$errDetails = "";
			$haveError = false;
			
			$con = mysqli_connect($_SESSION['sqlServer'], $dbView, $viewPW, 'ajs_blogs');
			if( mysqli_connect_errno())
			{	$haveError = true;
				$errStr .= 'Error connecting to server<br />';
				$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
			}
			else
			{	if( $stmt = mysqli_prepare($con, "SELECT emailAdr, isActive, adminHold FROM GuestUsers where userID=?"))
				{	$cookieID = getLoginCookie();
					mysqli_stmt_bind_param($stmt, "s", $cookieID);
					mysqli_stmt_execute($stmt);
					if( mysqli_stmt_error($stmt) != "")
					{	$conError = true; 
						$errStr .= 'Error executing query<br />';
						$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
					}
					mysqli_stmt_bind_result($stmt, $email, $isAct, $admHold);
					mysqli_stmt_fetch($stmt);
					
					// perfomed db lookup, now validate
					//	1) check that cookie user exists
					if( $email == "")	// cookie user does not exist
					{ $haveError = true; }
					//	2) check that cookie user is active
					elseif( $isAct == false)
					{ $haveError = true; }
					//	3) check that cookie user isnt on admin hold
					elseif( $admHold == true)
					{ $haveError = true; }
					//	4) if 1-3 are good, set session, if not, clear cookie
					if( $haveError == true) // clear out bad cookie 
					{ clearAllLogin($inHeader); }
					else
					{ setSessionUser($cookieID); }

					mysqli_stmt_close($stmt);
				}
				else
				{	$conError = true;
					$errStr .= 'Error preparing query<br />';
					$errDetails .= __FILE__.': line: '.__LINE__.'<br />';
				}
				mysqli_close($con);
			}
			if( $conError == true)
			{ return; } // error connection to SQL server, just quit out

			// check again, in case $_SESSION was set from cookie
			if( isSetSession())
			{ return getSessionId; }
		}
	}
}

?>