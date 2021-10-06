<?php

if(isset($_GET['id'])) {

	$id = $_GET['id'];

	//blog_entryの取得
	$sql = "select * from blog_entry where blog_entry_code = :blog_entry_code and client_id = :client_id and blog_id =:blog_id limit 1";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":blog_entry_code" => $id,
		":client_id" => $user['id'],
		":blog_id" =>  $blog['id']
	);
	$stmt->execute($params);
	$blog_entry = $stmt->fetch();

	if(isset($blog_entry['id'])) {

		//blog_category_masterのカテゴリーを削除
		$sql = "delete from blog_entry where id =:id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(":id" => $blog_entry['id']));

		//blog_entryの記事を削除
		$sql = "delete from blog_entry where blog_entry_code = :blog_entry_code";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(":blog_entry_code" => $blog_entry['blog_entry_code']));
	}
// blogに画面遷移する
header('Location: '.SITE_URL.'/blog/');
}

?>
