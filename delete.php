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

    if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) { //URLにidを数字で入力しているかのチェック
        $id = $_REQUEST['id']; //idのURLパラメータを$idに代入
    
        $statement = $db->prepare('DELETE FROM memos WHERE id=?'); //指定されたidのmemosデータを削除
        $statement->execute(array($id)); //上の?を$idで指定する
    }
?>
<p>投稿を削除しました</p>
</pre>
<p><a href="index.php">投稿一覧へ</a></p>
</main>
</body>    
</html>