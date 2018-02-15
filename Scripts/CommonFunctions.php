<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 01/02/18
 * Time: 14:16
 */
//These two functions are called on most pages, so it's good to have them together here to easily require.
function setUpHandler()
{
    $host = 'helios.csesalford.com';
    $dbName = 'stb216';
    $user = 'stb216';
    $pass = 'Salford-17';
    $dbHandler = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
    $dbHandler->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //This enables parameterisation for the queries
    $dbHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //This enables error handling for exceptions.
    return $dbHandler;
    //Set up the PHP Database Object according to the values at the top, then return the PDO
    //This way, the Database Details are only in one place and are easy to change.
}

function sessionInitialize(){
    if(!isset($_SESSION['loggedin']))
    {
        $_SESSION['loggedin'] = false;
        $_SESSION['Admin'] = false;
    }
    //If the session value loggedin is not set, set it and Admin to false.
    //This helps maintain the things on the site that depend on their values.
    //And to be certain no errors arise, though none should.
}