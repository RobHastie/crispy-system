<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 07/02/18
 * Time: 10:25
 */
require_once 'CommonFunctions.php';
session_start();
sessionInitialize();

if(!isset($_FILES['picture']) or !isset($_POST['caption']) or !isset($_POST['adname']) or !isset($_POST['addesc']) or !isset($_POST['location']) or !isset($_POST['price']) or !isset($_POST['colour'])){
    //We need all of the inputs from the form, so make sure they're set, if not, stop and redirect.
    $_SESSION['redirect'] = 1;
    header("Location: ../CreateAd.php");
    exit;
}

echo "Testing. Testing." . "<br>";

$imageName = uniqid();

echo $imageName . "<br>";

$finfo = finfo_open(FILEINFO_MIME);
$fileDetails = finfo_file($finfo, $_FILES['picture']['tmp_name']);
//We can't trust the user with a file upload, and we can't trust them to tell us what
//type of file they've uploaded. So we take a look directly at the file with fileinfo.
//This returns something, hopefully, along the lines of image/png; charset=binary
$extension = explode(" ", $fileDetails);
//This should split that into image/png; and charset=binary
if($extension[0] != "image/png;" && $extension[0] != "image/gif;" && $extension[0] != "image/jpeg;" && $extension[0] != "image/jgg;"){
    $_SESSION['redirect'] = 2;
    header("Location: ../CreateAd.php");
    exit;
    //Check if the file is anything but the llowed image types, and if not, stop and redirect.
}

$check = getimagesize($_FILES['picture']);
if($_FILES['picture']['size'] > 500000){
    //Make sure the file is below the maximum size. If not, redirect.
    $_SESSION['redirect'] = 2;
    header("Location: ../CreateAd.php");
    exit;
}
$imageAddress = "../images/" . $imageName;



if(createAdvert($_POST['adname'],$_POST['addesc'],$_POST['location'],$imageName,$_POST['caption'],$_POST['colour'],$_POST['price'])){
    move_uploaded_file($_FILES['picture']['tmp_name'], $imageAddress);
}else{
    echo "bugger.";
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
    $userID = $_SESSION['userid'];
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
    return false;
}