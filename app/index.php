<?php
require_once(dirname(__FILE__).'/url_list.php');
require_once(dirname(__FILE__).'/../functions/require.php');
try {
	session_start();

	$pdo = connectDb();

	$request_path = $_REQUEST['path'];
	// サインアップページの場合はログインチェック無し
	if ($request_path == '/signup/' || $request_path == '/signup.php') {
		include(dirname(__FILE__).'/models/client/signup.php');
	} else {
		// ログインチェック
		if (check_client_login()) {
			include(dirname(__FILE__).'/models/client/login.php');
		} else {
			// セッションからユーザ情報を取得
			$user = $_SESSION['USER'];

			// データベース（blogテーブル）からblog_idを取得する。
			$sql = "select * from blog where client_id = :client_id limit 1";
			$stmt = $pdo->prepare($sql);
			$params = array(
				":client_id" => $user['id']
			);
			$stmt->execute($params);
			$blog = $stmt->fetch();
			$blog_id =$blog['id'];

			if (isset($url_list[$request_path])) {
				// アクセスされたURLのプログラムに処理を移譲
				include(dirname(__FILE__).$url_list[$request_path]);
				//include(/home/luckypanda/www/blog-system-5884/app/models/blog/entry.php);
			}
		}

	}
	unset($pdo);
} catch (Exception $e) {
	unset($pdo);
	exit;
}
