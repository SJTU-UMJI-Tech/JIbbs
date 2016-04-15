<!DOCTYPE html>                                                                                                                                                       
<html lang="zh-cn"><head>                                                                                                                                                                
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/static/img/favicon.png">
    
    <!-- Local Scripts -->
    <!--
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>   
    <link href="/static/css/bootstrap.min.css" rel="stylesheet">
    -->
    <!-- End of Local Scripts -->
    
    <!-- Online Scripts -->
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <!-- End of Online Scripts -->
    
	<link href="/static/css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->                                                                            
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->                                                                                        
    <!--[if lt IE 9]>                                                                                                                                                 
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>                                                                                 
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>                                                                                  
    <![endif]-->
                                                                                                                                                   
    <script type="text/javascript">
		function get_avatar_path(username, avatar, type)
		{
			var path = '<?php echo base_url('uploads/avatar');?>/';
			if (avatar == null)
			{
				if (type != '')
				{
					path += type + '-';
				}
				path += 'default.png';
			}
			else
			{
				if (username != '')
				{
					path += username;
				}
				if (type != '')
				{
					path += '-' + type;
				}
				path += '.jpg';
			}
			return path;
		}
		
		function refresh_common_href_str(str)
		{
			$(".login_href").attr('href', '<?php echo base_url('user/login');?>' + str);
			$(".register_href").attr('href', '<?php echo base_url('user/register');?>' + str);
			$(".logout_href").attr('href', '<?php echo base_url('user/logout');?>' + str);	
		}
		
		function refresh_common_href()
		{
			refresh_common_href_str('?url=' + Base64.encodeURI(window.location.href));
		}
		
	</script>
      
    <title><?php echo $site_title;?> | <?php echo $site_name;?></title>                                                                                               
</head>                                                                                                                                                               
<body>                                                                                                                                                                
    <nav class="navbar navbar-default" role="navigation">                                                                                                             
        <div class="container">                                                                                                                                       
            <!-- Brand and toggle get grouped for better mobile display -->                                                                                           
            <div class="navbar-header">                                                                                                                               
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">                             
                    <span class="sr-only">Toggle navigation</span>                                                                                                    
                    <span class="icon-bar"></span>                                                                                                                    
                    <span class="icon-bar"></span>                                                                                                                    
                    <span class="icon-bar"></span>                                                                                                                    
                </button>                                                                                                                                             
                <a class="navbar-brand" href="<?php echo base_url();?>"><?php echo $site_name;?></a>                                                                  
            </div>                                                                                                                                                    
                                                                                                                                                                      
            <!-- Collect the nav links, forms, and other content for toggling -->                                                                                     
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">                                                                                  
                <ul class="nav navbar-nav">                                                                                                                           
                    <li<?php if (uri_string()=='') {echo ' class="active"';}?>><a href="<?php echo base_url();?>"><strong>首页</strong></a></li>                    
                    
                    <li<?php if (strpos(uri_string(), 'module')==0&&strpos(uri_string(), 'odule')==1) {echo ' class="active"';}?>><a href="<?php echo base_url('module/1');?>"><strong>模块</strong></a></li>                             
                    <li<?php if (uri_string()=='topic/add') {echo ' class="active"';}?>><a href="<?php echo base_url('topic/add');?>"><strong>发表</strong></a></li>                   
                </ul>                                                                                                                                                 
                <!--<form class="navbar-form navbar-left" role="search" action="http://www.google.com/search" method="get" target="_blank">                               
                    <div class="form-group">                                                                                                                          
                        <input type="text" class="form-control" placeholder="Search" name="q">                                                                        
                        <input type="hidden" name="sitesearch" value="<?php echo base_url()?>">                                                                       
                    </div>                                                                                                                                            
                </form>-->                                                                                                                                               
                <ul class="nav navbar-nav navbar-right">                                                                                                              
                    <?php if ($this->session->userdata('username')) : ?>                                                                                              
                    <li><a href="<?php echo base_url('member/'.$this->session->userdata('username')); ?>"><?php echo $this->session->userdata('username'); ?></a></li>
                    <?php if ($this->session->userdata('group_id')==1) {                                                                                              
                        echo '<li><a href="'. base_url('admin') . '">后台</a></li>';}?>                                                                               
                    <li><a href="<?php echo base_url('user/settings'); ?>">设置</a></li>                                                                                   
                    <li><a class="logout_href" href="<?php echo base_url('user/logout'); ?>">登出</a></li>                                                                                     
                    <?php else : ?>                                                                                                                                   
                    <li><a class="register_href" href="<?php echo base_url('user/register');?>">注册</a></li>                                                                                         
                    <li><a class="login_href" href="<?php echo base_url('user/login');?>">登录</a></li>                                                                                       
                    <?php endif;?>                                                                                                                                    
                </ul>                                                                                                                                                 
            </div><!-- /.navbar-collapse -->                                                                                                                          
        </div><!-- /.container -->                                                                                                                                    
    </nav>                                                                                                                                                            
    