function info(id) {
    const info = document.getElementsByClassName("info")[id];
    
    if (info.style.display === 'none') {
        info.style.display = 'inline';
    } else {
        info.style.display = 'none';
    }
}


function filterTaskLists() {
    var input = document.querySelector('.search-tasklist');
    var filter = input.value.toLowerCase();
    var tasklistContainer = document.getElementById('tasklist-container');
    var tasklists = tasklistContainer.getElementsByClassName('tasklist-item');
    var results = document.getElementById('results');
    var anyVisible = false;

    for (var i = 0; i < tasklists.length; i++) {
        var title = tasklists[i].getAttribute('data-title');
        if (title.indexOf(filter) > -1) {
            tasklists[i].style.display = "";
            anyVisible = true;
        } else {
            tasklists[i].style.display = "none";
        }
    }

    if(anyVisible == true){
        results.style.display = "none";
        tasklistContainer.style.display = "";
        tasklistContainer.style.justifyContent = "";
        tasklistContainer.style.alignItems = "";
    }else{
        tasklistContainer.style.display = "flex";
        tasklistContainer.style.justifyContent = "center";
        tasklistContainer.style.alignItems = "center";
        results.style.display = "";
    }
}


function filterTasks(tasklistId) {
    var input = document.getElementById('search-task-' + tasklistId);
    var filter = input.value.toLowerCase();

    var taskContainer = document.getElementById('task-container-' + tasklistId);
    var tasks = taskContainer.getElementsByClassName('task');
    

    var statusInput = document.getElementById('task-status-' + tasklistId);
    var statusFilter = statusInput.value.toLowerCase();

    var results = document.getElementById('results-'+tasklistId);
    var anyVisible = false;

    
    for (var i = 0; i < tasks.length; i++) {
        var title = tasks[i].getElementsByClassName('task-title')[0].innerText.toLowerCase();
        var status = tasks[i].getElementsByClassName('status')[0].innerText.toLowerCase();

        // Check if the task matches the filter text and status filter
        var matchesFilter = title.indexOf(filter) > -1;
        var matchesStatus = statusFilter === '' || status.includes(statusFilter);

        if (matchesFilter && matchesStatus) {
            tasks[i].style.display = "";
            anyVisible = true;
        } else {
            tasks[i].style.display = "none";
        }
    }
    if(filter == '' && statusFilter == ''){
        anyVisible = true
    }
    results.style.display = anyVisible ? "none" : "";
}


function filterAssignments() {
    var input = document.querySelector('.search-tasklist');
    var filter = input.value.toLowerCase();
    var assignedTasklistContainer = document.getElementById('assigned-tasklist-container');
    var assignedTasklists = assignedTasklistContainer.getElementsByClassName('tasklist-item');
    var results = document.getElementById('results');
    var anyVisible = false;

    for (var i = 0; i < assignedTasklists.length; i++) {
        var title = assignedTasklists[i].getAttribute('data-title');
        if (title.indexOf(filter) > -1) {
            assignedTasklists[i].style.display = "";
            anyVisible = true;
        } else {
            assignedTasklists[i].style.display = "none";
        }
    }
    if(anyVisible == true){
        results.style.display = "none";
        assignedTasklistContainer.style.display = "";
        assignedTasklistContainer.style.justifyContent = "";
        assignedTasklistContainer.style.alignItems = "";
    }else{
        assignedTasklistContainer.style.display = "flex";
        assignedTasklistContainer.style.justifyContent = "center";
        assignedTasklistContainer.style.alignItems = "center";
        results.style.display = "";
    }
    
}
