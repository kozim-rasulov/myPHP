<? if (isset($_SESSION['id'])) : ?>
    <main class="main">
        <section class="head">
            <h2 class="head__title"><?= $title ?></h2>
            <p class="head__date"><?= $date ?></p>
        </section>
        <div class="slider">
            <div class="slider__line">
                <?
                $path = "./img/slides/";
                $img = scandir($path);
                ?>
                <? foreach ($img as $key => $value) : ?>
                    <? if ($value != '.' && $value != '..') : ?>
                        <img src="<?= $path . $value ?>" alt="" class="slider__img">
                    <? endif; ?>
                <? endforeach; ?>
            </div>

            <div class="slider__controls">
                <button class="slider__prev slider__btn"><i class="far fa-chevron-left"></i></button>
                <button class="slider__next slider__btn"><i class="far fa-chevron-right"></i></button>
            </div>
        </div>
    </main>
<? else : ?>
    <? header('Location: ../?route=404') ?>
<? endif; ?>