<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 1 Jul 2015
*/
if(!defined('HF')){
    exit('Access Denied');
}

function _setCookies($username, $uniqid){
    setcookie('username',$username, time() + 60*60); //expire in 1 hour
    setcookie('uniqid', $uniqid, time() + 60*60);  //expire in 1 hour
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
    return $str;
}    
function checkLoginPassword ($password, $min_digits){
    if(strlen($password) < $min_digits){
        alert_return("Password must not less than ".$min_digits." characters!");
    }

    return sha1($password);
}    
?>