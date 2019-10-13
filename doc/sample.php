<?php
// file_uploadファンクションの使い方
// 例）inputタグのname値が「blog_header_image」の場合

// ファイルアップロード
$file_upload_array = file_upload('blog_header_image', $err);
$blog_header_image = $file_upload_array['file'];
$blog_header_image_ext = $file_upload_array['ext'];
$err = $file_upload_array['err'];
?>

<?php
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
