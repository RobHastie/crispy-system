<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 12/02/18
 * Time: 13:13
 */
require_once 'Scripts/CommonFunctions.php';
session_start();
sessionInitialize();

if(!isset($_GET['Advert'])){
    header("Location: index.php");
}
require_once 'Scripts/AdvertFull.php';
$advert = new AdvertFull($_GET['Advert']);
require_once 'Views/TopBar.phtml';
require_once 'Views/Advert.phtml';
