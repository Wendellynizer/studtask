<?php
require_once "../config/dbconnection.php";
require_once "../model/Taskboard.php";
require_once "../model/TaskList.php";
require_once "../model/Task.php";

$db = new DB();

$taskboard_obj = new Taskboard($db);
$taskboard = $taskboard_obj->get($_GET["board_id"]);


$tasklist_obj = new TaskList($db);
$tasklists = $tasklist_obj->getAll($_GET["board_id"]);


$title = $taskboard["taskboard_name"];
require "../includes/header.php";
?>

<body>
    <?php include_once "../includes/navbar.php" ?>

    <div class="container-fluid d-flex p-0">

        <!-- the sidebar -->
        <?php include_once "../includes/sidebar.php" ?>


        <!-- list creation modal -->
        <div class="card u-modal position-absolute top-50 start-50" style="min-width: 400px;" id="list-creation">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <p class="m-0">Create List</p>

                    <button onclick="closeModal('list-creation')">
                        <i class="fa-solid fa-xmark close-btn"></i>
                    </button>

                </div>

                <!-- create taskboard form -->
                <form action="../operations/createTaskList.php" method="POST">
                    <div class="form">
                        <div class="label">
                            List name
                            <!-- <span>*</span> -->
                        </div>

                        <div>
                            <input type="hidden" name="board_id" value="<?php echo $_GET["board_id"] ?>" />
                            <input type="text" name="tasklist_name" id="taskboard-name" />
                        </div>
                    </div>


                    <div class="mt-3">
                        <input type="submit" class="btn btn-success d-block w-100" value="Add List" name="create_list" />
                    </div>
                </form>
            </div>
        </div>

        <!-- task details modal -->
        <div class="card u-modal position-absolute top-50 start-50 d-block task-details-card" style="min-width: 400px;" id="task-details">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-5">
                    <p class="m-0 fw-bold">Task Title Here</p>

                    <button onclick="closeModal('task-details')">
                        <i class="fa-solid fa-xmark close-btn"></i>
                    </button>
                </div>

                <!-- task body -->
                <div class="d-flex gap-5">
                    <div class="w-50">
                        <!-- labels -->
                        <div class="mb-3">
                            <p class="m-0 fw-semibold">Labels</p>

                            <div class="label-wrapper d-flex gap-1">
                                <div class="label px-2 p-1 rounded-1">
                                    <span>Low Priority</span>
                                </div>
                                
                                <button type="button" class="btn btn-sm btn-secondary">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- description -->
                        <div class="description-container mb-3">
                            <div class="d-flex align-items-center gap-1 mb-2">
                                <p class="mb-0 fw-semibold">Description</p>
                                <button 
                                    type="button" 
                                    class="btn px-1 py-0"
                                    id="edit-btn"
                                    onclick="toggleMode()";
                                >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </div>
                            

                            <div class="" id="view-textarea">
                                <p class="text-break">This is a description</p>
                            </div>

                            <div class="d-none" id="edit-textarea">
                                <textarea name="description" class="form-control" placeholder="enter description"></textarea>

                                <div>
                                    <button class="btn btn-sm c-btn-primary mt-1" onclick="toggleMode()">Save</button>
                                    
                                    <button class="btn btn-sm btn-secondary mt-1" onclick="toggleMode()">Cancel</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="w-50 subtask-wrapper">
                        <p class="m-0 fw-semibold">Subtasks</p>

                        <div class="subtask-container w-100">
                            <div class="subtask mb-2 d-flex gap-1">
                                <div>
                                    <input type="checkbox" class="form-check-input me-2"/>
                                </div>
                                <span class="text-break">Do dishes</span>
                            </div>

                            <button 
                                type="button" 
                                class="btn btn-sm c-btn-primary mt-2"
                                id="add-subtask-btn"
                                onclick="toggleElements(this, '#subtask-form')"
                            >Add Subtask</button>

                            

                            <form class="d-none" id="subtask-form">
                                <input type="text" name="subtask_name" class="form-control form-control-sm mb-1">

                                <div class="d-flex align-items-center gap-2">
                                    <input type="submit" value="Add" class="btn btn-sm c-btn-primary">

                                    <button 
                                        type="button"
                                        class="btn btn-sm btn-secondary"
                                        onclick="toggleElements('#subtask-form', '#add-subtask-btn')"
                                    >Cancel</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- content -->
        <div class="content w-100">
            <div class="container-fluid p-0 cnt">
                <div class="task-navbar border-bottom p-2">
                    <p class="m-0 fw-bold"><?php echo $taskboard["taskboard_name"] ?></p>
                </div>

                <div class="container-fluid py-3 d-flex gap-2 task-container">
                    <!-- render all tasks -->
                    <?php
                    foreach ($tasklists as $tl) {
                    ?>

                        <div class="card rounded-2 list-card" style="width: 300px">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <span><?php echo $tl["tasklist_name"] ?></span>
                                <i class="fa-solid fa-trash c-btn" title="Delete"></i>
                            </div>

                            <div class="card-body p-2 d-flex flex-column gap-2">
                                <!-- render all tasks card -->

                                <?php
                                $task_obj = new Task(new DB());
                                $tasks = $task_obj->getAll($tl["tasklist_id"]);

                                foreach ($tasks as $t) {
                                ?>

                                    <div class="card rounded-1 task-card border-0 shadow-sm"  data-task-id="<?php echo $t['task_id'] ?>" onclick="loadTaskData(this)">
                                        <div class="card-body p-2">
                                            <div class="task-label mb-2 bg-danger">
                                                <span>Low Priority</span>
                                            </div>

                                            <span class="title"><?php echo $t["task_title"] ?></span>

                                            <div class="task-details">
                                                <div class="container d-flex gap-3">

                                                    <!-- show other details when column is not null -->
                                                    <?php if (!$t['description'] == null): ?>
                                                        <div class="description">
                                                            <i class="fa-solid fa-align-left"></i>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div>
                                                        <!-- <i class="fa-regular fa-square-check me-2"></i>
                                                        <span class="subtask-count">5/10</span> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                }
                                ?>

                                <div class="add-task-container">
                                    <button type="button" class="btn w-100 text-start" 
                                    onclick="showAddTaskForm(this)">
                                        + Add task
                                    </button>

                                    <div class="d-none form-container">
                                        <form action="../operations/createTask.php" method="POST">
                                            <div class="form">
                                                <div>
                                                    <input type="hidden" value="<?php echo $tl['tasklist_id']?>" name="tl_id">

                                                    <input 
                                                        type="text" class="task_title_field" 
                                                        name="task_title" 
                                                        autocomplete="off"
                                                        onblur="showAddTaskBtn(this)"
                                                        oninput="checkField(this)"
                                                    >
                                                </div>
                                            </div>

                                            <div>
                                                <input type="submit" class="btn btn-sm c-btn-primary mt-1 add_task_btn" value="Add" name="add_task_btn" disabled>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                    ?>

                    <div>
                        <button type="button" class="btn c-btn-primary" id="createListBtn" onclick="openModal('list-creation')">
                            + Add List
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html