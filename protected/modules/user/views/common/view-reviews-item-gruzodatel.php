<? $review_text_intro = ''; ?>
<div class="mb-20">
	<div class="blue-border-1 bg_f4fbfe_h p-20 pos-rel clearfix">
		<div class="col1 fLeft font-12 text_c"><?=$data->bid_id?></div>

		<div class="col2 fLeft font-12 border-box pl-35 cat-ico-s-<?=$data->category_id?>">
			<a class="" href="<?=$this->createUrl('/bids/view', array('id'=>$data->bid_id))?>"><?=$data->full_name?></a>
		</div>

		<div class="col3 fLeft font-13 text_c c_aab1ba"><?php echo $this->app->dateFormatter->format('dd.MM.yyyy', $data->date_transportation); ?></div>

		<div class="col4 fLeft font-12">
			<a class="profile-link" target="_blank" href="<?=$this->createUrl('/user/view', array('id'=>$data->performer_id))?>"><?php echo $data->performer_name; ?></a>
		</div>

		<? if($data->rating != '')	{	?>
			<div class="col5 fLeft">
				<div class="rating-stars"><span class="stars-empty"></span><span class="stars-full" style="width:78%;"></span></div> 
			</div>
		<?	}	elseif($data->rating == '' && $data->performer_id == $this->app->user->id)	{	?>
			<div class="col5 fLeft c_c3c8cd">
				<div class="profile-requests-btns pos-rel width100">
					<a href="#" class="rate-this-btn btn-blue-33 pos-abs">Оценить</a>
					<div class="stars-wr hide-block">
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
			</div>
		<?	}	else	{	?>
			<div class="col5 fLeft c_c3c8cd">Нет оценки</div>
		<?	}	?>
		
		<div class="col6 fLeft font-12">
			<a class="profile-link c_71a72c" target="_blank" href="<?=$this->createUrl('/user/view', array('id'=>$data->user_id))?>"><?php echo $data->username; ?></a>
		</div>

		<? if($data->review_text != '')	{	?>
			<?
				$maxchar = 50;
				
				if(strlen($data->review_text) > $maxchar)	{
					$words = explode(' ', $data->review_text);
					foreach ($words as $word)	{
						if (strlen($review_text_intro . ' ' . $word) < $maxchar)	{
							$review_text_intro .= ' '.$word; 
						} else	{
							$review_text_intro .= '';
							break;
						}
					}
				}	else	{
					
				}
				
			?>
			<div class="col7 fLeft font-12 border-box item-review <? if($data->review_value == -1) { echo "item-review-bad"; } else { echo "item-review-good"; } ?>">
				<? if($review_text_intro != '')	{	?>
					<span class="lh-18 pointer review-text-switch-on bb-dotted-1"><?=$review_text_intro.'...' ?></span>
				<?	}	else	{	?>
					<span class="lh-18"><?=$data->review_text ?></span>
				<?	}	?>
			</div>
		<?	}	elseif($data->review_text == '' && $data->user_id == $this->app->user->id)	{	?>
			<div class="col7 fLeft font-12 border-box c_c3c8cd">
				<div class="profile-requests-btns pos-rel width100">
					<button class="comment-this-btn btn-green-33 pos-abs">Оставить отзыв</button>
				</div>
			</div>
		<?	}	else	{	?>
			<div class="col7 fLeft font-12 border-box c_c3c8cd">Заказчик пока не оставил отзыв</div>
		<?	}	?>
	</div>

	<? if($data->review_text == '' && $data->user_id == $this->app->user->id)	{	?>
		<form method="post" class="profile-requests-comment-frm clear pos-rel width100 border-box blue-border-1 bg_daf0fa p-20 clearfix hide-block">
			<input type="hidden" name="performer-id" value="<?=$data->performer_id?>" />
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

	<?	}	elseif($review_text_intro != '')	{	?>
		<div class="profile-requests-comment-frm clear pos-rel width100 border-box blue-border-1 bg_daf0fa p-20 clearfix hide-block">
			<div class="font-12 lh-18 border-box item-review item-review-full <? if($data->review_value == -1) { echo "item-review-bad"; } else { echo "item-review-good"; } ?>">
				<span><?=$data->review_text ?></span> <span class="review-text-switch-off bb-dotted-1 pointer">Скрыть</span>
			</div>
			
		</div>
	<?	}	?>
</div>