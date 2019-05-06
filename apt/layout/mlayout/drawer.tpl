<div id='drawer'>

	<div class='mask full-mask' onclick='M.drawer.hide();'></div>
	
	<div class='drawer'>
		<div class='cover url' data-xurl='account'>
			<div class='user'>
				<div class='image'><img src='<?php echo APT::xthumb(User::avatar(Client::$viewer->username));?>'/></div>
				<div class='name ap-xdot'><?php echo Client::$viewer->name;?></div>
				<div class='info main ap-xdot'><?php echo Client::$viewer->title;?></div>
				<div class='info ap-xdot'><?php echo Client::$viewer->email;?></div>
			</div>
		</div>
	
	
		
		<div class='section'>
			<div class='li-title'>Tài khoản</div>
			
			<div class='list'>
				<div class='li' onclick='Me.info.edit()'><div class='icon -ap icon-uniF11A'></div> Chỉnh sửa</div>
				<div class='li' onclick='Me.info.editPassword()'><div class='icon -ap icon-uniF149'></div> Đổi mật khẩu</div>
				<div class='li' onclick='Me.chooseColor()'><div class='icon -ap icon-uniF121'></div> Đổi màu hiển thị</div>
				<div class='li' onclick='Base.logout()'><div class='icon -ap icon-uniF127'></div> Logout</div>
			</div>
		</div>
	
	
		<div class='section'>
			<div class='li-title'><?php echo Client::$system->name; ?></div>
			
			<div class='list'>
				<div class='li url' data-url='company'><div class='icon -ap icon-uniF1AB'></div> Danh sách thành viên</div>
				<div class='li url' data-url='company/units'><div class='icon -ap icon-uniF1272'></div> Đơn vị nghiệp vụ</div>
				<div class='li url' data-url='guests'><div class='icon -ap icon-uniF106'></div> Tài khoản khách hàng</div>
			</div>
		</div>
	
	</div>

</div>


<script>

</script>