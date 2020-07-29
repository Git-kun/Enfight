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
<h1 class="font-weight-normal">メモ作成</h1>

</header>

<main>
<h2>メモ詳細画面</h2>
<?php 
require('dbconnect.php');

 $id = $_REQUEST['id'];
 if (!is_numeric($id) || $id <= 0) { //パラメータの中身が数字でないまたは0以上かを確認する
  print('1以上の数字で指定してください');
  exit();

 }

$memos = $db->prepare('SELECT * FROM memos WHERE id=?'); //prepareならidの受け渡しが安全
$memos->execute(array($id)); //?に入るものをarrayで指定する
$memo = $memos->fetch();
?>
<article>
  <pre><?php print($memo['memo']); ?></pre>

  <a href="update.php?id=<?php print($memo['id']); ?>">編集する</a>  <!-- 編集ページ(update.php)へのリンク -->
  |
  <a href="delete.php?id=<?php print($memo['id']); ?>">削除する</a>  <!-- 削除完了ページ(delete.php)へのリンク -->
  |
  <a href="index.php">戻る</a>
</article>
</main>
</body>    
</html>