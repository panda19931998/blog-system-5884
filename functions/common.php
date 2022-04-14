<?php
// データベースに接続する
function connectDb() {
	$param = "mysql:dbname=".DB_NAME.";host=".DB_HOST;
	try{
		$pdo = new PDO($param, DB_USER, DB_PASSWORD);
		$pdo->query('SET NAMES utf8;');
		return $pdo;
	} catch (PDOException $e) {
		echo $e->getMessage();
		exit;
	}
}

//メールアドレスの存在チェック
function checkEmail($mail_address, $pdo) {
	$sql = "select * from client where mail_address = :mail_address limit 1";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(":mail_address" => $mail_address));
	$user = $stmt->fetch();

	return $user ? true : false;
}

//メールアドレスとパスワードからuserを検索する
function getUser($mail_address,$password,$pdo) {
	$sql = "select * from client where mail_address = :mail_address and password =:password limit 1";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(":mail_address" => $mail_address,":password" => $password));
	$user = $stmt->fetch();

	return $user ? $user : false;
}

//トークンを発行する処理
function setToken() {
	$token = sha1(uniqid(mt_rand(),true));
	$_SESSION['sstoken']=$token;
}

//トークンをチェックする処理
function checkToken() {
  	if (empty($_SESSION['sstoken']) || ($_SESSION['sstoken'] != $_POST['token'])) {
  		echo '<html><head><meta charset="utf-8"></head><body>不正なアクセスです。</body></html>';
		unset($_SESSION['sstoken']);
		exit;
	}
}

// HTMLエスケープ処理（XSS対策）
function h($original_str) {
    return htmlspecialchars($original_str,ENT_QUOTES,"UTF-8");
}

//クライアントコードを発行する
function random($length = 12) {
	return substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, $length);
}

// ログインチェック
function check_client_login() {
	return !isset($_SESSION['USER']) ? true : false;
}

// ユーザIDからuserを検索する
function getUserbyUserId($client_id, $pdo) {
    $sql = "select * from client where client_id = :client_id  limit 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(":clinet_id" => $client_id));
    $user = $stmt->fetch();

    return $user ? $user : false;
}

// ファイルアップロード($id, $err)
// 返却配列（0:ファイルポインタ、1:拡張子、2:エラー配列）


function file_upload($id, $err) {
	// アップロードを許可する画像タイプ
	// アップロードを許可する画像タイプ（1:GIF、2:JPEG、3:PNG、17:ICO）
	$image_types = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_ICO);

	$return_array = array();
	$fp = NULL;
	$extension = NULL;

	if ($id) {
		if ($_FILES[$id]['tmp_name']) {
			// 成功の場合も$_FILES[$id]['error']にUPLOAD_ERR_OK:0が入ってくるためここでコード存在チェック
			if (isset($_FILES[$id]['error']) && is_int($_FILES[$id]['error'])) {
				try {
					// $_FILES['upfile']['error'] の値を確認
					switch ($_FILES[$id]['error']) {
						case UPLOAD_ERR_OK: // 0:エラーはなく、ファイルアップロードは成功しています。
							break;
						case UPLOAD_ERR_INI_SIZE: // 1:アップロードされたファイルは、php.ini の upload_max_filesize ディレクティブの値を超えています。
						case UPLOAD_ERR_FORM_SIZE: // 2:アップロードされたファイルは、HTML フォームで指定された MAX_FILE_SIZE を超えています。
							throw new RuntimeException('ファイルサイズが大きすぎます。');
						default:
							throw new RuntimeException('エラーが発生しました。');
					}

					// $_FILES[$id]['mime']の値はブラウザ側で偽装可能なので、MIMEタイプを自前でチェックする
					$type = @exif_imagetype($_FILES[$id]['tmp_name']);
					if (!in_array($type, $image_types, true)) {
						throw new RuntimeException('未対応の画像形式です。');
					}

					if (!$info = @getimagesize($_FILES[$id]['tmp_name'])) {
						throw new RuntimeException("有効な画像ファイルを指定して下さい。");
					}

					$fp = fopen($_FILES[$id]['tmp_name'], 'rb');
					$extension = pathinfo($_FILES[$id]["name"], PATHINFO_EXTENSION);
				} catch (RuntimeException $e) {
					$err[$id] = $e->getMessage();
				}
			}
		}
	}
	$return_array['file'] = $fp;
	$return_array['ext'] = $extension;
	$return_array['err'] = $err;
	return $return_array;
}


function get_base64_header_string($file_extension) {
	switch (mb_strtolower($file_extension)) {
		case 'png':
		case 'ico':
		return 'data:image/png;base64,';
		break;
		case 'jpg':
		case 'jpeg':
		return 'data:image/jpg;base64,';
		break;
	}
}

function startsWith($haystack, $needle) {
    return (strpos($haystack, $needle) === 0);
}
?>
