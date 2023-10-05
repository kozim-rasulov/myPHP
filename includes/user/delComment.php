<?
include_once "../db.php";
$result = userDeleteComment($_GET['trash']);
if ($result) {
    header('Location: ../../?route=guest');
} else {
    header('Location: ../../?route=guest');
}
