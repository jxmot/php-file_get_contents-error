# file_get_contents() Connection Timeout

This is a demonstration of a problem that occurs under the following conditions:

* PHP 7.2.34
* Server version: Apache/2.4.53 (cPanel)
* Server built:   Apr 19 2022 23:33:10
* Multi-site hosting environment
* A recent update (cPanel?) was done.

## History

I think this problem first started in 2019 or 2020. The hosting service tech support folks would "do something" and the problem would be fixed. For a while.

It took a couple more occurrences and I noticed that it seemed to be coinciding with server updates. And during one of my many web searches there seemed to be a intangible connection to a *firewall*... I'm still investigating.

## Set Up

You will need two websites for this demonstration, and they must be hosted on the same server. In addition it will also be necessary for you to have shell access and permissions to create folders on, and copy files to each sites' document root.

Take note of the servers' domains, they will be required later for editing the script. And they will be referred to as **"Site A"** and **"Site B"**.

Typically the *document root* is located at `/home/$USER/public_html`, on **each server** navigate to it and create a folder named `testtemp`. Copy `file_get_contents-error_demo.php` and `tzone.json` into the folder on *both servers*.

**"Site A" Set Up**
First edit the `file_get_contents-error_demo.php` for "Site A". At the top of the file:

```
// these WILL fail if this script is ran from SITE_A!
//$url = 'http://SITE_B/testtemp/tzone.json';
//$url = 'https://SITE_B/testtemp/tzone.json';

// this WILL WORK!
//$url = 'https://baconipsum.com/api/?type=meat-and-filler&paras=1&format=text';

// local files continue to work correctly
//$url = './tzone.json';
```

1. Replace all `SITE_B` occurrences with the domain for "Site B". The top of the file should now have (*using "exampleB.com" as one of your site domains*):

```
// these WILL fail if this script is ran from SITE_A!
//$url = 'http://exampleB.com/testtemp/tzone.json';
//$url = 'https://exampleB.com/testtemp/tzone.json';
```
2. Uncomment the first occurence of `$url = ...`, you should now have:

```
// these WILL fail if this script is ran from SITE_A!
$url = 'http://exampleB.com/testtemp/tzone.json';
//$url = 'https://exampleB.com/testtemp/tzone.json';
```

**"Site B" Set Up**

Next edit the `file_get_contents-error_demo.php` for "Site B". 

1. Replace all `SITE_B` occurrences with the domain for "Site A" (*using "exampleA.com" as one of your site domains*):

2. Uncomment the first occurence of `$url = ...`, you should now have:

```
// these WILL fail if this script is ran from SITE_A!
$url = 'http://exampleA.com/testtemp/tzone.json';
//$url = 'https://exampleA.com/testtemp/tzone.json';
```

## Run

On **"Site A"** : 

```
$ cd /home/$USER/public_html/testtemp
$ php ./file_get_contents-error_demo.php
```

*Where* `$USER` *is typically the user name you logged in with.*

If the problem has been resolved, or if your servers don't have the issue the you will see the following output from the script:

```
allow_url_fopen is enabled.

url = http://exampleB.com/testtemp/tzone.json

data = [{"tz":"America/Chicago"}]
```

However the problem will cause the following output:

```
allow_url_fopen is enabled.

url = http://exampleB.com/testtemp/tzone.json

data = []

Array
(
    [type] => 2
    [message] => file_get_contents(http://myinfofind.com/temptest/tzone.json): failed to open stream: Connection timed out
    [file] => /home/webxinfo/public_html/portfolio/mdhc/file_get_contents-error_demo-20211004.php
    [line] => 59
)
```

Running the "Site B" script should produce very similar output.

# PHP curl

Unfortunately PHP curl has the same problem. Edit and run `curl-get_error_demo.php` just like `file_get_contents-error_demo.php` above. 

The only differnce has been when `"./tzone.json"` is the URL the curl version fails and `file_get_contents-error_demo.php` does not.

# Exact Cause

Unknown at this time.

---
<img src="http://webexperiment.info/extcounter/mdcount.php?id=php-file_get_contents-error">