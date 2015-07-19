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
define('SCRIPT','post');

require dirname(__FILE__).'/includes/common.inc.php';

if(!isset($_COOKIE["username"])){
    alert_return("You must log in before publish article");
}

if(isset($_GET["action"]) && $_GET["action"] == "post") {
    //varify passcode
    checkCode($_POST["passcode"], $_SESSION["code"]); 
    
    //check if cookie exists
    $result = $conn->query("SELECT tg_uniqid
        FROM tg_guest
        WHERE tg_username = '{$_COOKIE["username"]}'");
    
    if(!!$row = $result->fetch_assoc()){
        //check if uniqid matches
        //call matchUniqid
        matchUniqid($row["tg_uniqid"], $_COOKIE["uniqid"]);    
    }
    include ROOT_PATH.'includes/check.func.php';
    //retrieve article details
    $clean = array();
    $clean["username"] = $_COOKIE["username"];
    $clean["type"] = $_POST["type"];
    $clean["title"] = check_art_title($_POST["title"]);
    $clean["content"] = check_art_content($_POST["content"]);
    //write to db
    //insert new user
    $sql =
            "INSERT INTO tg_article (
                            tg_username,
                            tg_title,
                            tg_type,
                            tg_content,
                            tg_date
                            )
            VALUES (
                            '{$clean["username"]}',
                            '{$clean["title"]}',
                            '{$clean["type"]}',
                            '{$clean["content"]}',
                            NOW())";                           
    $conn->query($sql) or die($conn->error);
  
    if($conn->affected_rows == 1){
        //get id from last query
        $clean["id"] = $conn->insert_id;   
        $conn->close();
        session_destroy();
        location("Article published!", "article.php?article=".$clean['id']);
    }else{
        $conn->close();
        session_destroy();
        location("Sorry, Publish failed !", "post.php");
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

<script type="text/javascript" src="js/passcode.js"></script>
<script type="text/javascript" src="js/post.js"></script>
<title>Write Article</title>
</head>
    <body>
   <?php
   //include header
   require ROOT_PATH.'includes/header.inc.php';
   ?>
   <div id='post'>
    <h2>Write Article</h2>
    <form method="post" name="post" action="?action=post">
        <dl>
            <dt>Please fill in each of the following:</dt>
            <dd><?php foreach(range(1,8) as $num){
                                        if($num ==1){
                                            echo '<input type="radio" id="type'.$num.'" name="type" value="'.$num.'" checked="checked"></input>';
                                        }else{
                                            echo '<input type="radio" id="type'.$num.'" name="type" value="'.$num.'" ></input>';            
                                        }
                                        echo '<img src="images/icon'.$num.'.gif" class="icon" alt="type"/>  ';
                                    }?></dd>
            <dd>Title</dd>
            <dd><input type="text" name="title" class="text" /></dd>
            
            <dd>Subject</dd>
            <dd>
                <?php include ROOT_PATH.'includes/ubb.inc.php'?>  
                <textarea name="content" >
                </textarea></dd>
            <dd><input type="text" name="passcode" class="passcode" />
                                        <img src="code.php" id="code" />
                                        <input type="submit" value="Publish" class="submit" />
            </dd>
            
         </dl>
    </form>    
   </div>
   <?php 
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
    </body>
</html>