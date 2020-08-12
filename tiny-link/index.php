<?php

session_start();

require_once "librecaptcha.php";

// Register API keys at https://www.google.com/recaptcha/admin
$siteKey = "6Lekfq4ZAAAAAOVx4VVKgkGFpWDX1v5GGJq42SYl";
$secret = "6Lekfq4ZAAAAAA1zTRM3n8Z-10WRnpUEr7ayxqS4";
// reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
$lang = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2) || "en";

// The response from reCAPTCHA
$resp = null;
// The error code from reCAPTCHA, if any
$error = null;

$reCaptcha = new ReCaptcha($secret);

// Was there a reCAPTCHA response?
if (isset($_POST["g-recaptcha-response"])) {
    $resp = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
    );
};

if ( isset($_GET["hash"]) && !!$_GET["hash"] ) {
   $_SESSION["hash"] = $hash =  $_GET["hash"];
};

		if ( ($resp != null && $resp->success) ) {
    		require_once "../modules/TinyLink.php";
    		if ( !isset($_SESSION["hash"]) || !($link = $TinyLink -> findLink($_SESSION["hash"])) ) {
    		   echo "404 Not Link";
    		} else {
    		    //print_r($sql);
    		    $sql -> query("update Apps set downloads = downloads + 1 where versions REGEXP '.*;s:[0-9]+:\"".$_SESSION["hash"]."\".*'");
    		    echo $sql -> error;
    		   header("Location: ".$link);
    		   die();
			};
		} else if ( isset($hash) ) {
			$include = "php/check-captcha.php";
		} else {
		    header("Location: /");
		};
?>

	  
<!DOCTYPE html>
   <head>
      <title> Link Web </title>
      <link rel="stylesheet" href="https://nguyenthanh1995.github.io/lib/bootstrap.min.css">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>

   <body class="bg-light">
      <?php
         if ( isset($include) )
            include $include;
      ?>
   </body>
</html>