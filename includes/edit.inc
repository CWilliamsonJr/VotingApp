<?php

  $user_id = $_COOKIE['user_id'];
  $question = $todo[1];

  $sql = "SELECT Choice,ID FROM polls WHERE User_created_id = ? AND Question = ? "; // retrives user name from the database
  $stmt = $dbConnection->prepare($sql); // sends query to the database
  $stmt->bind_param("is",$user_id,$question); // binds variables to be sent with query
  $stmt->execute(); // sends query
  $query = $stmt->get_result();
  $i= 0;
  $polls = '';
  unset($_SESSION['current_poll']);


  while($array = $query->fetch_assoc()){ //returns the questions from the database
    $_SESSION['current_poll'][] = $array;
    $polls .= '
          <div class="form-group">
            <input title="option for '.$array['Choice'].'" class="input_width choice"  type="text" class="form-control"
            id="question_'.++$i.'" name="'.$array['Choice'].'" value="'.$array['Choice'].'">
            <i title="Delete '.$array['Choice'].' Choice" class="fa fa-times fa-2x delete_btn" aria-hidden="true" type="submit" role="button"></i>
          </div>
    ';
  }
  //*/

  //var_dump($_SESSION['current_poll']);
  $formAction = "'". htmlspecialchars($_SERVER["PHP_SELF"]) . "'";
  $html = <<<HTML
<div class='container'>
  <div class='row'>
    <div class='h2'>$todo[1]</div>
    <div> <strong> Poll Question:</div>
    <div><strong><input class='input_width' value="$question" >  </div> <br/>
    <strong>Poll Choices: </strong>
    <form action=$formAction method='post'>
      $polls
      <button type="submit" name="Task" value="Update_$question" class="btn btn-primary">Update Poll</button>
    </form>
  </div>
</div>
HTML;
echo $html;



 ?>
