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
$array = searchAds();
if($array != false) {
    $length = 30;
    $scroll = $_GET['scroll'] * $length;
    $arrayTrimmed = array_slice($array, $scroll, $length);
}else{
    $arrayTrimmed = ["Test", "Testing"];
}
$jason = json_encode($arrayTrimmed);
echo $jason;
?>