#!/bin/bash
# 
cd $HOME/public_html/testtemp
#
# these WILL fail if this script is ran from SITE_A!
#url="http://SITE_B/testtemp/tzone.json"
#url="https://SITE_B/testtemp/tzone.json"
# local files WILL NOT work correctly, this is expected here
#url="./tzone.json"

# this WILL WORK!
#url="https://baconipsum.com/api/?type=meat-and-filler&paras=1&format=json"

echo ""
echo $url
echo ""
#
curl -X GET $url \
    -H "user-agent: curl-get_error_demo.sh" \
    -H "Accept-language: en-US" \
    -H "Accept: application/json" \
    -H "Accept-Charset: utf-8"

echo ""
