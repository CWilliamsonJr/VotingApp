<?php
require_once './includes/includes.inc.php';

if (!empty(trim($_POST['user_name'])) && !empty(trim($_POST['user_password']))) { // checks to see if user name and password was entered

    $username = $_POST['user_name'];
    $password = $_POST['user_password'];
    $failedLogin = 'Wrong user name and/or password';

    $sql = "SELECT user_name,user_password,user_id FROM users WHERE user_name = ?"; // retrieves user name from the database
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $query = $stmt->get_result();
    $num_rows = $query->num_rows; // tells how many rows were returned
    $array = $query->fetch_assoc(); // returns username and password from the database
    $num_rows = $query->num_rows; // tells how many rows were returned
    $stmt->close();
    $right = password_verify($password,$array['user_password']);

    $cookieTime = time() + 3600 * 24 * 30;
    if (!empty($num_rows)) {
        if(password_verify($password,$array['user_password'])) {
            $_SESSION['uId'] = $array['user_id'];
            $_SESSION['uName'] = $array['user_name'];
            setcookie('logged_in', 'yes', $cookieTime);
            Redirect('dashboard.php'); // sends user to the polls page
        } else {
            echo $failedLogin;
        }
    } else {
        echo $failedLogin;
    }

} else {
    echo "you're not logged in";
}
   

