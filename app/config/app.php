<?php
	define('APP_NAME', "jaiunegrosseteu.be");
	define('APP_SERVER', "http://jaiunegrosseteu.be");
	define('APP_TITLE', "jaiunegrosseteu.be");
	define('APP_DESC', 'jaiunegrosseteu.be');
	define('APP_ANALYTICS', 'UA-13184829-x');

	define('PROD', (!empty($_SERVER['SERVER_NAME']) && strpos($_SERVER['SERVER_NAME'], APP_SERVER) !== false));