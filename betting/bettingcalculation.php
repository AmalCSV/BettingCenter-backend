
<?php

function bettingCalculation($bets){

$bettintgAmount = prepareBettingAmount($bets);

$finalAmount = getBettingAmount($bettingAmountArray => frontMoney,backMoney);

return $finalAmount;

}



function prepareBettingAmount($bets) {

    $noOfHorses = 0;
  foreach ($bets as $bet) {
  
    $noOfHorses = $bet->bettingHorse -> count;
    
  }
  
  $bettingcen_record = array(
             "front_money" => frontMoney;
             "backAmount" =>$backMoney;
         );
         
  return $bettingcen_record;

$frontMoney;
backMoney,
$noOfHorses,
$bettingCharge

//double
$doubleWin;
$double_1 = 1;
$double_2 = 1;
$doubleFact = ($noOfHorses) - 2 ;
//tribble
$tribbleWin;
$tribble_1 = 1;
$tribble_2 = 1;
$tribbleFact = ($noOfHorses) - 3 ;


//double probability
for ($i=$noOfHorses; $i >= 1 ; $i--) {

     $double_1 =  $double_1 * $i;
}


for ($i=$doubleFact; $i >= 1 ; $i--) {

    $double_2 =  $double_2 * $i;
}

$doubleWin = $double_1 / (2 * $double_2);

//tribble probability
for ($i=$noOfHorses; $i >= 1 ; $i--) {

    $tribble_1 =  $tribble_1 * $i;
}


for ($i=$tribbleFact; $i >= 1 ; $i--) {

   $tribble_2 =  $tribble_2 * $i;
}


$tribbleWin = $tribble_1 / (6 * $tribble_2);


//calculations 

return $totalBettingCharge = $frontMoney + $backMoney + ($bettingCharge * $doubleWin) + ($bettingCharge * $tribbleWin);

}

echo bettingCalculation(20,10,4,5);
?>


