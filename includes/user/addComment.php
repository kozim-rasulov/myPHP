<?
include_once "../db.php";
$result = userAddComment($_POST['descr']);
if ($result) {
    header('Location: ../../?route=guest');
} else {
    header('Location: ../../?route=guest&error=unreg');
}