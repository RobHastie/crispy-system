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

try {
    $userid = $_SESSION['userID'];
    $adid = $_GET['adid'];
    $dbHandle = setUpHandler();
    $dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlQuery = "INSERT INTO Watchlist VALUES ('$userid', '$adid')";
    echo $sqlQuery . "<br>";

    $dbHandle->exec($sqlQuery);
    $dbHandle = null;
    return true;

}catch(PDOException $e){
    echo $sqlQuery . "<br>" . $e->getMessage();
}