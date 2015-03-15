	<div class="step-container">
		<div class="container ">

			<p class="num-step num-step-green">2</p>
			<p class="step-title">Выберите одну или несколько подкатегорий</p>

			<div class="row">
				<ul class="clearfix">
				<? foreach($categories_list_level2 as $cat) {	?>
					<li class="col-md-3 col-lg-3 step2-list-item">
						<p class="step2-category-item">
							<input type="checkbox" name="category[]" onchange="change_step2_cat(this)" id="step2-category-item-<?=$cat['id']?>" class="checkbox step2-category-item-checkbox" value="<?=$cat['id']?>"><label for="step2-category-item-<?=$cat['id']?>" class="checkbox-lbl"><?=$cat['name']?></label>
						</p>
					</li>
				<? } ?>
				</ul>
			</div>

		</div>
	</div>
