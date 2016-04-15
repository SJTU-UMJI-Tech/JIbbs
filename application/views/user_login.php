<?php
include 'common/header.php';
include 'headers/kindeditor.php';
include 'headers/text_validation.php';
?>
    <script type='text/javascript'>
	
		$(document).ready(function()
		{
			refresh_common_href_str('<?php echo $redirect_url;?>');
			var result = '<?php echo $result;?>';
			$("[data-toggle='tooltip']").tooltip();
			if(result == 'error_username')
			{
				$("#username_div").attr('class','form-group has-error has-feedback');
				$("#username_img").attr({'style':'display:inline', 'class':"glyphicon glyphicon-remove form-control-feedback"});
				$("#username_error").html('用户名或邮箱不存在');
			}
			else if(result == 'error_password')
			{
				$("#username_div").attr('class','form-group has-success has-feedback');
				$("#username_img").attr({'style':'display:inline', 'class':"glyphicon glyphicon-ok form-control-feedback"});
				$("#username").val('<?php echo set_value('username')?>');
				$("#password_div").attr('class','form-group has-error has-feedback');
				$("#password_img").attr({'style':'display:inline', 'class':"glyphicon glyphicon-remove form-control-feedback"});
				$("#password_error").html('密码错误');
			}
			else if(result == 'error')
			{
				$("#username").val('<?php echo set_value('username')?>');
			}
			
			$("#captcha").keyup(function()
			{
				text_valid(
					$("#captcha").val(),
					"<?php echo $this->user_model->get_validation_rules('captcha');?>",
					'验证码',
					$.captcha_change
				);
			});
			
			$("#password").keyup(function()
			{
				$("#password_div").attr('class','form-group');
				$("#password_img").attr({'style':'display:none'});
				$("#password_error").html('');
			});
			
			$.extend(
			{
				captcha_change: function(data)
				{
					if(data == 'success')
					{
						$("#captcha_div").attr('class','form-group has-success has-feedback');
						$("#captcha_img").attr({'style':'display:inline', 'class':"glyphicon glyphicon-ok form-control-feedback"});
					}
					else
					{
						$("#captcha_div").attr('class','form-group has-error has-feedback');
						$("#captcha_img").attr({'style':'display:inline', 'class':"glyphicon glyphicon-remove form-control-feedback"});
					}
				}
			});
		});
	
	</script>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">请登录</h3>
                    </div>
                    <div class="panel-body">
                        <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                        <form action="<?php echo base_url('user/login').$redirect_url;?>" class="form-horizontal" role="form" method="post" accept-charset="utf-8">
                            <div id="username_div" class="form-group">
                                <label for="username" class="col-sm-2 control-label">用户名</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="User Name" data-toggle="tooltip" 
   title="请输入用户名或邮箱">
                                    <span id="username_img" style="display:none" aria-hidden="true"></span>
                                </div>
                                <label for="username" class="col-sm-4 control-label-left" id="username_error"></label>
                            </div>
                            <div id="password_div" class="form-group">
                                <label for="password" class="col-sm-2 control-label">密码</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" data-toggle="tooltip" 
   title="请输入密码，注意大小写">
                                    <span id="password_img" style="display:none" aria-hidden="true"></span>
                                </div>
                                <label for="password" class="col-sm-4 control-label-left" id="password_error"></label>
                            </div>
                            <div id="captcha_div" class="form-group">
                                <label for="captcha" class="col-sm-2 control-label">验证码</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="captcha" name="captcha" placeholder="Captcha" data-toggle="tooltip" 
   title="请输入验证码">
                                    <span id="captcha_img" style="display:none" aria-hidden="true"></span>
                                </div>
                                <div class="col-sm-3" id="cap_img" onclick="get_cap_img()">
                                    <?php echo $cap_image; ?>
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
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">登录</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- /.col-md-8 -->

<?php include 'common/sidebar.php';?>

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php include 'common/footer.php';?>
</body>
</html>