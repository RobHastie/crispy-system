<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 05/02/18
 * Time: 15:56
 */

require_once 'Scripts/CommonFunctions.php';
session_start();
sessionInitialize();

if(!$_SESSION['loggedin'] == true OR !isset($_SESSION['userid'])){
    header("Location: index.php");
    exit;
    //We exit after redirects to prevent any extra code executing
}
require_once 'Views/TopBar.phtml';
require_once 'Views/WatchedAds.html';

require_once 'Scripts/ListAds.php';
$list = searchWatchedAds();
//Set a variable to the array that searchWatchedAds() returns.
foreach ($list as &$ad){
    //For each ad in the list array.
    $ad->printThumbnail();
    //Each advert has the html for it's thumbnail, so have them echo it.
}