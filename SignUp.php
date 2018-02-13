<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 13/02/2018
 * Time: 07:53 PM
 */

require_once 'Scripts/CommonFunctions.php';
session_start();
sessionInitialize();

require_once 'Views/TopBar.phtml';
require_once 'Views/SignUp.phtml';