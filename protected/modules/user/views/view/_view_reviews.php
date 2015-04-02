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
	<div class="col7 fLeft font-12 border-box requests1-list-item-review c_c3c8cd">Заказчик пока не оставил отзыв</div>
<?	}	?>
