<?php 

require "../utility/Validator.php";
require_once "../config/dbconnection.php";
require "../model/TaskList.php";


if(isset($_POST["create_list"])) {

    $board_id = $_POST["board_id"];
    $tasklist_name = $_POST["tasklist_name"];


    if(!Validator::isValid($board_id) && !Validator::isValid($tasklist_name)) {
        echo "invalid input";
        return;
    }

    $tasklist = new TaskList(new DB());
    $tasklist->board_id = $board_id;
    $tasklist->tasklist_name = $tasklist_name;

    if(!$tasklist->create()) {
        echo "error creating data";
        return;
    }

    header("location: ../taskboard/board.php?board_id=".$board_id);
    exit();
}

header("location: ../index.php");