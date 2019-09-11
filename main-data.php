<?php
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
