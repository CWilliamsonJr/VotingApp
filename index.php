<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Create your Poll</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="./styles/style.css">
</head>
<body>
  <div class='container'>
    <div class='row'>
      <div><span class='h1'>Log in to start making polls</span></div>
        <form action='./logincheck.php' method="post">
          <div class="form-group">
           <label for="user_name">User Name:</label>
           <input name='user_name' type="text" class="form-control input_width" id="user_name" placeholder="User Name" required>
          </div>
         <div class="form-group">
           <label for="user_password">Password</label>
           <input name='user_password' type="password" class="form-control input_width" id="user_password" placeholder="Password" required>
         </div>
         <button type="submit" class="btn btn-primary">Log In</button>
      </form>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" ></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>
</body>
</html>
