<?php
include 'common/header.php';
?>
    
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-9">
				<div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">上传头像</h3>
                    </div>
                    <div class="panel-body">
						<?php print_r($error);?>
            
                        <?php echo form_open_multipart(base_url('user/avatar'));?>
                        
                        <input type="file" name="userfile" size="20" />
                        
                        <br /><br />
                        
                        <input type="submit" value="upload" />
                        
                        </form>
                    </div>
                </div>
            </div>
		
<?php include 'common/sidebar.php';?>

        </div><!-- /.row -->
    </div><!-- /.container -->

<?php include 'common/footer.php';?>
</body>
</html>