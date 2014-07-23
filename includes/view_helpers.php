<?php

function head_title() {
  global $project_name, $page_title;
  $title = $project_name;
  if (isset($admin)) {
    $title .= ' | Admin';
  }
  if ($page_title) {
    $title .= " | $page_title";
  }
  return $title;
}



?>