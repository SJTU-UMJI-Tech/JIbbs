<script src="../../../static/js/base64.js"></script>

<script type="text/javascript">
	function generate_array(data_str)
	{
		var raw_data = data_str.split(',');
		var data=[];
		for (var i=0;i<raw_data.length;i+=2)
		{
			data[String(raw_data[i])] = raw_data[i+1];
		}
		return data;
	}
	

	function generate_preview_topic(topic_data)
	{
		var result = 
			'<li class="media">' +
				'<div class="pull-right">' +
					'<span class="badge topic-comment"><a href="<?php echo base_url('topic')?>/' + topic_data['topic_id'] + '/' + topic_data['reply_num'] + '">' + topic_data['reply_num'] + '</a></span>' +
				'</div>' +
				'<a class="media-left" href="<?php echo base_url('member');?>/' + topic_data['user_name'] + '"><img class="img-rounded" src="' + get_avatar_path(topic_data['user_name'], topic_data['user_avatar'], '') + '" alt="' + topic_data['user_name'] + '_avatar"></a>' +
				'<div class="media-body">' +
					'<h4 class="media-heading topic-list-heading"><a href="<?php echo base_url('topic');?>/' + topic_data['topic_id'] + '">' + topic_data['topic_name'] + '</a></h4>' +
					'<p class="small text-muted">' +
						'<span><a href="<?php echo base_url('module');?>/' + topic_data['module_id'] + '">' + topic_data['module_name'] + '</a></span>&nbsp;•&nbsp;' +
						'<span><a href="<?php echo base_url('member');?>/' + topic_data['user_name'] + '">' + topic_data['user_name'] + '</a></span>&nbsp;•&nbsp;' +
						'<span>' + topic_data['time_ago'] + '</span>&nbsp;•&nbsp;' +
						'<span>最后回复来自 <a href="<?php echo base_url('member');?>/' + topic_data['user_reply_name'] + '">' + topic_data['user_reply_name'] + '</a></span>' +
					'</p>' +
				'</div>' +
			'</li>'
		;
		return result;
	}
	
	function generate_preview_list(list_data, callback_func)
	{
		$.ajax
		({
			type: 'GET',
  			url: '<?php echo base_url("ajax/get_preview_topic")?>',
  			data:
			{
				module_id: list_data['module_id'],
				first: 0,
				step: 10,
				order_field: 'UPDATE_TIMESTAMP',
				order: 'desc',
				key: ''
			},
  			success: function(data)
			{
				//alert(data);
				var result = '<hr class="smallhr">';
				if (data != '')
				{
					var raw_data = data.split('|');
					for (index in raw_data)
					{
						result += generate_preview_topic(generate_array(raw_data[index]));
						result += '<hr class="smallhr">';
					}
				}
				callback_func(result);
			},
			error: function()
			{
				callback_func('');
			},
  			dataType: 'text'
		});
		
	}
	
	function generate_reply(reply_data)
	{
		var content = Base64.decode(reply_data['content']);
		
		var result = 
			'<div class="panel-body" id="reply_' + reply_data['floor_id'] + '">' +
				'<div class="row show-grid">' +
					'<div class="col-md-3">' +
						'<center>' +
							'<br><img class="img-rounded" src="' + get_avatar_path(reply_data['user_name'], reply_data['user_avatar'], 'big') + '" alt="' + reply_data['user_name'] + '_avatar"><br>' +
							'<br><a href="<?php echo base_url('member');?>/' + reply_data['user_name'] + '"><h4>' + reply_data['user_name'] + '</h4></a><br>' +
						'</center>' +
					'</div>' +
					'<div class="col-md-9">' +
						content +
					'</div>' +
				'</div>' +
				'<div class="reply-foot text-right text-muted">' +
					'<span>' + reply_data['floor_id'] + '楼</span>&nbsp;•&nbsp;' +
					'<span>' + reply_data['create_time'] + '</span>' +
				'</div>' +
			'</div>'
		;
		return result;
	}

	function generate_reply_list(list_data, callback_func)
	{
		var reply_per_page = <?php echo $site_topic_reply_per_page;?>;
		$.ajax
		({
			type: 'GET',
  			url: '<?php echo base_url("ajax/get_topic_reply")?>',
  			data:
			{
				topic_id: list_data['topic_id'],
				first: (list_data['reply_page'] - 1) * reply_per_page,
				step: reply_per_page,
				order_field: 'floor_id',
				order: 'asc',
				key: ''
			},
  			success: function(data)
			{
				//alert(data);
				var result = '';
				if (data != '')
				{
					var pagination = generate_pagination(Math.floor(list_data['reply_page']), Math.ceil(list_data['reply_num'] / reply_per_page));
					result += pagination;
					var raw_data = data.split('|');
					var reply_num = 0;
					for (index in raw_data)
					{
						if (index == 0)
						{
							reply_num = raw_data[0];
						}
						else
						{
							if (index == 1)
							{
								result += '<div class="panel panel-default">';
								result += '<div class="panel-heading">' + list_data['topic_name'] +'</div>';
							}
							else
							{
								result += '<div class="panel panel-default">';
							}
							result += generate_reply(generate_array(raw_data[index])) + '</div>';
						}
					}
					result += pagination;
				}
				
				callback_func(result, reply_num);
			},
			error: function()
			{
				callback_func('', 0);
			},
  			dataType: 'text'
		});
	}
	
	function generate_pagination(page_now, page_num)
	{
		var step = <?php echo $site_topic_pagination_step;?>;
		var start = 1;
		var end = page_num;
		var result = 
			'<center>' +
				'<ul class="pagination">'
		;
		
		// First
		if (page_now >= 2 + step)
		{
			result += '<li><a class="ji-pagination" pageid="1" href="javascipt:void(0);">1</a></li>';
		}
		else
		{
			if (page_now == 1)
			{
				result += '<li class="disabled">';
			}
			else
			{
				result += '<li>';
			}
			result += 
                        '<a class="ji-pagination" pageid="1" href="javascipt:void(0);" aria-label="First">' +
                            '<span class="glyphicon glyphicon-fast-backward" pageid="1" aria-hidden="true"></span>' +
                        '</a>' +
                    '</li>'
			;
		}
		
		// Backward
		if (page_now == 1)
		{
			result += '<li class="disabled">';
		}
		else
		{
			result += '<li>';
		}
		result += 
					'<a class="ji-pagination" pageid="backward" href="javascipt:void(0);" aria-label="Backward">' +
						'<span class="glyphicon glyphicon-backward" pageid="backward" aria-hidden="true"></span>' +
					'</a>' +
				'</li>'
		;
		
		// Previous
		if (page_now == 1)
		{
			result += '<li class="disabled">';
		}
		else
		{
			result += '<li>';
		}
		result +=
                        '<a class="ji-pagination" pageid="previous" href="javascipt:void(0);" aria-label="Next">' +
                            '<span class="glyphicon glyphicon-chevron-left" pageid="previous" aria-hidden="true"></span>' +
                        '</a>' +
                    '</li>'
		;
		
		// Main
		if (page_now < 2 + step)
		{
			end = Math.min(step * 2 + 1, page_num);
		}
		else if (page_now >= page_num - step)
		{
			start = Math.max(1, page_num - step * 2);
		}
		else
		{
			start = page_now - step;
			end = page_now + step;
		}
		for (var i = start;i <= end;i++)
		{
			if (page_now == i)
			{
				result += '<li class="active">';
			}
			else
			{
				result += '<li>';
			}
			result += '<a class="ji-pagination" pageid="' + i + '" href="javascipt:void(0);">' + i + '</a></li>';
		}
		
		// Next
		if (page_now == page_num)
		{
			result += '<li class="disabled">';
		}
		else
		{
			result += '<li>';
		}
		result +=
                        '<a class="ji-pagination" pageid="next" href="javascipt:void(0);" aria-label="Next">' +
                            '<span class="glyphicon glyphicon-chevron-right" pageid="next" aria-hidden="true"></span>' +
                        '</a>' +
                    '</li>'
		;
		
		// Forward
		if (page_now == page_num)
		{
			result += '<li class="disabled">';
		}
		else
		{
			result += '<li>';
		}
		result += 
					'<a class="ji-pagination" pageid="forward" href="javascipt:void(0);" aria-label="Forward">' +
						'<span class="glyphicon glyphicon-forward" pageid="forward" aria-hidden="true"></span>' +
					'</a>' +
				'</li>'

		// Last
		if (page_now < page_num - step)
		{
			result += '<li><a class="ji-pagination" pageid="' + page_num + '" href="javascipt:void(0);">' + page_num + '</a></li>';
		}
		else
		{
			if (page_now == page_num)
			{
				result += '<li class="disabled">';
			}
			else
			{
				result += '<li>';
			}
			result += 
                        '<a class="ji-pagination" pageid="' + page_num + '" href="javascipt:void(0);" aria-label="Last">' +
                            '<span class="glyphicon glyphicon-fast-forward" pageid="' + page_num + '" aria-hidden="true"></span>' +
                        '</a>' +
                    '</li>'
			;
		}
		
		result +=
				'</ul>' +
			'</center>'
		;
		return result;

	}
</script>