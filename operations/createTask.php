<?php

require_once "../utility/Validator.php";
require_once "../config/dbconnection.php";
require_once "../model/Task.php";


if(isset($_POST["add_task_btn"])) {
    $tasklist_id = $_POST["tl_id"];
    $task_title = $_POST["task_title"];

    if(!Validator::isValid($tasklist_id) && !Validator::isValid($task_title)) {
        echo "not valid bleh";
        return;
    }

    $db = new DB();
    $task = new Task($db);

    $task->tasklist_id = $tasklist_id;
    $task->task_title = $task_title;
    $task->create();

    var_dump($tasklist_id);
    var_dump($task_title);

    header("location: ../index.php");
    exit();
} 

header("location: ../index.php");