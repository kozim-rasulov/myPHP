<?
include_once "../db.php";
$result = userEditComment($_GET['updComm'], $_POST['descr']);
if ($result) {
    header('Location: ../../?route=guest');
} else {
    header("Location: ../../?route=guest&error=2&updComm=".$_GET['updComm']);
}
