<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 14/02/18
 * Time: 12:26
 */
require_once 'Scripts/CommonFunctions.php';
session_start();
sessionInitialize();
if($_SESSION['Admin'] != true){
    header("Location: index.php");
    exit;
    //If the user is not an admin, redirect and make sure no further code executes.
}

require_once 'Views/TopBar.phtml';
require_once 'Views/Admin.phtml';
