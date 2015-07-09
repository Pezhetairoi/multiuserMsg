<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 20 Jun 2015
*/
function runtime(){
    $runtime = explode(' ', microtime());
    return $runtime[1] + $runtime[0];
}

/*
 * alert_return() is a popup
 * @access public
 * */
function alert_return($text){
    echo "<script type='text/javascript'>
            alert('".$text."');
            history.back();
        </script>";
    exit();
}

function alert_close($text){
    echo "<script type='text/javascript'>
            alert('".$text."');
            window.close();
        </script>";
    exit();
}

function location($info, $url){
    if(!empty($info)){
        echo "<script type='text/javascript'>
            alert('$info');
            location.href='$url';
        </script>";
    }else{
        header("Location:".$url);
    }
}

/*
 * _code() is a passcode generation function
 * @access public
 * @param int $width: passcode box length
 * @param int $height: passcode box height
 * @param int random_code_num: digits length
 * @param boolean $border_flag: has border or not
 * @return void, a passcode is generated after execution
 * 
 * */
function _code($width, $height, $random_code_num, $border_flag){
    //generate passcode
    //$random_code_num = 4;
    $num = null;
    for($i=0;$i<$random_code_num;$i++){
        $num .= dechex(mt_rand(0, 15));
    }
    $_SESSION['code'] = $num;
    
    
    
    //create a img background of passcode
    //$width = 75;
    //$height = 25;
    $img = imagecreatetruecolor($width, $height);
    
    $white = imagecolorallocate($img, 255, 255, 255);
    
    imagefill($img, 0, 0, $white);
    
    if($border_flag){
        //black border
        $black = imagecolorallocate($img, 0, 0, 0);
        imagerectangle($img, 0, 0, $width-1, $height-1, $black);
    }
    
    //random lines
    for($i=0; $i<6; $i++){
        $random_color = imagecolorallocate($img, mt_rand(0, 255),mt_rand(0, 255), mt_rand(0, 255));
        imageline($img, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $random_color);
    }
    
    //generate flake
    for($i=0; $i<100; $i++){
        $random_color = imagecolorallocate($img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
        imagestring($img, 1, mt_rand(1, $width), mt_rand(1, $height), '*', $random_color);
    }
    
    //output passcode
    for ($i=0;$i<strlen($_SESSION['code']);$i++) {
        $_rnd_color = imagecolorallocate($img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200));
        imagestring($img,5,$i*$width/$random_code_num + mt_rand(1,10),mt_rand(1,$height/2),$_SESSION['code'][$i],$_rnd_color);
    }
    header('Content-Type: image/png');
    
    imagepng($img);
    imagedestroy($img);
    
}

function checkCode($user_code, $gen_code){
    if($user_code != $gen_code){
        alert_return("Invalid passcode!");
    }
}

function sha1_uniqid(){
    return sha1(uniqid(rand(), true));
}

/*
 * prevent access to login page when user already logged in
 */
function login_state(){
    if(isset($_COOKIE["username"])){
        alert_return("You are already signed in.");
    }
}

/*
 * delete cookies
 */
function _deleteCookies(){
    setcookie('username', '', time()-1);
    setcookie('uniqid', '', time()-1);    
    session_destroy();
    location(null, 'index.php');
}


/*
 * 1st param retrieves total number of entries, 
 * 2nd param specifies the number of entries displayed on page
 * display items on each page
 */
function page_param($sql, $size, $conn){
    
    //retrive all variables so that they can be access externally
    global $page_start, $pagesize, $current_page , $page_total, $total, $conn;
    
    //page division
    if(isset($_GET["page"])){
        $current_page = $_GET["page"];  //current page
        if(empty($_GET["page"]) || $current_page < 0 || !is_numeric($current_page)){
            $current_page = 1;
        }else{
            $current_page = intval($current_page);
        }
    }else{
        $current_page = 1;
    }
    
    $pagesize = $size;
    
    $result1 = $conn->query($sql) or die(mysqli_error());
    $total = $result1->num_rows;
    
    if($total == 0){
        $page_total = 1;
    }else{
        $page_total = ceil($total / $pagesize);
    }
    if($current_page > $page_total){
        $current_page = $page_total;
    }
    
    $page_start = ($current_page - 1) * $pagesize;  //the index of the first entry display on each pages
    
}

/*
 * Page divide 
 * display page bullets 
 */
function page($type){
    
    global $current_page, $page_total, $total;
    //1 - num
    if($type == 1){
       echo '<div id="page_num">';
       echo '<ul>';
       for($i=0; $i<$page_total; $i++){
            if($current_page == ($i+1)){
                echo '<li><a href="'.SCRIPT.'.php?page='.($i+1).'" class="selected" >'.($i+1).'</a></li>';
            }else{
                echo '<li><a href="'.SCRIPT.'.php?page='.($i+1).'">'.($i+1).'</a></li>';
            }
       }              
       echo '</ul>';
       echo '</div>';
    }else if($type == 2){        //2 - text
        
       echo '<div id="page_text">';
       echo '<ul>';
       echo '<li>Page '.$current_page.'/'.$page_total.' | </li>';
        echo '<li><strong>'.$total.'</strong> Friends | </li>';

            if($current_page == 1){
                echo '<li>First Page | </li>';
                echo '<li>Previous | </li>';
            }else{
                echo '<li><a href="'.SCRIPT.'.php">First Page</a> | </li>';
                echo '<li><a href="'.SCRIPT.'.php?page='.($current_page-1).'">Previous</a> | </li>';
            }
            
            if($current_page == $page_total){
                echo '<li>Last Page | </li>';
                echo '<li>Next | </li>';
            }else{
                echo '<li><a href="'.SCRIPT.'.php?page='.($current_page+1).'">Next</a> | </li>';
                echo '<li><a href="'.SCRIPT.'.php?page='.$page_total.'">Last Page</a> | </li>';           
            }

        echo '</ul>';
        echo '</div>';
    }
}

/*
 * 
 */
function matchUniqid($db_uniqid, $cookie_uniqid){
    if($db_uniqid != $cookie_uniqid){
        alert_return("Uniqid exception found.");
    }
}

/*
 * Filter html making use of htmlspecialchars()
 */
function htmlFilter($str){
    if(is_array($str)){
        foreach ($str as $key => $value){
            $str[$key] = htmlspecialchars($value);
        }
    }else{
        $str = htmlspecialchars($str);
    }
    return $str;
}

/*
 * only display the first 20 characters if the content is larger than 20
 * */
function content_length($str){
    if(mb_strlen($str, 'utf-8') > 20){
        $str = mb_substr($str, 0, 20, 'utf-8').'...';
    }
    return $str;
}
?>
