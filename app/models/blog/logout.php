<?php

$pdo = connectDb();

if (isset($_COOKIE['BLOG_SYSTEM'])) {
	$auto_login_key = $_COOKIE['BLOG_SYSTEM'];

	setcookie('BLOG_SYSTEM', '', time()-86400, '/');

	$sql = "delete from client_auto_login where c_key = :c_key";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(":c_key" => $auto_login_key));
}

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-86400, '/');
}

session_destroy();

unset($pdo);

header('Location:'.SITE_URL);

?>
