<div class="content">
    <section class="content__side">
        <h2 class="content__side-heading">Проекты</h2>

        <nav class="main-navigation">
            <ul class="main-navigation__list">
                <?php foreach ($arr_projects as $key => $project): ?>
                    <li class="main-navigation__list-item <?=$_GET['project_id'] === $project["id"] ? "main-navigation__list-item--active" : ""?>">
                        <a class="main-navigation__list-item-link" href="<?="/index.php?project_id=" . $project["id"]; ?>"><?=htmlspecialchars($project["title"]); ?></a>
                        <span class="main-navigation__list-item-count"><?=getQuantityOfProjectTasks($project["id"], $arr_all_tasks); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </section>

    <main class="content__main">
        <h2 class="content__main-heading">Добавление проекта</h2>

        <form class="form"  action="../add-project.php" method="post" autocomplete="off">
          <div class="form__row">
            <?php $classname = isset($errors["name"]) ? "form__input--error" : "";?>
            <label class="form__label" for="project_name">Название <sup>*</sup></label>

            <input class="form__input <?=$classname; ?>" type="text" name="name" id="project_name" value="<?=getPostValue("name"); ?>" placeholder="Введите название проекта">
            <p class="form__message"><?=$errors["name"] ?? ""; ?></p>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>
        </form>
    </main>
</div>
