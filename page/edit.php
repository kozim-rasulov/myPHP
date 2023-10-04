<? if (isset($_SESSION['id'])) : ?>
    <main class="main">
        <section class="head">
            <h2 class="head__title"><?= $userInfo['user_login'] ?></h2>
            <p class="head__date"><?= $date ?></p>
        </section>
        <?if ($_GET['error'] == 5) :?>
            <p style="color: red; margin-bottom: 20px">Нельзя удалить аватар</p>
        <?endif;?>

        <form action="./includes/user/changeAva.php" class="userPage" method="post">
            <div class="userPage__wrapper">
                <? foreach ($userPhotos as $key => $value) : ?>

                    <label class="userPage__label">

                        <img src="<?= $value['img_path'] ?>" class="userPage__img" alt="<?= $userInfo['user_login'] ?>-img">

                        <input type="radio" name="ava" value="<?=$value['img_id']?>" class="userPage__input" <?= $value['img_select'] == 1 ? "checked" : "" ?> hidden>
                        <span class="userPage__check hover-eff">
                            <i class="fas fa-check"></i>
                        </span>
                        <a href="./includes/user/delPhoto.php?trash=<?=$value['img_id']?>" class="userPage__trash hover-eff">
                            <i class="fas fa-trash"></i>
                        </a>
                    </label>

                <? endforeach; ?>
            </div>
            <button class="form__btn userPage__btn">Изменить главное фото</button>
        </form>

        <form action="./includes/user/addPhoto.php" method="post" class="userAddImg" enctype="multipart/form-data">
            <h3 class="userAddImg__title">Добавить фото</h3>
            <input type="file" name="photo[]" accept="image/png, image/jpeg, image/gif" class="userAddImg__input" multiple>
            <button class="form__btn">Добавить</button>
        </form>
    </main>
<? else : ?>

    <? header('Location: ../?route=404') ?>

<? endif; ?>