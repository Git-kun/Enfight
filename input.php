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

// if (!empty($_POST)) { //もし$_POSTに値が入っていれば
//   if ($_POST['memo'] !== '') { //もしmemoが空でなけらば
//       $statement = $db->prepare('INSERT INTO memos SET memo=?, member_id=?, created_at=NOW()'); //postのデータが安全に渡される為の記述
//       $statement->execute(array($_POST['memo'],$member['id'])); //ここでは上の「?」に入る値を指定する
//       echo 'メッセージが登録されました';
//   }
// }
?>

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
<h2>メモ内容</h2>

<form action="input_do.php" method="post">
  <textarea name="memo" cols="50" rows="10" placeholder="内容を記入してください"></textarea><br>
  <button type="submit">投稿する</button>
  |
  <a href="index.php">戻る</a>
</form>

</main>
</body>    
</html>