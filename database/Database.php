<?php
class Database
{
    // specify your own database credentials
    private $host = "";//host
    private $db_name = "";//replace with your database name
    private $username = "";//put your username
    private $password =  "";//password;
    
    private static $databaseInstance = null;
    
    
    public static function  createDatabaseInstance(){
        if ( null == self::$databaseInstance) {
          self::$databaseInstance = new Database();
      }
      return self::$databaseInstance;   
    }
 
    
    // get the database connection
    public function getConnection(){
        
        try{
            $conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $conn -> setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
            $conn -> exec("set names utf8");

        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        
        return $conn;
    }
    
    //kill database connection
    public function disconnect($conn){
        if (null!= $conn) {
            $conn = null;
        }
    }


}

