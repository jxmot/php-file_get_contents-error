<?php
// Please see the README in this repository first, thanks!
//
// these WILL fail if this script is ran from SITE_A!
//$url = 'http://SITE_B/testtemp/tzone.json';
//$url = 'https://SITE_B/testtemp/tzone.json';

// this WILL WORK!
//$url = 'https://baconipsum.com/api/?type=meat-and-filler&paras=1&format=json';

// local files continue to work correctly
//$url = './tzone.json';

if( ini_get('allow_url_fopen') ) {
    echo "\nallow_url_fopen is enabled.\n\n";
} else {
    echo "\nallow_url_fopen is disabled.\n\n";
    die();
}

echo "url = {$url}\n\n";

$opts = array(
    'http'=>array(
        'method'=>'GET',
        'header'=>"user-agent: file_get_contents-error_demo.php\r\n"
                 ."Accept-language: en-US\r\n"
                 ."Accept: application/json\r\n" 
                 ."Accept-Charset: utf-8\r\n"
    )
);
$context = stream_context_create($opts);
$data = file_get_contents($url, false, $context);

echo "data = [{$data}]\n\n";

echo 'error_get_last: ';
print_r(error_get_last());
echo "\n\n";
?>