<?php
include 'app/source/securimage/securimage.php';
$img = new securimage();
$img->wordlist_file = 'data/words/words.txt';
$img->audio_path = 'data/audio/';
$img->ttf_file = 'data/fonts/incite.ttf';
$img->draw_lines = false;
if ($handle = @opendir('data/background/'))
{
    while ($bgfile = @readdir($handle))
    {
        if (preg_match('/\.jpg$/i', $bgfile))
        {
            $backgrounds[] = 'data/background/'.$bgfile;
        }
    }
    @closedir($handle);
}
srand ((float) microtime() * 10000000);
$rand_keys = array_rand ($backgrounds);
$background = $backgrounds[$rand_keys];
$img->show($background);
?>
