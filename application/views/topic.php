<?php 
	include 'common/header_common.php';
	include 'common/generate.php';	
	include 'common/kindeditor.php';
	include 'common/header_syntaxhighlighter.php';
?>
	
    <script src="../../static/js/pagination.js"></script>
	<script type='text/javascript'>
		
		$(document).ready(function()
		{
			refresh_common_href(true);
						
			var first_load = true;
			var reply_per_page = <?php echo $site_topic_reply_per_page;?>;
			var floor_id = <?php echo $reply_now;?>;
			
			var arr=[];
			arr['topic_id']   = <?php echo $topic_id;?>;
			arr['reply_page'] = Math.ceil(floor_id / reply_per_page);
			arr['topic_name'] = '<?php echo $site_title;?>';
			arr['reply_num'] = <?php echo $reply_num;?>;
			
			
			$.extend(
			{	
				change_url: function()
				{
					var stateObject = {};
					var title = "";
					var newUrl = '/topic/' + arr['topic_id'] + '/' + floor_id;
					history.pushState(stateObject,title,newUrl);
					refresh_common_href(true);
				},
				
				reply_list_change: function(result, reply_num)
				{
					$.change_url();
					arr['reply_num'] = reply_num;
					$("#reply_list").html(result);
					if (floor_id % reply_per_page != 1 && floor_id <= arr['reply_num'])
					{
						setTimeout(function(){$("body,html").animate({scrollTop:$("#reply_"+floor_id).offset().top-15},0);},0.1);
					}
					else if (!first_load)
					{
						setTimeout(function(){$("body,html").animate({scrollTop:$("#reply_list").offset().top-100},0);},0.1);
					}
					first_load = false;
					SyntaxHighlighter.highlight();
					$("a.ji-pagination").click(function(e)
					{
						var data = [];
						data.max_page = Math.ceil(arr['reply_num'] / reply_per_page);
						data.page_id = $(e.target).attr("pageid");
						data.step = <?php echo $site_topic_pagination_step;?>;
						data.page_now = arr['reply_page'];
						
						pagination_change(data);
						
						if (data.page_now != arr['reply_page'])
						{
							arr['reply_page'] = data.page_now;
							floor_id = reply_per_page * (arr['reply_page'] - 1) + 1;
							generate_reply_list(arr, $.reply_list_change);
						}
					});	
				}
			});
			
			
			
			generate_reply_list(arr, $.reply_list_change);
			
			$("#reply_button").click(function(e)
			{
				if (editor.count('text') >= <?php echo $site_editor_count_max;?>)
				{
					alert("帖子长度超过限制");
					return;
				}
				var content = editor.html();
				if (content == '')
				{
					alert("请输入回复内容");
					return;
				}
				content = content.replace(',', '&cedil;');
				$.ajax
				({
					type: 'POST',
					url: '<?php echo base_url("ajax/reply_submit")?>',
					data:
					{
						content: content,
						topic_id: arr['topic_id'],
						reply_id: 0
					},
					success: function(data)
					{
						//alert(data);
						switch(data)
						{
							case 'topic undefined'   : alert('发送失败：帖子不存在'); break;
							case 'user undefined'    : alert('发送失败：用户未登录'); break;
							case 'content undefined' : alert('发送失败：回复内容为空'); break;
							default:
								floor_id = data;
								arr['reply_num'] = data;
								arr['reply_page'] = Math.ceil(floor_id / reply_per_page);
								generate_reply_list(arr, $.reply_list_change);
								editor.html('');
						}
					},
					error: function()
					{
						alert('发送失败');
					},
					dataType: 'text'
				});
			});
			
			
		});

	</script>
    
	    

	<div class="container">
    	<div id="reply_list">
            <!-- Generated by jQuery -->
        </div>
        
        <div id="editor_form" style="display:none">
            <form>
                <textarea name="content" style="width:100%;height:250px;visibility:hidden;"></textarea>
            </form>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <button id="reply_button" class="btn btn-default">回复</button>
                </div>
    
                <div class="col-md-9 text-right">
                    <div id="word_count" class="text-right">
                        <!-- Generated by jQuery -->
                    </div>
                </div>
            </div>
            
        </div>
        
        <?php include 'common/editor_login.php';?>
        
        
    </div><!-- /.container -->

<?php include 'common/footer_common.php';?>
</body>
</html>