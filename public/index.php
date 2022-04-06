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
//	} elseif($request_path == '/client_code/') {
    } else {

		// 物理ディレクトリURL取得

		$uri = rtrim($_SERVER["REQUEST_URI"], '/');
		$client_code = substr($uri, strrpos($uri, '/') + 1);



		$sql = "select * from client where client_code = :client_code limit 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":client_code" => $client_code
		);
		$stmt->execute($params);
		$client = $stmt->fetch();
		$client_id =$client['id'];

		// データベース（blogテーブル）からblog_idを取得する。
		$sql = "select * from blog where client_id = :client_id limit 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":client_id" => $client['id']
		);
		$stmt->execute($params);
		$blog = $stmt->fetch();
		$blog_id =$blog['id'];

		echo h($blog_id);

    	if(substr($request_path , -4) =='html' or substr($request_path , -5) =='html/'){

			include(dirname(__FILE__).'/models/blog/entry.php');
    	} else {

			if (isset($url_list[$request_path])) {
				// アクセスされたURLのプログラムに処理を移譲
				include(dirname(__FILE__).$url_list[$request_path]);
        	} else {
				include(dirname(__FILE__).'/models/blog/error.php');
			}
    	}
	}
	unset($pdo);
} catch (Exception $e) {
	unset($pdo);
	exit;
}
