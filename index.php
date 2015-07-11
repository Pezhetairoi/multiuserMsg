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

    //read xml file $xml is an array
    $xml = getxml("test.xml");
    //print_r($xml);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Your Title</title>
<script type="text/javascript" src="js/passcode.js"></script>
<script type="text/javascript" src="js/friend.js"></script>
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
    <h2>New Member</h2>
    <dl>
        <dd class="name"><?php echo $xml["username"] ?>(<?php echo $xml["gender"]?>)</dd> 
        
        <dt><img src='<?php echo $xml["avatar"]?>' alt="<?php echo $xml["avatar"]?>" /></dt>
        <dd class="msg"><a href="#" name="msg" title = "<?php echo $xml["id"] ?>" >Send Text</a></dd>
        <dd class="comment">Post Comment</a></dd>
        <dd class="friend"><a href="#" name="addfriend" title = "<?php echo $xml["id"] ?>" >Add Friend</a></dd>
        <dd class="star"><a href="#" name="sendstar" title = "<?php echo $xml["id"] ?>" >Send Star</a></dd>
        <dd class="email">Email: <?php echo $xml["email"]?></dd>
    </dl>
</div>
<div id="pics">
    <h2>Gallery</h2>
</div>
<?php 
    require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>