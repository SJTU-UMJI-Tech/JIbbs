<?php
include 'common/header.php';
?>
    <script type='text/javascript'>
		function generate_settings_select(data)
		{
			var result = [
				'<div class="btn-group">',
                	'<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">',
					'<span id="settings-', data.name, '-text" sid="', (data.selected != null ? data.selected : 0), '"></span> <span class="caret"></span>',
					'</button>',
					'<ul class="dropdown-menu" style="height: 200px; overflow-y: scroll;">'
			];
			for (index in data.option)
			{
				if (data.option[index][0] < 0)
				{
					result.push(
						'<li role="separator" class="divider"></li>');
				}
				else
				{
					result.push(
						'<li><a sid="', data.option[index][0], '" class="settings-', data.name, '-option" href="javasrcipt:void(0)">', data.option[index][1], '</a></li>');
				}
			}			
			result.push(
					'</ul>',
				'</div>');
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
				$("#settings-"+data.name+"-text").html($(e.target).html());
				$("#settings-"+data.name+"-text").attr('sid', $(e.target).attr('sid'));
				if (data.onclick != undefined)
				{
					data.onclick(e.target);
				}
			});
		}
		
		$(document).ready(function()
		{
			var settings = [];
			
			settings[1] = 
			{
				name : 'user-type',
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
					switch(id)
					{
					case 0:
							
						break;
					case 10:
					
						break;
					}
				}
			};
			
			settings[2] = 
			{
				name : 'entrance-year',
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
			
			//alert(JSON.stringify(settings));
			
			$("#settings-row-1").append(generate_settings_select(settings[1]));
			init_settings_select(settings[1]);
			
			$("#settings-row-2").append(generate_settings_select(settings[2]));
			init_settings_select(settings[2]);
			
			var settings_config = [];
			settings_config[10] = [1];
			
			
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
                        <div class="ji-settings">
                        	<div class="row">
                                <h5><label class="col-sm-3 control-label text-center">个人身份</label></h5>
                                <div id="settings-row-1">
                                
                                </div>
                       		</div>
                        	<div class="row">
                                <h5><label class="col-sm-3 control-label text-center">入学年份</label></h5>
                                <div id="settings-row-2">
                                
                                </div>
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