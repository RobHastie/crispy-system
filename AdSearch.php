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

require_once 'Views/TopBar.phtml';
require_once 'Views/adPage.phtml';

//Here, we need to get a list of ads to fill the page.
    $sqlQuery = "SELECT adname, addesc, image1address, price, adID FROM classifieds";
    //This sets up the base query, which just grabs every ad.
    $and = 0;
    //This variable keeps track of if something has been added to the where clause.
    $where = " WHERE ";
    //This is the string we add to to construct a WHERE clause
    if($_GET['adname'] != ""){
        //GET variables are always set, so isset won't work. We test for the default value of the variables
        $name = '%' . $_GET['adname'] . '%';
        //The percent signs are multi-character wildcards
        $where = $where . "adname LIKE ?";
        //So any name containing the string will pass the check
        $and = 1;
        //This lets the system know that something has been added, so any other tests that are added to the
        //Where clause can have an AND placed before them.
    }
    if($_GET['minprice'] != ""){
        if($and == 1){
            $where = $where . " AND ";
            //If something has been added to the where clause, these checks put in AND's to fit it all together.
        }
        $min = $_GET['minprice'];
        $where = $where . "price >= ?";
        //Test that price is above the minimum
        $and = 1;
    }
    if($_GET['maxprice'] != ""){
        if($and == 1){
            $where = $where . " AND ";
        }
        $max = $_GET['maxprice'];
        $where = $where . "price <= ?";
        //Test that price is below the maximum
        $and = 1;
    }
    if($_GET['location'] != ""){
        if($and == 1){
            $where = $where . " AND ";
        }
        $loc = $_GET['location'];
        $where = $where . "Location = ?";
        //Match location
        $and = 1;
    }
    if($_GET['colours'] != ""){
        if ($and == 1) {
            $where = $where . ' AND ';
        }
        $colours = $_GET['colours'];
        $clauses = "(";
        $or = 0;
        //Here we place the OR' for colours in brackets, so they count as one test for the AND's
        foreach($colours as &$colour) {
            //For each of the colours selected
            if ($or == 1) {
                $clauses = $clauses . ' OR ';
                //If a colour has been added here already, put in an OR
            }
            $clauses = $clauses . "colour = ?";
            //Match the colour
            $or = 1;
        }
        $clauses = $clauses . ")";
        //Close the bracket
        $and = 1;
        $where = $where . $clauses;
    }

    if($and == 1){
        $sqlQuery = $sqlQuery . $where;
        //If anything was added, we add the WHERE clause onto the query
    }
    $sort = " ORDER BY ";
    //prep the sorting string to reduce repetition.
    switch($_GET['sort']){
        //Base the sorting off of the input
        case "AgeD":
            $sort = $sort . "datecreated ASC";
            break;
        case "PriceA":
            $sort = $sort . "price ASC";
            break;
        case "PriceD":
            $sort = $sort . "price DESC";
            break;
        case "Name":
            $sort = $sort . "adname";
            break;
        default:
            //Age ascending is the default, so we don't need to check for AgeA
            $sort = $sort . "datecreated DESC";
            break;
    }
    $sqlQuery = $sqlQuery . $sort;
    //Add the ORDER BY to the query.
    //echo $sqlQuery;

try {
//We set up a try-catch to deal with any errors.
    $dbHandle = setUpHandler();
    $dbHandle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $fetch = $dbHandle->prepare($sqlQuery);
    $params = 1;
    if(isset($name)) {
        //We set the values in the if checks that add the parameters to the query.
        //So by checking if those values are set, we can see if the parameters are in the query.
        $fetch->bindParam($params, $name);
        $params++;
        //Since the parameters are positional, we need a common variable to keep track of the position.
        //Each time we bind a parameter, we increment that variable.
    }
    if(isset($min)) {
        $fetch->bindParam($params, $min);
        $params++;
    }
    if(isset($max)) {
        $fetch->bindParam($params, $max);
        $params++;
    }
    if(isset($loc)) {
        $fetch->bindParam($params, $loc);
        $params++;
    }
    foreach($colours as &$colour) {
        $fetch->bindParam($params, $colour);
        $params++;
    }
    //named parameters don't work with colour, so they all need to be positional parameters.
    $fetch->execute();
    $loop = 0;
    $list = array();
    //We set up a list to hold the ads we'll fetch
    while($ads = $fetch->fetch()){
        $ad = new AdThumbnail($ads[0],$ads[1],$ads[2],$ads[3],$ads[4]);
        $list[$loop] = $ad;
        $loop++;
    }
    foreach ($list as &$ad){
        $ad->printThumbnail();
    }
}catch(PDOException $e){
    echo $sqlQuery . "<br>" . $e->getMessage();
}