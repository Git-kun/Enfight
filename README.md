[![Image from Gyazo](https://i.gyazo.com/5eaf21a4c6394662481cd595de6eb4a3.gif)](https://gyazo.com/5eaf21a4c6394662481cd595de6eb4a3)

<h2 align="left">簡易メモ</h2>
<br>

##  App URL

### **http://enfight.obearda.com/**
- メールアドレス：test@com
- パスワード：111111
　

##  開発環境

- 開発言語　　　　　：PHP（7.4）
- データベース　　　：MySQL（5.7）
- バージョン管理　　：GitHub　
- テキストエディター：VSCode（Visual Studio Code）

---

# DB設計
## membersテーブル
- 登録ユーザー

|Column|Type|Options|
|------|----|-------|
|id|int||
|name|var||
|email|varchar||
|password|varchar||
|age|tinyint||
|gender|varchar||
|picture|varchar||
|created|datetime||
|modified|timestamp||
<!-- ### Association
- has_many :items
- has_many :comments
- has_many :addresses
- has_one  :card
- has_one  :tell -->

## memosテーブル
- 投稿したメモ

|Column|Type|Options|
|------|----|-------|
|id|int||
|memo|text||
|member_id|int||
|reply_message_id|int||
|created_at|datetime||
|modified|timestamp||