<?php

//シーケンスを取得
$sql = "select * from blog_category_code_sequence where blog_id = :blog_id and client_id = :client_id limit 1";
	$stmt = $pdo->prepare($sql);
	$params = array(
		":blog_id" => $blog_id,
		":client_id" => $user['id']
	);
	$stmt->execute($params);
	$sequence = $stmt->fetch();

$id = $_GET['id'];

//カテゴリーを削除
$sql = "delete from blog_category_master where blog_category_code = :blog_category_code";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(":blog_category_code" => $id));

//シーケンスを更新
$sql = "update blog_category_code_sequence
		set
		sequence =:sequence,
		updated_at = now()
		where
		client_id = :client_id and
		blog_id = :blog_id";
$stmt = $pdo->prepare($sql);
$params = array(
	":sequence" => $sequence['sequence'] -1,
	":client_id" => $user['id'],
	":blog_id" => $blog_id
);
$stmt->execute($params);

// category.phpに画面遷移する。
header('Location: '.SITE_URL.'/blog/category/');
