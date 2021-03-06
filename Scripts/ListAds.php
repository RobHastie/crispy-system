<?php
/**
 * Created by PhpStorm.
 * User: stb216
 * Date: 05/02/18
 * Time: 16:23
 */
require_once 'CommonFunctions.php';
class AdThumbnail{
    public $adName;
    public $image;
    public $description;
    public $price;
    public $adid;

    function __construct($name,$desc,$img, $price, $adid){
        //The constructor fills the objects variables
        $this->adName = $name;
        $this->description = $desc;
        $this->image = $img;
        $this->price = $price;
        $this->adid = $adid;
    }

    public function printThumbnail(){
        //Each AdThumbnail prints it's own html code. That shows some of it's details and
        //Has a link to the page which can display the full advert.
        echo '<div class="col-md-6 col-lg-4 linkbox"><a href="../Advert.php?Advert=' . $this->adid . '"><div class="SmallAd">',
        '<div class="adSmall">',
          '<div class="imageWrap"><img src="../images/' . $this->image . '" onerror="this.onerror=null;this.src=\'../images/default.png\'"></div>',
            '<h1>' . $this->adName. '</h1>',
            '<p>' . $this->description .'</p>',
            '<p>Price: £' . $this->price . '</p>',
        '</div>',
        '</div></a></div>';
    }
}
function searchWatchedAds(){
    try {
        $list = array();
        if(isset($_SESSION['userid'])) {
            $userid = $_SESSION['userid'];
        }else{
            return false;
        }
        $dbHandle = setUpHandler();
        $sqlQuery = "SELECT * FROM Watchlist WHERE userID = '$userid'";
        //User id is not user-supplied, so no parameters are needed.

        $fetch = $dbHandle->prepare($sqlQuery);
        $fetch->execute();
        $loop = 0;
        while($ads = $fetch->fetch()){
            $dbHandle2 = setUpHandler();
            $dbHandle2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sqlQuery = "SELECT adname, addesc, image1address, price FROM classifieds WHERE adID = '$ads[0]'";
            //For each ad we retrieved before, we get the information we need for it's thumbnail.

            $fetch2 = $dbHandle2->prepare($sqlQuery);
            $fetch2->execute();
            $adDetails = $fetch2->fetch();
            $ad = new AdThumbnail($adDetails[0],$adDetails[1],$adDetails[2],$adDetails[3], $ads[0]);
            //Load the data into small objects to be conveniently returned.
            $list[$loop] = $ad;
            //Load the objects into an array to easily return and be looped through.
            $loop++;
        }
        return $list;
    }catch(PDOException $e){
        echo $sqlQuery . "<br>" . $e->getMessage();
    }
    return false;
}