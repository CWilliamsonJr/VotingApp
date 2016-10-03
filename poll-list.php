<?php
/**
 * Created by PhpStorm.
 * User: Clarence Williamson
 * Date: 10/3/2016
 * Time: 1:35 PM
 */

require_once 'includes/includes.inc.php';

$sql ="SELECT * FROM questions";
$stmt = $dbConnection->prepare($sql);
$stmt->execute();
$query = $stmt->get_result();
$array = $query->fetch_all(MYSQLI_ASSOC);

$listpoll = " ";

foreach ($array as $key => $value){
    $link = "./vote.php/{$value["User_name"]}/{$value["Question"]}";
    $listpoll .= "<div>{$value["Question"]} by {$value["User_name"]} <small> <a title=\"A link to your poll so you can vote\" class=\"poll-link\" target=\"_blank\"  href=\"{$link}\"><i class=\"fa fa-location-arrow\" aria-hidden=\"true\"> Poll Link</i></a></small></div>";
}

$html = <<<HTML
<!DOCTYPE html>

<html lang="en">
<head>    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/VotingApp/styles/style.css">
     
   
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="">
         <div class="navbar-brand"><a class="nounderline" href="../../dashboard.php">Voting Poll Web App</a></div>
            <ul class="nav navbar-nav navbar-right margin_right">
                <li><a href="./createaccount.php" role="button"><i class="fa fa-plus" aria-hidden="true">&nbsp;Create Account</i></a></li>
                <li><a href="./dashboard.php"><i class="fa fa-sign-out" aria-hidden="true">&nbsp;Sign in</i> </a></li>
            </ul>
        </div>
    </div>
</nav>
<div class='jumbotron'>
    <div class='container'>
        <div class='h2'>Here are a list of all the public polls avaiable to be voted on.</small></div>
    </div>
</div>
  <div class='container'>
    <div class='row col-sm-12'>
        $listpoll
    </div>     
  </div>
  <footer>
    <div class=''>Designed by Clarence Williamson
    </div>
  </footer>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" ></script>
      <script async src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>
      <script src="/VotingApp/scripts/index.js"></script>
</body>
</html>
HTML;

echo $html;