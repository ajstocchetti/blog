<?php
	if( isset($_POST['errorText']))
	{	echo '<font color="red">';
		echo $_POST['errorText'];
		echo '</font><br />';
	}
?>

<form method="post" action="index.php">
Email:<br />
<input type="text" name="userID"><br /><br />
Password:<br />
<input type="password" name="password"><br /><br />
<input type="checkbox" name="remember">Keep me logged in (<i>must have cookies enabled</i>)<br /><br />
<input type="submit" value="Log In">
<input type="hidden" name="loginfo" value="submit">
</form>

<br /><br />
<p>Don't have a login? <a href="/register">Click here</a> to set up a user</p>