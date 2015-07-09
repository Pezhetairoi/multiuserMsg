<?php  
/**
 * TestGuest Version 0.4
 1. register interface added
 2. avatar popup window added 
 3. JSEclispe installed to achieve popup effect
 4. CSS file extracted to ruduce code redundancy
 * ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 21 Jun 2015
*/   
    //define a constant to authorize the access to inc.php
    define('HF', true);
    
    //define a constant to specify the css of the current page
    define('SCRIPT','index');
    
    require dirname(__FILE__).'/includes/common.inc.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Your Title</title>
<?php 
    require ROOT_PATH."includes/title.inc.php";
?>
</head>
<body>
<?php    
    require ROOT_PATH.'includes/header.inc.php';   
?>
<div id="list">
    <h2>Archiving List</h2>
</div>

<div id="user">
    <h2>New Members</h2>
</div>
<div id="pics">
    <h2>Gallery</h2>
</div>
<?php 
    require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>