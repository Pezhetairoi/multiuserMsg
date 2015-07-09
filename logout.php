<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 1 Jul 2015
*/

session_start();

define('HF', true);

require dirname(__FILE__).'/includes/common.inc.php';

//delete cookie and redirect to index.php
_deleteCookies();
?>