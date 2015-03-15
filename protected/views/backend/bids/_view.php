<?php
/* @var $this BidsController */
/* @var $data Bids */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('bid_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->bid_id), array('view', 'id'=>$data->bid_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('published')); ?>:</b>
	<?php echo CHtml::encode($data->published); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_transportation')); ?>:</b>
	<?php echo CHtml::encode($data->date_transportation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_transportation')); ?>:</b>
	<?php echo CHtml::encode($data->time_transportation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_unknown')); ?>:</b>
	<?php echo CHtml::encode($data->date_unknown); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('loading_town')); ?>:</b>
	<?php echo CHtml::encode($data->loading_town); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('loading_address')); ?>:</b>
	<?php echo CHtml::encode($data->loading_address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_loading_unloading_town_1')); ?>:</b>
	<?php echo CHtml::encode($data->add_loading_unloading_town_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_loading_unloading_address_1')); ?>:</b>
	<?php echo CHtml::encode($data->add_loading_unloading_address_1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_loading_unloading_town_2')); ?>:</b>
	<?php echo CHtml::encode($data->add_loading_unloading_town_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_loading_unloading_address_2')); ?>:</b>
	<?php echo CHtml::encode($data->add_loading_unloading_address_2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_loading_unloading_town_3')); ?>:</b>
	<?php echo CHtml::encode($data->add_loading_unloading_town_3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add_loading_unloading_address_3')); ?>:</b>
	<?php echo CHtml::encode($data->add_loading_unloading_address_3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unloading_town')); ?>:</b>
	<?php echo CHtml::encode($data->unloading_town); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unloading_address')); ?>:</b>
	<?php echo CHtml::encode($data->unloading_address); ?>
	<br />

	*/ ?>

</div>