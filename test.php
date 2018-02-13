<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 31/01/2018
 * Time: 09:54 PM
 */


session_start();


//createUser('Password', 'Test3@Gmail.com', '12 Three Road', '01908723', 'Description');


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
        $userid = $_SESSION['userid'];
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