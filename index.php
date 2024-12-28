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
    <div class=game_style">
        <header class="header_game">
            <div class="head_title"> Mastermind Game </div>
        </header>

        <main>
            <div class="game_area">
                <div class="remaining_guess">Guesses remaining: <strong><?= $_SESSION['max_guess'] ?></strong></div>
                <div class="code_input">
                    <input type="hidden" id="guess_input" maxlength="<?= strlen($_SESSION['locked_code']) ?>" readonly>
                    <div class="symbols_input">
                        <?php for($c = 0; $c < strlen($locked_code); $c++){ ?>
                            <img id="<?=$c+1?>" src="img/gray.gif" alt="image">
                        <?php } ?>
                    </div>
                </div>

                <div class="guessing_history">

                </div>

                <div class="guessing_area">
                    <div class="squares_row">
                        <?php for($i = 0; $i < count($image); $i++){ ?>
                            <div class="clickable_square">
                                <a href="#"><img src="img/<?=$image[$i]?>" alt="image"></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="submit_row">
                    <a href="#">Reset</a>
                    <a href="#">Submit</a>
                </div>

            </div>
        </main>

        <footer>
            <div> Footer </div>
        </footer>
    </div>
    
</body>
</html>

<script src="js/jquery-3.7.1.js"></script>
<script>
    const images = [];
    const len = <?= strlen($_SESSION['locked_code'])?>
    const input_list = [];
    let id = 0;
    let number_guesses = 0;

    <?php for($i = 1;$i <= count($image);$i++){?>
        images.push("img" + <?=$i?> + ".gif")
    <?php } ?>

    function inputCode(code) {
        if (input_list.length < len) {
            input_list.push(code);
            id++;
            document.getElementById("guess_input").value = input_list.join("");
            document.getElementById(id).src = "img/" + images[code];
        } else {
            alert("You have reached the maximum number of inputs");
        }
    }

    function resetInput() {
        input_list.length = 0;
        document.getElementById("guess_input").value = "";
        $(".img_input").empty();
        for (let i = 1; i <= len; i++) {
            $(".symbols-input").append("<img id='" + i + "' src='img/gray.gif' alt='image'>");
        }
        id = 0;
    }
</script>