<?php

  $sql = "DELETE FROM polls WHERE ID = ?";
  $stmt = $dbConnection->prepare($sql); // sends query to the database
  $stmt->bind_param("i",$delete); // binds variables to be sent with query
  $stmt->execute(); // sends query
//*/

 ?>