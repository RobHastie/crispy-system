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
    exit;
}

require_once 'Views/TopBar.phtml';
require_once 'Views/Admin.phtml';
