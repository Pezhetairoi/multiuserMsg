<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 5 Jul 2015
*/

session_start();

//define a constant to authorize the access to inc.php
define('HF', true);

//define a constant to specify the css of the current page
define('SCRIPT','settings_edit');

require dirname(__FILE__).'/includes/common.inc.php';

if(isset($_GET["action"]) && $_GET["action"] == "edit"){
    checkCode($_POST["passcode"], $_SESSION["code"]);
    //check if cookie exists
    $result = $conn->query("SELECT tg_uniqid 
                            FROM tg_guest 
                            WHERE tg_username = '{$_COOKIE["username"]}'");
    
    //check if uniqid matches
    if(!!$row = $result->fetch_assoc()){
        
        //call matchUniqid
        matchUniqid($row["tg_uniqid"], $_COOKIE["uniqid"]);
        
        include ROOT_PATH."includes/check.func.php";
        
        $reg_info = array();
        $reg_info["password"] = modifyPassword($_POST["password"], 6);
        $reg_info["email"] = checkEmail($_POST["email"], 10, 40);
        $reg_info["gender"] = checkGender($_POST["gender"]);
        $reg_info["avatar"] = checkAva($_POST["avatar"]);
        
        //update fields
        if(empty($reg_info["password"])){
            $conn->query("UPDATE tg_guest SET
                                        tg_gender='{$reg_info['gender']}',
                                        tg_email='{$reg_info['email']}',
                                        tg_avatar='{$reg_info['avatar']}'
                                        WHERE   
                                        tg_username='{$_COOKIE['username']}'
                                 ");
        }else{
            $conn->query("UPDATE tg_guest SET
                                        tg_password='{$reg_info['password']}',
                                        tg_gender='{$reg_info['gender']}',
                                        tg_email='{$reg_info['email']}',
                                        tg_avatar='{$reg_info['avatar']}'
                                        WHERE   
                                        tg_username='{$_COOKIE['username']}'
                                 ");
                            
        }
    }
    
    //check if update is succeed
    if($conn->affected_rows == 1){
        $conn->close();
        session_destroy();
        location("Update successful !", "settings.php");
    }else{
        $conn->close();
        session_destroy();
        location("Sorry, Update failed !", "settings_edit.php");
    }
}

if(isset($_COOKIE["username"])){
    //retreive 
    $sql = "SELECT tg_username, tg_gender, tg_avatar, tg_email FROM tg_guest where tg_username = '{$_COOKIE['username']}'";
    $result = $conn->query($sql) or die($conn->error);
    
    if(!!$row = $result->fetch_assoc()){
        $html = array();
        $html["username"] = $row["tg_username"];
        $html["gender"] = $row["tg_gender"];
        $html["avatar"] = $row["tg_avatar"];
        $html["email"] = $row["tg_email"];
                
        $html = htmlFilter($html);
        
        //edit gender
        if($html["gender"] == "male"){
            $html["edit_gender"] = '<input type="radio" name="gender" value ="Male" checked="checked"/>Male 
                                    <input type="radio" name="gender" value ="Female"/>Female';
        }else{
            $html["edit_gender"] = '<input type="radio" name="gender" value ="Male" />Male
                                    <input type="radio" name="gender" value ="Female" checked="checked" />Female';
        }
        
        //edit avatar
        $html["edit_avatar"] = '<select name="avatar">';
        foreach(range(2,11) as $number){
            $html["edit_avatar"] .= '<option value="images/avatar/'.$number.'.jpg">'.$number.'.jpg</option>';
        }
        $html["edit_avatar"] .= '</select>';
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
<script type="text/javascript" src="js/passcode.js"></script>
<script type="text/javascript" src="js/settings_edit.js"></script>
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
       <form method="post" name="edit" action="settings_edit.php?action=edit">
        <dl>
            <dd>Username: <?php echo $html["username"] ?></dd>
            <dd>Password: <input type="password" class="text" name="password" />(Will not change if empty)</dd>
            <dd>Gender:   <?php echo  $html["edit_gender"] ?></dd>
            <dd>Avatar: <?php echo $html["edit_avatar"]?></dd>
            <dd>Email: <input type="text" name="email" value= "<?php echo $html["email"]?>" /></dd>
            <dd><label>Passcode:   </label><input type="text" name="passcode" class="passcode" />
                                        <img src="code.php" id="code" /></dd>
            <dd><input type="submit" value="Edit" class="submit" /></dd>
        </dl>
       </form>
    </div>
</div>

 <?php
//include footer 
require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>