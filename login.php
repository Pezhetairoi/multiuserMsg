<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 30 Jun 2015
*/

session_start();
//define a constant to authorize the access to inc.php
define('HF', true);

//define a constant to specify the css of the current page
define('SCRIPT','login');

require dirname(__FILE__).'/includes/common.inc.php';

//check login state, no access to login.php if logged in
login_state();

//handle login
if(isset($_GET["action"]) && $_GET["action"]=="login"){
    checkCode($_POST["passcode"], $_SESSION["code"]);

    //verify login
    include ROOT_PATH."includes/login.func.php";
    
    //array that contains login info
    $login_info = array();
    $login_info["username"] = checkUsername($_POST["username"], 5, 20);
    $login_info["password"] = checkLoginPassword($_POST["password"],6);
    
    //check against db entries
    $sql = "select tg_username, tg_uniqid from tg_guest where tg_username = '{$login_info["username"]}' and tg_password = '{$login_info["password"]}' limit 1";
    $result = $conn->query($sql) or die($conn->error);
    if(!!$row = $result->fetch_assoc()){
        //printf("%s (%s)\n", $row["tg_username"], $row["tg_uniqid"]);
        
        //record login info, last login time, login count
        $result = $conn->query("UPDATE tg_guest SET 
                                        tg_last_time = NOW(),
                                        tg_last_ip = '{$_SERVER["REMOTE_ADDR"]}',
                                        tg_login_count = tg_login_count + 1
                                     WHERE
                                        tg_username = '{$row["tg_username"]}'
                            ");
        $conn->close();
        session_destroy();
        
        //set cookie
        _setCookies($login_info["username"], $row["tg_uniqid"]);
        location(null, "index.php");
    }else{
        $conn->close();
        session_destroy();
        location("Incorrect username or password, or account has not been activated.", "login.php");
    }
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script type="text/javascript" src="js/passcode.js"></script>
<script type="text/javascript" src="js/login.js"></script>
<?php 
    require "includes/title.inc.php";
?>

<title>Insert title here</title>
</head>
    <body>
    <?php
   //include header
   require ROOT_PATH.'includes/header.inc.php';
   ?>
    
   <div id="login">
        <h2>Sign-in</h2>
        <form method="post" name="login" action="login.php?action=login">
 
            <dl>
                <dt>Please fill in each of the following:</dt>
                <dd><label>Username</label><input type="text" name="username" class="text" /></dd>
                <dd><label>Password</label><input type="password" name="password" class="text" /></dd>
                <dd><label>Passcode</label><input type="text" name="passcode" class="passcode" />
                                        <img src="code.php" id="code" /></dd>
                <dd><input type="submit" value="Sign-in" class="button" />  <input type="button" value="Register" id="location" class="button location" /></dd>
            </dl>
        </form>
   </div>
    
    
    
    <?php
    //include footer 
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
    
    </body>
</html>