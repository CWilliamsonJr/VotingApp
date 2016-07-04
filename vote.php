<?php
//TODO: AJAX Call for Google charts
//TODO: App redo with using functions instead of inc
require_once 'includes/includes.inc.php';

$path = $_SERVER['REQUEST_URI'];
$path = ltrim($path, '/');
$request = explode('/', $path);
$alerts = '&nbsp;';

if(!empty($_POST['Vote'])){
    $user = urldecode($request[2]);
    $question = urldecode($request[3]);
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $vote = $_POST['Vote'];
//*
    $sql = "INSERT INTO voted SET `ip_address` = ?, `user` = ?, `question` = ?, `answer` = ? ";
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("ssss",$ip_address,$user, $question,$vote); // binds variables to be sent with query
    $stmt->execute(); // sends query
    $worked = $stmt->affected_rows;
//*/

    if(!empty($worked) && $worked > 0){
        $sql = "UPDATE polls JOIN users SET polls.Chosen = polls.Chosen + 1 WHERE polls.User_created_id = users.user_id AND polls.Choice = ? AND polls.Question = ? AND users.user_name = ?";
        $stmt = $dbConnection->prepare($sql); // sends query to the database
        $stmt->bind_param("sss",$vote, $question,$user); // binds variables to be sent with query
        $stmt->execute(); // sends query
        $worked = $stmt->affected_rows;
        if(!empty($worked) && $worked > 0){
            $alerts = "<div class='alert alert-success'>Your vote has been successfully submitted</div>";
        }
    } else{
        $prevVote;

        $sql = "SELECT answer FROM voted WHERE `ip_address` = ? AND `user` = ? AND `question` = ?"; // Gets previous Answer
        $stmt = $dbConnection->prepare($sql); // sends query to the database
        $stmt->bind_param("sss",$ip_address,$user, $question); // binds variables to be sent with query
        $stmt->execute(); // sends query
        $query = $stmt->get_result();
        $array = $query->fetch_assoc();

        $prevVote = $array['answer'];

        $sql = "UPDATE voted SET `answer` = ?  WHERE `ip_address` = ? AND `user` = ? AND `question` = ? "; // sets new answer
        $stmt = $dbConnection->prepare($sql); // sends query to the database
        $stmt->bind_param("ssss",$vote ,$ip_address,$user, $question); // binds variables to be sent with query
        $stmt->execute(); // sends query
        $worked = $stmt->affected_rows;

        $sql = "UPDATE polls JOIN users SET polls.Chosen = polls.Chosen - 1 WHERE polls.User_created_id = users.user_id AND polls.Choice =? AND polls.Question = ? AND users.user_name = ?"; // rolls back previous option
        $stmt = $dbConnection->prepare($sql); // sends query to the database
        $stmt->bind_param("sss",$prevVote, $question,$user); // binds variables to be sent with query
        $stmt->execute(); // sends query

        $sql = "UPDATE polls JOIN users SET polls.Chosen = polls.Chosen + 1 WHERE polls.User_created_id = users.user_id AND polls.Choice =? AND polls.Question = ? AND users.user_name = ?"; // sets new option
        $stmt = $dbConnection->prepare($sql); // sends query to the database
        $stmt->bind_param("sss",$vote, $question,$user); // binds variables to be sent with query
        $stmt->execute(); // sends query

        $alerts =  "<div class='alert alert-warning'>Your vote has been successfully changed</div>";
    }
}

if(!empty($request[3])){
    $request[3] = urldecode($request[3]);
    $sql = "SELECT Choice,Chosen FROM polls JOIN users WHERE polls.User_created_id = users.user_id  AND polls.Question = ? AND users.user_name = ?"; // retrieves user name from the database
    $stmt = $dbConnection->prepare($sql); // sends query to the database
    $stmt->bind_param("ss", $request[3], $request[2]); // binds variables to be sent with query
    $stmt->execute(); // sends query
    $query = $stmt->get_result();
    $array = $query->fetch_all(MYSQLI_ASSOC);

    $totalVotes = 0;
    $rows = array(); // used to store th data
    $table = array(); // will hold the data and the labels
    $table['cols'] = array(  // sets the data type and label for the table
        array('id' => 'Option', 'label' => 'Choice', 'type' => 'string'),
        array('id' => 'Chosen', 'label' => 'Votes', 'type' => 'number')
    );

    foreach($array as $key => $results) { // loops through the query
        $totalVotes += (int)$results['Chosen'];
        $temp = array();
        $temp[] = array('v' => (string)$results['Choice']); // poll option
        $temp[] = array('v' => (int)$results['Chosen']); // poll votes
        $rows[] = array('c' => $temp);
    }
    $table['rows'] = $rows;
    $jsonTable = json_encode($table);
    $i = 1;
    $polls = '';
    foreach($array as $key => $results){
        $polls .= '<li class="polls poll-vote input-width">
                         <div class="input-width poll-choices">
                            <label class="radio-inline">                                 
                                <input type="radio" name="Vote" id="optionsRadios' . $i++ . '" value="' . $results['Choice'] . '"> 
                                <span class="h4 text-left"><strong>' . $results['Choice'] . '</strong> </span>
                            </label>                                 
                      </div>
                   </li>
                   <br/>';
    }

    $html = <<< HTML
<!doctype html>

<html lang="en">
<!--Load the AJAX API-->
<head>    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/VotingApp/styles/style.css">
     
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        var url = document.getElementsByTagName('a')[0];
        
        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages': ['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart(){

            // Create the data table.
            var data = new google.visualization.DataTable($jsonTable);


            // Set chart options
            var options = {
                title: '$request[3] Total Votes: $totalVotes',               
                legend: {position: "tv"},
                height: 600,
                width:1000
            };
            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="">
            <div class="navbar-brand">Voting Poll Web App</div>
            <ul class="nav navbar-nav navbar-right margin_right">
                <li><button class="btn btn-default navbar-btn margin_right"><a href="../../createaccount.php" role="button"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Create Account</a></button></li>
                <li><button class="btn btn-default navbar-btn"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;<a href="../../dashboard.php">Sign in </a><button</li>
            </ul>
        </div>
    </div>
</nav>
<div class='jumbotron'>
    <div class='container'>
        <div class='h1'>Welcome</div>
    </div>
</div>
  <div class='container'>
    <div class='row col-sm-12'>
        $alerts
        <div class="col-sm-4 margin-top-4">
            <form method="post" action="">          
                <ul>
                    $polls
                </ul>
                <button type="submit" class="btn btn-primary input-width btn-block text-left">Submit vote</button>
            </form>
        </div>
                
        <div class="col-sm-8">
        <!--Div that will hold the pie chart-->
            <div id="chart_div"></div>
        </div>
    </div>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" ></script>
      <script async src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>
      <script src="/VotingApp/scripts/index.js"></script>
</body>
</html>
HTML;
    echo $html;

}






