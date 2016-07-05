<?php

function NewPollOption($dbConnection, $post = $_POST, $session = $_SESSION) {
    if(!empty($_POST['option'])) {

        $sql = "INSERT INTO polls (`ID`, `Choice`, `Chosen`, `User_created_id`, `Question_id`, `Question`) VALUES (NULL, ? , '0', ?, ?, ?)";
        $question = explode('_', $post['Task']);


        $stmt = $dbConnection->prepare($sql); // sends query to the database
        $stmt->bind_param("siis", $post['option'], $session['user_id'], $session['q_id'], $question[1]); // binds variables to be sent with query
        $stmt->execute(); // sends query
    } else {
        echo "<div class='alert alert-danger'>You can't enter a blank option</div>";
    }
}

function MakePoll($dbConnection, $post = $_POST, $session = $_SESSION) {
    $sql = "INSERT INTO votingapp.questions (ID, User_name, Question) VALUES (NULL, ?, ?)";
    $stmt = $dbConnection->prepare($sql);
    $stmt->bind_param("ss", $session['uName'], $post['poll_question']);
    $stmt->execute();
    $worked = $stmt->affected_rows;
    $qID = $stmt->insert_id;

    if(!empty($worked)) {
        $uID = $session['uId'];
        $question = $post['poll_question'];
        $value;
        $sql = "INSERT INTO polls (`ID`, `Choice`, `Chosen`, `User_created_id`, `Question_id`, `Question`) VALUES (NULL, ? , '0', ?, ?, ?)";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bind_param("siis", $value, $uID, $qID, $question);
        foreach($post['poll_option'] as $key => $choice) {
            $value = $choice;
            $stmt->execute();
        }
        return $question; //
    }
}

function DeletePoll($dbConnection, $post = $_POST, $session = $_SESSION) {
    $task = explode('_', $post['Task']);
    $question = $task[1];
    $user_id = $session['uId'];
    $sql = "DELETE a.*, b.*, c.* FROM polls AS a, questions AS b, voted AS c INNER JOIN polls, voted WHERE a.question = b.question AND c.user = b.User_name AND c.question = a.question AND a.Question = ? AND a.User_created_id = ?";
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("si", $question, $user_id); // binds variables to be sent with query
    $stmt->execute(); // sends query
}

function DeleteOption($dbConnection, $poll_ID) {
    $delete = $poll_ID;
    $sql = "DELETE FROM polls, voted WHERE votingapp.voted.answer = votingapp.polls.Choice AND votingapp.polls.ID = ?";
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("i", $delete); // binds variables to be sent with query
    $stmt->execute(); // sends query
}

function UpdatePoll($dbConnection, $post = $_POST, $session = $_SESSION) {
    foreach($post as $key => $value) {
        $delete; // stores the ID that holds the row to delete

        if(empty($value)) { // contains the empty string to be deleted
            foreach($session['options'] as $choice => $ID) { // loops through the values in _SESSION
                $emptyVal = preg_replace('/\.|\s/', '_', $choice);  // converts periods and spaces to _

                if(strcmp($key, $emptyVal) === 0) {  // looks for the corresponding key
                    $delete = $ID;  // sets delete to the correct ID.
                    unset($session['options'][$choice]);
                    DeleteOption($dbConnection, $delete);
                }
            }
        }


        $sql = "UPDATE polls SET Choice = ? WHERE ID = ?"; // updates the changed choice
        $stmt = $dbConnection->prepare($sql); // sends query to the database
        $stmt->bind_param("si", $choice, $id); // binds variables to be sent with query

        foreach($session['options'] as $key => $value) { // Updates all the poll choices
            $update = preg_replace('/\.|\s/', '_', $key);// converts periods and spaces to _
            if(!empty($key)) { // makes sure that a key isn't blank
                $choice = $_POST[$update];
            }

            $id = $value;
            $stmt->execute(); // sends query
        }
        if(strcmp($session['q'], $post['poll_question']) !== 0 && !empty($post['poll_question'])) {
            $q_id = $session['q_id'];
            $poll_question = $post['poll_question'];

            $sql = "UPDATE questions, voted, polls SET questions.Question = ?, polls.Question = ?, voted.question = ?  WHERE voted.question = questions.Question AND polls.Question = questions.Question AND questions.ID = ?";
            $stmt = $dbConnection->prepare($sql); // sends query to the database
            $stmt->bind_param("sssi", $poll_question, $poll_question, $poll_question, $q_id); // binds variables to be sent with query
            $stmt->execute();

            return $poll_question; //todo[1]
        } else if(empty($post['poll_question'])) {
            echo "<div class='alert alert-danger'>Your Poll Question is blank, can't have a blank question</div>";
        }
    }
}

function EditPoll($dbConnection, $todo, $session = $_SESSION) {
    $user_id = $session['uId'];
    $question = $todo[1];

    $sql = "SELECT Choice,ID,Question_id,User_created_id,Question FROM polls WHERE User_created_id = ? AND Question = ? "; // retrieves user name from the database
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("is", $user_id, $question); // binds variables to be sent with query
    $stmt->execute(); // sends query
    $query = $stmt->get_result();
    $i = 0; // counter to be used for unique ID's
    $polls = ''; // used to hold th HTML for the polls

    unset($session['options']);  // reset's session variables.
    unset($session['q_id']);
    unset($session['q']);

    while($array = $query->fetch_assoc()) { //returns the questions from the database
        $i++;
        if(empty($session['q_id'])) { // used to assign values only once.
            $session['q_id'] = $array['Question_id'];
            $session['user_id'] = $array['User_created_id'];
            $session['q'] = $array['Question'];
        };
        $session['options'][$array['Choice']] = $array['ID']; // assigns the choices to be stored in session
        if(empty($array['Choice'])) {
            $delete = $array['ID'];
            DeleteOption($dbConnection, $delete);
        } else {
            $polls .= '
            <div class="form-group">
              <input title="option for ' . $array['Choice'] . '" class="input_width choice"  type="text" class="form-control"
              id="question_' . $i . '" name="' . $array['Choice'] . '" value="' . $array['Choice'] . '">
              <i title="Delete ' . $array['Choice'] . ' option" class="fa fa-times fa-2x delete_btn" aria-hidden="true" type="submit" role="button"></i>
            </div>
        ';
        }
    }
    return $polls;
}

function ViewResults($dbConnection, $post = $_POST, $session = $_SESSION) {
    $user_id = $session['uId'];
    $question = explode('_', $post['Task']); // Checks to see what you are trying to do


    $sql = "SELECT Choice,Chosen FROM polls WHERE User_created_id = ? AND Question = ? "; // retrieves user name from the database
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("is", $user_id, $question[1]); // binds variables to be sent with query
    $stmt->execute(); // sends query
    $query = $stmt->get_result();
    $array = $query->fetch_all(MYSQLI_ASSOC);

    return $array;
}