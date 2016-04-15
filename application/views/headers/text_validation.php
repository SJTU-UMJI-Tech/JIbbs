<script type="text/javascript">
	function text_valid(text, rules, display, callback_func)
	{
		$.ajax
		({
			type: 'POST',
  			url: '<?php echo base_url("ajax/text_validation")?>',
  			data: {text: text, rules: rules, display: display},
  			success: function(data)
			{
				callback_func(data);
			},
			error: function()
			{
				callback_func('服务器连接失败');
			},
  			dataType: 'text'
		});
	}
</script>