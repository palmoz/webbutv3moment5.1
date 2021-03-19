<?php 
//* Skapad av Emil palm, empa1600

//* Databas devmode

$devmode = true; // True om publicering

if ($devmode) {
  define('DB_HOST', "studentmysql.miun.se");
  define('DB_USER', "emilpalm94");
  define('DB_PASSWORD', "d5eryuoc"); 
  define('DB_NAME', "emilpalm94");   
} // Vid lokalhost:
else {
  define('DB_HOST', "localhost");
  define('DB_USER', "courses");
  define('DB_PASSWORD', "password");
  define('DB_NAME', "courses");   
}

//* Klass för Databas:

class Database{
  
  public $db;  

  public function connect() {
      $this->db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); // Variabler från ovan
      $this->db->connect_errno > 0 ? die('Fel vid databasanslutning[' . $db->connect_error . ']') : null;
      return $this->db; 
    }

  public function close() { // Stäng databas
    $this->db->close();
  }
}






?>