<?php

class Taskboard {
    private $conn;
    private $table = "taskboards";

    // properties
    public $board_id;
    public $taskboard_name;

    public function __construct($db) {
        $this->conn = $db->connect(); 
    }

    // get specific taskboards
    public function get($id) {
        $query = "
        SELECT 
            board_id, 
            taskboard_name, 
            date_created 
        FROM " . $this->table."
        WHERE board_id = ?
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }

    // get all taskboards
    public function getAll() {
        $query = "
        SELECT 
        board_id, 
        taskboard_name, 
        date_created 
        FROM " . $this->table;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->get_result();
    }
    

    // create taskboard
    public function create() {
        $query = "
        INSERT INTO " . $this->table . " (taskboard_name) 
        VALUES (?)";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bind_param("s", $this->taskboard_name);

        // Execute and check if successful
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // delete taskboard
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE board_id = ?";
        $stmt = $this->conn->prepare($query);

        // Bind the id parameter
        $stmt->bind_param("i", $this->board_id);

        // Execute and check if successful
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}