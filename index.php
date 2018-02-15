<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 31/01/2018
 * Time: 04:13 PM
 */
require_once 'Scripts/CommonFunctions.php';
session_start();
sessionInitialize();
require_once 'Views/TopBar.phtml';
require_once 'Views/MainPage.phtml';

