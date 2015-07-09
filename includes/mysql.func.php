<?php
/**
* TestGuest Version1.0
* ================================================
* Copy 2015 Sijie HAO
* ================================================
* Author: Sijie
* Date: 29 Jun 2015
*/
if(!defined('HF')){
    exit('Access Denied');
}


     
function _connect(){
    //connnect to db$conn;
    global $conn;
    $conn = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);
    if(mysqli_connect_errno()){
        printf("Connection failed: %s\n", mysqli_connect_error());
        exit();
    }
}

?>