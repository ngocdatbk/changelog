<?php 
	$user=get("user");
	$cv=get("cv");
	$units=get("units");
?>


<script>

	var managers=People.getList(Client.pageData.user.manager);
	if (managers.length){
		$("#js-managers").html(AP.render(managers, function(e){
			return "<p><span class='a url normal std' data-username='"+e.username+"'>"+e.name+"</span></p>";
		}));	
	}else{
		$("#js-managers").parent().hide();
	}
	

	var users=AP.array.filter(Client.people, function(e){
		return e.manager==Client.pageData.user.username;
	});

	$("#js-dreports .js-count").html("("+users.length+")");

	$("#js-dreports .js-items").html(AP.render(users, function(e){
		return "<div class='item url' data-url='user/"+e.username+"'>"+
			"<div class='name'>"+e.name+"</div>"+
			"<div class='info'>@"+e.username+" &middot; "+e.title+"</div>"+
			"<div class='icon'><span class='-ap icon-keyboard_arrow_right'></span></div>"+
		"</div>";
	}));
</script>


{% view layout/menu.tpl}

<div id='page-main'>
	{% view ~header.tpl}
	
	
	<div class='account-edit -cmenuw'>
		<span class='-ap icon-keyboard_arrow_down'></span>
		
		<div class='-cmenu -no-icon' style='width:250px; right:0px; top:30px;'>
			<div class='-item' onclick="Admin.edit('{{$user->username}}')">Chỉnh sửa: Thông tin cơ bản</div>
			
			<?php if ($user->id ==Client::$viewer->id || \this\sysadmin()):?>
			<div class='-item' onclick="Profile.cv.editContact(<?php echo $user->id;?>)">Chỉnh sửa: Thông tin liên hệ</div>
			<div class='-item' onclick="Profile.cv.editLinks(<?php echo $user->id;?>)">Chỉnh sửa: Liên kết mạng xã hội</div>
			<?php endif;?>
		</div>
	</div>
	
	<div id='profile'>
		
		<div class='main'>
			<div class='image url' data-url=':zoom' data-image='<?php echo User::avatar($user->username);?>'><img src='<?php echo APT::thumb(User::avatar($user->username));?>'/></div>
			<div class='text'>
				<div class='title'>
					<?php echo $user->name;?>
				</div>
				
				<div class='subtitle'>
					<?php printd($user->title, "No job title");?>
				</div>
				
				<div class='info'>
					<b>Email</b> <?php echo $user->email();?> 
				</div>
				
				<div class='info'>
					<b>Số điện thoại</b> <?php printd($user->phone(), "No phone number");?> 
				</div>
				
				<div class='info'>
					<b>Managers</b>
					<div class='' id='js-managers'></div>
				</div>
			</div>
			
		</div>
	
	
		<div class='list'>
			
			<div class='title'>
				Thông tin liên hệ
			</div>
	
			<?php 
				$contact=$user->releaseContacts();
				$ts=["office_phone"=>"Số điện thoại công ty", "home_phone"=>"Số điện thoại nhà", "skype"=>"Skype username", "whatsapp"=>"Whatsapp username", "viber"=>"Viber username", "zalo"=>"Zalo username", "address"=>"Địa chỉ nhà"];
				
				foreach ($contact as $k=>$v){
					if (!\Word::isEmpty($v)){
						echo "<div class='contact-info'><b>{$ts[$k]}</b> <span class='v'>{$v}</span></div>";
					}
				}
			?>
			
			<?php $hp=$cv->getLink("homepage");	
				if ($hp){
			?>
				<div class='contact-info ap-xdot'><b>Homepage</b> <a target='_blank' href='{{$hp}}'>{{$hp}}</a> </div>
			<?php } ?>
				
			
			<?php
				$fb=$cv->getLink("facebook");
				if ($fb){
			?>
				<div class='contact-info ap-xdot'><b>Facebook profile</b> <a target='_blank' href='{{$fb}}'>{{$fb}}</a> </div>
			<?php } ?>
				
			<?php
				$tt=$cv->getLink("twitter");
				if ($tt){
			?>
				<div class='contact-info ap-xdot'><b>Twitter profile</b> <a target='_blank' href='{{$tt}}'>{{$tt}}</a> </div>
			<?php } ?>
				
				
			<?php
				$li=$cv->getLink("linkedin");
				if ($li){
			?>
			<div class='contact-info ap-xdot'><b>Linkedin profile</b> <a target='_blank' href='{{$li}}'>{{$li}}</a> </div>
			<?php } ?>
		</div>
		
	
		<div class='list'>
			
			<div class='title'>
				Nhóm (đơn vị nghiệp vụ) <em>(<?php echo count($units); ?>)</em>
			</div>
			
			
			
			<?php 
				foreach ($units as $u){
					echo "<div class='item url' data-url='company/g/{$u->path}'>
					<div class='name'>{$u->name}</div>
					<div class='info'>
						{$u->num_people} thành viên &middot; Tham gia ngày ".APT::friendlyDate($u->ms->since)."
					</div>
					
					<div class='icon'>
						<span class='-ap icon-keyboard_arrow_right'></span>
					</div>
				</div>";
				}
			?>
			
			
			
		</div>
		
		
		
		
		<div class='list' id='js-dreports'>
			
			<div class='title'>
				Direct reports <em class='js-count'>()</em>
			</div>
			
			<div class='js-items'></div>
			
		</div>
		
		
		
		<div class='list'>
			<div class='title'>
				Học vấn
				
				<?php if ($user->same(Client::$viewer) || \this\sysadmin()):?>
				<div class='add' onclick="Profile.cv.add('education');">
					<span class='-ap icon-plus-circle'></span>
				</div>
				<?php endif; ?>
			</div>
			
			<?php 
				$rows=$cv->get('education');
				
				$actions="<div class='actions -cmenuw -relative'>
					<div class='-icon'><span class='-ap icon-keyboard_arrow_down'></span></div>
					<div class='-cmenu -rounded -no-icon' style='right:0px; top:24px; width:240px;'>
						<div class='-item' onclick='Profile.cv.edit(this);'>Chỉnh sửa</div>
						<div class='-item' onclick=\"Profile.cv.move(this,'up');\">Move up</div>
						<div class='-item' onclick=\"Profile.cv.move(this,'down');\">Move down</div>
						<div class='-item-sep'></div>
						<div class='-item red' onclick=\"Profile.cv.remove(this,'down');\">Xóa</div>
					</div>
				</div>";
				
				if (!$user->same(Client::$viewer)){
					$actions="";
				}
				
				foreach ($rows as $e){
					echo "<div class='item' data-id='{$e->id}' data-type='education'>
						<div class='name'>{$cv->display($e, 'major')}</div>
						<div class='subname'>{$cv->display($e, 'name')} &mdash; {$cv->display($e, 'time')}</div>
						{$actions}
					</div>";
				}
				
				if (!count($rows)){
					echo "<div class='item-none'>Không có thông tin.</div>";
				}
			?>
			
		
		</div>
		
		
		
		<div class='list'>
			<div class='title'>
				Kinh nghiệm làm việc
				
				<?php if ($user->same(Client::$viewer) || \this\sysadmin()):?>
				<div class='add' onclick="Profile.cv.add('work');">
					<span class='-ap icon-plus-circle'></span>
				</div>
				<?php endif; ?>
			</div>
			
			<?php 
				$rows=$cv->get('work');
				
				$actions="<div class='actions -cmenuw -relative'> 
					<div class='-icon'><span class='-ap icon-keyboard_arrow_down'></span></div>
					<div class='-cmenu -rounded -no-icon' style='right:0px; top:24px; width:240px;'>
						<div class='-item' onclick='Profile.cv.edit(this);'>Chỉnh sửa</div>
						<div class='-item' onclick=\"Profile.cv.move(this,'up');\">Move up</div>
						<div class='-item' onclick=\"Profile.cv.move(this,'down');\">Move down</div>
						<div class='-item-sep'></div>
						<div class='-item red' onclick=\"Profile.cv.remove(this,'down');\">Xóa</div>
					</div>
				</div>";
				
				if (!$user->same(Client::$viewer)){
					$actions="";
				}
				
				foreach ($rows as $e){
					echo "<div class='item' data-id='{$e->id}' data-type='work'>
						<div class='name'>{$cv->display($e, 'position')}</div>
						<div class='subname'>{$cv->display($e, 'name')} &mdash; {$cv->display($e, 'time')}</div>
						<div class='info'>{$cv->display($e, 'desc')}</div>
						{$actions}
					</div>";
				}
				
				if (!count($rows)){
					echo "<div class='item-none'>Không có thông tin.</div>";
				}
			?>
			
		</div>
	
	
	
	
		<div class='list'>
			<div class='title'>
				Giải thưởng &amp; thành tích
				
				<?php if ($user->same(Client::$viewer) || \this\sysadmin()):?>
				<div class='add' onclick="Profile.cv.add('award');">
					<span class='-ap icon-plus-circle'></span>
				</div>
				<?php endif; ?>
			</div>
			
			
			
			<?php 
				$rows=$cv->get('award');
				
				$actions="<div class='actions -cmenuw -relative'>
					<div class='-icon'><span class='-ap icon-keyboard_arrow_down'></span></div>
					<div class='-cmenu -rounded -no-icon' style='right:0px; top:24px; width:240px;'>
						<div class='-item' onclick='Profile.cv.edit(this);'>Chỉnh sửa</div>
						<div class='-item' onclick=\"Profile.cv.move(this,'up');\">Move up</div>
						<div class='-item' onclick=\"Profile.cv.move(this,'down');\">Move down</div>
						<div class='-item-sep'></div>
						<div class='-item red' onclick=\"Profile.cv.remove(this,'down');\">Xóa</div>
					</div>
				</div>";
				
				if (!$user->same(Client::$viewer)){
					$actions="";
				}
				
				foreach ($rows as $e){
					echo "<div class='item' data-id='{$e->id}' data-type='award'>
						<div class='name'>{$cv->display($e, 'name')} ({$cv->display($e, 'time')})</div>
						<div class='info'>{$cv->display($e, 'desc')}</div>
						{$actions}
					</div>";
				}
				
				if (!count($rows)){
					echo "<div class='item-none'>Không có thông tin.</div>";
				}
			?>
			
		</div>
	
	
	
		<div class='sep-20'></div>
		<div class='sep-20'></div>
		<div class='sep-20'></div>
	
	</div>
	
</div>