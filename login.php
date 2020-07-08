<?php
session_start(); //セッションを使用する
require('dbconnect.php'); //DBに接続

if ($_COOKIE['email'] !== '') {
  $email = $_COOKIE['email'];
}

if (!empty($_POST)) { //emptyは[空である]という意味「!」が付けばその逆
  $email = $_POST['email']; //後で入力したアドレスで上書きをする
  if ($_POST['email'] !== '' && $_POST['password'] !== '') {
    $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
    $login->execute(array(
      $_POST['email'],
      sha1($_POST['password'])  //ログイン時もsha1で暗号化し照合する
    ));
    $member = $login->fetch();  //データが返ってきたらログイン

    if ($member) {  //$memberに値が入ればindex.phpを表示
      $_SESSION['id'] = $member['id']; //$member['id']を$_SESSION['id']に
      $_SESSION['time'] = time();  //今の時間も入れておく

      if ($_POST['save'] === 'on') { //ログイン情報の記録
        setcookie('email', $_POST['email'], time()+60*60*24*7);
      }

      header('Location: index.php');
      exit();
    } else {
      $error['login'] = 'failed';
    }
  } else {
    $error['login'] = 'blank';
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="style.css" />
  <title>ログインする</title>
</head>

<body>
  <div id="wrap">
    <div id="head">
      <h1>ログインする</h1>
    </div>
    <div id="content">
      <div id="lead">
        <p>メールアドレスとパスワードを記入してログインしてください。</p>
        <p>入会手続きがまだの方はこちらからどうぞ。</p>
        <p>&raquo;<a href="join/">入会手続きをする</a></p>
      </div>
      <form action="" method="post">
        <dl>
          <dt>メールアドレス</dt>
          <dd>
            <input type="text" name="email" size="35" maxlength="255" value="<?php print(htmlspecialchars($email, ENT_QUOTES)); ?>" />
          </dd>
          <dt>パスワード</dt>
          <dd>
            <input type="password" name="password" size="35" maxlength="255" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>" />
            <?php if ($error['login'] === 'blank') : ?>
              <p class="error">*メールアドレスとパスワードをご入力ください</p>
            <?php endif; ?>
            <?php if ($error['login'] === 'failed') : ?>
              <p class="error">*ログインに失敗しました。正しくご記入ください</p>
            <?php endif; ?>
          </dd>
          <dt>ログイン情報の記録</dt>
          <dd>
            <input id="save" type="checkbox" name="save" value="on">
            <label for="save">次回からは自動的にログインする</label>
          </dd>
        </dl>
        <div>
          <input type="submit" value="ログインする" />
        </div>
      </form>
    </div>
    <div id="foot">
      <p><img src="images/txt_copyright.png" width="136" height="15" alt="(C) H2O Space. MYCOM" /></p>
    </div>
  </div>
</body>

</html>