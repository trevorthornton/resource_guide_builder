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


  function get_record_by_attribute($table, $attribute, $value) {
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
          $q_select .= ", sources.$field";
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


  // function concat_filters($table, $filters) {
  //   $q_where_parts = [];
  //   foreach ($filters as $key => $value) {
  //     $q_where_parts[] = "$key = $value";
  //   }
  //   $q_where .= 'WHERE ' . implode(' AND ', $q_where_parts);
  // }

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

    // Get n-to-n associations
    $association_queries = [
      'subjects' => "SELECT rs.resource_id, s.*
        FROM resources_subjects rs
        JOIN subjects s on rs.subject_id = s.id
        WHERE rs.resource_id IN ($id_list)
        ORDER BY rs.resource_id",
      'creators' => "SELECT rc.resource_id, c.*
        FROM resources_creators rc
        JOIN creators c on rc.creator_id = c.id
        WHERE rc.resource_id IN ($id_list)
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
      'sources' => ['slug'],
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
        'source_id' => 'integer',
        'resource_type_id' => 'integer',
        'isbn' => 'string',
        'issn' => 'string'
      ],
      'creators' => [
        'name' => 'string'
      ],
      'sources' => [],
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