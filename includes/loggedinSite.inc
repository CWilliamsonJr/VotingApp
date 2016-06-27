<?php
//$username = $_COOKIE['user_name'];
$sql = "SELECT questions.Question FROM questions WHERE user_name = '$username'"; // retrives user name from the database
$query = $dbConnection->query($sql); // sends query to the database
$numrows = $query->num_rows; // tells how many rows were returned

if(!empty($numrows)){
  $polls = '';
  $i = 0;
  while($array = $query->fetch_assoc()){
    $polls .= '<li class="polls">';
    $polls .=   '<div>';
    $polls .=     '<label class="radio-inline">';
    $polls .=       '<input type="radio" name="ViewOrEdit" id="optionsRadios'.$i++.'" value="View_'.$array['Question'].'">';
    $polls .=         'View';
    $polls .=     '</label>';
    $polls .=     '<label class="radio-inline">';
    $polls .=       '<input type="radio" name="ViewOrEdit" id="optionsRadios'.$i++.'" value="Edit_'.$array['Question'].'">';
    $polls .=         'Edit &nbsp;&nbsp;&nbsp;<span class="h4"> <strong>'.$array['Question'].'</strong> </span>';
    $polls .=     '</label>';
    $polls .=   '</div>';
    $polls .= '</li><br/>';
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
