<?php
/**
 * Created by PhpStorm.
 * User: rober
 * Date: 31/01/2018
 * Time: 09:54 PM
 */

require_once 'Scripts/CommonFunctions.php';

$names = array('Mercedez Benz', 'Alfa Romeo', 'Maserati', 'Mazda');
$colour = array('red', 'green', 'blue', 'white', 'black');
$locations = array('Manchester', 'London', 'Leeds');
$user = array('5a85e99fd68cf', '5a85e9db58835', '5a85ea196456a', '5a85ea9050b34', '5ab501b173bfc');


$descript = 'Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec in massa augue. Integer euismod interdum ante vel aliquet. Nulla ornare lacus quis varius luctus. Suspendisse dapibus dolor a ligula ornare ultrices. Maecenas sed cursus ligula.';

$imgadd = 'placehold';

for($x = 0; $x < 20; $x++){
    $nam = $names[array_rand($names)];
    $col = $colour[array_rand($colour)];
    $loca = $locations[array_rand($locations)];
    $usr = $user[array_rand($user)];
    $cost = rand(5000, 1000000);
    $imgaddr = $imgadd . ($x + 220);
    //createAdvert($nam, $descript, $loca, $imgaddr, 'Caption', $col, $cost, $usr);
    echo '<p> Added ad #' . ($x + 220);
    echo "</br>";
}


function createAdvert($name,$desc,$loc,$imgaddress,$caption,$colour, $price, $userID){
    $number = uniqid();
    //This is a convenient way to make a unique ID, so we might as well use it again.

    $date = date('Y-m-d');
    //This function gives us a date stamp. And is formatted to the date format MySQL uses

    try {
        $dbHandle = setUpHandler();
        //Now we just insert the data into the database.
        $prep = $dbHandle->prepare("INSERT INTO classifieds VALUES ('$number', :name, :desc, :loc, '$imgaddress', :caption,'$date','$colour','$userID', '$price')");
        $prep->bindParam(':desc', $desc);
        $prep->bindParam(':name', $name);
        $prep->bindParam(':loc', $loc);
        $prep->bindParam(':caption', $caption);
        //We bind all of the parameters we bring in, just to be sure.
        //Price is not a parameter like this, since we've confirmed it's just a number
        $prep->execute();

        $dbHandle = null;
        return true;

    }catch(PDOException $e){
        echo $e->getMessage();
        echo "</br>";
    }
    //This function inserts a user record into the database
    return false;
}