<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 19 Jul 2015
*/
//define a constant to authorize the access to inc.php
define('HF', true);
//define a constant to specify the css of the current page
define('SCRIPT','article');

require dirname(__FILE__).'/includes/common.inc.php';

//retrieve article by id
if(isset($_GET["id"])){
    $sql = "SELECT * 
            FROM tg_article
            WHERE tg_id='{$_GET["id"]}'    
        ";
    $result = $conn->query($sql) or die($conn->error);
    
    if(!!$rows = $result->fetch_assoc()){
        $article_info = array();
        $article_info["username"] = $rows["tg_username"];
        $article_info["type"] = $rows["tg_type"];
        $article_info["title"] = $rows["tg_title"];
        $article_info["content"] = $rows["tg_content"];
        $article_info["readcount"] = $rows["tg_readcount"];
        $article_info["commentcount"] = $rows["tg_commentcount"];
        $article_info["date"] = $rows["tg_date"];
        
        //check for specific username to retrieve userinfo      
        $result =$conn->query("SELECT tg_id, tg_gender, tg_avatar, tg_email
                               FROM tg_guest
                               WHERE tg_username = '{$article_info["username"]}'
                              ");
        if(!!$rows = $result->fetch_assoc()){
            //retrieve userinfo
            $userinfo = array();
            $userinfo["userid"] = $rows["tg_id"];
            $userinfo["gender"] = $rows["tg_gender"];
            $userinfo["avatar"] = $rows["tg_avatar"];
            $userinfo["email"] = $rows["tg_email"];
            
        }else{
            //user's been deleted
        }
    }else{
        alert_return("Article does not exists.");
    }
}else{
    alert_return("Illegal Operation");
}

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

<title>Articles</title>
</head>
    <body>
    <?php
   //include header
   require ROOT_PATH.'includes/header.inc.php';
   ?>
   
   <div id="article">
      <h2>Article</h2>
      <div id="subject">
          <dl>
            <dd class="name"><?php echo $article_info["username"]?> - <?php echo $userinfo["gender"]?></dd> 
                <dt><img src='<?php echo $userinfo["avatar"]?>' alt="<?php echo $userinfo['avatar']?>" /></dt>
                <dd class="msg"><a href="#" name="msg" title ="<?php echo $userinfo['userid']?>">Send Text</a></dd>
                <dd class="comment">Post Comment</a></dd>
                <dd class="friend"><a href="#" name="addfriend" title = "<?php echo $userinfo['userid']?>" >Add Friend</a></dd>
                <dd class="star"><a href="#" name="sendstar" title = "<?php echo $userinfo['userid']?>" >Send Star</a></dd>
                <dd class="email"><?php echo $userinfo["email"]?></dd>
          </dl>
          <div class="content">
            <div class="publisher">
                <span>1#</span><?php echo $article_info["username"]?> | Published on:  <?php echo $article_info["date"]?>
            </div>
            <h3><?php echo $article_info["title"]?><img src="images/icon<?php echo $article_info["type"]?>.gif" alt="icon" /></h3>
            <div class="detail">
            <?php echo $article_info["content"]?>
            </div>
            <div class="read">
                Read (<?php echo $article_info["readcount"]?>) Comments (<?php echo $article_info["commentcount"]?>)
            </div>
          </div>
          <p class="line"></p>
      </div>
   </div>
   
    <?php
    //include footer 
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
    </body>
</html>