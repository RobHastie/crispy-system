<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 31/01/2018
 * Time: 09:41 PM
 */
session_start();

if(isset($_POST['Email'])){
    $email = $_SESSION['Email'];
    echo $email . '<br>';
    if(isset($_POST['Password'])){
        $password = $_POST['Password'];
        if(validateLogin($email, $password)){
            echo 'Success';
        }else{
            echo 'Invalid Login';
        }
    }else{
        echo 'No Password';
    }
}else{
    echo 'No Email';
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

function sessionInitialize(){
    if(!isset($_SESSION['loggedin']))
    {
        $_SESSION['loggedin'] = false;
    }
    //If the session value loggedin is not set, set it to false.
    //This makes it so that the site can maintain knowledge of whether a user has loggedin or not
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