
<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/style.css">

<title>PHP</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">投稿一覧</h1>    
</header>

<main>
<h2>投稿画面</h2>
<pre>
<?php
session_start(); //セッションを使用する
require('dbconnect.php'); //DBに接続

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) { //1時間何もしないとセッション値はなくなりログアウトされる
    $_SESSION['time'] = time(); //何かアクションを起こした時の時間に更新する

    $members = $db->prepare('SELECT * FROM members WHERE id=?'); //DBのmembersの中から決まったidをひっぱり出す
    $members->execute(array($_SESSION['id'])); //セッションに入っているidを$membersとする
    $member = $members->fetch(); //取得したデータを代入
} else {
    header('Location: login.php');
    exit();
}

if (!empty($_POST)) { //もし$_POSTに値が入っていれば
    if ($_POST['memo'] !== '') { //もしmemoが空でなけらば
        $statement = $db->prepare('INSERT INTO memos SET memo=?, member_id=?, created_at=NOW()'); //postのデータが安全に渡される為の記述
        $statement->execute(array($_POST['memo'],$member['id'])); //ここでは上の「?」に入る値を指定する
        echo 'メッセージが登録されました';
        // header('Location: input_do.php');
        // exit();
    } else {
    echo '*空欄ではメモれません';
    }
}

?>
</pre>

<a href="index.php">投稿一覧へ</a>
|
<a href="input.php">もう一度メモ</a>
</main>
</body>    
</html>