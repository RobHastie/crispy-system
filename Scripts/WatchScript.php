<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 01/02/18
 * Time: 15:42
 */
require_once 'CommonFunctions.php';
session_start();
sessionInitialize();
if(!isset($_GET['adid']) or !$_SESSION['loggedin'] == true OR !isset($_SESSION['userid'])){
    header("Location: index.php");
}
$adid = $_GET['adid'];
$userid = $_SESSION['userid'];

$dbHandle = setUpHandler();
//This section of code is to check if the logged in user is already wtahcing the ad.
$prep = $dbHandle->prepare("SELECT COUNT(*) FROM Watchlist WHERE adID = :adid and userID = '$userid'");
$prep->bindParam(':adid', $adid);
$prep->execute();
$fetch = $prep->fetch();
$watched = 0;
echo $fetch[0];
if($fetch[0] == 1){
    $watched = 1;
}
$dbHandle = null;
if($watched == 0){
try {
    $dbHandle = setUpHandler();

    $prep = $dbHandle->prepare("SELECT COUNT(*) FROM classifieds WHERE adID = :adid");
    $prep->bindParam(':adid', $adid);
    $prep->execute();
    $fetch = $prep->fetch();
    //We run a query here to make sure that the ad ID we got from the user is legitimate.
    if($fetch[0] != 1){
        echo "Error.";
        exit;
    }

    $sqlQuery = "INSERT INTO Watchlist VALUES ('$adid', '$userid')";
    //userid is a session variable set by us, so it's safe. ad id is confirmed by this point. So it's safe.
    $dbHandle->exec($sqlQuery);
    $dbHandle = null;
    header("Location: ../WatchedAds.php");
}catch(PDOException $e){
    echo $sqlQuery . "<br>" . $e->getMessage();
}}else{
    try {
        $dbHandle = setUpHandler();
        $userid = $_SESSION['userid'];

        $prep = $dbHandle->prepare("SELECT COUNT(*) FROM classifieds WHERE adID = :adid");
        $prep->bindParam(':adid', $adid);
        $prep->execute();
        $fetch = $prep->fetch();
        //We run a query here to make sure that the ad ID we got from the user is legitimate.
        if($fetch[0] != 1){
            echo "Error.";
            exit;
        }

        $sqlQuery = "DELETE FROM Watchlist WHERE adID = '$adid' and userID = '$userid'";
        //userid is a session variable set by us, so it's safe. ad id is confirmed by this point. So it's safe.
        $dbHandle->exec($sqlQuery);
        $dbHandle = null;
        header("Location: ../WatchedAds.php");
    }catch(PDOException $e){
        echo $sqlQuery . "<br>" . $e->getMessage();
    }
}