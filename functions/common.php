<?php


// データベースに接続する

function connectDb(){


	$param = "mysql:dbname=".DB_NAME.";host=".DB_HOST;

	try{

	$pdo = new PDO($param, DB_USER, DB_PASSWORD);

	$pdo->query('SET NAMES utf8;');


	return $pdo;

}catch (PDOException $e){

	echo $e->getMessage();

	exit;
}

}


//メールアドレスの存在チェック

function checkEmail($mail_address, $pdo){

	$sql = "select * from client where mail_address = :mail_address limit 1";

	$stmt = $pdo->prepare($sql);

	$stmt->execute(array(":mail_address" => $mail_address));

	$user = $stmt->fetch();


	return $user ? true : false;

}



//メールアドレスとパスワードからuserを検索する

function getUser($mail_address,$password,$pdo){

	$sql = "select * from client where mail_address = :mail_address and password =:password limit 1";

	$stmt = $pdo->prepare($sql);

	$stmt->execute(array(":mail_address" => $mail_address,":password" => $password));

	$user = $stmt->fetch();


	return $user ? $user : false;


}


//トークンを発行する処理

   function setToken(){

	   $token = sha1(uniqid(mt_rand(),true));

	   $_SESSION['sstoken']=$token;
   }

   //トークンをチェックする処理


   function checkToken(){

  	 if (empty($_SESSION['sstoken']) || ($_SESSION['sstoken'] != $_POST['token'])){


  	 echo '<html><head><meta charset="utf-8"></head><body>不正なアクセスです。</body></html>';

  	 exit;

  	 }
   }


   function h($original_str){

      	return htmlspecialchars($original_str,ENT_QUOTES,"UTF-8");
      }


	function random($length = 12){
	      return substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, $length);
	  }


?>
