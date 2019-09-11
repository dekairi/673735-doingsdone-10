<?php
function getPostValue($name) {
    return $_POST[$name] ?? "";
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

function isProjectSelected($project_id) {
    if($_POST["project"] == $project_id) {
        return true;
    } else {
        return false;
    }
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
