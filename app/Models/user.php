//use pdo database connection to interact with the database
//use password hashing for secure password storage
//use supperglobal (array=session) to store information
//$_SESSION is a superglobal array used to store information.
//PDO FETCH_ASSOC tells PDO to return query results as an associative array, where column names are the array keys.



<?php
require_once __DIR__ . '/../config/database.php';
class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $email;
    public $password;
    

    //constructor accept pdo connection
    //This constructor initializes the User object with a database connection.
    public function __construct($db) {
        $this->conn = $db;
    }
    

    //register a new user
    public function register() {
        $query = "INSERT INTO " . $this->table . " 
                  SET username = :username, email = :email, password = :password";

        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    //login user

    public function login() {
        $query = "SELECT id, username, password FROM " . $this->table . " 
                  WHERE username = :username LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                return true;
            }
        }
        return false;
    }
    

    //matching exist user name in database
    public function usernameExists() {
        $query = "SELECT id FROM " . $this->table . " 
                  WHERE username = :username LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $this->username = htmlspecialchars(strip_tags($this->username));
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    

    //email
    public function emailExists() {
        $query = "SELECT id FROM " . $this->table . " 
                  WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
?>