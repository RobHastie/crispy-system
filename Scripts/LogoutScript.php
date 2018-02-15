<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 01/02/18
 * Time: 15:09
 */
session_start();
if($_SESSION['loggedin'] == true) {
//Making the session only reset when the user is logged in prevents this script
//From being used to reset the counter for spam login attempts.
//(Though that functionality isn't added yet)
    session_unset();
    session_destroy();
}
header("Location: ../index.php");