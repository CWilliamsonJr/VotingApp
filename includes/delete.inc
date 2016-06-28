<?php
  $count = count($_SESSION['current_poll']);

  echo 'var_dump for post on delete.inc';
  var_dump($_POST);




  $sql = "DELETE FROM polls WHERE ID = ?";

  $stmt = $dbConnection->prepare($sql); // sends query to the database
  $stmt->bind_param("ss",$id,$choice); // binds variables to be sent with query



  }
//*/

 ?>
