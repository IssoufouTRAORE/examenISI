<?php

define("HOST", "localhost"); 			// The host you want to connect to.
define("USER", "root"); 			// The database username.
define("PASSWORD", ""); 	// The database password.
define("DATABASE", "markaz");             // The database name.


define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "user");

/**
 * Is this a secure connection?  The default is FALSE, but the use of an
 * HTTPS connection for logging in is recommended.
 *
 * If you are using an HTTPS connection, change this to TRUE
 */
define("SECURE", FALSE);    // For development purposes only!!!!
$mysqli = new PDO('mysql:host=localhost;dbname=markaz','root','');
?>