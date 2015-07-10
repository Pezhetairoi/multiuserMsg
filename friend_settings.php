<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 8 Jul 2015
*/
//define a constant to authorize the access to inc.php
define('HF', true);

//define a constant to specify the css of the current page
define('SCRIPT','friend_settings');

require dirname(__FILE__).'/includes/common.inc.php';

//check if user has signed in
if(!isset($_COOKIE["username"])){
    alert_return("Please sign in first.");
}

//approve friend request
if(isset($_GET["action"]) && ($_GET["action"] == "approve") && isset($_GET["id"])){
    //check if cookie exists
    $result = $conn->query("SELECT tg_uniqid
        FROM tg_guest
        WHERE tg_username = '{$_COOKIE["username"]}'");
    
    if(!!$row = $result->fetch_assoc()){
        //check if uniqid matches
        //call matchUniqid
        matchUniqid($row["tg_uniqid"], $_COOKIE["uniqid"]);
        
        //update state of in friend table to approve request
        $conn->query("UPDATE tg_friend
                      SET tg_state = 1
                      WHERE tg_id = '{$_GET["id"]}'
                    ");
        //if update succeed
        if($conn->affected_rows == 1){
            $conn->close();
            location("Friend request approved.", "friend_settings.php");
        }else{
            $conn->close();
            alert_return("Friend request not approved.");
        }
        
    }else{
        alert_return("Illegal Operation");
    }
    
}

//bulk delete friends module
if(isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_POST["box"])){
    $boxes = array();
    $boxes["box"] = implode(",", $_POST["box"]);

    //check if cookie exists
    $result = $conn->query("SELECT tg_uniqid
                            FROM tg_guest
                            WHERE tg_username = '{$_COOKIE["username"]}'");

    if(!!$row = $result->fetch_assoc()){
        //check if uniqid matches
        //call matchUniqid
        matchUniqid($row["tg_uniqid"], $_COOKIE["uniqid"]);

        //bulk delte operation
        $conn->query("DELETE FROM tg_friend
            WHERE tg_id
            IN ({$boxes["box"]})
            ");

        //if delete succeed
        if($conn->affected_rows){
            $conn->close();
            location("Friend delete successful!", "friend_settings.php");
        }else{
            $conn->close();
            alert_return("Failed, friend not deleted.");
        }

    }else{
        alert_return("Illegal Operation");
    }

}
//get page divide module
global $conn;
page_param("SELECT tg_id 
            FROM tg_friend 
            WHERE tg_touser='{$_COOKIE["username"]}' 
                OR tg_fromuser = '{$_COOKIE["username"]}'
            ", 10, $conn);

//extract user from db
$sql2 = "SELECT tg_id, tg_state, tg_touser, tg_fromuser, tg_content, tg_date
        FROM tg_friend
        WHERE tg_touser = '{$_COOKIE["username"]}'
            OR tg_fromuser = '{$_COOKIE["username"]}'
        ORDER BY tg_date DESC LIMIT $page_start, $pagesize";
$result2 = $conn->query($sql2) or die(mysqli_error());

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<?php 
    require "includes/title.inc.php";
?>

<title>Friend Settings</title>
<script type="text/javascript" src="js/check_msg.js"></script>
</head>
    <body>
    <?php
    //include header
    require ROOT_PATH.'includes/header.inc.php';
    
    //include setting sidebar
    require ROOT_PATH.'includes/settings.inc.php';
    ?>
   
   <div id="settings_main">
        <h2>Friends Settings</h2>
        <form method="post" action="friend_settings.php?action=delete">
        <table cellspacing="1">
            <tr><th>Friends</th><th>Content</th><th>Date</th><th>State</th><th>Manage</th></tr>
            <?php 
            while(!!$rows = $result2->fetch_assoc()){
                    $friend_setting = array();
                    $friend_setting["id"] = $rows["tg_id"];
                    $friend_setting["content"] = $rows["tg_content"];
                    $friend_setting["fromuser"] = $rows["tg_fromuser"]; 
                    $friend_setting["touser"] = $rows["tg_touser"]; 
                    $friend_setting["state"] = $rows["tg_state"];               
                    $friend_setting["date"] = $rows["tg_date"];
                    
                    //friend includes ppl send req to you and you sent to others
                    if($friend_setting["touser"] == $_COOKIE["username"]){                        
                        $friend_setting["befriend"] = $friend_setting["fromuser"];
                        if(empty($friend_setting["state"])){
                            $friend_setting["approved"] = "<a href='?action=approve&id=".$friend_setting["id"]."' style='color: maroon'>You have not approved yet</a>";
                        }else{
                            $friend_setting["approved"] = "<span style='color:green'>Approved</span>";
                        }
                        
                    }elseif ($friend_setting["fromuser"] == $_COOKIE["username"]){
                        $friend_setting["befriend"] = $friend_setting["touser"];
                        if(empty($friend_setting["state"])){
                            $friend_setting["approved"] = "<span style='color: maroon'>not approved yet</span>";
                        }else{
                            $friend_setting["approved"] = "<span style='color:green'>Approved</span>";
                        }
                        
                    }
                    
            ?>
 
            <tr><td><?php echo $friend_setting["befriend"]?></td>
                <td title = "<?php echo $friend_setting["content"] ?>"><?php echo $friend_setting["content"]?></td>
                <td><?php echo $friend_setting["date"]?></td>
                <td><?php echo $friend_setting["approved"]?></td>
                <td><input type="checkbox" name="box[]" value="<?php echo $friend_setting["id"] ?>" /></td></tr>
            
            <?php 
            }
            $result2->free();
            
            ?>
            <tr><td colspan="5"><label>Select All<input type="checkbox" name="checkall" id="checkall" /></label><input type="submit" value="Delete All" /></td></tr>
        </table>
        </form>
        <?php 
        page(2);
        ?>
   </div>
     
    <?php
    //include footer 
    require ROOT_PATH.'includes/footer.inc.php';
    ?>  
    </body>
</html>