var c_status_1 = 0;
var global_var_check_first_row = 0;
var global_var_balance = 0;

function ge(el){
	return document.getElementById(el);
}
function ge1(el1){
	return document.getElementByName(el1);
}
function ge2(el2){
	return document.getElementsByClassName(el2);
}
function ge3(el3){
	return document.getElementsByName(el3);
}


function ajax_changetab_and_send_data(php_file, el, send_data){
	var hr=new XMLHttpRequest();
	hr.open('POST', php_file, true);
	hr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	hr.onreadystatechange=function(){
		if(hr.readyState==4 && hr.status==200){
			ge(el).innerHTML=hr.responseText;
			c_status_1 = 1;
		}else{
			c_status_1 = 0;
		}
	};

	hr.send(send_data);
}

function ajax_changetab_and_send_data1(php_file, el, send_data){
	var hr=new XMLHttpRequest();
	hr.open('POST', php_file, true);
	hr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	hr.onreadystatechange=function(){
		if(hr.readyState==4 && hr.status==200){
			ge(el).innerHTML=hr.responseText;
		}
	};

	hr.send(send_data);
};

function ajax_changetab_and_send_data2(php_file, el, send_data){
	var hr=new XMLHttpRequest();
	hr.open('POST', php_file, true);
	hr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	hr.onreadystatechange=function(){
		if(hr.readyState==4 && hr.status==200){
			ge(el).value=hr.responseText;
		}
	};

	hr.send(send_data);
};

function createtask() {
    const taskText = $('#input-box').val().trim();
    if (taskText === "") {
        alert("Task cannot be empty. Please enter a task!");
        return;
    }
    ge("result_response").value = "";

    var action = "NEW_TASK";
    var task = $('#input-box').val();

    $.ajax({
        type: 'POST',
        url: 'insert.php',
        data: {
            action: action,
            task: task,
        },
        success: function (response) {
            $("#result_response").val(response);
            location.reload();
        },
    });
}

function updateTaskStatus(task_id, new_status) {
    // Check if the task_id is valid
    if (task_id <= 0) {
        alert("Invalid task ID");
        return;
    }

    $.ajax({
        type: 'POST',
        url: 'updatetask.php', 
        data: {
            action: 'UPDATE_TASK',
            task_id: task_id,
            new_status: new_status,
        },
        
        success: function (response) {
            if (response.status === 200) {
                //successful update
            } else {
                // alert("Update failed: " + response.feedback);
            }
        },
        error: function () {
            alert("Error updating task");
        },
    });
}

function checked(task_id){
    ge("result_response").value = "";

	var action="UPDATE_TASK";
	var task= task_id;

	$.ajax({
		type:'POST',
		url:'insert.php',
		data:{
			action:action,
			task:task,
		},

		success: function (response){
			$("#result_response").val(response);
            location.reload();
		}

	});
}

function uncheckTask(task_id) {
    $.ajax({
        type: 'POST',
        url: 'insert.php',
        data: {
            action: 'UPDATE_TASK',
            task: task_id,
        },
        success: function (response) {
            $("#result_response").val(response);
            location.reload();
        }
    });
}


function editTask(taskName, task_id) {

    // Hide the add form
    document.querySelector('.row').style.display = 'none';

    $("#editedTask").val(taskName);
    $("#saveEditedTask").attr("data-task-id", task_id);
    $("#editTaskModal").css("display", "block");
}
  

function closeEditModal() {
    $("#editTaskModal").css("display", "none");
    // Hide the add form
    document.querySelector('.row').style.display = 'block';
}

function saveEditedTask() {
    var editedTaskText = $("#editedTask").val();
    var task_id = $("#saveEditedTask").attr("data-task-id");


    $.ajax({
        type: 'POST',
        url: 'edit-task.php', 
        data: {
            task_id: task_id,
            editedTaskText: editedTaskText
        },
        success: function (response) {
        $("#list-container li").eq(task_id - 1).find(".task-content").text(editedTaskText);
        closeEditModal();
        $("#result_response").val("");
            location.reload();
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + error);
        }
    });
}

function removeTask(task_id) {
    ge("result_response").value = "";

    var action = "REMOVE_TASK";
    var task = task_id;

    $.ajax({
        type: 'POST',
        url: 'insert.php',
        data: {
            action: action,
            task: task,
        },
        success: function (response) {
            $("#result_response").val(response);
            // Remove the task element from the list
            const taskElement = document.querySelector(`#list-container li[data-task-id="${task}"]`);
            taskElement.remove();
        }
    });
}


function confirmDelete(taskId) {
	var result = confirm("Are you sure you want to delete this task?");
	if (result) {
		window.location.href = 'delete-task.php?task_id=' + taskId;
	} else {
	
	}
}



