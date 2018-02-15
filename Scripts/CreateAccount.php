<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 14/02/18
 * Time: 10:57
 */
session_start();
if($_POST['captcha'] != $_SESSION['Captcha']){
    //If the captcha was not correctly solved.
    header("Location: ../SignUp.php");
    exit;
    //This is placed as early as possible to reduce the strain of repeated attempts.
}
require_once 'CommonFunctions.php';
if(!isset($_POST['email']) or !isset($_POST['password']) or !isset($_POST['captcha']) or !isset($_POST['phone']) or !isset($_POST['address']) or !isset($_POST['userdesc'])){
    header("Location: ../SignUp.php");
    exit;
    //If any part of the form was not filled in, return ot the form page.
}

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    //This checks if email is valid
    header("Location: ../SignUp.php");
    exit;
}
//I'd validate phone number, but there are more ways to type them than there are phone numbers
try {
    $number = uniqid();
    //Generate a unique id number
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    //Here we generate a hashkey for the password.
    //So even we don't know what the actual password is.

    $dbHandle = setUpHandler();
    //Now we just insert the data into the database.
    $prep = $dbHandle->prepare("INSERT INTO Users VALUES ('$number', '$hash', :email, :loc, :phone, :desc, 0, 0)");
    $prep->bindParam(':desc', $_POST['userdesc']);
    $prep->bindParam(':email', $_POST['email']);
    $prep->bindParam(':loc', $_POST['address']);
    $prep->bindParam(':phone', $_POST['phone']);
    //We bind everything we take from the user as a parameter, as standard.
    $prep->execute();

    $dbHandle = null;
    $_SESSION['loggedin'] = true;
    $_SESSION['Email'] = $_POST['email'];
    $_SESSION['userid'] = $number;
    //Here we set the variables to automatically log in to the newly created account.
    header("Location: ../index.php");

}catch(PDOException $e){
    echo $e->getMessage();
}