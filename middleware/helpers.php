<?php

function csrf_tag(){
  $token = $_SESSION["token"];
  echo "<input type='hidden' name='csrf_token' value='{$token}'>";
}

function csrf_token(){
  return $_SESSION["token"];
}