<?php

$sql = "SELECT questions.Question FROM questions WHERE user_name =?"; // retrieves user name's polls from the database

$stmt = $dbConnection->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$query = $stmt->get_result();
$num_rows = $query->num_rows; // tells how many rows were returned

if(!empty($num_rows)) {
    $polls = '';
    $i = 0;
    while($array = $query->fetch_assoc()) {
        $link = htmlspecialchars("./vote.php/".$_SESSION['uName']."/".$array['Question']);        
        $polls .= '<li class="polls">
                 <div><div class="h4"> <strong>' . $array['Question'] . '</strong><small> <a title="A link to your poll so people can vote" class="poll-link" target="_blank"  href="'.$link.'"><i class="fa fa-location-arrow" aria-hidden="true"> Poll Link</i></a></small> </div>
                   <label class="radio-inline"> 
                  <input type="radio" name="Task" id="optionsRadios' . $i++ . '" value="View_' . $array['Question'] . '">
                      View Results
                   </label>
                   <label class="radio-inline">
                     <input type="radio" name="Task" id="optionsRadios' . $i++ . '" value="Edit_' . $array['Question'] . '">
                      Edit
                  </label>
                  <label class="radio-inline">
                     <input type="radio" name="Task" id="optionsRadios' . $i++ . '" value="Delete_' . $array['Question'] . '">
                       Delete 
                  </label>
                </div>
            </li><br/>';
    }
    $submit_btn = '<button type="submit" class="btn btn-primary poll_view_btn">Submit</button>';
} else {
    $submit_btn = 'Since you have no polls, start by making one';
    $polls = 'You currently have no polls';
}

$html = <<<HTML
<div class='container'>
  <div class='row'>
    <div class='h2'>My Polls</div>
    <strong>Your current polls:</strong><br/><br/>
    <form action=$formAction method='post' class="poll_view">
        <ul>
          $polls
        </ul>
      $submit_btn
      <button name="Task" value="Make_polls" type="submit" class="btn btn-success poll_view_btn">Create Poll</button>
    </form>
  </div>
</div>
HTML;
echo $html;

 
