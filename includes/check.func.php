<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 23 Jun 2015
*/

if(!defined('HF')){
    exit('Access Denied');
}

function checkUniqid($post_uniqid, $session_uniqid){
    if($post_uniqid != $session_uniqid){
        alert_return("Uniqid is invalid!");
    }
    return $post_uniqid;
}

function checkUsername($str){
    //trim the space of input
    $str = trim($str);
    
    //valide in between 5 - 20 characters
    if(strlen($str) < 5 || strlen($str) > 20){
        alert_return("Username ength must be in between 5-20 characters.");
    }
    
    //restrict special characters
    $char_pattern = '/[\/\<\>\'\"\ ]/';
    if(preg_match($char_pattern, $str)){
        alert_return("Username cannot contain special characters");
    }
    
    //restrict sensitive username
    $sen[0] = 'sijie';
    $sen[1] = 'obama';
    $sen[2] = 'zemin';
    
    $sen_string = "";
    foreach ($sen as $value){
        $sen_string .= $value.'\n';
    }
    if(in_array($str, $sen)){
        alert_return("$sen_string"." cannot be used");
    }
    
    return $str;  
}

function checkPassword ($password, $notpass, $min_digits){
    if(strlen($password) < 6){
        alert_return("Password must not less than 6 characters!");
    }
    
    if($_POST["password"] != $_POST["notpassword"]){
        alert_return("Password does not match!");
    }
    return sha1($password);
}

function checkHint($hint, $min_num, $max_num){
    $hint = trim($hint);
    if(strlen($hint) < $min_num || strlen($hint) > $max_num){
        alert_return("Hint must be ".$min_num. "- ".$max_num." characters");
    }
    return $hint;
}

function checkAns($hint, $ans, $min_num, $max_num){
    $ans = trim($ans);
    if(strlen($ans) < $min_num || strlen($ans) > $max_num){
        alert_return("Answer must be ".$min_num. "- ".$max_num." characters");
    }
    
    if($hint == $ans){
        alert_return("Hint and answer must be different!");
    }
    return $ans;
}

function checkGender($str){
    return $str;
}

function checkAva($str){
    return $str;
}

function checkEmail($email, $min, $max){
    
    if(empty($email)){
        return null;
    }else{
        //^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$
        if(!preg_match('/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/', $email)){
           alert_return("Email format is invalid!"); 
        }
    }
    if(strlen($email) < $min || strlen($email) > $max){
        alert_return("Email length must in between 10 - 60 characters.");
    }    
    return $email;
}

function modifyPassword($str, $min){
    if(!empty($str)){
        if(strlen($str) < 6){
            alert_return("Password must not less than 6 characters!");
        }else{
            return null;
        }
    }
    return $str;
}

function checkContent($str){
    if(mb_strlen($str,'utf-8') < 2 || mb_strlen($str,'utf-8') > 200){
        alert_return("Text must between 2 - 200 characters.");
    }
    return $str;
}
?>