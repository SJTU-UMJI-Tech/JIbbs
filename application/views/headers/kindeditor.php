
    <link href="../../../static/kindeditor/themes/default/default.css" rel="stylesheet">
    <script src="../../../static/kindeditor/kindeditor-min.js"></script>
    <script src="../../../static/kindeditor/lang/zh_CN.js"></script>
    
    <script type="text/javascript">
		var editor;
			
		KindEditor.ready(function(K)
		{
			editor = K.create('textarea[name="content"]', 
			{
				cssPath : ['../../../static/kindeditor/plugins/code/prettify.css'],
				allowFileManager : true,
				autoHeightMode : true,
				resizeType: 0,
				filterMode : true,
				afterCreate : function() {
					this.loadPlugin('autoheight');
				},
				afterChange : function() {
					var count = this.count('text');
					var max_count = <?php echo $site_editor_count_max;?>;
					if (count <= max_count)
					{
						$("#word_count").attr('class', '');
					}
					else
					{
						$("#word_count").attr('class', 'text-danger');
					}
					var result = '<h4>' + count + '/' + max_count + '字节</h4>';
					$("#word_count").html(result);
				}
			});
		});
	</script>