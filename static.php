<?php
	

	if (!mobile()){
		cssBase()
		->more(AP_CSS)
		->more("ap.css, master.css, reset.css")
		->ext(BASE_COMMON_CSS)
		->more("layout/layout.css, layout/header.css, layout/menu.css, layout/people.css, layout/orgchart.css, layout/profile.css, layout/guest.css, layout/2fa.css")
		->ext("message.base/layout.css")
		->release();
		
		
		jsBase()->more("cdn/ap.js")
		->ext(BASE_COMMON_JS)
		->more("a.js, reset.js, viewer.js, start.js, plugin/trumbowyg.min.js")
		->more("me/me.js, me/info.js")
		->more("admin/admin.js, admin/ms.js, admin/people.js, admin/network.js")
		->more("profile/profile.js, profile/cv.js")
		->more("network/network.js, network/type.js, network/member.js, network/role.js")
		->more("layout/layout.js, layout/bcanvas.js, layout/context.js")
			
		->ext("base.js, init.js","base_static")
		->ext("message/message.js, message.base/init.js")
		->ext("live/socket.io.js, live/live.js, live/init.js, live/online.js")
		->release();

	}else{
		cssBase("mobile")
		->more(AP_CSS)
		->more("reset.css, mobile/master.css")
		->ext(BASE_COMMON_CSS)
		->more("m/layout.css")
		->more("@reset/layout.css")
		->release();
		
		
		jsBase()
		->more("cdn/ap.js")
		->ext(BASE_COMMON_JS)
		->ext("mobile/m.js")
		->more("a.js, reset.js, viewer.js, start.js")
		->more("me/me.js, me/info.js")
		->more("admin/admin.js, admin/ms.js, admin/people.js, admin/network.js")
		->more("profile/profile.js, profile/cv.js")
		->more("network/network.js, network/type.js, network/member.js, network/role.js")
		->more("layout/layout.js, layout/bcanvas.js, layout/context.js")
			
		->ext("base.js, init.js","base_static")
		->ext("live/socket.io.js, live/live.js, live/init.js, live/online.js")
		->release();
	}

	
?>