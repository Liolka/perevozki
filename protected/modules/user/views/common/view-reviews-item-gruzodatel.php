<div class="mb-20">
	<div class="blue-border-1 bg_f4fbfe_h pos-rel">
	<div class="dt width100">
	<div class="dtr">
		<div class="col1 dtc font-12 text_c p-20-0"><?=$data->bid_id?></div>

		<div class="col21<? if($this->app->user->isGuest) echo '-g' ?> dtc font-12 border-box p-20-0 pl-35 cat-ico-s-<?=$data->category_id?>">
			<a class="lh-18" href="<?=$this->createUrl('/bids/view', array('id'=>$data->bid_id))?>"><?=$data->full_name?></a>
		</div>

		<? /* <div class="col3 fLeft p-20-0 font-13 text_c c_aab1ba"><?php echo $this->app->dateFormatter->format('dd.MM.yyyy', $data->date_transportation); ?></div> */?>

		<div class="col41<? if($this->app->user->isGuest) echo '-g' ?> dtc font-12 p-20-0 border-box perevozchik-cell">
			<? if($data->performer_id != 0)	{	?>
				<span class="dib profile-link">
					Перевозчик: <a class="pr-5" target="_blank" href="<?=$this->createUrl('/user/view', array('id'=>$data->performer_id))?>"><?php echo $data->performer_name; ?></a>
					<? if(isOnline($this->app, $data->performer_last_activity))	{	?>
						<span class="user-online c_fff bg_33a72c font-10 p-0-5">Online</span>
					<?	}	else	{	?>
						<span class="user-ofline c_fff bg_abbbcf font-10 p-0-5">Offline</span>
					<?	}	?>
				</span>
				
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
		<div class="col51<? if($this->app->user->isGuest) echo '-g' ?> dtc font-12 p-20-0 border-box gruzodatel-cell">
			<span class="dib profile-link">
				Грузодатель: <a class="c_71a72c pr-5" target="_blank" href="<?=$this->createUrl('/user/view', array('id'=>$data->user_id))?>"><?php echo $data->username; ?></a>
				<? if(isOnline($this->app, $data->last_activity))	{	?>
					<span class="user-online c_fff bg_33a72c font-10 p-0-5">Online</span>
				<?	}	else	{	?>
					<span class="user-ofline c_fff bg_abbbcf font-10 p-0-5">Offline</span>
				<?	}	?>
			</span>
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
		
		<? if(!$this->app->user->isGuest)	{	?>
		<div class="col61 dtc border-box p-20-0 pr-20">
		<? //print $data->user_id .'<br>'. $this->app->user->id ?>
			<div class="profile-requests-btns pos-rel width100">
				<? if(!$this->app->user->isGuest && $data->performer_id != 0 && $data->user_review == '' && $data->user_id == $this->app->user->id)	{	?>
					<button class="show-full-review btn-green-33 pos-abs">Оставить отзыв</button>
				<?	}	elseif(!$this->app->user->isGuest && $data->user_review != '' && $data->user_id == $this->app->user->id)	{	?>
					<span class="comment-this-btn btn-grey-33 pos-abs">Вы оставили отзыв</span>
				<?	}	?>
			</div>
		</div>
		<?	}	?>
	</div>
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
		<? if($data->user_review == '' && $data->user_id == $this->app->user->id)	{	?>
			<form action="<?=$this->createUrl('/site/addnewreview')?>" method="post" class="clearfix p-20 bg_daf0fa">
				<input type="hidden" name="u-id" value="<?=$this->app->user->id?>" />
				<input type="hidden" name="bid-id" value="<?=$data->bid_id?>" />
				<input type="hidden" name="rating-value" class="rating-value" value="" />
				<input type="hidden" name="fld" value="user" />
				<textarea name="review-text" id="review-form-<?=$data->bid_id?>" cols="30" rows="7" class="width100 mb-20"></textarea>
				<p class="fLeft font-12 mt-10">символов <span id="counter-<?=$data->bid_id?>"></span> / 400</p>
				<input type="submit" class="btn-send-review btn-green-33 fRight" value="Разместить отзыв">
				
				<div class="fRight p-0-20 clearfix requests-review-frm-rating">
					<span class="db fLeft italic font-12 p-0-20">Выберите количество звёзд:</span>
					<div class="stars-wr fLeft">
						<input name="RatingForm[rating]" type="radio" class="auto-submit-star {split:2}" value="1"/>
						<input name="RatingForm[rating]" type="radio" class="auto-submit-star {split:2}" value="2"/>
						<input name="RatingForm[rating]" type="radio" class="auto-submit-star {split:2}" value="3"/>
						<input name="RatingForm[rating]" type="radio" class="auto-submit-star {split:2}" value="4"/>
						<input name="RatingForm[rating]" type="radio" class="auto-submit-star {split:2}" value="5"/>
						<input name="RatingForm[rating]" type="radio" class="auto-submit-star {split:2}" value="6"/>
						<input name="RatingForm[rating]" type="radio" class="auto-submit-star {split:2}" value="7"/>
						<input name="RatingForm[rating]" type="radio" class="auto-submit-star {split:2}" value="8"/>
						<input name="RatingForm[rating]" type="radio" class="auto-submit-star {split:2}" value="9"/>
						<input name="RatingForm[rating]" type="radio" class="auto-submit-star {split:2}" value="10"/>
					</div>

				</div>
				<div id="review-err-<?=$data->bid_id?>" class="error fLeft font-12 mt-10 pl-35 italic c_eb4c4c"></div>
			</form>
			<script type="text/javascript">
			/*<![CDATA[*/
				(function($)
				{
					$('#review-form-<?=$data->bid_id ?>').simplyCountable({
						counter: '#counter-<?=$data->bid_id?>',
						maxCount: 400,
						strictMax: true
					});

				})(jQuery);
			/*]]>*/
			</script>
		<?	}	?>
		
		<p class="blue-border-top-1 p-15 narrow-regular-20 c_96a5b8"><span class="requests-full-review-hide bb-dotted-3-h pointer">Скрыть отзывы</span> ×</p>
	</div>
	<?	}	?>
</div>