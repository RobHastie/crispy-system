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
$col = $_POST['colour'];
if($col != "Red" and $col != "Blue" and $col != "Green" and $col != "Black" and $col != "White"){
    //The variables that are sent towards us have to be checked to make sure they are what they should be.
    //Someone could easily send other colours, which is meaningless but we don't want it to happen.
    header("Location: ../CreateAd.php");
    exit;
}
if(!is_numeric($_POST['price'])){
    //Price has to be a number. So we make sure it is.
    header("Location: ../CreateAd.php");
    exit;
}


$imageName = uniqid();

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
    //Check if the file is anything but the allowed image types, and if not, stop and redirect.
}

$check = getimagesize($_FILES['picture']);
if($_FILES['picture']['size'] > 500000){
    //Make sure the file is below the maximum size. If not, redirect.
    $_SESSION['redirect'] = 2;
    header("Location: ../CreateAd.php");
    exit;
}
$imageAddress = "../images/" . $imageName;
//Add the path to the images folder to the front of the image name. To correctly place it.

if(createAdvert($_POST['adname'],$_POST['addesc'],$_POST['location'],$imageName,$_POST['caption'],$_POST['colour'],$_POST['price'])){
    //If the createAdvert has no errors
    move_uploaded_file($_FILES['picture']['tmp_name'], $imageAddress);
    //Place the picture into the images folder so it can be searched.
}
function createAdvert($name,$desc,$loc,$imgaddress,$caption,$colour, $price){
    /*$dbHandle = setUpHandler();
    $dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlQuery = "SELECT count(*) FROM classifieds";
    $executer = $dbHandle->prepare($sqlQuery);
    $executer->execute();
    $number = $executer->fetch();
    $number = sprintf('%015d', ($number[0] + 1));
    $dbHandle = null;*/
    $number = uniqid();
    //This is a convenient way to make a unique ID, so we might as well use it again.


    $date = date('Y-m-d');
    //This function gives us a date stamp. And is formatted to the date format MySQL uses
    $userID = $_SESSION['userid'];



    try {
        $dbHandle = setUpHandler();
        $dbHandle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$sqlQuery = "INSERT INTO classifieds VALUES ('$number', '$name', '$desc', '$loc', '$imgaddress', '$caption','$date','$colour','$userID', '$price')";
        //Now we just insert the data into the database.
        $prep = $dbHandle->prepare("INSERT INTO classifieds VALUES ('$number', :name, :desc, :loc, '$imgaddress', :caption,'$date','$colour','$userID', '$price')");
        $prep->bindParam(':desc', $desc);
        $prep->bindParam(':name', $name);
        $prep->bindParam(':loc', $loc);
        $prep->bindParam(':caption', $caption);
        $prep->execute();

        $dbHandle = null;
        return true;

    }catch(PDOException $e){
        echo $e->getMessage();
    }
    //This function inserts a user record into the database
    return false;
}