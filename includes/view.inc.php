<?php


$user_id = $_SESSION['uId'];
$question = explode('_', $_POST['Task']); // Checks to see what you are trying to do


$sql = "SELECT Choice,Chosen FROM polls WHERE User_created_id = ? AND Question = ? "; // retrieves user name from the database
$stmt = $dbConnection->prepare($sql); // sends query to the database
$stmt->bind_param("is", $user_id, $question[1]); // binds variables to be sent with query
$stmt->execute(); // sends query
$query = $stmt->get_result();
$array = $query->fetch_all(MYSQLI_ASSOC);

$totalVotes = 0;
$rows = array();
$table = array();
$table['cols'] = array(  // sets the data type and label for the table
    array('id' => 'Option', 'label' => 'Choice', 'type' => 'string'),
    array('id' => 'Chosen', 'label' => 'Votes', 'type' => 'number')
);

foreach($array as $key => $r) {
    $totalVotes += (int)$r['Chosen'];
    $temp = array();
    $temp[] = array('v' => (string)$r['Choice']);
    $temp[] = array('v' => (int)$r['Chosen']);
    $rows[] = array('c' => $temp);
}
$table['rows'] = $rows;
$tableType = 'BarChart';
$jsonTable = json_encode($table);


$html = <<< HTML
   <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {

            // Create the data table.
            var data = new google.visualization.DataTable($jsonTable);
         

            // Set chart options
            var options = {                
                title: '$question[1] Total Votes: $totalVotes',                     
                bars: 'hor',
                legend: { position: "none" },                
                height: 600
            };
            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
  
<!--Div that will hold the pie chart-->
<div id="chart_div"></div>

HTML;
echo $html;



