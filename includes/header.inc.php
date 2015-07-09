<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 20 Jun 2015
*/
if(!defined('HF')){
    exit('Access Denied');
}

//message reminder if there is
$msg = $conn->query("SELECT COUNT(tg_id) 
                     FROM tg_msg 
                     WHERE tg_state=0
                     AND tg_touser = '{$_COOKIE["username"]}'  
                    ");

$count = $msg->fetch_row();
//echo $count[0];

if($count[0] == 0){
    $count_html = "<strong class='noread'><a href ='check_msg.php'>(0)</a></strong>";
}else{
    $count_html = "<strong class='read'><a href ='check_msg.php'>(".$count[0].")</a></strong>";
}
?>
<div id="header">
    <h1></h1>
    <ul>
        <li><a href="index.php">Home</a></li>
       
        <?php 
            if(isset($_COOKIE["username"])){
                echo '<li><a href="member.php">'.$_COOKIE["username"].'\'s Spot</a></li>';
                echo "\n";
            }else{
                
                echo '<li><a href="register.php">Register</a></li>';
                echo "\n";
                echo "\t\t";
                echo '<li><a href="login.php">Sign-in</a></li>';
                echo "\n";
            }
        ?>
        <li><a href="friend.php">Friends</a></li>
        <li>Style</li>
        <li><a href="settings.php">Settings</a><?php echo $count_html ?></li>
        <?php 
        if(isset($_COOKIE["username"])){
            echo '<li><a href="logout.php">Sign-out</a></li>';
        }
        ?>
    </ul>
</div>
