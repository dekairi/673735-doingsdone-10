<?php
session_start();

require_once("init.php");
require_once("functions.php");
require_once("helpers.php");
require_once("data.php");
require_once("main-data.php");

$title = "Регистрация";
$required_fields = ["email", "password", "name"];
$errors = [];

if (isset($_SESSION['user_id'])) {
    header("Location: /");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $key => $value) {
        if ($key == "email") {
            if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$key] = "Email должен быть корректным";
            } else if (isEmailExist($value, $connection)) {
                $errors[$key] = "Email занят, введите другой";
            }
        }
    }

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = "Поле не заполнено";
        }
    }

    if (count($errors) === 0) {
        $user_name = $_POST["name"];
        $user_email = $_POST["email"];
        $user_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $query_add_user = "INSERT INTO user (register_date, email, name, password) VALUES (NOW(), ?, ?, ?)";
        $stmt = db_get_prepare_stmt($connection, $query_add_user, [$user_email, $user_name, $user_password]);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            header("Location: /");
        } else {
            print(mysqli_error($connection));
        }
    }

}

$register_content = include_template("register.php", [
    "errors" => $errors
]);
$layout_content = include_template("layout.php", ["content" => $register_content, "page_title" => $title, "guest_page" => false]);

print($layout_content);
