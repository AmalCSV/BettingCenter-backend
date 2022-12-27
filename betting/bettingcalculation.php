
<?php

function bettingCalculation($bets){

$bettintgAmount = prepareBettingAmount($frontMoney, $backMoney, $bettingCharge,$doubleWin,$tribbleWin);
$finalAmount = getBettingAmount();

return $finalAmount;

}



function prepareBettingAmount($frontMoney, $backMoney, $bettingCharge,$doubleWin,$tribbleWin){

  $noOfHorses = 0;

  foreach ($bets as $bet) {
  
    $noOfHorses = $bet->bettingHorse -> count;
    
  }
 
  return  array (

             "frontMoney"-> $frontMoney, 
             "backMoney" -> $backMoney,
             "bettingCharge" -> $bettingCharge,
             "doubleWin" -> $doubleWin,
             "tribbleWin"-> $tribbleWin,
         );
         
}


//
function getBettingAmount($frontMoney, $backMoney, $bettingCharge, $noOfHorses,$doubleWin,$tribbleWin) {
  
  /*
  $frontMoney = 20;
  $backMoney = 10;
  $bettingCharge = 5;
  $noOfHorses = 4;
  $doubleWin = 1;
  $tribbleWin = 2;
*/


  try {
    //double calculation 
    if ($doubleWin == 1) {

      $double_1 = 1;
      $double_2 = 1;
      $doubleFact = ($noOfHorses) - 2;


      //double probability
      for ($i = $noOfHorses; $i >= 1; $i--) {

        $double_1 = $double_1 * $i;
      }


      for ($i = $doubleFact; $i >= 1; $i--) {

        $double_2 = $double_2 * $i;
      }

      $double = $double_1 / (2 * $double_2);

    }
  }catch (Exception $e){
     echo "double error". $e -> getMessage();
  }


  try {
    if ($tribbleWin == 2) {

      $tribble_1 = 1;
      $tribble_2 = 1;
      $tribbleFact = ($noOfHorses) - 3;




      //tribble probability
      for ($i = $noOfHorses; $i >= 1; $i--) {

        $tribble_1 = $tribble_1 * $i;
      }


      for ($i = $tribbleFact; $i >= 1; $i--) {

        $tribble_2 = $tribble_2 * $i;
      }


      $tribble = $tribble_1 / (6 * $tribble_2);
    }
  }catch(Exception $e){
    echo "Tribble  Error" . $e->getMessage();
  }


//calculations 

 $totalBettingCharge = $frontMoney + $backMoney + ($bettingCharge * $double) + ($bettingCharge * $tribble);

return $totalBettingCharge;

}

echo getBettingAmount();

?>


