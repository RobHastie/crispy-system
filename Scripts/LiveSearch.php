<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 26/05/2018
 * Time: 12:21 AM
 */

require_once 'CommonFunctions.php';
$dbHandle = setUpHandler();
$search = $_GET['search'] . '%';
$sqlQuery = "SELECT DISTINCT adname FROM classifieds WHERE adname LIKE :search LIMIT 5";
//Only grab the first five distinct names in the database.
$fetch = $dbHandle->prepare($sqlQuery);
$fetch->bindParam(':search', $search);

$fetch->execute();
$loop = 0;
$list = array();
//We set up a list to hold the ad names we'll fetch
while($ads = $fetch->fetch()){
    $list[$loop] = $ads[0];
    //Add the name to the list array
    $loop++;
}

$jason = json_encode($list);
echo $jason;
?>