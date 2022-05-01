<?php
require_once(dirname(__FILE__).'/../functions/require.php');
try {
	session_start();

	$pdo = connectDb();

	$request_path = $_REQUEST['path'];

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

		//blog_entry_code,image_codeを取得
		$sql = "select * from blog_entry where client_id = :client_id limit 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":client_id" => $client['id']
		);
		$stmt->execute($params);
		$blog_entry = $stmt->fetch();
		$blog_entry_code =$blog_entry['blog_entry_code'];

		$sql = "select * from blog_entry_image where client_id = :client_id limit 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":client_id" => $client['id']
		);
		$stmt->execute($params);
		$blog_entry_image = $stmt->fetch();
		$image_code =$blog_entry_image['image_code'];

		if(endsWith($request_path,'html')){
			$include_program ='/entry.php';
		} elseif (endsWith($request_path,'style.css')) {
			$include_program = '/style.php';
		} elseif (startsWith($request_path,'/'.$client_code.'/category')) {
			$include_program = '/list.php';
		} elseif (startsWith($request_path,'/'.$client_code.'/image')) {
			$include_program = '/image.php';
		} elseif (startsWith($request_path,'/'.$client_code.'/feed')) {
			$include_program = '/feed.php';
		} elseif (startsWith($request_path,'/'.$client_code.'/entry')) {
			$include_program = '/entry.php';
		} elseif ($request_path == '/'.$client_code.'/' or $request_path =='/'.$client_code){
			$include_program ='/list.php';
		} else {
			$include_program ='/error.php';
		}

			include(dirname(__FILE__).'/models/blog'.$include_program);
	unset($pdo);
} catch (Exception $e) {
	unset($pdo);
	exit;
}
