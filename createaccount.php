<!doctype html>
<?php
require_once ('./includes/includes.inc.php');
?>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Create your Poll</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="">
            <div class="navbar-brand">Voting Poll Web App</div>
            <ul class="nav navbar-nav navbar-right margin_right">
                <li><button class="btn btn-default navbar-btn margin_right"><a href="./index.php" role="button"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Home</a></button></li>
                <li><button class="btn btn-default navbar-btn"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;<a href="./dashboard.php">Sign in </a><button</li>
            </ul>
        </div>
    </div>
</nav>
<div class='jumbotron'>
    <div class='container'>
        <div class='h1'>Create your Account</div>
    </div>
</div>
<div class='container'>
    <div class='row'>
        <?php
            if(isset($_SESSION['acct_warning'])){
                echo $_SESSION['acct_warning'];
                unset($_SESSION['acct_warning']);
            }
        ?>
        <div><span class='h1'>Make your account</span></div><br/>
        <form action='./makeaccount.php' method="post">
            <div class="form-group">
                <label for="user_name">User Name:</label>
                <input name='user_name' type="text" class="form-control input-width" id="user_name" placeholder="User Name" required>
            </div>
            <div class="form-group">
                <label for="user_password">Password</label>
                <input name='user_password' type="password" class="form-control input-width" id="user_password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="user_password">Confirm Password</label>
                <input name='confirm_user_password' type="password" class="form-control input-width" id="user_password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>
</body>
</html>
