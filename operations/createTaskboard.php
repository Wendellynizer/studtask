<?php

require_once "../utility/Validator.php";
require_once "../config/dbconnection.php";
require_once "../model/Taskboard.php";

if(isset($_POST["taskboard_name"])) {
    $tb_name = $_POST["taskboard_name"];

    if(!Validator::isValid($tb_name)) {
        var_dump($tb_name);
        echo "not valid bleh";
        return;
    }

    $db = new DB();
    $taskboard = new Taskboard($db);

    $taskboard->taskboard_name = $tb_name;
    $taskboard->create();

    header("location: ../index.php");
}

header("location: ../index.php");