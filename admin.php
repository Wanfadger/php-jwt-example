<?php
require_once 'database/Database.php';
class Admin  
{

    private $id;
    public $name;
    public $email;
    public $password;
    public $createdAt;
    public $updatedAt;//date("Y-m-d h:i:s a" , time())

    private $tableName;
    public function __construct(){
        $this -> tableName = "admins";
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of updatedAt
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */ 
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    private function sanitize($data){
        return htmlspecialchars(strip_tags($data));
    }

    function createAdmin($admin){
    $sql = "INSERT INTO admins SET name=:name , email=:email , password=:password";
    
    // //sanitize values
    // $name = htmlspecialchars(strip_tags($admin -> getName()));
    // $password = htmlspecialchars(strip_tags($admin -> getPassWord()));
    // $email = htmlspecialchars(strip_tags($admin -> getEmail()));

    try {
        $stmt = Database::createDatabaseInstance()  -> getConnection() -> prepare($sql);
        //bind value
        $stmt -> bindValue(":name" , $this -> sanitize($admin -> getName()));
        $stmt -> bindValue(":email" , $this -> sanitize($admin -> getEmail()));
        $stmt -> bindValue(":password" ,password_hash($this -> sanitize($admin -> getPassword()) , PASSWORD_BCRYPT) );
   
        return ($stmt -> execute()) ? true : false;
   
    } catch (\Throwable $th) {
        echo $th -> getMessage();
    }
      
    }


    function emailExists($email){
        $sql = "SELECT * FROM admins WHERE (email=:email) LIMIT 0,1";

        $stmt = Database::createDatabaseInstance() -> getConnection() -> prepare($sql);
         //bind
        $stmt -> bindValue(":email" , $this -> sanitize($email));
        $stmt -> execute();
        $dbRow = $stmt -> fetch(PDO::FETCH_ASSOC);

        return (null != $dbRow) ? true : false;
    }


    function fetchAdminByEmail($email){
        $sql = "SELECT * FROM admins WHERE (email=:email) LIMIT 0,1";

        $stmt = Database::createDatabaseInstance() -> getConnection() -> prepare($sql);
         //bind
        $stmt -> bindValue(":email" , $this -> sanitize($email));
        $stmt -> execute();
        $dbRow = $stmt -> fetch(PDO::FETCH_ASSOC);

        return  $dbRow;
    }


    function updateAdmin($admin){
        $sql = "UPDATE admins SET updated_at =:updatedAt ,";        
        
        $sql = (null != $admin -> getPassword()) ? $sql."password=:password , ": $sql;
        $sql = (null != $admin -> getName()) ? $sql." name=:name , ": $sql;
        $sql = (null != $admin -> getEmail()) ? $sql." email=:email ": $sql;
         
        $sql =  $sql."WHERE (id=:id)";
        // //sanitize values
        $name = htmlspecialchars(strip_tags($admin -> getName()));
        $password = htmlspecialchars(strip_tags($admin -> getPassWord()));
        $email = htmlspecialchars(strip_tags($admin -> getEmail()));
    
        try {
            $stmt = Database::createDatabaseInstance()  -> getConnection() -> prepare($sql);
            //bind value
            $stmt -> bindValue(":id" , $admin -> getId());
            $stmt -> bindValue(":name" , $this -> sanitize($admin -> getName()));
            $stmt -> bindValue(":email" , $this -> sanitize($admin -> getEmail()));
            $stmt -> bindValue(":password" ,password_hash($this -> sanitize($admin -> getPassword()) , PASSWORD_BCRYPT) );
            $stmt -> bindValue(":updatedAt" , date("Y-m-d h:i:s" , time()));
            
            return ($stmt -> execute()) ? true : false;
       
        } catch (\Throwable $th) {
            echo $th -> getMessage();
        }
          
         }
    
    
}



?>