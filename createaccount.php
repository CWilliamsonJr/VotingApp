<!doctype html>
<?php
require_once ('./includes/includes.inc.php');
?>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Create your Poll</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="">
            <div class="navbar-brand">Voting Poll Web App</div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="./index.php"> Home</a></li>
            </ul>
            <a href="index.php"><button name="Task" value="Logout_site" type="submit" class="btn btn-default navbar-btn navbar-right margin_right">Login</button></a>
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
            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>
</body>
</html>
