<?php

session_start();
$images_filename = "img1.gif|img2.gif|img3.gif|img4.gif|img5.gif|img6.gif|";
$image = explode("|", $images_filename);

$code = "012345";
$code = str_shuffle($code);

$locked_code = '';
$symbol_counts = [];

for($i = 0; $i < strlen($code); $i++){
    $index = random_int(0, strlen($code) - 1);
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

<!DOCTYPE html>
<html lang="en">
<head>
    <title> Mastermind Game </title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div> Mastermind Game </div>
    </header>

    <main>
        <div class="game-area">
            <div class="remaining-guess">Guesses remaining: <strong><?= $_SESSION['max_guess'] ?></strong></div>
            <div class="code-input">
                <input type="hidden" id="guess-input" maxlength="<?= strlen($_SESSION['locked_code']) ?>" readonly>
                <div class="symbols-input">
                    <?php for($c = 0; $c < strlen($locked_code); $c++){ ?>
                        <img id="<?=$c+1?>" src="img/gray.gif" alt="image">
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div> Footer </div>
    </footer>
</body>



</html>
<script src="js/jquery-3.7.1.js"></script>