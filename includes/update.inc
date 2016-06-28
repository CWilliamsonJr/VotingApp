<?php
  $count = count($_SESSION['current_poll']);
  $update = '';
  $updateArray = $_SESSION['current_poll'];

  $sql = "UPDATE polls SET Choice = ? WHERE ID = ?";

  $stmt = $dbConnection->prepare($sql); // sends query to the database
  $stmt->bind_param("ss",$id,$choice); // binds variables to be sent with query

  foreach($_POST as $key => $value){
      $post[$key] = $value;
  }


//*
  for ($i = 0; $i < $count; $i++) {
    $temp = preg_replace('/\.|\s/', '_', $_SESSION['current_poll'][$i]['Choice']);
    $choice = $post[$temp];

    $id =  $_SESSION['current_poll'][$i]['ID'];


    // $stmt = $dbConnection->prepare($sql); // sends query to the database
    // $stmt->bind_param("ss",$id,$choice); // binds variables to be sent with query
    // $stmt->execute(); // sends query
    //echo $stmt->affected_rows;

    if($stmt === false) {
      trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
    }

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

  }
//*/

 ?>
