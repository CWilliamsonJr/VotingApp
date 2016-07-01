<?php

$sql = "SELECT questions.Question FROM questions WHERE user_name =?"; // retrieves user name's polls from the database

$stmt = $dbConnection->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$query = $stmt->get_result();
$num_rows = $query->num_rows; // tells how many rows were returned

if (!empty($num_rows)) {
    $polls = '';
    $i = 0;
    while ($array = $query->fetch_assoc()) {
        $polls .= '<li class="polls">
                 <div>
                   <label class="radio-inline">
                  <input type="radio" name="Task" id="optionsRadios' . $i++ . '" value="View_' . $array['Question'] . '">
                      View
                   </label>
                   <label class="radio-inline">
                     <input type="radio" name="Task" id="optionsRadios' . $i++ . '" value="Edit_' . $array['Question'] . '">
                      Edit
                  </label>
                  <label class="radio-inline">
                     <input type="radio" name="Task" id="optionsRadios' . $i++ . '" value="Delete_' . $array['Question'] . '">
                       Delete &nbsp;&nbsp;&nbsp;<span class="h4"> <strong>' . $array['Question'] . '</strong> </span>
                  </label>
                </div>
            </li><br/>';
    }
    $submit_btn = '<button type="submit" class="btn btn-primary">Submit</button>';
} else {
    $submit_btn = '<strong>Since you have no polls, start by making one:</strong><br/> <br/>';
    $polls = 'You currently have no polls';
}

$html = <<<HTML
<div class='container'>
  <div class='row'>
    <div class='h2'>My Polls:</div>
    <strong>Your current polls:</strong>
    <form action=$formAction method='post'>
    <ul>
      $polls
    </ul>
      $submit_btn
      <button name="Task" value="Make_polls" type="submit" class="btn btn-success">Create Poll</button>
    </form>
  </div>
</div>
HTML;
echo $html;

 
