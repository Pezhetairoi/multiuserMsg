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
define('SCRIPT','check_star');

require dirname(__FILE__).'/includes/common.inc.php';

//check if user has signed in
if(!isset($_COOKIE["username"])){
    alert_return("Please sign in first.");
}

//delete all message module
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
        $conn->query("DELETE FROM tg_star
                      WHERE tg_id
                         IN ({$boxes["box"]})");
        
        //if delete succeed
        if($conn->affected_rows){
            $conn->close();
            location("Delete successful!", "check_star.php");
        }else{
            $conn->close();
            alert_return("Delete failed.");
        }
        
    }else{
        alert_return("Illegal Operation");
    }

}

//get page divide module
global $conn;
page_param("SELECT tg_id 
            FROM tg_msg 
            WHERE tg_touser='{$_COOKIE["username"]}'", 10, $conn);

//extract user from db
$sql2 = "SELECT tg_id, tg_star, tg_fromuser, tg_content, tg_date
        FROM tg_star
        WHERE tg_touser = '{$_COOKIE["username"]}'
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

<title>Insert title here</title>
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
        <h2>Check Star</h2>
        <form method="post" action="check_star.php?action=delete">
        <table cellspacing="1">
            <tr><th>Send from</th><th>Stars</th><th>Comment</th><th>Sent at</th><th>Manage</th></tr>
            
            <?php
            $msg_info = array(); 
            $msg_info["sum"] = null;
            while(!!$rows = $result2->fetch_assoc()){
                    
                    $msg_info["id"] = $rows["tg_id"];
                    $msg_info["content"] = $rows["tg_content"];
                    $msg_info["star"] = $rows["tg_star"];
                    $msg_info["fromuser"] = $rows["tg_fromuser"];                 
                    $msg_info["date"] = $rows["tg_date"];
                    
                    $msg_info["sum"] += $msg_info["star"];                   
            ?>

            <tr><td><?php echo $msg_info["fromuser"]?></td>
                <td><img src="images/x4.gif" alt="star"/><?php echo ' x '.$msg_info["star"]?></td>
                <td><?php echo $msg_info["content"]?></td>
                <td><?php echo $msg_info["date"]?></td>
                <td><input type="checkbox" name="box[]" value="<?php echo $msg_info["id"] ?>" /></td></tr>
            
            <?php 
            }
            $result2->free();
            
            ?>
            
            <tr><td colspan="5"><label>Select All<input type="checkbox" name="checkall" id="checkall" /></label><input type="submit" value="Delete All" /></td></tr>
            <tr><td colspan="5">Total <?php echo $msg_info["sum"]?> </td></tr>
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