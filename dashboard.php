<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard for <?php echo $_COOKIE['user_name'] ?> Polls </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/style.css">
    <?php
    require_once './includes/includes.inc';
    ?>
</head>

<body>
<div class='jumbotron'>
    <div class='container'>
        <div class='h1'>Dashboard</div>
    </div>
</div>
<?php

$logged_in = $_COOKIE['logged_in'];
if ($logged_in === 'yes') { // if you are still logged in
    $username = $_COOKIE['user_name'];
    $formAction = "'" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'";

    if (isset($_POST['Task'])) {
        $todo = explode('_', $_POST['Task']); // Checks to see what you are trying to do
        switch ($todo[0]) {
            case 'Edit':
                require './includes/edit.inc';
                break;
            case 'Update':
                require './includes/update.inc';
                require './includes/edit.inc';
                break;
            case 'View':
                require './includes/view.inc';
                break;
            case 'Insert':
                require './includes/insert.inc';
                require './includes/edit.inc';
                break;
            case 'Logout':
                break;
            default:
                require './includes/loggedinSite.inc';
        }
    } else {
        require './includes/loggedinSite.inc';
    }
} else {
    Redirect('index.php');
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="./scripts/index.js"></script>
</body>
</html>
