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
require_once 'adPage.html';

if($_SESSION['loggedin'] == true){
    echo '<script type="text/javascript">',
    'document.getElementById("loginform").style.display = "none";',
    'document.getElementById("lga").style.display = "inline-block";',
    'document.getElementById("lgat").innerHTML = "Logged in as: '. $_SESSION['Email'] . '";',
    '</script>';
}