<?php 

# APP TAG
define('APP_TAG', 'persoapp');

# DATABASE
define('DB_ENGINE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'persoappfinal');
define('DB_CHARSET', 'utf8mb4');
define('DB_USER', 'root');
define('DB_PWD', '');

define('DSN', DB_ENGINE .':host='. DB_HOST .';dbname='. DB_NAME .';charset='. DB_CHARSET );