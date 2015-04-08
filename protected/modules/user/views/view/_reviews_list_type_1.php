<? include (dirname(dirname(__FILE__))."/common/rating-init.php")?>
	
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_reviews_item_type_1',
	'ajaxUpdate'=>false,
	'template'=>"{items}",
	//'itemsCssClass' => 'blue-border-1 p-20 mb-10 bg_f4fbfe_h pos-rel clearfix',
	'itemsCssClass' => 'mb-10',
	'htmlOptions' => array('id'=>'requests1-list-items', 'class'=>'requests1-list-items',),
)); ?>

<a href="#" id="showMore" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Смотреть все</a>


<?/*
<div>
<input name="adv1" type="radio" class="auto-submit-star {split:2}" value="1"/>
<input name="adv1" type="radio" class="auto-submit-star {split:2}" value="2"/>
<input name="adv1" type="radio" class="auto-submit-star {split:2}" value="3"/>
<input name="adv1" type="radio" class="auto-submit-star {split:2}" value="4"/>
<input name="adv1" type="radio" class="auto-submit-star {split:2}" value="5"/>
<input name="adv1" type="radio" class="auto-submit-star {split:2}" value="6"/>
</div>
*/?>
