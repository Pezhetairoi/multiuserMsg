<?php
/**
* TestGuest Version0.4 
* added register interface
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 20 Jun 2015
*/
if(!defined('HF')){
    exit('Access Denied');
}

//convert rootpath
define('ROOT_PATH',substr(dirname(__FILE__),0,-8));

require ROOT_PATH.'includes/global.function.php';
require ROOT_PATH.'includes/mysql.func.php';

//execute time taken to load page 
define('START_TIME', runtime());

//DB constant
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', '');
define('DB_NAME', 'test_guest');


_connect();


?>