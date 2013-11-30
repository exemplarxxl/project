<?php
$this->pageTitle = 'Добавить альбом';
$this->breadcrumbs=array(
	'Альбомы'=>array('index'),
	'Добавить',
);

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>