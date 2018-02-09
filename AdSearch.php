<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 09/02/18
 * Time: 12:36
 */
require_once 'Scripts/CommonFunctions.php';
require_once 'Scripts/ListAds.php';
session_start();
sessionInitialize();

require_once 'TopBar.html';
require_once 'Views/adPage.html';
loggedinas();

//Here, we need to get a list of ads to fill the page.
try {
//We set up a try-catch to deal with any errors.
    $list = array();
    //We set up a list to hold the ads we'll fetch
    $dbHandle = setUpHandler();
    $dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sqlQuery = "SELECT adname, addesc, image1address, price FROM classifieds";
    //This sets up the base query, which just grabs every ad.
    $and = 0;
    //This variable keeps track of if something has been added to the where clause.
    $where = " WHERE ";
    //This is the string we add to to construct a WHERE clause
    if($_GET['adname'] != ""){
        $name = '%' . $_GET['adname'] . '%';
        //The percent signs are multi-character wildcards
        $where = $where . "adname LIKE '$name'";
        //So any name containing the string will pass the check
        $and = 1;
    }
    if($_GET['minprice'] != ""){
        if($and == 1){
            $where = $where . " AND ";
        }
        $min = $_GET['minprice'];
        $where = $where . "price >= '$min'";
        $and = 1;
    }
    if($_GET['maxprice'] != ""){
        if($and == 1){
            $where = $where . " AND ";
        }
        $max = $_GET['maxprice'];
        $where = $where . "price <= '$max'";
        $and = 1;
    }
    if($_GET['location'] != ""){
        if($and == 1){
            $where = $where . " AND ";
        }
        $loc = $_GET['location'];
        $where = $where . "Location = '$loc'";
        $and = 1;
    }
    if($_GET['maxprice'] != ""){
        if($and == 1){
            $where = $where . " AND ";
        }
        $max = $_GET['maxprice'];
        $where = $where . "price <= '$max'";
        $and = 1;
    }
    if($_GET['colours'] != ""){
        if ($and == 1) {
            $where = $where . ' AND ';
        }
        $colours = $_GET['colours'];
        $clauses = "(";
        $or = 0;
        foreach($colours as &$colour) {
            if ($or == 1) {
                $clauses = $clauses . ' OR ';
            }
            $clauses = $clauses . "colour = '$colour'";
            $or = 1;
        }
        $clauses = $clauses . ")";
        $and = 1;
        $where = $where . $clauses;
    }

    if($and == 1){
        $sqlQuery = $sqlQuery . $where;
    }
    //echo $sqlQuery;
    $fetch = $dbHandle->prepare($sqlQuery);
    $fetch->execute();
    $loop = 0;
    while($ads = $fetch->fetch()){
        $ad = new AdThumbnail($ads[0],$ads[1],$ads[2],$ads[3]);
        $list[$loop] = $ad;
        $loop++;
    }
    foreach ($list as &$ad){
        $ad->printThumbnail();
    }
}catch(PDOException $e){
    echo $sqlQuery . "<br>" . $e->getMessage();
}