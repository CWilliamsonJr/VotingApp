<?php

$task = explode('_', $_POST['Task']);

$sql = "DELETE a.*, b.* FROM polls as a, questions as b INNER JOIN polls WHERE a.question = b.question  AND a.Question = ? AND a.User_created_id = ?";
$stmt = $dbConnection->prepare($sql); // sends query to the database
$stmt->bind_param("si",$task[1],$_SESSION['uId']); // binds variables to be sent with query
$stmt->execute(); // sends query

