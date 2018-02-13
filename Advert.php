<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 12/02/18
 * Time: 13:13
 */
require_once 'Scripts/CommonFunctions.php';
session_start();
sessionInitialize();

if(!isset($_GET['Advert'])){
    header("Location: index.php");
}
require_once 'Scripts/AdvertFull.php';
$adid = $_GET['Advert'];
$advert = new AdvertFull($adid);

$dbHandle = setUpHandler();
$userid = $_SESSION['userid'];

//This section of code is to check if the logged in user is already wtahcing the ad.
$prep = $dbHandle->prepare("SELECT COUNT(*) FROM Watchlist WHERE adID = :adid and userID = '$userid'");
$prep->bindParam(':adid', $adid);
$prep->execute();
$fetch = $prep->fetch();
$watched = 0;
if($fetch[0] == 1){
    $watched = 1;
}

require_once 'Views/TopBar.phtml';
require_once 'Views/Advert.phtml';
