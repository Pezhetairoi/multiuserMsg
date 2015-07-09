<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 2 Jul 2015
*/

session_start();
//define a constant to authorize the access to inc.php
define('HF', true);

//define a constant to specify the css of the current page
define('SCRIPT','friend');

require dirname(__FILE__).'/includes/common.inc.php';

global $conn;

page_param("SELECT tg_id FROM tg_guest", 4, $conn);

//extract user from db
$sql2 = "SELECT tg_id, tg_username, tg_avatar, tg_gender 
           FROM tg_guest 
            ORDER BY tg_reg_time DESC LIMIT $page_start, $pagesize";
$result2 = $conn->query($sql2) or die(mysqli_error());

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script type="text/javascript" src="js/passcode.js"></script>
<script type="text/javascript" src="js/login.js"></script>
<script type="text/javascript" src="js/friend.js"></script>
<?php 
    require "includes/title.inc.php";
?>

<title>Your Friends</title>
</head>
    <body>
    <?php
   //include header
   require ROOT_PATH.'includes/header.inc.php';
   ?>
   
   <div id="friend">
        <h2>Friends List</h2>
        <?php 
            while(!!$rows = $result2->fetch_assoc()){
                $user_info = array();
                $user_info["id"] = $rows["tg_id"];
                $user_info["username"] = $rows["tg_username"];
                $user_info["avatar"] = $rows["tg_avatar"];
                $user_info["gender"] = $rows["tg_gender"];
                $user_info = htmlFilter($user_info);
        ?>
        <dl>
            <dd class="name"><?php echo $rows["tg_username"].'  '; echo "(".$rows["tg_gender"].")"?></dd> 
            <dt><img src='<?php echo $rows["tg_avatar"]?>' alt="" /></dt>
            <dd class="msg"><a href="#" name="msg" title = "<?php echo $user_info['id']?>" >Send Text</a></dd>
            <dd class="comment">Post Comment</a></dd>
            <dd class="friend"><a href="#" name="addfriend" title = "<?php echo $user_info['id']?>" >Add Friend</a></dd>
            <dd class="flower">Send Star</dd>
        </dl>
        <?php }
            
            $result2->free();
            
            //call page() and pass num
            page(2);
        ?>
    
   </div>
   
    <?php
    //include footer 
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
    </body>
</html>