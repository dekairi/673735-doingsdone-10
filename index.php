<?php
session_start();

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
        "user" => $user
    ]);

    if (isset($_GET['show_completed'])) {
        $show_completed = intval($_GET['show_completed']) ?? null;
        if ($show_completed !== null) {
            $_SESSION['show_complete_tasks'] = $show_completed;
            header("Location: /index.php");
        }
    }

    if (isset($_GET['check']) && isset($_GET['task_id'])) {
        $task_id = intval($_GET['task_id']) ?? null;
        $is_checked = intval($_GET['check']) ?? null;
        if (!$task_id) {
            header("Location: /index.php");
            exit;
        }
        mysqli_query($con, "START TRANSACTION");
        $sql = "UPDATE tasks SET task_status = '$is_checked' WHERE task_id = '$task_id'";
        $update_result = mysqli_query($con, $sql);
        if ($update_result) {
            mysqli_query($con, "COMMIT");
        } else {
            mysqli_query($con, "ROLLBACK");
        }

        header("Location: /index.php");
        exit;
    }

    if (isset($_GET['filter'])) {
        $filter = $_GET['filter'] ?? null;
        if ($filter) {
            switch ($filter) {
                case "today":
                    $date = changeDateFormat("now", 'Y-m-d');
                    $sql_filter_tasks = 'SELECT * FROM task WHERE user=' . $user . ' AND date(date_todo) = "' . $date . '"';
                    break;
                case "tomorrow":
                    $date = changeDateFormat("tomorrow", 'Y-m-d');
                    $sql_filter_tasks = 'SELECT * FROM task WHERE user=' . $user . ' AND date(date_todo) = "' . $date . '"';
                    break;
                case "outofdate":
                    $date = changeDateFormat("now", 'Y-m-d');
                    $sql_filter_tasks = 'SELECT * FROM task WHERE user=' . $user . ' AND date_todo < "' . $date . '" AND status = 0';
                    break;
            }
        }
        $arr_filter_tasks = getInfoFromDatabase($connection, $sql_filter_tasks);
        if ($arr_filter_tasks) {
            $page_content = include_template("main.php", [
                "arr_tasks" => $arr_filter_tasks,
                "arr_projects" => $arr_projects,
                "arr_all_tasks" => $arr_all_tasks,
                "user" => $user
            ]);
        } else {
            $page_content = include_template("main.php", [
                "arr_tasks" => [],
                "arr_projects" => $arr_projects,
                "arr_all_tasks" => $arr_all_tasks,
                "user" => $user
            ]);
        }
    } else if (isset($_POST['q'])) {
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
