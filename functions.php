<?php
function getPostValue($name) {
    return $_POST[$name] ?? "";
}

function isEmailExist($email, $connection) {
    $result = false;

    $query_emails = 'SELECT * FROM user WHERE email = "' . $email . '"';
    $arr_emails = getInfoFromDatabase($connection, $query_emails);

    if ($arr_emails) {
        $result = true;
    }

    return $result;
}

function isProjectExist($project_id, $connection, $user) {
    $result = false;

    $query_projects = 'SELECT * FROM projects WHERE user = ' . $user . ' AND id = ' . $project_id;
    $arr_projects = getInfoFromDatabase($connection, $query_projects);

    if ($arr_projects) {
        $result = true;
    }

    return $result;
}

function isProjectExistByName($project_name, $connection, $user) {
    $result = false;

    $query_projects = 'SELECT * FROM projects WHERE user = ' . $user . ' AND title = "' . $project_name . '"';
    $arr_projects = getInfoFromDatabase($connection, $query_projects);

    if ($arr_projects) {
        $result = true;
    }

    return $result;
}

function isProjectSelected($project_id) {
    return $_POST["project"] == $project_id;
}

function getInfoFromDatabase($conn, $sql_query) {
    $result = mysqli_query($conn, $sql_query);

    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
}

function getDateDifference($date_in) {
    $diff = 0;

    $date = strtotime($date_in);
    $now = strtotime("now");
    $diff = floor(($date - $now) / 3600);

    return $diff;
}

function isTaskImportant($date_todo) {
    $result = false;

    $diff = getDateDifference($date_todo);

    if ($diff <= 24 && $diff > 0) {
        $result = true;
    }

    return $result;
}

function getQuantityOfProjectTasks($project_id, $arr_tasks) {
    $tasks_number = 0;

    foreach ($arr_tasks as $task) {
        if ($task["project"] == $project_id && $task["status"] != 1) {
            $tasks_number++;
        }
    }
    return $tasks_number;
}
