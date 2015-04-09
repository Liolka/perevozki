<div class="mb-20">
	<div class="blue-border-1 bg_f4fbfe_h p-0-20 pos-rel clearfix">
		<div class="col1 fLeft font-12 text_c p-20-0"><?=$data->bid_id?></div>

		<div class="col21 fLeft font-12 border-box p-20-0 pl-35 cat-ico-s-<?=$data->category_id?>">
			<a class="" href="<?=$this->createUrl('/bids/view', array('id'=>$data->bid_id))?>"><?=$data->full_name?></a>
		</div>

		<div class="col41 fLeft font-12 p-20-0 border-box perevozchik-cell" style="width:34%;">
			<? if($data->performer_id != 0)	{	?>
				Перевозчик: <a class="profile-link " target="_blank" href="<?=$this->createUrl('/user/view', array('id'=>$data->performer_id))?>"><?php echo $data->performer_name; ?></a>
				<? if($data->performer_rating != 0)	{	?>
					<div class="clearfix mt-10 c_c3c8cd">
						<span class="db fLeft ">оставил оценку:</span>
						<div class="db fLeft m-0-5 rating-stars"><span class="stars-empty"></span><span class="stars-full-blue" style="width:<?=($data->performer_rating*10)?>%;"></span></div> 
						<span class="db fLeft c_1e91da bb-dotted-1-h pointer show-full-review">Читать отзыв</span>
					</div> 
				<?	}	else	{	?>
					<p class="c_c3c8cd mt-5">Нет оценки</p>
				<?	}	?>
			<?	}	else	{	?>
				<p class="c_c3c8cd mt-5">Перевозчик еще не выбран</p>
			<?	}	?>
			
		</div>
		<div class="col51 fLeft font-12 p-20-0 border-box gruzodatel-cell" style="width:34%;border-right:none;">
			Грузодатель: <a class="profile-link c_71a72c" target="_blank" href="<?=$this->createUrl('/user/view', array('id'=>$data->user_id))?>"><?php echo $data->username; ?></a>
			<? if($data->user_rating != 0)	{	?>
				<div class="clearfix mt-10 c_c3c8cd">
					<span class="db fLeft ">оставил оценку:</span>
					<div class="db fLeft m-0-5 rating-stars"><span class="stars-empty"></span><span class="stars-full" style="width:<?=($data->user_rating*10)?>%;"></span></div>
					<span class="db fLeft c_71a72c bb-dotted-2-h pointer show-full-review">Читать отзыв</span>
				</div>
			<?	}	else	{	?>
				<p class="c_c3c8cd mt-5">Нет оценки</p>
			<?	}	?>
			
		</div>
	</div>
	
	<? //if(!($this->app->user->isGuest && $data->performer_review == '' && $data->user_review == '') )	{	?>
	<? if(($data->user_review == '' && $data->user_id == $this->app->user->id) || ($data->performer_review != '') || ($data->user_review != ''))	{	?>
	<div class="requests-full-review blue-border-1 ov-hidden hide-block">
	
		<?	if($data->performer_review != '')	{	?>
			<div class="row">
				<div class="bg_f3fbff p-15 clearfix">
					<div class="col-lg-3 col-md-3 font-12">
						Перевозчик: <a class="profile-link" target="_blank" href="<?=$this->createUrl('/user/view', array('id'=>$data->user_id))?>"><?php echo $data->username; ?></a>						
						<div class="clearfix mt-10 c_c3c8cd">
							<span class="db fLeft ">оставил оценку:</span>
							<div class="db fLeft m-0-5 rating-stars"><span class="stars-empty"></span><span class="stars-full-blue" style="width:<?=($data->performer_rating*10)?>%;"></span></div>
						</div>
					</div>

					<div class="col-lg-9 col-md-9 font-12 lh-18">
						<span><?=$data->performer_review ?></span>
					</div>
				</div>	
			</div>	
		<?	}	?>
		<?	if($data->user_review != '')	{	?>
			<div class="row">
				<div class="bg_f3fbff blue-border-top-1 p-15 clearfix">
					<div class="col-lg-3 col-md-3 font-12">
						Грузодатель: <a class="profile-link c_71a72c" target="_blank" href="<?=$this->createUrl('/user/view', array('id'=>$data->performer_id))?>"><?php echo $data->performer_name; ?></a>
						<div class="clearfix mt-10 c_c3c8cd">
							<span class="db fLeft ">оставил оценку:</span>
							<div class="db fLeft m-0-5 rating-stars"><span class="stars-empty"></span><span class="stars-full" style="width:<?=($data->user_rating*10)?>%;"></span></div>
						</div>
					</div>

					<div class="col-lg-9 col-md-9 font-12 lh-18">
						<span><?=$data->user_review ?></span> 
					</div>
				</div>	
			</div>	
		
		<?	}	?>
		
		<p class="blue-border-top-1 p-15 narrow-regular-20 c_96a5b8"><span class="requests-full-review-hide bb-dotted-3-h pointer">Скрыть отзывы</span> ×</p>
	</div>
	<?	}	?>
</div>