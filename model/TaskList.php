<?php

class TaskList {
    private $conn;
    private $table = "tasklist";

    // properties
    public $board_id;
    public $tasklist_name;

    public function __construct($db) {
        $this->conn = $db->connect(); 
    }

    public function getAll($board_id) {
        $query = "
            SELECT 
                tasklist_id, 
                tasklist_name, 
                date_created 
            FROM " . $this->table . "
            WHERE board_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $board_id);
        $stmt->execute();
        
        return $stmt->get_result();
    }

    // create taskboard
    public function create() {
        $query = "
        INSERT INTO " . $this->table . " (board_id, tasklist_name) 
        VALUES (?,?)";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bind_param("is", $this->board_id, $this->tasklist_name);

        // Execute and check if successful
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}