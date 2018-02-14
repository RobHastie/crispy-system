<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 14/02/18
 * Time: 12:37
 */
require_once 'CommonFunctions.php';
session_start();
sessionInitialize();
try {
    $dbHandle = setUpHandler();
    $prep = $dbHandle->prepare("UPDATE Users SET Admin = 1 WHERE useremail = :email");
    //Since PDO::ATTR_EMULATE_PREPARES is set to false, php will insert the 1 in the query as a bit.
    $prep->bindParam(':email', $_POST['email']);
    $prep->execute();

    $dbHandle = null;

    header("Location: ../Admin.php");
}catch(PDOException $e){
    echo $e->getMessage();
}