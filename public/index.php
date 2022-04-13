<?php
require_once(dirname(__FILE__).'/../functions/require.php');
try {
	session_start();

	$pdo = connectDb();

	$request_path = $_REQUEST['path'];

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


		if($request_path == '/'.$client_code.'/entry'or $request_path =='/'.$client_code.'/entry/'){
			$include_program ='/entry.php';
		// ファイル名が「style.php」だった場合
		} elseif ($request_path == '/'.$client_code.'/style.css'or $request_path =='/'.$client_code.'/style.css/') {
			$include_program = '/style.php';
		} elseif ($request_path == '/'.$client_code.'/category'or $request_path =='/'.$client_code.'/category/') {
			$include_program = '/list.php';
		}  elseif ($request_path == '/'.$client_code.'/image'or $request_path =='/'.$client_code.'/image/') {
			$include_program = '/image.php';
		} elseif ($request_path == '/'.$client_code.'/feed'or $request_path =='/'.$client_code.'/feed/') {
			$include_program = '/feed.php';
		} elseif ($request_path == '/'.$client_code.'/' or $request_path =='/'.$client_code.'') {
			$include_program = '/list.php';
		} elseif(substr($request_path , -4) =='html' or substr($request_path , -5) =='html/'){
			$include_program ='/entry.php';
		} else {
			$include_program ='/error.php';
		}

		$category = strrpos($path_arr[2], "category",0);

		if($category ===false){
			$include_program ='/error.php';
		} else {
			if(strlen($path_arr[2]) ==8){
				$include_program = '/list.php';
			}else{
				$include_program ='/error.php';
			}
		}
			include(dirname(__FILE__).'/models/blog'.$include_program);
	unset($pdo);
} catch (Exception $e) {
	unset($pdo);
	exit;
}
