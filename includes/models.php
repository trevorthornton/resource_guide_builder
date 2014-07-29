<?php
  
  function get_record_by_id($table, $id) {
    $valid_attributes = valid_attributes($table);

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


  # ONLY WORKS FOR STRINGS NOW - FIX IT
  function get_record_by_attribute($table, $attribute, $value) {
    $query = "SELECT * FROM $table WHERE $attribute = '$value' LIMIT 1";
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


  function update_record($table, $id, $attributes, $connection=null) {
    if (!$connection) {
      $connection = db_connection();
    }
    $attributes = clean_attributes($table, $attributes, $connection);
    $fields = array_keys($attributes);
    $query = "UPDATE $table SET ";

    // Build values list
    $field_types = valid_attributes($table);
    $last = end($attributes);
    foreach ($attributes as $key => $value) {
      if ($field_types[$key] == 'string') {
        $query .= "$key = '$value'";
      }
      else {
        $query .= "$key = '$value'";
      }
      $query .= ($value != $last) ? ',' : '';
    }
    $query .= " WHERE id=$id";
    
    // Execute query
    $result = $connection->query($query);    
    mysqli_close($connection);
    return $result;
  }


  function get_records($table, $options=[], $connection=null) {
    
    if (!$connection) {
      $connection = db_connection();
    }

    $fields = array_keys(valid_attributes($table));

    // SELECT
    $q_select = "SELECT $table.id";
    foreach ($fields as $field) {
      $q_select .= ", $table.$field AS $field";
    }

    $q_from = "FROM $table";

    // ADD JOINS FOR n-TO-1 ASSOCIATIONS
    $q_join = '';
    switch ($table) {
      case 'resources':
        $q_join = 'LEFT JOIN sources on resources.source_id = sources.id';
        $source_fields = array_keys(valid_attributes('sources'));
        foreach ($source_fields as $field) {
          $q_select .= ", sources.$field AS source_$field";
        }
    }
    

    // LIMIT
    $offset = isset($options['offset']) ? intval($options['offset']) : 0;
    $limit = isset($options['limit']) ? intval($options['limit']) : 1000;
    $q_limit = "LIMIT $offset,$limit";

    // WHERE
    $q_where = '';
    if (isset($options['where'])) {
      $q_where .= 'WHERE ' . $options['where'];
    }

    // ORDER BY
    $q_order = '';
    if (isset($options['order'])) {
      $q_order = "ORDER BY " . $options['order'];
    }

    $q_clauses = [$q_select, $q_from, $q_join, $q_where, $q_order, $q_limit];
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


  function resource_subject_ids($resource_id, $connection=null) {
    $query = "SELECT subject_id FROM resources_subjects WHERE resource_id = $resource_id";
    $result = execute_query($query, $connection);
    $subject_ids = [];
    foreach ($result as $row) {
      $subject_ids[] = intval($row['subject_id']);
    }
    return $subject_ids;
  }


  function remove_resource_subjects($resource_id, $subject_ids, $connection=null) {
    $query = "DELETE FROM resources_subjects WHERE resource_id = $resource_id AND subject_id IN (";
    $query .= implode(',',$subject_ids) . ')';
    return execute_query($query, $connection);
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

    // Get n-to-n associations
    $association_queries = [
      'subjects' => "SELECT rs.resource_id, s.*
        FROM resources_subjects rs
        JOIN subjects s on rs.subject_id = s.id
        WHERE rs.resource_id IN ($id_list)
        ORDER BY rs.resource_id"
    ];
    
    foreach ($association_queries AS $table => $query) {

      if ($result = execute_query($query, $connection)) {
        while ($row = $result->fetch_assoc()) {
          $record = $row;
          $resource_id = array_shift($record);
          if (!isset($resources[$resource_id][$table])) {
            $resources[$resource_id][$table] = [];
          }
          $resources[$resource_id][$table][] = $record;
        }
        $result->free();
      }

    }

    mysqli_close($connection);
    return $resources;
  }


  function create_resource($attributes) {
    $result = insert_record('resources', $attributes);
    return $result;
  }


  // Helpers
  function verify_unique($table,$attributes) {
    $existing = get_record_by_attribute($table, 'slug', $attributes['slug']);
    return (is_null($existing)) ? TRUE : FALSE;
  }


  function check_slug($attributes) {
    if (empty($attributes['slug'])) {
      if (isset($attributes['label'])) {
        $attributes['slug'] = slugify($attributes['label']);
      }
      elseif (isset($attributes['title'])) {
        $attributes['slug'] = slugify($attributes['title']);
      }
      elseif (isset($attributes['name'])) {
        $attributes['slug'] = slugify($attributes['name']);
      }
    }
    else {
      $attributes['slug'] = slugify($attributes['slug']);
    }
    return $attributes;
  }


  function slugify($string) {
    $slug = strtolower($string);
    $slug = preg_replace('/[\s\-\_]/', '_', $slug);
    $slug = preg_replace('/[^A-Za-z0-9_]/', '', $slug);
    return $slug;
  }


  function valid_attributes($table) {
    $attributes = [
      'resources' => [
        'title' => 'string',
        'url' => 'string',
        'creator' => 'string',
        'description' => 'string',
        'publication_info' => 'string',
        'source_id' => 'integer',
        'resource_type_id' => 'integer',
        'slug' => 'string'
      ],
      'sources' => [
        'title' => 'string',
        'url' => 'string',
        'description' => 'string',
        'slug' => 'string'
      ],
      'subjects' => [
        'label' => 'string',
        'wikipedia_uri' => 'string',
        'slug' => 'string'
      ],
      'resource_types' => [
        'label' => 'string',
        'description' => 'string',
        'slug' => 'string'
      ],
      'resources_subjects' => [
        'resource_id' => 'integer',
        'subject_id' => 'integer'
      ]
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
        $clean_attributes[$key] = clean_attribute_value($value, $valid_attributes[$key], $connection);
        // if ($valid_attributes[$key] == 'string') {
        //   $new_val = $connection->real_escape_string($value);
        //   $clean_attributes[$key] = $new_val;
        // }
        // else {
        //   $clean_attributes[$key] = intval($value);
        // }
      }
    }
    return $clean_attributes;
  }


  function clean_attribute_value($value, $type, $connection) {
    if ($type == 'string') {
      $new_val = $connection->real_escape_string($value);
    }
    else {
      $new_val = intval($value);
    }
    return $new_val;
  }


  // class Resource
  // {

  //   public function save(attributes) {

  //   }

  //   public function delete() {

  //   }
  // }





?>