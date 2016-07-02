<?php
  

  function Redirect($where){
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = $where;
    header("Location: http://$host$uri/$extra");
  }
  function dump($var,$name = ''){
      $loc = $_SERVER['PHP_SELF'];
      echo "var_dump for $name at $loc ";
      var_dump($var);
  }
 ?>
