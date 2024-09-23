<?php
require_once "./config/dbconnection.php";
require_once "./model/Taskboard.php";

$tb_obj = new Taskboard(new DB());

$taskboards = $tb_obj->getAll();


include "includes/header.php";
?>

<body>
    <?php include_once "includes/navbar.php" ?>

    <!-- taskboard creation modal -->
    <div class="card u-modal position-absolute top-50 start-50" style="min-width: 400px;" id="taskboard-creation">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <p class="m-0">Create Taskboard</p>

                <button onclick="closeModal('taskboard-creation')">
                    <i class="fa-solid fa-xmark close-btn"></i>
                </button>
                
            </div>
            
            <!-- create taskboard form -->
            <form action="./operations/createTaskboard.php" method="POST">
                <div class="form">
                    <div class="label">
                        Taskboard name
                        <!-- <span>*</span> -->
                    </div>

                    <div>
                        <input type="text" name="taskboard_name" id="taskboard-name">
                    </div>
                </div>
                
                
                <div class="mt-3">
                    <input type="submit" class="btn btn-success d-block w-100" value="Create">
                </div>
            </form>
        </div>
    </div>

    
    <div class="container-fluid d-flex p-0">

        <!-- the sidebar -->
        <?php include_once "includes/sidebar.php" ?>

        <!-- all contents right of the sidebar -->
        <div class="content py-3 px-3">
            <!-- create taskboard btn -->
            <button 
            type="button" 
            class="add-btn text-decoration-none px-2 py-2"
            onclick="openModal('taskboard-creation')"
            >
                <i class="fa-solid fa-plus me-1"></i>
                Create
            </button>

            <!-- taskboard list -->
            <div class="container mt-5">
                <p>
                    <i class="fa-brands fa-flipboard"></i>
                    Your Taskboards
                </p>

                <div class="boards d-flex flex-wrap gap-2">

                    <?php
                    
                    if($taskboards->num_rows == 0) {
                        echo "<p>No taskboards for the moment. Create one!</p>";
                        return;
                    }

                    foreach($taskboards as $tb) {
                        echo "
                        <a class='text-decoration-none' 
                        href='taskboard/board.php?board_id={$tb['board_id']}'>
                            <div class='card taskboard p-2 border-0'>
                                <p class='title text-wrap'>{$tb['taskboard_name']}</p>
                            </div>
                        </a>
                        ";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>