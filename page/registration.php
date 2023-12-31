<main class="main">
    <section class="head">
        <h2 class="head__title"><?= $title ?></h2>
        <p class="head__date"><?= $date ?></p>
    </section>
    <? if ($_GET['userError'] == 1) : ?>
        <p style="color: red;">Пользователь с таким логином уже существует</p>
    <? endif; ?>
    <form action="./includes/user/reg.php" class="form" method="post" enctype="multipart/form-data">
        <label class="form__label">
            <span class="form__text">Логин</span>
            <input type="text" class="form__input" name="login" autocomplete="off">
        </label>
        <label class="form__label">
            <span class="form__text">Имя</span>
            <input type="text" class="form__input" name="name" autocomplete="off">
        </label>
        <label class="form__label">
            <span class="form__text">Пароль</span>
            <input type="password" class="form__input" name="pass">
            <button type="button" class="form__eye"><i class="far fa-eye-slash"></i></button>
        </label>
        <label class="form__label">
            <span class="form__text">Повторите пароль</span>
            <input type="password" class="form__input" name="confirmpass">
            <button type="button" class="form__eye"><i class="far fa-eye-slash"></i></button>
        </label>
        <span class="form__error">* Пароли не совподают</span>
        <label class="form__label">
            <input type="file" name="photo" class="form__input form__input_fz" accept="image/png, image/jpeg, image/gif">
        </label>
        <button class="form__btn" disabled>Зарегистрироваться</button>
    </form>
</main>