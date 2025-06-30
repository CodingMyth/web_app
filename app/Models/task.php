<?php
class Task {
    private $conn;
    private $table = 'tasks';

    public $id;
    public $user_id;
    public $title;
    public $description;
    public $priority;
    public $due_date;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    //get data from current user
    public function read() {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE user_id = :user_id 
                  ORDER BY 
                    CASE priority 
                        WHEN 'high' THEN 1 
                        WHEN 'medium' THEN 2 
                        WHEN 'low' THEN 3 
                    END, due_date ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();

        return $stmt;
    }



    //Retrieves tasks for the current user filtered by a specific priority, ordered by due date.
    public function readByPriority($priority) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE user_id = :user_id AND priority = :priority 
                  ORDER BY due_date ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':priority', $priority);
        $stmt->execute();

        return $stmt;
    }


    //Inserts a new task into the database for the current user.
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET user_id = :user_id, title = :title, description = :description, 
                      priority = :priority, due_date = :due_date, status = 'pending'";

        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->priority = htmlspecialchars(strip_tags($this->priority));
        $this->due_date = htmlspecialchars(strip_tags($this->due_date));

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':priority', $this->priority);
        $stmt->bindParam(':due_date', $this->due_date);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    //Retrieves a single task by its ID and user ID.
    public function readOne() {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE id = :id AND user_id = :user_id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //Updates an existing task in the database for the current user.
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET title = :title, description = :description, priority = :priority, 
                      due_date = :due_date, status = :status 
                  WHERE id = :id AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->priority = htmlspecialchars(strip_tags($this->priority));
        $this->due_date = htmlspecialchars(strip_tags($this->due_date));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':priority', $this->priority);
        $stmt->bindParam(':due_date', $this->due_date);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':user_id', $this->user_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    //Deletes a task by its ID and user ID.
    public function delete() {
        $query = "DELETE FROM " . $this->table . " 
                  WHERE id = :id AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':user_id', $this->user_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>