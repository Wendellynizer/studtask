// opens a modal with the given element ID
const openModal = (elemID) => {
    // do a shake animation when modal is already open
    

    let modal = document.getElementById(elemID);
    modal.style.display = 'block'; 
    modal.classList.add('animate__animated');
    modal.classList.add('animate__fadeIn');
    modal.classList.remove('animate__fadeOut');
}

// closes a modal with the given element ID
const closeModal = (elemID) => {
    let modal = document.getElementById(elemID);
    // modal.classList.remove('animate__animated');
    modal.classList.remove('animate__fadeIn');
    modal.classList.add('animate__fadeOut');

    setTimeout(function() {
        modal.style.display = 'none';
    }, 200);
}

const toggleElements = (el1, el2) => {
    $(el1).toggleClass('d-none');
    $(el2).toggleClass('d-none');
}


//* specific functions

// shows and focus on the form inputtext
const showAddTaskForm = (el) => {
    let formContainer = $(el).siblings()[0];

    $(el).toggleClass("d-none");
    $(formContainer).toggleClass("d-none");

    // auto focuses
    $(formContainer).find("input[type='text']").focus();
}

const showAddTaskBtn = (el) => {
    // don't hide if task_title field has value
    if($(el).val())
        return;

    let parent = $(el).parents("div.form-container")[0];
    let sibling = $(parent).siblings()[0];

    $(sibling).toggleClass("d-none");
    $(parent).toggleClass("d-none");
}

const checkField = (el) => {
    // getting the submit btn element
    let submitBtnParent = $(el).parentsUntil(".form").parent().siblings()[0];
    let submitBtn = $(submitBtnParent).children()[0];

    // enables/disables submitBtn, if inputfield is empty
    if(!$(el).val()) {
        $(submitBtn).attr('disabled', true);
        return;
    }

    $(submitBtn).attr('disabled', false);
}

// shows and hides descrption edit and view mode
const toggleMode = () => {
    $("#view-textarea").toggleClass("d-none");
    $("#edit-textarea").toggleClass("d-none");
    $("#edit-btn").toggleClass("d-none");
}


// ajax calls
const loadTaskData = (task) => {
    $.get(
        "/studTask/operations/getTaskData.php", 
        {
            task_id: $(task).data('task-id'),
        },
        function(data, status) {
            alert("data: "+data);
        });
};