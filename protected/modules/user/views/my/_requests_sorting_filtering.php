<ul class="requests-show-block mb-30 clearfix">
	<li class="requests-show-block-item fLeft <? if($filter == 'actual') echo 'active' ?>"><a href="<?=$this->createUrl('/user/my/requests', array('filter'=>'actual'))?>" class="requests-show-block-link" title="Только текущие" rel="nofollow">Только текущие</a></li>
	<li class="requests-show-block-item fLeft <? if($filter == 'all') echo 'active' ?>"><a href="<?=$this->createUrl('/user/my/requests', array('filter'=>'all'))?>" class="requests-show-block-link" title="Все" rel="nofollow">Все</a></li>
</ul>

<div class="my-requests-sort-block">
	<ul class="clearfix">
		<li>Сортировка:</li>
		<li class="sort-block-item sort-block-date <? if($order == 'date') echo 'active' ?>"><a href="<?=$this->createUrl('/user/my/requests', array('order'=>'date'))?>" rel="nofollow">По дате</a><? if($order == 'date') echo '<span class="sort-direction">▼</span>' ?></li>
		<li class="sort-block-item sort-block-requests <? if($order == 'reviews') echo 'active' ?>"><a href="<?=$this->createUrl('/user/my/requests', array('order'=>'reviews'))?>" rel="nofollow">По наличию отзывов</a><? if($order == 'reviews') echo '<span class="sort-direction">▼</span>' ?></li>
	</ul>
</div>
