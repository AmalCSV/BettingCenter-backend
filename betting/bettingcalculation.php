<?php

//deaclare varibles

$front_money = 20;
$back_money = 10;
$no_of_horses = 4;
$betting_charge = 5;
$total_betting_charge;

//double
$double_win;
$double_1 = 1;
$double_2 = 1;
$double_fact = ($no_of_horses) - 2 ;
//tribble
$tribble_win;
$tribble_1 = 1;
$tribble_2 = 1;
$tribble_fact = ($no_of_horses) - 3 ;


//double probability
for ($i=$no_of_horses; $i >= 1 ; $i--) {

     $double_1 =  $double_1 * $i;
}


for ($i=$double_fact; $i >= 1 ; $i--) {

    $double_2 =  $double_2 * $i;
}

$double_win = $double_1 / (2 * $double_2);

//tribble probability
for ($i=$no_of_horses; $i >= 1 ; $i--) {

    $tribble_1 =  $tribble_1 * $i;
}


for ($i=$tribble_fact; $i >= 1 ; $i--) {

   $tribble_2 =  $tribble_2 * $i;
}


$tribble_win = $tribble_1 / (6 * $tribble_2);


//calculations 

$total_betting_charge = $front_money + $back_money + ($betting_charge * $double_win) + ($betting_charge * $tribble_win);

//output

echo $total_betting_charge;

?>
