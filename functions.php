<?php

/**
 * Возвращает значение POST запроса по атрибуту name
 * @param string $name атрибут name
 * @return string значение атрибута name
 */
function getPostValue($name) {
    return $_POST[$name] ?? "";
}

/**
 * Возвращает дату в нужном формате
 * @param string $date исходная дата
 * @param string $format необходимый формат
 * @return DateTime дата в указанном формате
 */
function changeDateFormat($date, $format)
{
    $new_date = date_create($date);
    return date_format($new_date, $format);
}

/**
 * Проверяет, существует ли email в базе данных
 * @param string $email проверяемый email
 * @param mysqli $connection объект, представляющий соединение с сервером MySQL
 * @return boolean
 */
function isEmailExist($email, $connection) {
    $result = false;

    $query_emails = 'SELECT * FROM user WHERE email = ?';
    $stmt = db_get_prepare_stmt($connection, $query_emails, [$email]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($res) {
        $arr_emails = mysqli_fetch_all($res, MYSQLI_ASSOC);
        if (count($arr_emails) !== 0) {
            $result = true;
        }
    }

    return $result;
}

/**
 * Проверяет, существует ли проект в базе данных по его ID
 * @param int $project_id проверяемый ID проекта
 * @param mysqli $connection объект, представляющий соединение с сервером MySQL
 * @param int $user ID пользователя
 * @return boolean
 */
function isProjectExist($project_id, $connection, $user) {
    $result = false;

    $query_projects = 'SELECT * FROM projects WHERE user = ? AND id = ?';
    $stmt = db_get_prepare_stmt($connection, $query_projects, [$user, $project_id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($res) {
        $arr_projects = mysqli_fetch_all($res, MYSQLI_ASSOC);
        if (count($arr_projects) !== 0) {
            $result = true;
        }
    }

    return $result;
}

/**
 * Проверяет, существует ли проект в базе данных по его имени
 * @param string $project_name проверяемое имя проекта
 * @param mysqli $connection объект, представляющий соединение с сервером MySQL
 * @param int $user ID пользователя
 * @return boolean
 */
function isProjectExistByName($project_name, $connection, $user) {
    $result = false;

    $query_projects = 'SELECT * FROM projects WHERE user = ? AND title = ?';
    $stmt = db_get_prepare_stmt($connection, $query_projects, [$user, $project_name]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($res) {
        $arr_projects = mysqli_fetch_all($res, MYSQLI_ASSOC);
        if (count($arr_projects) !== 0) {
            $result = true;
        }
    }

    return $result;
}

/**
 * Проверяет, выделен ли проект в html
 * @param int $project_id проверяемый ID проекта
 * @return boolean
 */
function isProjectSelected($project_id) {
    if (isset($_POST["project"])) {
        return $_POST["project"] === $project_id;
    }
}

/**
 * Возвращает данные из БД по запросу
 * @param mysqli $connection объект, представляющий соединение с сервером MySQL
 * @param string $sql_query запрос к БД
 * @return array массив с данными, если запрос прошел успешно
 */
function getInfoFromDatabase($conn, $sql_query) {
    $result = mysqli_query($conn, $sql_query);

    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
}

/**
 * Возвращает разницу во времени в сравнении с текущей
 * @param string $date_in дата для сравнения
 * @return int разница во времени
 */
function getDateDifference($date_in) {
    $diff = 0;

    $date = strtotime($date_in);
    $now = strtotime("now");
    $diff = floor(($date - $now) / 3600);

    return $diff;
}

/**
 * Проверяет, является ли задание важным (время на исполнение меньше суток)
 * @param string $date_todo дата на исполнение задачи
 * @return boolean
 */
function isTaskImportant($date_todo) {
    $result = false;

    $diff = getDateDifference($date_todo);
    var_dump($diff);
    if ($diff <= 24) {
        $result = true;
    }

    return $result;
}

/**
 * Возвращает количество задания, принадлежащих данному проекту
 * @param int $project_id ID данного проекта
 * @param array $arr_tasks массив всех заданий пользователя
 * @return int количество проектов
 */
function getQuantityOfProjectTasks($project_id, $arr_tasks) {
    $tasks_number = 0;

    foreach ($arr_tasks as $task) {
        if ($task["project"] === $project_id && $task["status"] !== 1) {
            $tasks_number++;
        }
    }
    return $tasks_number;
}
