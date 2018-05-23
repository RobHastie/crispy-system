<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 25/04/2018
 * Time: 09:58 AM
 */

// This is the server-side script.
// Set the content type.
// Send the data back.
require_once 'Scripts/SearchFunction.php';
$array = searchAds();
$jason = json_encode($array);
echo $jason;
?>