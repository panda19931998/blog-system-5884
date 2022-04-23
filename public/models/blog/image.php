<?php
// リクエストされたイメージタイプを取得
$image_type = $_REQUEST['i'];

switch ($image_type) {
	case 'profile':
		$image_data = $client['client_profile_image'];
		$image_ext = $client['client_profile_image_ext'];
		break;

	case 'blog_header':
		$image_data = $blog['blog_header_image'];
		$image_ext = $blog['blog_header_image_ext'];
		break;

	case 'favicon':
		$image_data = $blog['blog_favicon_image'];
		$image_ext = 'png';
		break;

	case 'favicon180':
		$image_data = $blog['blog_favicon180_image'];
		$image_ext = 'png';
		break;

	case 'eyecatch_top':
		$image_data = $blog['blog_default_eye_catch_image'];
		$image_ext = $blog['blog_default_eye_catch_image_ext'];
		break;

	case 'eyecatch':
		// 記事コードを取得
		$blog_entry_code = $_REQUEST['e'];

		//$blog_entry = 記事コードから記事を取得する

		$sql = "select * from blog_entry where blog_entry_code = :blog_entry_code limit 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":blog_entry_code" => $blog_entry_code
		);
		$stmt->execute($params);
		$blog_entry = $stmt->fetch();


		if (!$blog_entry) {
			// 取得出来ない場合は404エラー
			throw new Exception('ブログ記事取得エラー', 404);
		}
		$image_data = $blog_entry['eye_catch_image'];
		$image_ext = $blog_entry['eye_catch_image_ext'];
		break;

	case 'entry_image':
		// 画像コードを取得
		$blog_entry_image_code = $_REQUEST['c'];

		//$blog_entry_image = 記事コードから記事を取得する

		$sql = "select * from blog_entry_image where image_code = :blog_entry_image_code limit 1";
		$stmt = $pdo->prepare($sql);
		$params = array(
			":blog_entry_image_code" => $blog_entry_image_code
		);
		$stmt->execute($params);
		$blog_entry_image = $stmt->fetch();

		if (!$blog_entry_image) {
			// 取得出来ない場合は404エラー
			throw new Exception('画像取得エラー', 404);
		}
		$image_data = $blog_entry_image['image'];
		$image_ext = $blog_entry_image['image_ext'];
		break;

}

if ($image_data) {
	// 画像を出力
	$fp = fopen('php://memory', 'r+');
	$result = fwrite($fp, $image_data, strlen($image_data));

	if ($result == strlen($image_data)) {
		header("Content-Type: image/".$image_ext);
		rewind($fp);
		fpassthru($fp);
	}
}
?>
