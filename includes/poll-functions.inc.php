<?php

function NewPollOption($dbConnection) {
    if(!empty($_POST['option'])) {

        $sql = "INSERT INTO polls (`ID`, `Choice`, `Chosen`, `User_created_id`, `Question_id`, `Question`) VALUES (NULL, ? , '0', ?, ?, ?)";
        $question = explode('_', $_POST['Task']);


        $stmt = $dbConnection->prepare($sql); // sends query to the database
        $stmt->bind_param("siis", $_POST['option'], $_SESSION['user_id'], $_SESSION['q_id'], $question[1]); // binds variables to be sent with query
        $stmt->execute(); // sends query
    } else {
        echo "<div class='alert alert-danger'>You can't enter a blank option</div>";
    }
}

function MakePoll($dbConnection) {
    $sql = "INSERT INTO votingapp.questions (ID, User_name, Question) VALUES (NULL, ?, ?)";
    $stmt = $dbConnection->prepare($sql);
    $stmt->bind_param("ss", $_SESSION['uName'], $_POST['poll_question']);
    $stmt->execute();
    $worked = $stmt->affected_rows;
    $qID = $stmt->insert_id;

    if(!empty($worked)) {
        $uID = $_SESSION['uId'];
        $question = $_POST['poll_question'];
        $value;
        $sql = "INSERT INTO polls (`ID`, `Choice`, `Chosen`, `User_created_id`, `Question_id`, `Question`) VALUES (NULL, ? , '0', ?, ?, ?)";
        $stmt = $dbConnection->prepare($sql);
        $stmt->bind_param("siis", $value, $uID, $qID, $question);
        foreach($_POST['poll_option'] as $key => $choice) {
            $value = $choice;
            $stmt->execute();
        }
        return $question; // todo[1]
    }
}

function DeletePoll($dbConnection) {
    $task = explode('_', $_POST['Task']);
    $question = $task[1];
    $user_id = $_SESSION['uId'];
    $sql = "DELETE a.*, b.*, c.* FROM polls AS a, questions AS b, voted AS c INNER JOIN polls, voted WHERE a.question = b.question AND c.user = b.User_name AND c.question = a.question AND a.Question = ? AND a.User_created_id = ?";
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("si", $question, $user_id); // binds variables to be sent with query
    $stmt->execute(); // sends query
}

function DeleteOption($dbConnection, $poll_ID) {
    $delete = $poll_ID;
    $sql = "DELETE FROM polls WHERE votingapp.polls.ID = ?";
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("i", $delete); // binds variables to be sent with query
    $stmt->execute(); // sends query
}

function UpdatePoll($dbConnection) {
    foreach($_POST as $key => $value) {
        $delete; // stores the ID that holds the row to delete

        if(empty($value)) { // contains the empty string to be deleted
            foreach($_SESSION['options'] as $choice => $ID) { // loops through the values in _SESSION
                $emptyVal = preg_replace('/\.|\s/', '_', $choice);  // converts periods and spaces to _

                if(strcmp($key, $emptyVal) === 0) {  // looks for the corresponding key
                    $delete = $ID;  // sets delete to the correct ID.
                    unset($_SESSION['options'][$choice]);
                    DeleteOption($dbConnection, $delete);
                }
            }
        }
    }

    $sql = "UPDATE polls SET Choice = ? WHERE ID = ?"; // updates the changed choice
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("si", $choice, $id); // binds variables to be sent with query

    foreach($_SESSION['options'] as $key => $value) { // Updates all the poll choices
        $update = preg_replace('/\.|\s/', '_', $key);// converts periods and spaces to _
        if(!empty($key)) { // makes sure that a key isn't blank
            $choice = $_POST[$update];
        }

        $id = $value;
        $stmt->execute(); // sends query
    }
    if(strcmp($_SESSION['q'], $_POST['poll_question']) !== 0 && !empty($_POST['poll_question'])) {
        $q_id = $_SESSION['q_id'];
        $username = $_SESSION['uName'];
        $poll_question = $_POST['poll_question'];
 
        $sql = "UPDATE questions, voted, polls SET questions.Question = ?, polls.Question = ?, voted.question = ?  WHERE questions.ID = ? AND voted.user = ? AND polls.Question_id = ?";
        $stmt = $dbConnection->prepare($sql); // sends query to the database
        $stmt->bind_param("sssisi", $poll_question, $poll_question, $poll_question, $q_id,$username,$q_id); // binds variables to be sent with query
        $stmt->execute();

        return $poll_question; //todo[1]
    } else if(empty($_POST['poll_question'])) {
        echo "<div class='alert alert-danger'>Your Poll Question is blank, can't have a blank question</div>";
    }
}

function EditPoll($dbConnection, $todo) {
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

    while($array = $query->fetch_assoc()) { //returns the questions from the database
        $i++;
        if(empty($_SESSION['q_id'])) { // used to assign values only once.
            $_SESSION['q_id'] = $array['Question_id'];
            $_SESSION['user_id'] = $array['User_created_id'];
            $_SESSION['q'] = $array['Question'];
        };
        $_SESSION['options'][$array['Choice']] = $array['ID']; // assigns the choices to be stored in session
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

function ViewResults($dbConnection) {
    $user_id = $_SESSION['uId'];
    $question = explode('_', $_POST['Task']); // Checks to see what you are trying to do


    $sql = "SELECT Choice,Chosen FROM polls WHERE User_created_id = ? AND Question = ? "; // retrieves user name from the database
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("is", $user_id, $question[1]); // binds variables to be sent with query
    $stmt->execute(); // sends query
    $query = $stmt->get_result();
    $array = $query->fetch_all(MYSQLI_ASSOC);

    return $array;
}