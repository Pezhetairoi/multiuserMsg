<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 30 Jun 2015
*/
//define a constant to authorize the access to inc.php
define('HF', true);

//define a constant to specify the css of the current page
define('SCRIPT','activate');


require dirname(__FILE__).'/includes/common.inc.php';

//handle activation
if(!isset($_GET["activate"])){
    alert_return("invalid");
}
if(isset($_GET["action"]) && isset($_GET["activate"]) && $_GET["action"] =="ok"){
    
    $sql = "select tg_activate from tg_guest where tg_activate= '{$_GET["activate"]}'";  
    
    $result = $conn->query($sql) or die($conn->error);
    if($result->fetch_assoc()){
        $sql = "update tg_guest set tg_activate = NULL where tg_activate = '{$_GET["activate"]}'";
        $result = $conn->query($sql) or die($conn->error);
        
        if($conn->affected_rows == 1){
            $conn->close();
            location("Activation successful !", "login.php");
        }else{
            $conn->close();
            location("Activation failed", "register.php");
        }
    }else{
        alert_return("Invalid operation");
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php 
    require "includes/title.inc.php";
?>

<script type="text/javascript" src="js/register.js"></script>
<title>Activate</title>
</head>
<body>
    <?php
       //include header
       require ROOT_PATH.'includes/header.inc.php';
    ?>
    
    <div id="activate">
        <h2>Activate Your Account</h2>
        <p>This page simulates your email functionalities, click the link below to activate your account.</p>
        <p><a href="activate.php?action=ok&amp;activate=<?php echo $_GET["activate"]?>"><?php echo 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>activate.php?action=ok&amp;activate=<?php echo $_GET["activate"]?></a></p>

        
    </div>
    
    <?php 
        require ROOT_PATH.'includes/footer.inc.php';
    ?>
    </body>
</html>