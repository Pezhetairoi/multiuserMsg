<?php
/**
* TestGuest Version 0.4
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 21 Jun 2015
*/
session_start();
//define a constant to authorize the access to inc.php
define('HF', true);

//define a constant to specify the css of the current page
define('SCRIPT','register');


require dirname(__FILE__).'/includes/common.inc.php';

//check login state, no access to register.php if logged in
login_state();

//check if the form is submitted
if(isset($_GET["action"]) && $_GET["action"]=="register"){
    //varify passcode
    checkCode($_POST["passcode"], $_SESSION["code"]);        
    
    include ROOT_PATH."includes/check.func.php";
    $reg_info = array();
    //uniqid for security 
    $reg_info["uniqid"] = checkUniqid($_POST["uniqid"],$_SESSION["uniqid"]);
    
    //activate is also a uniqid, is used to activate new user
    $reg_info["activate"] = sha1_uniqid();
    $reg_info["username"] = checkUsername($_POST["username"]);
    $reg_info["password"] = checkPassword($_POST["password"],$_POST["notpassword"],6);
    $reg_info["passhint"] = checkHint($_POST["passhint"], 6, 20);
    $reg_info["passans"] = checkAns($_POST["passhint"], $_POST["passans"],6, 20);
    $reg_info["email"] = checkEmail($_POST["email"], 10, 40);
    $reg_info["gender"] = checkGender($_POST["gender"]);
    $reg_info["avatar"] = checkAva($_POST["imgalt"]);
    
    //check username duplicate
    $q1 = "SELECT tg_username 
            FROM tg_guest 
            WHERE tg_username = '{$reg_info["username"]}'";
    
    $result = $conn->query($q1) or die($conn->error);
    if($result->fetch_assoc()){
        alert_return("Sorry, username already exists.");
    }
    
    //insert new user 
        $q2 = 
        "INSERT INTO tg_guest (
                               tg_uniqid,
                               tg_activate,
                               tg_username,
                               tg_password,
                               tg_hint,
                               tg_answer,
                               tg_email,
                               tg_gender,
                               tg_avatar,
                               tg_reg_time,
                               tg_last_time,
                               tg_last_ip
                                ) 
                     VALUES (
                             '{$reg_info["uniqid"]}',
                             '{$reg_info["activate"]}',
                             '{$reg_info["username"]}',
                             '{$reg_info["password"]}',
                             '{$reg_info["passhint"]}',
                             '{$reg_info["passans"]}',
                             '{$reg_info["email"]}',
                             '{$reg_info["gender"]}',
                             '{$reg_info["avatar"]}',
                              NOW(),
                              NOW(),
                             '{$_SERVER["REMOTE_ADDR"]}'
    
                              )";   
    $conn->query($q2) or die($conn->error);
    if($conn->affected_rows == 1){
        
        //get id from last query
        $reg_info["id"] = $conn->insert_id;
        
        $conn->close();
        session_destroy();
        
        //write to xml user details
        setxml("test.xml", $reg_info);
        
        location("Registration successful !", "activate.php?activate=".$reg_info['activate']);
    }else{
        $conn->close();
        session_destroy();
        location("Sorry, registration failed !", "register.php");
    }  
}else{
    $_SESSION["uniqid"] = $uniqid = sha1_uniqid();
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

<script type="text/javascript" src="js/passcode.js"></script>
<script type="text/javascript" src="js/register.js"></script>
<title>Insert title here</title>
</head>
    <body>
   <?php
   //include header
   require ROOT_PATH.'includes/header.inc.php';
   ?>
   <div id='register'>
    <h2>Register</h2>
    <form method="post" name="register" action="register.php?action=register">
        <input type="hidden" name="uniqid" value="<?php echo $uniqid ?>" />
        <dl>
            <dt>Please fill in each of the following:</dt>
            <dd><label>Username</label><input type="text" name="username" class="text" /></dd>
            <dd><label>Password</label> <input type="password" name="password" class="text" /></dd>
            <dd><label>Confirm Password</label><input type="password" name="notpassword" class="text" /></dd>
            <dd><label>Password Hint</label> <input type="text" name="passhint" class="text" /></dd>
            <dd><label>Password Answer</label><input type="text" name="passans" class="text" /></dd>
            <dd><label>Gender</label><input type="radio" name="gender" value ="male" checked="checked"/>Male
                        <input type="radio" name="gender" value ="female"/>Female
            </dd>
            <dd><label style='padding: 50px 0 0 0;'>Choose Avatar</label><img id="avaimg" src="images/avatar/2.jpg" alt="$number"/>
                <input type="hidden" name="imgalt" value="images/avatar/2.jpg" /></dd>
            <dd><label>Email</label><input type="text" name="email" class="text" /></dd>
            <dd><label>Passcode</label><input type="text" name="passcode" class="passcode" />
                                        <img src="code.php" id="code" />
            </dd>
            <dd><input type="submit" value="Register" class="submit" /></dd>
         </dl>
    </form>    
   </div>
   <?php 
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
    </body>
</html>