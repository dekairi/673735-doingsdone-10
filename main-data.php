<?php
require_once("init.php");
require_once("data.php");
require_once("functions.php");

/**
 * Возвращает запрос на список всех проектов, принадлежащих данному пользователю
 * @param int $user ID данного пользователя
 * @return string запрос
 */
function getProjectsQuery($user) {
    return 'SELECT * FROM projects WHERE user = ' . $user;
}

/**
 * Возвращает запрос на список всех задач, принадлежащих данному пользователю
 * @param int $user ID данного пользователя
 * @return string запрос
 */
function getAllTasksQuery($user) {
    return 'SELECT * FROM task WHERE user = ' . $user;
}

/**
 * Возвращает запрос на список всех задач запрошенного проекта, принадлежащих данному пользователю
 * @param int $user ID данного пользователя
 * @param mysqli $connection объект, представляющий соединение с сервером MySQL
 * @return string запрос
 */
function getTasksQuery($user, $connection) {
    $query_tasks = getAllTasksQuery($user);

    if (isset($_GET['project_id']) && is_numeric($_GET['project_id'])) {
        $query_tasks = getAllTasksQuery($user) . ' AND project = ' . $_GET['project_id'];

        if (!isProjectExist($_GET['project_id'], $connection, $user)) {
            http_response_code(404);
            include('404.php');
            die();
        }
    }

    return $query_tasks;
}

$arr_projects;
$arr_all_tasks;
$arr_tasks;

if (isset($user)) {
    $arr_projects = getInfoFromDatabase($connection, getProjectsQuery($user));
    $arr_all_tasks = getInfoFromDatabase($connection, getAllTasksQuery($user));
    $arr_tasks = getInfoFromDatabase($connection, getTasksQuery($user, $connection));
}

/**
 * Создает данные по пользователю (проекты, все задачи и задачи по конкретному проекту)
 * @param mysqli $connection объект, представляющий соединение с сервером MySQL
 * @param int $user ID данного пользователя
 */
function generateUserData($connection, $user) {
    $arr_projects = getInfoFromDatabase($connection, getProjectsQuery($user));
    $arr_all_tasks = getInfoFromDatabase($connection, getAllTasksQuery($user));
    $arr_tasks = getInfoFromDatabase($connection, getTasksQuery($user, $connection));

    if (count($arr_tasks) === 0) {
        $query_tasks = 'SELECT * FROM task WHERE user = ' . $user;
        $arr_tasks = getInfoFromDatabase($connection, $query_tasks);
    }
}
