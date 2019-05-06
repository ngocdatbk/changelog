<?php if (Client::$network && Client::$network->status==-1):?>
<div id='join'><div class='box'>
	<h1>This team is not accessible anymore.</h1>
</div></div>
<?php else: ?>

<div id='join'><div class='box'>
	<h1>You need to be a member of this team to view it.</h1>
	
	<?php if (Client::$network && Client::$network->type==Network::TYPE_PUBLIC):?>
	
	<div class='buttons -two xo' style='padding:20px 0 0px 0'>
		<div class='button -first -gradient -big -stroked -rounded' onclick="AP.redirect('home');">Go back home</div>
		<div class='button -second -success -big -stroked -rounded bold' onclick="Me.join('<?php echo Client::$network->hid();?>','<?php echo Client::$network->getSecuredToken();?>');">Join this team</div>
	</div>
	
	<?php endif;?>
	
</div></div>

<?php endif; ?>


<script>
	$("#pagew").addClass("live");
</script>