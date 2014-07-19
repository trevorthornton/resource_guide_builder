<?php
  
  include 'db_connect.php';

  function get_record_by_id($table, $id) {
    $id = intval($id);
    $query = "SELECT * FROM $table WHERE id = $id LIMIT 1";
    $connection = db_connection();
    if ($result = $connection->query($query)) {
      /* fetch associative array */
      $row = $result->fetch_assoc();
      /* free result set */
      $result->free();
    }
    mysqli_close($connection);
    return $row;
  }


  function get_records($table, $options=[], $connection=null) {
    
    if (!$connection) {
      $connection = db_connection();
    }

    // SELECT
    $q_select = "SELECT * FROM $table";

    // LIMIT
    $offset = isset($options['offset']) ? intval($options['offset']) : 0;
    $limit = isset($options['limit']) ? intval($options['limit']) : 1000;
    $q_limit = "LIMIT $offset,$limit";

    // WHERE
    $q_where = '';
    if (isset($options['where'])) {
      $q_where_parts = [];
      foreach ($options['where'] as $key => $value) {
        $q_where_parts[] = "$key = $value";
      }
      $q_where .= 'WHERE ' . implode(' AND ', $q_where_parts);
    }

    // ORDER BY
    $q_order = '';
    if (isset($options['order'])) {
      $q_order = "ORDER BY " . $options['order'];
    }

    $q_clauses = [$q_select, $q_where, $q_order, $q_limit];
    $query = implode(' ', $q_clauses);

    $records = [];

    if ($result = execute_query($query, $connection)) {
      while ($row = $result->fetch_assoc()) {
        $records[$row['id']] = $row;
      }
      $result->free();
    }

    return $records;
  }


  function execute_query($query, $connection=null) {
    if (!$connection) {
      $connection = db_connection();
    }
    $result = $connection->query($query);
    
    return $result;
  }


  // Get resources + associated records
  function get_resources($options=[], $connection=null) {
    
    if (!$connection) {
      $connection = db_connection();
    }
    
    $resources = get_records('resources', $options, $connection);
    
    $resource_ids = [];
    foreach ($resources as $r) {
      $resource_ids[] = $r['id'];
    }
    $id_list = implode(',',$resource_ids);

    // Get subjects
    $subject_query = "SELECT rs.resource_id, s.*
      FROM resources_subjects rs
      JOIN subjects s on rs.subject_id = s.id
      WHERE rs.resource_id IN ($id_list)
      ORDER BY rs.resource_id";
    if ($subject_result = execute_query($subject_query, $connection)) {
      while ($row = $subject_result->fetch_assoc()) {
        $subject = $row;
        $resource_id = array_shift($subject);

        if (!isset($resources[$resource_id]['subjects'])) {
          $resources[$resource_id]['subjects'] = [];
        }
        $resources[$resource_id]['subjects'][] = $subject;
      }
      $subject_result->free();
    }
    mysqli_close($connection);
    return $resources;
  }


  function create_resource($attributes) {
    $result = insert_record('resources', $attributes);
    return $result;
  }


  function insert_record($table, $attributes) {
    $connection = db_connection();
    $attributes = clean_attributes($table, $attributes, $connection);
    $fields = array_keys($attributes);
    $query = "INSERT INTO $table (" . implode(',',$fields) . ") VALUES (";

    // Build values list
    $field_types = valid_attributes($table);
    $last = end($attributes);
    foreach ($attributes as $key => $value) {
      if ($field_types[$key] == 'string') {
        $query .= "'$value'";
      }
      else {
        $query .= $value;
      }
      $query .= ($value != $last) ? ',' : '';
    }
    $query .= ")";
    
    // Execute query
    $result = $connection->query($query);    
    mysqli_close($connection);
    return $result;
  }


  // Helpers

  function verify_unique($table,$attributes) {
    $unique_attributes = [
      'resources' => ['url','isbn','issn'],
      'subjects' => ['slug'],
      'publishers' => ['slug'],
      'creators' => ['slug']
    ];
  }


  function check_slug($attributes) {
    if (empty($attributes['slug'])) {
      $attributes['slug'] = slugify($attributes['label']);
    }
    else {
      $attributes['slug'] = slugify($attributes['slug']);
    }
    return $attributes;
  }


  function slugify($string) {
    $slug = strtolower($string);
    $slug = preg_replace('/[\s\-\_]/', '_', $slug);
    $slug = preg_replace('/[^\w\_]/', '', $slug);
    return $slug;
  }


  function valid_attributes($table) {
    $attributes = [
      'resources' => [
        'title' => 'string',
        'url' => 'string',
        'description' => 'string',
        'publisher_id' => 'integer',
        'resource_type_id' => 'integer',
        'isbn' => 'string',
        'issn' => 'string'
      ],
      'creators' => [
        'name' => 'string'
      ],
      'publishers' => [],
      'subjects' => [
        'label' => 'string',
        'wikipedia_uri' => 'string',
        'slug' => 'string'
      ],
      'resource_types' => []
    ];
    return $attributes[$table];
  }


  function clean_attributes($table, $attributes, $connection) {
    $clean_attributes = [];
    $valid_attributes = valid_attributes($table);
    foreach ($attributes as $key => $value) {
      if (empty($value)) {
        continue;
      }
      elseif (!in_array($key, array_keys( $valid_attributes ))) {
        continue;
      }
      else {
        if ($valid_attributes[$key] == 'string') {
          $new_val = $connection->real_escape_string($value);
          $clean_attributes[$key] = $new_val;
        }
        else {
          $clean_attributes[$key] = intval($value);
        }
      }
    }
    return $clean_attributes;
  }




  // class Resource
  // {

  //   public function save(attributes) {

  //   }

  //   public function delete() {

  //   }
  // }





?>