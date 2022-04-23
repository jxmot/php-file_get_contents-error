<?php
// Please see the README in this repository first, thanks!
//
// these WILL fail if this script is ran from SITE_A!
//$url = 'http://SITE_B/testtemp/tzone.json';
//$url = 'https://SITE_B/testtemp/tzone.json';
// local files WILL NOT work correctly, unlike file_get_contents()
//$url = './tzone.json';

// this WILL WORK!
//$url = 'https://baconipsum.com/api/?type=meat-and-filler&paras=1&format=json';

if( ini_get('allow_url_fopen') ) {
    echo "\nallow_url_fopen is enabled.\n\n";
} else {
    echo "\nallow_url_fopen is disabled.\n\n";
    die();
}

echo "url = {$url}\n\n";

if (!function_exists('curl_init')){ 
    die('CURL is not installed!');
}

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
    'user-agent: curl-get_error_demo.php',
    'Accept-language: en-US',
    'Accept: application/json',
    'Accept-Charset: utf-8',
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$data = curl_exec($curl);
curl_close($curl);

echo "data = [{$data}]\n\n";

echo 'error_get_last: ';
print_r(error_get_last());
echo "\n\n";
?>