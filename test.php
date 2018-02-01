<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 31/01/2018
 * Time: 09:54 PM
 */


session_start();
echo 'done';
//createUser('0000000003','Password','Test3@Gmail.com','13 Three Road', '07654789014', 'Description');



session_unset();
session_destroy();

function createUser($id, $password, $email, $address, $mobile, $desc){
    $hash = password_hash($password, PASSWORD_DEFAULT);
    try {
        $dbHandle = setUpHandler();
        $dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlQuery = "INSERT INTO Users (userID, password, useremail, address, mobile, userdesc) VALUES ('$id', '$hash','$email', '$address', '$mobile', '$desc')";
        echo $sqlQuery . "<br>";

        $dbHandle->exec($sqlQuery);
        $dbHandle = null;
        return true;

    }catch(PDOException $e){
        echo $sqlQuery . "<br>" . $e->getMessage();
    }
    //This function inserts a user record into the database
}


function setUpHandler()
{
    $host = 'helios.csesalford.com';
    $dbName = 'stb216';
    $user = 'stb216';
    $pass = 'Salford-17';
    $dbHandler = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
    return $dbHandler;
    //Set up the PHP Database Object according to the values at the top, then return the PDO
    //This way, the Database Details are only in one place and are easy to change.
}