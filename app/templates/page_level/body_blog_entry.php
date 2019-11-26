<!-- WISYWIG -->
<script src="<?php echo h(CONTENTS_SERVER_URL) ?>/assets/plugins/summernote/summernote.min.js"></script>
<script src="<?php echo h(CONTENTS_SERVER_URL) ?>/assets/plugins/summernote/lang/summernote-ja-JP.min.js"></script>
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
