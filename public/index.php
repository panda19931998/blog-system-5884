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

//		$uri = rtrim($_SERVER["REQUEST_URI"], '/');
//		$client_code = substr($uri, strrpos($uri, '/') + 1);

		$path_arr = explode('/',$_SERVER['REQUEST_URI']);
		$client_code = $path_arr[1];

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


		if($request_path == '/'.$client_code.'/entry'){
			$include_program ='/entry.php';
			include(dirname(__FILE__).'/models/blog'.$include_program);

		// ファイル名が「style.php」だった場合
		} elseif ($request_path == '/'.$client_code.'/style.css') {
			$include_program = '/style.php';
			include(dirname(__FILE__).'/models/blog'.$include_program);
		} elseif ($request_path == '/'.$client_code.'/category') {
			$include_program = '/list.php';
			include(dirname(__FILE__).'/models/blog'.$include_program);
		} elseif ($request_path == '/'.$client_code.'/image') {
			$include_program = '/image.php';
			include(dirname(__FILE__).$client_code.$include_program);
		} elseif ($request_path == '/'.$client_code.'/feed') {
			$include_program = '/feed.php';
			include(dirname(__FILE__).'/models/blog'.$include_program);
		} elseif ($request_path == '/'.$client_code.'/') {
			$include_program = '/list.php';
			include(dirname(__FILE__).'/models/blog'.$include_program);
		} elseif(substr($request_path , -4) =='html' or substr($request_path , -5) =='html/'){
			include(dirname(__FILE__).'/models/blog/entry.php');
		} else {
			include(dirname(__FILE__).'/models/blog/error.php');
		}
	}
	unset($pdo);
} catch (Exception $e) {
	unset($pdo);
	exit;
}
