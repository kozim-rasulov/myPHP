<?
function db()
{
    $dbhost = "127.0.0.1";
    $dbname = "tue1930";
    $dblogin = "root";
    $dbpass = "";
    return new PDO("mysql:host=$dbhost;dbname=$dbname", $dblogin, $dbpass);
}

function userReg($login, $pass, $name, $path)
{
    $login = strip_tags(strtolower($login));
    $pass = password_hash($pass, PASSWORD_BCRYPT);
    $name = strip_tags($name);
    $pdo = db();
    $query = "SELECT `user_login` FROM `users` WHERE `user_login`=?";
    $pdoStat = $pdo->prepare($query);
    $pdoStat->execute([$login]);
    $newUser = $pdoStat->fetch(PDO::FETCH_ASSOC);
    if ($newUser['user_login'] != $login) {
        $query = "INSERT INTO `users`(`user_login`, `user_pass`, `user_name`) VALUES (?,?,?)";
        $pdoStat = $pdo->prepare($query);
        $result = $pdoStat->execute([$login, $pass, $name]);
        if ($result) {
            $userId = $pdo->lastInsertId();
            $query = "INSERT INTO `images`(`img_path`, `user_id`, `img_select`) VALUES (?,?,?)";
            $pdoStat = $pdo->prepare($query);
            $pdoStat->execute([$path, $userId, 1]);
        }
        return true;
    } else if ($newUser['user_login'] === $login) {
        return "userError=1";
    }
}

function userAuth($login, $pass)
{
    $login = strip_tags(strtolower($login));
    $pdo = db();
    $query = "SELECT `user_id`, `user_login`, `user_pass` FROM `users` WHERE `user_login`=?";
    $pdoStat = $pdo->prepare($query);
    $pdoStat->execute([$login]);
    $user = $pdoStat->fetch(PDO::FETCH_ASSOC);
    if ($login === $user['user_login'] && password_verify($pass, $user['user_pass'])) {
        session_start();
        $_SESSION['id'] = $user['user_id'];
        return true;
    }
    return false;
}

function userInfo()
{
    session_start();
    $userId = $_SESSION['id'];
    $pdo = db();
    $query = "SELECT `user_login`, `user_name`, images.img_path FROM `users` JOIN `images` USING(user_id) WHERE user_id=? AND `img_select`=?";
    $pdoStat = $pdo->prepare($query);
    $pdoStat->execute([$userId, 1]);
    return $pdoStat->fetch(PDO::FETCH_ASSOC);
}

function userAddPhoto($path)
{
    session_start();
    $userId = $_SESSION['id'];
    $pdo = db();
    $query = "INSERT INTO `images`(`img_path`, `user_id`) VALUES (?,?)";
    $pdoStat = $pdo->prepare($query);
    return $pdoStat->execute([$path, $userId]);
}

function userGetPhotos()
{
    session_start();
    $userId = $_SESSION['id'];
    $pdo = db();
    $query = "SELECT * FROM `images` WHERE `user_id`=?";
    $pdoStat = $pdo->prepare($query);
    $pdoStat->execute([$userId]);
    return $pdoStat->fetchAll(PDO::FETCH_ASSOC);
}
function userChangeAva($imgId)
{
    session_start();
    $userId = $_SESSION['id'];
    $pdo = db();
    $query = "UPDATE `images` SET `img_select`=0 WHERE `user_id`=?";
    $pdoStat = $pdo->prepare($query);
    $result = $pdoStat->execute([$userId]);
    if ($result) {
        $query = "UPDATE `images` SET `img_select`=1 WHERE `user_id`=? AND `img_id`=?";
        $pdoStat = $pdo->prepare($query);
        return $pdoStat->execute([$userId, $imgId]);
    }
}
function userDelPhoto($imgId)
{
    session_start();
    $userId = $_SESSION['id'];
    $pdo = db();
    $query = "SELECT `img_path`, `img_select` FROM `images` WHERE `user_id`=? AND `img_id`=?";
    $pdoStat = $pdo->prepare($query);
    $pdoStat->execute([$userId, $imgId]);
    $result = $pdoStat->fetch(PDO::FETCH_ASSOC);
    if ($result['img_select'] != 1) {
        unlink("../../{$result['img_path']}");
        $query = "DELETE FROM `images` WHERE `user_id`=? AND `img_id`=?";
        $pdoStat = $pdo->prepare($query);
        return $pdoStat->execute([$userId, $imgId]);
    }
}

function userAddComment($descr)
{
    session_start();
    $userId = $_SESSION['id'];
    $text = htmlspecialchars($descr);
    $time = time();
    $pdo = db();
    $query = "INSERT INTO `comment`(`comment_time`, `comment_text`, `user_id`) VALUES (?,?,?)";
    $pdoStat = $pdo->prepare($query);
    return $pdoStat->execute([$time, $text, $userId]);
}
function userDeleteComment($commentId)
{
    session_start();
    $userId = $_SESSION['id'];
    $pdo = db();
    $query = "DELETE FROM `comment` WHERE `user_id`=? AND `comment_id`=?";
    $pdoStat = $pdo->prepare($query);
    return $pdoStat->execute([$userId, $commentId]);
}
function userCommentTextById($commentId)
{
    session_start();
    $userId = $_SESSION['id'];
    $pdo = db();
    $query = "SELECT `comment_id`, `comment_text` FROM `comment` WHERE `comment_id`=? AND `user_id`=?";
    $pdoStat = $pdo->prepare($query);
    $pdoStat->execute([$commentId, $userId]);
    return $pdoStat->fetch(PDO::FETCH_ASSOC);
}
function userEditComment($commentId, $commentText)
{
    session_start();
    $userId = $_SESSION['id'];
    $text = htmlspecialchars($commentText);
    $pdo = db();
    $query = "UPDATE `comment` SET `comment_text`=? WHERE `comment_id`=? AND `user_id`=?";
    $pdoStat = $pdo->prepare($query);
    return $pdoStat->execute([$text, $commentId, $userId]);
}
function getAllComments()
{
    $pdo = db();
    $query = "SELECT `comment`.`comment_time`, `comment`.`comment_id`,  `comment`.`comment_text`, `user_id`, `user_name`, `images`.`img_path` FROM `comment` JOIN `images` USING(`user_id`) JOIN `users` USING(`user_id`) WHERE `images`.`img_select`=1";
    $pdoStat = $pdo->prepare($query);
    $pdoStat->execute();
    return $pdoStat->fetchAll(PDO::FETCH_ASSOC);
}
