<?php

    $user_id = $_COOKIE['user_id'];
    $question = $todo[1];

    $sql = "SELECT Choice,ID,Question_id,User_created_id,Question FROM polls WHERE User_created_id = ? AND Question = ? "; // retrieves user name from the database
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("is", $user_id, $question); // binds variables to be sent with query
    $stmt->execute(); // sends query
    $query = $stmt->get_result();
    $i = 0; // counter to be used for unique ID's
    $polls = ''; // used to hold th HTML for the polls
    session_unset();  // reset's session variables.

    while ($array = $query->fetch_assoc()) { //returns the questions from the database
        $i++;
        if(empty($_SESSION['q_id'])){ // used to assign values only once.
            $_SESSION['q_id'] = $array['Question_id'];
            $_SESSION['user_id'] = $array['User_created_id'];
            $_SESSION['q'] = $array['Question'];
        };
        $_SESSION['options'][$array['Choice']] = $array['ID']; // assigns the choices to be stored in session
        if(empty($array['Choice'])){
            $delete = $array['ID'];
            require './includes/delete.inc';
        }else{
            $polls .= '
            <div class="form-group">
              <input title="option for ' . $array['Choice'] . '" class="input_width choice"  type="text" class="form-control"
              id="question_' . $i . '" name="' . $array['Choice'] . '" value="' . $array['Choice'] . '">
              <i title="Delete '.$array['Choice'].' option" class="fa fa-times fa-2x delete_btn" aria-hidden="true" type="submit" role="button"></i>
            </div>
        ';
        }

    }

    $html = <<<HTML
    <div class='container' xmlns="http://www.w3.org/1999/html">
      <div class='row'>
        <div><span class='h3'>Editing: $todo[1]</span> </div>
        <br/>
        <div>
            <form id="options" action=$formAction method='post'>
                <div> <strong> Poll Question:</div>
                <div><strong><input class='input_width' name="poll_question" value="$question" >  </div> <br/></strong>
                <strong>Poll Choices:(Leaving an option black will delete it)</strong>
                $polls
                <button id="update_btn" type="submit" name="Task" value="Update_$question" class="btn btn-primary">Update Poll</button>
            </form>
        </div>
        <div>
            <br/>
            <form id="add_option" action=$formAction method='post'>
                <button type="submit" name="Task" value="Insert_$question" class="btn btn-success btn-bloc input_width"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></button>
                <div> <strong> Add a new option:</div>
                <div><strong><input class='input_width' id="new_option" name="option" value="" >  </div> <br/>            
            </form>
            
            <button type="submit" name="Task" value="Default_" class="btn btn-primary btn-bloc input_width">View All Your Polls</button>                    
            
        </div>
      </div>
    </div>
HTML;
    echo $html;


?>
