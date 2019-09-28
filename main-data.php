<?php
function getProjectsQuery($user) {
    return 'SELECT * FROM projects WHERE user = ' . $user;
}

function getAllTasksQuery($user) {
    return 'SELECT * FROM task WHERE user = ' . $user;
}

function getTasksQuery($user) {
    $query_tasks = getAllTasksQuery($user);

    if (isset($_GET['project_id']) && is_numeric($_GET['project_id'])) {
        $query_tasks = getAllTasksQuery($user) . ' AND project = ' . $_GET['project_id'];
    } else if (empty($_GET['project_id'])) {
        $query_tasks = getAllTasksQuery($user);
    } else {
        http_response_code(404);
        include('404.php');
        die();
    }

    return $query_tasks;
}

$arr_projects = getInfoFromDatabase($connection, getProjectsQuery($user));
$arr_all_tasks = getInfoFromDatabase($connection, getAllTasksQuery($user));
$arr_tasks = getInfoFromDatabase($connection, getTasksQuery($user));

if (count($arr_tasks) === 0) {
    $query_tasks = 'SELECT * FROM task WHERE user = ' . $user;
    $arr_tasks = getInfoFromDatabase($connection, $query_tasks);
}

function generateUserData($connection, $user) {
    $arr_projects = getInfoFromDatabase($connection, getProjectsQuery($user));
    $arr_all_tasks = getInfoFromDatabase($connection, getAllTasksQuery($user));
    $arr_tasks = getInfoFromDatabase($connection, getTasksQuery($user));

    if (count($arr_tasks) === 0) {
        $query_tasks = 'SELECT * FROM task WHERE user = ' . $user;
        $arr_tasks = getInfoFromDatabase($connection, $query_tasks);
    }
}
