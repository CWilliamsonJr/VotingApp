<?php
  function LogMeIn($username,$password){

  }
  function Redirect($where){
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = $where;
    header("Location: http://$host$uri/$extra");
  }
 ?>
