<?php

$id = $_GET['id'];

//blog_category_masterのカテゴリーを削除
$sql = "delete from blog_category_master where blog_category_code = :blog_category_code";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(":blog_category_code" => $id));

//blog_categoryのカテゴリーを削除
$sql = "delete from blog_category where blog_category_master_id = :blog_category_master_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(":blog_category_master_id" => $id));

// category.phpに画面遷移する。
header('Location: '.SITE_URL.'/blog/category/');
