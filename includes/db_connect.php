<?php

  // Include config file, which should be located somewhere safe
  include '/Users/trthorn2/webapps/tt/config/epcot_history_config.php';

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
