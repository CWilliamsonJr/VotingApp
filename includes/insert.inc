<?php
// INSERT INTO `votingapp`.`polls` (`ID`, `Choice`, `Chosen`, `User_created_id`, `Question_id`, `Question`) VALUES (NULL, 'Going to the movies', '0', '2', '12', 'What is your favorite activity?')
$sql = "INSERT INTO polls (`ID`, `Choice`, `Chosen`, `User_created_id`, `Question_id`, `Question`) VALUES (NULL, ? , '0', ?, ?, ?)";
$question = explode('_', $_POST['Task']);
$bind_type = 'siis';

$stmt = $dbConnection->prepare($sql); // sends query to the database
$stmt->bind_param("siis",$_POST['option'],$_SESSION['user_id'],$_SESSION['q_id'],$question[1]); // binds variables to be sent with query
$stmt->execute(); // sends query


?>