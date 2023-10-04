<?
include_once "../db.php";
$result = userChangeAva($_POST['ava']);
if ($result) {
    header('Location: ../../?route=edit');
} else {
    header('Location: ../../?route=edit&error=1');
}