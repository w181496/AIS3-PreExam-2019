<head>
<title>AIS3 - BabySSRF</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
function chk() { var url = document.getElementById("url").value;if(url.match(/[^\.a-z:\/]/i)) {return false;} else {return true;}}
</script>
</head>

<?php
function curl($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
}

function errmsg($msg) {
    die('<div class="alert alert-danger" role="alert">' . $msg . '</div>');
}

if(isset($_GET['url'])) {

    $raw_url = $_GET['url'];

    if(strlen($raw_url) > 236) 
        errmsg("Your url is too looooong! (max length: 236)");

    $url = urldecode($raw_url);
    if(stripos($url, "metadata.google.internal") !== FALSE)
        errmsg("Bad seadog! Don't use metadata.google.internal");
    if(stripos($url, "169.254.169.254") !== FALSE)
        errmsg("Bad seadog! Don't use 169.254.169.254");
    if(stripos($url, "computeMetadata") !== FALSE)
        errmsg("Bad seadog! Don't use computeMetadata");
    if(stripos($url, "file:") !== FALSE)
        errmsg("Bad hacker! Don't use file:");
    if(stripos($url, "ftp:") !== FALSE)
        errmsg("Bad hacker! Don't use ftp:");
    if(stripos($url, "/proc") !== FALSE)
        errmsg("Bad hacker! Don't use /proc");
    if(stripos($url, "/var/log") !== FALSE)
        errmsg("Bad hacker! Don't use /var/log");
    if(stripos($url, "flag") !== FALSE)
        errmsg("Bad hacker! Don't use flag");
    //if(stripos($url, "/var/www/html") !== FALSE)
    //    errmsg("Bad hacker! Don't use /var/www/html");
    if(stripos($url, "index.php") !== FALSE)
        errmsg("Bad hacker! Don't use index.php");

}

?>

<body>
<div id='stars'></div>
<div id='stars2'></div>
<div id='stars3'></div>

<center>
<div class="container-fluid">
<div style="padding:30px;border-radius:6px;color:black;background-color:#ceffed;width: 40%">
<h2>BabySSRF</h2>
SSRF? Easy Peasy!<br>
<br>
<form method="get" onsubmit="return chk();" class="form-group">
<input type="text" id="url" class="form-control" name="url" placeholder="URL..."><br>
<input type="submit" class="btn btn-primary btn-lg btn-block" value="Submit">
</form>
</div>
</div>
</center>
<br>
<hr>
<br>
<?php
if(isset($_GET['url']))
    curl($raw_url);
?>
<!-- s3cr3t: https://tinyurl.com/y52yw5bh -->
</body>
