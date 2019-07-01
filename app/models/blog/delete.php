<?php

$id = $_GET['id'];

if(isset($id)) {

	//blog_category_master_idの取得
	$sql = "select * from blog_category_master where blog_category_code = :blog_category_code and client_id = :client_id and blog_id =:blog_id limit 1";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":blog_category_code" => $id,
		":client_id" => $user['id'],
		":blog_id" =>  $blog['id']
	);
	$stmt->execute($params);
	$blog_category_master = $stmt->fetch();

	if(isset($blog_category_master['id'])) {

		//blog_category_masterのカテゴリーを削除
		$sql = "delete from blog_category_master where id =:id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(":id" => $blog_category_master['id']));

		//blog_categoryのカテゴリーを削除
		$sql = "delete from blog_category where blog_category_master_id = :blog_category_master_id";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(":blog_category_master_id" => $blog_category_master['id']));
	}
// category.phpに画面遷移する
header('Location: '.SITE_URL.'/blog/category/');
}
