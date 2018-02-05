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

    function __construct($name,$desc,$img){
        $this->adName = $name;
        $this->description = $desc;
        $this->image = $img;
    }

    public function printThumbnail(){
        echo '<div class="col-md-6 col-lg-4">',
        '<div class="adSmall">',
          '<div class="imageWrap"><img src="../images/' . $this->image . '"></div>',
            '<h1>' . $this->adName. '</h1>',
            '<p>' . $this->description .'</p>',
        '</div>',
        '</div>';
    }
}
function searchWatchedAds(){
    try {
        $list = array();
        if(isset($_SESSION['userID'])) {
            $userid = $_SESSION['userID'];
        }else{
            return false;
        }
        $dbHandle = setUpHandler();
        $dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlQuery = "SELECT * FROM Watchlist WHERE userID = '$userid'";

        $fetch = $dbHandle->prepare($sqlQuery);
        $fetch->execute();
        $loop = 0;
        while($ads = $fetch->fetch()){
            $dbHandle2 = setUpHandler();
            $dbHandle2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sqlQuery = "SELECT adname, addesc, image1address FROM classifieds WHERE adID = '$ads[0]'";

            $fetch2 = $dbHandle2->prepare($sqlQuery);
            $fetch2->execute();
            $adDetails = $fetch2->fetch();
            $ad = new AdThumbnail($adDetails[0],$adDetails[1],$adDetails[2]);
            $list[$loop] = $ad;
        }
        return $list;
    }catch(PDOException $e){
        echo $sqlQuery . "<br>" . $e->getMessage();
    }
    return false;
}