<script>
	$("#base-panel").hide();
	$("#master").css("left", 0);
</script>

<div id='guest-box'><div class='w'>

	<?php 
		$accesses=Client::$viewer->accesses;
		
		if (count($accesses)){
			echo "<h1>Select an app to start working</h1>";
		}
		foreach ($accesses as $app){
			$url=\base\Base::domain($app);
			echo "<a class='li' href='$url'>
				<span class='icon'><img src='".SHARE_URL."/apps/{$app}.png'/></span>
				<span class='name'>{$app}</span>
				<span class='link'>{$url}</span>
				</a>";
		}
		
		if (!$accesses){
			echo "<div class='none'>Tài khoản của bạn chưa được trao quyền truy cập bất kỳ ứng dụng nào. Vui lòng liên hệ với
					quản trị viên hệ thống <b>".Client::$system->name."</b> để được cấp quyền.</div>";
		}
	?>

</div></div>