<?php
require_once("init.php");
require_once("functions.php");
require_once("helpers.php");
require_once("data.php");
require_once("main-data.php");

$title = "Добавить проект";
$required_fields = ["name"];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = "Поле не заполнено";
        }
    }

    foreach ($_POST as $key => $value) {
        if ($key == "name") {
            if (isProjectExistByName($_POST[$field], $connection, $user)) {
                $errors[$key] = "Проект с таким именем уже существует";
            }
        }
    }

    if (count($errors) === 0) {
        $project_name = $_POST["name"];

        $query_add_project = "INSERT INTO projects (title, user) VALUES (?, ?)";
        $stmt = db_get_prepare_stmt($connection, $query_add_project, [$project_name, $user]);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            header("Location: /");
            exit();
        } else {
            print(mysqli_error($connection));
        }
    }

}

$form_content = include_template("add-project.php", [
    "arr_projects" => $arr_projects,
    "arr_all_tasks" => $arr_all_tasks,
    "user" => $user,
    "errors" => $errors
]);
$layout_content = include_template("layout.php", ["content" => $form_content, "page_title" => $title, "user_name" => $user_name]);

print($layout_content);
