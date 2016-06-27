
  <?php
    require './includes/includes.inc';

    if(!empty(trim($_POST['user_name'])) && !empty(trim($_POST['user_password']))){ // checks to see if user name and password was entered

        $username = $_POST['user_name'];
        $password = $_POST['user_password'];
        $failedlogin = 'Wrong user name or password';

        $sql = "SELECT user_name,user_password,user_id FROM users WHERE user_name = '$username'"; // retrives user name from the database
        $query = $dbConnection->query($sql); // sends query to the database

        $array = $query->fetch_assoc(); // returns username and password from the database
        $numrows = $query->num_rows; // tells how many rows were returned
        if(!empty($numrows)){
          if($array['user_password'] === $password){
            setcookie('user_name',$username,time() + 3600);
            setcookie('user_id',$array['user_id'],time() + 3600);
            setcookie('logged_in','yes',time() + 3600);
            Redirect('dashboard.php'); // sends user to the polls page
          }else{
            echo $failedlogin;
          }
        }else{
          echo $failedlogin;
        }

    }else{
      echo "you're not logged in";
    }
   ?>
</body>
</html>
