<html>

<head>

<style>
body {
	background-image: url(spongebobback.jpg);
	background-repeat: no-repeat;
    background-size: cover;
	font-size: 69px;
	text-align: center;
	font-family: bookman old style;
}
h1 {
	font-size: 20;
	text-align: center;
	font-family: bookman old style;
}
</style>
</head>

<body>

<h1> Guess The Word: Spongebob Edition! :)

<?php

$letters = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

if (empty($_POST)) {
    $words = explode("\n", file_get_contents('wordlist.txt'));
    $right = array_fill_keys($letters, ' _ ');
    $wrong = array();
    shuffle($words);
    $word = strtolower($words[0]);
    $rightstr = serialize($right);
    $wrongstr = serialize($wrong);
    $wordletters = str_split($word);
    $show = '';
    foreach ($wordletters as $letter) {
        $show .= $right[$letter];
    }
} else {
    $word = $_POST['word'];
    $guess = strtolower($_POST['guess']);
    $right = unserialize($_POST['rightstr']);
    $wrong = unserialize($_POST['wrongstr']);
    $wordletters = str_split($word);
    if (stristr($word, $guess)) {
        $show = '';
        $right[$guess] = $guess;
        $wordletters = str_split($word);
        foreach ($wordletters as $letter) {
            $show .= $right[$letter];
        }   
    } else {
        $show = '';
        $wrong[$guess] = $guess;
        if (count($wrong) == 10) {
            $show = $word;
        } else {
            foreach ($wordletters as $letter) {
                $show .= $right[$letter];
            }
        }
    }
    $rightstr = serialize($right);
    $wrongstr = serialize($wrong);
}

?>

<?php echo $show ?><br />
<form method='post'>
<input name='guess' />
<input type='hidden' name='word' value='<?php echo $word ?>' />
<input type='hidden' name='rightstr' value='<?php echo $rightstr ?>' />
<input type='hidden' name='wrongstr' value='<?php echo $wrongstr ?>' />
<input type='submit' value='guess' />
</form>
<h1>this ain't it : <?php echo implode(', ', $wrong) ?><br /> </h1>
<br>
<h1><a href='hangman.php'>restart?</a></h1>
<h1><a href='leaderboard.php'>leaderboard</a></h1>

<br>
<br>
<br>
<br>
<br>

</body>
</html>