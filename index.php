<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 31/01/2018
 * Time: 04:13 PM
 */
require_once 'Scripts/CommonFunctions.php';
session_start();
sessionInitialize();
require_once 'TopBar.html';
require_once 'Views/MainPage.html';

if($_SESSION['loggedin'] == true){
    loggedinas();
}else{
    echo '<script type="text/javascript">',
    'document.getElementById("lga").style.display = "none";',
    'document.getElementById("loginform").style.display = "inline-block";',
    '</script>';
}