<?php

class Task {
    private $conn;
    private $table = "task";

    // properties
    public $tasklist_id;
    public $task_title;
    public $description;
    public $datetime_start;
    public $datetime_end;
    public $label;
    public $is_done = 0;

    public function __construct($db) {
        $this->conn = $db->connect(); 
    }

    public function getAll($tasklist_id) {
        $query = "CALL GetTasks(?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $tasklist_id);
        $stmt->execute();
        
        return $stmt->get_result();
    }

    public function create() {
        $query = "
        INSERT INTO ".$this->table."
        (tasklist_id, task_title)
        VALUES
        (?,?)
        ";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param(
            "is", 
            $this->tasklist_id,
            $this->task_title,
        );

        // Execute and check if successful
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}