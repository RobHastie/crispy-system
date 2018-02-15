<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 31/01/2018
 * Time: 09:54 PM
 */

require_once 'Scripts/CommonFunctions.php';
$email = "Test@Gmail.com";
try {
    $dbHandle = setUpHandler();
    $prep = $dbHandle->prepare("UPDATE Users SET Admin = 1 WHERE useremail = :email");
    //Since PDO::ATTR_EMULATE_PREPARES is set to false, php will insert the 1 in the query as a bit.
    $prep->bindParam(':email', $email);
    $prep->execute();

    $dbHandle = null;

    header("Location: ../Admin.php");
}catch(PDOException $e){
    echo $e->getMessage();
}