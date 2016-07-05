<?php
session_start();
require 'db_login.inc.php';
require 'functions.inc.php';
require 'poll-functions.inc.php';
 /*
$fb = new Facebook\Facebook([
    'app_id' => 1581192785514986, // Replace {app-id} with your app id
    'app_secret' => 97b81d532fe4fb55442a377c6e209517 ,
    'default_graph_version' => 'v2.2',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);
//*/
