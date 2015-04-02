<?php
$this->breadcrumbs=array(
	$model->username,
);

$this->layout='//layouts/column2';

?>
<h1><?php echo $model->username ?></h1>
<p class="bid-detail-number narrow-bold-23">Профиль грузодателя</p>


<div class="clearfix">
	<div class="content column2r">
		<? include (dirname(dirname(__FILE__))."/common/gruzodatel-contact-info-container.php")?>


	</div>

	<div class="sidebar sideRight">
		<? include (dirname(dirname(__FILE__))."/common/gruzodatel-rating-reviews.php")?>

	</div>
</div>
