<?php 

	/**
	 * @desc Edit accesses
	 */

	if (!\this\sysowner()){
		Ajax::release(Code::INVALID_AUTHENTICATION);
	}

	$user=\User::withUsername(HTML::inputInline("username"));
	
	if (!$user || !$user->good() || !$user->isGuest()){
		Ajax::release(Code::INVALID_DATA);
	}
	
	
	$password=HTML::inputInline("new_password");
	$password2=HTML::inputInline("new_password2");
	
	if ($password!=$password2){
		Ajax::release("Two passwords do not match");
	}
	
	if (!Valid::password($password)){
		Ajax::release("Invalid password");
	}
	
	$user->password=User::md5($password);
	$user->email=\sys\Guest::hashEmail($user->email());
	$user->edit("email, password");
	
	// @desc Edit password: sending email
	
	\mail\raw($user->email(), "[".\Client::$system->name."] Mật khẩu đăng nhập hệ thống ", "
			<p>Xin chào, <b>{$user->first_name}</b></p>
			<p>Mật khẩu của bạn trên <b>".\Client::$system->name."</b> đã được thay đổi. Dưới đây là thông tin tài khoản của bạn:</p>
			<p><b>Họ và tên:</b> &nbsp; {$user->name}</p>
			<p><b>Email:</b> &nbsp; {$user->email()}</p>
			<p><b>Tên người dùng:</b> &nbsp; @{$user->username}</p>
			<p><b>Mật khẩu mới:</b> &nbsp; {$password}</p>
			<p><b>Access point:</b> &nbsp; ".\Client::$system->path."</p>
			<p>Ngay bây giờ bạn có thể mở <a href='".\base\Base::domain("account")."'>hệ thống quản lý tài khoản</a> để bổ sung thông tin &amp; đổi mật khẩu và bắt đầu làm việc.</p>
				<div style='margin:20px 0'>
					<a href='".\base\Base::domain("account")."' style='padding: 12px 0; background-color: #4286f4; text-decoration:none; color:#fff; font-size: 16px; text-align:center; border-radius: 3px; display:block;'>Bắt đầu làm việc</a>
				</div>
			"
	);
	
	
	Ajax::release(Code::success());
	
?>