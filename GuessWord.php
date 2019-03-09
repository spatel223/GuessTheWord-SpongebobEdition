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
<br>
<h1> Guess The Word: Spongebob Edition! :) <h1>

<?php


$letters = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

if (empty($_POST)) {
    $words = explode("\n", file_get_contents('words.list.txt'));
    $right = array_fill_keys($letters, '.');
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
} 

else {
	$score = 1000;
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
	foreach($wrong as $wrongGuess){
		$score = $score - 100;
	}
        if (count($wrong) == 6) {
            $show = $word;
			echo "YOUR SCORE IS: " .$score. "<br>" ;
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
Bad Guesses : <?php echo implode(', ', $wrong) ?><br />
<?php echo $show ?><br />
<form method='post'>
<input name='guess' />
<input type='hidden' name='word' value='<?php echo $word ?>' />
<input type='hidden' name='rightstr' value='<?php echo $rightstr ?>' />
<input type='hidden' name='wrongstr' value='<?php echo $wrongstr ?>' />
<input type='submit' value='guess' />
</form>
<a href='3d10-hangman-generator.php'>Start Over</a>