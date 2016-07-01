<?php
require_once './includes/includes.inc.php';
$username = trim($_POST['user_name']);
$password = trim($_POST['user_password']);


if(!empty($username) && !empty($password)){
    echo 'here';
    $sql = 'INSERT INTO users (`user_id`, `user_name`, `user_password`) VALUES (NULL, ?, ?)';


    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("ss",$_POST['user_name'],$_POST['user_password']); // binds variables to be sent with query
    $stmt->execute(); // sends query
    $successful = $stmt->affected_rows;
    if($successful === -1){
        $_SESSION['acct_warning'] = "<div class='alert alert-danger'>Account Creation Failed, please try again</div>";
        Redirect('createaccount.php');

    }else{
        $_SESSION['acct_warning'] = "<div class='alert alert-success'>Your Account was created!</div>";
        Redirect('index.php');
    }

}else{
    $_SESSION['acct_warning'] = "<div class='alert alert-danger'>You can't enter a blank option for User Name and/or Password</div>";
    Redirect('createaccount.php');
}

