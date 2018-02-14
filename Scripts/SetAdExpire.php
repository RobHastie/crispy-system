<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 14/02/2018
 * Time: 08:39 PM
 */
require_once 'CommonFunctions.php';
session_start();
sessionInitialize();
if($_SESSION['Admin'] != true or !isset($_POST['expire'])){
    exit;
}

$dbHandle = setUpHandler();

$prep = $dbHandle->prepare("UPDATE expire SET AdvertDuration = :dur");
$prep->bindValue(':dur', $_POST['expire']);
$prep->execute();

header("Location: ../Admin.php");