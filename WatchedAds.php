<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 05/02/18
 * Time: 15:56
 */

require_once 'Scripts/CommonFunctions.php';
session_start();
sessionInitialize();

if(!$_SESSION['loggedin'] == true){
    header("Location: index.php");
}
require_once 'TopBar.html';
require_once 'Views/WatchedAds.html';
echo '<script type="text/javascript">',
'document.getElementById("loginform").style.display = "none";',
'document.getElementById("lga").style.display = "inline-block";',
    'document.getElementById("lgat").innerHTML = "Logged in as: '. $_SESSION['Email'] . '";',
'</script>';

