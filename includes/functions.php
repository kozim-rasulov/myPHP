<?
session_start();

date_default_timezone_set("Asia/Tashkent");
$route = $_GET['route'] ?? 'home';
$route = is_readable("./page/$route.php") ? $route : "404";

if (isset($_SESSION['id'])) {
    $page = [
        'home' => ['name' => 'Главная', 'icon' => 'fal fa-home'],
        'contact' => ['name' => 'Контакты', 'icon' => 'fal fa-address-book'],
        'calc' => ['name' => 'Калькулятор', 'icon' => 'fas fa-calculator-alt'],
        'table' => ['name' => 'Таблица умножения', 'icon' => 'fas fa-times'],
        'slide' => ['name' => 'Слайдер', 'icon' => 'far fa-presentation'],
        'guest' => ['name' => 'Гостевая книга', 'icon' => 'fal fa-books'],
        'test' => ['name' => 'Тест', 'icon' => 'fal fa-vial'],
        'login' => ['name' => 'Вход в систему'],
        'registration' => ['name' => 'Регистрация'],
    ];
} else {
    $page = [
        'home' => ['name' => 'Главная', 'icon' => 'fal fa-home'],
        'guest' => ['name' => 'Гостевая книга', 'icon' => 'fal fa-books'],
        'login' => ['name' => 'Вход в систему'],
        'registration' => ['name' => 'Регистрация'],
    ];
}

$title = $page[$route]['name'];
$ruMonths = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
$ruMonth = $ruMonths[date('n') - 1];
$date = date("Сегодня d $ruMonth o год");

$userInfo = userInfo();