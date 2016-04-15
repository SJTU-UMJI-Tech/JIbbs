<?php
include 'common/header.php';
include 'headers/kindeditor.php';
include 'headers/text_validation.php';
?>
    <script type='text/javascript'>
		$(document).ready(function()
		{
			refresh_common_href_str('<?php echo $redirect_url;?>');
			$("[data-toggle='tooltip']").tooltip();
			// 验证后回调函数
			$.extend(
			{
				common_change: function(id, data, flag)
				{
					if(data == 'success')
					{
						data = '';
						$("#"+id+"_div").attr('class','form-group has-success has-feedback');
						$("#"+id+"_img").attr({'style':'display:inline', 'class':"glyphicon glyphicon-ok form-control-feedback"});
					}
					else
					{
						$("#"+id+"_div").attr('class','form-group has-error has-feedback');
						$("#"+id+"_img").attr({'style':'display:inline', 'class':"glyphicon glyphicon-remove form-control-feedback"});
					}
					if(flag)
					{
						$("#"+id+"_error").html(data);
					}
				},
				
				username_change_trig: function()
				{
					text_valid
					(
						$("#username").val(),
						"<?php echo $this->user_model->get_validation_rules('username');?>",
						'用户名',
						$.username_change
					);
				},
				
				username_change: function(data)
				{
					$.common_change('username', data, true);
				},
				
				password_change: function(data)
				{
					$.common_change('password', data, true);
					if($("#password_confirm").val() != '')
					{
						$.password_reconfirm();
					}
				},
				
				password_confirm_change: function(data)
				{
					$.common_change('password_confirm', data, true);
				},
				
				email_change_trig: function()
				{
					text_valid
					(
						$("#email").val(),
						"<?php echo $this->user_model->get_validation_rules('email');?>",
						'邮箱',
						$.email_change
					);
				},
				
				email_change: function(data)
				{
					$.common_change('email', data, true);
				},
				
				captcha_change: function(data)
				{
					$.common_change('captcha', data, false);
				},
				
				password_reconfirm: function()
				{
					if ($("#password_confirm").val() == '')
					{
						$.password_confirm_change('');
					}
					else if($("#password").val() == $("#password_confirm").val())
					{
						$.password_confirm_change('success');
					}
					else
					{
						$.password_confirm_change('两次输入密码不一致');
					}
				}
				
			});
			
			// 表单值重新填充
			var tempStr;
			tempStr="<?php echo set_value('username')?>";
			if(tempStr != '')
			{
				$("#username").val(tempStr);
				$.username_change_trig();
			}
			tempStr="<?php echo set_value('email')?>";
			if(tempStr != '')
			{
				$("#email").val(tempStr);
				$.email_change_trig();
			}
			
			// 检查 username 是否有效
			$("#username").change(function()
			{
				$.username_change_trig();
			});
			

			// 检查 password 是否有效
			$("#password").change(function()
			{
				text_valid(
					$("#password").val(),
					"<?php echo $this->user_model->get_validation_rules('password');?>",
					'密码',
					$.password_change
				);
			});
			
			// 检查 password_confirm 是否和 password 一致
			$("#password_confirm").change(function()
			{
				$.password_reconfirm();
			});
			
			// 检查 email 是否有效
			$("#email").change(function()
			{
				$.email_change_trig();
			});
			
			// 检查 captcha 是否正确
			$("#captcha").keyup(function()
			{
				text_valid(
					$("#captcha").val(),
					"<?php echo $this->user_model->get_validation_rules('captcha');?>",
					'验证码',
					$.captcha_change
				);
			});
			
			
			
		});
	</script>
    
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">欢迎注册</h3>
                    </div>
                    <div class="panel-body">
                        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                        <form action="<?php echo base_url('user/register').$redirect_url;?>" class="form-horizontal" role="form" method="post" accept-charset="utf-8">
                            <div id="username_div" class="form-group">
                                <label for="username" class="col-sm-2 control-label">用户名</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" data-toggle="tooltip" 
   title="3-12位的字母、数字、_和-">
                                    <span id="username_img" style="display:none" aria-hidden="true"></span>
                                </div>
                                <label for="username" class="col-sm-5 control-label-left" id="username_error"></label>
                            </div>
                            <div id="password_div" class="form-group">
                                <label for="password" class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                    <span id="password_img" style="display:none" aria-hidden="true"></span>
                                </div>
                                <label for="password" class="col-sm-5 control-label-left" id="password_error"></label>
                            </div>
                            <div id="password_confirm_div" class="form-group">
                                <label for="password_confirm" class="col-sm-2 control-label">确认密码</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm Password">
                                    <span id="password_confirm_img" style="display:none" aria-hidden="true"></span>
                                </div>
                                <label for="password_confirm" class="col-sm-5 control-label-left" id="password_confirm_error"></label>
                            </div>
                            <div id="email_div" class="form-group">
                                <label for="email" class="col-sm-2 control-label">邮箱</label>
                                <div class="col-sm-5">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                    <span id="email_img" style="display:none" aria-hidden="true"></span>
                                </div>
                                <label for="email" class="col-sm-5 control-label-left" id="email_error"></label>
           		            </div>
                            <div id="captcha_div" class="form-group">
                                <label for="captcha" class="col-sm-2 control-label">验证码</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="captcha" name="captcha" placeholder="Captcha">
                                    <span id="captcha_img" style="display:none" aria-hidden="true"></span>
                                </div>
                                <div class="col-sm-3" id="cap_img" onclick="get_cap_img()">
                                    <?php echo $cap_image; ?>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">注册</button>
                                </div>
                            </div>
                            <script type="text/javascript">
                            function get_cap_img(){
                              $.ajax({
                                url: '<?php echo base_url('user/refresh_cap_image');?>',
                                success: function(data) {
                                  $("#cap_img").html(data);
                              }});
                            }
                            </script>
                        </form>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

<?php include 'common/sidebar.php';
?>

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php include 'common/footer.php';
?>
</body>
</html>
