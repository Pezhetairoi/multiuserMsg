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

//close db conn
mysqli_close($conn);
?>

<div id="footer">
    <p>Page Loaded: <?php echo runtime() - START_TIME?></p>
    <p>2013 © Sijie Hao. All Rights Reserved.</p>
</div>