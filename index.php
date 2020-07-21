<?php
session_start(); //セッションを使用する
require('dbconnect.php'); //DBに接続

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) { //1時間何もしないとセッション値はなくなりログアウトされる
    $_SESSION['time'] = time(); //何かアクションを起こした時の時間に更新する

    $members = $db->prepare('SELECT * FROM members WHERE id=?'); //DBのmembersの中から決まったidをひっぱり出す
    $members->execute(array($_SESSION['id'])); //セッションに入っているidを$memberとする
    $member = $members->fetch(); //取得したデータを代入
} else {
    header('Location: login.php');
    exit();
}
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
<!-- <h1 class="font-weight-normal">ユーザー名</h1> -->
<dt><?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?> さん</dt>

</header>

<main>
<h2><a href="input.php">メモる!</a></h2>
<div style="text-align: right"><a href="logout.php" class="logoutbutton">ログアウト</a></div>
<?php 
require('dbconnect.php');

if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) { //URLにページ数が書いてない場合と数字でない場合はページを1とする
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}

$start = 5 * ($page - 1); //入力したページ数にページが飛ぶようにする

$memos = $db->prepare('SELECT * FROM memos ORDER BY id DESC LIMIT ?, 5'); //memosのデーブルの5件を入手し代入
$memos->bindParam(1, $start, PDO::PARAM_INT); //数字で値を渡す
$memos->execute()
?>

 <article>
     <?php while ($memo = $memos->fetch()): ?> <!-- fetchメソッドはテーブルのデータを一件ずつ取り出す文 -->
      <p><a href="memo.php?id=<?php print($memo['id']); ?>"><?php print(mb_substr($memo['memo'], 0, 50)); //mb_substrは長いメモを0,から50文字だけを表示する ?></a></p> <!-- $memoの中から'memo'カラムの項目をリンクで表示する -->
      <time><?php print($memo['created_at']); ?></time>
      <hr>
     <?php endwhile; ?>

      <?php if ($page >= 2): ?> <!--ページ数が2以下にならないようにする為のif文 -->
        <a href="index.php?page=<?php print($page-1); ?>"><?php print($page-1); ?>ページ目へ</a> <!-- 前のページへ戻るリンクとその文字列 -->
     <?php endif; ?>
     |
     <?php 
     $counts = $db->query('SELECT COUNT(*) as cnt FROM memos'); //取得したデータ件数をcntキーで取り出す
     $count = $counts->fetch();
     $max_page = ceil($count['cnt'] / 5); //データ数を5で割りその数字を切り上げる
     if ($page < $max_page):
     ?>
     <a href="index.php?page=<?php print($page+1); ?>"><?php print($page+1); ?>ページ目へ</a>
     <?php endif; ?>
    </article>
</main>
</body>    
</html>