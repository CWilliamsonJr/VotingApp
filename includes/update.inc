<?php
 
    foreach($_POST as $key => $value){
      $delete; // stores the ID that holds the row to delete
      if(!empty($value)){
        $post[$key] = $value;
      }else{ // contains the empty string to be deleted
        foreach ($_SESSION['options'] as $choice => $ID) { // loops through the values in _SESSION
        $emptyVal =   preg_replace('/\.|\s/', '_', $choice);  // converts periods and spaces to _

        if(strcmp($key,$choice) === 0){  // looks for the corresponding key
            $delete = $ID;  // sets delete to the correct ID.
            unset($_SESSION['options'][$choice]);
            require 'delete.inc';
          }
        }
      }
    }

    $sql = "UPDATE polls SET Choice = ? WHERE ID = ?";
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("si",$choice,$id); // binds variables to be sent with query

    foreach ($_SESSION['options'] as $key => $value){ // Updates all the poll choices
        $update =   preg_replace('/\.|\s/', '_', $key);// converts periods and spaces to _
        if(!empty($key)){ // makes sure that a key isn't blank
            $choice = $_POST[$update];
        }
        
        $id = $value;
        $stmt->execute(); // sends query
    }
    if(strcmp($_SESSION['q'],$_POST['poll_question']) !== 0  && !empty($_POST['poll_question'])){
        $q_id =$_SESSION['q_id'];
        $poll_question = $_POST['poll_question'];

        $sql = "UPDATE questions SET Question = ? WHERE ID = ?";
        $stmt = $dbConnection->prepare($sql); // sends query to the database
        $stmt->bind_param("si",$poll_question,$q_id); // binds variables to be sent with query
        $stmt->execute();

        $sql =  "UPDATE polls SET Question = ? WHERE Question_id = ?";
        $stmt = $dbConnection->prepare($sql); // sends query to the database
        $stmt->bind_param("si",$poll_question,$q_id); // binds variables to be sent with query
        $stmt->execute();
        $todo[1] = $poll_question;
    }else if(empty($_POST['poll_question'])){
        echo "<div class='bg-danger'>Your Poll Question is blank, can't have a blank question</div>";
    }
 
