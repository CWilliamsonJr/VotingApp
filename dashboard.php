<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard for <?php echo $_SESSION['uName'] ?> Polls </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/style.css">
    <?php
    require_once './includes/includes.inc.php';
    ?>
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
<?php

$logged_in = $_COOKIE['logged_in'];
if ($logged_in === 'yes') { // if you are still logged in
    
    $username = $_SESSION['uName'];
    $formAction = "'".htmlspecialchars($_SERVER["PHP_SELF"])."'";

    if (isset($_POST['Task'])) {
        $todo = explode('_', $_POST['Task']); // Checks to see what you are trying to do
        switch ($todo[0]) {
            case 'Edit':
                require './includes/edit.inc.php';
                break;
            case 'Create':
                
                $todo[1] = MakePoll($dbConnection);
                Redirect('dashboard.php');
                break;
            case 'Make':
                require './make-poll-form.php';
                break;
            case 'Update':                
                $new_question = UpdatePoll($dbConnection);
                if(!empty($new_question)){
                    $todo[1] = $new_question;
                }
                require './includes/edit.inc.php';
                break;
            case 'Delete':
                //require './includes/delete_poll.inc.php';
                DeletePoll($dbConnection);
                require './includes/poll-view.php';
                break;
            case 'View':
                require './includes/view-results.inc.php';
                break;
            case 'Insert':               
                NewPollOption($dbConnection);
                require './includes/edit.inc.php';
                break;
            case 'Logout':
                require './logout.inc.php';
                break;
            default:
                require './includes/poll-view.php';
        }
    } else {
        require './includes/poll-view.php';
    }
} else {
    Redirect('index.php');
}
//TODO: social site integration and login
//TODO: Password change
//TODO: Account creation second input for confirm password
//TODO: password hashing  
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="./scripts/index.js"></script>
</body>
</html>
