<?
include_once "../db.php";
$login = userInfo()['user_login'];
$photo = $_FILES['photo'];

foreach ($photo['name'] as $key => $value) {
    $rand_name = md5(time()) . crc32($key);
    $extension = pathinfo($value, PATHINFO_EXTENSION);
    $file_name = "$login-$rand_name.$extension";
    $dir_name = "./img/users/$file_name";
    if (is_uploaded_file($photo['tmp_name'][$key])) {
        $result = userAddPhoto($dir_name);
        if ($result) {
            move_uploaded_file($photo['tmp_name'][$key], "../../$dir_name");
        }
    }
}
header('Location: ../../?route=edit');
