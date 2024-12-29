<?php
session_start();
$state = 0;
$array_locked_code = [];

$rep = $_REQUEST['rep'];
$rep = str_split($rep);
$guess = $_REQUEST['guess'];
$map = [];

$unique = [...array_unique(str_split($_SESSION['locked_code']))];

$values = array_count_values($rep);

foreach ($unique as $u){
    $map[$u] = 0;
}

if($guess == $_SESSION['max_guess']){
    $state = 10; // Game over.
}


if(count($rep) !== strlen($_SESSION['locked_code'])){
    $state = 9; // Not enough symbols.
}else{
    $correct = 0;
    $nb_values = array_count_values($values);
    for($i = 0; $i < strlen($_SESSION['locked_code']);$i++){
        if($_SESSION['locked_code'][$i] == $rep[$i]){
            $correct++;
        }
    }
    if($correct == strlen($_SESSION['locked_code'])){
        $state = 1; // Win.
    }else{
        $code_count = array_count_values(str_split($_SESSION['locked_code']));
        $guessed_count = [];
        //
        for ($i = 0; $i < strlen($_SESSION['locked_code']); $i++){
            if($_SESSION['locked_code'][$i] === $rep[$i]){
                $array_locked_code[] = 2; // Good symbol, good place.
                $map[$_SESSION['locked_code'][$i]]++;
                $guessed_count[$_SESSION['locked_code'][$i]] = ($guessed_count[$_SESSION['locked_code'][$i]] ?? 0) + 1;
            }else{
                $array_locked_code[] = 0; // Wrong symbol.
            }
            //Second loop to check if symbol is good but not at the good place.
            for($j = 0; $j < count($array_locked_code); $j++){
                //str_contains($_SESSION['code'], $rep[$j]) if PHP>8.
                if(in_array($rep[$j], $unique)){
                    if($map[$rep[$j]] < 2 && $array_locked_code[$j] == 0 && ($guessed_count[$rep[$j]] ?? 0) < $code_count[$rep[$j]]){
                        $array_locked_code[$j] = 1;
                        $map[$rep[$j]]++;
                        $guessed_count[$rep[$j]] = ($guessed_count[$rep[$j]] ?? 0) + 1;
                    }
                    if($map[$rep[$j]] > 2 || $guessed_count[$rep[$j]] > $code_count[$rep[$j]]){
                        for($k = 0; $k < count($array_locked_code); $k++){
                            if($array_locked_code[$k] == 1){
                                $array_locked_code[$k] = 0;
                            }
                        }
                    }
                }
            }

        }
    }
}
$response = [
    'state' => $state,
    'array_locked_code' => $array_locked_code
]; //JSON response
echo json_encode($response);

?>