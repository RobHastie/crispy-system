<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 01/02/18
 * Time: 14:16
 */

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