<?php
if(!empty($_POST['option'])){

    $sql = "INSERT INTO polls (`ID`, `Choice`, `Chosen`, `User_created_id`, `Question_id`, `Question`) VALUES (NULL, ? , '0', ?, ?, ?)";
    $question = explode('_', $_POST['Task']);


    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("siis",$_POST['option'],$_SESSION['user_id'],$_SESSION['q_id'],$question[1]); // binds variables to be sent with query
    $stmt->execute(); // sends query
}else{
    echo "<div class='alert alert-danger'>You can't enter a blank option</div>";
}

