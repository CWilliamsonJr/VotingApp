<?php
$html = <<<HTML
<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard for $username Polls </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/style.css">

</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="">
            <div class="navbar-brand">Voting Poll Web App</div>
            <ul class="nav navbar-nav navbar-right margin_right">
                <li><button class="btn btn-default navbar-btn margin_right"><a href="./dashboard.php" role="button"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;Home</a></button></li>
                <li><button class="btn btn-default navbar-btn"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;<a href="logout.inc.php">Logout </a><button</li>
            </ul>
        </div>
    </div>
</nav>
<div class='jumbotron'>
    <div class='container'>
        <div class='h1'>Dashboard</div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div>
            <form method="post" action=$formAction>
                <strong>Enter your poll question:</strong>
                <div class="form-group"><input class="input-width" id="poll_topic" type="text" name="poll_question" placeholder="Enter your question here">
                    <br/><br/>
                    <strong>Poll Options:</strong>
                    <div id="poll_options">
                        <div class="form-group"><input class="input-width" type="text" name="poll_option[]" placeholder="Put your option here"></div>
                        <div class="form-group"><input class="input-width" type="text" name="poll_option[]" placeholder="Put your option here"></div>
                        <div class="form-group"><input class="input-width" type="text" name="poll_option[]" placeholder="Put your option here"></div>
                    </div>
                        <button type="button" id="add_option" class="btn-info btn block input-width ">Add another option</button><br/>
                        <button type="submit" name="Task" value="Create_poll" class="btn-primary margin-top btn-block input-width">Make Poll</button>
                    </div>
            </form>

        </div>
    </div>
</div>
HTML;
echo $html;