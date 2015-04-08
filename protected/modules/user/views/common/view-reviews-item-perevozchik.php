<div class="mb-20">
	<div class="blue-border-1 bg_f4fbfe_h p-0-20 pos-rel clearfix">
		<div class="col1 fLeft font-12 text_c p-20-0"><?=$data->bid_id?></div>

		<div class="col21 fLeft font-12 border-box p-20-0 pl-35 cat-ico-s-<?=$data->category_id?>">
			<a class="" href="<?=$this->createUrl('/bids/view', array('id'=>$data->bid_id))?>"><?=$data->full_name?></a>
		</div>

		<? /* <div class="col3 fLeft p-20-0 font-13 text_c c_aab1ba"><?php echo $this->app->dateFormatter->format('dd.MM.yyyy', $data->date_transportation); ?></div> */?>

		<div class="col41 fLeft font-12 p-20-0 border-box perevozchik-cell">
			Перевозчик: <a class="profile-link" target="_blank" href="<?=$this->createUrl('/user/view', array('id'=>$data->performer_id))?>"><?php echo $data->performer_name; ?></a>
			<? if($data->performer_rating != 0)	{	?>
				<div class="clearfix mt-10 c_c3c8cd">
					<span class="db fLeft ">оставил оценку:</span>
					<div class="db fLeft m-0-5 rating-stars"><span class="stars-empty"></span><span class="stars-full-blue" style="width:<?=($data->performer_rating*10)?>%;"></span></div> 
					<span class="db fLeft c_1e91da bb-dotted-1-h pointer show-full-review">Читать отзыв</span>
				</div> 
			<?	}	else	{	?>			
				<p class="c_c3c8cd mt-5">Нет оценки</p>
			<?	}	?>
			
		</div>
		<div class="col51 fLeft font-12 p-20-0 border-box gruzodatel-cell">
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
		
		<div class="col61 fLeft border-box p-20-0">
			<div class="profile-requests-btns pos-rel width100">
				<? if($data->performer_review == '' && $data->performer_id == $this->app->user->id)	{	?>
					<button class="show-full-review btn-blue-33 pos-abs">Оставить отзыв</button>
				<?	}	elseif($data->performer_review != '' && $data->performer_id == $this->app->user->id)	{	?>
					<span class="comment-this-btn btn-grey-33 pos-abs">Вы оставили отзыв</span>
				<?	}	?>
			</div>

		</div>
		
		<?/*
		<? if($data->rating != '')	{	?>
		<div class="col5 fLeft">
			<div class="rating-stars"><span class="stars-empty"></span><span class="stars-full" style="width:78%;"></span></div> 
		</div>
		<?	}	else	{	?>
		<div class="col5 fLeft c_c3c8cd">
			Нет оценки
		</div>
		<?	}	?>
		
		
		<div class="col6 fLeft font-12">
			<a class="profile-link c_71a72c" target="_blank" href="<?=$this->createUrl('/user/view', array('id'=>$data->user_id))?>"><?php echo $data->username; ?></a>
		</div>

		<? if($data->review_text != '')	{	?>
			<div class="col7 fLeft font-12 border-box requests1-list-item-review requests1-list-item-review-good">
				<span><?=$data->review_text?></span>
			</div>
		<?	}	else	{	?>
			<div class="col7 fLeft font-12 border-box c_c3c8cd">Заказчик пока не оставил отзыв</div>
		<?	}	?>
		*/ ?>
	</div>
	
	<? //if(!($this->app->user->isGuest && $data->performer_review == '' && $data->user_review == '') )	{	?>
	<? if(($data->performer_review == '' && $data->performer_id == $this->app->user->id) || ($data->performer_review != '') || ($data->user_review != ''))	{	?>
	<div class="requests-full-review blue-border-1 ov-hidden hide-block1">
	
		<? if($data->performer_review == '' && $data->performer_id == $this->app->user->id)	{	?>
			<form method="post" class="clearfix p-20 bg_daf0fa">
				<input type="hidden" name="performer-id" value="<?=$this->app->user->id?>" />
				<input type="hidden" name="bid-id" value="<?=$data->bid_id?>" />
				<textarea name="review-text" id="review-form-<?=$data->bid_id?>" cols="30" rows="7" class="width100 mb-20"></textarea>
				<p class="fLeft font-12 mt-10">символов <span id="counter-<?=$data->bid_id?>"></span> / 400</p>
				<input type="submit" class="btn-blue-33 fRight" value="Разместить отзыв">
				
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

			</form>
		<?
		$this->app->clientScript->registerScript('Countable'.$data->bid_id, "
			$('#review-form-".$data->bid_id."').simplyCountable({
				counter: '#counter-".$data->bid_id."',
				maxCount: 400,
				strictMax: true
			});

		");
		?>


		<?	}	elseif($data->performer_review != '')	{	?>
			<div class="row">
				<div class="bg_f3fbff p-15 clearfix">
					<div class="col-lg-3 col-md-3 font-12">
						Перевозчик: <a class="profile-link" target="_blank" href="<?=$this->createUrl('/user/view', array('id'=>$data->performer_id))?>"><?php echo $data->performer_name; ?></a>
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
						Грузодатель: <a class="profile-link c_71a72c" target="_blank" href="<?=$this->createUrl('/user/view', array('id'=>$data->user_id))?>"><?php echo $data->username; ?></a>
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
