
  <?php
    require_once './includes/includes.inc';

    if(!empty(trim($_POST['user_name'])) && !empty(trim($_POST['user_password']))){ // checks to see if user name and password was entered

        $username = $_POST['user_name'];
        $password = $_POST['user_password'];
        $failedlogin = 'Wrong user name or password';

        $sql = "SELECT user_name,user_password,user_id FROM users WHERE user_name = ? AND user_password = ?"; // retrives user name from the database
        $stmt = $dbConnection->prepare($sql); // sends query to the database
        $stmt->bind_param("ss",$username,$password);
        $stmt->execute();
        $query = $stmt->get_result();
        $numrows = $query->num_rows; // tells how many rows were returned
        $array = $query->fetch_assoc(); // returns username and password from the database
        $numrows = $query->num_rows; // tells how many rows were returned
        $stmt->close();
        
        $cookieTime = time() + 3600 * 24 * 30;
        if(!empty($numrows)){
          if($array['user_password'] === $password){
            setcookie('user_name',$username,$cookieTime);
            setcookie('user_id',$array['user_id'],$cookieTime);
            setcookie('logged_in','yes',$cookieTime);
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
