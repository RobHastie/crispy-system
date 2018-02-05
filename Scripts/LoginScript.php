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
    if(isset($_POST['Password'])){
        $password = $_POST['Password'];
        //Check if password was set.
        if(validateLogin($email, $password)){
            //Check if the email is in the database, and that the password matches.
            echo 'Success';
            $_SESSION['loggedin'] = true;
            $_SESSION['Email'] = $email;
            //Set the session variables so the site knows who is logged in.
            if(checkAdmin($email)){
                $_SESSION['Admin'] = true;
            }else{
                $_SESSION['Admin'] = false;
            }
            //If they are an admin, set that too.
            header("Location: ../index.php");
            //Redirect back to the main page.
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
    $sqlQuery = "SELECT password, userID FROM Users WHERE useremail = '$email'";
    echo $sqlQuery . "<br>";
    $data = $dbHandler->prepare($sqlQuery);
    $data->execute();
    $pwhash = $data->fetch();
    if (password_verify($password, $pwhash[0])) {
        //Check the password versus the stored encrypted password for the chosen email.
        $_SESSION['userID'] = $pwhash[1];
        return true;
    } else {
        return false;
    }
}
function checkAdmin($email){
    $dbHandler = setUpHandler();
    $sqlQuery = "SELECT password FROM Users WHERE useremail = '$email'";
    echo $sqlQuery . "<br>";
    $data = $dbHandler->prepare($sqlQuery);
    $data->execute();
    $priv = $data->fetch();
    if($priv[0] == 1){
        //The admin value is stored as a bit, 1 is true, 0 is false
        echo '<br>', 'Target Email is for an admin', '<br>';
        return true;
    }
    echo '<br>', 'Target Email is not for an admin', '<br>';
    return false;
}