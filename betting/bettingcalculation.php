
<?php
/*
{
    "customer": "1234",
    "bettingDate": "2022-01-20",
    "bettingCenterId": "02",
    "bettingAmount": "3500",
    "createdBy": "31",
    "bets": [
        {"bettingHorse": [{
            "raceCode":"w1", "horseCode": "Fine"
            }, 
            {
            "raceCode":"w3", "horseCode": "Fine 32"
            },
            {
            "raceCode":"w2", "horseCode": "DEC"
            }],
        "amounts": [{"amountTypeId":2, 
        "amount": 100},
        {"amountTypeId":1, 
        "amount": 20}]
        }
    ],
    "amountTypeId": 1, 
    "amount": 20
}
*/
function bettingCalculation($bet){

$bettintgAmount = prepareBettingAmount($bet);
$finalAmount = getBettingAmount();

return $finalAmount;

}


function prepareBettingAmount($bet){

  $noOfHorses = 0;
  $frontMoney = 0;
  $backMoney = 0;
  $bettingCharge = 0;


  foreach ($bet as $bet) {

    $bettingAmount = $bet->amount;
     foreach($bettingAmount as $bettingAmount){
      if ($bettingAmount->amountTypeId == 1){
        $frontMoney = $frontMoney + $bettingAmount->amount;
      }
      else if ($bettingAmount -> amountTypeId == 2){
        $backMoney = $backMoney + $bettingAmount->amount;
      }
      else if ($bettingAmount -> amountTypeId == 3){
        $doubleWin = $doubleWin + $bettingAmount->amount;
      }
      else if ($bettingAmount -> amountTypeId == 4){
        $tribbleWin = $tribbleWin + $bettingAmount->amount;
      }

      $noOfHorses = $bet->bettingHorse -> count;

      $bettingCharge = $bet->bettingAmount;

     }

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
  $doubleWin = 3;
  $tribbleWin = 4;
*/


  try {
    //double calculation 
    if ($doubleWin == 3) {

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
    if ($tribbleWin == 4) {

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

?>


