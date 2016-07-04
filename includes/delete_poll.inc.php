<?php

$task = explode('_', $_POST['Task']);

$sql = "DELETE a.*, b.*, c.* FROM polls as a, questions as b, voted as c INNER JOIN polls, voted WHERE a.question = b.question AND c.user = b.User_name AND a.Question = ? AND a.User_created_id = ?";
$stmt = $dbConnection->prepare($sql); // sends query to the database
$stmt->bind_param("si",$task[1],$_SESSION['uId']); // binds variables to be sent with query
$stmt->execute(); // sends query

