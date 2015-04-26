	<? if(isOnline($this->app, $model->last_activity))	{	?>
		<span class="user-online dib pos-rel c_fff bg_33a72c font-12 pl-5 pr-5 arial">Online</span>
	<?	}	else	{	?>
		<span class="user-ofline dib pos-rel c_fff bg_abbbcf font-12 pl-5 pr-5 arial">Offline</span>
	<?	}	?>	