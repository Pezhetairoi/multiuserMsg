<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 5 Jul 2015
*/

//define a constant to authorize the access to inc.php
define('HF', true);

//define a constant to specify the css of the current page
define('SCRIPT','settings');

require dirname(__FILE__).'/includes/common.inc.php';

if(isset($_COOKIE["username"])){
    //retreive 
    $sql = "SELECT tg_username, tg_gender, tg_avatar, tg_email, tg_reg_time, tg_level 
            FROM tg_guest 
            WHERE tg_username = '{$_COOKIE['username']}'";
    $result = $conn->query($sql) or die($conn->error);
    
    if(!!$row = $result->fetch_assoc()){
        $html = array();
        $html["username"] = $row["tg_username"];
        $html["gender"] = $row["tg_gender"];
        $html["avatar"] = $row["tg_avatar"];
        $html["email"] = $row["tg_email"];
        $html["reg_time"] = $row["tg_reg_time"];
        switch ($row["tg_level"]){
            case 0: 
                $html["level"] = "Member";
                break;
            case 1: 
                $html["level"] = "Admin";
                break;
            default: 
                $html["level"] = "Error";
        }
        
        $html = htmlFilter($html);
    }else{
        alert_return("Username doesn't exist.");
    }
    
}else{
    alert_return("You need to log in first.");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Settings</title>
<?php 
    require "includes/title.inc.php";
?>
</head>
<body>

<?php
//include header
require ROOT_PATH.'includes/header.inc.php';
?>


<?php 
require ROOT_PATH.'includes/settings.inc.php';
?>

<div id="settings">
    
    <div id="settings_main">
        <dl>
            <dd>Username: <?php echo $html["username"] ?></dd>
            <dd>Gender:   <?php echo $html["gender"] ?></dd>
            <dd>Avatar: <?php echo $html["avatar"]?></dd>
            <dd>Email: <?php echo $html["email"]?></dd>
            <dd>Register Date: <?php echo $html["reg_time"]?></dd>
            <dd>Membership: <?php echo $html["level"]?></dd>
        </dl>
    </div>
</div>

 <?php
//include footer 
require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>