<?php 
//データベースに接続
try {
  // $db = new PDO('mysql:dbname=wordblog_enfight;host=mysql8033.xserver.jp;charset=utf8', 'wordblog_enfight', 'masataka23');
  $db = new PDO('mysql:dbname=enfight;host=127.0.0.1;port=8889;charset=utf8','root', 'root');
} catch(PDOException $e) {  //うまく接続できなかった時のエラーメッセージの表示
  print('DB接続エラー:' . $e->getMessage());
}