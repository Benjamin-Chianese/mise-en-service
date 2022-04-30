<?php
require ('../includes/head.php');



$day =date("m.d.y");
$time = strtotime($day);
$rand_time = rand(0,$time);
echo $day.' | '.$time.' | '.$rand_time.'<br/>';

$input_fastfood = array("JapThai", "Paniolade", "Kebab","O Fait Maison","Subway","Delicosy","Ô KI Sushi","Macdo", "La Tosca","Hereos Cafe","Izmir Purpan");

$input_resto = array( "Paniolade", "Bidule", "3B","Saveur & Basilic","La Tosca","La Cantcha","Rajpoot","Café Francis");

$rand_fastfood = array_rand($input_fastfood);
$rand_resto = array_rand($input_resto);

echo 'On mange à emporter : '.$input_fastfood[$rand_fastfood].' ou sur place au : '.$input_resto[$rand_resto];






require('../includes/foot.php');
?>
