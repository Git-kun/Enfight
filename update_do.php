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
    
    $statement = $db->prepare('UPDATE memos SET memo=? WHERE id=?'); //変更するmemoの内容とどのidか指定する
    $statement->execute(array($_POST['memo'], $_POST['id'])); //上の?に入る値をarrayで指定
?>
<p>投稿の内容を変更しました</p>
</pre>
<p><a href="index.php">戻る</a></p>
</main>
</body>    
</html>