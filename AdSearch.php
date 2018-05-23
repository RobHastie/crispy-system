<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 09/02/18
 * Time: 12:36
 */
require_once 'Scripts/CommonFunctions.php';
require_once 'Scripts/ListAds.php';
require_once 'Scripts/SearchFunction.php';
session_start();
sessionInitialize();

$AdsPerPage = 12;
//An easily changeable variable for the amount of ads on each page of ads

if(!isset($_GET['page']) or $_GET['page'] == ""){
    //If page is unset in any way, we must be on page 1
    $page = 1;
}else{
    $page = $_GET['page'];
    //This is the page we are now on.
}


require_once 'Views/TopBar.phtml';
require_once 'Views/adPage.phtml';

$list = searchAds();
    echo '<div id="adList">';
    //Put a wrapper around the ads.
    $capped = 0;
    for($x = ($page-1)*$AdsPerPage; $x <= $page*$AdsPerPage-1; $x++){
        //Starting from 0, $AdsPerPage, 2*$AdsPerPage, etc
        //Going to $AdsPerPage-1, 2*$AdsPerPage-1, etc
            $list[$x]->printThumbnail();

        if(count($list) == $x+1){
            //If the last entry in the array was reached, stop the loop.
            $capped = 1;
            break;
        }
    }
    echo '</div>';
    /*if(count($list) >= $AdsPerPage){
        //If there are more ads in the list array than fit on the page
        //We require in the buttons to change the page.
        require_once 'Views/PageTurn.phtml';
    }*/