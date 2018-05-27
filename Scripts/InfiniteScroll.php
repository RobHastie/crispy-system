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
require_once 'SearchFunction.php';
$length = 30;
$scroll = $_GET['scroll'] * $length;
$limit = 39 + $scroll*$length;
//This is an easy but somewhat inefficient way of grabbing less results.
$array = searchAds($limit);
$arrayTrimmed = array_slice($array, $scroll, $length);
//Cut the array we've got down to only what we need.
$jason = json_encode($arrayTrimmed);
echo $jason;
?>