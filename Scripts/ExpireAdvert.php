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
$prep->execute();
$fetch = $prep->fetch();
$dbHandle = null;
echo "test " . $fetch[0] . "<br>";
try {
    $dbHandle = setUpHandler();

    $prep = $dbHandle->prepare("DELETE FROM classifieds WHERE TIMESTAMPDIFF(DAY,datecreated,CURDATE()) >= :dur");
    $prep->bindValue(':dur', $fetch[0]);
    $prep->execute();
}catch(PDOException $e){
    echo $e->getMessage();
}
header("Location: ../index.php");