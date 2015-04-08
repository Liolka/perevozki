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
					<span class="db fLeft c_1e91da bb-dotted-1-h pointer">Читать отзыв</span>
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
					<span class="db fLeft c_71a72c bb-dotted-2-h pointer">Читать отзыв</span>
				</div>
			<?	}	else	{	?>
				<p class="c_c3c8cd mt-5">Нет оценки</p>
			<?	}	?>
			
		</div>
		<? if($data->performer_review == '')	{	?>
			<div class="col61 fLeft border-box p-20-0">
				<div class="profile-requests-btns pos-rel width100">
					<button class="comment-this-btn btn-blue-33 pos-abs">Оставить отзыв</button>
				</div>

			</div>
		<?	}	?>
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
	
	<? if(!($this->app->user->isGuest && $data->performer_review == '' && $data->user_review == ''))	{	?>
	<div class="reviews-wr">
	
		<? if($data->performer_review == '' && $data->performer_id == $this->app->user->id)	{	?>
			<form method="post" class="profile-requests-comment-frm clear pos-rel width100 border-box blue-border-1 bg_daf0fa p-20 clearfix hide-block">
				<input type="hidden" name="performer-id" value="<?=$this->app->user->id?>" />
				<input type="hidden" name="bid-id" value="<?=$data->bid_id?>" />
				<textarea name="review-text" id="review-form-<?=$data->bid_id?>" cols="30" rows="7" class="width100 mb-20"></textarea>
				<p class="fLeft">Осталось символов: <span id="counter-<?=$data->bid_id?>"></span></p>
				<input type="submit" class="btn-green-33 fRight" value="Разместить отзыв">
				<div class="review-values fRight p-0-20">
					<span class="p-0-10">
						<input type="radio" name="review-value" id="review-value-good-<?=$data->bid_id?>" value="1" checked="checked" />
						<label for="review-value-good-<?=$data->bid_id?>" class="review-value-good">
							<img src="/images/rating-good.png" alt="good" class="pos-rel" />
						</label>
					</span>
					<span class="p-0-10">
						<input type="radio" name="review-value" id="review-value-bad-<?=$data->bid_id?>" value="-1" />
						<label for="review-value-bad-<?=$data->bid_id?>" class="review-value-bad">
							<img src="/images/rating-bad.png" alt="bad" class="pos-rel" />
						</label>
					</span>
				</div>

			</form>
		<?
		$this->app->clientScript->registerScript('loading1', "
			$('#review-form-".$data->bid_id."').simplyCountable({
				counter: '#counter-".$data->bid_id."',
				maxCount: 400,
			});

		");

		?>


		<?	}	else	{	?>
			<div class="profile-requests-comment-frm clear pos-rel width100 border-box blue-border-1 bg_daf0fa p-20 clearfix hide-block">
				<div class="font-12 lh-18 border-box item-review item-review-full">
					<span><?=$data->performer_review ?></span> <span class="review-text-switch-off bb-dotted-1 pointer">Скрыть</span>
				</div>

			</div>	
		<?	}	?>
	</div>
	<?	}	?>
</div>
