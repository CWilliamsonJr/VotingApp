<?php
  var_dump($todo);
  $user_id = $_COOKIE['user_id'];
  $sql = "SELECT Choice FROM polls WHERE User_created_id = $user_id AND Question = '$todo[1]' "; // retrives user name from the database
  $query = $dbConnection->query($sql); // sends query to the database

  $array = $query->fetch_assoc(); // returns username and password from the database

  $numrows = $query->num_rows; // tells how many rows were returned

  var_dump($array);

  $formAction = "'". htmlspecialchars($_SERVER["PHP_SELF"]) . "'";
  $html = <<<HTML
<div class='container'>
  <div class='row'>
    <div class='h2'>My Polls</div>
    <strong>Your current polls:</strong>
    <form action=$formAction method='post'>
    <ul>
      $polls
    </ul>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>
HTML;
echo $html;



 ?>
