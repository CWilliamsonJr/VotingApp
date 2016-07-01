<?php

    $user_id = $_SESSION['uId'];
    $question = $todo[1];

    $sql = "SELECT Choice,ID,Question_id,User_created_id,Question FROM polls WHERE User_created_id = ? AND Question = ? "; // retrieves user name from the database
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("is", $user_id, $question); // binds variables to be sent with query
    $stmt->execute(); // sends query
    $query = $stmt->get_result();
    $i = 0; // counter to be used for unique ID's
    $polls = ''; // used to hold th HTML for the polls

    unset($_SESSION['options']);  // reset's session variables.
    unset($_SESSION['q_id']);
    unset($_SESSION['q']);

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
            require './includes/delete.inc.php';
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

    unset($_POST['Task']);
    $html = <<<HTML
    <div class='container' xmlns="http://www.w3.org/1999/html">
      <div class='row'>
        <div><span class='h3'>Editing: <small>$todo[1]</small></span> </div>
        <br/>
        <div>
            <form id="options" action=$formAction method='post'>
                <div> <strong> Poll Question:</div>
                <div><strong><input class='input-width' name="poll_question" value="$question" >  </div> <br/></strong>
                <strong><span class="h3">Poll Choices:<small>(Leaving an option blank will delete it too).</small></span></strong>
                $polls
                <button id="update_btn" type="submit" name="Task" value="Update_$question" class="btn btn-primary">Update Poll</button>
            </form>
        </div>
        <div>
            <br/><br/>
            <form id="add_option" action=$formAction method='post'>
                <button type="submit" name="Task" value="Insert_$question" class="btn btn-success btn-block input-width"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></button>
                <div> <strong> Add a new option:</div>
                <div><strong><input class='input-width' id="new_option" name="option" value="" ></div>
            </form> <br/><br/>
            <div class='poll_btn'><button type="submit" id="see_polls" name="Task" value="Default_" class="btn btn-primary btn-block input-width">View All Your Polls</button> </div>
        </div>
      </div>
    </div>
HTML;
    echo $html;

