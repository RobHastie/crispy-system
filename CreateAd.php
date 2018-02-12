<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 07/02/18
 * Time: 10:38
 */

require_once 'Scripts/CommonFunctions.php';
session_start();
sessionInitialize();

if($_SESSION['loggedin'] != true OR !isset($_SESSION['userid'])){
    header("Location: index.php");
}
require_once 'Views/TopBar.phtml';
require_once 'Views/CreateAd.phtml';

if($_SESSION['redirect'] == 1){
    $_SESSION['redirect'] = 0;
    echo '<script type="text/javascript">',
    'window.alert("Please fill in every field in the form");',
    '</script>';
}
if($_SESSION['redirect'] == 2){
    $_SESSION['redirect'] = 0;
    echo '<script type="text/javascript">',
    'window.alert("The uploaded file must be a jpg, jpeg, png or gif file below 500KB");',
    '</script>';
}