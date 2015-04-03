<script src="/js/jquery.rating.pack.js" type="text/javascript"></script>
<script src="/js/jquery.MetaData.js" type="text/javascript"></script>
<script>
$(function(){
 $('.auto-submit-star').rating({
  callback: function(value, link){
   // 'this' is the hidden form element holding the current value
   // 'value' is the value selected
   // 'element' points to the link element that received the click.
   alert("The value selected was '" + value + "'\n\nWith this callback function I can automatically submit the form with this code:\nthis.form.submit();");
   
   // To submit the form automatically:
   //this.form.submit();
   
   // To submit the form via ajax:
   //$(this.form).ajaxSubmit();
  }
 });
});
</script>
<link rel="stylesheet" href="/css/jquery.rating.css" type= "text/css" />
	
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_reviews_item_type_1',
	'ajaxUpdate'=>false,
	'template'=>"{items}",
	'itemsCssClass' => 'blue-border-1 p-20 mb-10 bg_f4fbfe_h clearfix',
	'htmlOptions' => array('id'=>'requests1-list-items', 'class'=>'requests1-list-items',),
)); ?>

<a href="#" id="showMore" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Показать еще</a>


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
