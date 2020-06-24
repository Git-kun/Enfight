<?php 
//データベースに接続
try {
  $db = new PDO('mysql:dbname=wordblog_enfight;host=mysql8033.xserver.jp;charset=utf8', 'wordblog_enfight', 'enfight2020');
} catch(PDOException $e) {  //うまく接続できなかった時のエラーメッセージの表示
  print('DB接続エラー:' . $e->getMessage());
}