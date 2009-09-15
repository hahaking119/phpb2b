<?php

include 'app/source/securimage/securimage.php';

$img = new securimage();
$img->wordlist_file = 'data/words/words.txt';
$img->audio_path = 'data/audio/';
$img->ttf_file = 'data/fonts/incite.ttf';
$img->show(); // alternate use:  $img->show('/path/to/background.jpg');

?>
