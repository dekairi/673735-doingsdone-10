<?php

$link = mysqli_init();
mysqli_options($link, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
$connection = mysqli_connect("localhost:8889", "root", "root", "doingsdone");

$user_name = "Ирина";
$user = 1;

if($connection == false)
    print("Ошибка подключения: " . mysqli_connect_error());
else {
    mysqli_set_charset($connection, "utf8");

    $query_tasks = "";
    $query_projects = 'SELECT * FROM projects WHERE user = ' . $user;
    $query_all_tasks = 'SELECT * FROM task WHERE user = ' . $user;
    $query_tasks = $query_all_tasks;

    if (isset($_GET['project_id']) && is_numeric($_GET['project_id'])) {
        $query_tasks = $query_all_tasks . ' AND project = ' . $_GET['project_id'];
    } else if (empty($_GET['project_id'])) {
        $query_tasks = $query_all_tasks;
    } else {
        http_response_code(404);
        include('404.php');
        die();
    }

    $arr_projects = getInfoFromDatabase($connection, $query_projects);
    $arr_all_tasks = getInfoFromDatabase($connection, $query_all_tasks);
    $arr_tasks = getInfoFromDatabase($connection, $query_tasks);

    if (count($arr_tasks) === 0) {
        $query_tasks = 'SELECT * FROM task WHERE user = ' . $user;
        $arr_tasks = getInfoFromDatabase($connection, $query_tasks);
    }
}

function isProjectExist($project_id, $connection) {
    $result = false;

    $query_projects = 'SELECT * FROM projects WHERE user = ' . $user . ' AND id = ' . $project_id;
    $arr_projects = getInfoFromDatabase($connection, $query_projects);

    if (count($arr_projects) !== 0)
        $result = true;

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
    $query_task = $sql_query;
    $result = mysqli_query($conn, $query_task);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $result;
}

$title = "Дела в порядке";
$show_complete_tasks = rand(0, 1);

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
        if ($task["project"] == $project_id && $task["status"] != 1)
            $tasks_number++;
        }
    return $tasks_number;
}
