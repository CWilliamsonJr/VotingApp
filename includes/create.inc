<?php
$sql = "INSERT INTO votingapp.questions (ID, User_name, Question) VALUES (NULL, ?, ?)";
$stmt = $dbConnection->prepare($sql);
$stmt->bind_param("ss", $_SESSION['uName'], $_POST['poll_question']);
$stmt->execute();
$worked = $stmt->affected_rows;
$qID = $stmt->insert_id;

if(!empty($worked)){
    $uID = $_SESSION['uId'];
    $question = $_POST['poll_question'];
    $value;
    $sql = "INSERT INTO polls (`ID`, `Choice`, `Chosen`, `User_created_id`, `Question_id`, `Question`) VALUES (NULL, ? , '0', ?, ?, ?)";
    $stmt = $dbConnection->prepare($sql);
    $stmt->bind_param("siis",$value,$uID, $qID ,$question);
    foreach($_POST['poll_option'] as $key => $choice){
        $value = $choice;
        $stmt->execute();
    }
    $todo[1] = $question;
}
