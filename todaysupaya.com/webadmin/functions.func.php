<?php

include "logerror.func.php";

function getServerID()
{	return (strpos($_SERVER['DOCUMENT_ROOT'], 'C:/wamp/www') === 0) ? 'localhost' : 'mysql.todaysupaya.com';	}

?>