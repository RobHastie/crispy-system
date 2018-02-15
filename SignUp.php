<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 13/02/2018
 * Time: 07:53 PM
 */

require_once 'Scripts/CommonFunctions.php';
session_start();
sessionInitialize();
if($_SESSION['loggedin'] == true){
//Logged in users don't need to make new accounts. And don't have the button to
    //Access this page. So just redirect them away.
    header("Location: index.php");
    exit;
    //We exit after redirects to prevent any extra code executing
}


require_once 'Views/TopBar.phtml';
require_once 'Views/SignUp.phtml';