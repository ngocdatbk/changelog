<?php $app=get("app"); ?>

<div id='app-confirm'><div class='box'>
	
	<div class='image'><div class='icon'><img src='{% share_url}/apps/{{$app}}.png'></div></div>
	
	<div class='text'>
		<h1><?php echo Client::$system->name; ?></h1>
		Xác nhận đưa ứng dụng <b>{{$app}}</b> vào hệ thống của <b><?php echo Client::$system->name; ?></b>?
	</div>
	
	<div class='buttons'>
		<div class='button -cta left' onclick="Admin.sa.confirmApp('{{$app}}');">Xác nhận</div>
		<div class='button -cancel right url' data-url='account'>Bỏ qua</div>
	</div>
	
</div></div>