<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 31/01/2018
 * Time: 09:54 PM
 */


session_start();

$imageaddress = uniqid();

echo $imageaddress;

//createUser('Password', 'Test3@Gmail.com', '12 Three Road', '01908723', 'Description');
/*$img = '423456789';
$caption = 'First image';
$_SESSION['userID'] = '0000000001';
createAdvert('Red phone','A phone that is red', 'Here', $img, $caption, 'Blue', 250);

$_SESSION['userID'] = '0000000002';
watchAd('000000000000003');
session_unset();
session_destroy();*/

function createUser($password, $email, $address, $mobile, $desc){
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $dbHandle = setUpHandler();
    $dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlQuery = "SELECT count(*) FROM Users";
    echo $sqlQuery . "<br>";

    $executer = $dbHandle->prepare($sqlQuery);
    $executer->execute();
    $number = $executer->fetch();
    $number = sprintf('%010d', ($number[0] + 1));

    $dbHandle = null;
    try {
        $dbHandle = setUpHandler();
        $dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlQuery = "INSERT INTO Users (userID, password, useremail, address, mobile, userdesc) VALUES ('$number', '$hash','$email', '$address', '$mobile', '$desc')";
        echo $sqlQuery . "<br>";

        $dbHandle->exec($sqlQuery);
        $dbHandle = null;
        return true;

    }catch(PDOException $e){
        echo $sqlQuery . "<br>" . $e->getMessage();
    }
    //This function inserts a user record into the database
}

function createAdvert($name,$desc,$loc,$imgaddress,$caption,$colour, $price){
    $dbHandle = setUpHandler();
    $dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlQuery = "SELECT count(*) FROM classifieds";
    echo $sqlQuery . "<br>";

    $executer = $dbHandle->prepare($sqlQuery);
    $executer->execute();
    $number = $executer->fetch();
    $number = sprintf('%015d', ($number[0] + 1));

    $date = date('Y-m-d');
    $dbHandle = null;
    $userID = $_SESSION['userID'];
    try {
        $dbHandle = setUpHandler();
        $dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlQuery = "INSERT INTO classifieds VALUES ('$number', '$name', '$desc', '$loc', '$imgaddress', '$caption','$date','$colour','$userID', '$price')";
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

function watchAd($adid){
    try {
        $userid = $_SESSION['userID'];
        //$adid = $_GET['adid'];
        $dbHandle = setUpHandler();
        $dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlQuery = "INSERT INTO Watchlist VALUES ('$adid', '$userid')";
        echo $sqlQuery . "<br>";

        $dbHandle->exec($sqlQuery);
        $dbHandle = null;
        return true;

    }catch(PDOException $e){
        echo $sqlQuery . "<br>" . $e->getMessage();
    }
}