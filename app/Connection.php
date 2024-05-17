<?php
namespace app;

use app\Config;

// Class for database connection.
class Connection {
  public $db_conn;

  // Constructor method.
  public function __construct() {
    // Creating new object of Config class.
    new Config();
  }
  public function connect() {
    // Establishing database connection.
    $this->db_conn = new \mysqli(HOSTNAME, USERNAME, PASSWORD, DBNAME);

    //If connection is not established, return the error.
    if ($this->db_conn->connect_error) {
      die("ERROR: Could not connect. "
        . $this->db_conn->connect_error);
    } else {
      return $this->db_conn;
    }
  }
}
