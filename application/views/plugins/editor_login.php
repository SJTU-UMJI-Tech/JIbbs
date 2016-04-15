	<script type="text/javascript">
		$(document).ready(function()
		{
			if ('<?php echo $this->session->userdata('username');?>' == '')
			{
				$("#editor_form").attr('style','display:none');
				$("#editor_login").attr('style','');					
			}
			else
			{
				$("#editor_form").attr('style','');
				$("#editor_login").attr('style','display:none');
			}
		});
	</script>
        
    <div id="editor_login" class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"></h3>
        </div>
        <div class="panel-body">
            发帖前请 <a class="login_href" href="<?php echo base_url('user/login');?>">登录</a >
             或 <a class="register_href" href="<?php echo base_url('user/register');?>">注册</a>
        </div>
    </div>