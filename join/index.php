<?php
session_start(); //セッションを使用する
require('../dbconnect.php'); //DBに接続

if (!empty($_POST)) {  //入力フォームが空ではない時に以下のif文を走らせる
	if ($_POST['name'] === '') {
		$error['name'] = 'blank';
	}
	if (strlen($_POST['password']) < 6) {
		$error['password'] = 'length';
	}
	if ($_POST['password'] === '') {
		$error['password'] = 'blank';
	}
	if ($_POST['email'] === '') {
		$error['email'] = 'blank';
	}
	if (strlen($_POST['age']) > 2) {
		$error['age'] = 'length';
	}
	if ($_POST['age'] === '') {
		$error['age'] = 'blank';
	}
	$fileName = $_FILES['image']['name'];
	if (!empty($fileName)) {
		$ext = substr($fileName, -3); //ファイルの拡張子を得て変数に代入
		if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png') { //それぞれの拡張子でない場合
			$error['image'] = 'type'; //$error['image']に'type'を代入
		}
	}
	
	//アカウントの重複をチェック
	if (empty($error)) { //ここまででエラーは入っていないかのチェック
		$member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=?');
		$member->execute(array($_POST['email']));
		$record = $member->fetch();
		if ($record['cnt'] > 0) {
			$error['email'] = 'duplicate'; //エラーコード
		}

	}

	if (empty($error)) {
			$image = date('YmdHis') . $_FILES['image']['name'];
			move_uploaded_file($_FILES['image']['tmp_name'],'../member_picture/' . $image);
			$_SESSION['join'] = $_POST; //check.php(確認画面)でもセッションに入れた入力情報を表示する
			$_SESSION['join']['image'] = $image;
			header('Location: check.php'); //エラーがない場合は'check.php'へジャンプ
			exit();
	}
}

if ($_REQUEST['action'] == 'rewrite'  && isset($_SESSION['join'])) {
	$_POST = $_SESSION['join'];
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>会員登録画面</title>

	<link rel="stylesheet" href="../style.css" />
</head>

<body>
	<div id="wrap">
		<div id="head">
			<h1>会員登録画面</h1>
		</div>

		<div id="content">
			<p>次のフォームに必要事項をご記入ください。</p>
			<form action="" method="post" enctype="multipart/form-data">
				<dl>
					<dt>ニックネーム<span class="required">必須</span></dt>
					<dd>
						<input type="text" name="name" size="35" maxlength="255" value="<?php print(htmlspecialchars($_POST['name'], ENT_QUOTES)); ?>" />
						<?php if ($error['name'] === 'blank') : ?>
							<p class="error">* ニックネームを入力してください</p>
						<?php endif ?>
					</dd>
					<dt>パスワード(6文字以上)<span class="required">必須</span></dt>
					<dd>
						<input type="password" name="password" size="10" maxlength="20" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>" />
						<?php if ($error['password'] === 'length') : ?>
							<p class="error">* パスワードは6文字以上で入力してください</p>
						<?php endif ?>
						<?php if ($error['password'] === 'blank') : ?>
							<p class="error">* パスワードを入力してください</p>
						<?php endif ?>
					</dd>
					<dt>メールアドレス<span class="required">必須</span></dt>
					<dd>
						<input type="text" name="email" size="35" maxlength="255" value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>" />
						<?php if ($error['email'] === 'blank') : ?>
							<p class="error">* メールアドレスを入力してください</p>
						<?php endif ?>
						<?php if ($error['email'] === 'duplicate') : ?>
							<p class="error">* 指定されたメールアドレスは、既に登録されています</p>
						<?php endif ?>
					<dt>年齢<span class="required">必須</span></dt>
					<dd>
						<input type="age" name="age" size="3" maxlength="20" value="<?php print(htmlspecialchars($_POST['age'], ENT_QUOTES)); ?>" />
					</dd>
					<?php if ($error['age'] === 'length') : ?>
							<p class="error">* 適性な年齢を入力してください</p>
						<?php endif ?>
					<?php if ($error['age'] === 'blank') : ?>
							<p class="error">* 年齢を入力してください</p>
						<?php endif ?>
					<dt>性別<span class="required">必須</span></dt>
					<dd>
						<input type="radio" id="other" name="gender" value="3">
						<label for="other">指定なし</label><br>
						<input type="radio" id="male" name="gender" value="0">
						<label for="male">男性</label><br>
						<input type="radio" id="female" name="gender" value="1">
						<label for="female">女性</label><br>
					</dd>
					</dd>
					<dt>結婚<span class="required">必須</span></dt>
					<dd>
						<input type="radio" id="married" name="marital_status" value="0">
						<label for="married">既婚</label><br>
						<input type="radio" id="unmarried" name="marital_status" value="1">
						<label for="unmarried">未婚</label><br>
					</dd>


					<dt>アイコン写真など</dt>
					<dd>
						<input type="file" name="image" size="35" value="test" />
						<?php if ($error['image'] === 'type') : ?>
							<p class="error">* 写真などの拡張子は「.gif」または「.jpg」「.png」の画像を指定してください</p>
						<?php endif ?>
						<?php if (!empty($error)) : ?>
							<p class="error">* 恐れ入りますが、画像を改めて</p>
						<?php endif ?>
					</dd>
				</dl>
				<div><input type="submit" value="入力内容を確認する" /></div>
			</form>
		</div>
</body>

</html>