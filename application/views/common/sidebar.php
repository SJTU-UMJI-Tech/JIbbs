            <div class="col-md-4 col-lg-3">
                <div class="center-block">
                    <br>
                    <center>
                    	<img src="../../static/img/JIsign.png" height="150">
                    </center>
                    <br><br>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">你好<?php if ($this->session->userdata('username')) { echo '，'.$this->session->userdata('username');}?></h3>
                    </div>
                    <div class="panel-body">
                        <?php if ($this->session->userdata('username')) : ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <a href="<?php echo base_url('member/'.$this->session->userdata('username'));?>">
                                	<script type="text/javascript">
										$(document).ready(function()
										{
											$("#sidebar_avatar").attr('src', get_avatar_path('<?php echo $this->session->userdata('username');?>', '<?php echo $this->session->userdata('avatar');?>', ''));
										});
									</script>
                                    <img class="img-rounded img-responsive pull-left" id="sidebar_avatar" src="?" alt="avatar">
                                </a>
                                <p class="username"><a href="<?php echo base_url('member/'.$this->session->userdata('username'));?>"><?php echo $this->session->userdata('username');?></a></p>
                            </div>
                            <div class="user-panel">
                                <!--<div class="col-xs-4"><center><a href="<?php echo base_url('topic/show/nodes');?>"><p class="big-font"><?php echo $this->session->userdata('node_follow');?></p><p class="text-muted">动态</p></a></center></div>
                                <div class="col-xs-4 side-border"><center><a href="<?php echo base_url('topic/show/topics');?>"><p class="big-font"><?php echo $this->session->userdata('topic_follow');?></p><p class="text-muted">收藏</p></a></center></div>
                                <div class="col-xs-4"><center><a href="<?php echo base_url('topic/show/users');?>"><p class="big-font"><?php echo $this->session->userdata('user_follow');?></p><p class="text-muted">关注</p></a></center></div>-->
                            </div>
                        </div>
                        <?php else : ?>
                        <?php echo $site_introduction;?>
                        <?php endif; ?>
                    </div>
                    <div class="panel-footer">
                        <?php if ($this->session->userdata('username')) : ?>
                        <!--<a href="<?php echo base_url('notification');?>"><?php echo $this->session->userdata('notification');?> 条未读提醒</a>-->
                        <?php else : ?>
                        <a class="register_href" href="<?php echo base_url('user/register');?>">注册</a>　<a class="login_href" href="<?php echo base_url('user/login');?>">登录</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="panel panel-default">
                    <center class="panel-body">
                        <p>
                        	本网站由<a href="https://github.com/SJTU-UMJI-Tech/">JI技术部</a>开发
                            <br>服务器：李子涵
                            <br>架构：刘逸灏
                            <br>部分UI由周妍君完成
                        </p>
                    </center>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">社区运行状况</h3>
                    </div>
                    <div class="panel-body">
                        <p>注册会员：<?php echo $site_user_number;?></p>
                        <p>　　主题：<?php echo $site_topic_number;?></p>
                        <p>　　回复：<?php echo $site_reply_number;?></p>
                    </div>
                </div>
            </div><!-- /.col-md-4 -->
