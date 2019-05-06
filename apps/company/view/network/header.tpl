<?php 
	$network=get("g");
?>


<script>
	$("#base-panel .item").setActiveURL("company/units");
	$("#menu .li").setActiveURL({url: "company/units"});
</script>


<div class="apptitle" id="mngheader">
	<?php if (\this\admin($network) || \this\sysowner()):?>
		<div class='actions'>
			<div class="action -icon" onclick="Network.invite();" title="Mời thêm thành viên"><span class='-ap icon-person_add'></span></div>
			<div class="action -icon" onclick="Network.editSelf();" title="Chỉnh sửa"><span class='-ap icon-mode_edit'></span></div>
			<div class="action -icon" onclick="Network.settings();" title="Tùy chọn"><span class='-ap icon-more_vert'></span></div>
		</div>
		
	<?php elseif ($network->isRoot()):?>
	<?php else: ?>
		<div class="cta -red" onclick="Network.leave();"><span class='-ap icon-highlight_off'></span> &nbsp; Leave this group</div>
	<?php endif;?>
	
	<div class='back' onclick="AP.back();">
		<div class='label'><?php if ($network->isRoot()): ?>The whole company <?php else: ?> User group<?php endif;?></div>
		<div class='title ap-xdot'><?php echo $network->name; ?></div>
	</div>
		
</div>