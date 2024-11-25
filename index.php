<?php

session_start();
$images_filename = "img1.gif|img2.gif|img3.gif|img4.gif|img5.gif|img6.gif|";
$image = explode("|", $images_filenames);

$code = "012345";
$code = str_shuffle($code);

$locked_code = '';
$symbol_counts = [];

for($i = 0; $i < strlen($code); $i++){
    $index = rand(0, strlen($code) - 1);
    $symbol = $code[$index];

    if(!isset($symbol_counts[$symbol])){
        $symbol_counts[$symbol] = 0;
    }
    if($symbol_counts[$symbol] < 2){
        $locked_code .= $symbol;
        $symbol_counts[$symbol]++;
    }else{
        $i--;
    }
}

$_SESSION['locked_code'] = $locked_code; // I decided to hide the code in a session variable to prevent the user from seeing the code in the source code of the page.
$max_guess = 10;
$_SESSION['max_guess'] = $max_guess;
?>