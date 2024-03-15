<?php

defined('DS') ? null :define('DS', DIRECTORY_SEPARATOR);

define('SITE_ROOT', DS . 'Applications' . DS . 'XAMPP' . DS . 'xamppfiles' . DS . 'htdocs'. DS . 'Gallery');

defined('INCLUDE_PATH') ? null :define('INCLUDE_PATH',  SITE_ROOT . DS . 'admin'. DS. 'includes');

require_once "new_config.php";
require_once "database.php";
require_once "db_object.php";
require_once "user.php";
require_once "photo.php";
require_once "functions.php";
require_once "Session.php";
