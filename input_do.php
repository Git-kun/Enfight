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
    require('dbconnect.php');
    
    $statement = $db->prepare('INSERT INTO memos SET memo=?, member_id=?, created_at=NOW()'); //postのデータが安全に渡される為の記述
    $statement->execute(array($_POST['memo'],$member['id'])); //ここでは上の「?」に入る値を指定する
    echo 'メッセージが登録されました';
?>
</pre>
<a href="index.php">投稿一覧へ</a>
</main>
</body>    
</html>