<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 14/02/2018
 * Time: 07:46 PM
 */
require_once 'CommonFunctions.php';
session_start();
sessionInitialize();

if($_SESSION['Admin'] != true){
    exit;
}
$dbHandle = setUpHandler();

$prep = $dbHandle->prepare("SELECT * FROM expire");
//The lifetime of ads is stored as the only value in this table, to make it easy to edit.
$prep->execute();
$fetch = $prep->fetch();
//Store the result of the query so we can reuse prep and dbhandle
$dbHandle = null;
try {
    $dbHandle = setUpHandler();

    $prep = $dbHandle->prepare("DELETE FROM classifieds WHERE TIMESTAMPDIFF(DAY,datecreated,CURDATE()) >= :dur");
    //If the difference between an ads date of creation and the current date is greater than :dur days
    //With :dur being the number we obtained in the first query, then delete that ad.
    $prep->bindValue(':dur', $fetch[0]);
    //Fetch[0] is the one value from the previous query.
    $prep->execute();
}catch(PDOException $e){
    echo $e->getMessage();
}
header("Location: ../index.php");