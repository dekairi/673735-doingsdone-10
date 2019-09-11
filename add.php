<?php
require_once("init.php");
require_once("functions.php");
require_once("helpers.php");
require_once("data.php");
require_once("logic.php");

$title = "Добавить задачу";
$required_fields = ["name", "project"];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = "Поле не заполнено";
        }
    }

    foreach ($_POST as $key => $value) {
        if ($key == "date" && $value != NULL) {
            if(!is_date_valid($value)) {
                $errors[$key] = "Введите дату в корректном формате";
            } else if (getDateDifference($value) < -24) {
                $errors[$key] = "Дата не должна быть позже сегодняшней";
            }
        }

        if ($key == "name") {
            if (strlen($_POST[$key]) == 0) {
                $errors[$key] = "Длинна поля не должна быть равна нулю";
            }
        }

        if ($key == "project") {
            if (!isProjectExist($_POST[$key], $connection, $user)) {
                $errors[$key] = "Проект не существует";
            }
        }
    }

    $file_path = "";
    $file_url = "";

    if (isset($_FILES["file"])) {
        $file_name = $_FILES["file"]["name"];
        $file_path = __DIR__ . "/uploads/";
        $file_url = "/uploads/" . $file_name;

        move_uploaded_file($_FILES["file"]["tmp_name"], $file_path . $file_name);
    }

    if (count($errors)) {
        $errors = array_filter($errors);
    }

    if (count($errors) === 0) {
        $task_name = $_POST["name"];
        $task_project = $_POST["project"];
        $task_date = empty($_POST["date"]) ? null : $_POST["date"];
        $task_file = $file_url == "" ? null : $file_url;

        $query_add_task = "INSERT INTO task (date_created, status, title, file, date_todo, project, user) VALUES (NOW(), 0, ?, ?, ?, ?, ?)";
        $stmt = db_get_prepare_stmt($connection, $query_add_task, [$task_name, $task_file, $task_date, $task_project, $user]);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            header("Location: /");
        } else {
            print(mysqli_error($connection));
        }
    }

}

$form_content = include_template("form.php", [
    "arr_tasks" => $arr_tasks,
    "arr_projects" => $arr_projects,
    "arr_all_tasks" => $arr_all_tasks,
    "show_complete_tasks" => $show_complete_tasks,
    "user" => $user,
    "errors" => $errors
]);
$layout_content = include_template("layout.php", ["content" => $form_content, "page_title" => $title, "user_name" => $user_name]);

print($layout_content);
