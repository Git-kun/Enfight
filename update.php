<?php require('dbconnect.php'); ?>
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

<?php
if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])){ //正規に入力されたURLを$idに代入
  $id = $_REQUEST['id'];

  $memos = $db->prepare('SELECT * FROM memos WHERE id=?'); //データからmemosのidを取り出す
  $memos->execute(array($id));
  $memo = $memos->fetch();

}
?>


<form action="update_do.php" method="post">
  <input type="hidden" name='id' value="<?php print($id); ?>"> <!-- $idを画面が隠して(検証では見れる)状態で送る -->
  <textarea name="memo" cols="50" rows="10"><?php print($memo['memo']); ?></textarea><br> <!-- テキストエリアに投稿したメモを表示 -->
  <button type="submit">投稿する</button>
</form>
</main>
</body>    
</html>