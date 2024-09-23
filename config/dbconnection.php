<?php

class DB {

    public function connect() {

        $conn = new mysqli(
            "localhost", 
            "root", 
            "", 
            "studtask"
        );

        if($conn->error)
            echo $conn->error;

        return $conn;
    }  
}