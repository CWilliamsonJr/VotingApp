<?php

    $user_id = $_COOKIE['user_id'];
    $question = $todo[1];


    $sql = "SELECT Choice,ID,Question_id,User_created_id FROM polls WHERE User_created_id = ? AND Question = ? "; // retrives user name from the database
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("is", $user_id, $question); // binds variables to be sent with query
    $stmt->execute(); // sends query
    $query = $stmt->get_result();
    $i = 0;
    $polls = '';
    session_unset();
    echo $stmt->num_rows() . " rows in table";

    while ($array = $query->fetch_assoc()) { //returns the questions from the database
        $i++;
        if(empty($_SESSION['q_id'])){
            $_SESSION['q_id'] = $array['Question_id'];
            $_SESSION['user_id'] = $array['User_created_id'];
        };
        $_SESSION['options'][$array['Choice']] = $array['ID'];
        if(empty($array['Choice'])){
            $delete = $array['ID'];
            require './includes/delete.inc';
        }else{
            $polls .= '
            <div class="form-group">
              <input title="option for ' . $array['Choice'] . '" class="input_width choice"  type="text" class="form-control"
              id="question_' . $i . '" name="' . $array['Choice'] . '" value="' . $array['Choice'] . '">
              
            </div>
        ';
        }

    }

    $html = <<<HTML
    <div class='container'>
      <div class='row'>
        <div class='h2'>$todo[1]</div>
        <div>
            <form action=$formAction method='post'>
                <div> <strong> Poll Question:</div>
                <div><strong><input class='input_width' name="poll_question" value="$question" >  </div> <br/>
                <strong>Poll Choices: </strong>
                $polls
                <button type="submit" name="Task" value="Update_$question" class="btn btn-primary">Update Poll</button>
            </form>
        </div>
        <div>
            <br/>
            <form action=$formAction method='post'>
                <button type="submit" name="Task" value="Insert_$question" class="btn btn-success btn-bloc input_width"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></button>
                <div> <strong> Add a new option:</div>
                <div><strong><input class='input_width' name="option" value="" >  </div> <br/>            
            </form>
        </div>
      </div>
    </div>
HTML;
    echo $html;


?>
