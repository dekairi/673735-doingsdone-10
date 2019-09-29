<?php
require_once("init.php");
require_once("functions.php");
require_once("helpers.php");
require_once("data.php");
require_once("main-data.php");


$title = "Дела в порядке";

if ($_SESSION['user_id']) {
    generateUserData($connection, $user);

    $page_content = include_template("main.php", [
        "arr_tasks" => $arr_tasks,
        "arr_projects" => $arr_projects,
        "arr_all_tasks" => $arr_all_tasks,
        "show_complete_tasks" => $show_complete_tasks,
        "user" => $user
    ]);

    if (isset($_POST['q'])) {
        $search_tasks = array();
        $search = trim($_POST['q']);
        if (!empty($search)) {
            $sql = 'SELECT * FROM task WHERE MATCH(title) AGAINST(?) AND user=' . $user;
            $stmt = db_get_prepare_stmt($connection, $sql, [$search]);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $search_tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $page_content = include_template("main.php", [
                "arr_tasks" => $search_tasks,
                "arr_projects" => $arr_projects,
                "arr_all_tasks" => $arr_all_tasks,
                "show_complete_tasks" => $show_complete_tasks,
                "user" => $user
            ]);
        }
    }
} else {
    header("Location: guest.php");
    exit();
}

$layout_content = include_template("layout.php", ["content" => $page_content, "page_title" => $title, "user_name" => $user_name]);

print($layout_content);
