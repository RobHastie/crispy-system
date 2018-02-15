<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 31/01/2018
 * Time: 09:41 PM
 */
require_once 'CommonFunctions.php';
session_start();
sessionInitialize();
if(isset($_POST['Email'])){
    $email = $_POST['Email'];
    //Check if email was set. Then put it in a simpler variable.
    echo $email . '<br>';
    if(isset($_POST['Password'])) {
        $password = $_POST['Password'];
        //Check if password was set.
        if (validateLogin($email, $password)) {
            //Check if the email is in the database, and that the password matches.
            echo 'Success';
            $_SESSION['loggedin'] = true;
            $_SESSION['Email'] = $email;
            //Set the session variables so the site knows who is logged in.
            $_SESSION['Admin'] = checkAdmin($email);
            //If they are an admin, set that too.
            //The function returns true or false, so we simply make the GET value
            //Equal to the function.
            header("Location: ../index.php");
            //Redirect back to the main page.
        } else {
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
    $data = $dbHandler->prepare("SELECT password, userID FROM Users WHERE useremail = :email");
    $data->bindParam(':email',$email);
    //We get user id from the user, so we parameterise it.
    $data->execute();
    $pwhash = $data->fetch();
    if (password_verify($password, $pwhash[0])) {
        //Check the password versus the stored hashed password for the chosen email.
        $_SESSION['userid'] = $pwhash[1];
        //Set the user ID to what we just pulled out for convenient use.
        return true;
    } else {
        return false;
    }
}
function checkAdmin($email){
    $dbHandler = setUpHandler();
    $data = $dbHandler->prepare("SELECT Admin FROM Users WHERE useremail = :email");
    $data->bindParam(':email',$email);
    $data->execute();
    $priv = $data->fetch();
    if($priv[0] == 1){
        //The admin value is stored as a bit, 1 is true, 0 is false
        return true;
    }
    return false;
}