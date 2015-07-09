<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 21 Jun 2015
*/

session_start();

//define a constant to authorize the access to inc.php
define('HF', true);

require dirname(__FILE__).'/includes/common.inc.php';

//run passcode function _code();
_code(75, 28, 4, false);

?>