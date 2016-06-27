<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard for <?php echo $_COOKIE['user_name'] ?> Polls </title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="./styles/style.css">
  <?php
    require './includes/includes.inc';
   ?>
</head>

<body>
  <div class='jumbotron'>
    <div class='container'>
      <div class='h1'>Dashboard</div>
    </div>
  </div>
  <?php
    $logged_in = $_COOKIE['logged_in'];
    if($logged_in === 'yes'){
      $username = $_COOKIE['user_name'];
      if(isset($_POST['ViewOrEdit'])){
        $todo = explode('_',$_POST['ViewOrEdit']);
        if($todo[0] === 'Edit'){
          require './includes/edit.inc';
        }
      }else{
        require  './includes/loggedinSite.inc';
      }
    }else{
      Redirect('index.php');
    }
   ?>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" ></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>
</body>
</html>
