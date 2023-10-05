<? if (isset($_SESSION['id'])) : ?>
    <main class="main">

    </main>
<? else : ?>
    <? header('Location: ../?route=404') ?>
<? endif; ?>