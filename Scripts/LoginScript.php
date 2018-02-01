<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 31/01/2018
 * Time: 09:41 PM
 */
session_start();
sessionInitialize();
require_once 'CommonFunctions.php';
if(isset($_POST['Email'])){
    $email = $_POST['Email'];
    echo $email . '<br>';
    if(isset($_POST['Password'])){
        $password = $_POST['Password'];
        if(validateLogin($email, $password)){
            echo 'Success';
            $_SESSION['loggedin'] = true;

        }else{
            echo 'Invalid Login';
        }
    }else{
        echo 'No Password';
    }
}else{
    echo 'No Email';
}

function validateLogin($email, $password){
    $dbHandler = setUpHandler();
    $sqlQuery = "SELECT password FROM Users WHERE useremail = '$email'";
    echo $sqlQuery . "<br>";
    $data = $dbHandler->prepare($sqlQuery);
    $data->execute();
    $pwhash = $data->fetch();
    if (password_verify($password, $pwhash[0])) {
        return true;
    } else {
        return false;
    }
}