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

try {
    $dbHandle = setUpHandler();
    $dbHandle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //This enables parameterisation for the queries
    $dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //This enables error handling for exceptions.
    $userid = $_SESSION['userid'];
    $adid = $_GET['adid'];

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
    header("Location: WatchedAds.php");
}catch(PDOException $e){
    echo $sqlQuery . "<br>" . $e->getMessage();
}