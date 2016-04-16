<?php
include 'common/header.php';
?>
    <script type='text/javascript'>
		function generate_settings_select(data)
		{
			var result = [
				'<div class="row">',
					'<h5><label class="col-sm-3 control-label text-center" style="margin-top:8px">', data.label, '</label></h5>',
					'<div class="btn-group">',
						'<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">',
						'<span id="settings-', data.name, '-text" sid="', (data.selected != null ? data.selected : 0), '"></span> <span class="caret"></span>',
						'</button>',
						'<ul class="dropdown-menu" style="max-height: 250px; overflow-y: auto;">'
			];
			for (var index in data.option)
			{
				if (data.option[index][0] < 0)
				{
					result.push(
							'<li role="separator" class="divider"></li>');
				}
				else
				{
					result.push(
							'<li><a sid="', data.option[index][0], '" class="settings-', data.name, '-option" href="javascript:void(0)">', data.option[index][1], '</a></li>');
				}
			}			
			result.push(
						'</ul>',
					'</div>',
				'</div>'
			);
			return result.join('');
		}
		
		function init_settings_select(data)
		{
			$(".settings-"+data.name+"-option").each(function()
			{
				if($(this).attr('sid') == data.selected)
				{
					$("#settings-"+data.name+"-text").html($(this).html());
					$("#settings-"+data.name+"-text").attr('sid', (data.selected != null ? data.selected : 0));
					if (data.onclick != undefined)
					{
						data.onclick(this);
					}
				}
			});
			$(".settings-"+data.name+"-option").click(function(e)
			{
				if ($("#settings-"+data.name+"-text").attr('sid') != $(e.target).attr('sid'))
				{
					$("#settings-"+data.name+"-text").html($(e.target).html());
					$("#settings-"+data.name+"-text").attr('sid', $(e.target).attr('sid'));
					data.selected = $(e.target).attr('sid');
					if (data.onclick != undefined)
					{
						data.onclick(e.target);
					}
				}
			});
		}
		
		$(document).ready(function()
		{
			var settings = [];
			
			settings[1] = 
			{
				name : 'user-type',
				label : '个人身份',
				selected : 0,
				option : 
				[
					[0 , ' - - '],
					[-1],
					[10, '本科生'],
					[11, '研究生'],
					[-1],
					[20, '家长'],
					[21, '老师'],
					[22, '毕业校友']
				],
				onclick : function(target)
				{
					var id = $(target).attr('sid');
					$("#settings-rows").html('');
					if (settings_config[id] != undefined)
					{
						for (var index in settings_config[id])
						{
							$("#settings-rows").append(generate_settings_select(settings[settings_config[id][index]]));
							init_settings_select(settings[settings_config[id][index]]);
						}
					}
				}
			};
			
			settings[2] = 
			{
				name : 'entrance-year',
				label : '入学时间',
				selected : 2015,
				option :
				[
				<?php
					for ($i = $site_ji_foundation_year; $i <= date('Y'); $i++)
					{
						echo '['.$i.', "'.$i.'"],';
					}
				?>
				]
			};
			
			settings[10] = 
			{
				name : 'grade',
				label : '年级',
				selected : 1,
				option :
				[
					[0, '大一'],
					[2, '大二'],
					[3, '大三'],
					[4, '大四'],
					[5, '大五'],
					[6, '大六']
				]
			}
			
			settings[20] =
			{
				name : 'major',
				label : '专业',
				selected : 0,
				option :
				[
					[0, ' - - '],
					[1, '电子信息工程（ECE）'],
					[2, '机械工程（ME）']
				]
			}
			
			settings[21] =
			{
				name : 'second-major',
				label : '第二专业',
				selected : 0,
				option :
				[
					[0, ' - - '],
					[1, '电子信息工程（ECE）'],
					[2, '机械工程（ME）']
				]
			}
			
			//alert(JSON.stringify(settings));
			
			
			var settings_config = [];
			settings_config[10] = [2, 10, 20, 21];
			
			
			$("#settings-user-type").append(generate_settings_select(settings[1]));
			init_settings_select(settings[1]);
			
			
			
			
			
			
		});
	</script>
    
    
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3">
            	<div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">设置</h3>
                    </div>
                    <div class="panel-body">
						<ul class="nav nav-pills nav-stacked">
                            <li role="presentation" class="active"><a href="#">个人资料</a></li>
                            <li role="presentation" class="disabled"><a href="#">暂未开放</a></li>
                            <li role="presentation" class="disabled"><a href="#">暂未开放</a></li>
                        </ul>
                    </div>
                </div>
        		
        	</div>
            <div class="col-md-8 col-lg-9">
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">个人资料</h3>
                    </div>
                    <div class="panel-body">
                    	<div class="ji-settings">
                            <div class="row">
                                <h5><label for="avatar_change" class="col-sm-3 control-label text-center">个人头像</label></h5>
                                <div id="avatar_change" class="col-sm-9">
                                    <?php include 'plugins/avatar_change.php';?>
                                </div>
                            </div>
                        </div>
                        <hr class="smallhr">
                        <div class="ji-settings" id="settings-row">
                        	<div id="settings-user-type">
                            
                            </div>
                            <div id="settings-rows">
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php include 'common/footer.php';?>
</body>
</html>