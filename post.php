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
                                            echo '<input type="radio" id="type'.$num.'" name="radio" value="'.$num.'" checked="checked"></input>';
                                        }else{
                                            echo '<input type="radio" id="type'.$num.'" name="radio" value="'.$num.'" ></input>';            
                                        }
                                        echo '<img src="images/icon'.$num.'.gif" class="icon" alt="type"/>  ';
                                    }?></dd>
            <dd>Subject</dd>
            <dd><input type="text" name="subject" class="text" /></dd>
            
            <dd>Write something</dd>
            <dd>
                <div id="ubb">
                    <img src="images/fontsize.gif" title="font size"/>
                    <img src="images/space.gif"/>
                    <img src="images/bold.gif" title="bold"/>
                    <img src="images/italic.gif" title="italic"/>
                    <img src="images/underline.gif" title=""/>
                    <img src="images/strikethrough.gif" title="strike through"/>
                    <img src="images/space.gif"/>
                    <img src="images/color.gif" title="color"/>
                    <img src="images/url.gif" title="url"/>
                    <img src="images/email.gif" title="email"/>
                    <img src="images/image.gif" title="image" />
                    <img src="images/movie.gif" title="movie" />
                    <img src="images/space.gif" />
                    <img src="images/left.gif" title="left" />
                    <img src="images/center.gif" title="center" />
                    <img src="images/right.gif" title="right" />
                    <img src="images/space.gif" />
                    <img src="images/increase.gif" title="increase" />
                    <img src="images/decrease.gif" title="decrease" />
                </div>
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