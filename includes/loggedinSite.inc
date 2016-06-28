<?php
//$username = $_COOKIE['user_name'];
$sql = "SELECT questions.Question FROM questions WHERE user_name =?"; // retrives user name from the database

//$query = $dbConnection->query($sql); // sends query to the database
$stmt = $dbConnection->prepare($sql);
$stmt->bind_param("s",$username);
$stmt->execute();
$query = $stmt->get_result();
$numrows = $query->num_rows; // tells how many rows were returned

if(!empty($numrows)){
  $polls = '';
  $i = 0;
  while($array = $query->fetch_assoc()){
    $polls .= '<li class="polls">
                 <div>
                   <label class="radio-inline">
                  <input type="radio" name="Task" id="optionsRadios'.$i++.'" value="View_'.$array['Question'].'">
                      View
                   </label>
                  <label class="radio-inline">
                     <input type="radio" name="Task" id="optionsRadios'.$i++.'" value="Edit_'.$array['Question'].'">
                       Edit &nbsp;&nbsp;&nbsp;<span class="h4"> <strong>'.$array['Question'].'</strong> </span>
                  </label>
                </div>
            </li><br/>';
  }
}else{
  $polls = 'You currently have no polls';
}





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
