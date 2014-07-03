<?php
if( $_SERVER['SCRIPT_FILENAME'] != $root.'/index.php')
{	echo '
	<a href="/">Back to Home</a>
	<br />';
}
echo '<a href="/blog/">My Stories</a><br />';
echo '<a href="/photos/">Photos</a><br />';
if( isSetSession())
{ echo '<a href="/login/logout.php">Log Out</a><br />'; }
else
{ echo '<a href="/login/">Log In</a><br />'; }
echo '<a href="/ag2i/">AG2I</a><br />';
//echo '<a href="/harmonica/">Harmonica Tabs</a><br />';
?>