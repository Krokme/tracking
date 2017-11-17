<?php
define ('DEBUG', false);

define ('DEF_LANG', 'en');

ini_set('date.timezone', 'Europe/Riga');

define('DS', DIRECTORY_SEPARATOR);

define('BASE_DIR', __DIR__ . DS . '..' . DS);

define ('CORE_PATH', 'core');
define ('FULL_PATH', 'dev.tracking.lv');

// if project not in domain root
//define ('PROJECT_PATH', '/dev.latlototest.lv/public/');
// if project in domain root
define ('PROJECT_PATH', '/');

// -- default application classes
$GLOBALS['CORE_CLASSES'] = [
                           'request' => 'Core\Request',
                           'db' => 'Core\Db',
                           'session' => 'Core\Session',
                           ];

// -- db configuration
define ('DB_HOST',  'mysql:host=localhost;port=3306;dbname=tracking');
define ('DB_LOGIN', 'root');
define ('DB_PSW',   '');
define ('DB_NAME',  'tracking');

define ('USERS_TBL', 'users');
define ('TICKETS_TBL', 'tickets');
define ('PROJECTS_TBL', 'projects');