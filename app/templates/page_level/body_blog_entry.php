<!-- WISYWIG -->
<script src="<?php echo h(CONTENTS_SERVER_URL) ?>/assets/plugins/summernote/summernote.min.js"></script>
<script src="<?php echo h(CONTENTS_SERVER_URL) ?>/assets/plugins/summernote/lang/summernote-ja-JP.min.js"></script>
<!-- ON/OFFトグル -->
<script src="//gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
// WISYWIG
$('.summernote').summernote({
	placeholder: '',
	height: 500,
	toolbar: [
		// [groupName, [list of button]]
		['basic', ['undo', 'redo']],
		['style', ['bold', 'italic', 'underline', 'strikethrough']],
		['fontsize', ['fontsize']],
		['color', ['color']],
		['para', ['paragraph']],
		['table', ['hr', 'table']],
		['insert', ['link', 'relationentry']],
		['media', ['picture', 'video']],
		['custom1', ['h2', 'h3']],
		['custom2', ['list', 'listok']],
		['custom3', ['boxgreen', 'boxyellow']],
		['custom4', ['authorcomment', 'sourcecode']],
		['misc', ['codeview']]
	],
	fontNames: ["YuGothic","Yu Gothic","Hiragino Kaku Gothic Pro","Meiryo","sans-serif", "Arial","Arial Black","Comic Sans MS","Courier New","Helvetica Neue","Helvetica","Impact","Lucida Grande","Tahoma","Times New Roman","Verdana"],
	lang: "ja-JP",

	callbacks: {
		onImageUpload : function(files, editor, welEditable) {
			for (var i = files.length - 1; i >= 0; i--) {
				sendFile(files[i], this);
			}
		}
	}

});
</script>

<script src="<?php echo h(CONTENTS_SERVER_URL) ?>/assets/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>

<?php if ($err): ?>
	<script>
	swal(
		{
			text: "入力エラーがあります。",
			icon: "error",
			button: false,
			timer: 1500,
		}
	);
	</script>
<?php endif; ?>

<?php if ($complete_msg): ?>
	<script>
	swal(
		{
			text: "登録が正常完了しました。",
			icon: "success",
			button: false,
			timer: 1500,
		}
	);
	</script>
<?php endif; ?>

<!-- DATETIMEピッカー -->
<script src="<?php echo h(CONTENTS_SERVER_URL) ?>/assets/plugins/bootstrap-daterangepicker/moment.js"></script>
<script src="<?php echo h(CONTENTS_SERVER_URL) ?>/assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

<script>
$(document).ready(function() {
	// DATETIMEピッカー
	$('#datetimepicker1').datetimepicker({
		format : 'YYYY/MM/DD HH:mm',
	});
});
</script>


<script>
// 新規カテゴリー追加ボタンが押された時の処理
function create_category() {
	var inputVal = $("#new_category_name").val();
	if (inputVal != "") {
		// フォームデータを取得し、追加で送るデータを登録する
		var formData = new FormData();

		formData.append('category_name', inputVal);

		$.ajax({
			type: "POST",
			url: "/blog/entry/",
			data: formData,
			dataType : "json",
			processData: false,
			contentType: false,
		}).done(function(data){
		  //値を取り出す
		  var check_status = data['status'];
		  if (check_status == 1) {
			  var category_id = data['blog_category_code'];
			  $("#category_area").append('<li class="checkbox checkbox-css m-l-15 m-b-5"><input type="checkbox" id="category_'+category_id+'" name="category_id[]" value="'+category_id+'" checked /><label for="category_'+category_id+'">'+inputVal+'</label></li>');
			  $("#new_category_name").val('');
		  }
		}).fail(function(XMLHttpRequest, textStatus, error){
			alert(error);
		});
	}
}

</script>


<script>
$('form').on('change', 'input[type="file"]', function(e) {
	// アイキャッチ画像ファイルを選択した際にプレビューを表示する

	var file = e.target.files[0],
	reader = new FileReader(),
	$preview = $(".image-preview");

	t = this;

	// 画像ファイル以外の場合は何もしない
	if (file.type.indexOf("image") < 0) {
		return false;
	}

	// ファイル読み込みが完了した際のイベント登録
	reader.onload = (function(file) {
		return function(e) {
			// 既存のプレビューを削除
			$preview.empty();
			// .prevewの領域の中にロードした画像を表示するimageタグを追加
			$preview.append($('<img>').attr({
				src: e.target.result,
				width: "100%",
				class: "image-preview m-b-5",
				title: file.name
			}));
		};
	})(file);
	reader.readAsDataURL(file);
});


</script>

<script>
// プレビューボタンが押された時の処理
$('[data-click="preview"]').click(function(e) {
	var form = document.getElementById("mainform");

	form.action = "/blog/preview/";
	form.target = "_blank";
	form.submit();

	form.action = "";
	form.target = "_self";

});
</script>
