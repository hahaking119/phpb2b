<?php
/**
 * NOTE   :  PHP versions 4 and 5
 *
 * PHPB2B :  An Opensource Business To Business E-Commerce Script (http://www.phpb2b.com/)
 * Copyright 2007-2009, Ualink E-Commerce Co,. Ltd.
 *
 * Licensed under The GPL License (http://www.opensource.org/licenses/gpl-license.php)
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * @copyright Copyright 2007-2009, Ualink E-Commerce Co,. Ltd. (http://phpb2b.com)
 * @since PHPB2B v 1.0.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id: captcha.php 416 2009-12-26 13:31:08Z steven $
 */
include 'libraries/captcha/securimage.php';
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
