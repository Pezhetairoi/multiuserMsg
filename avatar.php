<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 21 Jun 2015
*/

//define a constant to authorize the access to inc.php
define('HF', true);

//define a constant to specify the css of the current page
define('SCRIPT', 'avatar');

//define a constant to specify the css of the current page
require dirname(__FILE__).'/includes/common.inc.php';


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Choose Your Avatar</title>
<?php 
    require ROOT_PATH."includes/title.inc.php";
?>
<script type="text/javascript" src="js/popup.js"></script>
</head>
<body>
    <div id="avatar">
        <h3>Choose avatar</h3>
        <dl>
        <?php foreach(range(2,11) as $number){?>
        <dd><img src="images/avatar/<?php echo $number?>.jpg" alt="images/avatar/<?php echo $number?>.jpg" title="<?php echo $number?>"/></dd>        
        <?php }?>
        
        </dl>
    </div>
</body>
</html>