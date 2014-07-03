<h2>Register a new user</h2>
Once you register, you can log in and comment on posts. All fields are required.<br /><br />
<?php
	$usrName="";
	$usrEml="";
	$usrDisp="";
	if( isset($_POST['userFullName'])) { $usrName=$_POST['userFullName']; }
	if( isset($_POST['emlAdr'])) { $usrEml=$_POST['emlAdr']; }
	if( isset($_POST['dispName'])) { $usrDisp=$_POST['dispName']; }

if( isset($_GET['errorText']))
{	echo '<font color="red">';
	echo $_GET['errorText'];
	echo '</font><br />';
}

echo'
<form action="index.php" method="post">
<table><tr><td>
name:<br /></td><td>
<input type="text" size="40" maxlength="40" name="userFullName" value="'.$usrName.'"></td>
</tr><tr><td>
display name: (how you appear)</td><td>
<input type="text" size="40" maxlength="40" name="dispName" value="'.$usrDisp.'"></td>
</tr><tr><td>
email address: (how you log in)</td><td>
<input type="text" size="40" maxlength="40" name="emlAdr" value="'.$usrEml.'"></td>
</tr><tr><td>
password:</td><td>
<input type="password" size="40" maxlength="25" name="pwone"></td>
</tr><tr><td>
verify password:</td><td>
<input type="password" size="40" maxlength="25" name="pwtwo">
</td></tr></table>
';
?>
<br />
<input type="submit" value="Register">
<input type="hidden" name="regInfo" value="regUser">
</form>