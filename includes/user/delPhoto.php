<?
include_once "../db.php";
$result = userDelPhoto($_GET['trash']);
if ($result === true) {
    header('Location: ../../?route=edit&success=1');
} else if ($result === null) {
    header('Location: ../../?route=edit&error=5');
}
