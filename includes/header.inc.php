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
       
        <li><a href="settings.php">Settings</a><?php 
                if(isset($_COOKIE["username"])){
                    echo $GLOBALS['count']; 
                }?>
        </li>
        <?php 
        if(isset($_COOKIE["username"])){
            echo '<li><a href="logout.php">Sign-out</a></li>';
        }
        ?>
    </ul>
</div>
