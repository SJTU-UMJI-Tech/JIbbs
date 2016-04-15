<?php 
	include 'common/header.php';
    include 'common/generate.php';
	include 'headers/kindeditor.php';
?>

    <script src="../../static/js/pagination.js"></script>
	<script type='text/javascript'>

		$(document).ready(function()
		{
			

		});
	</script>
	<div class="container">
    	<div class="row">	
    		<div class="col-md-8 col-lg-9">
            	<div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><strong>精彩聚焦</strong></h3>
                    </div>
                    <div class="panel-body" style="position:relative">
                    	<div class="ji-bg-building">
							<br><br><br><br><br><br><br><br><br><br><br><br>
                        </div>
                        <div class="ji-bg-text">
                        	<h4>
                            <br>
                        	欢迎访问 JIBBS 正式版 (v0.1.2) 过滤bug已修复！
                            <br><br>
                            感谢33位测试者提出的宝贵建议
							<br><br>
                            目前有大量功能仍在完善中
                            <br><br>
                            如个人资料完善，个人主页等
                            <br><br>
                            <a href="https://github.com/SJTU-UMJI-Tech/JIbbs/">欢迎访问我们的github</a>
                            <br><br>
                            有任何bug反馈和功能建议请直接在相关板块发帖或在issue中提出，谢谢！
                            </h4>
						</div>
                    </div>
                </div>
            	
                <?php include 'plugins/module_topic_list.php';?>
                
            </div><!-- /.col-md-8 -->

<?php include 'common/sidebar.php';?>

        </div><!-- /.row -->
        <div class="row">
        	<div class="col-md-12 col-lg-9">
            	
                <?php include 'plugins/editor_topic.php';?>
                
                <?php include 'plugins/editor_login.php';?>

            </div>
    	</div><!-- /.row -->
        
    </div><!-- /.container -->

<?php include 'common/footer.php';?>
</body>
</html>