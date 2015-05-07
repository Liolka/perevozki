<div class="map-block border-box">
	<div class="container">
		<div class="row clearfix">
			<div class="col-md-12 col-lg-12 mb-25 info text_c c_fff">Любой груз в любую точку</div>
			
				<ul class="clearfix">
				<? foreach($categories_list_level1 as $cat) {	?>
				<?	
					if($user_type == 2) {
						$cat_url = $this->controller->createUrl('/bids/category', array('id'=>$cat['id']));
					}	else	{
						$cat_url = $this->controller->createUrl('/bids/createincat', array('id'=>$cat['id']));
					}
				?>
					<li class="col-md-2 col-lg-2">
						<a href="<?=$cat_url?>" class="main-page-cat-item db for_sprite text_c c_fff underline_n_n cat-g1-<?=$cat['id']?>">
							<span class="main-page-cat-item-name narrow-bold-18 c_fff"><?=$cat['name']?></span>
						</a>
					</li>
				<? } ?>
				</ul>
			</div>
		</div>

		<?/*
		<? if ($this->app->user->isGuest)	{	?>
			<a href="<?=$this->createUrl('/bids/create')?>" class="btn-green-66 btn-zakazhu m-0-15">Закажу перевозку</a>
			<a href="<?=$this->createUrl('/bids/index')?>" class="btn-blue-66 btn-perevezu m-0-15">Перевезу груз</a>
		<? }	elseif ($this->app->user->user_type == 1)	{	?>
			<a href="<?=$this->createUrl('/bids/create')?>" class="btn-green-66 btn-zakazhu m-0-15">Закажу перевозку</a>
		<? }	elseif ($this->app->user->user_type == 2)	{	?>
			<a href="<?=$this->createUrl('/bids/index')?>" class="btn-blue-66 btn-perevezu m-0-15">Перевезу груз</a>
		<?	}	?>
		*/?>
	</p>
</div>
