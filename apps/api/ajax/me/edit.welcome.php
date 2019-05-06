<?php


	$color=HTML::inputInt("color");
	if (inrange($color,1,9)){
		Client::$viewer->color=$color;
		Client::$viewer->edit('color');
	}

	Client::$viewer->title=HTML::inputInline("title");
	if (!Client::$viewer->title){
		Ajax::release("Vui lòng điền thông tin chức vụ của bạn.");
	}
	
	Client::$viewer->data->phone=HTML::inputInline("phone");
	if (!Valid::phone(Client::$viewer->data->phone)){
		Ajax::release("Vui lòng nhập số điện thoại của bạn.");
	}
	
	
	$code=FileDB::upload("image", Client::$viewer);
	
	if ($code->good()){
		FileDB::setTransparency(false);
		$id=$code->message->id();
		Client::$viewer->setGlobalAvatar($id);
	}else if (!Client::$viewer->image){
		Ajax::release("Có lỗi khi tải ảnh, hoặc ảnh quá lớn(kích thước vượt quá 2000x2000 px). Xin vui lòng tải lại ảnh đại diện.");
	}
	
	
	
	// Post to company network
	
	$root=Client::$system->rootNetwork();
	if (!$root || !$root->good()){
		Ajax::release("Invalid Network");
	}
	
	
	// Hack
	$user=Client::$viewer;
	
	if (Client::$system->path != 'daily' && Client::$system->path != 'uni') {
		$update = Update::system($user, $root, "vừa gia nhập <b>".SITENAME."</b>. Chúc Anh/Chị sức khoẻ và thành công!", new CustomStructure([
						"Họ và tên"=>$user->name,
						"Chức vụ"=>$user->title,
						"Số điện thoại"=>$user->data->get("phone"),
						"Email"=>$user->email,
		]));
	} else {
		// get MOG units
		$tokenObj = \MOG\MOGHelper::getInsiderToken();
		if (!$tokenObj) {
			Ajax::release("Can not get Insider Token");
		}
		$insiderAccessToken = $tokenObj->access_token;
		$insiderTokenType = $tokenObj->token_type;
		$insiderRefreshToken = $tokenObj->refresh_token;
		
		$unitsObj = \MOG\MOGHelper::getOrgUnits($insiderAccessToken);
		
		$arrUnits = [];
		if ($unitsObj->status->code == 0) {
			$arrUnits = $unitsObj->orgUnits;
		}
		$unit_name = "MOG";
		$mog_unit_code = $user->data->get('mog_unit_code');
		if(count($arrUnits) > 0 && $mog_unit_code != "") {
			$cArray = explode("-", $mog_unit_code);
			$cCode = $cArray[0];
			foreach ($arrUnits as $unit) {
				if($unit->id == $cCode) {
					$unit_name = $unit->name;
					break;
				}
			}
		}
		
		$update=Update::system($user, $root, "vừa gia nhập <b>".Client::$system->name."</b>. Chúc Anh/Chị sức khoẻ và thành công!", new CustomStructure([
						"Họ và tên"=>$user->name,
						"Chức vụ"=>$user->title,
						"Số điện thoại"=>$user->data->get("phone"),
						"Email"=>$user->email,
						"Thông tin đơn vị"=>$unit_name,
						"MOG Daily username"=>$user->username
		]));
	}
	
	
	
	
	OnBoard::markLearned("welcome");
	Client::$viewer->save();
	Client::$viewer->unload();
	
	Ajax::release(Code::success("Đã lưu thông tin cá nhân."));
?>