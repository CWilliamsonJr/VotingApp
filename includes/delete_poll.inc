<?php
dump($_SESSION,"SESSION");
dump($_POST,'POST');
$task = explode('_', $_POST['Task']);

$sql = "DELETE FROM polls WHERE Question = ? AND User_created_id = ?";
$stmt = $dbConnection->prepare($sql); // sends query to the database
$stmt->bind_param("si",$task[1],$_SESSION['uId']); // binds variables to be sent with query
$stmt->execute(); // sends query

$sql = "DELETE FROM questions WHERE Question = ? AND User_name = ?";
$stmt = $dbConnection->prepare($sql); // sends query to the database
$stmt->bind_param("ss",$task[1],$_SESSION['uName']); // binds variables to be sent with query
$stmt->execute(); // sends query