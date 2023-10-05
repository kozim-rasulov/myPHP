<?
$comment = getAllComments();
sort($comment);
$commentText = userCommentTextById($_GET['updComm']);
?>

<main class="main">
    <section class="head">
        <h2 class="head__title"><?= $title ?></h2>
        <p class="head__date"><?= $date ?></p>
    </section>

    <? if ($_GET['error'] == 2) : ?>
        <p style="color: red;">Редактирование не удалось !</p>
    <? elseif ($_GET['error'] == "unreg") : ?>
        <p>Вы не авторизованы. Пожалуйста выполните <a style="color: orange;" href="./?route=login">Вход</a> или <a style="color: orange;" href="./?route=registration">Зарегистрируйтесь</a>.</p>
    <? endif; ?>

    <form action=<?= isset($_GET['updComm'])
                        ? "./includes/user/editComment.php?updComm=" . $_GET['updComm']
                        : "./includes/user/addComment.php" ?> class="form" method="post">
        <label class="form__label">
            <span class="form__text"><?= isset($_GET['updComm']) ? "Редактировать отзыв" : "Оставте отзыв" ?></span>
            <textarea class="form__input" name="descr"><?= $commentText['comment_text'] ?></textarea>
        </label>
        <button class="form__btn"><?= isset($_GET['updComm']) ? "Изменить" : "Отправить" ?></button>
        <a href="./?route=guest" class="form__btn <?= isset($_GET['updComm']) ? "form__btn_close-on" : "form__btn_close" ?>">Отменить</a>
    </form>
    <div class="comments">
        <? foreach ($comment as $key => $value) : ?>

            <div class="comments__item">
                <p class="comments__item-time"><?= date("H:i", $value['comment_time']) ?></p>
                <section class="comments__body">
                    <div class="comments__head">
                        <h2 class="comment__head-title"><?= $value['user_name'] ?></h2>
                        <img src="<?= $value['img_path'] ?>" alt="" class="comments__head-img">
                    </div>
                    <p class="comments__body-descr"><?= $value['comment_text'] ?></p>

                    <? if (($_SESSION['id']) === $value['user_id']) : ?>

                        <div class="comments__footer">
                            <a href="./?route=guest&updComm=<?= $value['comment_id'] ?>" class="comments__footer-link"><i class="fal fa-edit"></i></a>
                            <a href="./includes/user/delComment.php?trash=<?= $value['comment_id'] ?>" class="comments__footer-link"><i class="fal fa-trash"></i></a>
                        </div>

                    <? endif; ?>

                </section>
            </div>

        <? endforeach; ?>

    </div>
</main>