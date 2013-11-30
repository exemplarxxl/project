<?php
$this->breadcrumbs=array(
	'Альбомы'=>array('index'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'List Albums','url'=>array('index')),
	array('label'=>'Create Albums','url'=>array('create')),
	array('label'=>'View Albums','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Albums','url'=>array('admin')),
);
?>

<h3>Редактирование альбома "<?php echo $model->title; ?>"</h3>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>