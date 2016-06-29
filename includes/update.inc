<?php
    foreach($_POST as $key => $value){
      $delete; // stores the ID that holds the row to delete
      if(!empty($value)){
        $post[$key] = $value;
      }else{ // contains the empty string to be deleted
        foreach ($_SESSION as $choice => $ID) { // loops through the values in _SESSION
        $emptyVal =   preg_replace('/\.|\s/', '_', $choice);  // converts periods and spaces to _

        if(strcmp($key,$choice) === 0){  // looks for the corresponding key
            $delete = $ID;  // sets delete to the correct ID.
            unset($_SESSION[$choice]);
            require 'delete.inc';
          }
        }

      }

    }

    $sql = "UPDATE polls SET Choice = ? WHERE ID = ?";
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("si",$choice,$id); // binds variables to be sent with query

    foreach ($_SESSION as $key => $value){
        $update =   preg_replace('/\.|\s/', '_', $key);
        $choice = $_POST[$update];
        $id = $value;
        $stmt->execute(); // sends query
        if (!$stmt->execute()) {
            echo "Update failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }




    // $stmt = $dbConnection->prepare($sql); // sends query to the database
    // $stmt->bind_param("ss",$id,$choice); // binds variables to be sent with query
    // $stmt->execute(); // sends query
    //echo $stmt->affected_rows;
/*
    if($stmt === false) {
      trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    //*/

 ?>
