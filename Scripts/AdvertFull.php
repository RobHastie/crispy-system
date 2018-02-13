<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 12/02/18
 * Time: 13:18
 */
require_once 'CommonFunctions.php';
class AdvertFull{
    public $adName;
    public $image;
    public $description;
    public $price;
    public $location;
    public $caption;
    public $date;
    public $colour;
    public $adID;
    public $posterEmail;
    public $posterPhone;
    //All of the data an Advert object needs

    function __construct($id){
        $this->adID = $id;
        //We're getting ad from id, so we can set the variable immediately.
        $dbHandle = setUpHandler();
        $dbHandle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $fetch = $dbHandle->prepare("SELECT * FROM classifieds WHERE adid = :id");
        $fetch->bindParam(':id' , $id);
        //Ad id is taken from theuser end, so we bind it as a parameter to prevent injection.
        $fetch->execute();
        $data = $fetch->fetch();

        $this->adName = $data[1];
        $this->description = $data[2];
        $this->location = $data[3];
        $this->image = $data[4];
        $this->caption = $data[5];
        $this->date = $data[6];
        $this->colour = $data[7];
        $this->price = $data[9];
        //We set a bunch of variables to the data we just fetched

        $sqlQuery = "SELECT useremail, mobile FROM Users WHERE userID = '$data[8]'";
        //This query is entirely things we set up in the php, so it's fine.
        $fetch = $dbHandle->prepare($sqlQuery);
        $fetch->execute();
        $data = $fetch->fetch();
        $this->posterEmail = $data[0];
        $this->posterPhone = $data[1];
        //The last two variables cn't be obtained from the ad's entry so we query the users table.
    }
}