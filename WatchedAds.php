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
}
require_once 'Views/TopBar.phtml';
require_once 'Views/WatchedAds.html';
loggedinas();

require_once 'Scripts/ListAds.php';
$list = searchWatchedAds();
foreach ($list as &$ad){
    $ad->printThumbnail();
}