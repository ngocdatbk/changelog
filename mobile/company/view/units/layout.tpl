{% view ~header.tpl}

<div id='body' class='with-header-footer'>
	<div id='subheader'>
		<div class='items'>
			<div class='item url' data-url='company'>
				Thành viên
			</div>
			
			<div class='item url active' data-xurl='company/units'>
				Đơn vị nghiệp vụ
			</div>
			
			
			<div class='item url' data-xurl='guests'>
				TK Khách
			</div>
			
		</div>
	</div>


	
	{% view ~units/units.tpl}

	
</div>


<script></script>