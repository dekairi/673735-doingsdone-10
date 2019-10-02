<div class="content">
    <section class="content__side">
        <h2 class="content__side-heading">Проекты</h2>

        <nav class="main-navigation">
            <ul class="main-navigation__list">
                <?php foreach ($arr_projects as $key => $project): ?>
                    <li class="main-navigation__list-item <?=$_GET['project_id'] === $project["id"] ? "main-navigation__list-item--active" : ""?>">
                        <a class="main-navigation__list-item-link" href="index.php?project_id=<?=$project["id"];?>"><?=htmlspecialchars($project["title"]); ?></a>
                        <span class="main-navigation__list-item-count"><?=getQuantityOfProjectTasks($project["id"], $arr_all_tasks); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <a class="button button--transparent button--plus content__side-button"
           href="add-project.php" target="project_add">Добавить проект</a>
    </section>

    <main class="content__main">
        <h2 class="content__main-heading">Список задач</h2>

        <form class="search-form" action="index.php" method="post" autocomplete="off">
            <input class="search-form__input" type="text" name="q" value="<?=getPostValue('q');?>" placeholder="Поиск по задачам">

            <input class="search-form__submit" type="submit" name="" value="Искать">
        </form>

        <div class="tasks-controls">
            <nav class="tasks-switch">
           <a href="/" class="tasks-switch__item <?= (!isset($_GET['filter'])) ? "tasks-switch__item--active" : ""; ?>">Все задачи</a>
           <a href="/?filter=today" class="tasks-switch__item <?= (htmlspecialchars($_GET['filter']) === "today") ? "tasks-switch__item--active" : ""; ?>">Повестка дня</a>
           <a href="/?filter=tomorrow" class="tasks-switch__item <?= (htmlspecialchars($_GET['filter']) === "tomorrow") ? "tasks-switch__item--active" : ""; ?>">Завтра</a>
           <a href="/?filter=outofdate" class="tasks-switch__item <?= (htmlspecialchars($_GET['filter']) === "outofdate") ? "tasks-switch__item--active" : ""; ?>">Просроченные</a>
       </nav>

       <label class="checkbox">
           <input class="checkbox__input visually-hidden show_completed" type="checkbox"
           <?php if (isset($_SESSION['show_complete_tasks'])): ?>
           <?=($_SESSION['show_complete_tasks']) ? "checked" : "";?>
            <?php endif; ?>>
           <span class="checkbox__text">Показывать выполненные</span>
       </label>
        </div>

        <table class="tasks">
            <?php if (empty($arr_tasks) && isset($_POST['q'])): ?>
                <div>Ничего не найдено по вашему запросу</div>
            <?php else: ?>
            <?php foreach ($arr_tasks as $task): ?>
                <tr class="tasks__item task <?=($task["status"]) ? "task--completed" : ""?> <?=(isTaskImportant($task["date_todo"])) && !$task["status"] ? "task--important" : ""?>"
                    <?php if (isset($_SESSION['show_complete_tasks'])): ?>
                    <?=($task["status"] && intval($_SESSION['show_complete_tasks']) === 0) ? "style='display:none;'" : "" ?>
                    <?php endif; ?>>
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="<?=$task["id"];?>" <?=$task["status"] ? "checked" : "";?>>
                            <span class="checkbox__text"><?=htmlspecialchars($task["title"]);?></span>
                        </label>
                    </td>

                    <td class="task__file">
                        <?php $current_file_path = $task["file"]; ?>
                        <?=$task["file"] !== '/uploads/' && $task["file"] !== NULL ? '<a class="download-link" href="' . $current_file_path . '">Download</a>' : ''; ?>
                    </td>

                    <td class="task__date"><?=date_format(date_create(htmlspecialchars($task["date_todo"])),"d.m.Y"); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </table>
    </main>
</div>
