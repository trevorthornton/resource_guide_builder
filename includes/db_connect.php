<?php

  function db_connection() {
    
    global $db_host, $db_user, $db_password, $db_name;

    // Create connection
    $mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

    // Check connection
    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    }
    else {
      return $mysqli;
    }
  }

?>
